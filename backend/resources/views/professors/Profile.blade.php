@extends('layout.professorLayout')

@section('title')
    Profile
@endsection

@section('content')
<div class="container mx-auto mt-10 p-6 bg-gray-50 shadow-lg rounded-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Professor Profile</h1>

    <!-- Personal Information Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Personal Details Card -->
        <div class="bg-white p-6 shadow-md rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Personal Details</h2>
            <div class="space-y-2">
                <p><strong>Full Name:</strong> {{ $professor->full_name }}</p>
                <p><strong>Email:</strong> {{ $professor->email }}</p>
                <p><strong>Phone:</strong> {{ $professor->phone }}</p>
                <p><strong>Address:</strong> {{ $professor->professor_address }}</p>
                <p><strong>Office:</strong> {{ $professor->office }}</p>
                <p><strong>Department:</strong> {{ $professor->dept_name }} ({{ $professor->building }})</p>
            </div>
        </div>

        <!-- Courses Information Card -->
        <div class="bg-white p-6 shadow-md rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Courses</h2>
            <ul class="list-disc list-inside text-gray-600 space-y-2">
                @forelse($courses as $course)
                    <li class="border-b py-2">{{ $course->course_name }} ({{ $course->course_code }})</li>
                @empty
                    <p class="text-gray-500">No courses assigned.</p>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
