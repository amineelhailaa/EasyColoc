# ManagementTabs Livewire Component

This component renders and controls the owner management tabs UI (members, categories, roles, settings) and keeps tab state in Livewire.

## Files

- `app/Livewire/Owner/ManagementTabs.php`
- `resources/views/livewire/owner/management-tabs.blade.php`

## Purpose

- Provide a tab navigation block for owner actions.
- Prepare member/category data for safe rendering in Blade.
- Emit a browser event when the active tab changes so parent page scripts can react.

## Public State and API

### Public properties

- `$activeTab` (`string`): current tab key, defaults to `dashboard`.
- `$members` (`array`): normalized member rows for the members table.
- `$categories` (`array`): normalized category rows for the categories table.

### `mount($members = [], $categories = [])`

Normalizes incoming data into render-ready arrays:

- Members are mapped to:
  - `id`, `role`, `name`, `email`
  - `joined_at`, `left_at` (formatted `M d, Y`, fallback `-`)
  - `total_paid_expenses` (2-decimal string)
  - `reputation`
  - `avatar` (`storage/...` URL or `ui-avatars.com` fallback)
- Categories are mapped to:
  - `id`, `name`

### `setTab(string $tab)`

- Accepts only: `dashboard`, `members`, `categories`, `roles`, `settings`.
- If invalid key: exits without changing state.
- If valid key:
  - updates `$activeTab`
  - dispatches browser event: `global-tab-changed` with `{ tab: <activeTab> }`

### `render()`

Returns `livewire.owner.management-tabs`.

## Blade Structure

### 1) Navigation

- Mobile (`md:hidden`):
  - primary tabs: `Dashboard`, `Members`, `Categories`
  - `More` dropdown contains `Roles` and `Settings`
- Desktop (`md:grid`):
  - all five tabs shown directly

All tab buttons call Livewire:

```blade
wire:click="setTab('members')"
```

### 2) Panels

The component conditionally shows panels using:

```blade
{{ $activeTab === 'members' ? '' : 'hidden' }}
```

Panels included here:

- `members`: members table + invite button
- `categories`: categories table + add/delete actions
- `roles`: placeholder section
- `settings`: delete-colocation action

Note: the `dashboard` tab content is not inside this Livewire component. It is controlled by parent page markup/scripts.

## Parent Page Integration

Current usage:

```blade
<livewire:owner.management-tabs :members="$members" :categories="$categories" />
```

Used in:

- `resources/views/colocation/owner/dashboard.blade.php`

The parent dashboard JS listens to `global-tab-changed` to:

- show/hide global dashboard sections when tab is `dashboard`
- update active styles/panels
- close/open the mobile `More` dropdown state

## Route and Modal Dependencies

The component markup expects these routes to exist:

- `owner.kick` (`DELETE /owner/kick/{member}`)
- `owner.colocation.delete` (`DELETE /owner/colocation/delete`)

The component also triggers modal open actions via `data-open-modal` attributes. Parent page JS should provide modals with matching IDs:

- `invite-member-modal`
- `add-category-modal`
- `delete-category-modal`

## Data Requirements

For best results, pass members with loaded `user` relation and date fields:

- `$member->user->name`, `$member->user->email`, `$member->user->avatar`, `$member->user->reputation`
- `$member->created_at`, `$member->left_at`
- `$member->total_paid_expenses`

If values are missing, the component uses safe fallbacks (`Member`, `-`, default avatar, `0`).

## Extending Tabs Safely

When adding a new tab key:

1. Add key to `setTab()` allowlist in `ManagementTabs.php`.
2. Add button entry in Blade tab arrays (`$primaryTabs` or `$overflowTabs`).
3. Add a panel block with matching `data-tab-panel`.
4. Update parent dashboard JS if tab-specific behavior is needed (for example `isMoreActive` logic).
