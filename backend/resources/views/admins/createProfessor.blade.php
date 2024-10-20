@extends('layout.adminLayout')

@section('title')
Create Professor
@endsection

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold mb-6">Create Professor</h1>

    <!-- Display success or error messages -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <form action="{{ route('professors.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <div class="mb-4">
            <label for="full_name" class="block text-gray-700 font-medium mb-2">Full Name</label>
            <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter full name" required>
            @error('full_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter email" required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="office" class="block text-gray-700 font-medium mb-2">Office</label>
    <input  type="text" id="office" name="office" value="{{ old('office') }}"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        placeholder="Enter office" required>
    @error('office')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>


<div class="mb-4">
            <label for="department_id" class="block text-gray-700 font-medium mb-2">Department</label>
            <select id="department_id" name="department_id"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
                <option  value="">Select Department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->dept_name }}</option>
                @endforeach
            </select>
            @error('department_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-medium mb-2">Phone</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter phone number" required>
                <div class="mb-4">
                    <label for="professor_address" class="block text-gray-700 font-medium mb-2">Address</label>
                    <textarea id="professor_address" name="professor_address" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter address" required>{{ old('professor_address') }}</textarea>
                    @error('professor_address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

        <div class="flex justify-end">
            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Create Professor
            </button>
        </div>
    </form>
</div>
@endsection
