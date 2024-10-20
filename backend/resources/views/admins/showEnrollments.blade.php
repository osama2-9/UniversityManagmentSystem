@extends('layout.adminLayout')

@section('title')
    Show Enrollments
@endsection

@section('content')
<div class="container mx-auto mt-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-md rounded-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white p-4">
            <h2 class="text-2xl font-semibold text-center">Enrollments</h2>
        </div>

        <!-- Enrollments Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-gray-800 text-white">
                    <tr class="text-md font-semibold">
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Student ID</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Student Name</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Course Name</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Course Code</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Professor Name</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Credits</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Level</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Enrollment Date</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Last Updated</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($enrollments as $enrollment)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $enrollment->stdID }}</td>
                            <td class="px-6 py-4 text-sm">{{ $enrollment->first_name }} {{ $enrollment->last_name }}</td>
                            <td class="px-6 py-4 text-sm">{{ $enrollment->course_name }}</td>
                            <td class="px-6 py-4 text-sm">{{ $enrollment->course_code }}</td>
                            <td class="px-6 py-4 text-sm">{{ $enrollment->professor_name }}</td>
                            <td class="px-6 py-4 text-sm">{{ $enrollment->credits }}</td>
                            <td class="px-6 py-4 text-sm">{{ $enrollment->course_level }}</td>
                            <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($enrollment->created_at)->format('d M, Y') }}</td>
                            <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($enrollment->updated_at)->format('d M, Y') }}</td>
                             <td class="px-6 py-4 text-center">
                                <div class="flex justify-center space-x-4">
                                    <a href="" class="text-blue-500 hover:text-blue-700">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232a3 3 0 014.243 4.243l-9.192 9.192a4 4 0 01-1.414.94l-3.858.772a1 1 0 01-1.212-1.212l.772-3.858a4 4 0 01.94-1.414l9.192-9.192z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{route('admin.deleteEnrollment')}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="enrollment_id" value="{{$enrollment->enroll_id}}">
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
