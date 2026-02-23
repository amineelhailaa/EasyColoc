@props(['subtitle' => null])

<div class="text-center">
    <div class="flex justify-center">
        <span class="text-4xl font-extrabold tracking-tight text-cerulean-800">EasyColoc</span>
    </div>

    @if($subtitle)
        <p class="mt-2 text-sm text-cerulean-800">{{ $subtitle }}</p>
    @endif
</div>
