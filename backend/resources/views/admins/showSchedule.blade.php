@extends('layout.adminLayout')

@section('title')
    Show Schedule
@endsection

@section('content')
<div class="container mx-auto mt-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-md rounded-sm overflow-hidden">
        <div class="bg-blue-600 text-white p-4">
            <h2 class="text-2xl font-semibold text-center">Schedules</h2>
        </div>

        <div class="p-6">
            <form method="GET" action="" class="flex space-x-4 justify-end">
                <input type="text" name="search" placeholder="Search by Course ID" value="{{ request('search') }}"
                    class="border border-gray-300 rounded-lg px-4 py-2 w-full max-w-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-gray-800 text-white">

                    <tr class="text-md font-semibold">
                        <th class="px-6 py-4 border-b-2 border-gray-300 text-center">Course Name</th>
                        <th class="px-6 py-4 border-b-2 border-gray-300 text-center">Professor </th>
                        <th class="px-6 py-4 border-b-2 border-gray-300 text-center">Classroom </th>
                        <th class="px-6 py-4 border-b-2 border-gray-300 text-center">Days</th>
                        <th class="px-6 py-4 border-b-2 border-gray-300 text-center">Start Time</th>
                        <th class="px-6 py-4 border-b-2 border-gray-300 text-center">End Time</th>
                        <th class="px-6 py-4 border-b-2 border-gray-300 text-center">Actions</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($schedules as $schedule)

                    <tr>
                        <td class="px-6 py-4 border-b border-gray-200 text-md text-center">{{$schedule->course_name}}</td>
                        <td class="px-6 py-4 border-b border-gray-200 text-md text-center">{{$schedule->full_name}}</td>
                        <td class="px-6 py-4 border-b border-gray-200 text-md text-center">{{$schedule->room_number}}</td>
                        <td class="px-6 py-4 border-b border-gray-200 text-md text-center">{{$schedule->days}}</td>
                        <td class="px-6 py-4 border-b border-gray-200 text-md text-center">{{$schedule->start_time}}</td>
                        <td class="px-6 py-4 border-b border-gray-200 text-md text-center">{{$schedule->end_time}}</td>
                        <td class="px-6 py-4 border-b border-gray-200 text-center">
                            <div class="flex justify-center space-x-4">
                                <a href="" class="text-blue-500 hover:text-blue-700">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232a3 3 0 014.243 4.243l-9.192 9.192a4 4 0 01-1.414.94l-3.858.772a1 1 0 01-1.212-1.212l.772-3.858a4 4 0 01.94-1.414l9.192-9.192z"></path>
                                    </svg>
                                </a>

                                <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this schedule?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
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
@endsection
