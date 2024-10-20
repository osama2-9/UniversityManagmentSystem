@extends('layout.adminLayout')

@section('title')
Create Enrollments
@endsection

@section('content')
<div class="container mx-auto mt-10">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Create Enrollment</h1>

        <form method="POST" action="{{ route('enrollment.store') }}" class="space-y-6">
            @csrf
            <!-- Alpine.js data object for searches -->
            <div x-data="{
                studentSearch: '',
                professorSearch: '',
                courseSearch: ''
            }">
                <!-- Student Select with Search -->
                <div>
                    <label for="student_id" class="block text-xl  font-medium text-gray-700">Select Student</label>
                    <div class="relative mt-2">
                        <input
                            type="text"
                            x-model="studentSearch"
                            placeholder="Search student..."
                            class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        />
                        <select name="student_id" id="student_id" class="block w-full mt-2 border-gray-300 rounded-md" size="5">
                            @foreach($students as $student)
                                <option value="{{ $student->id }}"
                                    x-show="studentSearch == '' || '{{ $student->id }}'.toLowerCase().includes(studentSearch.toLowerCase())">
                                    {{ $student->first_name }} {{ $student->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Professor Select with Search -->
                <div>
                    <label for="professor_id" class="block text-xl  font-medium text-gray-700">Select Professor</label>
                    <div class="relative mt-2">
                        <input
                            type="text"
                            x-model="professorSearch"
                            placeholder="Search professor..."
                            class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        />
                        <select name="professor_id" id="professor_id" class="block w-full mt-2 border-gray-300 rounded-md" size="5">
                            @foreach($professors as $professor)
                                <option value="{{ $professor->id }}"
                                    x-show="professorSearch == '' || '{{ $professor->full_name }}'.toLowerCase().includes(professorSearch.toLowerCase())">
                                    {{ $professor->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Course Select with Search -->
                <div>
                    <label for="course_id" class="block text-xl  font-medium text-gray-700">Select Course</label>
                    <div class="relative mt-2">
                        <input
                            type="text"
                            x-model="courseSearch"
                            placeholder="Search course..."
                            class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        />
                        <select name="course_id" id="course_id" class="block w-full mt-2 border-gray-300 rounded-md" size="5">
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}"
                                    x-show="courseSearch == '' || '{{ $course->course_code }}'.toLowerCase().includes(courseSearch.toLowerCase())">
                                    {{ $course->course_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Semester Input -->
                <div>
                    <label for="semester" class="block text-xl  mt-3 font-medium text-gray-700">Semester</label>
                    <input
                        type="text"
                        name="semester"
                        id="semester"
                        class="block py-2 w-full mt-3 mb-3 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-md"
                        placeholder="Enter semester"
                    />
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition-colors">
                        Submit Enrollment
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Import Alpine.js for reactivity -->
@endsection
