<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\WordOrSentence;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $search = $request->input('search');

        // Validate the search input
        $request->validate([
            'search' => 'required|string|max:255',
        ]);

        $tags = Tag::where('name', 'like', "%{$search}%")
            ->limit(10)
            ->get();
        return response()->json($tags);
    }

    /**
     * Add tags to a word or sentence.
     */
    public function addToWord(Request $request): JsonResponse
    {
        // Validate the request data
        $data = $request->validate([
            'wordId' => 'required|integer|exists:word_or_sentences,id',
            'tagsId' => 'required|array',
            'tagsId.*' => 'integer|exists:tags,id',
        ]);

        // Find the word
        $word = WordOrSentence::findOrFail($data['wordId']);

        // Attach the tags to the word (many-to-many relationship)
        $word->tags()->syncWithoutDetaching($data['tagsId']);

        return response()->json([
            'message' => 'Tags successfully added to the word.',
            'word' => $word->load('tags'),  // Load the tags relationship
        ], 200);
    }

    /**
     * Remove tags from a word or sentence.
     */
    public function removeFromWord(Request $request): JsonResponse
    {
        // Validate the request data
        $data = $request->validate([
            'wordId' => 'required|integer|exists:word_or_sentences,id',
            'tagsId' => 'required|array',
            'tagsId.*' => 'integer|exists:tags,id',
        ]);

        // Find the word
        $word = WordOrSentence::findOrFail($data['wordId']);

        // Detach the tags from the word
        $word->tags()->detach($data['tagsId']);

        return response()->json([
            'message' => 'Tags successfully removed from the word.',
            'word' => $word->load('tags'),  // Load the tags relationship
        ], 200);
    }
}
