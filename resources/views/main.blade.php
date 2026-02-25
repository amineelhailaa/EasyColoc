@php($title = 'Main - EasyColoc')

@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full max-w-6xl space-y-6 px-2 md:px-4">
        <section class="rounded-3xl border border-cerulean-200 bg-white p-6 shadow-sm md:p-8">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cerulean-500">EasyColoc</p>
            <h1 class="mt-2 text-3xl font-semibold text-cerulean-800 md:text-4xl">Main</h1>
            <p class="mt-2 max-w-3xl text-sm text-cerulean-700">
                Central page accessible to everyone. Choose where you want to go next.
            </p>

            <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <a href="{{ route('home') }}" class="rounded-2xl border border-cerulean-200 bg-cerulean-50 px-4 py-3 text-sm font-semibold text-cerulean-800 hover:bg-cerulean-100">Home</a>
                <a href="{{ route('member.dashboard') }}" class="rounded-2xl border border-cerulean-200 bg-cerulean-50 px-4 py-3 text-sm font-semibold text-cerulean-800 hover:bg-cerulean-100">Member Dashboard</a>
                <a href="{{ route('owner.dashboard') }}" class="rounded-2xl border border-cerulean-200 bg-cerulean-50 px-4 py-3 text-sm font-semibold text-cerulean-800 hover:bg-cerulean-100">Owner Dashboard</a>
                <a href="{{ route('profile.view') }}" class="rounded-2xl border border-cerulean-200 bg-cerulean-50 px-4 py-3 text-sm font-semibold text-cerulean-800 hover:bg-cerulean-100">Profile</a>
            </div>
        </section>
    </div>
@endsection
