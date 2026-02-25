@php($title = 'Owner Dashboard - EasyColoc')

@extends('layouts.app')

@section('content')
    <div class="w-full space-y-6">
        <section class="rounded-3xl border border-cerulean-200 bg-white p-6 shadow-sm md:p-8">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cerulean-500">Group Owner Space</p>
                    <h1 class="mt-2 text-3xl font-semibold text-cerulean-800 md:text-4xl">Group Dashboard</h1>
                    <p class="mt-2 max-w-3xl text-sm text-cerulean-700">
                        Manage your group from one page: members, categories, and expenses.
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

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
            <div class="space-y-6">
                <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Members</p>
                        <p class="mt-3 text-3xl font-semibold text-cerulean-800">0</p>
                        <p class="mt-1 text-xs text-cerulean-600">Users in this group</p>
                    </article>

                    <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Total Spent</p>
                        <p class="mt-3 text-3xl font-semibold text-cerulean-800">0.00 MAD</p>
                        <p class="mt-1 text-xs text-cerulean-600">All expenses combined</p>
                    </article>

                    <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Categories</p>
                        <p class="mt-3 text-3xl font-semibold text-cerulean-800">0</p>
                        <p class="mt-1 text-xs text-cerulean-600">Active categories</p>
                    </article>

                    <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Expenses</p>
                        <p class="mt-3 text-3xl font-semibold text-cerulean-800">0</p>
                        <p class="mt-1 text-xs text-cerulean-600">Recorded expenses</p>
                    </article>
                </section>

                <section class="rounded-3xl border border-cerulean-200 bg-white p-5 shadow-sm md:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-semibold text-cerulean-800">Manage Categories</h2>
                            <p class="mt-1 text-sm text-cerulean-700">Edit or delete categories directly from the list.</p>
                        </div>

                        <button
                            type="button"
                            class="rounded-xl border border-cerulean-300 bg-cerulean-50 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-100"
                        >
                            Add Category
                        </button>
                    </div>

                    <div class="mt-5 space-y-3">
                        <article class="grid gap-3 rounded-2xl border border-cerulean-200 bg-cerulean-50 p-4 sm:grid-cols-[1fr_auto] sm:items-center">
                            <div>
                                <p class="text-sm font-semibold text-cerulean-800">Food</p>
                                <p class="text-xs text-cerulean-600">Category for groceries and shared meals</p>
                            </div>

                            <div class="flex gap-2">
                                <button
                                    type="button"
                                    data-open-modal="edit-category-modal"
                                    data-category-name="Food"
                                    class="rounded-lg border border-cerulean-300 bg-white px-3 py-1.5 text-xs font-semibold text-cerulean-700 hover:bg-cerulean-50"
                                >
                                    Edit
                                </button>
                                <button
                                    type="button"
                                    data-open-modal="delete-category-modal"
                                    data-category-name="Food"
                                    class="rounded-lg border border-red-200 bg-white px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50"
                                >
                                    Delete
                                </button>
                            </div>
                        </article>

                        <article class="grid gap-3 rounded-2xl border border-cerulean-200 bg-cerulean-50 p-4 sm:grid-cols-[1fr_auto] sm:items-center">
                            <div>
                                <p class="text-sm font-semibold text-cerulean-800">Utilities</p>
                                <p class="text-xs text-cerulean-600">Category for water, electricity, and internet</p>
                            </div>

                            <div class="flex gap-2">
                                <button
                                    type="button"
                                    data-open-modal="edit-category-modal"
                                    data-category-name="Utilities"
                                    class="rounded-lg border border-cerulean-300 bg-white px-3 py-1.5 text-xs font-semibold text-cerulean-700 hover:bg-cerulean-50"
                                >
                                    Edit
                                </button>
                                <button
                                    type="button"
                                    data-open-modal="delete-category-modal"
                                    data-category-name="Utilities"
                                    class="rounded-lg border border-red-200 bg-white px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50"
                                >
                                    Delete
                                </button>
                            </div>
                        </article>
                    </div>
                </section>

                <section class="rounded-3xl border border-cerulean-200 bg-white p-5 shadow-sm md:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-semibold text-cerulean-800">Manage Members</h2>
                            <p class="mt-1 text-sm text-cerulean-700">Keep members organized and monitor reputation quickly.</p>
                        </div>

                        <button
                            type="button"
                            class="rounded-xl border border-cerulean-300 bg-cerulean-50 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-100"
                        >
                            Invite Member
                        </button>
                    </div>

                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        <article class="flex items-center gap-3 rounded-2xl border border-cerulean-200 bg-cerulean-50 p-3">
                            <div class="relative">
                                <img src="https://i.pravatar.cc/80?img=53" alt="Member avatar" class="h-12 w-12 rounded-xl border border-cerulean-200 object-cover">
                                <span class="absolute -bottom-1 -right-1 inline-flex min-h-5 min-w-5 items-center justify-center rounded-full bg-cerulean-700 px-1.5 text-[10px] font-semibold text-white">
                                    +8
                                </span>
                            </div>

                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-cerulean-800">Member Name</p>
                                <p class="truncate text-xs text-cerulean-600">Role: Member</p>
                            </div>

                            <button type="button" class="ml-auto rounded-lg border border-red-200 bg-white px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">
                                Remove
                            </button>
                        </article>

                        <article class="flex items-center gap-3 rounded-2xl border border-cerulean-200 bg-cerulean-50 p-3">
                            <div class="relative">
                                <img src="https://i.pravatar.cc/80?img=56" alt="Member avatar" class="h-12 w-12 rounded-xl border border-cerulean-200 object-cover">
                                <span class="absolute -bottom-1 -right-1 inline-flex min-h-5 min-w-5 items-center justify-center rounded-full bg-cerulean-700 px-1.5 text-[10px] font-semibold text-white">
                                    +3
                                </span>
                            </div>

                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-cerulean-800">Member Name</p>
                                <p class="truncate text-xs text-cerulean-600">Role: Member</p>
                            </div>

                            <button type="button" class="ml-auto rounded-lg border border-red-200 bg-white px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">
                                Remove
                            </button>
                        </article>
                    </div>
                </section>
            </div>

            <aside class="rounded-3xl border border-cerulean-200 bg-white p-5 shadow-sm md:p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-cerulean-800">Recent Expenses</h2>
                    <span class="rounded-full border border-cerulean-200 bg-cerulean-50 px-2.5 py-1 text-xs font-semibold text-cerulean-700">Live</span>
                </div>
                <p class="mt-2 text-xs text-cerulean-700">Amount, payer, and category</p>

                <div class="mt-5 space-y-3">
                    <article class="rounded-2xl border border-cerulean-200 bg-cerulean-50 p-3">
                        <div class="flex items-center gap-3">
                            <img src="https://i.pravatar.cc/80?img=12" alt="Payer avatar" class="h-11 w-11 rounded-xl border border-cerulean-200 object-cover">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-cerulean-800">User Name</p>
                                <p class="truncate text-xs text-cerulean-600">Food</p>
                            </div>
                            <p class="ml-auto text-sm font-semibold text-cerulean-800">0.00 MAD</p>
                        </div>
                    </article>

                    <article class="rounded-2xl border border-cerulean-200 bg-cerulean-50 p-3">
                        <div class="flex items-center gap-3">
                            <img src="https://i.pravatar.cc/80?img=32" alt="Payer avatar" class="h-11 w-11 rounded-xl border border-cerulean-200 object-cover">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-cerulean-800">User Name</p>
                                <p class="truncate text-xs text-cerulean-600">Utilities</p>
                            </div>
                            <p class="ml-auto text-sm font-semibold text-cerulean-800">0.00 MAD</p>
                        </div>
                    </article>

                    <article class="rounded-2xl border border-cerulean-200 bg-cerulean-50 p-3">
                        <div class="flex items-center gap-3">
                            <img src="https://i.pravatar.cc/80?img=41" alt="Payer avatar" class="h-11 w-11 rounded-xl border border-cerulean-200 object-cover">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-cerulean-800">User Name</p>
                                <p class="truncate text-xs text-cerulean-600">Transport</p>
                            </div>
                            <p class="ml-auto text-sm font-semibold text-cerulean-800">0.00 MAD</p>
                        </div>
                    </article>
                </div>
            </aside>
        </div>
    </div>

    <div id="edit-category-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-cerulean-900/50 p-4">
        <div class="w-full max-w-md rounded-2xl border border-cerulean-200 bg-white p-5 shadow-xl">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-cerulean-800">Edit Category</h3>
                    <p class="mt-1 text-xs text-cerulean-600">Update category information.</p>
                </div>
                <button type="button" data-close-modal class="rounded-lg p-2 text-cerulean-700 hover:bg-cerulean-100">X</button>
            </div>

            <form class="mt-4 space-y-3">
                <div>
                    <label for="edit-category-name" class="block text-xs font-medium text-cerulean-800">Category Name</label>
                    <input id="edit-category-name" type="text" class="mt-2 block h-11 w-full rounded-xl border border-cerulean-200 bg-white px-3 text-sm text-cerulean-800 outline-none focus:border-cerulean-600">
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" data-close-modal class="rounded-xl border border-cerulean-300 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-50">Cancel</button>
                    <button type="button" class="rounded-xl bg-cerulean-700 px-4 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div id="delete-category-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-cerulean-900/50 p-4">
        <div class="w-full max-w-md rounded-2xl border border-cerulean-200 bg-white p-5 shadow-xl">
            <h3 class="text-lg font-semibold text-cerulean-800">Delete Category</h3>
            <p class="mt-2 text-sm text-cerulean-700">
                Are you sure you want to delete
                <span id="delete-category-name" class="font-semibold text-cerulean-800">this category</span>?
            </p>

            <div class="mt-5 flex justify-end gap-2">
                <button type="button" data-close-modal class="rounded-xl border border-cerulean-300 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-50">Cancel</button>
                <button type="button" class="rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-100">Delete</button>
            </div>
        </div>
    </div>

    <div id="add-expense-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-cerulean-900/50 p-4">
        <div class="w-full max-w-lg rounded-2xl border border-cerulean-200 bg-white p-5 shadow-xl">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-cerulean-800">Add Expense</h3>
                    <p class="mt-1 text-xs text-cerulean-600">Create a new expense for the group.</p>
                </div>
                <button type="button" data-close-modal class="rounded-lg p-2 text-cerulean-700 hover:bg-cerulean-100">X</button>
            </div>

            <form class="mt-4 grid gap-3 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="expense-title" class="block text-xs font-medium text-cerulean-800">Title</label>
                    <input id="expense-title" type="text" class="mt-2 block h-11 w-full rounded-xl border border-cerulean-200 bg-white px-3 text-sm text-cerulean-800 outline-none focus:border-cerulean-600">
                </div>

                <div>
                    <label for="expense-amount" class="block text-xs font-medium text-cerulean-800">Amount</label>
                    <input id="expense-amount" type="number" step="0.01" class="mt-2 block h-11 w-full rounded-xl border border-cerulean-200 bg-white px-3 text-sm text-cerulean-800 outline-none focus:border-cerulean-600">
                </div>

                <div>
                    <label for="expense-date" class="block text-xs font-medium text-cerulean-800">Date</label>
                    <input id="expense-date" type="date" class="mt-2 block h-11 w-full rounded-xl border border-cerulean-200 bg-white px-3 text-sm text-cerulean-800 outline-none focus:border-cerulean-600">
                </div>

                <div>
                    <label for="expense-category" class="block text-xs font-medium text-cerulean-800">Category</label>
                    <select id="expense-category" class="mt-2 block h-11 w-full rounded-xl border border-cerulean-200 bg-white px-3 text-sm text-cerulean-800 outline-none focus:border-cerulean-600">
                        <option>Food</option>
                        <option>Utilities</option>
                        <option>Transport</option>
                    </select>
                </div>

                <div>
                    <label for="expense-payer" class="block text-xs font-medium text-cerulean-800">Paid By</label>
                    <select id="expense-payer" class="mt-2 block h-11 w-full rounded-xl border border-cerulean-200 bg-white px-3 text-sm text-cerulean-800 outline-none focus:border-cerulean-600">
                        <option>User Name</option>
                    </select>
                </div>

                <div class="sm:col-span-2 flex justify-end gap-2 pt-2">
                    <button type="button" data-close-modal class="rounded-xl border border-cerulean-300 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-50">Cancel</button>
                    <button type="button" class="rounded-xl bg-cerulean-700 px-4 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Add Expense</button>
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
            const editCategoryInput = document.getElementById('edit-category-name');
            const deleteCategoryName = document.getElementById('delete-category-name');

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
                    const target = button.dataset.openModal;
                    const categoryName = button.dataset.categoryName || '';

                    if (target === 'edit-category-modal' && editCategoryInput) {
                        editCategoryInput.value = categoryName;
                    }

                    if (target === 'delete-category-modal' && deleteCategoryName) {
                        deleteCategoryName.textContent = categoryName || 'this category';
                    }

                    openModal(target);
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
