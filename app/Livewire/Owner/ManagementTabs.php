<?php

namespace App\Livewire\Owner;

use Livewire\Component;

class ManagementTabs extends Component
{
    public string $activeTab = 'dashboard';

    public $members = [];

    public $categories = [];

    public function mount($members = [], $categories = []): void
    {
        $this->members = collect($members)->map(function ($member) {
            $name = $member->user->name ?? 'Member';
            $email = $member->user->email ?? '-';
            $joinedAt = $member->created_at ? $member->created_at->format('M d, Y') : '-';
            $leftAt = $member->left_at ? $member->left_at->format('M d, Y') : '-';
            $totalPaid = (float) ($member->total_paid_expenses ?? 0);

            return [
                'id' => $member->id,
                'role' => $member->role,
                'name' => $name,
                'email' => $email,
                'joined_at' => $joinedAt,
                'left_at' => $leftAt,
                'total_paid_expenses' => number_format($totalPaid, 2, '.', ''),
                'reputation' => $member->user->reputation ?? 0,
                'avatar' => $member->user
                    ? $member->user->avatarUrl($name, '0f766e')
                    : 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=0f766e&color=ffffff',
            ];
        })->values()->all();

        $this->categories = collect($categories)->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
            ];
        })->values()->all();
    }

    public function setTab(string $tab): void
    {
        if (!in_array($tab, ['dashboard', 'members', 'categories', 'roles', 'settings'], true)) {
            return;
        }

        $this->activeTab = $tab;
        $this->dispatch('global-tab-changed', tab: $this->activeTab);
    }

    public function render()
    {
        return view('livewire.owner.management-tabs');
    }
}
