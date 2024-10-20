@extends('layout.studentLayout')

@section('title')
    Show Enrollments
@endsection

@section('content')
    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-8 mt-10">
        <div class="flex-1 p-10 bg-white">

            @if (session('error'))
                <div class="container w-full bg-red-200 p-4 mb-4">
                    <p class="text-red-600">{{ session('error') }}</p>
                </div>
            @elseif(session('message'))
                <div class="container w-full bg-green-200 p-4 mb-4">
                    <p class="text-green-600">{{ session('message') }}</p>
                </div>
            @endif

            <h2 class="text-4xl font-extrabold text-gray-900 text-center mb-6">Course Enrollments</h2>
            <p class="text-center text-gray-500 mb-8">Click on a course to view available professors and schedule details.</p>

            <div class="space-y-6 mb-5">
                @foreach ($availableCourses as $group)
                    <div class="bg-gray-50 hover:bg-gray-100 transition-colors duration-300 rounded-lg shadow-md">
                        <button onclick="toggleDropdown('{{ $group['course']['id'] }}')" aria-expanded="false"
                            aria-controls="{{ $group['course']['id'] }}"
                            class="flex justify-between items-center w-full text-left px-6 py-4 focus:outline-none">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $group['course']['name'] }}</h3>
                            <svg class="w-5 h-5 transform transition-transform duration-300"
                                id="icon-{{ $group['course']['id'] }}" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2" d="M6 9l6 6 6-6" />
                            </svg>
                        </button>

                        <div id="{{ $group['course']['id'] }}" class="hidden mt-2 px-4 pb-4 text-white">
                            <table class="min-w-full  bg-white border border-gray-300 text-white rounded-lg shadow-md">
                                <thead class="bg-blue-500 ">
                                    <tr class="text-white">
                                        <th class="py-3 px-5 border-b text-left font-semibold ">Professor</th>
                                        <th class="py-3 px-5 border-b text-left font-semibold ">Start Time</th>
                                        <th class="py-3 px-5 border-b text-left font-semibold ">End Time</th>
                                        <th class="py-3 px-5 border-b text-left font-semibold ">Days</th>
                                        <th class="py-3 px-5 border-b text-left font-semibold ">Credits</th>
                                        <th class="py-3 px-5 border-b text-left font-semibold ">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($group['schedules'] as $schedule)
                                        <tr class="hover:bg-gray-100 transition-colors duration-200">
                                            <td class="py-3 px-5 border-b text-gray-800">{{ $group['course']['professor'] }}</td>
                                            <td class="py-3 px-5 border-b text-gray-800">{{ $schedule['start_time'] }}</td>
                                            <td class="py-3 px-5 border-b text-gray-800">{{ $schedule['end_time'] }}</td>
                                            <td class="py-3 px-5 border-b text-gray-800">{{ $schedule['day_of_week'] }}</td>
                                            <td class="py-3 px-5 border-b text-gray-800">{{ $group['course']['credits'] }}</td>
                                            <td class="py-3 px-5 border-b text-center">
                                                <form action="{{ route('student.enroll') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                    <input type="hidden" name="course_id" value="{{ $group['course']['id'] }}">
                                                    <input type="hidden" name="professor_id" value="{{ $group['course']['professor'] }}">
                                                    <input type="hidden" name="student_current_semester" value="{{ $student->semester }}">
                                                    <input type="hidden" name="days_of_week" value="{{ $schedule['day_of_week'] }}">
                                                    <input type="hidden" name="credits" value="{{ $group['course']['credits'] }}">
                                                    <button type="submit" class="text-blue-600 hover:underline focus:outline-none">Enroll</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <script>
            function toggleDropdown(id) {
                var element = document.getElementById(id);
                var icon = document.getElementById('icon-' + id);

                element.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');

                var isExpanded = element.classList.contains('hidden') ? 'false' : 'true';
                element.previousElementSibling.setAttribute('aria-expanded', isExpanded);
            }
        </script>
    @endsection
