@props([
    'membership',
    'members' => collect(),
    'categories' => collect(),
    'modalId' => 'add-expense-modal',
])

@php
    $membersCollection = collect($members)->filter();
    $splitParticipants = collect([$membership])
        ->merge($membersCollection->where('id', '!=', $membership->id))
        ->unique('id')
        ->values();

    $defaultSplitIds = $splitParticipants->pluck('id')->map(fn ($id) => (string) $id)->all();
    $selectedSplitIds = $defaultSplitIds;
    $modalKey = str_replace('-modal', '', (string) $modalId);
@endphp


<style>
    [data-expense-form-modal="{{ $modalId }}"] input[data-percent-range] {
        -webkit-appearance: none;
        appearance: none;
        height: 8px;
        border-radius: 999px;
        background: linear-gradient(to right, #0369a1 0%, #0369a1 0%, #d6e5ee 0%, #d6e5ee 100%);
        outline: none;
    }

    [data-expense-form-modal="{{ $modalId }}"] input[data-percent-range]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 16px;
        height: 16px;
        border-radius: 999px;
        border: 2px solid #0369a1;
        background: #ffffff;
        cursor: pointer;
    }

    [data-expense-form-modal="{{ $modalId }}"] input[data-percent-range]::-moz-range-thumb {
        width: 16px;
        height: 16px;
        border-radius: 999px;
        border: 2px solid #0369a1;
        background: #ffffff;
        cursor: pointer;
    }

    [data-expense-form-modal="{{ $modalId }}"] [data-split-row].is-disabled {
        opacity: 0.55;
    }

    /* Keep vertical scroll behavior but hide the visual scrollbar. */
    [data-expense-form-modal="{{ $modalId }}"] .expense-form-scroll {
        max-height: 90vh;
        -webkit-overflow-scrolling: touch;
        overscroll-behavior-y: contain;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    @supports (height: 100dvh) {
        [data-expense-form-modal="{{ $modalId }}"] .expense-form-scroll {
            max-height: calc(100dvh - 2rem);
        }
    }

    @media (max-width: 639px) {
        [data-expense-form-modal="{{ $modalId }}"] .expense-form-scroll {
            max-height: calc(100dvh - 1.5rem);
        }
    }

    [data-expense-form-modal="{{ $modalId }}"] .expense-form-scroll::-webkit-scrollbar {
        width: 0;
        height: 0;
    }
</style>

<div id="{{ $modalId }}" data-expense-form-modal="{{ $modalId }}" class=" fixed inset-0 z-50 hidden items-start justify-center overflow-y-auto bg-cerulean-900/50 p-3 sm:items-center sm:p-4 ">
    <div class="expense-form-scroll max-h-64  w-full max-w-lg overflow-y-auto rounded-2xl border border-cerulean-200 bg-white p-5 shadow-xl">
        <div class="flex items-start justify-between gap-3">
            <div>
                <h3 class="text-lg font-semibold text-cerulean-800">Add Expense</h3>
                <p class="mt-1 text-xs text-cerulean-600">Create a new expense for the group.</p>
            </div>
            <button
                type="button"
                data-close-modal
                aria-label="Close"
                title="Close"
                class="rounded-lg p-2 text-cerulean-700 transition hover:bg-cerulean-100 hover:text-cerulean-900"
            >
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M4.22 4.22a.75.75 0 011.06 0L10 8.94l4.72-4.72a.75.75 0 111.06 1.06L11.06 10l4.72 4.72a.75.75 0 11-1.06 1.06L10 11.06l-4.72 4.72a.75.75 0 01-1.06-1.06L8.94 10 4.22 5.28a.75.75 0 010-1.06z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <form class="mt-4 grid gap-3 sm:grid-cols-2" action="{{ route('expense.add') }}" method="post" enctype="multipart/form-data">
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
                        <option value="{{ $category->id }}" @selected((string) old('category_id') === (string) $category->id)>
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
                    @foreach($membersCollection as $member)
                        @if($member->id !== $membership->id)
                            <option value="{{ $member->id }}" @selected((string) old('membership_id', $membership->id) === (string) $member->id)>
                                {{ $member->user->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                <x-form.error name="membership_id" />
            </div>

            <div class="mt-4 sm:col-span-2">
                <label class="block text-xs font-medium text-cerulean-800">Attach Receipt</label>
                <div id="file-dropzone-{{ $modalKey }}-input" class="mt-2 flex cursor-pointer justify-center rounded-xl border border-dashed border-cerulean-300 px-6 py-8 transition hover:bg-cerulean-50">
                    <div class="text-center">
                        <svg class="mx-auto h-8 w-8 text-cerulean-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <div class="mt-4 flex text-sm leading-6 text-cerulean-600">
                            <span id="file-upload-primary-{{ $modalKey }}-text" class="relative rounded-md bg-transparent font-semibold text-cerulean-700">Upload a file</span>
                            <p id="file-upload-secondary-{{ $modalKey }}-text" class="pl-1">or drag and drop</p>
                        </div>
                        <p id="file-upload-hint-{{ $modalKey }}-text" class="text-xs leading-5 text-cerulean-500">PNG, JPG, PDF up to 5MB</p>
                    </div>
                </div>
                <input
                    id="file-upload-input-{{ $modalKey }}"
                    name="attachment"
                    type="file"
                    accept=".pdf,.png,.jpg,.jpeg,application/pdf,image/png,image/jpeg"
                    class="sr-only"
                >
                <p id="file-upload-name-{{ $modalKey }}-text" class="mt-2 text-xs text-cerulean-500">No file chosen</p>
                <x-form.error name="attachment" />
            </div>

            <div class="sm:col-span-2">
                <div class="flex items-center justify-between gap-3">
                    <p class="block text-xs font-medium text-cerulean-800">Split Mode</p>
                    <input type="hidden" name="split_mode" value="equal" data-split-mode-input>
                </div>

                <div class="mt-2 grid grid-cols-3 gap-2 rounded-xl p-1">
                    <button
                        type="button"
                        data-split-tab-btn="equal"
                        class="cursor-pointer rounded-lg border-transparent bg-cerulean-700 px-2 py-1.5 text-xs font-semibold text-white transition hover:bg-cerulean-800"
                    >
                        Select With
                    </button>
                    <button
                        type="button"
                        data-split-tab-btn="manual"
                        class="cursor-pointer rounded-lg border border-cerulean-200 bg-white px-2 py-1.5 text-xs font-semibold text-cerulean-700 transition hover:bg-cerulean-100"
                    >
                        Manual
                    </button>
                    <button
                        type="button"
                        data-split-tab-btn="percentage"
                        class="cursor-pointer rounded-lg border border-cerulean-200 bg-white px-2 py-1.5 text-xs font-semibold text-cerulean-700 transition hover:bg-cerulean-100"
                    >
                        Percentage
                    </button>
                </div>

                <div class="mt-2">
                    <label class="flex cursor-pointer items-center gap-2 rounded-lg px-1 py-1 text-sm font-medium text-cerulean-800">
                        <input
                            type="checkbox"
                            data-split-all-checkbox
                            class="h-4 w-4 rounded border-cerulean-300 text-cerulean-700 focus:ring-cerulean-400"
                            checked
                        >
                        <span>All</span>
                    </label>
                </div>

                <div class="mt-2 divide-y divide-cerulean-200">
                    @foreach($splitParticipants as $participant)
                        @php
                            $participantName = $participant->id === $membership->id ? 'Me' : ($participant->user->name ?? 'Member');
                            $participantAvatar = $participant->user->avatar
                                ? asset('storage/' . $participant->user->avatar)
                                : 'https://ui-avatars.com/api/?name=' . urlencode($participantName) . '&background=0369a1&color=ffffff';
                            $percentageValue = (int) old('percentage_entries.' . $participant->id, 0);
                        @endphp
                        <div class="flex flex-col gap-2 py-2 sm:flex-row sm:items-center sm:justify-between sm:gap-3" data-split-row data-member-id="{{ $participant->id }}">
                            <label class="flex min-w-0 items-center gap-2 px-1 py-1 text-sm text-cerulean-800 sm:flex-1">
                                <input
                                    type="checkbox"
                                    name="split_with[]"
                                    value="{{ $participant->id }}"
                                    data-split-user-checkbox
                                    class="h-4 w-4 rounded border-cerulean-300 text-cerulean-700 focus:ring-cerulean-400"
                                    @checked(in_array((string) $participant->id, $selectedSplitIds, true))
                                >
                                <img src="{{ $participantAvatar }}" alt="{{ $participantName }} avatar" class="h-8 w-8 rounded-full border border-cerulean-200 object-cover">
                                <span class="truncate font-medium">{{ $participantName }}</span>
                            </label>

                            <div class="w-full px-1 py-1 text-cerulean-800 sm:min-w-[170px] sm:w-auto">
                                <div data-split-cell="equal" class="flex h-full items-center justify-between gap-2 sm:justify-end">
                                    <span class="text-[11px] text-cerulean-600">Equal</span>
                                    <span data-equal-amount="{{ $participant->id }}" class="text-sm font-semibold text-cerulean-800">0.00 MAD</span>
                                </div>

                                <div data-split-cell="manual" class="hidden">
                                    <div class="relative w-full sm:ml-auto sm:max-w-[180px]">
                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            name="manual_entries[{{ $participant->id }}]"
                                            data-manual-amount
                                            value="{{ old('manual_entries.' . $participant->id, '') }}"
                                            placeholder="0.00"
                                            class="h-9 w-full rounded-lg border border-cerulean-200 bg-white pl-3 pr-10 text-sm text-cerulean-800 outline-none focus:border-cerulean-600 disabled:cursor-not-allowed disabled:bg-cerulean-100"
                                        >
                                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[11px] font-semibold text-cerulean-600">MAD</span>
                                    </div>
                                </div>

                                <div data-split-cell="percentage" class="hidden space-y-1">
                                    <div class="flex items-center justify-between">
                                        <span data-percent-output="{{ $participant->id }}" class="text-xs font-semibold text-cerulean-700">{{ $percentageValue }}%</span>
                                        <span data-percent-amount="{{ $participant->id }}" class="text-xs font-semibold text-cerulean-800">0.00 MAD</span>
                                    </div>
                                    <input
                                        type="range"
                                        min="0"
                                        max="100"
                                        step="1"
                                        name="percentage_entries[{{ $participant->id }}]"
                                        value="{{ $percentageValue }}"
                                        data-percent-range="{{ $participant->id }}"
                                        class="w-full cursor-pointer disabled:cursor-not-allowed"
                                    >
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="sm:col-span-2 flex justify-end gap-2 pt-2">
                <button type="button" data-close-modal class="rounded-xl border border-cerulean-300 px-4 py-2 text-sm font-semibold text-cerulean-700 hover:bg-cerulean-50">Cancel</button>
                <button type="submit" class="rounded-xl bg-cerulean-700 px-4 py-2 text-sm font-semibold text-white hover:bg-cerulean-800">Add Expense</button>
            </div>
        </form>
    </div>
</div>

<script>
    (() => {
        const modalId = @json($modalId);
        const modalKey = @json($modalKey);
        const modal = document.getElementById(modalId);

        if (!modal) {
            return;
        }

        const getSplitCheckboxes = () => modal.querySelectorAll('input[data-split-user-checkbox]');
        const getAllCheckbox = () => modal.querySelector('input[data-split-all-checkbox]');
        const tabButtons = () => modal.querySelectorAll('[data-split-tab-btn]');
        const splitRows = () => modal.querySelectorAll('[data-split-row]');
        const modeInput = () => modal.querySelector('[data-split-mode-input]');
        const amountInput = () => modal.querySelector('#expense-amount');
        const fileInput = modal.querySelector(`#file-upload-input-${modalKey}`);
        const fileDropzone = modal.querySelector(`#file-dropzone-${modalKey}-input`);
        const fileName = modal.querySelector(`#file-upload-name-${modalKey}-text`);
        const filePrimaryText = modal.querySelector(`#file-upload-primary-${modalKey}-text`);
        const fileSecondaryText = modal.querySelector(`#file-upload-secondary-${modalKey}-text`);
        const fileHintText = modal.querySelector(`#file-upload-hint-${modalKey}-text`);
        let fileLocked = false;
        const toMoney = (value) => `${(Number(value) || 0).toFixed(2)} MAD`;
        const readAmount = () => Math.max(0, Number(amountInput()?.value) || 0);

        const unlockFileUpload = () => {
            fileLocked = false;

            if (fileDropzone) {
                fileDropzone.classList.remove('pointer-events-none', 'border-emerald-300', 'bg-emerald-50');
                fileDropzone.classList.add('cursor-pointer', 'border-cerulean-300');
                fileDropzone.classList.remove('cursor-default');
            }

            if (fileName) {
                fileName.textContent = 'No file chosen';
                fileName.classList.remove('text-emerald-700');
                fileName.classList.add('text-cerulean-500');
            }

            if (filePrimaryText) {
                filePrimaryText.textContent = 'Upload a file';
                filePrimaryText.classList.remove('text-emerald-700');
                filePrimaryText.classList.add('text-cerulean-700');
            }

            if (fileSecondaryText) {
                fileSecondaryText.textContent = 'or drag and drop';
            }

            if (fileHintText) {
                fileHintText.textContent = 'PNG, JPG, PDF up to 5MB';
                fileHintText.classList.remove('text-emerald-700');
                fileHintText.classList.add('text-cerulean-500');
            }
        };

        const lockFileUpload = (selectedName) => {
            fileLocked = true;

            if (fileDropzone) {
                fileDropzone.classList.add('pointer-events-none', 'border-emerald-300', 'bg-emerald-50', 'cursor-default');
                fileDropzone.classList.remove('cursor-pointer', 'border-cerulean-300');
            }

            if (fileName) {
                fileName.textContent = selectedName;
                fileName.classList.remove('text-cerulean-500');
                fileName.classList.add('text-emerald-700');
            }

            if (filePrimaryText) {
                filePrimaryText.textContent = 'Receipt attached';
                filePrimaryText.classList.remove('text-cerulean-700');
                filePrimaryText.classList.add('text-emerald-700');
            }

            if (fileSecondaryText) {
                fileSecondaryText.textContent = '';
            }

            if (fileHintText) {
                fileHintText.textContent = 'Upload locked for this expense.';
                fileHintText.classList.remove('text-cerulean-500');
                fileHintText.classList.add('text-emerald-700');
            }
        };

        const setActiveSplitTab = (tab) => {
            tabButtons().forEach((button) => {
                const isActive = button.dataset.splitTabBtn === tab;
                button.classList.toggle('bg-cerulean-700', isActive);
                button.classList.toggle('text-white', isActive);
                button.classList.toggle('hover:bg-cerulean-800', isActive);
                button.classList.toggle('border-transparent', isActive);

                button.classList.toggle('border', !isActive);
                button.classList.toggle('border-cerulean-200', !isActive);
                button.classList.toggle('bg-white', !isActive);
                button.classList.toggle('text-cerulean-700', !isActive);
                button.classList.toggle('hover:bg-cerulean-100', !isActive);
            });

            splitRows().forEach((row) => {
                row.querySelectorAll('[data-split-cell]').forEach((cell) => {
                    cell.classList.toggle('hidden', cell.dataset.splitCell !== tab);
                });
            });

            const input = modeInput();
            if (input) {
                input.value = tab;
            }
        };

        const selectAllSplitUsers = (checked) => {
            getSplitCheckboxes().forEach((checkbox) => {
                checkbox.checked = checked;
            });
        };

        const syncAllCheckbox = () => {
            const allCheckbox = getAllCheckbox();
            if (!allCheckbox) {
                return;
            }

            const checkboxes = [...getSplitCheckboxes()];
            if (checkboxes.length === 0) {
                allCheckbox.checked = false;
                return;
            }

            allCheckbox.checked = checkboxes.every((checkbox) => checkbox.checked);
        };

        const updateEqualAmounts = () => {
            const checkboxes = [...getSplitCheckboxes()];
            const selectedCount = checkboxes.filter((checkbox) => checkbox.checked).length;
            const equalAmount = selectedCount > 0 ? readAmount() / selectedCount : 0;

            splitRows().forEach((row) => {
                const memberId = row.dataset.memberId;
                const checkbox = row.querySelector('input[data-split-user-checkbox]');
                const equalOutput = row.querySelector(`[data-equal-amount="${memberId}"]`);
                if (!checkbox || !equalOutput) {
                    return;
                }

                const amount = checkbox.checked ? equalAmount : 0;
                equalOutput.textContent = toMoney(amount);
                equalOutput.classList.toggle('text-cerulean-800', checkbox.checked);
                equalOutput.classList.toggle('text-cerulean-500', !checkbox.checked);
            });
        };

        const updateManualDefaults = (force = false) => {
            const checkboxes = [...getSplitCheckboxes()];
            const selectedCount = checkboxes.filter((checkbox) => checkbox.checked).length;
            const equalAmount = selectedCount > 0 ? readAmount() / selectedCount : 0;

            splitRows().forEach((row) => {
                const checkbox = row.querySelector('input[data-split-user-checkbox]');
                const manualInput = row.querySelector('input[data-manual-amount]');
                if (!checkbox || !manualInput || !checkbox.checked) {
                    return;
                }

                const isDirty = manualInput.dataset.manualDirty === 'true';
                if (!force && isDirty) {
                    return;
                }

                manualInput.value = equalAmount.toFixed(2);
            });
        };

        const updateSplitRowState = (checkbox) => {
            const row = checkbox.closest('[data-split-row]');
            if (!row) {
                return;
            }

            const isEnabled = checkbox.checked;
            const manualInput = row.querySelector('input[data-manual-amount]');
            const percentageInput = row.querySelector('input[data-percent-range]');

            row.classList.toggle('is-disabled', !isEnabled);

            if (manualInput) {
                manualInput.disabled = !isEnabled;
                if (!isEnabled) {
                    manualInput.value = '';
                    manualInput.dataset.manualDirty = 'false';
                }
            }

            if (percentageInput) {
                percentageInput.disabled = !isEnabled;
                if (!isEnabled) {
                    percentageInput.value = '0';
                }
                updateRangeFill(percentageInput);
            }
        };

        const updateAllRowsState = () => {
            getSplitCheckboxes().forEach((checkbox) => {
                updateSplitRowState(checkbox);
            });
        };

        const updateRangeFill = (rangeInput) => {
            const percent = Math.max(0, Math.min(100, Number(rangeInput.value) || 0));
            const memberId = rangeInput.dataset.percentRange;
            const output = modal.querySelector(`[data-percent-output="${memberId}"]`);
            const amountOutput = modal.querySelector(`[data-percent-amount="${memberId}"]`);
            if (output) {
                output.textContent = `${percent}%`;
            }
            if (amountOutput) {
                amountOutput.textContent = toMoney((readAmount() * percent) / 100);
            }
            rangeInput.style.background = `linear-gradient(to right, #0369a1 0%, #0369a1 ${percent}%, #d6e5ee ${percent}%, #d6e5ee 100%)`;
        };

        const updatePercentageData = () => {
            modal.querySelectorAll('[data-percent-range]').forEach((rangeInput) => {
                updateRangeFill(rangeInput);
            });
        };

        const refreshComputedData = () => {
            updateEqualAmounts();
            updateManualDefaults();
            updatePercentageData();
        };

        const resetSplitDefaults = () => {
            selectAllSplitUsers(true);
            setActiveSplitTab('equal');
            modal.querySelectorAll('[data-percent-range]').forEach((rangeInput) => {
                rangeInput.value = '0';
            });
            modal.querySelectorAll('[data-manual-amount]').forEach((manualInput) => {
                manualInput.dataset.manualDirty = 'false';
            });
            if (fileInput) {
                fileInput.value = '';
            }
            unlockFileUpload();
            const scrollContainer = modal.querySelector('.expense-form-scroll');
            if (scrollContainer) {
                scrollContainer.scrollTop = 0;
            }
            updateAllRowsState();
            updateManualDefaults(true);
            syncAllCheckbox();
            refreshComputedData();
        };

        modal.querySelectorAll('[data-manual-amount]').forEach((manualInput) => {
            manualInput.dataset.manualDirty = manualInput.value.trim() !== '' ? 'true' : 'false';
        });

        updateAllRowsState();
        syncAllCheckbox();
        refreshComputedData();

        document.addEventListener('click', (event) => {
            const openButton = event.target.closest('[data-open-modal]');
            if (openButton && openButton.dataset.openModal === modalId) {
                requestAnimationFrame(() => {
                    resetSplitDefaults();
                });
                return;
            }

            if (!modal.contains(event.target)) {
                return;
            }

            const splitTabButton = event.target.closest('[data-split-tab-btn]');
            if (splitTabButton) {
                setActiveSplitTab(splitTabButton.dataset.splitTabBtn || 'equal');
                return;
            }
        });

        modal.addEventListener('input', (event) => {
            if (event.target.id === 'expense-amount') {
                refreshComputedData();
                return;
            }

            const rangeInput = event.target.closest('[data-percent-range]');
            if (rangeInput) {
                updateRangeFill(rangeInput);
                return;
            }

            const checkbox = event.target.closest('input[data-split-user-checkbox]');
            if (checkbox) {
                updateSplitRowState(checkbox);
                syncAllCheckbox();
                updateEqualAmounts();
                updateManualDefaults();
                return;
            }

            const manualInput = event.target.closest('input[data-manual-amount]');
            if (manualInput) {
                manualInput.dataset.manualDirty = 'true';
                return;
            }
        });

        modal.addEventListener('change', (event) => {
            const allCheckbox = event.target.closest('input[data-split-all-checkbox]');
            if (allCheckbox) {
                selectAllSplitUsers(allCheckbox.checked);
                updateAllRowsState();
                syncAllCheckbox();
                refreshComputedData();
                return;
            }

            const checkbox = event.target.closest('input[data-split-user-checkbox]');
            if (!checkbox) {
                return;
            }
            updateSplitRowState(checkbox);
            syncAllCheckbox();
            updateEqualAmounts();
            updateManualDefaults();
        });

        if (fileInput && fileName) {
            fileInput.addEventListener('change', () => {
                const selectedName = fileInput.files && fileInput.files.length > 0
                    ? fileInput.files[0].name
                    : '';

                if (!selectedName) {
                    unlockFileUpload();
                    return;
                }

                lockFileUpload(selectedName);
            });
        }

        if (fileDropzone && fileInput) {
            // Keep file picker interaction inside modal and prevent accidental backdrop close.
            fileDropzone.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();
                if (fileLocked) {
                    return;
                }
                fileInput.click();
            });
        }
    })();
</script>
