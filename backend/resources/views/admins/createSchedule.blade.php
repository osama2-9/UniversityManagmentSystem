@extends('layout.adminLayout')

@section('title')
    Create Schedule
@endsection

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-8 mt-10 space-y-6">
    <h2 class="text-4xl font-extrabold text-gray-900 text-center">Create Schedule</h2>
    <p class="text-center text-gray-500 mb-8">Fill in the details below to schedule a course. All fields are required.</p>

    <form action="{{ route('schedule.store') }}" method="POST" class="space-y-8">
        @csrf

        <!-- Course -->
        <div>
            <label for="course_id" class="block text-lg font-medium text-gray-700">Course</label>
            <select id="course_id" name="course_id" class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50">
                <option value="" disabled selected>Select Course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->course_name }}  {{$course->course_code}}</option>
                @endforeach
            </select>
        </div>

        <!-- Professor -->
        <div>
            <label for="professor_id" class="block text-lg font-medium text-gray-700">Professor</label>
            <select id="professor_id" name="professor_id" class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50">
                <option value="" disabled selected>Select Professor</option>
                @foreach($professors as $professor)
                    <option value="{{ $professor->id }}">{{ $professor->full_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Classroom -->
        <div>
            <label for="classroom_id" class="block text-lg font-medium text-gray-700">Classroom</label>
            <select id="classroom_id" name="classroom_id" class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50">
                <option value="" disabled selected>Select Classroom</option>
                @foreach($classrooms as $classroom)
                    <option value="{{ $classroom->id }}">{{ $classroom->room_number }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="department_id" class="block text-lg font-medium text-gray-700">Department</label>
            <select id="department_id" name="department_id" class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50">
                <option value="" disabled selected>Select Classroom</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->dept_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Day of the Week -->
        <div>
            <label for="day_of_week" class="block text-lg font-medium text-gray-700">Day of the Week</label>
            <select id="day_of_week" name="day_of_week[]" multiple class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50">
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
            </select>
            <small class="text-gray-400 block mt-1">Hold Ctrl (Windows) or Command (Mac) to select multiple days</small>
        </div>

        <!-- Start Time -->
        <div>
            <label for="start_time" class="block text-lg font-medium text-gray-700">Start Time</label>
            <input type="time" name="start_time" id="start_time" class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50">
        </div>

        <!-- End Time -->
        <div>
            <label for="end_time" class="block text-lg font-medium text-gray-700">End Time</label>
            <input type="time" name="end_time" id="end_time" class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50">
        </div>
        <div>
            <label for="year_of_create" class="block text-lg font-medium text-gray-700">Year Of Create</label>
            <input type="text" name="year_of_create" id="year_of_create" class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 bg-gray-50">
        </div>

        <!-- Submit Button -->
        <div class="flex justify-center">
            <button type="submit" class="w-full sm:w-auto py-3 px-8 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500 transition duration-200">
                Create Schedule
            </button>
        </div>
    </form>
</div>
@endsection
