@php($title = 'Member Dashboard - EasyColoc')

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

        <section class="rounded-3xl border border-cerulean-200 bg-white p-5 shadow-sm md:p-6">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-cerulean-800">Recent Group Expenses</h2>
                <div class="flex items-center gap-2">
                    <form action="{{ route('member.dashboard') }}" method="get" class="flex items-center gap-2">
                        <select name="month" class="h-9 rounded-xl border border-cerulean-200 bg-white px-2 text-xs text-cerulean-800 outline-none focus:border-cerulean-600">
                            <option value="">All months</option>
                            @php($months = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'])
                            @foreach($months as $value => $label)
                                <option value="{{ $value }}" @selected((int) request('month') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>

                        <select name="year" class="h-9 rounded-xl border border-cerulean-200 bg-white px-2 text-xs text-cerulean-800 outline-none focus:border-cerulean-600">
                            <option value="2026" @selected((int) request('year', 2026) === 2026)>2026</option>
                        </select>

                        <button type="submit" class="rounded-lg border border-cerulean-300 bg-white px-2.5 py-1 text-[11px] font-semibold text-cerulean-700 hover:bg-cerulean-100">
                            Filter
                        </button>

                        @if(request('month') && request('year'))
                            <a href="{{ route('member.dashboard') }}" class="rounded-lg border border-cerulean-300 bg-white px-2.5 py-1 text-[11px] font-semibold text-cerulean-700 hover:bg-cerulean-100">
                                Clear
                            </a>
                        @endif
                    </form>
                    <span class="rounded-full border border-cerulean-200 bg-cerulean-50 px-2.5 py-1 text-xs font-semibold text-cerulean-700">
                        {{ request('month') && request('year') ? 'Filtered' : 'Last 5' }}
                    </span>
                </div>
            </div>

            <div class="mt-5 space-y-3">
                @forelse($expenses as $expense)
                    <article class="rounded-2xl border border-cerulean-200 bg-cerulean-50 p-3">
                        <div class="flex items-center gap-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-cerulean-800">{{ $expense->title }}</p>
                                <p class="truncate text-xs text-cerulean-600">
                                    {{ $expense->membership->user->name }}
                                    • {{ $expense->category?->name }}
                                </p>
                            </div>
                            <p class="ml-auto text-sm font-semibold text-cerulean-800">{{ $expense->amount }} MAD</p>
                        </div>
                    </article>
                @empty
                    <p class="text-sm text-cerulean-700">No expenses yet.</p>
                @endforelse
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-2">
            <section class="rounded-3xl border border-cerulean-200 bg-white p-5 shadow-sm md:p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-cerulean-800">Members</h2>
                    <span class="rounded-full border border-cerulean-200 bg-cerulean-50 px-2.5 py-1 text-xs font-semibold text-cerulean-700">Active</span>
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
                    <span class="rounded-full border border-cerulean-200 bg-cerulean-50 px-2.5 py-1 text-xs font-semibold text-cerulean-700">Live</span>
                </div>
                <p class="mt-2 text-xs text-cerulean-700">Debtor is red, creditor is green</p>

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
                                    <form action="{{ route('split.paid') }}" method="post" class="mt-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="owe_id" value="{{ $owe->id }}">
                                        <button type="submit" class="rounded-lg border border-cerulean-300 bg-white px-2.5 py-1 text-[11px] font-semibold text-cerulean-700 hover:bg-cerulean-100">Mark as paid</button>
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

    <div class="fixed bottom-5 right-5 z-40 rounded-2xl border border-cerulean-200 bg-white/95 px-4 py-2 shadow-lg backdrop-blur">
        <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-cerulean-600">My Reputation</p>
        <p class="text-lg font-semibold text-cerulean-800">{{ $reputation }}</p>
    </div>

    <div id="add-expense-modal" class="fixed hidden inset-0 z-50 items-center justify-center bg-cerulean-900/50 p-4">
        <div class="w-full max-w-lg rounded-2xl border border-cerulean-200 bg-white p-5 shadow-xl">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-cerulean-800">Add Expense</h3>
                    <p class="mt-1 text-xs text-cerulean-600">Create a new expense for the group.</p>
                </div>
                <button type="button" data-close-modal class="rounded-lg p-2 text-cerulean-700 hover:bg-cerulean-100">X</button>
            </div>

            <form class="mt-4 grid gap-3 sm:grid-cols-2" action="{{ route('expense.add') }}" method="post">
                @csrf
                <div class="sm:col-span-2">
                    <x-form.input
                        id="expense-title"
                        name="title"
                        label="Title"
                        required
                    />
                </div>

                <div>
                    <x-form.input
                        id="expense-amount"
                        name="amount"
                        label="Amount"
                        type="number"
                        step="0.01"
                        required
                    />
                </div>

                <div>
                    <x-form.input
                        id="expense-date"
                        name="date"
                        label="Date"
                        type="date"
                        required
                    />
                </div>

                <div>
                    <label for="expense-category" class="block text-xs font-medium text-cerulean-800">Category</label>
                    <select id="expense-category" name="category_id" class="mt-2 block h-11 w-full rounded-xl border border-cerulean-200 bg-white px-3 text-sm text-cerulean-800 outline-none focus:border-cerulean-600">
                        <option value="">choose a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-form.error name="category_id" />
                </div>

                <div>
                    <label for="expense-payer" class="block text-xs font-medium text-cerulean-800">Paid By</label>
                    <select id="expense-payer" name="membership_id" class="mt-2 block h-11 w-full rounded-xl border border-cerulean-200 bg-white px-3 text-sm text-cerulean-800 outline-none focus:border-cerulean-600" required>
                        <option value="{{ $membership->id }}" @selected((string) old('membership_id', $membership->id) === (string) $membership->id)>Me</option>
                        @foreach($members as $member)
                            @if($member->id !== $membership->id)
                                <option value="{{ $member->id }}" @selected((string) old('membership_id', $membership->id) === (string) $member->id)>{{ $member->user->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-form.error name="membership_id" />
                </div>

                <div class="sm:col-span-2 flex justify-end gap-2 pt-2">
                    <button type="button" data-close-modal class="rounded-xl border border-cerulean-300 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-50">Cancel</button>
                    <button type="submit" class="rounded-xl bg-cerulean-700 px-4 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Add Expense</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (() => {
            const body = document.body;
            const openers = document.querySelectorAll('[data-open-modal]');
            const closers = document.querySelectorAll('[data-close-modal]');
            const modals = document.querySelectorAll('[id$="-modal"]');

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
