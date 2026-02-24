@props([
    'name' => 'avatar',
    'label' => 'Avatar (optional)',
    'previewSrc' => '',
    'accept' => 'image/*',
    'required' => false,
])

@php
    $id = $attributes->get('id', $name);
    $hasError = $errors->has($name);
    $base = 'block w-full rounded-2xl bg-white px-4 py-3 text-sm text-cerulean-700 border file:mr-4 file:rounded-xl file:border-0 file:bg-cerulean-100 file:px-3 file:py-2 file:font-semibold file:text-cerulean-700 hover:file:bg-cerulean-200';
    $state = $hasError
      ? 'border-red-500 focus:border-red-500 focus:ring-4 focus:ring-red-100'
      : 'border-cerulean-200 focus:border-cerulean-600 focus:ring-4 focus:ring-cerulean-100';
    $resolvedPreviewSrc = trim((string) $previewSrc);
@endphp

<div data-avatar-upload>
    <label for="{{ $id }}" class="block text-xs font-medium text-cerulean-800">
        {{ $label }} @if($required)<span class="text-red-600">*</span>@endif
    </label>

    <div class="mt-2 flex items-center gap-4">
        <img
            data-avatar-preview
            src="{{ $resolvedPreviewSrc }}"
            data-default-src="{{ $resolvedPreviewSrc }}"
            alt="Avatar preview"
            class="{{ $resolvedPreviewSrc ? '' : 'hidden' }} h-16 w-16 rounded-2xl border border-cerulean-200 object-cover"
        />

        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="file"
            accept="{{ $accept }}"
            @if($required) required @endif
            data-avatar-input
            {{ $attributes->merge(['class' => trim("$base $state")]) }}
        />
    </div>

    <x-form.error :name="$name" />
</div>

<script>
    (() => {
        const script = document.currentScript;
        const root = script ? script.previousElementSibling : null;
        if (!root || !root.hasAttribute('data-avatar-upload')) return;

        const input = root.querySelector('[data-avatar-input]');
        const preview = root.querySelector('[data-avatar-preview]');
        if (!input || !preview) return;

        let objectUrl = null;

        const resetPreview = () => {
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
                objectUrl = null;
            }

            const defaultSrc = preview.dataset.defaultSrc || '';
            preview.src = defaultSrc;
            preview.classList.toggle('hidden', defaultSrc === '');
        };

        input.addEventListener('change', () => {
            const file = input.files && input.files[0];
            if (!file || !file.type.startsWith('image/')) {
                resetPreview();
                return;
            }

            if (objectUrl) URL.revokeObjectURL(objectUrl);
            objectUrl = URL.createObjectURL(file);
            preview.src = objectUrl;
            preview.classList.remove('hidden');
        });

        window.addEventListener('beforeunload', () => {
            if (objectUrl) URL.revokeObjectURL(objectUrl);
        });
    })();
</script>
