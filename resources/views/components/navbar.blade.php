<header id="myheaderNav" class="sticky top-0 border-b border-cerulean-200 bg-cerulean-50/95 backdrop-blur">
    <nav class="mx-auto w-full max-w-8xl px-4 py-3 md:px-6">
        <div class="flex items-center justify-between">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-cerulean-700 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 11.5L12 4l9 7.5"/>
                        <path d="M5 10.5V20h14v-9.5"/>
                        <path d="M10 20v-5h4v5"/>
                    </svg>
                </span>
                <span class="hidden text-2xl text-cerulean-800 md:block">EasyColoc</span>
            </a>

            <button
                type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-cerulean-300 text-cerulean-800 md:hidden"
                id="burgerMenu"
                aria-label="Toggle menu"
            >
                <svg id="openBurgerMenu" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm1 4a1 1 0 100 2h12a1 1 0 100-2H4z" clip-rule="evenodd" />
                </svg>
                <svg id="closeBurgerMenu" xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <ul class="hidden items-center gap-2 md:flex">
                @auth
                    @if(auth()->user()->role==='admin')
                        <li>
                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-cerulean-700 text-white hover:bg-cerulean-800' : 'text-cerulean-700 hover:bg-cerulean-100' }}"
                            >
                                Admin Dashboard
                            </a>
                        </li>
                    @endif

                    <li>
                        <a
                            href="{{ route('profile.view') }}"
                            class="rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('profile.*') ? 'bg-cerulean-700 text-white hover:bg-cerulean-800' : 'text-cerulean-700 hover:bg-cerulean-100' }}"
                        >
                            Profile
                        </a>
                    </li>
                    <li>
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-xl bg-cerulean-700 px-3 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="rounded-xl px-3 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-100">Login</a></li>
                    <li><a href="{{ route('register') }}" class="rounded-xl bg-cerulean-700 px-3 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Register</a></li>
                @endauth
            </ul>
        </div>

        <div id="mobile-menu" class="mt-3 hidden rounded-2xl border border-cerulean-200 bg-white p-2 md:hidden">
            <ul class="space-y-1">
                @auth
                    <li>
                        <a
                            href="{{ route('profile.view') }}"
                            class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('profile.*') ? 'bg-cerulean-700 text-white hover:bg-cerulean-800' : 'text-cerulean-700 hover:bg-cerulean-100' }}"
                        >
                            Profile
                        </a>
                    </li>
                    <li>
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full rounded-xl bg-cerulean-700 px-3 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-100">Login</a></li>
                    <li><a href="{{ route('register') }}" class="block rounded-xl bg-cerulean-700 px-3 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Register</a></li>
                @endauth
            </ul>
        </div>
    </nav>
</header>

<script>
    (() => {
        const burgerButton = document.getElementById('burgerMenu');
        const openIcon = document.getElementById('openBurgerMenu');
        const closeIcon = document.getElementById('closeBurgerMenu');
        const mobileMenu = document.getElementById('mobile-menu');
        const header = document.getElementById('myheaderNav');

        if (!burgerButton || !openIcon || !closeIcon || !mobileMenu || !header) {
            return;
        }

        const closeMenu = () => {
            mobileMenu.classList.add('hidden');
            closeIcon.classList.add('hidden');
            openIcon.classList.remove('hidden');
        };

        burgerButton.addEventListener('click', (event) => {
            event.stopPropagation();
            const isHidden = mobileMenu.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden', isHidden);
            openIcon.classList.toggle('hidden', !isHidden);
        });

        document.addEventListener('click', (event) => {
            if (!header.contains(event.target)) {
                closeMenu();
            }
        });
    })();
</script>
