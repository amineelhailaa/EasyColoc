@php($title = 'Admin Dashboard - EasyColoc')

@extends('layouts.app')

@section('content')
    <div class="w-full space-y-6">
        <section class="rounded-3xl border border-cerulean-200 bg-white p-6 shadow-sm md:p-8">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="flex items-center gap-3">
                    <img src="{{ $admin->avatar ? asset('storage/' . $admin->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($admin->name ?? 'Admin') . '&background=0369a1&color=ffffff' }}" alt="Admin avatar" class="h-14 w-14 rounded-xl border border-cerulean-200 object-cover">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cerulean-500">Administration</p>
                        <h1 class="mt-2 text-3xl font-semibold text-cerulean-800 md:text-4xl">Admin Dashboard</h1>
                        <p class="mt-2 max-w-3xl text-sm text-cerulean-700">
                            Monitor platform metrics and manage user access.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Users</p>
                <p class="mt-3 text-3xl font-semibold text-cerulean-800">{{ $users->count() }}</p>
                <p class="mt-1 text-xs text-cerulean-600">Registered users (without you)</p>
            </article>

            <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Colocations</p>
                <p class="mt-3 text-3xl font-semibold text-cerulean-800">{{ $colocations->count() }}</p>
                <p class="mt-1 text-xs text-cerulean-600">Total groups</p>
            </article>

            <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Revenue</p>
                <p class="mt-3 text-3xl font-semibold text-cerulean-800">{{ $chiffreDaffaire }} MAD</p>
                <p class="mt-1 text-xs text-cerulean-600">All expenses amount</p>
            </article>

            <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Active Members</p>
                <p class="mt-3 text-3xl font-semibold text-cerulean-800">{{ $usersWithMembershipActive }}</p>
                <p class="mt-1 text-xs text-cerulean-600">Users with active membership</p>
            </article>

            <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">No Membership</p>
                <p class="mt-3 text-3xl font-semibold text-cerulean-800">{{ $usersWithNoMembership }}</p>
                <p class="mt-1 text-xs text-cerulean-600">Users without active membership</p>
            </article>
        </section>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_340px]">
            <section class="rounded-3xl border border-cerulean-200 bg-white p-5 shadow-sm md:p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-cerulean-800">Users</h2>
                    <span class="rounded-full border border-cerulean-200 bg-cerulean-50 px-2.5 py-1 text-xs font-semibold text-cerulean-700">Manage Access</span>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse($users as $user)
                        <article class="rounded-2xl border border-cerulean-200 bg-cerulean-50 p-3">
                            <div class="flex flex-wrap items-center gap-3">
                                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&background=0f766e&color=ffffff' }}" alt="User avatar" class="h-11 w-11 rounded-xl border border-cerulean-200 object-cover">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-cerulean-800">{{ $user->name }}</p>
                                    <p class="truncate text-xs text-cerulean-600">{{ $user->email }}</p>
                                </div>

                                <span class="ml-auto rounded-full border px-2.5 py-1 text-[11px] font-semibold {{ $user->ban ? 'border-cerulean-300 bg-white text-cerulean-800' : 'border-cerulean-200 bg-cerulean-100 text-cerulean-700' }}">
                                    {{ $user->ban ? 'Banned' : 'Active' }}
                                </span>

                                @if($user->ban)
                                    <form method="POST" action="{{ route('admin.unban', $user) }}" onsubmit="return confirm('Unban this user?');">
                                        @csrf
                                        @method('PATCH')
                                        <x-button variant="primary" class="!h-9 !w-auto rounded-lg px-3 py-1.5 text-xs">
                                            Unban
                                        </x-button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.ban', $user) }}" onsubmit="return confirm('Ban this user?');">
                                        @csrf
                                        @method('PATCH')
                                        <x-button variant="secondary" class="!h-9 !w-auto rounded-lg px-3 py-1.5 text-xs">
                                            Ban
                                        </x-button>
                                    </form>
                                @endif
                            </div>
                        </article>
                    @empty
                        <p class="text-sm text-cerulean-700">No users found.</p>
                    @endforelse
                </div>
            </section>

            <aside class="rounded-3xl border border-cerulean-200 bg-white p-5 shadow-sm md:p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-cerulean-800">Colocations</h2>
                    <span class="rounded-full border border-cerulean-200 bg-cerulean-50 px-2.5 py-1 text-xs font-semibold text-cerulean-700">Details</span>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse($colocations as $group)
                        <article class="rounded-2xl border border-cerulean-200 bg-cerulean-50 p-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $group->avatar ? asset('storage/' . $group->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($group->name ?? 'Colocation') . '&background=0369a1&color=ffffff' }}" alt="Colocation avatar" class="h-10 w-10 rounded-xl border border-cerulean-200 object-cover">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-cerulean-800">{{ $group->name }}</p>
                                    <p class="truncate text-xs text-cerulean-600">ID: {{ $group->id }}</p>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-cerulean-700">{{ $group->description }}</p>
                        </article>
                    @empty
                        <p class="text-sm text-cerulean-700">No colocations found.</p>
                    @endforelse
                </div>
            </aside>
        </div>
    </div>
@endsection
