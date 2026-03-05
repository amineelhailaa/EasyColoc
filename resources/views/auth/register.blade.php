@php
    $title = 'Sign Up — EasyColoc';
@endphp

@extends('layouts.guest')

@section('content')
    <div class="mx-2 w-full max-w-md rounded-2xl border border-cerulean-200 bg-white p-6 shadow-sm">
        <h1 class="text-center text-3xl font-semibold text-cerulean-800">Create Account</h1>
        <p class="mt-2 text-center text-sm text-cerulean-700">Fill the form below to get started.</p>

        <form action="{{ route('register') }}" method="post" enctype="multipart/form-data" class="mt-6 space-y-4">
            @csrf

            <x-form.input
                label="Full Name"
                name="fullName"
                type="text"
                id="fullName"
                placeholder="Full name"
                autocomplete="name"
                required
            />

            <x-form.input
                label="Email"
                name="email"
                type="email"
                id="email"
                placeholder="name@example.com"
                autocomplete="email"
                required
            />

            <x-form.avatar-upload
                name="avatar"
                id="register_avatar"
                label="Avatar (optional)"
            />

            <x-form.input
                label="Password"
                name="password"
                type="password"
                id="password"
                placeholder="Password"
                autocomplete="new-password"
                required
            />

            <x-form.input
                label="Confirm Password"
                name="password_confirmation"
                type="password"
                id="confirm_password"
                placeholder="Confirm password"
                autocomplete="new-password"
                required
            />

            <x-button variant="primary" class="h-12">Create account</x-button>
        </form>

        <p class="mt-6 text-center text-sm text-cerulean-700">
            Already have an account?
            <a href="{{ route('login') }}" class="font-semibold text-cerulean-800 hover:underline">Sign in</a>
        </p>
    </div>

@endsection
