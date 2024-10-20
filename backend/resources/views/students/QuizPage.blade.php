@extends('layout.app')

@section('title', 'Quiz - Web Development Basics')

@section('content')
    <div class="container mx-auto py-10 flex flex-wrap justify-center">
        <div class="w-full md:w-3/4  ">
            <div class="bg-white shadow-xl rounded-lg p-6 mb-6 border border-gray-300">
                <h1 class="text-4xl font-extrabold text-gray-800 text-center mb-4">{{ $quizData->quiz_title }}</h1>
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="relative w-20 h-20">
                            <svg class="w-full h-full transform rotate-180" viewBox="0 0 36 36">
                                <path class="circle-bg" stroke="#d3d3d3" stroke-width="3" fill="none"
                                    d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831">
                                </path>
                                <path id="circle" stroke="#4a90e2" stroke-width="3" stroke-dasharray="100, 100"
                                    fill="none"
                                    d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831">
                                </path>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <p id="time" class="text-red-600 font-semibold text-lg">14:59</p>
                            </div>
                        </div>
                        <p class="text-gray-700 font-semibold">Time Remaining</p>
                    </div>
                    <p class="text-gray-700 font-semibold">Total Marks: {{ $quizData->total_marks }}</p>
                </div>
            </div>

            <form action="{{ route('quiz.submit') }}" method="POST" class="space-y-8">
                @csrf
                <input type="hidden" name="quiz_id" value="{{ $quizData->quiz_id }}">
                <input type="hidden" name="attempt_id" value="{{ request()->query('attempt_id') }}">
                <input type="hidden" name="student_id" value="{{ auth()->user()->id }}">

                @foreach ($questions as $index => $question)
                    <div class="bg-white shadow-md rounded-lg p-6 mb-8 border border-gray-300"
                        id="question_{{ $index + 1 }}">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ $index + 1 }}.
                            {{ $question['question_text'] }}</h2>
                        <div class="mt-4 space-y-3">
                            @if ($question['question_type'] == 'short_answer')
                                <input type="text" name="answers[{{ $question['question_id'] }}]"
                                    class="border border-gray-300 rounded-md w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    placeholder="Type your answer here...">
                            @elseif($question['question_type'] == 'true_false')
                                <div class="flex space-x-4">
                                    <label class="flex items-center">
                                        <input type="radio" name="answers[{{ $question['question_id'] }}]" value="true"
                                            class="mr-2">
                                        <span>True</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="answers[{{ $question['question_id'] }}]" value="false"
                                            class="mr-2">
                                        <span>False</span>
                                    </label>
                                </div>
                            @elseif($question['question_type'] == 'multiple_choice')
                                @foreach ($question['answers'] as $answer)
                                    <label class="flex items-center">
                                        <input type="radio" name="answers[{{ $question['question_id'] }}]"
                                            value="{{ $answer['answer_text'] }}" class="mr-2">
                                        <span>{{ $answer['answer_text'] }}</span>
                                    </label>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-md shadow-md hover:bg-blue-700 transition duration-200">
                        Submit Quiz
                    </button>
                </div>
            </form>
        </div>

        <!-- Quiz Navigation on the right as buttons -->
        <div class="w-full md:w-1/4 mb-6 sticky top-4">
            <div class="bg-white shadow-xl rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Quiz Navigation</h2>
                <div class="grid grid-cols-4 gap-4 text-center">
                    @foreach ($questions as $index => $question)
                        <a href="#question_{{ $index + 1 }}"
                            class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg hover:bg-blue-700 transition duration-200">
                            {{ $index + 1 }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        // Countdown Timer Script
        var totalSeconds = 15 * 60; // 15 minutes in seconds
        var circle = document.getElementById('circle');
        var timerElement = document.getElementById('time');

        function startTimer() {
            var countdown = setInterval(function() {
                if (totalSeconds <= 0) {
                    clearInterval(countdown);
                    alert("Time is up! Submitting the quiz.");
                    document.querySelector('form').submit(); // Submit form when time is up
                } else {
                    totalSeconds--;
                    var minutes = Math.floor(totalSeconds / 60);
                    var seconds = totalSeconds % 60;
                    timerElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

                    // Update circular progress
                    var progress = ((15 * 60 - totalSeconds) / (15 * 60)) * 100;
                    circle.setAttribute('stroke-dasharray', progress + ", 100");
                }
            }, 1000);
        }

        window.onload = startTimer;
    </script>

    <script>
        window.addEventListener('popstate', function(event) {
            if (event.state) {
                window.location.href = "/student/dashboard";
            }
        });
    </script>
@endsection
