@php($title = 'Main - EasyColoc')

@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full max-w-7xl space-y-6 px-2 md:px-4">
        <section class="rounded-3xl border border-cerulean-200 bg-white p-6 shadow-sm md:p-10">
            <div class="grid gap-6 lg:grid-cols-[1.35fr_1fr] lg:items-center">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-cerulean-600">EasyColoc Platform</p>
                    <h1 class="mt-3 text-3xl font-bold leading-tight text-cerulean-900 md:text-5xl">
                        @auth
                            Welcome back, {{ auth()->user()->name }}
                        @else
                            Shared living, organized.
                        @endauth
                    </h1>
                    <p class="mt-4 max-w-2xl text-sm leading-relaxed text-cerulean-700 md:text-base">
                        Keep your colocation expenses, balances, and actions in one place with a clean workflow for everyone.
                    </p>

                    <div class="mt-7 flex flex-wrap gap-3">
                        @auth

                                <a href="{{ route('member.dashboard') }}" class="inline-flex items-center rounded-xl bg-cerulean-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-cerulean-800">Dashboard</a>
                             @endauth
                        <a href="#overview" class="inline-flex items-center rounded-xl border border-cerulean-300 bg-white px-6 py-3 text-sm font-semibold text-cerulean-700 transition hover:bg-cerulean-50">
                            Explore
                        </a>
                    </div>
                </div>

                <aside class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cerulean-500">Current Status</p>
                    <div class="mt-3 inline-flex rounded-full border border-cerulean-300 bg-cerulean-50 px-3 py-1 text-xs font-semibold text-cerulean-700">
                        @auth
                            @if (auth()->user()->role === 'admin')
                                Admin
                            @elseif (auth()->user()->membership?->role === 'owner')
                                Owner
                            @elseif (auth()->user()->membership?->role === 'member')
                                Member
                            @else
                                No Active Colocation
                            @endif
                        @else
                            Guest
                        @endauth
                    </div>
                    <div class="mt-5 space-y-3 text-sm text-cerulean-700">
                        <div class="rounded-xl border border-cerulean-200 bg-white px-3 py-2">Create or join a colocation in minutes.</div>
                        <div class="rounded-xl border border-cerulean-200 bg-white px-3 py-2">Track expenses transparently for the whole group.</div>
                        <div class="rounded-xl border border-cerulean-200 bg-white px-3 py-2">Move directly to your dashboard from here.</div>
                    </div>
                </aside>
            </div>
        </section>

        <section id="overview" class="grid gap-4 md:grid-cols-3">
            <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-500">Step 01</p>
                <h2 class="mt-2 text-lg font-semibold text-cerulean-900">Create a Group</h2>
                <p class="mt-2 text-sm text-cerulean-700">Set up your shared place and define how your household works.</p>
            </article>
            <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-500">Step 02</p>
                <h2 class="mt-2 text-lg font-semibold text-cerulean-900">Add Expenses</h2>
                <p class="mt-2 text-sm text-cerulean-700">Record spending with clarity so everyone sees the same numbers.</p>
            </article>
            <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-500">Step 03</p>
                <h2 class="mt-2 text-lg font-semibold text-cerulean-900">Settle Up</h2>
                <p class="mt-2 text-sm text-cerulean-700">Track what is paid and close balances without confusion.</p>
            </article>
        </section>

        <section class="rounded-3xl border border-cerulean-200 bg-white p-6 shadow-sm md:p-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cerulean-500">Quick Access</p>
                    <h2 class="mt-2 text-2xl font-semibold text-cerulean-900 md:text-3xl">Ready to continue?</h2>
                </div>
                @auth
                        <a href="{{ route('member.dashboard') }}" class="inline-flex items-center rounded-xl bg-cerulean-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-cerulean-800">Dashboard</a>
                @endauth
            </div>
        </section>
    </div>
@endsection
