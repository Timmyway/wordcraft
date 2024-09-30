<?php

namespace Database\Seeders;

use App\Models\IrregularVerb;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IrregularVerbsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IrregularVerb::insert([
            ['verb' => 'be', 'past_simple' => 'was/were', 'past_participle' => 'been'],
            ['verb' => 'begin', 'past_simple' => 'began', 'past_participle' => 'begun'],
            ['verb' => 'choose', 'past_simple' => 'chose', 'past_participle' => 'chosen'],
            ['verb' => 'come', 'past_simple' => 'came', 'past_participle' => 'come'],
            ['verb' => 'do', 'past_simple' => 'did', 'past_participle' => 'done'],
            ['verb' => 'drink', 'past_simple' => 'drank', 'past_participle' => 'drunk'],
            ['verb' => 'eat', 'past_simple' => 'ate', 'past_participle' => 'eaten'],
            ['verb' => 'fall', 'past_simple' => 'fell', 'past_participle' => 'fallen'],
            ['verb' => 'find', 'past_simple' => 'found', 'past_participle' => 'found'],
            ['verb' => 'fly', 'past_simple' => 'flew', 'past_participle' => 'flown'],
            ['verb' => 'forget', 'past_simple' => 'forgot', 'past_participle' => 'forgotten'],
            ['verb' => 'get', 'past_simple' => 'got', 'past_participle' => 'gotten/got'],
            ['verb' => 'give', 'past_simple' => 'gave', 'past_participle' => 'given'],
            ['verb' => 'go', 'past_simple' => 'went', 'past_participle' => 'gone'],
            ['verb' => 'know', 'past_simple' => 'knew', 'past_participle' => 'known'],
            ['verb' => 'lie', 'past_simple' => 'lay', 'past_participle' => 'lain'],
            ['verb' => 'see', 'past_simple' => 'saw', 'past_participle' => 'seen'],
            ['verb' => 'take', 'past_simple' => 'took', 'past_participle' => 'taken'],
            ['verb' => 'think', 'past_simple' => 'thought', 'past_participle' => 'thought'],
            ['verb' => 'write', 'past_simple' => 'wrote', 'past_participle' => 'written'],
            ['verb' => 'speak', 'past_simple' => 'spoke', 'past_participle' => 'spoken'],
            ['verb' => 'read', 'past_simple' => 'read', 'past_participle' => 'read'],
            ['verb' => 'bring', 'past_simple' => 'brought', 'past_participle' => 'brought'],
            ['verb' => 'swim', 'past_simple' => 'swam', 'past_participle' => 'swum'],
            ['verb' => 'sit', 'past_simple' => 'sat', 'past_participle' => 'sat'],
            ['verb' => 'stand', 'past_simple' => 'stood', 'past_participle' => 'stood'],
            ['verb' => 'lose', 'past_simple' => 'lost', 'past_participle' => 'lost'],
            ['verb' => 'buy', 'past_simple' => 'bought', 'past_participle' => 'bought'],
            ['verb' => 'sell', 'past_simple' => 'sold', 'past_participle' => 'sold'],
        ]);

    }
}
