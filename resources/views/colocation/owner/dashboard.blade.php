@php($title = 'Owner Dashboard - EasyColoc')

@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full max-w-7xl space-y-6">
        <section class="rounded-3xl border border-cerulean-200 bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cerulean-500">Group Owner Space</p>
            <div class="mt-3 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-semibold text-cerulean-800">Group Dashboard</h1>
                    <p class="mt-2 text-sm text-cerulean-700">Track group activity, categories, and members from one place.</p>
                </div>
                <div class="inline-flex items-center rounded-2xl border border-cerulean-200 bg-cerulean-50 px-4 py-2 text-xs font-semibold text-cerulean-700">
                    Owner mode
                </div>
            </div>
        </section>

        <section class="rounded-3xl border border-cerulean-200 bg-white shadow-sm">
            <div class="border-b border-cerulean-200 px-4 py-4 sm:px-6">
                <nav class="inline-flex rounded-2xl bg-cerulean-50 p-1" aria-label="Owner tabs">
                    <button
                        type="button"
                        data-owner-tab-button="dashboard"
                        class="rounded-xl px-4 py-2 text-sm font-semibold transition"
                    >
                        Dashboard
                    </button>
                    <button
                        type="button"
                        data-owner-tab-button="categories"
                        class="rounded-xl px-4 py-2 text-sm font-semibold transition"
                    >
                        Manage Categories
                    </button>
                    <button
                        type="button"
                        data-owner-tab-button="members"
                        class="rounded-xl px-4 py-2 text-sm font-semibold transition"
                    >
                        Manage Members
                    </button>
                </nav>
            </div>

            <div class="p-4 sm:p-6">
                <div data-owner-tab-panel="dashboard">
                    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_340px]">
                        <div class="space-y-6">
                            <div class="grid gap-4 sm:grid-cols-3">
                                <article class="rounded-2xl border border-cerulean-200 bg-cerulean-50 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Members</p>
                                    <p class="mt-3 text-3xl font-semibold text-cerulean-800">0</p>
                                    <p class="mt-1 text-xs text-cerulean-600">Users currently in this group</p>
                                </article>

                                <article class="rounded-2xl border border-cerulean-200 bg-cerulean-50 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Total Spent</p>
                                    <p class="mt-3 text-3xl font-semibold text-cerulean-800">0.00 MAD</p>
                                    <p class="mt-1 text-xs text-cerulean-600">All expenses combined</p>
                                </article>

                                <article class="rounded-2xl border border-cerulean-200 bg-cerulean-50 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Categories</p>
                                    <p class="mt-3 text-3xl font-semibold text-cerulean-800">0</p>
                                    <p class="mt-1 text-xs text-cerulean-600">Available expense categories</p>
                                </article>
                            </div>

                            <article class="rounded-2xl border border-cerulean-200 p-5">
                                <h2 class="text-xl font-semibold text-cerulean-800">Overview Area</h2>
                                <p class="mt-2 text-sm text-cerulean-700">Use this block for charts, trends, and quick owner actions.</p>
                                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                                    <div class="h-28 rounded-2xl border border-dashed border-cerulean-300 bg-cerulean-50"></div>
                                    <div class="h-28 rounded-2xl border border-dashed border-cerulean-300 bg-cerulean-50"></div>
                                </div>
                            </article>
                        </div>

                        <aside class="rounded-2xl border border-cerulean-200 bg-cerulean-50 p-5">
                            <h2 class="text-lg font-semibold text-cerulean-800">Expense Feed</h2>
                            <p class="mt-1 text-xs text-cerulean-700">Amount, payer, and category</p>

                            <div class="mt-4 space-y-3">
                                <article class="rounded-2xl border border-cerulean-200 bg-white p-3">
                                    <div class="flex items-center gap-3">
                                        <img src="https://i.pravatar.cc/80?img=12" alt="Payer avatar" class="h-11 w-11 rounded-xl border border-cerulean-200 object-cover">
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-semibold text-cerulean-800">User Name</p>
                                            <p class="truncate text-xs text-cerulean-600">Category Name</p>
                                        </div>
                                        <p class="ml-auto text-sm font-semibold text-cerulean-800">0.00 MAD</p>
                                    </div>
                                </article>

                                <article class="rounded-2xl border border-cerulean-200 bg-white p-3">
                                    <div class="flex items-center gap-3">
                                        <img src="https://i.pravatar.cc/80?img=32" alt="Payer avatar" class="h-11 w-11 rounded-xl border border-cerulean-200 object-cover">
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-semibold text-cerulean-800">User Name</p>
                                            <p class="truncate text-xs text-cerulean-600">Category Name</p>
                                        </div>
                                        <p class="ml-auto text-sm font-semibold text-cerulean-800">0.00 MAD</p>
                                    </div>
                                </article>

                                <article class="rounded-2xl border border-cerulean-200 bg-white p-3">
                                    <div class="flex items-center gap-3">
                                        <img src="https://i.pravatar.cc/80?img=41" alt="Payer avatar" class="h-11 w-11 rounded-xl border border-cerulean-200 object-cover">
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-semibold text-cerulean-800">User Name</p>
                                            <p class="truncate text-xs text-cerulean-600">Category Name</p>
                                        </div>
                                        <p class="ml-auto text-sm font-semibold text-cerulean-800">0.00 MAD</p>
                                    </div>
                                </article>
                            </div>
                        </aside>
                    </div>
                </div>

                <div data-owner-tab-panel="categories" class="hidden">
                    <div class="rounded-2xl border border-cerulean-200 p-5">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-semibold text-cerulean-800">Manage Categories</h2>
                                <p class="mt-1 text-sm text-cerulean-700">Create, edit, and organize your group expense categories.</p>
                            </div>
                            <button type="button" class="rounded-xl bg-cerulean-700 px-4 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">
                                Add Category
                            </button>
                        </div>

                        <div class="mt-5 space-y-3">
                            <div class="grid grid-cols-[1fr_auto_auto] items-center gap-3 rounded-2xl border border-cerulean-200 bg-cerulean-50 p-3">
                                <p class="text-sm font-semibold text-cerulean-800">Category Name</p>
                                <button type="button" class="rounded-lg border border-cerulean-300 px-3 py-1.5 text-xs font-semibold text-cerulean-700 hover:bg-white">Edit</button>
                                <button type="button" class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">Delete</button>
                            </div>
                            <div class="grid grid-cols-[1fr_auto_auto] items-center gap-3 rounded-2xl border border-cerulean-200 bg-cerulean-50 p-3">
                                <p class="text-sm font-semibold text-cerulean-800">Category Name</p>
                                <button type="button" class="rounded-lg border border-cerulean-300 px-3 py-1.5 text-xs font-semibold text-cerulean-700 hover:bg-white">Edit</button>
                                <button type="button" class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div data-owner-tab-panel="members" class="hidden">
                    <div class="rounded-2xl border border-cerulean-200 p-5">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-semibold text-cerulean-800">Manage Members</h2>
                                <p class="mt-1 text-sm text-cerulean-700">Review members, roles, and group status from this section.</p>
                            </div>
                            <button type="button" class="rounded-xl bg-cerulean-700 px-4 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">
                                Invite Member
                            </button>
                        </div>

                        <div class="mt-5 space-y-3">
                            <article class="flex items-center gap-3 rounded-2xl border border-cerulean-200 bg-cerulean-50 p-3">
                                <img src="https://i.pravatar.cc/80?img=53" alt="Member avatar" class="h-11 w-11 rounded-xl border border-cerulean-200 object-cover">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-cerulean-800">Member Name</p>
                                    <p class="truncate text-xs text-cerulean-600">Role: Member</p>
                                </div>
                                <button type="button" class="ml-auto rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">Remove</button>
                            </article>

                            <article class="flex items-center gap-3 rounded-2xl border border-cerulean-200 bg-cerulean-50 p-3">
                                <img src="https://i.pravatar.cc/80?img=56" alt="Member avatar" class="h-11 w-11 rounded-xl border border-cerulean-200 object-cover">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-cerulean-800">Member Name</p>
                                    <p class="truncate text-xs text-cerulean-600">Role: Member</p>
                                </div>
                                <button type="button" class="ml-auto rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">Remove</button>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        (() => {
            const buttons = Array.from(document.querySelectorAll('[data-owner-tab-button]'));
            const panels = Array.from(document.querySelectorAll('[data-owner-tab-panel]'));
            if (!buttons.length || !panels.length) return;

            const activate = (tabName) => {
                buttons.forEach((button) => {
                    const isActive = button.dataset.ownerTabButton === tabName;
                    button.classList.toggle('bg-cerulean-700', isActive);
                    button.classList.toggle('text-white', isActive);
                    button.classList.toggle('shadow-sm', isActive);
                    button.classList.toggle('text-cerulean-700', !isActive);
                    button.classList.toggle('hover:bg-cerulean-100', !isActive);
                });

                panels.forEach((panel) => {
                    const isActive = panel.dataset.ownerTabPanel === tabName;
                    panel.classList.toggle('hidden', !isActive);
                });
            };

            buttons.forEach((button) => {
                button.addEventListener('click', () => activate(button.dataset.ownerTabButton));
            });

            activate('dashboard');
        })();
    </script>
@endsection
