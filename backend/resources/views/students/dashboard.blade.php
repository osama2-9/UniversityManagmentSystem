@extends('layout.studentLayout')

@section('title')
    Dashboard
@endsection

@section('content')
    @if (session('error'))
        <div id="errorNotification"
            class="w-full md:m-10 bg-red-50 p-4 rounded-md border border-red-500 text-red-600 flex items-center justify-between ">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v8.586l5.293 5.293 1.414-1.414L13 12l5.707-5.707-1.414-1.414L12 4z" />
                </svg>
                <span class="font-semibold">Error:</span>
                <span class="ml-2">{{ session('error') }}</span>
            </div>
            <button onclick="closeNotification(this)" class="ml-4 text-red-500 hover:text-red-700 focus:outline-none">
                &times;
            </button>
        </div>
    @endif
    <div class="flex items-center mb-10 bg-white shadow-md p-6 rounded-lg border border-blue-300">
        <img src="https://xsgames.co/randomusers/avatar.php?g=male" alt="User Picture"
            class="w-24 h-24 rounded-full mr-6 border-4 border-blue-500 shadow-sm">
        <div class="flex flex-col">
            <h1 class="text-4xl font-semibold text-gray-900 mb-1">
                {{ $student->first_name . ' ' . $student->last_name }}</h1>
            <p class="text-gray-600">Date: {{ date('Y-m-d') }}</p>
        </div>
        <div class="ml-auto bg-gray-100 p-4 rounded-lg shadow-md border-l-4 border-blue-200">
            <h2 class="text-xl font-semibold text-blue-700">Balance</h2>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($student->balance, 2) }} USD</p>
        </div>
    </div>

    <div class="mb-8">
        <input type="text" id="searchInput" placeholder="Search courses..."
            class="w-full p-4 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors duration-300">
    </div>

    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Enrolled Courses</h2>
            <div>
                <select
                    class="p-3 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option>All Courses</option>
                    <option>Current Semester</option>
                    <option>Completed Courses</option>
                </select>
            </div>
        </div>
        <ul class="space-y-4" id="coursesList">
            @foreach ($courses as $course)
                <a href="/student/dashboard/{{ $course->course_name }}/{{ $course->course_id }}">
                    <li
                        class="course-item bg-white p-6 rounded-lg mb-4 shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-blue-600">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $course->course_name }}</h3>
                    </li>
                </a>
            @endforeach
        </ul>

        <div class="mt-8 flex justify-center">
            {{ $courses->links() }}
        </div>

        <div>
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Available Quizzes</h2>
            <ul class="space-y-6">
                @foreach ($quizzes as $quiz)
                    <li
                        class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-blue-600">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $quiz->quiz_title }}</h3>
                        <p class="text-gray-500 mt-2">Due: {{ \Carbon\Carbon::parse($quiz->end_time)->format('F d, Y') }}
                        </p>

                        @if (isset($quiz->student_score))
                            <p class="text-gray-500 mt-2">Your Score: {{ $quiz->student_score }} /
                                {{ $quiz->total_marks }}</p>
                        @else
                            <p class="text-gray-500 mt-2">Score: Not Attempted</p>
                        @endif

                        <button class="text-blue-500 mt-2" onclick="openModal('modal_{{ $quiz->quiz_id }}')">Start
                            Quiz</button>
                    </li>

                    <div id="modal_{{ $quiz->quiz_id }}"
                        class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white rounded-lg p-6 shadow-lg w-full max-w-lg">
                            <div class="modal-header flex justify-between items-center mb-4">
                                <h5 class="text-xl font-semibold text-gray-900">Start Quiz: {{ $quiz->quiz_title }}</h5>
                                <button onclick="closeModal('modal_{{ $quiz->quiz_id }}')"
                                    class="text-gray-500 hover:text-gray-700 focus:outline-none">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>{{ $quiz->quiz_description }}</p>
                                <p><strong>Course:</strong> {{ $quiz->course_name }} ({{ $quiz->course_code }})</p>
                                <p><strong>Total Marks:</strong> {{ $quiz->total_marks }}</p>
                                <p><strong>Start Time:</strong>
                                    {{ \Carbon\Carbon::parse($quiz->start_time)->format('M d, Y h:i A') }}</p>
                                <p><strong>End Time:</strong>
                                    {{ \Carbon\Carbon::parse($quiz->end_time)->format('M d, Y h:i A') }}</p>
                            </div>
                            <div class="modal-footer flex justify-end mt-6">
                                <form action="{{ route('quiz.start') }}" method="POST">
                                    <input id="quiz_id" type="hidden" name="quiz_id" value="{{ $quiz->quiz_id }}">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Start
                                        Quiz</button>
                                </form>
                                <button onclick="closeModal('modal_{{ $quiz->quiz_id }}')"
                                    class="ml-3 px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Close</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </ul>
        </div>
    </div>

    <script>
        function closeNotification(button) {

            const notification = button.parentElement
            setTimeout(() => {

                notification.style.display = 'none';
            }, 3000);

            notification.style.display = 'none';


        }
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchQuery = this.value.toLowerCase();
            const courses = document.querySelectorAll('.course-item');

            courses.forEach(function(course) {
                const courseName = course.querySelector('h3').textContent.toLowerCase();
                if (courseName.includes(searchQuery)) {
                    course.style.display = '';
                } else {
                    course.style.display = 'none';
                }
            });
        });

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
@endsection
