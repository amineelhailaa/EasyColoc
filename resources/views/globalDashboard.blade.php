@php($title = 'Global Dashboard')
@extends('layouts.app')
@section('content')

    <div class="md:mx-12">
        <div class="flex gap-2">
            <div><img class="rounded-4xl" src="{{auth()->user()->avatar ?? 'https://yt3.ggpht.com/f0uZg4v91xpYmJP3AKRjmIlBqh6dLhhFDklUgZ555Y7Bb5oHQY1FdANQmptt2XcugN3yqiwDjw=s48-c-k-c0x00ffffff-no-rj'}}"></div>
            <div>
                <div class="text-xl font-bold">Hello Jhon Smith</div>
                <div class=" opacity-70">Welcome Back !</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl h-50">
            a
        </div>
    </div>

@endsection
