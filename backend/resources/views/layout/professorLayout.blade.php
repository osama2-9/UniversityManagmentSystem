<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="flex flex-col h-screen bg-gray-100">
        <header class="bg-blue-700 text-white p-4 shadow-md flex justify-between items-center">
            <h1 class="text-2xl font-bold">Professor Dashboard</h1>

        </header>

        <div class="flex flex-1">
            <aside class="w-64 bg-white shadow-md p-4 border-r border-gray-200">
                <ul class="space-y-4">
                    <li>
                        <a href="{{ route('professor.dashboard') }}"
                            class="flex items-center text-blue-600 hover:bg-blue-100 p-2 rounded-md transition duration-300 ease-in-out">
                            <i class="fas fa-user text-lg mr-2"></i>Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('professor.profile') }}"
                            class="flex items-center text-blue-600 hover:bg-blue-100 p-2 rounded-md transition duration-300 ease-in-out">
                            <i class="fas fa-user text-lg mr-2"></i>Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('professor.showStudents') }}"
                            class="flex items-center text-blue-600 hover:bg-blue-100 p-2 rounded-md transition duration-300 ease-in-out">
                            <i class="fas fa-users text-lg mr-2"></i>View Students
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('professor.getGradesForm') }}"
                            class="flex items-center text-blue-600 hover:bg-blue-100 p-2 rounded-md transition duration-300 ease-in-out">
                            <i class="fas fa-users text-lg mr-2"></i>Grades
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('files.getForm') }}"
                            class="flex items-center text-blue-600 hover:bg-blue-100 p-2 rounded-md transition duration-300 ease-in-out">
                            <i class="fas fa-upload text-lg mr-2"></i>Uploaded Files
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('professor.studentsEnrollments') }}"
                            class="flex items-center text-blue-600 hover:bg-blue-100 p-2 rounded-md transition duration-300 ease-in-out">
                            <i class="fas fa-calendar-check text-lg mr-2"></i>Student Enrollments
                        </a>
                    </li>
                    <li class="relative group">
                        <a href="#"
                            class="flex items-center text-blue-600 hover:bg-blue-100 p-2 rounded-md transition duration-300 ease-in-out">
                            <i class="fas fa-graduation-cap text-lg mr-2"></i>Quizzes
                            <i class="fas fa-caret-down ml-auto"></i>
                        </a>
                        <div
                            class="absolute left-0 w-48 bg-white shadow-lg rounded-md mt-1 hidden group-hover:block transition-all duration-300 ease-in-out">
                            <a href="{{ route('professor.quiz') }}"
                                class="block px-4 py-2 text-gray-800 hover:bg-blue-100 transition duration-300">Create
                                Quiz</a>
                            <a href="{{ route('quizzes.show') }}"
                                class="block px-4 py-2 text-gray-800 hover:bg-blue-100 transition duration-300">Show
                                Quizzes</a>
                            <a href="{{ route('quiz.getQustions') }}"
                                class="block px-4 py-2 text-gray-800 hover:bg-blue-100 transition duration-300">Add
                                Questions</a>
                            <a href="{{ route('quiz.getAnsware') }}"
                                class="block px-4 py-2 text-gray-800 hover:bg-blue-100 transition duration-300">Add
                                Answers</a>
                            <a href="{{ route('quiz.studentsAttempts') }}"
                                class="block px-4 py-2 text-gray-800 hover:bg-blue-100 transition duration-300">Students
                                Attempts</a>
                        </div>
                    </li>
                </ul>
            </aside>

            <main class="flex-1 p-6 space-y-6">
                @yield('content')
            </main>
        </div>
    </div>


</body>

</html>
