@extends('layout.adminLayout')
@section('title')
    Show Classrooms
@endsection

@section('content')
    <div class="container mx-auto mt-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-md overflow-hidden">
            <div class="bg-blue-600 text-white py-4">
                <h2 class="text-2xl font-semibold text-center">Classrooms</h2>
            </div>

            <!-- Search Bar -->
            <div class="p-6">
                <form method="GET" action="" class="flex justify-end space-x-4">
                    <input type="text" name="search" placeholder="Search by Room Number" value="{{ request('search') }}"
                        class="border border-gray-300 rounded-lg px-4 py-2 w-full max-w-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        autocomplete="off">
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300 rounded-lg">
                    <thead class="bg-gray-800 text-white">
                        <tr class="text-md font-semibold">
                            <th class="px-6 py-4 text-center">ID</th>
                            <th class="px-6 py-4 text-center">Room Number</th>
                            <th class="px-6 py-4 text-center">Building</th>
                            <th class="px-6 py-4 text-center">Capacity</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($classrooms as $classroom)
                            <tr class="hover:bg-gray-100 transition-colors">
                                <td class="px-6 py-4 border-b border-gray-300 text-md text-center">{{ $classroom->id }}</td>
                                <td class="px-6 py-4 border-b border-gray-300 text-md text-center">
                                    {{ $classroom->room_number }}</td>
                                <td class="px-6 py-4 border-b border-gray-300 text-md text-center">
                                    {{ $classroom->building }}</td>
                                <td class="px-6 py-4 border-b border-gray-300 text-md text-center">
                                    {{ $classroom->capacity }}</td>
                                <td class="px-6 py-4 border-b border-gray-300 text-center">
                                    <div class="flex justify-center space-x-4">
                                        <button
                                            onclick="openUpdateModal('{{ $classroom->id }}','{{ $classroom->room_number }}','{{ $classroom->building }}','{{ $classroom->capacity }}')"
                                            class="text-blue-500 hover:text-blue-700">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.232 5.232a3 3 0 014.243 4.243l-9.192 9.192a4 4 0 01-1.414.94l-3.858.772a1 1 0 01-1.212-1.212l.772-3.858a4 4 0 01.94-1.414l9.192-9.192z">
                                                </path>
                                            </svg>
                                        </button>

                                        <form action="{{ route('admin.deleteClassroom') }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this classroom?');">
                                            @csrf
                                            @method('DELETE')

                                            <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">

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
    </div>

    <!-- Update Modal -->
    <div id="updateModal" class="fixed hidden inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Update Classroom</h3>
            <form action="{{ route('admin.updateClassroom') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="classroom_id" id="classroom_id">
                <div class="mb-4">
                    <label for="room-number" class="block text-sm font-semibold mb-1">Room Number</label>
                    <input type="text" name="room_number" id="room-number"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter new room number">
                </div>
                <div class="mb-4">
                    <label for="building" class="block text-sm font-semibold mb-1">Building</label>
                    <input type="text" name="building" id="building"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter new building name">
                </div>
                <div class="mb-4">
                    <label for="capacity" class="block text-sm font-semibold mb-1">Capacity</label>
                    <input type="number" name="capacity" id="capacity"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter new capacity">
                </div>
                <div class="flex justify-end">
                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-md mr-2"
                        onclick="closeModal()">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Script -->
    <script>
        function openUpdateModal(classroomId, roomNumber, building, capacity) {
            document.getElementById('updateModal').classList.remove('hidden');
            document.getElementById('classroom_id').value = classroomId;
            document.getElementById('room-number').value = roomNumber;
            document.getElementById('building').value = building;
            document.getElementById('capacity').value = capacity;
        }

        function closeModal() {
            document.getElementById('updateModal').classList.add('hidden');
        }
    </script>
@endsection
