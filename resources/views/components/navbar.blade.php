

<header id="myheaderNav" class="border-b border-cerulean-200 bg-cerulean-50/95 backdrop-blur sticky top-0 ">
    <nav class="mx-auto w-full max-w-8xl px-4 py-3 md:px-6 " >
        <div class="flex items-center justify-between">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2">
                <img alt="logo" src="{{asset('storage/images/nass_split_logo.png')}}" height="50" width="50" />
                <span class="font-cash2 text-2xl text-cerulean-800  ">Nass Split</span>
            </a>

            <button
                type="button"
                class=" inline-flex h-10 w-10 items-center justify-center rounded-xl border border-cerulean-300 text-cerulean-800 md:hidden"
                id="burgerMenu"
            >
                <svg id="openBurgerMenu" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" >
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm1 4a1 1 0 100 2h12a1 1 0 100-2H4z" clip-rule="evenodd" />
                </svg>
{{--                svg for when clicked--}}
                <svg id="closeBurgerMenu" xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" viewBox="0 0 20 20" fill="currentColor" >
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <ul class="hidden items-center gap-2 md:flex">
                <li><a href="{{ url('/') }}" class="rounded-xl px-3 py-2 text-sm font-semibold text-cerulean-800 hover:bg-cerulean-100">Home</a></li>
                <li><a href="{{ route('login') }}" class="rounded-xl px-3 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-100">Login</a></li>
                <li><a href="{{ route('register') }}" class="rounded-xl bg-cerulean-700 px-3 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Register</a></li>
            </ul>
        </div>

        <div id="mobile-menu" class="mt-3 hidden rounded-2xl border border-cerulean-200 bg-white p-2 md:hidden">
            <ul class="space-y-1">
                <li><a href="{{ url('/') }}" class=" rounded-xl px-3 py-2 text-sm font-semibold text-cerulean-800 hover:bg-cerulean-100">Home</a></li>
                <li><a href="{{ route('login') }}" class=" rounded-xl px-3 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-100">Login</a></li>
                <li><a href="{{ route('register') }}" class=" rounded-xl bg-cerulean-700 px-3 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Register</a></li>
            </ul>
        </div>
    </nav>
</header>

<script>
    document.addEventListener('click', (e) => {
    const closeBurgerMenu = document.getElementById('closeBurgerMenu');
    const openBurgerMenu = document.getElementById('openBurgerMenu');
    const mobileMenu = document.getElementById('mobile-menu');
    const header = document.getElementById('myheaderNav');
    [closeBurgerMenu, openBurgerMenu, mobileMenu].forEach(menu => {
        menu.classList.toggle('hidden');
    })

    });
</script>
