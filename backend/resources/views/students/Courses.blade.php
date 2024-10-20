@extends('layout.studentLayout')

@section('title', 'Courses')

@section('content')
<div class="max-w-6xl mx-auto my-10 p-8 bg-white rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Courses</h1>

    <div class="mb-4">
        <label for="semester-filter" class="block text-gray-700 font-semibold mb-2">Filter by Semester:</label>
        <select id="semester-filter" class="border border-gray-300 rounded p-2 w-full" onchange="filterCourses()">
            <option value="">All Semesters</option>
            <option value="Fall 2023">Fall 2023</option>
            <option value="Spring 2024">Spring 2024</option>
            <option value="Summer 2024">Summer 2024</option>

        </select>
    </div>

    @if ($studentCourses && count($studentCourses) > 0)
        <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="py-3 px-4 border-b">Course Name</th>
                    <th class="py-3 px-4 border-b">Professor</th>
                    <th class="py-3 px-4 border-b">Semester</th>
                    <th class="py-3 px-4 border-b">Grade</th>
                    <th class="py-3 px-4 border-b">Enrollment Date</th>
                </tr>
            </thead>
            <tbody id="course-table-body">
                @foreach ($studentCourses as $course)
                    <tr class="hover:bg-gray-50 transition duration-200 ">
                        <td class="py-4 px-6 border-b">{{ $course->course_name }}</td>
                        <td class="py-4 px-6 border-b">{{ $course->professor_name }}</td>
                        <td class="py-4 px-6 border-b">{{ $course->semester }}</td>
                        <td class="py-4 px-6 border-b">{{ $course->grade }}</td>
                        <td class="py-4 px-6 border-b">{{ \Carbon\Carbon::parse($course->enrollment_date)->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center text-gray-600 mt-4">
            <p>No courses found for this student.</p>
        </div>
    @endif
</div>

<script>
    function filterCourses() {
        const filterValue = document.getElementById('semester-filter').value.toLowerCase();
        const tableBody = document.getElementById('course-table-body');
        const rows = tableBody.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const semesterCell = rows[i].getElementsByTagName('td')[2];
            if (semesterCell) {
                const semesterText = semesterCell.textContent.toLowerCase();
                if (filterValue === '' || semesterText.includes(filterValue)) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    }
</script>
@endsection
