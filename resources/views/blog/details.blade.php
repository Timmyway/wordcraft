@extends('layouts.blog')
@section('title', $post['title'])
@section('description', $post['meta']['description'])
@section('featured_image', $post['featured_image'])

@section('content')
<section class="relative">
    <!-- Blog post content -->
    <div>
        <div class="py-2 px-4 max-w-2xl mx-auto lg:py-4">
            <div class="text-sm">
                <ul class="flex space-x-2">
                    <li class="text-gray-500 text-xs dark:text-gray-200">
                        <a href="{{ route('blog.index') }}">
                            <i class="fas fa-book mr-1"></i>
                            Blog
                        </a>
                    </li>
                    <li class="truncate text-ellipsis text-gray-500 text-xs dark:text-gray-200">
                        <a class="{{ route('blog.post', ['postId' => $post['id']])}}">
                            <i class="fas fa-file-alt mr-1"></i>
                            {{ $post['title'] }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="space-x-2 text-gray-500 dark:text-gray-200">
                <span class="text-xs">{{ tim_to_pretty_date($post['published_at'], 'D MMMM YYYY') }}</span>
                <i class="fas fa-circle text-[4px]"></i>
                <span class="text-xs">Temps de lecture : moins de {{ $readTime }}.</span>
            </div>
            <div class="w-full">
                <h1 class="py-2 font-bold text-xl lg:text-3xl uppercase lg:py-4 dark:text-white">{{ $post['title'] }}</h1>
            </div>
        </div>
        <div class="flex justify-center">
            <img src="{{ $post['featured_image'] }}" class="max-h-96 object-contain shadow-sm bg-red-600">
        </div>
        <article class="py-2 px-4 max-w-4xl mx-auto lg:py-4 lg:px-4">
            <div class="tw-blog-detail__body">
                {!! $post['body'] !!}
            </div>
        </article>
    </div>
</section>

<section class="mt-1">
    {{-- <x-blog-related-posts :post-id="$post->id" :slugs="$post->tags->pluck('slug')"></x-blog-related-posts> --}}
</section>
@endsection
