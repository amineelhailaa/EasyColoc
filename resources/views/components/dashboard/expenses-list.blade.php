@props([
    'sectionId' => 'dashboard-expenses',
    'title' => 'Recent Expenses',
    'filterAction',
    'expenses',
    'membership',
    'members' => collect(),
    'emptyModalId' => 'add-expense-modal',
])

@php
    $portalId = $sectionId . '-participants-tooltip-portal';
    $months = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];

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

    $membersCollection = collect($members ?? []);
    $expenseParticipants = collect([$membership])
        ->merge($membersCollection)
        ->filter()
        ->unique('id')
        ->values()
        ->map(function ($participant) use ($membership) {
            $user = $participant->user ?? null;
            $name = $participant->id === $membership->id ? 'Me' : ($user?->name ?? 'Member');
            $avatar = $user
                ? $user->avatarUrl($name, '0369a1')
                : 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=0369a1&color=ffffff';

            return [
                'name' => $name,
                'avatar' => $avatar,
            ];
        });
    $participantsPreview = $expenseParticipants->isNotEmpty() ? $expenseParticipants : $staticParticipants;
    $participantsCount = $participantsPreview->count();

    $isExpensesPaginated = $expenses instanceof \Illuminate\Contracts\Pagination\Paginator;
    $canShowTotal = $isExpensesPaginated && method_exists($expenses, 'total');
@endphp

<section id="{{ $sectionId }}" class="rounded-2xl border border-cerulean-200 bg-white p-5 shadow-sm md:p-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-xl font-semibold text-cerulean-800">{{ $title }}</h2>
        <div class="flex flex-wrap items-center gap-2">
            <form action="{{ $filterAction }}" method="get" class="flex flex-wrap items-center gap-2">
                <select name="month" class="h-9 rounded-lg border border-cerulean-200 bg-white px-2 text-xs text-cerulean-800 outline-none focus:border-cerulean-600">
                    <option value="">All months</option>
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
                    <a href="{{ $filterAction }}" class="rounded-md border border-cerulean-300 bg-white px-2.5 py-1 text-[11px] font-semibold text-cerulean-700 hover:bg-cerulean-100">
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

    <div class="mt-5 space-y-2 md:hidden">
        @forelse($expenses as $expense)
            @php
                $payerName = $expense->membership?->user?->name ?? 'Payer';
                $payerAvatar = $expense->membership?->user
                    ? $expense->membership->user->avatarUrl($payerName, '0f766e')
                    : 'https://ui-avatars.com/api/?name=' . urlencode($payerName) . '&background=0f766e&color=ffffff';
                $expenseTitle = $expense->title ?? 'Expense title';
                $expenseAmount = number_format((float) ($expense->amount ?? 0), 2, '.', '');
            @endphp
            <article class="rounded-xl border border-cerulean-200 bg-cerulean-50 p-3">
                <div class="flex items-center gap-3">
                    <img src="{{ $payerAvatar }}" alt="Payer avatar" class="h-10 w-10 rounded-lg border border-cerulean-200 object-cover">
                    <p class="min-w-0 flex-1 truncate text-sm font-semibold text-cerulean-800">{{ $expenseTitle }}</p>
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
                <button type="button" data-open-modal="{{ $emptyModalId }}" class="mt-4 rounded-lg bg-cerulean-700 px-4 py-2 text-xs font-semibold text-white hover:bg-cerulean-800">+ Add your first expense</button>
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
                            $payerAvatar = $expense->membership?->user
                                ? $expense->membership->user->avatarUrl($payerName, '0f766e')
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
                                        data-expenses-participants-trigger
                                        class="rounded-full border border-cerulean-200 bg-cerulean-50 px-2.5 py-1 text-xs font-semibold text-cerulean-700"
                                    >
                                        {{ $participantsCount }}
                                    </button>
                                    <template data-expenses-participants-template>
                                        <p class="px-1 pb-1 text-[11px] font-semibold uppercase tracking-[0.1em] text-cerulean-600">Participants</p>
                                        <div class="space-y-1 pr-1">
                                            @foreach($participantsPreview as $participant)
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
                                <button type="button" data-open-modal="{{ $emptyModalId }}" class="mt-4 rounded-lg bg-cerulean-700 px-4 py-2 text-xs font-semibold text-white hover:bg-cerulean-800">+ Add your first expense</button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

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

<div id="{{ $portalId }}" class="pointer-events-none fixed left-0 top-0 z-[70] hidden w-56 rounded-lg border border-cerulean-200 bg-white p-2 shadow-xl"></div>

<script>
    (() => {
        const section = document.getElementById(@js($sectionId));
        const portal = document.getElementById(@js($portalId));
        if (!section || !portal) {
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
            const template = trigger.parentElement?.querySelector('template[data-expenses-participants-template]');
            if (!template) {
                return;
            }

            activeTrigger = trigger;
            portal.innerHTML = template.innerHTML;
            portal.classList.remove('hidden');
            requestAnimationFrame(positionPortal);
        };

        document.addEventListener('mouseenter', (event) => {
            const trigger = event.target.closest('[data-expenses-participants-trigger]');
            if (!trigger || !section.contains(trigger)) {
                return;
            }
            showPortal(trigger);
        }, true);

        document.addEventListener('mouseleave', (event) => {
            const trigger = event.target.closest('[data-expenses-participants-trigger]');
            if (!trigger || activeTrigger !== trigger || !section.contains(trigger)) {
                return;
            }
            hidePortal();
        }, true);

        document.addEventListener('focusin', (event) => {
            const trigger = event.target.closest('[data-expenses-participants-trigger]');
            if (!trigger || !section.contains(trigger)) {
                return;
            }
            showPortal(trigger);
        });

        document.addEventListener('focusout', (event) => {
            const trigger = event.target.closest('[data-expenses-participants-trigger]');
            if (!trigger || activeTrigger !== trigger || !section.contains(trigger)) {
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
