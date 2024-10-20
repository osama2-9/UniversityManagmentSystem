@extends('layout.adminLayout')

@section('title')
    Show Departments
@endsection

@section('content')
    <div class="container mx-auto mt-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6">
                <h2 class="text-3xl font-bold text-center">Departments</h2>
            </div>
        </div>

        <div class="p-6">
            <div class="flex justify-center space-x-2">
                <input type="text" id="search" name="search" placeholder="Search by name..."
                    class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-500"
                    onkeyup="filterTable()">
            </div>
        </div>

        <div class="p-8">
            <div class="overflow-x-auto">
                <table id="departmentstable" class="min-w-full table-auto border border-gray-200 rounded-lg shadow-md">
                    <thead class="bg-gray-800 text-white">
                        <tr class="text-md font-semibold">
                            <th class="px-6 py-4 border-b-2 border-gray-300 text-center">Department Name</th>
                            <th class="px-6 py-4 border-b-2 border-gray-300 text-center">Phone</th>
                            <th class="px-6 py-4 border-b-2 border-gray-300 text-center">Building</th>
                            <th class="px-6 py-4 border-b-2 border-gray-300 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                            <tr class="hover:bg-gray-200 transition-all">
                                <td class="text-center p-2 border-b-2 border-gray-200 text-md">{{ $department->dept_name }}
                                </td>
                                <td class="text-center p-2 border-b-2 border-gray-200 text-md">{{ $department->phone }}</td>
                                <td class="text-center p-2 border-b-2 border-gray-200 text-md">{{ $department->building }}
                                </td>
                                <td class="px-6 py-4 border-b border-gray-200 text-center">
                                    <div class="flex justify-center space-x-4">
                                        <!-- Edit Button -->
                                        <button
                                            onclick="openUpdateModal({{ $department->id }}, '{{ $department->dept_name }}', '{{ $department->phone }}', '{{ $department->building }}')"
                                            class="text-blue-500 hover:text-blue-700">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.232 5.232a3 3 0 014.243 4.243l-9.192 9.192a4 4 0 01-1.414.94l-3.858.772a1 1 0 01-1.212-1.212l.772-3.858a4 4 0 01.94-1.414l9.192-9.192z">
                                                </path>
                                            </svg>
                                        </button>
                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.deleteDepartment') }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="department_id" value="{{ $department->id }}">
                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="updateModal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50">
            <div class="bg-white rounded-md shadow-md p-6 w-96">
                <form action="{{ route('admin.updateDepartment') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="department_id" id="modal_department_id">
                    <div class="mb-4">
                        <label for="dept_name" class="block mb-2 font-semibold">Department Name</label>
                        <input type="text" name="dept_name" id="modal_dept_name"
                            class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="building" class="block mb-2 font-semibold">Building</label>
                        <input type="text" name="building" id="modal_building"
                            class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block mb-2 font-semibold">Phone</label>
                        <input type="text" name="phone" id="modal_phone"
                            class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="flex justify-end">
                        <button onclick="closeModal()"
                            class="bg-gray-300 me-3 text-black px-4 py-2 rounded-md">Close</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openUpdateModal(id, deptName, phone, building) {
                document.getElementById('modal_department_id').value = id;
                document.getElementById('modal_dept_name').value = deptName;
                document.getElementById('modal_phone').value = phone;
                document.getElementById('modal_building').value = building;
                document.getElementById('updateModal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('updateModal').classList.add('hidden');

            }

            function filterTable() {
                let input = document.getElementById("search");
                let filter = input.value.toLowerCase();
                let table = document.getElementById("departmentstable");
                let tr = table.getElementsByTagName("tr");

                for (let i = 1; i < tr.length; i++) {
                    let td = tr[i].getElementsByTagName("td")[0];
                    if (td) {
                        let txtValue = td.textContent || td.innerText;
                        tr[i].style.display = txtValue.toLowerCase().indexOf(filter) > -1 ? "" : "none";
                    }
                }
            }
        </script>
    </div>
@endsection
