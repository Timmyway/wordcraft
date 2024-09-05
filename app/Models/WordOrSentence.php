<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordOrSentence extends Model
{
    use HasFactory;

    protected $fillable = [
        'word_or_sentence',
        'definition',
        'example',
        'synonyms',
        'antonyms',
        'image_path',
        'image_url',
        'pronunciation',
        'type_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_word_or_sentence');
    }
}
