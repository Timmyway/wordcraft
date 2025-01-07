<!DOCTYPE html>
<html>
	<head>
		<!-- Metas -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('description', 'Dive into the Wordcraft Blog for practical tips, grammar guides, vocabulary building, and creative ways to master English effortlessly. Perfect for learners of all levels!')">
		<meta property="og:title" content="@yield('title', 'Explore English Tips & Language Insights | Wordcraft Blog')" />
		<meta property="og:url" content="" />
		<meta property="og:image" content="@yield('featured_image', '')" />
		<meta property="og:description" content="@yield('description', 'Dive into the Wordcraft Blog for practical tips, grammar guides, vocabulary building, and creative ways to master English effortlessly. Perfect for learners of all levels!')" />

		<title>@yield('title', 'Explore English Tips & Language Insights | Wordcraft Blog')</title>

		<link rel="icon" type="image/x-icon" sizes="32x32" href="{{ asset('images/favicon-wordcraft.ico') }}">
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
        @section('custom_style')
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
