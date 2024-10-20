@extends('layout.adminLayout')

@section('title')
    Create Department
@endsection

@section('content')
    <div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-700">Create Department</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 mb-4 rounded-md">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="bg-red-100 text-red-800 p-4 mb-4 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('dept.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="dept_name" class="block text-sm font-medium text-gray-700">Department Name</label>
                <input type="text" name="dept_name" id="dept_name"
                    class="mt-1 block w-full p-2.5 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    required>
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="tel" name="phone" id="phone"
                    class="mt-1 block w-full p-2.5 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    required>
            </div>

            <div>
                <label for="building" class="block text-sm font-medium text-gray-700">Building</label>
                <input type="text" name="building" id="building"
                    class="mt-1 block w-full p-2.5 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    required>
            </div>

            <div>
                <label for="credit_price" class="block text-sm font-medium text-gray-700">Credit Price</label>
                <input type="text" name="credit_price" id="credit_price"
                    class="mt-1 block w-full p-2.5 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    required>
            </div>


            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create
                </button>
            </div>
        </form>
    </div>
@endsection
