@extends('layout.professorLayout')

@section('title')
    Create Quiz
@endsection

@section('content')
    <div class="max-w-6xl mx-auto my-10 p-8 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Create a New Quiz</h1>

        @if (session('success'))
            <div class="bg-green-50 w-56 p-2">
                <p class="ml-2 text-green-500">{{ session('success') }}</p>
            </div>
        @elseif (session('error'))
            <div class="bg-red-50 w-56 p-2">
                <p class="ml-2 text-red-500">{{ session('error') }}</p>
            </div>
        @endif


        <form action="{{ route('quiz.store') }}" method="POST" id="quiz-form">
            @csrf

            <div class="mb-6">
                <label for="quiz-title" class="block text-gray-700 font-semibold mb-2">Quiz Title:</label>
                <input type="text" id="quiz-title" name="quiz_title"
                    class="border border-gray-300 rounded focus:outline-none p-2 w-full focus:ring focus:ring-blue-300"
                    placeholder="Enter quiz title" required>
            </div>

            <div class="mb-6">
                <label for="quiz-description" class="block text-gray-700 font-semibold mb-2">Quiz Description:</label>
                <textarea id="quiz-description" name="quiz_description"
                    class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring focus:ring-blue-300" rows="3"
                    placeholder="Enter quiz description" required></textarea>
            </div>

            <div class="mb-6">
                <label for="course-id" class="block text-gray-700 font-semibold mb-2">Course:</label>
                <select name="course_id" id="course-id" class="border border-gray-300 p-2 rounded-md w-full">
                    @foreach ($courses as $course)
                        <option value="{{ $course->course_id }}">{{ $course->course_name }} </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="start-time" class="block text-gray-700 font-semibold mb-2">Start Time:</label>
                <input type="datetime-local" id="start-time" name="start_time"
                    class="border border-gray-300 focus:outline-none rounded p-2 w-full focus:ring focus:ring-blue-300" required>
            </div>

            <div class="mb-6">
                <label for="end-time" class="block text-gray-700 font-semibold mb-2">End Time:</label>
                <input type="datetime-local" id="end-time" name="end_time"
                    class="border border-gray-300 focus:outline-none rounded p-2 w-full focus:ring focus:ring-blue-300" required>
            </div>
            <div class="mb-6">
                <label for="quiz-duration" class="block text-gray-700 font-semibold mb-2">Quiz Duration (in
                    minutes):</label>
                <input type="number" id="quiz-duration" name="quiz_duration"
                    class="border border-gray-300 focus:outline-none rounded p-2 w-full focus:ring focus:ring-blue-300"
                    placeholder="Enter quiz duration (e.g., 30)" required>
            </div>

            <div class="mb-6">
                <label for="total-marks" class="block text-gray-700 font-semibold mb-2">Total Marks:</label>
                <input type="number" id="total-marks" name="total_marks"
                    class="border border-gray-300 focus:outline-none rounded p-2 w-full focus:ring focus:ring-blue-300"
                    placeholder="Enter total marks" required>
            </div>


            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Submit Quiz</button>
        </form>
    </div>
@endsection
