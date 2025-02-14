@extends('layouts.blog')

@section('custom_style')
    <style>
        .tw-hero-bg {
            background-position: left;
            min-height: 600px;
            background-image: url({{ asset('images/blog/banner-mobile.WebP') }});
        }
        @media (min-width: 1024px) {
            .tw-hero-bg {
                background-position: top;
                background-size: cover;
                min-height: 600px;
                background-image: url({{ asset('images/blog/banner.WebP') }});
            }
        }
    </style>
@endsection

@section('content')
<main>
    <x-tw-hero
        class="tw-hero-bg"
        overlay-opacity="0"
    >
        <x-slot:content>
            <div class="hidden w-fit bg-gradient-to-tr from-red-50 to-blue-100 bg-opacity-80 px-4 py-2
                lg:flex rounded-lg shadow-lg lg:px-4 lg:py-4"
            >
                <h1 class="text-2xl font-bold lg:text-xl lg:font-extrabold xl:text-3xl">
                    <span> Blog </span>
                    <i class="fas fa-flag-usa"></i>
                    <span class="bg-gradient-to-r from-indigo-600 via-pink-600 to-blue-600 bg-clip-text text-transparent">Wordcraft</span>
                </h1>
            </div>
        </x-slot>
    </x-tw-hero>

    <section class="space-y-6 mx-auto w-full max-w-4xl py-6 px-4 lg:py-12 xl:py-20">
        <h2 class="text-xl font-bold lg:text-2xl lg:font-extrabold xl:text-3xl">Last articles</h2>
        @forelse($posts->items() as $post)
            <x-tw-blog-row :post="$post"></x-tw-blog-row>
        @empty
            <p class="text-lg text-gray-500">Aucun article disponible.</p> <!-- Message when there are no articles -->
        @endforelse
    </section>

    <section class="py-4 mx-auto w-full max-w-4xl lg:py-4">
        @if($posts->isEmpty())
            <p>No posts available.</p> <!-- Message when there are no posts -->
        @else
            <!-- Render pagination links only if there are posts -->
            {{ $posts->links() }}
        @endif
    </section>
</main>

@endsection
