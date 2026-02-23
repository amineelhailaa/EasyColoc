@php($title = 'Forgot Password - EasyColoc')

@extends('layouts.guest')

@section('content')
    <div class="w-full max-w-md rounded-2xl bg-gray-50 border border-gray-200 p-4 mx-2">
        <h1 class="mb-2 text-center text-4xl font-semibold  font-cash2 text-cerulean-700 ">Forgot Password ?</h1>
        <p class="mb-8 text-center text-sm text-cerulean-700 font-bold">Enter your email and we will send you a reset link.</p>
        <form method="post" action="{{route('reset_email_sent')}}">
            @csrf
            <div class="mb-4">
                <x-form.input label="Email" name="email" type="email" id="email" placeholder="name@example.com" autocomplete="email"
                       class="" ></x-form.input>
            </div>
            <x-button variant="primary" class="h-14">Send Reset Link</x-button>
        </form>
    </div>
@endsection
