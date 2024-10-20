@extends('layout.professorLayout')

@section('title', 'Grades')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold text-gray-800 mb-8">Grades</h1>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    @foreach (['Student ID', 'First Name', 'Last Name', 'Email', 'College', 'Major', 'Student Code','Course ID', 'Course Name', 'Course Code', 'Grade', 'Actions'] as $header)
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($enrollments as $enrollment)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $enrollment->student_id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $enrollment->first_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $enrollment->last_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $enrollment->email }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $enrollment->dept_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $enrollment->major }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $enrollment->student_code }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $enrollment->course_id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $enrollment->course_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $enrollment->course_code }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $enrollment->grade }}</td>
                    <td class="px-6 py-4 text-sm">

                        <button type="button" class="bg-green-600 text-white p-1 rounded-lg" onclick="openAddGradeModal('{{ $enrollment->student_id }}', '{{ $enrollment->first_name }}', '{{ $enrollment->last_name }}', '{{ $enrollment->student_code }}', '{{ $enrollment->course_name }}' ,'{{$enrollment->course_id}}')">Add Grade</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div id="addGradeModal" class="fixed inset-0 flex items-center justify-center bg-gray-600 bg-opacity-75 hidden transition-opacity">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-xl font-semibold mb-6 text-gray-800">Add Grade</h2>
            <form id="addGradeForm" class="space-y-4" method="POST" action="">
                @csrf
                <input type="hidden" id="modalStudentId" name="student_id">
                <input type="hidden" id="modalFirstName" name="first_name">
                <input type="hidden" id="modalLastName" name="last_name">
                <input type="hidden" id="modalStudentCode" name="student_code">
                <input type="hidden" id="modalCourseName" name="course_name">
                <input type="hidden" id="modalCourseId" name="courseId">

                <div class="mb-4">
                    <label for="studentName" class="block text-sm font-medium text-gray-700">Student</label>
                    <input type="text" id="studentName" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" readonly>
                </div>

                <div class="mb-4">
                    <label for="courseName" class="block text-sm font-medium text-gray-700">Course</label>
                    <input type="text" id="courseName" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" readonly>
                </div>

                <div>
                    <label for="grade" class="block text-sm font-medium text-gray-700">Grade</label>
                    <input type="text" id="grade" name="grade" placeholder="Enter grade" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow-sm hover:bg-blue-700 transition">Submit</button>
                    <button type="button" class="bg-gray-300 text-gray-700 px-5 py-2 rounded-lg shadow-sm hover:bg-gray-400 transition" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>

    function openAddGradeModal(studentId,firstName,lastName,studentCode,courseName ,courseId) {
        const form = document.getElementById('addGradeForm')

    document.getElementById("modalStudentId").value = studentId;
    document.getElementById("modalFirstName").value = firstName;
    document.getElementById("modalLastName").value = lastName;
    document.getElementById("modalStudentCode").value = studentCode;
    document.getElementById("modalCourseName").value = courseName;
    document.getElementById("modalCourseId").value = courseId;


    document.getElementById("studentName").value = `${firstName} ${lastName} (${studentCode})`;
    document.getElementById("courseName").value = courseName;

    document.getElementById("addGradeModal").classList.remove("hidden");
    setTimeout(
        () =>
            document.getElementById("addGradeModal").classList.add("transition-opacity"),10);

     form.action = `/professor/grade/${studentId}/${courseId}`;
     console.log(form.action = `/professor/grade/${studentId}/${courseId}`);




}

function closeModal() {
    document.getElementById("addGradeModal").classList.add("hidden");
}


</script>

@endsection
