<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PlaylistController extends Controller
{
    // List all playlists of the authenticated user
    public function index()
    {
        $playlists = Auth::user()->playlists()->with('wordsOrSentences')->get();
        return response()->json($playlists);
    }

    public function indexPage(Request $request)
    {
        $itemsPerPage = 100;

        // Build the query
        $playlists = Playlist::orderBy('id', 'desc')
            ->paginate($itemsPerPage);

        // Pass filter parameters to the view
        return Inertia::render('Playlists/Playlist', ['playlists' => $playlists]);
    }

    public function addPage(Request $request)
    {
        if ($request->user()->cannot('create', Playlist::class)) {
            abort(403);
        }
        return Inertia::render('Playlists/PlaylistForm', [
            'mode' => 'add'
        ]);
    }

    public function formPage(Request $request, Playlist $playlist = null, string $mode = null)
    {
        if ($request->user()->cannot('update', $playlist)) {
            abort(403);
        }
        return Inertia::render('Playlists/PlaylistForm', [
            'playlist' => $playlist,
            'mode' => $mode
        ]);
    }

    public function explorePage(Request $request, Playlist $playlist = null)
    {
        if ($request->user()->cannot('view', $playlist)) {
            abort(403);
        }

        // Eager load word_or_sentences relationship
        $playlistToPreview = Playlist::with('wordsOrSentences')->find($playlist->id);

        return Inertia::render('Playlists/PlaylistExplore', [
            'playlist' => $playlistToPreview,
        ]);
    }

    // Create a new playlist
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'words_or_sentences' => 'nullable|array',
            'words_or_sentences.*' => 'exists:word_or_sentences,id',
        ]);

        $playlist = Auth::user()->playlists()->create([
            'name' => $request->name,
        ]);

        // Sync the word_or_sentences if provided
        if ($request->filled('words_or_sentences')) {
            $playlist->wordsOrSentences()->sync($request->words_or_sentences);
        }

        return response()->json($playlist, 201);
    }

    // Display a specific playlist
    public function show($playlistId)
    {
        $playlist = Auth::user()->playlists()->with('wordsOrSentences')->findOrFail($playlistId);

        return response()->json($playlist, 200);
    }

    public function update(Request $request, $playlistId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'words_or_sentences' => 'nullable|array',
            'words_or_sentences.*' => 'exists:word_or_sentences,id',
        ]);

        $playlist = Auth::user()->playlists()->findOrFail($playlistId);

        // Update the playlist's name
        $playlist->update([
            'name' => $request->name,
        ]);

        // Sync the word_or_sentences if provided
        if ($request->filled('words_or_sentences')) {
            $playlist->wordsOrSentences()->sync($request->words_or_sentences);
        }

        return response()->json($playlist, 200);
    }

    public function destroy($playlistId)
    {
        $playlist = Auth::user()->playlists()->findOrFail($playlistId);
        $playlist->delete();

        return response()->json(['message' => 'Playlist deleted.'], 200);
    }

    /**
     * Add multiple words or sentences to a playlist
     */
    public function addToPlaylist(Request $request, Playlist $playlist)
    {
        $request->validate([
            'words_or_sentences' => 'required|array',
            'words_or_sentences.*' => 'exists:word_or_sentences,id'
        ]);

        // Add multiple words or sentences without detaching existing ones
        $playlist->wordsOrSentences()->syncWithoutDetaching($request->words_or_sentences);

        return response()->json(['message' => 'Words or sentences added to playlist successfully'], 200);
    }

    /**
     * Remove multiple words or sentences from a playlist
     */
    public function removeFromPlaylist(Request $request, Playlist $playlist)
    {
        $request->validate([
            'words_or_sentences' => 'required|array',
            'words_or_sentences.*' => 'exists:word_or_sentences,id'
        ]);

        // Remove the given words or sentences from the playlist
        $playlist->wordsOrSentences()->detach($request->words_or_sentences);

        return response()->json(['message' => 'Words or sentences removed from playlist successfully'], 200);
    }

    /**
     * Clear all words or sentences from a playlist
     */
    public function clearPlaylist(Playlist $playlist)
    {
        dd('=====> Delete all');
        // Detach all words or sentences from the playlist
        $playlist->wordsOrSentences()->detach();

        return response()->json(['message' => 'All words or sentences cleared from playlist successfully'], 200);
    }

}
