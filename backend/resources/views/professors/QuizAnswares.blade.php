@extends('layout.professorLayout')

@section('title', 'Add Answers')

@section('content')
    <div class="max-w-6xl mx-auto my-10 p-8 bg-white rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold mb-6 text-center">Add Answers</h2>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-300 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('quiz.storeAnswer') }}" method="POST" class="space-y-6">
            @csrf
            <input id="hidden_question_id" type="hidden" name="question_id">

            <div class="mb-4">
                <label for="question_id" class="block text-gray-700 font-medium">Select Question:</label>
                <select name="question_id" id="question_id" class="w-full p-2 border border-gray-300 rounded-md" required>
                    <option value="" selected disabled>Select a Question</option>
                    @foreach ($questions as $question)
                        <option value="{{ $question->id }}" data-type="{{ $question->question_type }}">
                            {{ $question->question_text }} ({{ $question->question_type }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="multiple_choice_fields" style="display: none;" class="space-y-4">
                <h4 class="text-lg font-semibold">Multiple Choice Answers</h4>
                @for ($i = 1; $i <= 3; $i++)
                    <div class="flex items-center space-x-4">
                        <input type="text" name="multiple_choice_answers[]" placeholder="Answer {{ $i }}"
                            class="w-full p-2 border border-gray-300 rounded-md" />
                        <input type="checkbox" name="is_correct[]" value="{{ $i - 1 }}"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                        <span class="text-gray-700">Correct</span>
                    </div>
                @endfor
            </div>

            <div id="true_false_fields" style="display: none;" class="space-y-4">
                <h4 class="text-lg font-semibold">True or False</h4>
                <div class="flex items-center space-x-4">
                    <input type="radio" name="true_false_answer" value="true"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                    <span class="text-gray-700">True</span>
                </div>
                <div class="flex items-center space-x-4">
                    <input type="radio" name="true_false_answer" value="false"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                    <span class="text-gray-700">False</span>
                </div>
            </div>

            <div id="short_answer_fields" style="display: none;" class="space-y-4">
                <h4 class="text-lg font-semibold">Short Answer</h4>
                <textarea name="short_answer_text" id="answer_text" rows="4" class="w-full p-2 border border-gray-300 rounded-md"
                    placeholder="Enter your answer"></textarea>
            </div>

            <button type="submit"
                class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Save Answer
            </button>
        </form>
    </div>

    <script>
        document.getElementById('question_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const questionType = selectedOption.getAttribute('data-type');

            document.getElementById('hidden_question_id').value = selectedOption.value;

            document.getElementById('multiple_choice_fields').style.display = 'none';
            document.getElementById('true_false_fields').style.display = 'none';
            document.getElementById('short_answer_fields').style.display = 'none';

            if (questionType === 'multiple_choice') {
                document.getElementById('multiple_choice_fields').style.display = 'block';
            } else if (questionType === 'true_false') {
                document.getElementById('true_false_fields').style.display = 'block';
            } else if (questionType === 'short_answer') {
                document.getElementById('short_answer_fields').style.display = 'block';
            }
        });
    </script>
@endsection
