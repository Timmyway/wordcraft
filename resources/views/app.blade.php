<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Wordcraft') }}: Master English Vocabulary and Irregular Verbs | Learn Words & Sentences Easily</title>
        <meta name="description" content="WordCraft is your ultimate English learning tool for building a rich vocabulary. Explore a growing list of words and sentences, categorized by tags for easy retrieval. Enhance your language skills with a dedicated page for irregular verbs. Perfect for learners aiming to improve their English proficiency through focused vocabulary training.">
        <link rel="icon" type="image/x-icon" sizes="32x32" href="{{ asset('images/favicon-wordcraft.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Paytone+One&display=swap" rel="stylesheet">

        <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased flex flex-col">
        @inertia
    </body>

    <script>
        var baseApiUrl = '{{ $base_api_url }}';
    </script>
</html>
