<section
    {{ $attributes->merge(['class' => "relative py-4 lg:py-8 bg-no-repeat bg-{$bgSize} bg-gray-100"]) }}
    style="background-image: url('{{ $bgUrl }}'); height: {{ $height }};"
>
    @if ($bgUrl)
    <!-- Overlay -->
    <div class="bg-gradient-to-r from-blue-100 to-yellow-100 opacity-{{ $overlayOpacity }} absolute top-0 bottom-0 right-0 left-0 w-full h-full"></div>
    @endif
    <div class="mx-auto md:flex md:flex-row-reverse justify-between max-w-7xl xl:h-125">
        {{ $content }}
    </div>
</section>
