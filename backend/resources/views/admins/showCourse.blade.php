@extends('layout.adminLayout')

@section('title')
    Show Courses
@endsection

@section('content')
    <div class="container mx-auto mt-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-sm overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 text-white p-4">
                <h2 class="text-2xl font-semibold text-center">Courses</h2>
            </div>

            <!-- Search Form -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between p-4">
                <form method="GET" action="{{ url()->current() }}" class="flex space-x-4 items-center mb-4 md:mb-0">
                    <input type="text" name="search" placeholder="Search by Name" value="{{ request('search') }}"
                        class="border border-gray-300 rounded-lg px-4 py-2 w-full max-w-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                        Search
                    </button>
                </form>
            </div>

            <!-- Messages -->
            @if (session('error'))
                <div
                    class="w-full md:m-5 bg-red-50 p-2 border-r-4 border-red-500 rounded-lg shadow-md flex items-center space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10A8 8 0 110 10a8 8 0 0118 0zm-9-4a1 1 0 000 2h.01a1 1 0 000-2H9zM9 7a1 1 0 000 2h1v2H9a1 1 0 000 2h1a1 1 0 010 2H9a1 1 0 000 2h1a1 1 0 000-4h1V9H9a1 1 0 000-2h1a1 1 0 000-2H9z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-red-500 font-semibold text-xl">{{ session('error') }}</p>
                </div>
            @elseif (session('success'))
                <div
                    class="w-full md:m-5 bg-green-50 p-2 border-l-4 border-green-500 rounded-lg shadow-sm flex items-center space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-10.707a1 1 0 00-1.414-1.414L9 9.586 7.707 8.293a1 1 0 00-1.414 1.414L8.293 11l-2.293 2.293a1 1 0 001.414 1.414L9 12.414l2.293 2.293a1 1 0 001.414-1.414L10.414 11l2.293-2.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <p onclick="this.parentElement.style.display='none'" class="text-green-500 font-semibold text-xl">
                        {{ session('success') }}</p>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border border-gray-200 rounded-lg shadow-md">
                    <thead class="bg-gray-800 text-white">
                        <tr class="text-md font-semibold">
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left">ID</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Course Name</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Course Code</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Professor Name</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Department</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Credits</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Level</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left">IsActive</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($courses as $course)
                            <tr class="hover:bg-gray-100 transition-colors">
                                <td class="px-6 py-4 text-sm">{{ $course->course_id }}</td>
                                <td class="px-6 py-4 text-sm">{{ $course->course_name }}</td>
                                <td class="px-6 py-4 text-sm">{{ $course->course_code }}</td>
                                <td class="px-6 py-4 text-sm">{{ $course->professor_name }}</td>
                                <td class="px-6 py-4 text-sm">{{ $course->department_name }}</td>
                                <td class="px-6 py-4 text-sm">{{ $course->credits }}</td>
                                <td class="px-6 py-4 text-sm">{{ $course->course_level }}</td>
                                <td class="px-6 py-4 text-sm">
                                    {!! $course->isActive === 1
                                        ? "<p class='text-green-600 bg-green-50 font-semibold p-2 rounded-md shadow-sm text-center'>Yes</p>"
                                        : "<p class='text-red-600 bg-red-50 font-semibold p-2 rounded-md shadow-sm text-center'>No</p>" !!}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-4">
                                        <button
                                            onclick="openUpdateModal('{{ $course->course_id }}' ,'{{ $course->course_name }}' ,'{{ $course->course_code }}' , '{{ $course->department_id }}','{{ $course->professor_id }}','{{ $course->credits }}','{{ $course->course_level }}' ,'{{ $course->isActive }}')"
                                            class="text-blue-500 hover:text-blue-700">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.232 5.232a3 3 0 014.243 4.243l-9.192 9.192a4 4 0 01-1.414.94l-3.858.772a1 1 0 01-1.212-1.212l.772-3.858a4 4 0 01.94-1.414l9.192-9.192z">
                                                </path>
                                            </svg>
                                        </button>

                                        <form action="{{ route('admin.deleteCourse') }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this course?')">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $course->course_id }}">
                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M18 6L6 18M6 6l12 12"></path>
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

          <div id="updateModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-8 rounded-lg shadow-lg w-11/12 md:w-1/3 relative">
        <!-- Close Button (Optional) -->
        <button class="absolute top-3 right-3 text-gray-400 hover:text-gray-600" onclick="closeUpdateModal()">
            ✕
        </button>
        <h3 class="text-2xl font-semibold mb-6 text-gray-800">Update Course</h3>

        <form id="updateCourseForm" method="POST" action="{{ route('admin.updateCourse') }}">
            @csrf
            @method('PUT')

            <!-- Hidden Input for Course ID -->
            <input type="hidden" name="course_id" id="modal_course_id">

            <!-- Course Name -->
            <div class="mb-4">
                <label for="course_name" class="block text-sm font-medium text-gray-700 mb-1">Course Name</label>
                <input type="text" name="course_name" id="modal_course_name" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
            </div>

            <!-- Course Code -->
            <div class="mb-4">
                <label for="course_code" class="block text-sm font-medium text-gray-700 mb-1">Course Code</label>
                <input type="text" name="course_code" id="modal_course_code" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
            </div>

            <!-- Department -->
            <div class="mb-4">
                <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                <select name="department_id" id="modal_department_id" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->dept_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Professor -->
            <div class="mb-4">
                <label for="professor_id" class="block text-sm font-medium text-gray-700 mb-1">Professor</label>
                <select name="professor_id" id="modal_professor_id" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                    @foreach ($professors as $professor)
                        <option value="{{ $professor->id }}">{{ $professor->full_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Credits -->
            <div class="mb-4">
                <label for="credits" class="block text-sm font-medium text-gray-700 mb-1">Credits</label>
                <input type="number" name="credits" id="modal_credits" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" min="1" max="5">
            </div>

            <!-- Course Level -->
            <div class="mb-4">
                <label for="course_level" class="block text-sm font-medium text-gray-700 mb-1">Course Level</label>
                <input type="text" name="course_level" id="modal_course_level" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
            </div>

            <div class="mb-4">
                <label for="isActive" class="block text-sm font-medium text-gray-700 mb-1">Active Status</label>
                <select name="isActive" id="modal_isActive" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <!-- Buttons -->
            <div class="flex items-center justify-between">
                <!-- Cancel Button -->
                <button type="button" onclick="closeUpdateModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-150 ease-in-out">
                    Cancel
                </button>

                <!-- Update Button -->
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-150 ease-in-out">
                    Update Course
                </button>
            </div>


            </div>
        </form>
    </div>
</div>


        </div>
    </div>

    <script>
        function openUpdateModal(course_id, course_name, course_code, department_id, professor_id, credits, course_level,
            activation) {
            document.getElementById('modal_course_id').value = course_id;
            document.getElementById('modal_course_name').value = course_name;
            document.getElementById('modal_course_code').value = course_code;
            document.getElementById('modal_department_id').value = department_id;
            document.getElementById('modal_professor_id').value = professor_id;
            document.getElementById('modal_credits').value = credits;
            document.getElementById('modal_course_level').value = course_level;
            document.getElementById('updateModal').classList.remove('hidden');
            }

        function closeUpdateModal() {
            document.getElementById('updateModal').classList.add('hidden');
        }
    </script>
@endsection
