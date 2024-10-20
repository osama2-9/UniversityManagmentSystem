@extends('layout.professorLayout')

@section('title')
    Quizzes
@endsection

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-4xl text-center font-extrabold text-gray-800 mb-6">Manage Quizzes</h1>

        @if (session('success'))
            <div
                class="bg-green-100 border-l-4 md:mx-10 border-green-500 text-green-700 p-4 rounded-lg mb-6 flex justify-between items-center">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.style.display='none'" class="text-xl font-bold">X</button>
            </div>
        @endif

        @if (session('error'))
            <div
                class="bg-red-100 border-l-4 md:mx-10 border-red-500 text-red-700 p-4 rounded-lg mb-6 flex justify-between items-center">
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.style.display='none'" class="text-xl font-bold">X</button>
            </div>
        @endif

        @if ($quizzes->isEmpty())
            <div class="bg-gray-100 p-6 rounded-md shadow-md text-center">
                <p class="text-lg text-gray-600">No quizzes available.</p>
            </div>
        @else
            <div class="overflow-x-auto shadow-md rounded-lg border border-gray-300 mt-6">
                <table class="min-w-full table-auto bg-white">
                    <thead class="bg-indigo-600 text-white">
                        <tr class="text-center">
                            <th class="py-4 px-6">Quiz ID</th>
                            <th class="py-4 px-6">Quiz Title</th>
                            <th class="py-4 px-6">Course</th>
                            <th class="py-4 px-6">Start Time</th>
                            <th class="py-4 px-6">End Time</th>
                            <th class="py-4 px-6">Total Marks</th>
                            <th class="py-4 px-6">Quiz Duration</th>

                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6">Created At</th>
                            <th class="py-4 px-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 divide-y divide-gray-200 text-center">
                        @foreach ($quizzes as $quiz)
                            <tr class="hover:bg-gray-100 transition ease-in-out duration-200">
                                <td class="py-4 px-6">{{ $quiz->quiz_id }}</td>
                                <td class="py-4 px-6">{{ $quiz->quiz_title }}</td>
                                <td class="py-4 px-6">{{ $quiz->course_title }}</td>
                                <td class="py-4 px-6">{{ \Carbon\Carbon::parse($quiz->start_time)->format('Y-m-d H:i') }}
                                </td>
                                <td class="py-4 px-6">{{ \Carbon\Carbon::parse($quiz->end_time)->format('Y-m-d H:i') }}</td>
                                <td class="py-4 px-6 font-semibold">{{ $quiz->total_marks }}</td>
                                 <td class="py-4 px-6">{{ $quiz->quiz_duration }} minutes</td>
                                <td class="py-4 px-6">
                                    <span
                                        class="{{ $quiz->isQuizActive ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} px-3 py-1 rounded-full font-semibold text-sm">
                                        {{ $quiz->isQuizActive ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">{{ \Carbon\Carbon::parse($quiz->created_at)->format('Y-m-d H:i') }}
                                </td>
                                <td class="py-4 px-6 flex items-center space-x-4">
                                    <button
                                        onclick="openUpdateModal('{{ $quiz->quiz_id }}', '{{ $quiz->quiz_title }}', '{{ $quiz->total_marks }}', '{{ $quiz->start_time }}', '{{ $quiz->end_time }}', '{{ $quiz->quiz_description }}', {{ $quiz->isQuizActive ? 'true' : 'false' }} , {{$quiz->quiz_duration}})"
                                        class="text-blue-600 hover:underline">Edit</button>

                                    <form action="{{ route('quiz.toggleStatus') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="quiz_id" value="{{ $quiz->quiz_id }}">
                                        <button type="submit"
                                            class="hover:underline {{ $quiz->isQuizActive ? 'text-red-600' : 'text-green-600' }}">
                                            {{ $quiz->isQuizActive ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('quiz.delete') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="quiz_id" value="{{ $quiz->quiz_id }}">
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div id="updateModal" class="fixed inset-0 z-50 flex justify-center items-center hidden bg-gray-600 bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg mx-4">
                <h2 class="text-2xl font-bold text-gray-700 mb-4">Update Quiz</h2>
                <form id="updateQuizForm" method="POST" action="{{ route('quiz.update') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="quiz_id" id="quiz_id">

                    <div class="mb-5">
                        <label for="quiz_title" class="block text-gray-600 font-medium mb-2">Quiz Title</label>
                        <input type="text" name="quiz_title" id="quiz_title"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-300">
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-600 font-medium mb-2" for="start_time">Start Time</label>
                        <input type="datetime-local" id="start_time" name="start_time"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-300">
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-600 font-medium mb-2" for="end_time">End Time</label>
                        <input type="datetime-local" id="end_time" name="end_time"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-300">
                    </div>
                    <div class="mb-5">
                        <label for="quiz_duration" class="block text-gray-600 font-medium mb-2">Quiz Duration
                            (minutes)</label>
                        <input type="number" name="quiz_duration" id="quiz_duration"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-300">
                    </div>

                    <div class="mb-5">
                        <label for="quiz_description" class="block text-gray-600 font-medium mb-2">Quiz Description</label>
                        <textarea name="quiz_description" id="quiz_description"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-300"></textarea>
                    </div>

                    <div class="mb-5">
                        <label for="total_marks" class="block text-gray-600 font-medium mb-2">Total Marks</label>
                        <input type="number" name="total_marks" id="total_marks"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-300">
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" class="px-4 py-2 bg-gray-200 text-black rounded-lg hover:bg-gray-300"
                            onclick="closeUpdateModal()">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-800">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function formatDateForInput(dateStr) {
            const date = new Date(dateStr);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            return `${year}-${month}-${day}T${hours}:${minutes}`;
        }

        function openUpdateModal(quizId, quizTitle, totalMarks, startTime, endTime, quizDescription, isQuizActive ,quizDuration) {
            document.getElementById('quiz_id').value = quizId;
            document.getElementById('quiz_title').value = quizTitle;
            document.getElementById('total_marks').value = totalMarks;
            document.getElementById('start_time').value = formatDateForInput(startTime);
            document.getElementById('end_time').value = formatDateForInput(endTime);
            document.getElementById('quiz_description').value = quizDescription;
            document.getElementById('updateModal').classList.remove('hidden');
            document.getElementById('quiz_duration').value =quizDuration
        }

        function closeUpdateModal() {
            document.getElementById('updateModal').classList.add('hidden');
        }
    </script>
@endsection
