@extends('layout.app')

@section('title', 'Error')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 text-center px-6">
    <img src="{{ asset('assets/server_down.svg') }}" alt="Error Illustration" class="mb-8 w-full max-w-lg h-auto">

    <h1 class="text-4xl font-bold text-red-600 mb-4">Oops! Something went wrong.</h1>

    <p class="text-xl text-gray-700 mb-6">We're sorry, but something went wrong. Please try visiting again later.</p>
</div>
@endsection
