@extends('layout.adminLayout')

@section('title')
    Show Professors
@endsection

@section('content')
    <div class="container mx-auto mt-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6">
                <h2 class="text-3xl font-bold text-center">Professors List</h2>
            </div>

            <div class="p-6">
                <div class="flex justify-center space-x-2">
                    <input type="text" id="search" name="search" placeholder="Search by name..."
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-500"
                        onkeyup="filterTable()">
                </div>
            </div>

            @if (session('error'))
                <div
                    class="w-full md:m-5 bg-red-50 p-2 border-r-4 border-red-500 rounded-lg shadow-md flex items-center space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10A8 8 0 110 10a8 8 0 0118 0zm-9-4a1 1 0 000 2h.01a1 1 0 000-2H9zM9 7a1 1 0 000 2h1v2H9a1 1 0 000 2h1a1 1 0 010 2H9a1 1 0 000 2h1a1 1 0 000-4h1V9H9a1 1 0 000-2h1a1 1 0 000-2H9z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-red-500 font-semibold text-xl">{{ session('error') }}</p>
                </div>
            @elseif (session('success'))
            <div
                class="w-full md:m-5 bg-green-50 p-2 border-l-4 border-green-500 rounded-lg shadow-sm flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-10.707a1 1 0 00-1.414-1.414L9 9.586 7.707 8.293a1 1 0 00-1.414 1.414L8.293 11l-2.293 2.293a1 1 0 001.414 1.414L9 12.414l2.293 2.293a1 1 0 001.414-1.414L10.414 11l2.293-2.293z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-green-500 font-semibold text-xl">{{ session('success') }}</p>
            </div>

            @endif


            <div class="p-8">
                <div class="overflow-x-auto">
                    <table id="professorsTable" class="min-w-full table-auto border border-gray-200 rounded-lg shadow-md">
                        <thead class="bg-gray-800 text-white">
                            <tr class="text-sm font-semibold">
                                <th class="px-6 py-4 border-b-2 border-gray-300 text-left">Full Name</th>
                                <th class="px-6 py-4 border-b-2 border-gray-300 text-left">Email</th>
                                <th class="px-6 py-4 border-b-2 border-gray-300 text-left">Phone</th>
                                <th class="px-6 py-4 border-b-2 border-gray-300 text-left">Department</th>
                                <th class="px-6 py-4 border-b-2 border-gray-300 text-left">Office</th>
                                <th class="px-6 py-4 border-b-2 border-gray-300 text-left">Address</th>
                                <th class="px-6 py-4 border-b-2 border-gray-300 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($professors as $professor)
                                <tr class="hover:bg-gray-100 transition duration-200 ease-in-out">
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">{{ $professor->full_name }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">{{ $professor->email }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">{{ $professor->phone }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">{{ $professor->dept_name }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">{{ $professor->office }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">
                                        {{ $professor->professor_address }}</td>
                                    <td class="px-6 py-4 border-b border-gray-200 text-center">
                                        <div class="flex justify-center space-x-4">
                                            <button
                                                onclick="openModal('{{ $professor->profId }}' ,'{{ $professor->full_name }}' ,'{{ $professor->dept_name }}' ,'{{ $professor->office }}' ,'{{ $professor->professor_address }}')"
                                                class="text-blue-500 hover:text-blue-700">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.232 5.232a3 3 0 014.243 4.243l-9.192 9.192a4 4 0 01-1.414.94l-3.858.772a1 1 0 01-1.212-1.212l.772-3.858a4 4 0 01.94-1.414l9.192-9.192z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <form
                                                onsubmit="confirm('This Professor will deleted immediately are you sure about this action ?')"
                                                action="{{ route('admin.deleteProfessor') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="professor_id" value="{{ $professor->profId }}">
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
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
        </div>
    </div>

    <div id="updateProfessorModal" class="fixed hidden inset-0 flex items-center justify-center  bg-gray-900 bg-opacity-50">
        <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg relative">
            <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 focus:outline-none"
                onclick="closeModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Update Professor</h2>
            <form method="POST" action="{{ route('admin.updateProfessor') }}">
                @csrf
                @method('PUT')
                <input type="hidden" id="professor_id" name="professor_id" value="{{ $professor->profId }}">

                <div class="mb-4">
                    <label for="professorName" class="block mb-2 font-semibold">Name</label>
                    <input type="text" name="full_name" id="professorName"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter professor name">
                </div>

                <div class="mb-4">
                    <label for="office" class="block mb-2 font-semibold">Office</label>
                    <input type="text" name="office" id="office"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter professor office">
                </div>

                <div class="mb-4">
                    <label class="block mb-2 font-semibold" for="department">Department</label>
                    <select name="department_id" class="w-full rounded-md border border-gray-300 p-2" id="department">
                        <option selected disabled>Select department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->department_id }}"
                                {{ $professor->department_id === $department->department_id ? 'selected' : '' }}>
                                {{ $department->dept_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="address" class="block mb-2 font-semibold">Address</label>
                    <textarea name="professor_address" id="address"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter professor address"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 focus:outline-none">
                        Update
                    </button>
                </div>
            </form>


            </form>
        </div>
    </div>


    <script>
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toLowerCase();
            table = document.getElementById("professorsTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        function closeModal() {
            document.getElementById("updateProfessorModal").classList.add("hidden")
        }

        function openModal(professor_id, fullname, department, office, address) {
            document.getElementById('updateProfessorModal').classList.remove("hidden")
            document.getElementById('professor_id').value = professor_id
            document.getElementById('professorName').value = fullname
            document.getElementById('department').value = department
            document.getElementById('office').value = office
            document.getElementById('address').value = address

        }
    </script>
@endsection
