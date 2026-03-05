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

        <section id="member-dashboard-expenses" class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm md:p-6">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-cerulean-800">Recent Expenses</h2>
                <div class="flex flex-wrap items-center gap-2">
                    <form action="{{ route('member.dashboard') }}" method="get" class="flex flex-wrap items-center gap-2">
                        <select name="month" class="h-9 rounded-lg border border-cerulean-200 bg-white px-2 text-xs text-cerulean-800 outline-none focus:border-cerulean-600">
                            <option value="">All months</option>
                            @php
                                $months = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];
                            @endphp
                            @foreach($months as $value => $label)
                                <option value="{{ $value }}" @selected((int) request('month') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>

                        <select name="year" class="h-9 rounded-lg border border-cerulean-200 bg-white px-2 text-xs text-cerulean-800 outline-none focus:border-cerulean-600">
                            <option value="2026" @selected((int) request('year', 2026) === 2026)>2026</option>
                        </select>

                        <button type="submit" class="rounded-md border border-cerulean-300 bg-white px-2.5 py-1 text-[11px] font-semibold text-cerulean-700 hover:bg-cerulean-100">
                            Filter
                        </button>

                        @if(request('month') && request('year'))
                            <a href="{{ route('member.dashboard') }}" class="rounded-md border border-cerulean-300 bg-white px-2.5 py-1 text-[11px] font-semibold text-cerulean-700 hover:bg-cerulean-100">
                                Clear
                            </a>
                        @endif
                    </form>
                    <span class="rounded-full border border-cerulean-200 bg-cerulean-50 px-2.5 py-1 text-xs font-semibold text-cerulean-700">
                        {{ request('month') && request('year') ? 'Filtered' : 'Last 5' }}
                    </span>
                </div>
            </div>
            <p class="mt-2 text-xs text-cerulean-700">Amount, payer, and category</p>

            @php
                $staticParticipants = collect([
                    [
                        'name' => 'Participant A',
                        'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode('Participant A') . '&background=0369a1&color=ffffff',
                    ],
                    [
                        'name' => 'Participant B',
                        'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode('Participant B') . '&background=0f766e&color=ffffff',
                    ],
                    [
                        'name' => 'Participant C',
                        'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode('Participant C') . '&background=334155&color=ffffff',
                    ],
                ]);

                $expenseParticipants = collect([$membership])
                    ->merge($members ?? collect())
                    ->filter()
                    ->unique('id')
                    ->values()
                    ->map(function ($participant) use ($membership) {
                        $name = $participant->id === $membership->id ? 'Me' : ($participant->user->name ?? 'Member');
                        $avatar = $participant->user->avatar
                            ? asset('storage/' . $participant->user->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=0369a1&color=ffffff';

                        return [
                            'name' => $name,
                            'avatar' => $avatar,
                        ];
                    });
                $participantsPreview = $expenseParticipants->isNotEmpty() ? $expenseParticipants : $staticParticipants;
                $participantsCount = $participantsPreview->count();
            @endphp

            <div class="mt-5 space-y-2 md:hidden">
                @forelse($expenses as $expense)
                    @php
                        $payerName = $expense->membership?->user?->name ?? 'Payer';
                        $payerAvatar = $expense->membership?->user?->avatar
                            ? asset('storage/' . $expense->membership->user->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($payerName) . '&background=0f766e&color=ffffff';
                        $expenseTitle = $expense->title ?? 'Expense title';
                        $expenseCategory = $expense->category?->name ?? 'Category';
                        $expenseAmount = number_format((float) ($expense->amount ?? 0), 2, '.', '');
                    @endphp
                    <article class="rounded-xl border border-cerulean-200 bg-cerulean-50 p-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $payerAvatar }}" alt="Payer avatar" class="h-10 w-10 rounded-lg border border-cerulean-200 object-cover">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-semibold text-cerulean-800">{{ $expenseTitle }}</p>
                                <p class="truncate text-xs text-cerulean-600">{{ $payerName }} • {{ $expenseCategory }}</p>
                            </div>
                            <p class="text-sm font-semibold text-cerulean-800">{{ $expenseAmount }} MAD</p>
                        </div>
                    </article>
                @empty
                    <div class="rounded-xl border border-dashed border-cerulean-200 bg-cerulean-50 px-4 py-10 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-8 w-8 text-cerulean-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 6h18"/>
                            <path d="M3 12h18"/>
                            <path d="M3 18h18"/>
                        </svg>
                        <p class="mt-3 text-sm font-semibold text-cerulean-800">No expenses yet</p>
                        <p class="mt-1 text-xs text-cerulean-600">Start by adding your first shared expense.</p>
                        <button type="button" data-open-modal="add-expense-modal" class="mt-4 rounded-lg bg-cerulean-700 px-4 py-2 text-xs font-semibold text-white hover:bg-cerulean-800">+ Add your first expense</button>
                    </div>
                @endforelse
            </div>

            <div class="mt-5 hidden overflow-hidden rounded-xl border border-cerulean-200 bg-white md:block">
                <div>
                    <table class="min-w-full text-sm">
                        <thead class="bg-cerulean-100/70 text-cerulean-800">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Payer</th>
                                <th class="px-4 py-3 text-left font-semibold">Expense Name</th>
                                <th class="px-4 py-3 text-left font-semibold">Category</th>
                                <th class="px-4 py-3 text-left font-semibold">Amount</th>
                                <th class="px-4 py-3 text-left font-semibold">Participants</th>
                                <th class="px-4 py-3 text-left font-semibold">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cerulean-100">
                            @forelse($expenses as $expense)
                                @php
                                    $payerName = $expense->membership?->user?->name ?? 'Payer';
                                    $payerAvatar = $expense->membership?->user?->avatar
                                        ? asset('storage/' . $expense->membership->user->avatar)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($payerName) . '&background=0f766e&color=ffffff';
                                    $expenseTitle = $expense->title ?? 'Expense title';
                                    $expenseCategory = $expense->category?->name ?? 'Category';
                                    $expenseAmount = number_format((float) ($expense->amount ?? 0), 2, '.', '');
                                    $expenseDate = $expense->date
                                        ? \Illuminate\Support\Carbon::parse($expense->date)->format('M d, Y')
                                        : 'Date -';
                                @endphp
                                <tr class="bg-white transition hover:bg-cerulean-50/60">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $payerAvatar }}" alt="Payer avatar" class="h-10 w-10 rounded-lg border border-cerulean-200 object-cover">
                                            <span class="font-medium text-cerulean-900">{{ $payerName }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-cerulean-800">{{ $expenseTitle }}</td>
                                    <td class="px-4 py-3 text-cerulean-700">{{ $expenseCategory }}</td>
                                    <td class="px-4 py-3 font-semibold text-cerulean-800">{{ $expenseAmount }} MAD</td>
                                    <td class="px-4 py-3 text-cerulean-700">
                                        <div class="relative inline-flex items-center">
                                            <button
                                                type="button"
                                                data-member-hover-trigger
                                                class="rounded-full border border-cerulean-200 bg-cerulean-50 px-2.5 py-1 text-xs font-semibold text-cerulean-700"
                                            >
                                                {{ $participantsCount ?? (($participantsPreview ?? collect())->count()) }}
                                            </button>
                                            <template data-member-hover-template>
                                                <p class="px-1 pb-1 text-[11px] font-semibold uppercase tracking-[0.1em] text-cerulean-600">Participants</p>
                                                <div class="space-y-1 pr-1">
                                                    @foreach(($participantsPreview ?? collect()) as $participant)
                                                        <div class="flex items-center gap-2 rounded-md px-1 py-1">
                                                            <img src="{{ $participant['avatar'] }}" alt="{{ $participant['name'] }} avatar" class="h-7 w-7 rounded-full border border-cerulean-200 object-cover">
                                                            <span class="truncate text-xs font-medium text-cerulean-800">{{ $participant['name'] }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </template>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-cerulean-700">{{ $expenseDate }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-8 w-8 text-cerulean-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M3 6h18"/>
                                            <path d="M3 12h18"/>
                                            <path d="M3 18h18"/>
                                        </svg>
                                        <p class="mt-3 text-sm font-semibold text-cerulean-800">No expenses yet</p>
                                        <p class="mt-1 text-xs text-cerulean-600">Start by adding your first shared expense.</p>
                                        <button type="button" data-open-modal="add-expense-modal" class="mt-4 rounded-lg bg-cerulean-700 px-4 py-2 text-xs font-semibold text-white hover:bg-cerulean-800">+ Add your first expense</button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @php
                $isExpensesPaginated = $expenses instanceof \Illuminate\Contracts\Pagination\Paginator;
                $canShowTotal = $isExpensesPaginated && method_exists($expenses, 'total');
            @endphp
            @if($isExpensesPaginated && $expenses->hasPages())
                <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                    @if($canShowTotal)
                        <p class="text-xs font-medium text-cerulean-700">
                            Showing {{ $expenses->firstItem() ?? 0 }}-{{ $expenses->lastItem() ?? 0 }} of {{ $expenses->total() }}
                        </p>
                    @else
                        <p class="text-xs font-medium text-cerulean-700">
                            Page {{ $expenses->currentPage() }}
                        </p>
                    @endif
                    <div class="w-full sm:w-auto">
                        {{ $expenses->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </section>

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

    <div id="member-dashboard-hover-portal" class="pointer-events-none fixed left-0 top-0 z-[70] hidden w-56 rounded-lg border border-cerulean-200 bg-white p-2 shadow-xl"></div>

    <x-expenses.form :membership="$membership" :members="$members" :categories="$categories" />

    <script>
        (() => {
            const portal = document.getElementById('member-dashboard-hover-portal');
            if (!portal) {
                return;
            }

            let activeTrigger = null;
            const edgePadding = 8;
            const offset = 8;

            const hidePortal = () => {
                portal.classList.add('hidden');
                activeTrigger = null;
            };

            const positionPortal = () => {
                if (!activeTrigger || portal.classList.contains('hidden')) {
                    return;
                }

                const triggerRect = activeTrigger.getBoundingClientRect();
                const portalRect = portal.getBoundingClientRect();

                let left = triggerRect.right - portalRect.width;
                left = Math.max(edgePadding, Math.min(left, window.innerWidth - portalRect.width - edgePadding));

                let top = triggerRect.top - portalRect.height - offset;
                if (top < edgePadding) {
                    top = triggerRect.bottom + offset;
                }
                if (top + portalRect.height > window.innerHeight - edgePadding) {
                    top = Math.max(edgePadding, window.innerHeight - portalRect.height - edgePadding);
                }

                portal.style.left = `${left}px`;
                portal.style.top = `${top}px`;
            };

            const showPortal = (trigger) => {
                const template = trigger.parentElement?.querySelector('template[data-member-hover-template]');
                if (!template) {
                    return;
                }

                activeTrigger = trigger;
                portal.innerHTML = template.innerHTML;
                portal.classList.remove('hidden');
                requestAnimationFrame(positionPortal);
            };

            document.addEventListener('mouseenter', (event) => {
                const trigger = event.target.closest('[data-member-hover-trigger]');
                if (!trigger) {
                    return;
                }
                showPortal(trigger);
            }, true);

            document.addEventListener('mouseleave', (event) => {
                const trigger = event.target.closest('[data-member-hover-trigger]');
                if (!trigger || activeTrigger !== trigger) {
                    return;
                }
                hidePortal();
            }, true);

            document.addEventListener('focusin', (event) => {
                const trigger = event.target.closest('[data-member-hover-trigger]');
                if (!trigger) {
                    return;
                }
                showPortal(trigger);
            });

            document.addEventListener('focusout', (event) => {
                const trigger = event.target.closest('[data-member-hover-trigger]');
                if (!trigger || activeTrigger !== trigger) {
                    return;
                }
                hidePortal();
            });

            window.addEventListener('scroll', positionPortal, true);
            window.addEventListener('resize', positionPortal);

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    hidePortal();
                }
            });
        })();
    </script>

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
