<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Travel', 'Food', 'Technology', 'Education', 'Health', 'Fitness', 'Entertainment',
            'Fashion', 'Business', 'Nature', 'Art', 'Finance', 'Music', 'Science', 'Culture',
            'Sports', 'Wellness', 'Lifestyle', 'Marketing', 'Adventure', 'History', 'Politics',
            'Social Media', 'Photography', 'Books', 'Movies', 'Television', 'Gaming', 'Shopping',
            'Hobbies', 'Languages', 'Economy', 'Environment', 'Leadership', 'Communication',
            'Animals', 'Parenting', 'Relationships', 'Personal Development', 'Spirituality',
            'Religion', 'Psychology', 'Mental Health', 'Sustainability', 'Real Estate',
            'Architecture', 'Technology Trends', 'Cars', 'Motorcycles', 'Gadgets', 'Programming',
            'Coding', 'Artificial Intelligence', 'Blockchain', 'Cryptocurrency', 'Startup',
            'Productivity', 'Work', 'Career', 'Job Search', 'Freelancing', 'Consulting',
            'Entrepreneurship', 'Investing', 'Stock Market', 'E-commerce', 'Sales', 'Customer Service',
            'Advertising', 'Public Relations', 'Journalism', 'Law', 'Government', 'Nonprofit',
            'Volunteering', 'Charity', 'Philanthropy', 'Social Justice', 'Equality', 'Human Rights',
            'Discrimination', 'Politics', 'War', 'Peace', 'Conflict', 'Medicine', 'Pharmacy',
            'Nutrition', 'Exercise', 'Cooking', 'Baking', 'Home Improvement', 'Interior Design',
            'Gardening', 'DIY', 'Crafts', 'Pets', 'Wildlife', 'Marine Life', 'Space', 'Astronomy',
            'Physics', 'Mathematics', 'Biology', 'Chemistry', 'Geography', 'Geology'
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['name' => $tag]);
        }
    }
}
