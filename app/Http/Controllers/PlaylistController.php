<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    // List all playlists of the authenticated user
    public function index()
    {
        $playlists = Auth::user()->playlists()->with('wordsOrSentences')->get();
        return response()->json($playlists);
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


}
