@extends('layout.professorLayout')

@section('title')
    Students
@endsection

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-blue-700 text-white p-6 rounded-lg shadow-lg mb-6">
            <h1 class="text-3xl font-bold text-center">Student Table</h1>
        </div>

        <!-- Search Bar -->
        <div class="mb-6">
            <form method="GET" action="{{ route('admin.getStudents') }}" class="flex justify-center space-x-2">
                <input id="search" type="text" name="search" placeholder="Search by Student Code"
                    class="w-full max-w-md border border-gray-300 rounded-full px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button id="searchButton" type="submit"
                    class="bg-blue-700 text-white px-6 py-2 rounded-full shadow-md hover:bg-blue-800 transition duration-200 ease-in-out">
                    Search
                </button>
            </form>
        </div>


        <div class="bg-white p-4 rounded-lg shadow-lg overflow-x-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-200 rounded-lg">
                <thead class="bg-blue-600 text-white rounded-lg">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Student Code</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">First Name</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Last Name</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Email</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Semester</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Major</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Date of Birth</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Course Name</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Course Code</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Credits</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Enrollment Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($students as $enrollment)
                        <tr class="hover:bg-gray-100 border-b border-gray-200 transition duration-150">
                            <td class="px-4 py-3 text-sm">{{ $enrollment->student_code }}</td>
                            <td class="px-4 py-3 text-sm">{{ $enrollment->first_name }}</td>
                            <td class="px-4 py-3 text-sm">{{ $enrollment->last_name }}</td>
                            <td class="px-4 py-3 text-sm">{{ $enrollment->email }}</td>
                            <td class="px-4 py-3 text-sm">{{ $enrollment->semester }}</td>
                            <td class="px-4 py-3 text-sm">{{ $enrollment->major ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm">
                                {{ \Carbon\Carbon::parse($enrollment->date_of_birth)->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 text-sm">{{ $enrollment->course_name }}</td>
                            <td class="px-4 py-3 text-sm">{{ $enrollment->course_code }}</td>
                            <td class="px-4 py-3 text-sm">{{ $enrollment->credits }}</td>
                            <td class="px-4 py-3 text-sm">
                                {{ \Carbon\Carbon::parse($enrollment->created_at)->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <div class="mt-6 flex justify-center">
            {{ $students->links() }}
        </div>
    </div>

    <script>
        const searchInput = document.getElementById("search");
        const rows = document.querySelectorAll("tbody tr");

        searchInput.addEventListener("input", function() {
            const searchValue = this.value.toLowerCase();

            rows.forEach((row) => {
                const studentCode = row.querySelector('td:first-child').textContent.toLowerCase();

                if (studentCode.includes(searchValue)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
