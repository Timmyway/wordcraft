<footer class="bg-yellow-200">
    <div class="mx-auto px-4 py-2">
        <div
            x-data="{ showButton: false }"
            x-init="window.addEventListener('scroll', () => { showButton = window.scrollY > 300; })">
            <button
                class="ds-btn ds-btn-circle fixed right-1 bottom-1 shadow-lg opacity-60 hover:opacity-100"
                x-show="showButton"
                @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            >
                <img src="{{ asset('images/icons/arrow-up.svg')}}" class="w-4" alt="">
            </button>
        </div>

        <div class="text-center md:text-left flex flex-col md:flex-row md:justify-between w-full py-2">
            <div class="flex flex-col">
                <p class="mb-4 text-lg text-dark font-bold">Suivez-nous</p>
                <ul class="mx-auto flex justify-between flex-wrap max-w-xs gap-4 md:ml-0 h-4">
                    <li><a href=""><img src="{{ asset('images/icons/facebook.svg')}}" alt="FB"></a></li>
                    <li><a href=""><img src="{{ asset('images/icons/youtube.svg')}}" alt="Youtube"></a></li>
                </ul>
            </div>
            <div class="flex flex-col">
                <p class="mb-4 text-lg text-dark font-bold">Site</p>
                <ul class="mx-auto flex justify-between flex-wrap max-w-xs gap-4 md:ml-0 h-4">
                    <li class="mt-2"><a href="{{ route('site.about')}}">A propos</a></li>
                    <li class="mt-2"><a href="{{ route('site.contact')}}">Contact</a></li>
                </ul>
            </div>
        </div>

        <div class="text-left sm:text-left sm:flex sm:justify-between mb-4">
            <span class="inline-block font-bold text-xs mb-4 sm:mb-0">© Copyright {{ date('Y') }} - Tous Droits Réservés</span>
            <ul class="lg:flex lg:justify-between">
                Legal links : TODO
                {{-- <li class="ml-4 pl-4 border-solid border-l-2 border-gray-200 lg:ml-0 lg:pl-0 lg:border-l-0"><a href="{{ route('legal.cgu') }}" class="font-bold text-xs" target="blank">CGU</a></li> --}}
                {{-- <li class="ml-4 pl-4 border-solid border-l-2 border-gray-200"><a href="{{ route('legal.cookies') }}" class="font-bold text-xs" target="blank">Politique de cookies</a></li>
                <li class="ml-4 pl-4 border-solid border-l-2 border-gray-200"><a href="{{ route('legal.protection') }}" class="font-bold text-xs" target="blank">Politique de protection des données</a></li>
                <li class="ml-4 pl-4 border-solid border-l-2 border-gray-200"><a href="{{ route('legal.mention') }}" class="font-bold text-xs" target="blank">Mentions légales</a></li> --}}
            </ul>
        </div>

    </div>

</footer>

