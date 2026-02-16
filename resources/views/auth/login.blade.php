@php($title = 'Connexion — NASS SPLIT')

@extends('layouts.guest')

@section('content')
    <x-brand subtitle="Connecte-toi pour gérer tes dépenses" />

    @if (session('status'))
        <x-card class="p-3">
            <p class="text-sm text-cerulean-800">{{ session('status') }}</p>
        </x-card>
    @endif

    <x-card>
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <x-form.input
                name="email"
                label="Email"
                type="email"
                autocomplete="email"
                placeholder="ex: amine@mail.com"
                required
            />

            <x-form.password
                name="password"
                label="Mot de passe"
                autocomplete="current-password"
                required
            />

            <div class="flex items-center justify-between">
                <label class="inline-flex items-center gap-2 text-sm text-cerulean-800">
                    <input
                        type="checkbox"
                        name="remember"
                        class="rounded border-cerulean-200 text-cerulean-600 focus:ring-cerulean-100"
                        @checked(old('remember'))
                    />
                    <span>Se souvenir</span>
                </label>

                @if (Route::has('password.request'))
                    <x-link :href="route('password.request')">Mot de passe oublié ?</x-link>
                @endif
            </div>

            <x-button>Se connecter</x-button>
        </form>
    </x-card>

    <p class="text-center text-sm text-cerulean-800">
        Pas de compte ?
        <x-link :href="route('register')">Créer un compte</x-link>
    </p>
@endsection
