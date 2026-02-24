@php($title = 'Create Group - EasyColoc')

@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full max-w-2xl rounded-2xl border border-cerulean-200 bg-white p-6 shadow-sm">
        <h1 class="text-3xl font-semibold text-cerulean-800">Create Group</h1>
        <p class="mt-2 text-sm text-cerulean-700">Set up your colocation group details.</p>

        <form method="POST" action="{{ route('colocation.store') }}" enctype="multipart/form-data" class="mt-6 space-y-4">
            @csrf

            <x-form.input
                label="Group Name"
                name="name"
                type="text"
                id="name"
                placeholder="Ex: Appartement Centre Ville"
                required
            />

            <x-form.avatar-upload
                name="avatar"
                id="avatar"
                label="Group Avatar (optional)"
            />

            <x-form.textarea
                label="Description"
                name="description"
                id="description"
                placeholder="Short description for your group..."
                rows="5"
            />

            <div class="pt-2">
                <x-button variant="primary" class="h-12">Create Group</x-button>
            </div>
        </form>
    </div>
@endsection
