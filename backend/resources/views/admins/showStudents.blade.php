@extends('layout.adminLayout')

@section('title')
    Show Students
@endsection

@section('content')
    <div class="container mx-auto mt-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-blue-600 text-white p-6">
                <h2 class="text-3xl font-bold text-center">Student Details</h2>
            </div>

            <div class="p-6">
                <form method="GET" action="{{ route('admin.getStudents') }}" class="mb-4">
                    <div class="flex justify-center space-x-2">
                        <input id="search" type="text" name="search" placeholder="Search by Student Code"
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-gray-500">
                        <button id="searchButton" type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-800">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            <div class="p-8">
                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-md shadow-md">
                        <div class="flex items-center">
                            <div class="ml-3">
                                <p class="text-lg leading-5 text-green-700">
                                    {{ session('success') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-md shadow-md">
                        <div class="flex items-center">
                            <div class="ml-3">
                                <p class="text-lg leading-5 text-red-700">
                                    {{ session('error') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>


            <div class="overflow-x-auto">
                <table id="studentsTable" class="min-w-full table-auto border border-gray-200 rounded-lg shadow-md">
                    <thead class="bg-green-500 text-white">
                        <tr class="text-sm font-semibold">
                            <th class="px-6 py-4 border-b-2 border-gray-300 text-left">ID</th>
                            <th class="px-6 py-4 border-b-2 border-gray-300 text-left">Student Code</th>
                            <th class="px-6 py-4 border-b-2 border-gray-300 text-left">First Name</th>
                            <th class="px-6 py-4 border-b-2 border-gray-300 text-left">Last Name</th>
                            <th class="px-6 py-4 border-b-2 border-gray-300 text-left">Email</th>
                            <th class="px-6 py-4 border-b-2 border-gray-300 text-left">Phone</th>
                            <th class="px-6 py-4 border-b-2 border-gray-300 text-left">Balance</th>
                            <th class="px-6 py-4 border-b-2 border-gray-300 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($students as $student)
                            <tr id="studentsdata" class="hover:bg-gray-100 transition duration-200 ease-in-out">
                                <td class="px-6 py-4 border-b border-gray-200 text-sm">{{ $student->id }}</td>
                                <td class="px-6 py-4 border-b border-gray-200 text-sm">{{ $student->student_code }}</td>
                                <td class="px-6 py-4 border-b border-gray-200 text-sm">{{ $student->first_name }}</td>
                                <td class="px-6 py-4 border-b border-gray-200 text-sm">{{ $student->last_name }}</td>
                                <td class="px-6 py-4 border-b border-gray-200 text-sm">{{ $student->email }}</td>
                                <td class="px-6 py-4 border-b border-gray-200 text-sm">{{ $student->phone }}</td>
                                <td class="px-6 py-4 border-b border-gray-200 text-sm">{{ $student->balance }}</td>
                                <td class="px-6 py-4 border-b border-gray-200 text-center">
                                    <div class="flex justify-center space-x-4">
                                        <a onclick="openUpdateStudentDataModel('{{ $student->student_code }}', '{{ $student->first_name }}', '{{ $student->last_name }}', '{{ $student->email }}', '{{ $student->phone }}')"  class="text-blue-500 hover:text-blue-700">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.232 5.232a3 3 0 014.243 4.243l-9.192 9.192a4 4 0 01-1.414.94l-3.858.772a1 1 0 01-1.212-1.212l.772-3.858a4 4 0 01.94-1.414l9.192-9.192z">
                                                </path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.deleteStudent') }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this student?');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="student_code" value="{{ $student->student_code }}">
                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </form>
                                        <div class="ml-2 cursor-pointer text-green-500 font-semibold text-xl"
                                            onclick="openBalanceModal({{ $student->student_code }} , {{ $student->balance }})">
                                            $
                                        </div>


                                    </div>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                 <div class="px-6 py-4">
        {{ $students->links() }}
    </div>
            </div>
        </div>
    </div>
    </div>

    <div id="balanceModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-200 bg-opacity-75 transition-opacity"></div>

            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:align-middle sm:max-w-lg sm:w-full sm:max-h-screen">
                <form method="POST" action="{{ route('admin.updateStudentBalance') }}">
                    @csrf
                    <div class="bg-green-600 p-6 rounded-t-lg">
                        <h3 class="text-2xl font-bold text-white">Update Balance</h3>
                    </div>
                    <div class="bg-white p-6">
                        <input type="hidden" name="student_code" id="studentId">
                        <div>
                            <label for="balance" class="block text-sm font-medium text-gray-700 mb-2">New Balance</label>
                            <input type="number" name="balance" id="studentBalance"
                                class="mt-1 block w-full rounded-md shadow-sm border-2 border-gray-800 p-3 focus:outline-none focus:ring-gray-800 focus:border-gray-800 transition duration-200 ease-in-out sm:text-lg"
                                placeholder="Enter new balance">
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 flex justify-end">
                        <button type="button" onclick="closeBalanceModal()"
                            class="mr-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">Cancel</button>
                        <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-800 transition duration-200">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


  <div id="editStudentModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-300 bg-opacity-75 transition-opacity"></div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:align-middle sm:max-w-lg sm:w-full sm:max-h-screen">
            <form method="POST" action="{{ route('admin.updateStudentData') }}">
                @csrf
                @method('PUT')
                <div class="bg-white p-6 rounded-t-lg border-b-2 border-gray-300">
                    <h3 class="text-2xl font-bold text-gray-900">Edit Student Data</h3>
                </div>
                <div class="bg-gray-50 p-6">
                    <input type="hidden" name="student_code" id="editStudentCode">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                        <input type="text" name="first_name" id="editFirstName"
                            class="mt-1 block w-full rounded-md shadow-sm border-2 border-gray-300 p-3 focus:outline-none focus:ring-gray-500 focus:border-gray-500 transition duration-200 ease-in-out sm:text-lg"
                            placeholder="Enter first name" required>
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                        <input type="text" name="last_name" id="editLastName"
                            class="mt-1 block w-full rounded-md shadow-sm border-2 border-gray-300 p-3 focus:outline-none focus:ring-gray-500 focus:border-gray-500 transition duration-200 ease-in-out sm:text-lg"
                            placeholder="Enter last name" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="editEmail"
                            class="mt-1 block w-full rounded-md shadow-sm border-2 border-gray-300 p-3 focus:outline-none focus:ring-gray-500 focus:border-gray-500 transition duration-200 ease-in-out sm:text-lg"
                            placeholder="Enter email" required>
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                        <input type="text" name="phone" id="editPhone"
                            class="mt-1 block w-full rounded-md shadow-sm border-2 border-gray-300 p-3 focus:outline-none focus:ring-gray-500 focus:border-gray-500 transition duration-200 ease-in-out sm:text-lg"
                            placeholder="Enter phone number" required>
                    </div>
                </div>
                <div class="bg-gray-100 p-4 flex justify-end border-t-2 border-gray-300">
                    <button type="button" onclick="closeUpdateStudentDataModel()" class="mr-2 bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-500 transition duration-300">Cancel</button>
                    <button  type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200" >Update</button>
                </div>
            </form>
        </div>
    </div>
</div>



    <script>


    function closeUpdateStudentDataModel(){
        document.getElementById('editStudentModal').classList.add('hidden')
    }


function openUpdateStudentDataModel(stdCode, firstName, lastName, email, phone) {
    document.getElementById('editStudentModal').classList.remove('hidden');
    document.getElementById('editStudentCode').value = stdCode;
    document.getElementById('editFirstName').value = firstName;
    document.getElementById('editLastName').value = lastName;
    document.getElementById('editEmail').value = email;
    document.getElementById('editPhone').value = phone;
}









        function openBalanceModal(studentId, currentBalance) {
            document.getElementById('balanceModal').classList.remove('hidden');
            document.getElementById('studentId').value = studentId;
            document.getElementById('studentBalance').value = currentBalance;



        }

        function closeBalanceModal() {
            document.getElementById('balanceModal').classList.add('hidden');
        }

        const searchInput = document.getElementById("search");
        const rows = document.querySelectorAll("#studentsTable tbody tr");

        KQ
        searchInput.addEventListener("input", function() {
            const searchValue = this.value.toLowerCase();

            rows.forEach((row) => {
                const studentCode = row.querySelector('td:nth-child(2)').textContent
                    .toLowerCase();

                if (studentCode.includes(searchValue)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
