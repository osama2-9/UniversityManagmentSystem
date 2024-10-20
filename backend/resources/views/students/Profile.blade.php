@extends('layout.studentLayout')

@section('title', 'Profile')

@section('content')

    <div class="max-w-4xl mx-auto my-10 p-8 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Student Profile</h1>

        <div class="mb-6 border-b pb-4">
            <h2 class="text-xl font-semibold text-gray-600 mb-3">Personal Information</h2>
            <div class="flex flex-wrap gap-6">
                <div class="flex-1">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">First Name</label>
                        <div class="mt-1 font-medium text-gray-900">{{ $student->first_name }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Last Name</label>
                        <div class="mt-1 font-medium text-gray-900">{{ $student->last_name }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Email</label>
                        <div class="mt-1 font-medium text-gray-900">{{ $student->email }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Phone</label>
                        <div class="mt-1 font-medium text-gray-900">{{ $student->phone }}</div>
                    </div>
                </div>

                <div class="flex-1">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Gender</label>
                        <div class="mt-1 font-medium text-gray-900">{{ ucfirst($student->gender) }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Date of Birth</label>
                        <div class="mt-1 font-medium text-gray-900">{{ $student->date_of_birth }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Student ID</label>
                        <div class="mt-1 font-medium text-gray-900">{{ $student->student_code }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6 border-b pb-4">
            <h2 class="text-xl font-semibold text-gray-600 mb-3">Education Details</h2>
            <div class="flex flex-wrap gap-6">
                <div class="flex-1">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Semester</label>
                        <div class="mt-1 font-medium text-gray-900">{{ $student->semester }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Major</label>
                        <div class="mt-1 font-medium text-gray-900">{{ $student->major }}</div>
                    </div>
                </div>

                <div class="flex-1">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Department</label>
                        <div class="mt-1 font-medium text-gray-900">{{ $student->department_name }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Balance</label>
                        <div class="mt-1 font-medium text-gray-900">${{ number_format($student->balance, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6 border-b pb-4">
            <h2 class="text-xl font-semibold text-gray-600 mb-3">Address</h2>
            <div class="flex">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-500">Address</label>
                    <div class="mt-1 font-medium text-gray-900">{{ $student->studant_address }}</div>
                </div>
            </div>
        </div>


        <div class="mb-6 border-b pb-4">
            <h2 class="text-xl font-semibold text-gray-600 mb-3">System Information</h2>
            <div class="flex flex-wrap gap-6">

                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-500">Enrollment Date</label>
                    <div class="mt-1 font-medium text-gray-900">{{ $student->created_at }}</div>
                </div>


            </div>
        </div>
    </div>

@endsection
