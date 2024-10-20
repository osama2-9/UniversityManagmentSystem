@extends('layout.professorLayout')

@section('title')
    Students Enrollments
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Students Enrolled</h1>

        @if (isset($error))
            <div class="bg-red-100 text-red-700 p-4 rounded-md">
                {{ $error }}
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow-md">
                    <thead class="bg-blue-500 text-white">
                        <tr>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Student ID</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">First Name</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Last Name</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Email</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">College</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Course</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Grade</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Enrollment Date</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($studentsEnrollment as $enrollment)
                            <tr class="border-b border-gray-200 hover:bg-gray-100 transition-colors">
                                <td class="py-3 px-4">{{ $enrollment->id }}</td>
                                <td class="py-3 px-4">{{ $enrollment->first_name }}</td>
                                <td class="py-3 px-4">{{ $enrollment->last_name }}</td>
                                <td class="py-3 px-4">{{ $enrollment->email }}</td>
                                <td class="py-3 px-4">{{ $enrollment->dept_name ?? '' }}</td>
                                <td class="py-3 px-4">{{ $enrollment->course_name }}</td>
                                <td class="py-3 px-4">{{ $enrollment->grade }}</td>
                                <td class="py-3 px-4">
                                    {{ \Carbon\Carbon::parse($enrollment->enrollment_date)->format('F j, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
