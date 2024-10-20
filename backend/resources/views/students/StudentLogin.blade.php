@extends('layout.app')

@section('title')
    Login
@endsection

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <form action="{{ route('student.login') }}" method="POST" class="w-full max-w-md p-8 bg-white shadow-lg rounded-lg">
            @csrf

            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Student Login</h2>

            @if (session('error'))
                <div class="mb-4 text-red-500">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-6">
                <label for="student_id" class="block text-lg font-medium text-gray-700">Student ID</label>
                <input type="text" id="student_id" name="student_code"
                    class="mt-1 block w-full border-gray-300 border-2 p-2 rounded-md shadow-sm focus:outline-none focus:border-blue-500"
                    required autofocus>
               
            </div>

            <div class="mb-6">
                <label for="password" class="block text-lg font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="student_password"
                    class="mt-1 block w-full p-2 border-gray-300 border-2 rounded-md focus:outline-none shadow-sm focus:border-blue-500"
                    required>

            </div>

            <div class="flex items-center mb-6">
                <input type="checkbox" name="remember" id="remember"
                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="remember" class="ml-2 text-gray-700">Remember me</label>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300 ease-in-out">
                Login
            </button>

            <div class="mt-4 text-center">
                <a href="#" class="text-blue-600 hover:underline">Forgot your password?</a>
            </div>
        </form>
    </div>
@endsection
