@php
    $title = 'Update Profile — EasyColoc';
@endphp

@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full max-w-2xl rounded-2xl border border-cerulean-200 bg-white p-6 shadow-sm">
        <h1 class="text-3xl font-semibold text-cerulean-800">Update Profile</h1>
        <p class="mt-2 text-sm text-cerulean-700">Edit your account information.</p>


        <form method="POST" action="{{route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-4">
            @csrf
            @method('PUT')

            <x-form.input
                label="Full Name"
                name="name"
                type="text"
                id="name"
                :value="old('name', auth()->user()->name ?? '')"
                placeholder="Your full name"
                autocomplete="name"
                required
            />

            <x-form.input
                label="Email"
                name="email"
                type="email"
                id="email"
                :value="old('email', auth()->user()->email ?? '')"
                placeholder="name@example.com"
                autocomplete="email"
                required
            />

            <x-form.avatar-upload
                name="avatar"
                id="profile_avatar"
                label="Avatar (optional)"
                :preview-src="auth()->user()->avatarUrl(auth()->user()->name ?? 'User', '0369a1')"
            />

            <div class="pt-2">
                <x-button variant="primary" class="h-12">Save Changes</x-button>
            </div>
        </form>

        <div class="mt-10 border-t border-cerulean-200 pt-8">
            <h2 class="text-2xl font-semibold text-cerulean-800">Update Password</h2>
            <p class="mt-2 text-sm text-cerulean-700">Choose a strong password and keep your account secure.</p>

            <form method="POST" action="{{ route('profile.password') }}" class="mt-5 space-y-4">
                @csrf
                @method('PUT')

                <x-form.password
                    name="current_password"
                    label="Current Password"
                    autocomplete="current-password"
                />

                <x-form.password
                    name="password"
                    label="New Password"
                    autocomplete="new-password"
                />

                <x-form.password
                    name="password_confirmation"
                    label="Confirm New Password"
                    autocomplete="new-password"
                />

                <div class="pt-2">
                    <x-button variant="primary" class="h-12">Update Password</x-button>
                </div>
            </form>
        </div>
    </div>

@endsection
