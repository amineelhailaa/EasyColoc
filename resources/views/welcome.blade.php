<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasyColoc</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-b from-cerulean-100 via-cerulean-50 to-cerulean-100 text-cerulean-900">
<header class="border-b border-cerulean-200/70 bg-white/70 backdrop-blur">
    <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 md:px-8">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-cerulean-700 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 11.5L12 4l9 7.5"/>
                        <path d="M5 10.5V20h14v-9.5"/>
                        <path d="M10 20v-5h4v5"/>
                    </svg>
                </span>
            <span class="text-xl font-semibold tracking-tight text-cerulean-800">EasyColoc</span>
        </a>

        <nav class="hidden items-center gap-6 text-sm font-medium text-cerulean-700 lg:flex">
            <a href="#features" class="transition hover:text-cerulean-900">Tracking</a>
            <a href="#features" class="transition hover:text-cerulean-900">Categories</a>
            <a href="#features" class="transition hover:text-cerulean-900">Balances</a>
            <a href="#features" class="transition hover:text-cerulean-900">Invitations</a>
        </nav>

        <div class="flex items-center gap-2">
            @auth
                <a href="{{ url('/test') }}" class="rounded-full bg-cerulean-700 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-cerulean-800">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="rounded-full border border-cerulean-300 px-4 py-2 text-sm font-semibold text-cerulean-700 transition hover:bg-cerulean-50">Login</a>
                <a href="{{ route('register') }}" class="rounded-full bg-cerulean-700 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-cerulean-800">Sign up</a>
            @endauth
        </div>
    </div>
</header>

<main id="features" class="relative overflow-hidden">
    <div class="pointer-events-none absolute -left-32 top-12 h-80 w-80 rounded-full bg-cerulean-200/65 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-28 bottom-10 h-96 w-96 rounded-full bg-cerulean-100 blur-3xl"></div>

    <section class="mx-auto grid min-h-[calc(100vh-81px)] w-full max-w-7xl gap-10 px-4 py-10 md:px-8 lg:grid-cols-[1.05fr_0.95fr] lg:items-center lg:py-14">
        <div>
            <h1 class="max-w-xl text-4xl font-bold leading-tight text-cerulean-900 md:text-5xl lg:text-6xl">
                Best way to track
                <span class="bg-gradient-to-r from-cerulean-700 to-cerulean-400 bg-clip-text text-transparent">shared money</span>
            </h1>

            <p class="mt-5 max-w-lg text-sm leading-7 text-cerulean-700 md:text-base">
                EasyColoc centralizes shared expenses, computes balances instantly, and turns complex reimbursement math into a clear action plan for every roommate.
            </p>

            <div class="mt-7 flex flex-wrap items-center gap-3">
                @auth
                    <a href="{{ url('/test') }}" class="rounded-full bg-cerulean-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-cerulean-800">Open your dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="rounded-full bg-cerulean-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-cerulean-800">Get started</a>
                    <a href="{{ route('login') }}" class="rounded-full border border-cerulean-300 px-5 py-2.5 text-sm font-semibold text-cerulean-700 transition hover:bg-cerulean-50">I already have an account</a>
                @endauth
            </div>

            <div class="mt-9 flex flex-wrap items-center gap-6 text-sm text-cerulean-600">
                <div class="inline-flex items-center gap-2">
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-cerulean-100 text-cerulean-700">iOS</span>
                    App Store
                </div>
                <div class="inline-flex items-center gap-2">
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-cerulean-100 text-cerulean-700">GP</span>
                    Google Play
                </div>
            </div>
        </div>

        <div class="relative lg:h-[33rem]">
            <div class="rounded-3xl border border-cerulean-200/80 bg-white/95 p-5 shadow-xl shadow-cerulean-900/10 backdrop-blur">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs text-cerulean-500">Income</p>
                        <p class="mt-1 text-sm font-semibold text-cerulean-800">June Overview</p>
                    </div>
                    <span class="rounded-full bg-cerulean-100 px-3 py-1 text-xs font-semibold text-cerulean-700">+12.4%</span>
                </div>

                <div class="mt-5 rounded-2xl bg-cerulean-50 p-4">
                    <svg viewBox="0 0 280 120" class="h-36 w-full" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 92C38 90 48 46 74 50C98 54 108 98 132 98C156 98 166 38 194 38C220 38 236 74 272 70" stroke="url(#lineGradient)" stroke-width="4" stroke-linecap="round"/>
                        <circle cx="132" cy="98" r="6" fill="#5295AD"/>
                        <circle cx="194" cy="38" r="6" fill="#41778B"/>
                        <defs>
                            <linearGradient id="lineGradient" x1="8" y1="60" x2="272" y2="60" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#97BFCE"/>
                                <stop offset="1" stop-color="#315968"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    <div class="mt-2 flex items-center justify-between text-[11px] text-cerulean-500">
                        <span>Mar</span>
                        <span>Apr</span>
                        <span>May</span>
                        <span class="font-semibold text-cerulean-700">Jun</span>
                        <span>Jul</span>
                    </div>
                </div>
            </div>

            <div class="absolute -right-1 top-10 w-36 rounded-2xl border border-cerulean-200 bg-white p-4 shadow-xl shadow-cerulean-900/10 md:w-40">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-cerulean-100 text-xl text-cerulean-700">💸</span>
                <p class="mt-3 text-xs font-semibold text-cerulean-800">Easy Payment</p>
                <p class="mt-1 text-[11px] text-cerulean-500">One tap settlement</p>
            </div>

            <div class="absolute -right-3 top-44 w-64 rounded-2xl bg-gradient-to-br from-cerulean-700 via-cerulean-500 to-cerulean-300 p-5 text-white shadow-2xl shadow-cerulean-900/20">
                <p class="text-xs uppercase tracking-[0.22em] text-white/80">EasyColoc Card</p>
                <p class="mt-7 text-2xl font-semibold">$2,846.20</p>
                <div class="mt-5 flex items-end justify-between text-xs text-white/90">
                    <span>**** 4678</span>
                    <span>06/29</span>
                </div>
            </div>

            <div class="absolute bottom-4 right-10 rounded-xl border border-cerulean-200 bg-white p-3 shadow-lg shadow-cerulean-900/10">
                <p class="text-xs font-semibold text-cerulean-800">Latest payer</p>
                <p class="mt-1 text-sm text-cerulean-600">Yassine Fadil</p>
                <p class="mt-1 text-xs font-semibold text-cerulean-700">+ 264.50</p>
            </div>
        </div>
    </section>
</main>
</body>
</html>
