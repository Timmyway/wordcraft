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

                <ul
                    x-show="isDesktop || showMenu"
                    class="pt-5 bg-yellow-200 font-bold fixed top-0 bottom-0 right-0 z-40
                        w-full max-w-80 h-screen px-8 shadow-lg
                        lg:shadow-none lg:static lg:pt-0 lg:px-4 lg:py-1 lg:h-auto lg:w-full lg:max-w-full lg:flex lg:items-center lg:justify-center lg:gap-8"
                >
                    <a href="{{ route('home') }}" class="py-8 lg:ml-0 lg:mr-auto">
                        <img class="max-w-16" src="{{ asset('images/wordcraft.svg') }}" alt="">
                    </a>
                    <li class="text-dark py-4 md:py-2 @isActive('home')"><a href="{{ route('home') }}">Accueil</a></li>
                    <li class="text-dark py-4 md:py-2 @isActive('site.about')"><a href="{{ route('site.about')}}">A propos</a></li>
                    <li class="text-dark py-4 md:py-2 @isActive('site.contact')"><a href="{{ route('site.contact')}}">Contact</a></li>
                    <li class="text-dark py-4 md:py-2 @isActive('blog.index')"><a href="{{ route('blog.index')}}">Blog</a></li>
                </ul>
                <button
                    x-show="isMobile"
                    :class="['ds-btn ds-btn-circle top-5 right-1 z-50', showMenu ? 'fixed' : 'absolute']"
                    @click="toogleMenu()"
                >
                    <i x-show="showMenu" class="fas fa-times text-red-600 w-4"></i>
                    <i x-show="!showMenu" class="fas fa-bars w-4"></i>
                </button>
            </div>
        </div>
        <ul :class="['flex justify-between gap-2.5 me-8 lg:me-0 z-50', showMenu ? 'fixed right-6' : 'static']">
            @auth
            <li class="py-4 md:py-8" x-show="!isExtraSmallMobile">
                <div class="flex items-center px-2">
                    <span class="text-yellow">{{ Auth::user()->name }}</span>
                </div>
            </li>
            @endauth
        </ul>
    </div>
</nav>
