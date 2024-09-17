<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordOrSentence extends Model
{
    use HasFactory;

    protected $table = 'word_or_sentences';

    protected $fillable = [
        'word_or_sentence',
        'about',
        'image_path',
        'image_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_word_or_sentence');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
