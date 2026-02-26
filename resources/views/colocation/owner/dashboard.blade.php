@php($title = 'Owner Dashboard - EasyColoc')

@extends('layouts.app')

@section('content')
    <div class="w-full space-y-6">
        <section class="rounded-3xl border border-cerulean-200 bg-white p-6 shadow-sm md:p-8">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="flex items-center gap-3">
                    <img src="{{ $colocation->avatar ? asset('storage/' . $colocation->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($colocation->name ?? 'Colocation') . '&background=0369a1&color=ffffff' }}" alt="Colocation logo" class="h-14 w-14 rounded-xl border border-cerulean-200 object-cover">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cerulean-500">{{ $colocation->name ?? $colocation->title }}</p>
                    <h1 class="mt-2 text-3xl font-semibold text-cerulean-800 md:text-4xl">Group Dashboard</h1>
                    <p class="mt-2 max-w-3xl text-sm text-cerulean-700">
                        Manage your group from one page: members, categories, and expenses.
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
                </div>
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
            <div class="space-y-6">
                <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Members</p>
                        <p class="mt-3 text-3xl font-semibold text-cerulean-800">{{ $totalMembers }}</p>
                        <p class="mt-1 text-xs text-cerulean-600">Users in this group</p>
                    </article>

                    <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Total Spent</p>
                        <p class="mt-3 text-3xl font-semibold text-cerulean-800">{{$totalSpent}} MAD</p>
                        <p class="mt-1 text-xs text-cerulean-600">All expenses combined</p>
                    </article>

                    <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">My Balance</p>
                        <p class="mt-3 text-3xl font-semibold {{ $myBalance < 0 ? 'text-red-600' : ($myBalance > 0 ? 'text-green-600' : 'text-cerulean-800') }}">{{ $myBalance }} MAD</p>
                        <p class="mt-1 text-xs text-cerulean-600">Positive means you owe money</p>
                    </article>

                    <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Categories</p>
                        <p class="mt-3 text-3xl font-semibold text-cerulean-800">{{$totalCategories}}</p>
                        <p class="mt-1 text-xs text-cerulean-600">Active categories</p>
                    </article>

                    <article class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-cerulean-600">Expenses</p>
                        <p class="mt-3 text-3xl font-semibold text-cerulean-800">{{$totalExpenses}}</p>
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
                            data-open-modal="add-category-modal"
                            class="rounded-xl border border-cerulean-300 bg-cerulean-50 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-100"
                        >
                            Add Category
                        </button>
                    </div>

                    <div class="mt-5 space-y-3">
                        @forelse($categories as $category)
                        <article class="grid gap-3 rounded-2xl border border-cerulean-200 bg-cerulean-50 p-4 sm:grid-cols-[1fr_auto] sm:items-center">
                            <div>
                                <p class="text-sm font-semibold text-cerulean-800">{{ $category->name }}</p>
                                <p class="text-xs text-cerulean-600">Category for groceries and shared meals</p>
                            </div>

                            <div class="flex gap-2">
                                <button
                                    type="button"
                                    data-open-modal="edit-category-modal"
                                    data-category-name="{{ $category->name }}"
                                    class="rounded-lg border border-cerulean-300 bg-white px-3 py-1.5 text-xs font-semibold text-cerulean-700 hover:bg-cerulean-50"
                                >
                                    Edit
                                </button>
                                <button
                                    type="button"
                                    data-open-modal="delete-category-modal"
                                    data-category-id="{{ $category->id }}"
                                    data-category-name="{{ $category->name }}"
                                    class="rounded-lg border border-red-200 bg-white px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50"
                                >
                                    Delete
                                </button>
                            </div>
                        </article>
                        @empty
                            <div>nothing yet</div>
                        @endforelse

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
                            data-open-modal="invite-member-modal"
                            class="rounded-xl border border-cerulean-300 bg-cerulean-50 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-100"
                        >
                            Invite Member
                        </button>
                    </div>

                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        @forelse($members as $member)

                        <article class="flex items-center gap-3 rounded-2xl border border-cerulean-200 bg-cerulean-50 p-3">
                            <div class="relative">
                                <img src="{{ $member->user->avatar ? asset('storage/' . $member->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($member->user->name) . '&background=0f766e&color=ffffff' }}" alt="Member avatar" class="h-12 w-12 rounded-xl border border-cerulean-200 object-cover">
                                <span class="absolute -bottom-1 -right-1 inline-flex min-h-5 min-w-5 items-center justify-center rounded-full bg-cerulean-700 px-1.5 text-[10px] font-semibold text-white">
                                    {{$member->user->reputation}}
                                </span>
                            </div>

                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-cerulean-800">Member Name</p>
                                <p class="truncate text-xs text-cerulean-600">{{$member->role}}</p>
                            </div>

                            <button type="button" class="ml-auto rounded-lg border border-red-200 bg-white px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">
                                Remove
                            </button>
                        </article>
                        @empty
                            <div>you are the only member invite someone !</div>
                        @endforelse
                    </div>
                </section>
            </div>

            <aside class="rounded-3xl border border-cerulean-200 bg-white p-5 shadow-sm md:p-6">
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
                        <p>no owes yet !</p>
                    @endforelse
                </div>
            </aside>
        </div>

        <section class="rounded-3xl border border-cerulean-200 bg-white p-5 shadow-sm md:p-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-cerulean-800">Recent Expenses</h2>
                <span class="rounded-full border border-cerulean-200 bg-cerulean-50 px-2.5 py-1 text-xs font-semibold text-cerulean-700">Live</span>
            </div>
            <p class="mt-2 text-xs text-cerulean-700">Amount, payer, and category</p>

            <div class="mt-5 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                @forelse($expenses as $expense)
                    <article class="rounded-2xl border border-cerulean-200 bg-cerulean-50 p-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $expense->membership->user->avatar ? asset('storage/' . $expense->membership->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($expense->membership->user->name) . '&background=0f766e&color=ffffff' }}" alt="Payer avatar" class="h-11 w-11 rounded-xl border border-cerulean-200 object-cover">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-cerulean-800">{{$expense->membership->user->name}}</p>
                                <p class="truncate text-xs text-cerulean-600">{{$expense->category?->name }}</p>
                            </div>
                            <p class="ml-auto text-sm font-semibold text-cerulean-800">{{$expense->amount}} MAD</p>
                        </div>
                    </article>
                @empty
                    <p>no expenses yet !</p>
                @endforelse
            </div>
        </section>
    </div>

    <div id="add-category-modal" class="fixed hidden inset-0 z-50 items-center justify-center bg-cerulean-900/50 p-4">
        <div class="w-full max-w-md rounded-2xl border border-cerulean-200 bg-white p-5 shadow-xl">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-cerulean-800">Add Category</h3>
                    <p class="mt-1 text-xs text-cerulean-600">Create a new category for the group.</p>
                </div>
                <button type="button" data-close-modal class="rounded-lg p-2 text-cerulean-700 hover:bg-cerulean-100">X</button>
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
                    <button type="button" data-close-modal class="rounded-xl border border-cerulean-300 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-50">Cancel</button>
                    <button type="submit" class="rounded-xl bg-cerulean-700 px-4 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Add Category</button>
                </div>
            </form>
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
                <x-form.input
                    id="edit-category-name"
                    name="name"
                    label="Category Name"
                />

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

            <form
                id="delete-category-form"
                class="mt-5 flex justify-end gap-2"
                method="post"
{{--                js placed that id by of __category__ passito lroute--}}
                data-action-template="{{ route('owner.category.delete', ['category' => '__CATEGORY__']) }}"
            >
                @csrf
                @method('DELETE')
                <button type="button" data-close-modal class="rounded-xl border border-cerulean-300 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-50">Cancel</button>
                <button type="submit" class="rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-100">Delete</button>
            </form>
        </div>
    </div>

    <div id="add-expense-modal" class="fixed hidden inset-0 z-50  items-center justify-center bg-cerulean-900/50 p-4">
        <div class="w-full max-w-lg rounded-2xl border border-cerulean-200 bg-white p-5 shadow-xl">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-cerulean-800">Add Expense</h3>
                    <p class="mt-1 text-xs text-cerulean-600">Create a new expense for the group.</p>
                </div>
                <button type="button" data-close-modal class="rounded-lg p-2 text-cerulean-700 hover:bg-cerulean-100">X</button>
            </div>

            <form class="mt-4  grid gap-3 sm:grid-cols-2" action="{{route('expense.add')}}" method="post" >
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
                            <option value="{{ $category->id }}" >
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

    <div id="invite-member-modal" class="fixed hidden inset-0 z-50 items-center justify-center bg-cerulean-900/50 p-4">
        <div class="w-full max-w-md rounded-2xl border border-cerulean-200 bg-white p-5 shadow-xl">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-cerulean-800">Invite Member</h3>
                    <p class="mt-1 text-xs text-cerulean-600">Send an invitation email to join this group.</p>
                </div>
                <button type="button" data-close-modal class="rounded-lg p-2 text-cerulean-700 hover:bg-cerulean-100">X</button>
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
                    <button type="button" data-close-modal class="rounded-xl border border-cerulean-300 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-50">Cancel</button>
                    <button type="submit" class="rounded-xl bg-cerulean-700 px-4 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Send Invite</button>
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
            const deleteCategoryForm = document.getElementById('delete-category-form');

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
                    const categoryId = button.dataset.categoryId || '';
                    const categoryName = button.dataset.categoryName || '';

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
