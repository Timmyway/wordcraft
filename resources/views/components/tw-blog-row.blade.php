<div class="border-2 rounded-md border-slate-300 border-solid grid grid-cols-1 gap-4 lg:grid-cols-12 dark:text-gray-200">
    @if (!empty($post['featured_image']))
        <div class="lg:col-span-4">
            <div>
                <a href="/blog/{{ $post['id'] }}">
                    <img src="{{ $post['featured_image'] }}"
                        class="w-full h-60 object-cover"
                        alt="{{ $post['featured_image_caption'] }}"
                    >
                </a>
            </div>
        </div>
    @else
        <!-- If there's no image, adjust the grid to make content full width -->
        <div class="lg:col-span-12"></div>
    @endif

    <div class="{{ empty($post['featured_image']) ? 'lg:col-span-12' : 'lg:col-span-8' }} p-4 lg:p-8">
        <div>
            <div class="flex items-center gap-2 lg:gap-4">
                {{-- If avatar is available
                <div>
                    <img src="{{ $post->author?->avatar }}" class="w-8 h-8 rounded-full">
                </div> --}}
                <div class="flex flex-col">
                    <span class="text-xs">{{ $post['author']['name'] }}</span>
                    <span class="text-xs text-gray-600 dark:text-gray-400">Publié le : {{ $post['published_at'] }}</span>
                </div>
            </div>
            <a href="/blog/{{ $post['slug'] }}">
                <h5 class="font-bold py-4 text-3xl">{{ $post['title'] }}</h5>
                @if (!empty($post['excerpt']))
                    <p class="text-gray-600 dark:text-gray-400">
                        {!! Str::limit(strip_tags($post['excerpt']), 200) !!}
                    </p>
                @else
                    <p class="text-gray-600 dark:text-gray-400">
                        {!! Str::limit(strip_tags($post['body']), 200) !!}
                    </p>
                @endif
            </a>
        </div>
        <div class="pt-6">
            <a
                class="bg-indigo-900 text-white py-4 px-4 font-bold text-lg rounded-full flex items-center gap-2 w-fit max-w-xs mr-0 ml-auto opacity-95 hover:opacity-100"
                href="/blog/{{ $post['slug'] }}"
            >
                <span>{{ $ctaText }}</span>
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </div>
</div>
