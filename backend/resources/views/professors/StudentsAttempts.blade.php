@extends('layout.professorLayout')

@section('title', 'Students Attempts')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold mb-8 text-gray-900">Student Attempts</h1>

        <div class="overflow-x-auto shadow-lg rounded-lg">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-blue-600 text-white text-left text-sm leading-normal">
                        <th class="px-6 py-3 border">Name</th>
                        <th class="px-6 py-3 border">Email</th>
                        <th class="px-6 py-3 border">Course</th>
                        <th class="px-6 py-3 border">Quiz Title</th>
                        <th class="px-6 py-3 border">Score</th>
                        <th class="px-6 py-3 border">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @foreach ($studentAttempts as $attempt)
                        <tr class="hover:bg-gray-100 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 font-semibold border-b border-gray-200">{{ $attempt->first_name }}
                                {{ $attempt->last_name }}</td>
                            <td class="px-6 py-4 font-semibold border-b border-gray-200">{{ $attempt->email }}</td>
                            <td class="px-6 py-4 font-semibold border-b border-gray-200">{{ $attempt->course_name }}</td>
                            <td class="px-6 py-4 font-semibold border-b border-gray-200">{{ $attempt->quiz_title }}</td>
                            <td class="px-6 py-4 font-semibold border-b border-gray-200">{{ $attempt->score }}</td>
                            <td class="px-6 py-4 font-semibold border-b border-gray-200">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-500 transition"
                                    onclick="showAttemptsModal({{ $attempt->student_id }}, '{{ $attempt->first_name }} {{ $attempt->last_name }}' ,{{ $attempt->attempt_id }})">
                                    View Attempts
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="quizAttemptsModal"
            class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center transition duration-300">
            <div class="bg-white w-full max-w-3xl max-h-screen p-8 rounded-lg shadow-lg relative overflow-y-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800" id="student-name">Quiz Attempts</h2>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="text-right text-gray-600 mb-4" id="score-display">Score: 0</div>

                <div class="overflow-x-auto mt-4">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg text-sm">
                        <thead>
                            <tr class="bg-blue-100 text-gray-700">
                                <th class="px-4 py-2 border">Question</th>
                                <th class="px-4 py-2 border">Correct Answer</th>
                                <th class="px-4 py-2 border">Submitted Answer</th>
                                <th class="px-4 py-2 border">Correction</th>
                                <th class="px-4 py-2 border">Manual Correction</th>
                            </tr>
                        </thead>
                        <tbody id="quiz-attempts-table" class="text-sm text-gray-600">
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <form id="corrections-form" action="{{ route('quiz.scoreSubmit') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="attempt_id" id="attempt-id">

                        <div>
                            <label for="final-score" class="block font-semibold text-gray-700 mb-2">Final Score</label>
                            <input type="number" id="final-score"
                                class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter final score" name="score" />
                        </div>

                        <div class="text-right">
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-blue-500 transition">
                                Submit Corrections
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>

    <script>
        let totalScore = 0;

        function showAttemptsModal(studentId, studentName, attemptId) {
            document.getElementById('student-name').innerText = studentName + "'s Quiz Attempts";
            totalScore = 0;
            document.getElementById('score-display').innerText = 'Score: 0';
            document.getElementById('final-score').value = '';
            document.getElementById('attempt-id').value = attemptId;

            fetch(`{{ route('quiz.studentAnswer') }}?student_id=${studentId}&attempt_id=${attemptId}`)

                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('quiz-attempts-table');
                    tableBody.innerHTML = '';
                    data.forEach(answer => {
                        const isShortAnswer = answer.question_type === 'short';
                        const isCorrect = answer.submitted_answer === answer.answer_text;
                        if (isCorrect) {
                            totalScore += 2;
                        }

                        const correction = isShortAnswer ? `
                    <input type="text" class="border border-gray-300 px-2 py-1 rounded-md" placeholder="Enter correction" data-question-id="${answer.id}">
                ` : (isCorrect ? 'Correct' : 'Incorrect');

                        const manualCorrection = `
                    <input type="checkbox" class="mr-2" data-question-id="${answer.id}" ${isCorrect ? 'checked' : ''}>
                `;

                        tableBody.innerHTML += `
                    <tr>
                        <td class="border font-semibold px-4 py-2">${answer.question_text}</td>
                        <td class="border font-semibold px-4 py-2">${answer.answer_text}</td>
                        <td class="border font-semibold px-4 py-2">${answer.submitted_answer}</td>
                        <td class="border font-semibold px-4 py-2">${correction}</td>
                        <td class="border font-semibold px-4 py-2">${manualCorrection}</td>
                    </tr>
                `;
                    });
                    document.getElementById('score-display').innerText = 'Score: ' + totalScore;
                })
                .catch(error => {
                    console.error('Error fetching quiz attempts:', error);
                });

            document.getElementById('quizAttemptsModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('quizAttemptsModal').classList.add("hidden")
        }
    </script>
@endsection
