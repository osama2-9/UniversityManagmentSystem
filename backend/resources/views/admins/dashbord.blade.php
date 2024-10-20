@extends('layout.adminLayout')

@section('title')
    Admin Dashboard
@endsection

@section('content')
    <div class="flex">

        <main class="flex-1 p-8 bg-gray-100">
            <div class="mb-6">
                <h1 class="text-4xl font-semibold text-gray-800">Welcome, Mr. {{ $admin->full_name ?? '' }}</h1>
                <p class="text-lg text-gray-600">Last login: {{ \Carbon\Carbon::now()->format('d M, Y H:i') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 shadow-lg rounded-lg transition-transform transform hover:scale-105">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2"><i class="fas fa-users mr-2"></i> Total Students</h2>
                    <p class="text-3xl font-bold text-green-600">{{ $stdNumber ?? 0 }}</p>
                </div>

                <div class="bg-white p-6 shadow-lg rounded-lg transition-transform transform hover:scale-105">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2"><i class="fas fa-chalkboard-teacher mr-2"></i> Active
                        Professors</h2>
                    <p class="text-3xl font-bold text-blue-600">{{ $profNumber ?? 0 }}</p>
                </div>

                <div class="bg-white p-6 shadow-lg rounded-lg transition-transform transform hover:scale-105">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2"><i class="fas fa-book-open mr-2"></i> Ongoing Courses
                    </h2>
                    <p class="text-3xl font-bold text-red-600">{{ $ocnumber ?? 0 }}</p>
                </div>

                <div class="bg-white p-6 shadow-lg rounded-lg transition-transform transform hover:scale-105">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2"><i class="fas fa-user-plus mr-2"></i> New Enrollments
                    </h2>
                    <p class="text-3xl font-bold text-yellow-600">{{ $enronumber ?? 0 }}</p>
                </div>
            </div>

            <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">Recent Activities</h2>
                <ul class="space-y-3">
                    <li class="flex justify-between items-center">
                        <p class="text-gray-700"><i class="fas fa-user-graduate mr-2"></i> John Doe enrolled in Computer
                            Science</p>
                        <span class="text-sm text-gray-500">10 mins ago</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <p class="text-gray-700"><i class="fas fa-book mr-2"></i> New course added: Advanced AI</p>
                        <span class="text-sm text-gray-500">1 hour ago</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <p class="text-gray-700"><i class="fas fa-chalkboard-teacher mr-2"></i> Prof. Jane Smith updated Web
                            Development syllabus</p>
                        <span class="text-sm text-gray-500">3 hours ago</span>
                    </li>
                </ul>
            </div>

            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">Enrollment Statistics</h2>
                <div id="enrollment-chart">
                    <canvas id="enrollmentChart"></canvas>
                </div>
            </div>
        </main>
    </div>

    <script>
        var ctx = document.getElementById('enrollmentChart').getContext('2d');
        var enrollmentChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Enrollments',
                    data: [120, 190, 300, 500, 600, 300, 450],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
