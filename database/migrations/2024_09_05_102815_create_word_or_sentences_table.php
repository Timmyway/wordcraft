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
        Schema::create('word_or_sentences', function (Blueprint $table) {
            $table->id();
            $table->string('word_or_sentence')->unique();
            $table->text('about')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_url')->nullable();

            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Assign word_or_sentence to user
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_or_sentences');
    }
};
