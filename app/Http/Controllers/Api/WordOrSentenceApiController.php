<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AiHelper;
use App\Helpers\AiPromptsHelper;
use App\Http\Controllers\Controller;
use App\Models\WordOrSentence;
use App\Services\ImageUploadService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WordOrSentenceApiController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService) {
        $this->imageUploadService = $imageUploadService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 10); // Allow dynamic pagination size
        $words = WordOrSentence::orderBy('word_or_sentence', 'asc')
            ->paginate(10);
        return response()->json($words);
    }

    /**
     * Store a newly created resource in storage.
     */
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

        // Check if the word or sentence already exists
        if (WordOrSentence::where('word_or_sentence', $wordOrSentenceInput)->exists()) {
            return response()->json(['error' => 'The word or sentence already exists.'], 409); // 409 Conflict
        }

        // Call AI for generating the 'about' text
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
        try {
            // Save the new word or sentence
            $new_word->save();

            // Attach tags if provided
            if ($request->has('tags')) {
                $new_word->tags()->attach($request->input('tags'));
            }

            // Return success response
            return response()->json(['message' => 'The new word was added.'], 201);
        } catch (QueryException $e) {
            // Handle other exceptions
            return response()->json(['error' => 'An error occurred. Please try again later.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $wordOrSentence = WordOrSentence::find($id); // 404 if not found
        if (!$wordOrSentence) {
            return response()->json(null, 404);
        }

        return response()->json($wordOrSentence);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {

    }

    public function search(Request $request)
    {
        // Validate incoming request for the search term
        $request->validate([
            'q' => 'required|string|max:255',
        ]);

        // Get the search query and trim whitespace
        $searchQuery = trim($request->input('q'));

        // Perform a search query with a limit of 10 results
        $words = WordOrSentence::select(['word_or_sentence', 'about', 'definition'])
            ->where('word_or_sentence', 'like', '%' . $searchQuery . '%')
            ->orderBy('word_or_sentence', 'asc')
            ->limit(10)
            ->get();

        // Return the search results as JSON
        return response()->json($words);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Validate word or sentence data for storing/updating.
     */
    private function validateWordOrSentence(Request $request): array
    {
        return $request->validate([
            'word_or_sentence' => 'required|string|unique:word_or_sentences,word_or_sentence|max:255',
            'about' => 'nullable|string',
            'image_path' => 'nullable|string',
            'image_url' => 'nullable|string',
        ]);
    }
}
