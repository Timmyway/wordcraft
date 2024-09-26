<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\WordOrSentence;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TagController extends Controller
{
    public function indexPage(Request $request)
    {
        // if ($request->user()->cannot('viewAny')) {
        //     abort(403);
        // }

        $itemsPerPage = 100;

        // Get filter parameters from the request
        $search = $request->post('search'); // For filtering by name

        // Build the query
        $query = Tag::orderBy('id', 'desc');

        // Apply filters if present
        if ($search) {
            $query->where('name', 'like', "%$search%");
        }

        // Paginate results
        $tags = $query->paginate($itemsPerPage);

        // Pass filter parameters to the view
        return Inertia::render('Tags/TagList', [
            'tags' => $tags,
        ]);
    }

    public function addPage(Request $request)
    {
        if ($request->user()->cannot('modify', Tag::class)) {
            abort(403);
        }
        return Inertia::render('Tags/TagForm', [
            'mode' => 'add'
        ]);
    }

    public function formPage(Request $request, Tag $tag = null, string $mode = null)
    {
        if ($request->user()->cannot(['create', 'update'], $tag)) {
            abort(403);
        }
        return Inertia::render('Tags/TagForm', [
            'tag' => $tag,
            'mode' => $mode
        ]);
    }

    public function store(Request $request)
    {
        if ($request->user()->cannot(['create'], Tag::class)) {
            abort(403);
        }
        // Validate incoming request
        $validated = $request->validate([
            'tags' => ['required', 'array'],
            'tags.*' => ['required', 'string', 'max:50'],
        ]);

        // Get user input
        $tags = $validated['tags'];
        $addedTags = []; // Initialize an array to collect added/updated tags

        DB::transaction(function () use ($tags, &$addedTags) {
            foreach ($tags as $tagName) {
                try {
                    // Use updateOrCreate to handle insert or update in a single query
                    $tag = Tag::updateOrCreate(
                        ['name' => $tagName], // Matching criteria (unique field)
                        ['name' => $tagName]  // Fields to update or insert
                    );

                    // Add the successfully added/updated tag to the array
                    $addedTags[] = $tag;

                } catch (\Exception $e) {
                    // Log or handle the error (optional)
                    // Log::error('Failed to insert or update tag: ' . $tagName);
                    continue; // Continue with the next tag even if there's an error
                }
            }
        });

        // Return response with the list of added/updated tags
        // Return response with the list of added/updated tags
        $message = count($addedTags) > 0
            ? 'Added tags: ' . implode(', ', array_column($addedTags, 'name'))
            : 'No new tags were added or updated.';
        return redirect()->route('tag.index')
            ->with('success', $message)
            ->with('addedTags', $addedTags);
    }

    public function update(Request $request, Tag $tag)
    {
        if ($request->user()->cannot('update', $tag)) {
            abort(403);
        }
        // Validate incoming request
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'], // Ensure a valid tag name
        ]);

        // Update the tag within a transaction
        DB::transaction(function () use ($tag, $validated) {
            try {
                // Update the tag's name
                $tag->update(['name' => $validated['name']]);
            } catch (\Exception $e) {
                // Log or handle the error (optional)
                // Log::error('Failed to update tag: ' . $tag->name);
                throw $e; // Rethrow the exception to handle it outside if needed
            }
        });

        // Return response with the updated tag
        return redirect()->route('tag.index')
            ->with('success', 'Tag updated successfully: ' . $tag->name)
            ->with('updatedTag', $tag);
    }

    public function destroy(Request $request, Tag $tag)
    {
        if ($request->user()->cannot('delete', $tag)) {
            abort(403);
        }
        // Use a transaction to ensure atomicity
        DB::transaction(function () use ($tag) {
            // Detach the tag from its associated words/sentences
            $tag->wordOrSentences()->detach();

            // Now delete the tag
            $tag->delete();
        });

        // Return response
        return redirect()->route('tag.index')
            ->with('success', 'Tag deleted successfully: ' . $tag->name);
    }


    public function search(Request $request): JsonResponse
    {
        $search = $request->input('search');

        // Validate the search input
        $request->validate([
            'search' => 'required|string|max:255',
        ]);

        $tags = Tag::where('name', 'like', "%{$search}%")
            ->orderBy('name', 'asc')
            ->limit(25)
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

        // Authorize the action using the TagPolicy
        if ($request->user()->cannot('addTagToWord', $word)) {
            abort(403, 'Unauthorized to modify this word.');
        }

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

        // Authorize the action using the TagPolicy
        if ($request->user()->cannot('removeTagFromWord', $word)) {
            abort(403, 'Unauthorized to modify this word.');
        }

        // Detach the tags from the word
        $word->tags()->detach($data['tagsId']);

        return response()->json([
            'message' => 'Tags successfully removed from the word.',
            'word' => $word->load('tags'),  // Load the tags relationship
        ], 200);
    }
}
