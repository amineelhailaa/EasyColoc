@php
    $primaryTabs = [
        ['key' => 'dashboard', 'label' => 'Dashboard'],
        ['key' => 'members', 'label' => 'Members'],
        ['key' => 'categories', 'label' => 'Categories'],
    ];

    $overflowTabs = [
        ['key' => 'roles', 'label' => 'Roles'],
        ['key' => 'settings', 'label' => 'Settings'],
    ];

    $desktopTabs = array_merge($primaryTabs, $overflowTabs);
    $isMoreActive = in_array($activeTab, ['roles', 'settings'], true);
@endphp

<div class="rounded-3xl p-3 md:p-4">
    <div class="grid w-full grid-cols-4 gap-2 md:hidden" role="tablist" aria-label="Management tabs">
        @foreach($primaryTabs as $tab)
            @php
                $isActive = $activeTab === $tab['key'];
            @endphp
            <button
                type="button"
                wire:click="setTab('{{ $tab['key'] }}')"
                data-tab-btn="{{ $tab['key'] }}"
                role="tab"
                aria-selected="{{ $isActive ? 'true' : 'false' }}"
                class="min-w-0 cursor-pointer rounded-xl px-1.5 py-2 text-center text-[11px] font-semibold transition sm:text-xs {{ $isActive ? 'border-transparent bg-cerulean-700 text-white hover:bg-cerulean-800' : 'border border-cerulean-300 bg-white text-cerulean-700 hover:bg-cerulean-100' }}"
            >
                <span class="block truncate whitespace-nowrap">{{ $tab['label'] }}</span>
            </button>
        @endforeach

        <div class="relative">
            <button
                type="button"
                data-tab-more
                data-more-toggle
                aria-expanded="false"
                aria-haspopup="true"
                class="w-full cursor-pointer rounded-xl px-1.5 py-2 text-center text-[11px] font-semibold transition sm:text-xs {{ $isMoreActive ? 'border-transparent bg-cerulean-700 text-white hover:bg-cerulean-800' : 'border border-cerulean-300 bg-white text-cerulean-700 hover:bg-cerulean-100' }}"
            >
                <span class="block truncate whitespace-nowrap">More</span>
            </button>

            <div data-more-menu class="absolute right-0 z-20 mt-2 hidden w-36 rounded-xl border border-cerulean-200 bg-white p-1.5 shadow-lg">
                @foreach($overflowTabs as $tab)
                    @php
                        $isActive = $activeTab === $tab['key'];
                    @endphp
                    <button
                        type="button"
                        wire:click="setTab('{{ $tab['key'] }}')"
                        data-tab-btn="{{ $tab['key'] }}"
                        data-tab-menu
                        class="block w-full cursor-pointer rounded-lg px-3 py-2 text-left text-xs font-semibold transition {{ $isActive ? 'bg-cerulean-700 text-white hover:bg-cerulean-800' : 'text-cerulean-700 hover:bg-cerulean-100' }}"
                    >
                        {{ $tab['label'] }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="hidden w-full gap-2 md:grid md:grid-cols-5" role="tablist" aria-label="Management tabs">
        @foreach($desktopTabs as $tab)
            @php
                $isActive = $activeTab === $tab['key'];
            @endphp
            <button
                type="button"
                wire:click="setTab('{{ $tab['key'] }}')"
                data-tab-btn="{{ $tab['key'] }}"
                role="tab"
                aria-selected="{{ $isActive ? 'true' : 'false' }}"
                class="min-w-0 cursor-pointer rounded-xl px-2 py-2 text-center text-xs font-semibold transition sm:text-sm {{ $isActive ? 'border-transparent bg-cerulean-700 text-white hover:bg-cerulean-800' : 'border border-cerulean-300 bg-white text-cerulean-700 hover:bg-cerulean-100' }}"
            >
                <span class="block truncate whitespace-nowrap">{{ $tab['label'] }}</span>
            </button>
        @endforeach
    </div>

    <div class="mt-5 {{ $activeTab === 'members' ? '' : 'hidden' }}" data-tab-panel="members" role="tabpanel">
        <section>
            <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
                <h2 class="text-lg font-semibold text-cerulean-800">Members</h2>
                <button
                    type="button"
                    data-open-modal="invite-member-modal"
                    class="rounded-xl border border-cerulean-300 bg-cerulean-50 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-100"
                >
                    Invite Member
                </button>
            </div>

            <div class="overflow-hidden rounded-2xl border border-cerulean-200 bg-white">
                <div class="owner-x-scroll">
                    <table class="min-w-full text-sm">
                        <thead class="bg-cerulean-100/70 text-cerulean-800">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Name</th>
                            <th class="px-4 py-3 text-left font-semibold">Email</th>
                            <th class="px-4 py-3 text-left font-semibold">Date Joined</th>
                            <th class="px-4 py-3 text-left font-semibold">Left At</th>
                            <th class="px-4 py-3 text-left font-semibold">Reputation</th>
                            <th class="px-4 py-3 text-left font-semibold">Total Paid Expenses</th>
                            <th class="px-4 py-3 text-right font-semibold">Action</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-cerulean-100">
                        @forelse($members as $member)
                            <tr class="group bg-white transition hover:bg-cerulean-50/60">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $member['avatar'] }}" alt="Member avatar" class="h-9 w-9 rounded-lg border border-cerulean-200 object-cover">
                                        <span class="font-medium text-cerulean-900">{{ $member['name'] }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-cerulean-700">{{ $member['email'] }}</td>
                                <td class="px-4 py-3 text-cerulean-700">{{ $member['joined_at'] }}</td>
                                <td class="px-4 py-3 text-cerulean-700">{{ $member['left_at'] }}</td>
                                <td class="px-4 py-3 text-cerulean-700">{{ $member['reputation'] }}</td>
                                <td class="px-4 py-3 text-cerulean-700">{{ $member['total_paid_expenses'] }} MAD</td>
                                <td class="px-4 py-3 text-right">
                                    <form method="POST" action="{{ route('owner.kick', $member['id']) }}" onsubmit="return confirm('Are you sure you want to remove this member?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-button variant="danger" class="!h-9 !w-auto px-3 text-xs opacity-100 transition md:pointer-events-none md:opacity-0 md:group-hover:pointer-events-auto md:group-hover:opacity-100">
                                            Kick
                                        </x-button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-cerulean-600">No members found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <div class="mt-5 {{ $activeTab === 'categories' ? '' : 'hidden' }}" data-tab-panel="categories" role="tabpanel">
        <section>
            <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
                <h2 class="text-lg font-semibold text-cerulean-800">Categories</h2>
                <button
                    type="button"
                    data-open-modal="add-category-modal"
                    class="rounded-xl border border-cerulean-300 bg-cerulean-50 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-100"
                >
                    Add Category
                </button>
            </div>

            <div class="overflow-hidden rounded-2xl border border-cerulean-200 bg-white">
                <div class="owner-x-scroll">
                    <table class="min-w-full text-sm">
                        <thead class="bg-cerulean-100/70 text-cerulean-800">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Name</th>
                            <th class="px-4 py-3 text-right font-semibold">Action</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-cerulean-100">
                        @forelse($categories as $category)
                            <tr class="group bg-white transition hover:bg-cerulean-50/60">
                                <td class="px-4 py-3 font-medium text-cerulean-900">{{ $category['name'] }}</td>
                                <td class="px-4 py-3 text-right">
                                    <button
                                        type="button"
                                        data-open-modal="delete-category-modal"
                                        data-category-id="{{ $category['id'] }}"
                                        data-category-name="{{ $category['name'] }}"
                                        class="rounded-lg border border-red-200 bg-white px-3 py-1.5 text-xs font-semibold text-red-600 transition md:pointer-events-none md:opacity-0 md:group-hover:pointer-events-auto md:group-hover:opacity-100 hover:bg-red-50"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-6 text-center text-cerulean-600">No categories found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <div class="mt-5 {{ $activeTab === 'roles' ? '' : 'hidden' }}" data-tab-panel="roles" role="tabpanel">
        <section class="rounded-2xl border border-dashed border-cerulean-300 bg-cerulean-50 p-6">
            <h2 class="text-2xl font-semibold text-cerulean-800">Manage Roles</h2>
            <p class="mt-2 text-sm text-cerulean-700">This section is ready for your custom role management content.</p>
        </section>
    </div>

    <div class="mt-5 {{ $activeTab === 'settings' ? '' : 'hidden' }}" data-tab-panel="settings" role="tabpanel">
        <section class="rounded-2xl border border-dashed border-cerulean-300 bg-cerulean-50 p-6">
            <form method="POST" action="{{ route('owner.colocation.delete') }}" onsubmit="return confirm('Are you sure you want to delete this colocation?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-100">
                    Delete Colocation
                </button>
            </form>
        </section>
    </div>
</div>
