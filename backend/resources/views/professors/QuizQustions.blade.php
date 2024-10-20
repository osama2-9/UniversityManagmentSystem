@extends('layout.professorLayout')

@section('title')
    Add Question
@endsection

@section('content')
    <div class="max-w-6xl mx-auto my-10 p-8 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Add a New Question</h1>

        @if (session('success'))
            <div class="bg-green-50 p-2">
                <p class="text-green-500">{{ session('success') }}</p>
            </div>
        @elseif (session('error'))
            <div class="bg-red-50 p-2">
                <p class="text-red-500">{{ session('error') }}</p>
            </div>
        @endif

        <form action="{{ route('quiz.storeQustion') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="quiz-id" class="block text-gray-700 font-semibold mb-2">Quiz name:</label>
                <select name="quiz_id" id="quiz-id" class="border border-gray-300 p-2 rounded-md w-full focus:outline-none focus:ring-1 focus:ring-blue-300">
                    <option value="" selected>Select a question</option>
                    @foreach ($quizzes as $quiz)
                        <option value="{{ $quiz->quiz_id }}">{{ $quiz->quiz_title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="question-text" class="block text-gray-700 font-semibold mb-2">Question Text:</label>
                <textarea id="question-text" name="question_text" class="border border-gray-300 p-2 rounded-md w-full focus:outline-none focus:ring-1 focus:ring-blue-300" rows="3" placeholder="Enter the question" required></textarea>
            </div>

            <div class="mb-6">
                <label for="question-type" class="block text-gray-700 font-semibold mb-2">Question Type:</label>
                <select id="question-type" name="question_type" class="border border-gray-300 p-2 rounded-md w-full focus:outline-none focus:ring-1 focus:ring-blue-300" required>
                    <option value="multiple_choice">Multiple Choice</option>
                    <option value="true_false">True/False</option>
                    <option value="short_answer">Short Answer</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="question-mark" class="block text-gray-700 font-semibold mb-2">Mark:</label>
                <input type="number" name="mark" id="question-mark" class="border border-gray-300 p-2 rounded-md w-full focus:outline-none focus:ring-1 focus:ring-blue-300">
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-400">Add Question</button>
        </form>
    </div>
@endsection
