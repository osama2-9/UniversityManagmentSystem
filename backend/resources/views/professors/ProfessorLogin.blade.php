@extends('layout.app')

@section('title')
    Login
@endsection

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Login</h2>
        <form method="POST" action="{{ route('professor.login') }}">
            @csrf
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" id="email" placeholder="Enter your email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="professor_password" id="password" placeholder="Enter your password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    required>
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="inline-flex items-center text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="form-checkbox text-indigo-600">
                    <span class="ml-2">Remember me</span>
                </label>
                <a href="" class="text-sm text-indigo-600 hover:underline">Forgot password?</a>
            </div>

            <div>
                <button type="submit" 
                    class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Login
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
