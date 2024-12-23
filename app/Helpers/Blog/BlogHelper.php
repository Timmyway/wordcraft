<?php
namespace App\Helpers\Blog;

use Carbon\Carbon;

class BlogHelper
{
    public static function estimateReadTime($post)
    {
        // Define average reading speed in words per minute (WPM)
        $averageReadingSpeed = 250;
        // Count the number of words in the post
        $wordCount = str_word_count(strip_tags($post));

        // Calculate the estimated reading time based on average reading speed
        $minutes = ceil($wordCount / $averageReadingSpeed);

        // Return the estimation
        return $minutes . ' minute' . ($minutes == 1 ? '' : 's');
    }

    public static function toHumanDate(string $date, string $format = 'D MMMM YYYY')
    {
        return Carbon::parse($date)->isoFormat($format);
    }
}
