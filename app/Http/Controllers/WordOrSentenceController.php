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
        $itemsPerPage = 100;

        // Get filter parameters from the request
        $search = $request->post('search'); // For filtering by name
        $tagIds = $request->post('tags', []); // For filtering by tag

        // Build the query
        $query = WordOrSentence::with(['user', 'tags', 'comments.user'])
            ->orderBy('id', 'desc');

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

        // Paginate results
        $words = $query->paginate($itemsPerPage);
        $tags = Tag::select('id', 'name')
            ->orderBy('id', 'desc')
            ->take(500)
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

        // Return response
        return redirect()->route('word.index')
            ->with('success', 'The new word was added.');
    }

    public function update(Request $request, WordOrSentence $wordOrSentence)
    {
        // Validate the incoming request
        $request->validate([
            'word_or_sentence' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'regenerate' => 'nullable|boolean',
            'comments' => 'nullable|array',
            'comments.*.id' => 'nullable',
            'comments.*.comment' => 'nullable|string|max:1000',
        ]);

        // Get user input
        $wordOrSentenceInput = $request->input('word_or_sentence');

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
        if (isset($about) && $about) {
            $updatePayload['about'] = $about;
        }
        $wordOrSentence->update($updatePayload);

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

    public function destroy(WordOrSentence $wordOrSentence)
    {
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
        return Inertia::render('Words/WordForm', [
            'mode' => 'add'
        ]);
    }

    public function formPage(WordOrSentence $word = null, string $mode = null)
    {
        return Inertia::render('Words/WordForm', [
            'word' => $word,
            'comments' => $word->comments,
            'mode' => $mode
        ]);
    }

    public function addComment(Request $request, WordOrSentence $wordOrSentence)
    {
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
