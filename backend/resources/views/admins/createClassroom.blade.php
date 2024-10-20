@extends('layout.adminLayout')

@section('title')
    Create Classroom
@endsection

@section('content')
    <div class="container mx-auto mt-10">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">Create a New Classroom</h2>
        <form action="{{ route('classroom.store') }}" method="POST" class="bg-white p-8 rounded-xl shadow-lg max-w-md mx-auto">
            @csrf

            <!-- Room Number -->
            <div class="mb-6">
                <label for="room_number" class="block text-gray-600 text-sm font-semibold mb-2">Room Number</label>
                <input type="text" id="room_number" name="room_number"
                    class="w-full border-2 border-gray-300 focus:border-blue-500 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring focus:ring-blue-200"
                    placeholder="Enter room number">
            </div>

            <!-- Building -->
            <div class="mb-6">
                <label for="building" class="block text-gray-600 text-sm font-semibold mb-2">Building</label>
                <input type="text" id="building" name="building"
                    class="w-full border-2 border-gray-300 focus:border-blue-500 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring focus:ring-blue-200"
                    placeholder="Enter building name">
            </div>

            <!-- Capacity -->
            <div class="mb-6">
                <label for="capacity" class="block text-gray-600 text-sm font-semibold mb-2">Capacity</label>
                <input type="number" id="capacity" name="capacity"
                    class="w-full border-2 border-gray-300 focus:border-blue-500 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring focus:ring-blue-200"
                    placeholder="Enter capacity">
            </div>

            <!-- Submit Button -->
            <div class="mt-8">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-sm shadow-md transition-all  focus:outline-none focus:ring focus:ring-blue-300">
                    Create Classroom
                </button>
            </div>
        </form>
    </div>
@endsection
