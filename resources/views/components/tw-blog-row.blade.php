<div class="border-2 rounded-md border-slate-100 border-solid grid grid-cols-1 gap-4 lg:grid-cols-12">
    <div class="lg:col-span-4">
        <div>
            <a href="/blog/{{ $post['id'] }}">
                <img src="{{ $post['featured_image'] }}"
                    class="w-full h-60 object-cover"
                    alt={{ $post['featured_image_caption'] }}
                >
            </a>
        </div>
    </div>

    <div class="lg:col-span-8 p-4 lg:p-8">
        <div>
            <div class="flex items-center gap-2 lg:gap-4">
                {{-- <div>
                    <img src="{{ $post->author?->avatar }}" class="w-8 h-8 rounded-full">
                </div> --}}
                <div class="flex flex-col">
                    <span>{{ $post['author']['name'] }}</span>
                    <span class="text-md text-gray-600">Publié le : {{ $post['published_at'] }}</span>
                </div>
            </div>
            <a href="/blog/{{ $post['slug'] }}">
                <h5 class="font-bold py-4 text-3xl">{{ $post['title'] }}</h5>
                @if (!empty($post['excerpt']))
                    <p>
                        {!! Str::limit($post['excerpt'], 200) !!}
                    </p>
                @else
                    <p>
                        {!! Str::limit(strip_tags($post['body']), 200) !!}
                    </p>
                @endif
            </a>
        </div>
        <div class="pt-6">
            <a
                class="py-4 px-4 font-bold text-xl rounded-full flex items-center gap-3 w-fit max-w-xs mr-0 ml-auto opacity-95 uppercase hover:opacity-100"
                href="/blog/{{ $post['slug'] }}"
            >
                <span class="underline">{{ $ctaText }}</span>
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </div>
</div>
