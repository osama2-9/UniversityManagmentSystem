@extends('layout.adminLayout')

@section('title')
    Create Course
@endsection

@section('content')
<div class="container mx-auto mt-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-md rounded-md overflow-hidden">

        <div class="bg-gray-100 text-black  p-6">
            <h2 class="text-3xl font-semibold text-left">Create New Course</h2>
        </div>

       @if (isset($success))
         <div class="bg-green-100 text-green-800 p-4 mb-4 rounded-md">
                {{ $success }}
            </div>

        @elseif(session('error'))
 <div class="bg-red-100 text-red-800 p-4 mb-4 rounded-md">
                {{ session('error') }}
            </div>

            @endif


        <div class="p-6">
            <form method="POST" action="{{ route('course.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col">
                        <label for="course_name" class="text-gray-700 mb-2">Course Name</label>
                        <input type="text" id="course_name" name="course_name" placeholder="Enter course name"
                            class="border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <div class="flex flex-col">
                        <label for="course_code" class="text-gray-700 mb-2">Course Code</label>
                        <input type="text" id="course_code" name="course_code" placeholder="Enter course code"
                            class="border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>


                    <div class="flex flex-col">
                        <label for="professor_id" class="text-gray-700 mb-2">Professor</label>
                        <select id="professor_id" name="professor_id"
                            class="border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option>Select Professor</option>
                            @foreach ($professors as $professor)
                            <option value="{{$professor->id}}">{{$professor->full_name}}</option>

                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label for="department_id" class="text-gray-700 mb-2">Department</label>
                        <select id="department_id" name="department_id"
                            class="border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option>Select Department</option>
                           @foreach ($departments as $department)
                           <option value="{{$department->id}}">{{$department->dept_name}}</option>

                           @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label for="credits" class="text-gray-700 mb-2">Credits</label>
                        <input type="number" id="credits" name="credits" placeholder="Enter credits"
                            class="border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required min="1">
                    </div>

                    <div class="flex flex-col">
                        <label for="course_level" class="text-gray-700 mb-2">Course Level</label>
                        <input type="number" id="level" name="course_level" placeholder="Enter level"
                            class="border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required min="1">
                    </div>
                </div>
                    <div class="mb-6">
                <label for="coursedesc" class="block text-lg font-medium mb-2">Course Description</label>
                <textarea name="course_description" id="coursedesc" cols="30" class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 p-1" rows="10"></textarea>
            </div>

                <div class="flex justify-center mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                        Create Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
