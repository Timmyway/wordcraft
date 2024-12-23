<!DOCTYPE html>
<html>
	<head>
		<!-- Metas -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('description', 'WordCraft is your ultimate English learning tool for building a rich vocabulary. Explore a growing list of words and sentences, categorized by tags for easy retrieval. Enhance your language skills with a dedicated page for irregular verbs. Perfect for learners aiming to improve their English proficiency through focused vocabulary training.')">
		<meta property="og:title" content="@yield('title', 'Master English Vocabulary and Irregular Verbs | Learn Words & Sentences Easily')" />
		<meta property="og:url" content="" />
		<meta property="og:image" content="@yield('featured_image', '')" />
		<meta property="og:description" content="@yield('description', 'WordCraft is your ultimate English learning tool for building a rich vocabulary. Explore a growing list of words and sentences, categorized by tags for easy retrieval. Enhance your language skills with a dedicated page for irregular verbs. Perfect for learners aiming to improve their English proficiency through focused vocabulary training.')" />

		<title>@yield('title', 'Grand jeu concours')</title>

		<link rel="icon" type="icon" sizes="32x32" href="{{ asset('images/favicon-48x48.png') }}">
        <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">
		<!-- Google Fonts-->
		<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Paytone+One&display=swap" rel="stylesheet">
		@section('custom_fonts')
		@show
		@section('css_page')
		@vite(['resources/sass/appBlog.scss', 'resources/js/blog/appBlog.ts'])
		@show
	</head>

	<body>
        <x-menu.tw-navbar></x-menu.tw-navbar>
		@yield('content')

        @section('footer')
		<x-menu.tw-footer></x-menu.tw-footer>
        @show

        {{-- <script>
			var baseURL = '{{ $front_url }}';
            var apiURL = '{{ $back_url }}';
			console.log(`Frontend url: ${baseURL}`);
			console.log(`Backend api url: ${apiURL}`);
        </script> --}}

		@section('vuescript')
        @show
	</body>
</html>
