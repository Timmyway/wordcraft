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

        <div class="text-center w-full py-2 flex flex-col gap-2 lg:text-left lg:flex-row lg:gap-6">
            <div class="flex flex-col gap-2">
                <p class="text-lg text-dark font-bold">Suivez-nous</p>
                <ul class="mx-auto flex justify-between flex-wrap max-w-xs gap-4 md:ml-0">
                    {{-- <li><a href=""><img src="{{ asset('images/icons/facebook.svg')}}" alt="FB"></a></li> --}}
                    <li>
                        <a href="https://www.youtube.com/channel/UC1fnj9QkuDp186pLPHPlKuA" target="_blank">
                            <img src="{{ asset('images/icons/youtube.svg')}}" class="w-6 block" alt="Youtube">
                        </a>
                    </li>
                </ul>
            </div>
            <div class="flex flex-col">
                <p class="text-lg text-dark font-bold">Site</p>
                <ul class="mx-auto flex flex-wrap max-w-xs gap-4">
                    <li class="mt-2"><a href="{{ route('home')}}">Wordcraft</a></li>
                </ul>
            </div>
        </div>

        <div class="text-left lg:text-left lg:flex lg:justify-between lg:items-center my-4">
            <span class="inline-block font-bold text-xs mb-4 sm:mb-0">© Copyright Wordcraft {{ date('Y') }} - All Rights Reserved</span>
            <ul class="lg:flex lg:justify-between">
                <li class="ml-4 pl-4 border-solid border-l border-gray-500 lg:ml-0 lg:pl-0 lg:border-l-0">
                    <a href="{{ route('legal.general-terms') }}" class="font-bold text-xs">Terms and Conditions of Use</a>
                </li>
                <li class="ml-4 pl-4 border-solid border-l border-gray-500">
                    <a href="{{ route('legal.cookies-policy') }}" class="font-bold text-xs">Cookie Policy</a>
                </li>
                <li class="ml-4 pl-4 border-solid border-l border-gray-500">
                    <a href="{{ route('legal.privacy-policy') }}" class="font-bold text-xs">Privacy Policy</a>
                </li>
                {{-- <li class="ml-4 pl-4 border-solid border-l-2 border-gray-200"><a href="{{ route('legal.mention') }}" class="font-bold text-xs" target="blank">Mentions légales</a></li> --}}
            </ul>
        </div>

    </div>

</footer>
