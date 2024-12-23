@extends('layouts.blog')

@section('content')
<main>
    <x-tw-hero bg-url="{{ asset('images/blog/banner.WebP') }}">
        <x-slot:content>
            <div>
                <h1 class="text-2xl font-bold lg:text-4xl lg:font-extrabold xl:text-5xl">
                    Bienvenue sur le blog de <span class="bg-gradient-to-r from-primary via-secondary to-yellow bg-clip-text text-transparent">Jeuxgagne.fr</span>
                </h1>
                <p class="my-6 xl:my-12 text-xl lg:text-2xl max-w-md">
                    Découvrez notre univers : conseils, astuces et actualités pour une vie pleine de plaisirs et de surprises !
                </p>
                {{-- <a href="#liste-des-jeux">
                <button class="px-4 py-4 rounded-lg font-bold focus:outline-none text-white bg-gradient-to-r from-primary via-secondary to-yellow hover:bg-gradient-to-r hover:from-dark hover:to-primary">
                    Jouer maintenant
                    <img src="{{ asset('images/home/icons/arrow-right.svg')}}" alt="" class="inline-block ml-2 h-2.5 w-4">
                </button>
                </a> --}}
            </div>
        </x-slot>
    </x-tw-hero>

    <section class="space-y-6 mx-auto w-full max-w-4xl py-6 lg:py-12 xl:py-20">
        @foreach($posts['data'] as $post)
        <x-tw-blog-row :post="$post"></x-tw-blog-row>
        @endforeach
    </section>

    {{-- <section class="py-4 lg:py-8 mx-auto w-full max-w-4xl">
        @if($posts->data->isEmpty())
            <p>No posts available.</p> <!-- Message when there are no posts -->
        @else
            {{ $posts->links() }} <!-- Render pagination links only if there are posts -->
        @endif
    </section> --}}
</main>

@endsection
