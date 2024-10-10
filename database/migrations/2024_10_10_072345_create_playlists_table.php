<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('playlists', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Playlist name
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User who created the playlist
            $table->timestamps();
        });

        Schema::create('playlist_word_or_sentence', function (Blueprint $table) {
            $table->id();
            $table->foreignId('playlist_id')->constrained()->onDelete('cascade'); // Reference to playlist
            $table->foreignId('word_or_sentence_id')->constrained()->onDelete('cascade'); // Reference to word/sentence
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_word_or_sentence');
        Schema::dropIfExists('playlists');
    }
};
