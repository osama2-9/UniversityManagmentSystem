<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>@yield('title')</title>
</head>

<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <div class="w-72 bg-white text-blue-600 shadow-sm border-r border-gray-200">
            <div class="p-6 bg-blue-600 text-white text-center">
                <h2 class="text-3xl font-bold">Student Dashboard</h2>
            </div>
            <nav class="mt-4 space-y-2">
                <a href="{{ route('student.dashbord') }}" class="flex items-center py-3 px-6 rounded-md text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition-colors duration-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Home
                </a>
                <a href="{{ route('student.courses') }}" class="flex items-center py-3 px-6 rounded-md text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition-colors duration-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9v10h8V9m0 0L8 5m8 4L8 9" /></svg>
                    Courses
                </a>
                <a href="{{ route('student.enrollment') }}" class="flex items-center py-3 px-6 rounded-md text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition-colors duration-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v18l7-3 7 3V3H5z" /></svg>
                    Enrollment
                </a>
                <a href="{{ route('student.profile') }}" class="flex items-center py-3 px-6 rounded-md text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition-colors duration-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405 1.405a2.002 2.002 0 01-2.828 0L15 17zm-6.364-5.364a9 9 0 1112.728 0A9 9 0 018.636 11.636z" /></svg>
                    Profile
                </a>
                <form action="{{ route('student.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center py-3 px-6 rounded-md text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition-colors duration-300 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3" /></svg>
                        Logout
                    </button>
                </form>
            </nav>
        </div>

        <div class="flex-1 p-10 bg-gray-100">
            <div class="bg-white shadow-sm rounded-lg p-6">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>
