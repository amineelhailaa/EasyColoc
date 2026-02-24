@php($title = 'Sign Up — EasyColoc')

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

            <div>
                <label for="register_avatar" class="block text-xs font-medium text-cerulean-800">Avatar (optional)</label>
                <div class="mt-2 flex items-center gap-4">
                    <img
                        id="register-avatar-preview"
                        src=""
                        alt="Avatar preview"
                        class="hidden h-16 w-16 rounded-2xl border border-cerulean-200 object-cover"
                    />

                    <input
                        id="register_avatar"
                        name="avatar"
                        type="file"
                        accept="image/*"
                        class="block w-full rounded-2xl border border-cerulean-200 bg-white px-4 py-3 text-sm text-cerulean-700 file:mr-4 file:rounded-xl file:border-0 file:bg-cerulean-100 file:px-3 file:py-2 file:font-semibold file:text-cerulean-700 hover:file:bg-cerulean-200"
                    />
                </div>
                <x-form.error name="avatar" />
            </div>

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

    <script>
        (() => {
            const input = document.getElementById('register_avatar');
            const preview = document.getElementById('register-avatar-preview');
            if (!input || !preview) return;

            input.addEventListener('change', () => {
                const file = input.files && input.files[0];
                if (!file || !file.type.startsWith('image/')) {
                    preview.src = '';
                    preview.classList.add('hidden');
                    return;
                }

                const objectUrl = URL.createObjectURL(file);
                preview.src = objectUrl;
                preview.classList.remove('hidden');
            });
        })();
    </script>
@endsection
