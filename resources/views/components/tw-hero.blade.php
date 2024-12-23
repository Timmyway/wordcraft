<section class="relative py-4 lg:py-8 bg-no-repeat bg-cover bg-gray-100" style="background-image: url('{{ $bgUrl }}');">
    @if ($bgUrl)
    <!-- Overlay -->
    <div class="bg-gradient-to-r from-pink-300 to-yellow-100 opacity-50 absolute top-0 bottom-0 right-0 left-0 w-full h-full"></div>
    @endif
    <div class="mx-auto md:flex md:flex-row-reverse justify-between max-w-7xl xl:h-125">
      <div class="flex items-center mx-auto md:w-95/200 max-w-137">
        {{ $content }}
      </div>
    </div>
</section>
