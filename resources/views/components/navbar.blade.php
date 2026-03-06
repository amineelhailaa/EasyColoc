<header id="myheaderNav" class="fixed inset-x-0 top-0 z-40 w-full border-b border-cerulean-300 bg-cerulean-50/95 backdrop-blur font-['Plus_Jakarta_Sans',sans-serif]">
    <nav class="flex w-full items-center justify-between px-4 py-3 md:px-6 lg:px-8">

        <a href="{{ url('/') }}" class="group flex items-center gap-2.5 outline-none">
            <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-xl border border-cerulean-300 bg-cerulean-50 transition-transform group-hover:scale-105">
                <img src="{{ asset('storage/avatars/Nass_Split_Logo.png') }}" alt="Nass Split logo" class="h-full w-full object-contain">
            </div>
            <span class="hidden text-xl font-extrabold tracking-tight text-cerulean-900 md:block">Nass Split</span>
        </a>

        <div class="flex items-center gap-3">
            @auth
                @php
                    $authAvatar = auth()->user()->avatar
                        ? asset('storage/' . auth()->user()->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') . '&background=0369a1&color=ffffff';
                @endphp

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="hidden items-center gap-1.5 rounded-full border border-cerulean-300 bg-cerulean-50 px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-cerulean-800 hover:bg-cerulean-100 md:flex">
                        Admin
                    </a>
                @endif

                <div class="relative" id="notification-wrapper">
                    <button type="button" id="notificationBtn" class="relative rounded-full p-2 text-cerulean-600 transition hover:bg-cerulean-100 focus:outline-none" aria-expanded="false">
                        <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute right-2 top-2 block h-2 w-2 rounded-full border-2 border-white bg-red-500"></span>
                    </button>

                    <div id="notificationDropdown" class="absolute right-0 mt-2 hidden w-80 origin-top-right rounded-2xl border border-cerulean-300 bg-cerulean-50 py-1 shadow-lg ring-1 ring-cerulean-200/60 focus:outline-none sm:w-96">
                        <div class="flex items-center justify-between border-b border-cerulean-200 px-4 py-3">
                            <p class="text-sm font-bold text-cerulean-900">Notifications</p>
                            <button type="button" class="text-xs font-semibold text-cerulean-600 hover:text-cerulean-800">Mark all read</button>
                        </div>

                        <div class="max-h-80 overflow-y-auto overscroll-contain">
                            <a href="#" class="block border-b border-cerulean-100 px-4 py-3 transition hover:bg-cerulean-100">
                                <p class="text-sm font-semibold text-cerulean-800">Participant A added a new expense</p>
                                <p class="mt-0.5 text-xs text-cerulean-600">Dinner - 120.00 MAD</p>
                                <p class="mt-1 text-[10px] font-medium text-cerulean-500">2 hours ago</p>
                            </a>
                            <a href="#" class="block border-b border-cerulean-100 px-4 py-3 transition hover:bg-cerulean-100">
                                <p class="text-sm font-semibold text-cerulean-800">Your expense was marked as paid</p>
                                <p class="mt-0.5 text-xs text-cerulean-600">Taxi - 45.00 MAD</p>
                                <p class="mt-1 text-[10px] font-medium text-cerulean-500">1 day ago</p>
                            </a>
                        </div>

                        <div class="px-4 py-2 text-center">
                            <a href="#" class="text-xs font-semibold text-cerulean-800 hover:text-cerulean-900">View all notifications</a>
                        </div>
                    </div>
                </div>

                <div class="relative ml-1">
                    <button
                        type="button"
                        id="avatarSidebarButton"
                        aria-controls="profile-sidebar"
                        aria-expanded="false"
                        class="inline-flex h-10 w-10 items-center justify-center overflow-hidden rounded-full border border-cerulean-400 bg-cerulean-50 shadow-sm transition hover:border-cerulean-600 focus:outline-none"
                    >
                        <img src="{{ $authAvatar }}" alt="Profile" class="h-full w-full object-cover">
                    </button>
                    <span class="absolute bottom-0 right-0 inline-flex min-h-4 min-w-4 translate-x-[8%] translate-y-[8%] items-center justify-center rounded-full border border-white bg-cerulean-700 px-1 text-[10px] font-bold leading-none text-white">
                        {{ auth()->user()->reputation ?? 0 }}
                    </span>
                </div>
            @else
                <div class="hidden items-center gap-2 md:flex">
                    <a href="{{ route('login') }}" class="rounded-xl px-4 py-2 text-sm font-semibold text-cerulean-800 hover:bg-cerulean-200">Login</a>
                    <a href="{{ route('register') }}" class="rounded-xl bg-cerulean-700 px-4 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Register</a>
                </div>

                <button type="button" id="burgerMenu" class="inline-flex rounded-lg border border-cerulean-400 bg-cerulean-50 p-2 text-cerulean-800 md:hidden">
                    <svg id="openBurgerMenu" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="closeBurgerMenu" xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            @endauth
        </div>
    </nav>

    @guest
        <div id="mobile-menu" class="hidden border-t border-cerulean-300 bg-cerulean-50 px-4 py-3 md:hidden">
            <div class="flex flex-col gap-2">
                <a href="{{ route('login') }}" class="rounded-xl px-3 py-2 text-sm font-semibold text-cerulean-800 hover:bg-cerulean-200">Login</a>
                <a href="{{ route('register') }}" class="rounded-xl bg-cerulean-700 px-3 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Register</a>
            </div>
        </div>
    @endguest

    @auth
        <div id="profile-sidebar-overlay" class="pointer-events-none fixed inset-0 z-40 bg-cerulean-900/40 opacity-0 transition-opacity duration-300"></div>

        <aside id="profile-sidebar" class="pointer-events-none fixed right-0 top-0 z-50 h-screen w-full max-w-xs translate-x-full border-l border-cerulean-300 bg-cerulean-50 opacity-0 transition-transform duration-300 transition-opacity">
            <div class="flex h-full flex-col p-5">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex min-w-0 items-center gap-3">
                        <img src="{{ $authAvatar }}" alt="Profile avatar" class="h-12 w-12 rounded-full border border-cerulean-300 object-cover">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-cerulean-900">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs text-cerulean-600">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <button type="button" id="closeProfileSidebar" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-cerulean-300 text-cerulean-700 hover:bg-cerulean-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <div class="mt-6 space-y-2">
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-cerulean-700 text-white' : 'text-cerulean-800 hover:bg-cerulean-200' }}">
                            Admin Dashboard
                        </a>
                    @endif
                    <a href="{{ route('profile.view') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('profile.*') ? 'bg-cerulean-700 text-white' : 'text-cerulean-800 hover:bg-cerulean-200' }}">
                        My Profile
                    </a>
                    <a href="{{ route('profile.view') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('profile.*') ? 'bg-cerulean-700 text-white' : 'text-cerulean-800 hover:bg-cerulean-200' }}">
                        Preferences
                    </a>
                    <a href="mailto:support@easycoloc.app" class="block rounded-xl px-4 py-3 text-sm font-semibold text-cerulean-800 hover:bg-cerulean-200">
                        Help / Support
                    </a>
                </div>

                <div class="mt-auto pt-6">
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-xl bg-cerulean-700 px-4 py-3 text-sm font-semibold text-white hover:bg-cerulean-800">Logout</button>
                    </form>
                </div>
            </div>
        </aside>
    @endauth
</header>
<div id="myheaderNavSpacer" aria-hidden="true"></div>
@guest
    <div id="mobile-menu-overlay" class="pointer-events-none fixed inset-0 z-30 hidden bg-cerulean-900/20 backdrop-blur-sm md:hidden"></div>
@endguest

<script>
    (() => {
        const header = document.getElementById('myheaderNav');
        const headerSpacer = document.getElementById('myheaderNavSpacer');

        // Mobile Guest Menu
        const burgerButton = document.getElementById('burgerMenu');
        const openIcon = document.getElementById('openBurgerMenu');
        const closeIcon = document.getElementById('closeBurgerMenu');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');

        // Sidebar
        const avatarButton = document.getElementById('avatarSidebarButton');
        const profileSidebar = document.getElementById('profile-sidebar');
        const profileSidebarOverlay = document.getElementById('profile-sidebar-overlay');
        const closeProfileSidebarButton = document.getElementById('closeProfileSidebar');

        // Notifications
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');

        // --- Notifications Logic ---
        const closeNotificationMenu = () => {
            if (!notificationDropdown || !notificationBtn) return;
            notificationDropdown.classList.add('hidden');
            notificationBtn.setAttribute('aria-expanded', 'false');
        };

        if (notificationBtn && notificationDropdown) {
            notificationBtn.addEventListener('click', (event) => {
                event.stopPropagation();
                const isHidden = notificationDropdown.classList.toggle('hidden');
                notificationBtn.setAttribute('aria-expanded', !isHidden);
            });
        }

        // --- Mobile Menu Logic ---
        const syncHeaderSpacer = () => {
            if (!header || !headerSpacer) return;
            headerSpacer.style.height = `${header.offsetHeight}px`;
        };

        const closeMenu = () => {
            if (!mobileMenu || !openIcon || !closeIcon) return;
            mobileMenu.classList.add('hidden');
            if (mobileMenuOverlay) {
                mobileMenuOverlay.classList.add('hidden', 'pointer-events-none');
            }
            closeIcon.classList.add('hidden');
            openIcon.classList.remove('hidden');
            syncHeaderSpacer();
        };

        if (burgerButton && openIcon && closeIcon && mobileMenu && header) {
            burgerButton.addEventListener('click', (event) => {
                event.stopPropagation();
                const isHidden = mobileMenu.classList.toggle('hidden');
                if (mobileMenuOverlay) {
                    mobileMenuOverlay.classList.toggle('hidden', isHidden);
                    mobileMenuOverlay.classList.toggle('pointer-events-none', isHidden);
                }
                closeIcon.classList.toggle('hidden', isHidden);
                openIcon.classList.toggle('hidden', !isHidden);
                syncHeaderSpacer();
            });
        }

        // --- Sidebar Logic ---
        const openProfileSidebar = () => {
            if (!avatarButton || !profileSidebar || !profileSidebarOverlay) return;
            profileSidebar.classList.remove('translate-x-full', 'opacity-0', 'pointer-events-none', 'shadow-none');
            profileSidebar.classList.add('shadow-2xl');
            profileSidebarOverlay.classList.remove('pointer-events-none', 'opacity-0');
            profileSidebarOverlay.classList.add('opacity-100');
            avatarButton.setAttribute('aria-expanded', 'true');
            document.body.classList.add('overflow-hidden');
            closeNotificationMenu(); // Close notifications if open
        };

        const closeProfileSidebar = () => {
            if (!avatarButton || !profileSidebar || !profileSidebarOverlay) return;
            profileSidebar.classList.add('translate-x-full', 'opacity-0', 'pointer-events-none', 'shadow-none');
            profileSidebar.classList.remove('shadow-2xl');
            profileSidebarOverlay.classList.remove('opacity-100');
            profileSidebarOverlay.classList.add('opacity-0', 'pointer-events-none');
            avatarButton.setAttribute('aria-expanded', 'false');
            document.body.classList.remove('overflow-hidden');
        };

        if (avatarButton && profileSidebar && profileSidebarOverlay && closeProfileSidebarButton) {
            avatarButton.addEventListener('click', (event) => {
                event.stopPropagation();
                if (profileSidebar.classList.contains('translate-x-full')) {
                    openProfileSidebar();
                } else {
                    closeProfileSidebar();
                }
            });

            closeProfileSidebarButton.addEventListener('click', closeProfileSidebar);
            profileSidebarOverlay.addEventListener('click', closeProfileSidebar);
        }

        // --- Global Events ---
        document.addEventListener('click', (event) => {
            // Close mobile menu if clicking outside header
            if (header && !header.contains(event.target)) {
                closeMenu();
            }

            // Close notification dropdown if clicking outside of it
            if (notificationDropdown && !notificationDropdown.contains(event.target) && !notificationBtn.contains(event.target)) {
                closeNotificationMenu();
            }

            // Close sidebar if clicking outside
            if (profileSidebar && !profileSidebar.contains(event.target) && avatarButton && !avatarButton.contains(event.target) && !profileSidebar.classList.contains('translate-x-full')) {
                closeProfileSidebar();
            }
        });

        if (mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener('click', closeMenu);
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                closeMenu();
            }
            syncHeaderSpacer();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeMenu();
                closeProfileSidebar();
                closeNotificationMenu();
            }
        });

        syncHeaderSpacer();
    })();
</script>
