@extends('layout.professorLayout')

@section('title')
    Upload Files
@endsection

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8 text-center">Upload Course Content</h2>

        @if (session('success'))
            <div class="bg-green-200 border border-green-400 text-green-800 px-6 py-4 rounded-lg shadow-md mb-6" role="alert">
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-lg rounded-lg p-8 mb-4">
            @csrf

            <div class="mb-6">
                <label for="course_id" class="block text-gray-800 text-lg font-medium mb-2">
                    Select Course
                </label>
                <select id="course_id" name="course_id" class="shadow-sm border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach ($courses as $course)

                    <option value="{{$course->course_id}}">{{$course->course_name}}</option>
                    @endforeach
                </select>
                @error('course_id')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="file_name" class="block text-gray-800 text-lg font-medium mb-2">
                    File Name
                </label>
                <input id="file_name" type="text" name="file_name" class="shadow-sm border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('file_name') }}" required>
                @error('file_name')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>


            <div class="mb-8">
                <label for="file" class="block text-gray-800 text-lg font-medium mb-2">
                    Upload File
                </label>
                <input id="file" type="file" name="file" class="block w-full text-sm text-gray-500 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 p-2">
                @error('file')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-600">Allowed formats: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG</p>
            </div>

            <div class="flex items-center justify-center">
                <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-transform transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Upload
                </button>
            </div>
        </form>
    </div>
@endsection
