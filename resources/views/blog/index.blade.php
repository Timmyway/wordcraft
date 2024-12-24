@extends('layouts.blog')

@section('content')
<main>
    <x-tw-hero
        class="bg-center"
        bg-url="{{ asset('images/blog/banner.WebP') }}"
        bg-size="cover"
        height="36rem"
        overlay-opacity="0"
    >
        <x-slot:content>
            <div>
                <h1 class="text-2xl font-bold lg:text-4xl lg:font-extrabold xl:text-5xl">
                    Welcome to the <span class="bg-gradient-to-r from-indigo-600 via-pink-600 to-blue-600 bg-clip-text text-transparent">Wordcraft</span> Blog
                </h1>
            </div>
        </x-slot>
    </x-tw-hero>

    <section class="space-y-6 mx-auto w-full max-w-4xl py-6 lg:py-12 xl:py-20">
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
