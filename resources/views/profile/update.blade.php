@php($title = 'Update Profile — EasyColoc')

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

            <div>
                <label for="profile_avatar" class="block text-xs font-medium text-cerulean-800">Avatar (optional)</label>
                <div class="mt-2 flex items-center gap-4">
                    <img
                        id="profile-avatar-preview"
                        src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : '' }}"
                        data-default-src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : '' }}"
                        alt="Avatar preview"
                        class="{{ auth()->user()->avatar ? '' : 'hidden' }} h-16 w-16 rounded-2xl border border-cerulean-200 object-cover"
                    />

                    <input
                        id="profile_avatar"
                        name="avatar"
                        type="file"
                        accept="image/*"
                        class="block w-full rounded-2xl border border-cerulean-200 bg-white px-4 py-3 text-sm text-cerulean-700 file:mr-4 file:rounded-xl file:border-0 file:bg-cerulean-100 file:px-3 file:py-2 file:font-semibold file:text-cerulean-700 hover:file:bg-cerulean-200"
                    />
                </div>
                <x-form.error name="avatar" />
            </div>

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

    <script>
        (() => {
            const input = document.getElementById('profile_avatar');
            const preview = document.getElementById('profile-avatar-preview');
            if (!input || !preview) return;

            input.addEventListener('change', () => {
                const file = input.files && input.files[0];
                if (!file || !file.type.startsWith('image/')) {
                    const defaultSrc = preview.dataset.defaultSrc || '';
                    preview.src = defaultSrc;
                    preview.classList.toggle('hidden', !defaultSrc);
                    return;
                }

                const objectUrl = URL.createObjectURL(file);
                preview.src = objectUrl;
                preview.classList.remove('hidden');
            });
        })();
    </script>
@endsection
