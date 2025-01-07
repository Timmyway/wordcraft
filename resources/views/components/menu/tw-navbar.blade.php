<nav
    class="mx-auto"
    x-data="{
        screenWidth: window.innerWidth,
        get isExtraSmallMobile() { return this.screenWidth < 420 },
        get isSmallMobile() { return this.screenWidth < 640 },
        get isMobile() { return this.screenWidth < 1024 },
        get isDesktop() { return this.screenWidth >= 1024 },
        showMenu: false,
        submenu: '',
        openDesktopMegamenu(item) {
            if (this.isDesktop) {
                this.showMenu = true;
                this.submenu = item;
            }
        },
        closeDesktopMegamenu(item) {
            if (this.isDesktop) {
                this.showMenu = false;
                this.submenu = '';
            }
        },
        openMobileMegamenu(item) {
            if (this.isMobile) {
                this.submenu = item;
            }
        },
        closeMobileMegamenu() {
            if (this.isMobile) {
                this.submenu = '';
            }
        },
        toogleMobileMegamenu(item) {
            if (this.isMobile) {
                if (this.submenu === item) {
                    this.submenu = '';
                } else {
                    this.submenu = item;
                }
            }
        },
        showMobileMenu() {
            this.showMenu = true;
        },
        hideMenu() {
            this.showMenu = false;
        },
        toogleMenu() {
            this.showMenu = !this.showMenu;
        }
    }"
    x-init="() => {
        window.addEventListener('resize', () => {
            screenWidth = window.innerWidth;
            if (isDesktop) {
                showMenu = false;
            }
        });
    }"
>
    <div class="w-full flex justify-between flex-wrap">
        <div @click.outside="hideMenu" class="lg:w-full lg:max-w-128">
            <div>
                {{-- Display in desktop mode by default, hide in mobile mode unless showMenu is true. --}}
                <ul
                    x-show="isDesktop || showMenu"
                    class="pt-5 bg-white fixed top-0 bottom-0 right-0 z-40
                        w-full max-w-80 h-screen px-8 shadow-lg
                        lg:flex lg:items-center lg:justify-center lg:gap-8
                        lg:shadow-none lg:static lg:pt-0 lg:px-4 lg:py-1 lg:h-auto
                        lg:max-h-12 lg:w-full lg:max-w-full"
                >
                    <div class="mb-4 lg:mb-0 lg:ml-0 lg:mr-auto">
                        <a href="{{ route('home') }}" class="py-2 lg:ml-0 lg:mr-auto">
                            <img class="max-w-32" src="{{ asset('images/wordcraft.svg') }}" alt="">
                        </a>
                    </div>
                    <li class="text-dark py-2"><a href="{{ route('home') }}">Wordcraft</a></li>
                    {{-- <li class="text-dark py-4 md:py-2 @isActive('site.about')"><a href="{{ route('site.about')}}">A propos</a></li> --}}
                    <li class="text-dark py-2 @isActive('blog')">
                        <a href="{{ route('blog.index')}}">Blog</a>
                    </li>
                    @auth
                    {{-- Display an avatar with the first letter of the user's name --}}
                    <li class="py-2" x-show="!isExtraSmallMobile">
                        <div class="flex items-center px-2">
                            <div class="flex items-center justify-center w-8 h-8 bg-yellow-500 dark:bg-yellow-300 text-white dark:text-gray-800 rounded-full font-semibold text-sm">
                                <!-- Displaying the first letter of the first name and last name -->
                                <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}</span>
                            </div>
                        </div>
                    </li>
                    @endauth
                </ul>
                <button
                    x-show="isMobile"
                    :class="['w-8 h-8 rounded-full p-1 flex items-center justify-center cursor-pointer top-2 right-1 z-50', showMenu ? 'fixed' : 'absolute']"
                    @click="toogleMenu()"
                >
                    <i x-show="showMenu" class="fas fa-times text-red-600 w-4"></i>
                    <i x-show="!showMenu" class="fas fa-bars w-4"></i>
                </button>
            </div>
        </div>
    </div>
</nav>
