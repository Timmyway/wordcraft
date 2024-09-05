<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'house',
            'travel',
            'school',
            'business',
            'food',
            'technology',
            'health',
            'sports',
            'finance',
            'entertainment',
            'culture',
            'art',
            'science',
            'environment',
            'history',
            'music',
            'fashion',
            'fitness',
            'literature',
            'politics',
            'psychology',
            'relationships',
            'parenting',
            'personal development',
            'gaming',
            'photography',
            'nature',
            'vehicles',
            'events',
            'vacation',
            'local',
            'global',
            'adventure',
            'self-care'
        ];

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }
    }
}
