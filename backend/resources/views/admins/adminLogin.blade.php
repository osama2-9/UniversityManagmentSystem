@extends('layout.app')

@section('title')
    Admin Login
@endsection

@section('content')

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-6 text-center">Admin Login</h2>
        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300"
                />
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="admin_password" class="block text-gray-700 font-bold mb-2">Password</label>
                <input
                    type="password"
                    name="admin_password"
                    id="admin_password"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300"
                />
                @error('admin_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="remember" class="inline-flex items-center">
                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out"
                    />
                    <span class="ml-2 text-gray-700">Remember Me</span>
                </label>
            </div>
            <button
                type="submit"
                class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300"
            >
                Login
            </button>
        </form>
    </div>
</div>
@endsection
