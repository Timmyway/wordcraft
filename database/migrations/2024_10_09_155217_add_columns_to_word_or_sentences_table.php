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
        Schema::table('word_or_sentences', function (Blueprint $table) {
            $table->string('pos')->nullable();
            $table->text('def')->nullable();
            $table->integer('count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('word_or_sentences', function (Blueprint $table) {
            $table->dropColumn(['pos', 'def', 'count']);
        });
    }
};
