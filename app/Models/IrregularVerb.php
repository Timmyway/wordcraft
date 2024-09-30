<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IrregularVerb extends Model
{
    use HasFactory;

    protected $fillable = ['verb', 'past_simple', 'past_participle'];
}
