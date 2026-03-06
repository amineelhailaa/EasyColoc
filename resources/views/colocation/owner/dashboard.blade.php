@php
    $title = 'Owner Dashboard - EasyColoc';
@endphp

@extends('layouts.app')

@push('head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .owner-dashboard-font {
            font-family: "Plus Jakarta Sans", ui-sans-serif, system-ui, sans-serif;
            touch-action: pan-y pinch-zoom;
            scroll-snap-type: none;
        }

        .owner-add-expense-fab {
            bottom: calc(env(safe-area-inset-bottom, 0px) + 0.9rem);
            right: calc(env(safe-area-inset-right, 0px) + 0.9rem);
        }

        .owner-x-scroll {
            overflow-x: auto;
            overflow-y: visible;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior-x: contain;
            overscroll-behavior-y: auto;
            touch-action: pan-x pan-y;
            scroll-snap-type: none;
        }

        .owner-modal-shell {
            align-items: flex-start;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior-y: contain;
            touch-action: pan-y pinch-zoom;
            padding: 0.75rem;
        }

        .owner-modal-panel {
            max-height: 90vh;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior-y: contain;
            touch-action: pan-y pinch-zoom;
            scroll-snap-type: none;
        }

        @supports (height: 100dvh) {
            .owner-modal-panel {
                max-height: calc(100dvh - 1.5rem);
            }
        }

        @media (min-width: 640px) {
            .owner-add-expense-fab {
                bottom: calc(env(safe-area-inset-bottom, 0px) + 1.25rem);
                right: calc(env(safe-area-inset-right, 0px) + 1.25rem);
            }

            .owner-modal-shell {
                align-items: center;
                padding: 1rem;
            }

            @supports (height: 100dvh) {
                .owner-modal-panel {
                    max-height: calc(100dvh - 2rem);
                }
            }
        }
    </style>
@endpush

@section('content')
    @php
        $authUser = auth()->user();

        $colocation = $colocation ?? (object) [
            'name' => 'Google',
            'title' => 'Google',
            'avatar' => null,
        ];

        $membership = $membership ?? (object) [
            'id' => 0,
            'role' => 'owner',
            'user' => (object) [
                'name' => ($authUser->name ?? 'Owner'),
                'email' => ($authUser->email ?? 'owner@example.com'),
                'avatar' => null,
                'reputation' => 0,
            ],
        ];

        if (!isset($members)) {
            $members = collect([
                (object) [
                    'id' => 101,
                    'role' => 'member',
                    'user' => (object) [
                        'name' => 'Participant A',
                        'email' => 'participant-a@example.com',
                        'avatar' => null,
                        'reputation' => 0,
                    ],
                    'created_at' => now(),
                    'left_at' => null,
                    'total_paid_expenses' => 0,
                ],
                (object) [
                    'id' => 102,
                    'role' => 'member',
                    'user' => (object) [
                        'name' => 'Participant B',
                        'email' => 'participant-b@example.com',
                        'avatar' => null,
                        'reputation' => 0,
                    ],
                    'created_at' => now(),
                    'left_at' => null,
                    'total_paid_expenses' => 0,
                ],
            ]);
        } else {
            $members = collect($members);
        }

        if (!isset($categories)) {
            $categories = collect([
                (object) ['id' => 1, 'name' => 'Food'],
                (object) ['id' => 2, 'name' => 'Transport'],
                (object) ['id' => 3, 'name' => 'Utilities'],
            ]);
        } else {
            $categories = collect($categories);
        }

        if (!isset($expenses)) {
            $expenses = collect([
                (object) [
                    'title' => 'Dinner',
                    'amount' => 120.00,
                    'date' => now()->toDateString(),
                    'membership' => $membership,
                    'category' => (object) ['name' => 'Food'],
                ],
                (object) [
                    'title' => 'Taxi',
                    'amount' => 45.00,
                    'date' => now()->subDay()->toDateString(),
                    'membership' => $membership,
                    'category' => (object) ['name' => 'Transport'],
                ],
            ]);
        } else {
            $expenses = collect($expenses);
        }

        $owes = collect($owes ?? []);
        $totalMembers = $totalMembers ?? ($members->count() + 1);
        $totalSpent = $totalSpent ?? number_format((float) $expenses->sum('amount'), 2, '.', '');
        $totalExpenses = $totalExpenses ?? $expenses->count();
        $totalCategories = $totalCategories ?? $categories->count();
        $myBalance = $myBalance ?? 0;
        $expenseLastDays = $expenseLastDays ?? [];
        $expenseDateLabels = $expenseDateLabels ?? [];
        $expenseDateFullLabels = $expenseDateFullLabels ?? [];
        $expenseLast30Total = $expenseLast30Total ?? 0;
        $expensePeriodLabel = $expensePeriodLabel ?? 'Last 30 days';
    @endphp

    <div data-dashboard-scroll-root class="owner-dashboard-font w-full space-y-5 overflow-x-hidden">
        <section class="py-1">
            <div class="flex items-center gap-3">
                <img src="{{ $colocation->avatar ? asset('storage/' . $colocation->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($colocation->name ?? 'Colocation') . '&background=0369a1&color=ffffff' }}" alt="Colocation logo" class="h-12 w-12 rounded-lg border border-cerulean-200 object-cover">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cerulean-600">{{ $colocation->name ?? $colocation->title }}</p>
                    <p class="mt-1 text-sm text-cerulean-700">Welcome back, <span class="font-bold text-cerulean-900">{{ $authUser->name ?? 'Owner' }}</span></p>
                </div>
            </div>
        </section>

        <livewire:owner.management-tabs :members="$members" :categories="$categories" />

        <div id="global-dashboard-content" class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
            <div class="space-y-6">
                <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    <article class="rounded-xl border border-cerulean-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-2">
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Members</p>
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-md bg-cerulean-100 text-cerulean-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                    <circle cx="8.5" cy="7" r="4"/>
                                    <path d="M20 8v6"/>
                                    <path d="M23 11h-6"/>
                                </svg>
                            </span>
                        </div>
                        <p class="mt-3 text-4xl font-extrabold text-cerulean-800">{{ $totalMembers }}</p>
                    </article>

                    <article class="rounded-xl border border-cerulean-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-2">
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Total Spent</p>
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-md bg-cerulean-100 text-cerulean-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="6" width="20" height="12" rx="2"/>
                                    <path d="M2 10h20"/>
                                </svg>
                            </span>
                        </div>
                        <div class="mt-3 flex items-end gap-1 text-cerulean-800">
                            <p class="text-3xl font-extrabold leading-none xl:text-4xl">{{ $totalSpent }}</p>
                            <span class="pb-0.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-cerulean-600 sm:text-[11px]">MAD</span>
                        </div>
                    </article>

                    <article class="rounded-xl border border-cerulean-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-2">
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">My Balance</p>
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-md bg-cerulean-100 text-cerulean-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 1v22"/>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                </svg>
                            </span>
                        </div>
                        <div class="mt-3 flex items-end gap-1">
                            <p class="text-4xl font-extrabold {{ $myBalance > 0 ? 'text-green-600' : ($myBalance < 0 ? 'text-red-600' : 'text-slate-700') }}">{{ $myBalance }}</p>
                            <span class="pb-0.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-cerulean-600 sm:text-[11px]">MAD</span>
                        </div>
                    </article>

                    <article class="rounded-xl border border-cerulean-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-2">
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Categories</p>
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-md bg-cerulean-100 text-cerulean-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 7H4"/>
                                    <path d="M20 12H4"/>
                                    <path d="M20 17H4"/>
                                </svg>
                            </span>
                        </div>
                        <p class="mt-3 text-4xl font-extrabold text-cerulean-800">{{ $totalCategories }}</p>
                    </article>

                    <article class="rounded-xl border border-cerulean-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-2">
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Expenses</p>
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-md bg-cerulean-100 text-cerulean-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                                    <path d="M7 8h10"/>
                                    <path d="M7 12h10"/>
                                    <path d="M7 16h6"/>
                                </svg>
                            </span>
                        </div>
                        <p class="mt-3 text-4xl font-extrabold text-cerulean-800">{{ $totalExpenses }}</p>
                    </article>
                </section>

                <section class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm md:p-6">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Expenses Trend</p>
                            <div class="mt-1 flex items-baseline gap-2">
                                <p class="text-3xl font-semibold text-cerulean-800">{{ number_format((float) ($expenseLast30Total ?? 0), 2, '.', '') }}</p>
                                <p class="text-sm font-medium text-cerulean-700">MAD</p>
                            </div>
                            <p class="mt-1 text-xs text-cerulean-700">{{ $expensePeriodLabel ?? 'Last 30 days' }}</p>
                        </div>

                    </div>
                    <div class="mt-4 rounded-xl border border-cerulean-200 bg-white p-4 shadow-inner">
                        <div id="ownerWeeklyExpenseChart" class="h-56 p-0 sm:h-64"></div>
                    </div>
                </section>

            </div>

            <aside class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm md:p-6">
                <div class="flex items-center justify-between gap-2">
                    <h2 class="text-xl font-semibold text-cerulean-800">Owes</h2>
                    <div class="flex items-center gap-2">
                        <span class="rounded-full border border-cerulean-200 bg-cerulean-50 px-2.5 py-1 text-xs font-semibold text-cerulean-700">Live</span>
                    </div>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse($owes as $owe)
                        <article class="rounded-xl border border-cerulean-200 bg-cerulean-50 p-3">
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
                                        <button type="submit" class="rounded-md border border-cerulean-300 bg-white px-2.5 py-1 text-[11px] font-semibold text-cerulean-700 hover:bg-cerulean-100">Mark as paid</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-xl border border-dashed border-cerulean-200 bg-cerulean-50 px-4 py-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-8 w-8 text-cerulean-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 3h18v18H3z"/>
                                <path d="M8 12h8"/>
                            </svg>
                            <p class="mt-3 text-sm font-semibold text-cerulean-800">No owes yet</p>
                            <p class="mt-1 text-xs text-cerulean-600">Everything is settled for now.</p>
                        </div>
                    @endforelse
                </div>
            </aside>
        </div>

        <x-dashboard.expenses-list
            section-id="global-dashboard-expenses"
            :expenses="$expenses"
            :membership="$membership"
            :members="$members"
            :filter-action="route('owner.dashboard')"
        />
    </div>

    <button
        id="global-dashboard-add-expense"
        type="button"
        data-open-modal="add-expense-modal"
        class="owner-add-expense-fab fixed z-50 inline-flex h-12 w-12 items-center justify-center rounded-full bg-cerulean-700 text-white shadow-lg transition hover:bg-cerulean-800 sm:h-14 sm:w-14"
        aria-label="Add Expense"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14"/>
            <path d="M5 12h14"/>
        </svg>
    </button>

    <div id="add-category-modal" class="fixed inset-0 z-50 hidden justify-center bg-cerulean-900/50 owner-modal-shell">
        <div class="owner-modal-panel w-full max-w-md rounded-xl border border-cerulean-200 bg-white p-5 shadow-xl">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-cerulean-800">Add Category</h3>
                    <p class="mt-1 text-xs text-cerulean-600">Create a new category for the group.</p>
                </div>
                <button type="button" data-close-modal class="rounded-md p-2 text-cerulean-700 hover:bg-cerulean-100">X</button>
            </div>

            <form class="mt-4 space-y-3" action="{{ route('owner.category.add') }}" method="post">
                @csrf
                <x-form.input
                    id="category-name"
                    name="name"
                    label="Name"
                    required
                />

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" data-close-modal class="rounded-lg border border-cerulean-300 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-50">Cancel</button>
                    <button type="submit" class="rounded-lg bg-cerulean-700 px-4 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Add Category</button>
                </div>
            </form>
        </div>
    </div>

    <div id="edit-category-modal" class="fixed inset-0 z-50 hidden justify-center bg-cerulean-900/50 owner-modal-shell">
        <div class="owner-modal-panel w-full max-w-md rounded-xl border border-cerulean-200 bg-white p-5 shadow-xl">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-cerulean-800">Edit Category</h3>
                    <p class="mt-1 text-xs text-cerulean-600">Update category information.</p>
                </div>
                <button type="button" data-close-modal class="rounded-md p-2 text-cerulean-700 hover:bg-cerulean-100">X</button>
            </div>

            <form class="mt-4 space-y-3">
                <x-form.input
                    id="edit-category-name"
                    name="name"
                    label="Category Name"
                />

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" data-close-modal class="rounded-lg border border-cerulean-300 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-50">Cancel</button>
                    <button type="button" class="rounded-lg bg-cerulean-700 px-4 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div id="delete-category-modal" class="fixed inset-0 z-50 hidden justify-center bg-cerulean-900/50 owner-modal-shell">
        <div class="owner-modal-panel w-full max-w-md rounded-xl border border-cerulean-200 bg-white p-5 shadow-xl">
            <h3 class="text-lg font-semibold text-cerulean-800">Delete Category</h3>
            <p class="mt-2 text-sm text-cerulean-700">
                Are you sure you want to delete
                <span id="delete-category-name" class="font-semibold text-cerulean-800">this category</span>?
            </p>

            <form
                id="delete-category-form"
                class="mt-5 flex justify-end gap-2"
                method="post"
                data-action-template="{{ route('owner.category.delete', ['category' => '__CATEGORY__']) }}"
            >
                @csrf
                @method('DELETE')
                <button type="button" data-close-modal class="rounded-lg border border-cerulean-300 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-50">Cancel</button>
                <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-100">Delete</button>
            </form>
        </div>
    </div>

    <x-expenses.form :membership="$membership" :members="$members" :categories="$categories" />

    <div id="invite-member-modal" class="fixed inset-0 z-50 hidden justify-center bg-cerulean-900/50 owner-modal-shell">
        <div class="owner-modal-panel w-full max-w-md rounded-xl border border-cerulean-200 bg-white p-5 shadow-xl">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-cerulean-800">Invite Member</h3>
                    <p class="mt-1 text-xs text-cerulean-600">Send an invitation email to join this group.</p>
                </div>
                <button type="button" data-close-modal class="rounded-md p-2 text-cerulean-700 hover:bg-cerulean-100">X</button>
            </div>

            <form class="mt-4 space-y-4" action="{{ route('invitation.send') }}" method="post">
                @csrf
                <x-form.input
                    id="invite-email"
                    name="email"
                    type="email"
                    label="Member Email"
                    placeholder="name@example.com"
                    autocomplete="email"
                    required
                />

                <div class="flex justify-end gap-2 pt-1">
                    <button type="button" data-close-modal class="rounded-lg border border-cerulean-300 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-50">Cancel</button>
                    <button type="submit" class="rounded-lg bg-cerulean-700 px-4 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Send Invite</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (() => {
            const dashboardContent = document.getElementById('global-dashboard-content');
            const recentExpenses = document.getElementById('global-dashboard-expenses');
            const addExpenseButton = document.getElementById('global-dashboard-add-expense');

            if (!dashboardContent) {
                return;
            }

            const toggleDashboardVisibility = (tab) => {
                const isDashboardTab = tab === 'dashboard';
                dashboardContent.classList.toggle('hidden', !isDashboardTab);

                if (recentExpenses) {
                    recentExpenses.classList.toggle('hidden', !isDashboardTab);
                }

                if (addExpenseButton) {
                    addExpenseButton.classList.toggle('hidden', !isDashboardTab);
                }
            };

            const closeMoreMenus = () => {
                const moreMenus = document.querySelectorAll('[data-more-menu]');
                const moreToggles = document.querySelectorAll('[data-more-toggle]');

                moreMenus.forEach((menu) => {
                    menu.classList.add('hidden');
                });

                moreToggles.forEach((toggle) => {
                    toggle.setAttribute('aria-expanded', 'false');
                });
            };

            const toggleMoreMenu = (toggleButton) => {
                const wrapper = toggleButton.parentElement;
                const menu = wrapper ? wrapper.querySelector('[data-more-menu]') : null;

                if (!menu) {
                    return;
                }

                const shouldOpen = menu.classList.contains('hidden');
                closeMoreMenus();

                if (shouldOpen) {
                    menu.classList.remove('hidden');
                    toggleButton.setAttribute('aria-expanded', 'true');
                }
            };

            const updateTabUi = (tab) => {
                const tabButtons = document.querySelectorAll('[data-tab-btn]');
                const moreTabButtons = document.querySelectorAll('[data-tab-more]');
                const tabPanels = document.querySelectorAll('[data-tab-panel]');
                const isMoreActive = tab === 'roles' || tab === 'settings';

                moreTabButtons.forEach((button) => {
                    button.classList.toggle('bg-cerulean-700', isMoreActive);
                    button.classList.toggle('text-white', isMoreActive);
                    button.classList.toggle('hover:bg-cerulean-800', isMoreActive);
                    button.classList.toggle('border-transparent', isMoreActive);

                    button.classList.toggle('border', !isMoreActive);
                    button.classList.toggle('border-cerulean-300', !isMoreActive);
                    button.classList.toggle('bg-white', !isMoreActive);
                    button.classList.toggle('text-cerulean-700', !isMoreActive);
                    button.classList.toggle('hover:bg-cerulean-100', !isMoreActive);
                });

                tabButtons.forEach((button) => {
                    const isActive = button.dataset.tabBtn === tab;
                    const isMenuButton = button.hasAttribute('data-tab-menu');

                    if (isMenuButton) {
                        button.classList.toggle('bg-cerulean-700', isActive);
                        button.classList.toggle('text-white', isActive);
                        button.classList.toggle('hover:bg-cerulean-800', isActive);
                        button.classList.toggle('text-cerulean-700', !isActive);
                        button.classList.toggle('hover:bg-cerulean-100', !isActive);
                        return;
                    }

                    button.classList.toggle('bg-cerulean-700', isActive);
                    button.classList.toggle('text-white', isActive);
                    button.classList.toggle('hover:bg-cerulean-800', isActive);
                    button.classList.toggle('border-transparent', isActive);

                    button.classList.toggle('border', !isActive);
                    button.classList.toggle('border-cerulean-300', !isActive);
                    button.classList.toggle('bg-white', !isActive);
                    button.classList.toggle('text-cerulean-700', !isActive);
                    button.classList.toggle('hover:bg-cerulean-100', !isActive);
                });

                tabPanels.forEach((panel) => {
                    panel.classList.toggle('hidden', panel.dataset.tabPanel !== tab);
                });
            };

            const applyTab = (tab) => {
                updateTabUi(tab);
                toggleDashboardVisibility(tab);
                closeMoreMenus();
            };

            const handleTabChange = (event) => {
                applyTab(event?.detail?.tab || 'dashboard');
            };

            document.addEventListener('click', (event) => {
                const moreToggle = event.target.closest('[data-more-toggle]');
                if (moreToggle) {
                    toggleMoreMenu(moreToggle);
                    return;
                }

                const tabButton = event.target.closest('[data-tab-btn]');
                if (tabButton) {
                    applyTab(tabButton.dataset.tabBtn || 'dashboard');
                    return;
                }

                const clickedInsideMenu = event.target.closest('[data-more-menu]');
                if (!clickedInsideMenu) {
                    closeMoreMenus();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeMoreMenus();
                }
            });

            window.addEventListener('global-tab-changed', handleTabChange);
            document.addEventListener('global-tab-changed', handleTabChange);
            applyTab('dashboard');
        })();
    </script>

    <script>
        (() => {
            const rawSeries = @json(array_values($expenseLastDays ?? []));
            const rawLabels = @json(array_values($expenseDateLabels ?? []));
            const rawFullLabels = @json(array_values($expenseDateFullLabels ?? []));
            const expenseSeries = Array.isArray(rawSeries)
                ? rawSeries.map((value) => Number(value) || 0)
                : [];
            const fallbackSeries = Array.from({ length: 30 }, () => 0);
            const finalSeries = expenseSeries.length ? expenseSeries : fallbackSeries;
            const fallbackLabels = Array.from({ length: finalSeries.length }, (_, index) => `Day ${index + 1}`);
            const finalLabels = Array.isArray(rawLabels) && rawLabels.length === finalSeries.length
                ? rawLabels
                : fallbackLabels;
            const finalFullLabels = Array.isArray(rawFullLabels) && rawFullLabels.length === finalSeries.length
                ? rawFullLabels
                : finalLabels;
            const getVisibleCount = () => {
                if (window.innerWidth < 480) return 5;
                if (window.innerWidth < 768) return 7;
                if (window.innerWidth < 1024) return 12;
                return finalSeries.length;
            };
            const getChartConfig = () => {
                if (window.innerWidth < 480) {
                    return { height: 190, tickAmount: 5, rotate: 0, fontSize: '10px', columnWidth: '56%', showYaxis: false };
                }
                if (window.innerWidth < 768) {
                    return { height: 205, tickAmount: 7, rotate: -25, fontSize: '10px', columnWidth: '58%', showYaxis: false };
                }
                if (window.innerWidth < 1024) {
                    return { height: 220, tickAmount: 8, rotate: -35, fontSize: '10px', columnWidth: '60%', showYaxis: true };
                }
                return { height: 240, tickAmount: 10, rotate: -45, fontSize: '11px', columnWidth: '62%', showYaxis: true };
            };

            const getScreenSeries = () => {
                const visibleCount = getVisibleCount();
                return finalSeries.slice(-visibleCount);
            };
            const getScreenLabels = () => {
                const visibleCount = getVisibleCount();
                return finalLabels.slice(-visibleCount);
            };
            const getScreenFullLabels = () => {
                const visibleCount = getVisibleCount();
                return finalFullLabels.slice(-visibleCount);
            };

            const renderChart = () => {
                const chartElement = document.querySelector('#ownerWeeklyExpenseChart');
                if (!chartElement || typeof ApexCharts === 'undefined') {
                    return;
                }
                const chartConfig = getChartConfig();

                const options = {
                    chart: {
                        type: 'bar',
                        height: chartConfig.height,
                        toolbar: { show: false },
                        sparkline: { enabled: false },
                    },
                    series: [{ name: 'Expense', data: getScreenSeries() }],
                    plotOptions: {
                        bar: {
                            columnWidth: chartConfig.columnWidth,
                            borderRadius: 4,
                        },
                    },
                    dataLabels: { enabled: false },
                    xaxis: {
                        categories: getScreenLabels(),
                        tickAmount: chartConfig.tickAmount,
                        labels: {
                            show: true,
                            rotate: chartConfig.rotate,
                            hideOverlappingLabels: true,
                            trim: true,
                            style: {
                                colors: '#517487',
                                fontSize: chartConfig.fontSize,
                            },
                        },
                        axisTicks: {
                            show: true,
                            color: '#c7dae3',
                        },
                        axisBorder: {
                            show: true,
                            color: '#c7dae3',
                        },
                    },
                    yaxis: {
                        show: chartConfig.showYaxis,
                        labels: {
                            style: {
                                colors: '#517487',
                                fontSize: chartConfig.fontSize,
                            },
                            formatter: (value) => `${Math.round(Number(value) || 0)}`,
                        },
                    },
                    tooltip: {
                        x: {
                            formatter: (value, options) => {
                                const index = options?.dataPointIndex ?? 0;
                                const labels = getScreenFullLabels();
                                return labels[index] ?? value;
                            },
                        },
                        y: {
                            formatter: (value) => `${Number(value || 0).toFixed(2)} MAD`,
                        },
                    },
                    grid: {
                        borderColor: '#d7e4eb',
                        strokeDashArray: 4,
                    },
                    colors: ['#7EA3B1'],
                    states: {
                        active: {
                            filter: { type: 'none' },
                        },
                    },
                };

                const ownerExpenseChart = new ApexCharts(chartElement, options);
                ownerExpenseChart.render();

                let resizeTimer;
                window.addEventListener('resize', () => {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(() => {
                        const nextConfig = getChartConfig();
                        ownerExpenseChart.updateOptions({
                            chart: {
                                height: nextConfig.height,
                            },
                            plotOptions: {
                                bar: {
                                    columnWidth: nextConfig.columnWidth,
                                },
                            },
                            xaxis: {
                                categories: getScreenLabels(),
                                tickAmount: nextConfig.tickAmount,
                                labels: {
                                    rotate: nextConfig.rotate,
                                    style: {
                                        fontSize: nextConfig.fontSize,
                                    },
                                },
                            },
                            yaxis: {
                                show: nextConfig.showYaxis,
                                labels: {
                                    style: {
                                        fontSize: nextConfig.fontSize,
                                    },
                                },
                            },
                        }, false, false);
                        ownerExpenseChart.updateSeries([{ name: 'Expense', data: getScreenSeries() }]);
                    }, 120);
                });
            };

            const bootstrap = () => {
                if (typeof ApexCharts !== 'undefined') {
                    renderChart();
                    return;
                }

                const existingScript = document.querySelector('script[data-apexcharts-owner]');
                if (existingScript) {
                    existingScript.addEventListener('load', renderChart, { once: true });
                    return;
                }

                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/apexcharts';
                script.dataset.apexchartsOwner = '1';
                script.onload = renderChart;
                document.head.appendChild(script);
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', bootstrap, { once: true });
                return;
            }

            bootstrap();
        })();
    </script>

    <script>
        (() => {
            const body = document.body;
            const modalSelector = '[id$="-modal"].fixed.inset-0';
            const editCategoryInput = document.getElementById('edit-category-name');
            const deleteCategoryName = document.getElementById('delete-category-name');
            const deleteCategoryForm = document.getElementById('delete-category-form');
            const profileSidebar = document.getElementById('profile-sidebar');

            const isProfileSidebarOpen = () => {
                if (!profileSidebar) {
                    return false;
                }

                return !profileSidebar.classList.contains('translate-x-full');
            };

            const syncBodyScrollLock = () => {
                const hasVisibleModal = [...document.querySelectorAll(modalSelector)]
                    .some((modal) => !modal.classList.contains('hidden'));

                body.classList.toggle('overflow-hidden', hasVisibleModal || isProfileSidebarOpen());
            };

            const closeAll = () => {
                const modals = document.querySelectorAll(modalSelector);
                modals.forEach((modal) => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                });
                syncBodyScrollLock();
            };

            const openModal = (id) => {
                if (!id) return;
                const modal = document.getElementById(id);
                if (!modal) return;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                modal.scrollTop = 0;
                const scrollPanel = modal.querySelector('.owner-modal-panel, .expense-form-scroll');
                if (scrollPanel) {
                    scrollPanel.scrollTop = 0;
                }
                syncBodyScrollLock();
            };

            syncBodyScrollLock();

            document.addEventListener('click', (event) => {
                const openButton = event.target.closest('[data-open-modal]');
                if (openButton) {
                    const target = openButton.dataset.openModal;
                    const categoryId = openButton.dataset.categoryId || '';
                    const categoryName = openButton.dataset.categoryName || '';

                    if (target === 'edit-category-modal' && editCategoryInput) {
                        editCategoryInput.value = categoryName;
                    }

                    if (target === 'delete-category-modal' && deleteCategoryName) {
                        deleteCategoryName.textContent = categoryName || 'this category';
                        if (deleteCategoryForm) {
                            const template = deleteCategoryForm.dataset.actionTemplate || '';
                            deleteCategoryForm.action = template.replace('__CATEGORY__', categoryId);
                        }
                    }

                    openModal(target);
                    return;
                }

                const closeButton = event.target.closest('[data-close-modal]');
                if (closeButton) {
                    closeAll();
                    return;
                }

                const modalBackdrop = event.target.closest(modalSelector);
                if (modalBackdrop && event.target === modalBackdrop) {
                    closeAll();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeAll();
                }
            });
        })();
    </script>
@endsection
