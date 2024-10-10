<?php

namespace App\Http\Controllers;

use App\Helpers\AiHelper;
use App\Helpers\AiPromptsHelper;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\WordOrSentence;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WordOrSentenceController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    public function indexPage(Request $request)
    {
        // Get filter parameters from the request
        $search = $request->post('search'); // For filtering by name
        $tagIds = $request->post('tags', []); // For filtering by tag
        $listMode = $request->input('listMode', 'normal'); // New parameter to check if words should be shuffled
        $letter = $request->input('letter');
        $itemsPerPage = min($request->input('perPage', 25), 100);

        // Build the query
        $query = WordOrSentence::with(['user', 'tags', 'comments.user']);

        // Apply letter filter if present
        if ($letter) {
            $query->where('word_or_sentence', 'like', "$letter%");
        }

        // Apply filters if present
        if ($search) {
            $query->where('word_or_sentence', 'like', "%$search%");
        }

        // Apply tag filtering if tag IDs are present
        if (!empty($tagIds)) {
            $query->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('tags.id', $tagIds);
            }, '=', count($tagIds)); // Ensure all selected tags are present
        }

        // Shuffle words if requested
        if ($listMode === 'shuffle') {
            $query->inRandomOrder();
        } else {
            $query->orderBy('count', 'desc');
        }

        // Paginate results
        $words = $query->paginate($itemsPerPage);
        $tags = Tag::select('id', 'name')
            ->orderBy('name', 'asc')
            ->take(100)
            ->get();

        // Pass filter parameters to the view
        return Inertia::render('Words/WordList', [
            'words' => $words,
            'tags' => $tags,
        ]);
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'word_or_sentence' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'tags' => 'nullable|array', // Add validation for tags
            'tags.*' => 'exists:tags,id', // Ensure each tag ID exists
        ]);

        // Get user input
        $wordOrSentenceInput = $request->input('word_or_sentence');

        // Call AI for each required piece of information
        $about = AiHelper::askToAi(AiPromptsHelper::generateAboutPrompt($wordOrSentenceInput));

        // Upload image if provided
        $imagePath = null;
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $uploadData = $this->imageUploadService->upload($request->file('image'));
            $imagePath = $uploadData['image_path'];
            $imageUrl = $uploadData['image_url'];
        }

        // Create a new WordOrSentence instance and assign it to the logged-in user
        $new_word = new WordOrSentence();
        $new_word->word_or_sentence = $wordOrSentenceInput;
        $new_word->about = $about;
        $new_word->image_path = $imagePath;
        $new_word->image_url = $imageUrl;

        $new_word->user()->associate(auth()->user());
        $new_word->save();

        // Attach tags if provided
        if ($request->has('tags')) {
            $new_word->tags()->attach($request->input('tags'));
        }

        // Return response
        return redirect()->route('word.index')
            ->with('success', 'The new word was added.');
    }

    public function update(Request $request, WordOrSentence $wordOrSentence)
    {
        if ($request->user()->cannot('updateWord', $wordOrSentence)) {
            abort(403);
        }
        // Validate the incoming request
        $request->validate([
            'word_or_sentence' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'regenerate' => 'nullable|boolean',
            'comments' => 'nullable|array',
            'comments.*.id' => 'nullable',
            'comments.*.comment' => 'nullable|string|max:1000',
            'tags' => 'nullable|array', // Validate tags input
            'tags.*' => 'exists:tags,id', // Ensure each tag exists in the tags table
        ]);

        // Get user input
        $wordOrSentenceInput = $request->input('word_or_sentence');

        $about = null;
        if ($request->input('regenerate')) {
            // Call AI for updated information
            $about = AiHelper::askToAi(AiPromptsHelper::generateAboutPrompt($wordOrSentenceInput));
        }

        // Check for new image and upload if provided
        $imagePath = $wordOrSentence->image_path;
        $imageUrl = $wordOrSentence->image_url;
        if ($request->hasFile('image')) {
            // Optionally delete the old image if necessary
            if ($wordOrSentence->image_path) {
                $this->imageUploadService->delete($wordOrSentence->image_path);
            }

            // Upload new image
            $uploadData = $this->imageUploadService->upload($request->file('image'));
            $imagePath = $uploadData['image_path'];
            $imageUrl = $uploadData['image_url'];
        }

        // Update the WordOrSentence model
        $updatePayload = [
            'word_or_sentence' => $wordOrSentenceInput,
            'image_path' => $imagePath,
            'image_url' => $imageUrl,
        ];
        if ($about) {
            $updatePayload['about'] = $about;
        }
        $wordOrSentence->update($updatePayload);

        // Sync tags
        if ($request->has('tags')) {
            $wordOrSentence->tags()->sync($request->input('tags'));
        }

        // Update or create comments
        if ($request->has('comments')) {
            // Detach all existing comments for this word or sentence
            $wordOrSentence->comments()->delete();

            foreach ($request->input('comments') as $commentData) {
                Comment::create([
                    'comment' => $commentData['comment'],
                    'word_or_sentence_id' => $wordOrSentence->id,
                    'user_id' => auth()->id(),
                ]);
            }
        }

        // Return response
        return redirect()->route('word.index')
            ->with('success', 'The new word was added.');
    }

    public function destroy(Request $request, WordOrSentence $wordOrSentence)
    {
        if ($request->user()->cannot('updateWord', $wordOrSentence)) {
            abort(403);
        }
        // Optionally delete the associated image if it exists
        if ($wordOrSentence->image_path) {
            $this->imageUploadService->delete($wordOrSentence->image_path);
        }

        // Delete the WordOrSentence instance
        $wordOrSentence->delete();

        // Return a success response
        return response()->json(['message' => 'Word or sentence deleted successfully.'], 200);
    }

    public function addPage(WordOrSentence $wordOrSentence)
    {
        $tags = Tag::select('id', 'name')
            ->orderBy('name', 'asc')
            ->take(100)
            ->get();

        return Inertia::render('Words/WordForm', [
            'mode' => 'add',
            'tags' => $tags
        ]);
    }

    public function formPage(Request $request, WordOrSentence $word = null, string $mode = null)
    {
        if ($request->user()->cannot('modify', $word)) {
            abort(403);
        }
        $tags = Tag::select('id', 'name')
            ->orderBy('name', 'asc')
            ->take(100)
            ->get();

        // Format wordTags to match the tags structure
        $wordTags = $word ? $word->tags->map(function ($tag) {
            return ['id' => $tag->id, 'name' => $tag->name];
        })->toArray() : [];

        return Inertia::render('Words/WordForm', [
            'word' => $word,
            'wordTags' => $wordTags,
            'comments' => $word ? $word->comments : [],
            'mode' => $mode,
            'tags' => $tags,
        ]);
    }

    public function addComment(Request $request, WordOrSentence $wordOrSentence)
    {
        if ($request->user()->cannot('updateWord', $wordOrSentence)) {
            abort(403);
        }
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        Comment::create([
            'comment' => $request->comment,
            'word_or_sentence_id' => $wordOrSentence->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
