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
@endsection
