<?php

namespace App\Http\Controllers;

use App\Helpers\AiHelper;
use App\Helpers\AiPromptsHelper;
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

    public function list()
    {
        $itemsPerPage = 100;

        $words = WordOrSentence::with(['user'])
            ->orderBy('id', 'desc')
            ->paginate($itemsPerPage);

        return Inertia::render('Words/WordList', [
            'words' => $words
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
        return redirect()->route('word.list')
            ->with('success', 'The new word was added.');
    }

    public function update(Request $request, WordOrSentence $wordOrSentence)
    {
        // Validate the incoming request
        $request->validate([
            'word_or_sentence' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Get user input
        $wordOrSentenceInput = $request->input('word_or_sentence');

        // Call AI for updated information
        $about = AiHelper::askToAi(AiPromptsHelper::generateAboutPrompt($wordOrSentenceInput));

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
        $wordOrSentence->update([
            'word_or_sentence' => $wordOrSentenceInput,
            'about' => $about,
            'synonyms' => $synonyms,
            'antonyms' => $antonyms,
            'image_path' => $imagePath,
            'image_url' => $imageUrl,
        ]);

        // Return response
        return response()->json($wordOrSentence, 200);
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
            'mode' => $mode
        ]);
    }
}
