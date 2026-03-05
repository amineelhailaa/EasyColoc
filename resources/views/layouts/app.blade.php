<!doctype html>
<html lang="fr" class="h-full overflow-x-hidden">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'EasyColoc' }}</title>
    @stack('head')
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="flex min-h-screen flex-col overflow-x-hidden bg-cerulean-50 text-cerulean-900">
<x-navbar></x-navbar>
@php
    $hasBottomNav = trim((string) ($bottomNav ?? '')) !== '';
@endphp
<div class="flex-1 {{ $hasBottomNav ? 'pb-6 md:pb-8' : '' }}">
    {{-- Top bar --}}
    {{ $topbar ?? '' }}

    <div class="px-4 py-4">
        @yield('content')
    </div>
</div>

{{-- Bottom nav (mobile-first) --}}
{{ $bottomNav ?? '' }}
</body>
</html>
