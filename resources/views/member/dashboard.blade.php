@php($title = 'Member Dashboard - EasyColoc')

@extends('layouts.app')

@section('content')
    <div class="w-full space-y-6">
        <section class="rounded-3xl border border-cerulean-200 bg-white p-6 shadow-sm md:p-8">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cerulean-500">
                        {{ $colocation->name }}
                    </p>
                    <h1 class="mt-2 text-3xl font-semibold text-cerulean-800 md:text-4xl">Member Dashboard</h1>
                    <p class="mt-2 max-w-3xl text-sm text-cerulean-700">
                        Track your payments, balance, and the latest group expenses.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        data-open-modal="add-expense-modal"
                        class="inline-flex items-center rounded-xl bg-cerulean-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-cerulean-800"
                    >
                        Add Expense
                    </button>
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
                <p class="mt-3 text-3xl font-semibold text-cerulean-800">
                    {{ $totalOwe }} MAD
                </p>
                <p class="mt-1 text-xs text-cerulean-600">Positive means you owe money</p>
            </article>
        </section>

        <section class="rounded-3xl border border-cerulean-200 bg-white p-5 shadow-sm md:p-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-cerulean-800">Recent Group Expenses</h2>
                <span class="rounded-full border border-cerulean-200 bg-cerulean-50 px-2.5 py-1 text-xs font-semibold text-cerulean-700">Last 5</span>
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
