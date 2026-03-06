@php
    $title = 'Member Dashboard - EasyColoc';
@endphp

@extends('layouts.app')

@section('content')
    <div class="w-full space-y-6">
        <section class="rounded-3xl border border-cerulean-200 bg-white p-6 shadow-sm md:p-8">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="flex items-center gap-3">
                    <img src="{{ $colocation->avatar ? asset('storage/' . $colocation->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($colocation->name ?? 'Colocation') . '&background=0369a1&color=ffffff' }}" alt="Colocation logo" class="h-14 w-14 rounded-xl border border-cerulean-200 object-cover">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cerulean-500">
                            {{ $colocation->name }}
                        </p>
                        <h1 class="mt-2 text-3xl font-semibold text-cerulean-800 md:text-4xl">Member Dashboard</h1>
                        <p class="mt-2 max-w-3xl text-sm text-cerulean-700">
                            Track your payments, balance, and the latest group expenses.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        data-open-modal="add-expense-modal"
                        class="inline-flex items-center rounded-xl bg-cerulean-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-cerulean-800"
                    >
                        Add Expense
                    </button>
                    <form method="post" action="{{route('member.quit')}}">
                        @csrf
                        <button
                            type="submit"
                            class="inline-flex items-center rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-100"
                        >
                            Quit Group
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">My Role</p>
                <p class="mt-3 text-3xl font-semibold text-cerulean-800">{{ $membership->role }}</p>
                <p class="mt-1 text-xs text-cerulean-600">Current membership role</p>
            </article>

            <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Total Paid</p>
                <p class="mt-3 text-3xl font-semibold text-cerulean-800">{{ $totalPaid }} MAD</p>
                <p class="mt-1 text-xs text-cerulean-600">Amount you already paid</p>
            </article>

            <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">My Balance</p>
                <p class="mt-3 text-3xl font-semibold {{ $totalOwe < 0 ? 'text-red-600' : ($totalOwe > 0 ? 'text-green-600' : 'text-cerulean-800') }}">
                    {{ $totalOwe }} MAD
                </p>
                <p class="mt-1 text-xs text-cerulean-600">Positive means you owe money</p>
            </article>
        </section>

        <x-dashboard.expenses-list
            section-id="member-dashboard-expenses"
            :expenses="$expenses"
            :membership="$membership"
            :members="$members"
            :filter-action="route('member.dashboard')"
        />

        <div class="grid gap-6 xl:grid-cols-2">
            <section class="rounded-3xl border border-cerulean-200 bg-white p-5 shadow-sm md:p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-cerulean-800">Members</h2>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse($members as $member)
                        <article class="rounded-2xl border border-cerulean-200 bg-cerulean-50 p-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $member->user->avatar ? asset('storage/' . $member->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($member->user->name ?? 'Member') . '&background=0f766e&color=ffffff' }}" alt="Member avatar" class="h-11 w-11 rounded-xl border border-cerulean-200 object-cover">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-cerulean-800">{{ $member->user->name }}</p>
                                    <p class="truncate text-xs text-cerulean-600">Role: {{ $member->role }}</p>
                                </div>
                                <p class="ml-auto text-xs font-semibold text-cerulean-700">Rep: {{ $member->user->reputation }}</p>
                            </div>
                        </article>
                    @empty
                        <p class="text-sm text-cerulean-700">No other active members.</p>
                    @endforelse
                </div>
            </section>

            <section class="rounded-3xl border border-cerulean-200 bg-white p-5 shadow-sm md:p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-cerulean-800">Owes</h2>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse($owes as $owe)
                        <article class="rounded-2xl border border-cerulean-200 bg-cerulean-50 p-3">
                            <div class="flex items-center gap-3">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-red-600">{{ $owe->debuteur?->user?->name ?? 'Member' }}</p>
                                    <p class="truncate text-xs text-cerulean-600">owes</p>
                                    <p class="truncate text-sm font-semibold text-green-600">{{ $owe->crediteur?->user?->name ?? 'Member' }}</p>
                                </div>
                                <div class="ml-auto text-right">
                                    <p class="text-sm font-semibold text-cerulean-800">{{ $owe->part }} MAD</p>
                                    <form action="{{ route('split.paid') }}" method="post" class="mt-1">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="owe_id" value="{{ $owe->id }}">
                                        <button type="submit" class="rounded-lg cursor-pointer   bg-white px-2.5 py-1 text-[11px] font-semibold text-cerulean-700 hover:bg-cerulean-100">Pay Now !</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @empty
                        <p class="text-sm text-cerulean-700">No owes yet.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>

    <x-expenses.form :membership="$membership" :members="$members" :categories="$categories" />

    <script>
        (() => {
            const body = document.body;
            const modalSelector = '[id$="-modal"].fixed.inset-0';
            const openers = document.querySelectorAll('[data-open-modal]');
            const closers = document.querySelectorAll('[data-close-modal]');
            const modals = document.querySelectorAll(modalSelector);

            const closeAll = () => {
                modals.forEach((modal) => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                });
                body.classList.remove('overflow-hidden');
            };

            const openModal = (id) => {
                const modal = document.getElementById(id);
                if (!modal) return;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                body.classList.add('overflow-hidden');
            };

            openers.forEach((button) => {
                button.addEventListener('click', () => {
                    openModal(button.dataset.openModal);
                });
            });

            closers.forEach((button) => {
                button.addEventListener('click', closeAll);
            });

            modals.forEach((modal) => {
                modal.addEventListener('click', (event) => {
                    if (event.target === modal) {
                        closeAll();
                    }
                });
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeAll();
                }
            });
        })();
    </script>
@endsection
