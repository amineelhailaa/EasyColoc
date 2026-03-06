@php
    $title = 'Invitation - EasyColoc';
@endphp

@extends('layouts.app')

@section('content')
    <div class="mx-auto flex min-h-[75vh] w-full max-w-xl items-center justify-center">
        <x-card class="w-full rounded-3xl p-6 md:p-8">
            <div class="flex flex-col items-center text-center">
                <img
                    src="{{ $colocation->avatarUrl($colocation->name ?? 'Colocation', '0369a1') }}"
                    alt="Colocation logo"
                    class="h-24 w-24 rounded-2xl border border-cerulean-200 object-cover"
                >
                <h1 class="mt-4 text-2xl font-semibold text-cerulean-800">{{ $colocation->name }}</h1>
            </div>

            <div class="mt-8 grid gap-3 sm:grid-cols-2">
                <form method="post" action="{{ url('/invitation/accept') }}">
                    @csrf
                    <x-form.input name="email" type="hidden" :value="$email" class="hidden" />
                    <x-form.input name="token" type="hidden" :value="$token" class="hidden" />
                    <x-button type="submit">Accept Invitation</x-button>
                </form>

                <form method="post" action="{{ url('/invitation/decline') }}">
                    @csrf
                    <x-form.input name="email" type="hidden" :value="$email" class="hidden" />
                    <x-form.input name="token" type="hidden" :value="$token" class="hidden" />
                    <x-button type="submit" variant="danger">Decline Invitation</x-button>
                </form>
            </div>
        </x-card>
    </div>
@endsection
