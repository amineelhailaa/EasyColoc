@php($title = 'Login — EasyColoc')

@extends('layouts.guest')

@section('content')
    <div class="mx-2 w-full max-w-md rounded-2xl border border-cerulean-200 bg-white p-6 shadow-sm">
        <h1 class="text-center text-3xl font-semibold text-cerulean-800">Sign In</h1>
        <p class="mt-2 text-center text-sm text-cerulean-700">Enter your credentials to continue.</p>

        <form method="post" action="{{ route('login') }}" class="mt-6 space-y-4">
            @csrf

            <x-form.input
                label="Email"
                name="email"
                type="email"
                id="email"
                placeholder="name@example.com"
                autocomplete="email"
                required
            />

            <x-form.input
                label="Password"
                name="password"
                type="password"
                id="password"
                placeholder="Password"
                autocomplete="current-password"
                required
            />

            <div class="flex items-center justify-between">
                <x-form.checkbox name="remember" label="Remember me" />
                <a href="{{ route('reset_password') }}" class="text-sm text-cerulean-700 hover:underline">Forgot Password?</a>
            </div>

            <x-button variant="primary" class="h-12">Sign In</x-button>
        </form>

        <p class="mt-6 text-center text-sm text-cerulean-700">
            No account yet?
            <a href="{{ route('register') }}" class="font-semibold text-cerulean-800 hover:underline">Create one</a>
        </p>
    </div>
@endsection
