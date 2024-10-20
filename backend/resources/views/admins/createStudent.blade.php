@extends('layout.adminLayout')

@section('title')
    Create New Student
@endsection

@section('content')

    <div class="container mx-auto p-8 bg-white shadow-lg rounded-lg">
        <h2 class="text-3xl font-bold mb-8 text-gray-800">Create New Student</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 mb-4 rounded-md">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="bg-red-100 text-red-800 p-4 mb-4 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.createStudent') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="first_name" class="block text-gray-700 font-semibold mb-2">First Name</label>
                <input type="text" id="first_name" name="first_name" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-6">
                <label for="last_name" class="block text-gray-700 font-semibold mb-2">Last Name</label>
                <input type="text" id="last_name" name="last_name" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-6">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-6">
                <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone</label>
                <input type="text" id="phone" name="phone" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-6">
                <label for="date_of_birth" class="block text-gray-700 font-semibold mb-2">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-6">
                <label for="student_address" class="block text-gray-700 font-semibold mb-2">Address</label>
                <textarea id="studant_address" name="studant_address" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 h-32 resize-none" required></textarea>
            </div>

            <div class="mb-6">
            <label for="department" class="block text-gray-700 font-semibold mb-2">Department</label>
            <select name="department_id" id="department" class="block w-full p-2  focus:outline-none focus:ring-2 focus:ring-blue-400 rounded-md border border-gray-300">
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->dept_name }}</option>
                @endforeach
            </select>
        </div>

            <div class="mb-6">
                <label for="gender" class="block text-gray-700 font-semibold mb-2">Gender</label>
                <select id="gender" name="gender" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-400">Create Student</button>
            </div>
        </form>
    </div>
@endsection
