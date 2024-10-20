@extends('layout.app')

@section('title')
    Home
@endsection

@section('content')
    <div class="container flex justify-center items-center min-h-screen bg-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
            <div class="bg-white shadow-lg rounded-lg p-8 transform transition hover:-translate-y-2 duration-300">
                <div class="flex justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 12c2.28 0 4-1.72 4-4s-1.72-4-4-4-4 1.72-4 4 1.72 4 4 4zM16 14H8c-2.21 0-4 1.79-4 4v2h16v-2c0-2.21-1.79-4-4-4z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4">Admin</h3>
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline text-lg font-medium">Go to Admin
                    Panel</a>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-8 transform transition hover:-translate-y-2 duration-300">
                <div class="flex justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 12c2.28 0 4-1.72 4-4s-1.72-4-4-4-4 1.72-4 4 1.72 4 4 4zM16 14H8c-2.21 0-4 1.79-4 4v2h16v-2c0-2.21-1.79-4-4-4zM18 14v6H6v-6h12z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4">Professor</h3>
                <a href="{{ route('professor.getForm') }}"
                    class="text-blue-500 hover:underline text-lg font-medium">Professor Panel

                </a>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-8 transform transition hover:-translate-y-2 duration-300">
                <div class="flex justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7M5 20h14" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4">Students</h3>
                <a href="{{ route('student.getForm') }}" class="text-blue-500 hover:underline text-lg font-medium">Student
                    Portal</a>
            </div>
        </div>
    </div>
@endsection
