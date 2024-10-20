@extends('layout.studentLayout')

@section('title')
    Course Content
@endsection

@section('content')


    <div class="flex-1 p-12">
        <div class="container mx-auto">

            <div class="bg-white shadow-lg rounded-lg p-8 mb-8">

                <h1 class="text-4xl font-bold text-black mb-6">{{ $course_name }}</h1>
                <h2 class="text-2xl font-bold text-gray-400 mt-1 mb-6">{{ $courseContents[0]->course_code ?? 0 }}</h2>
                <p class="text-lg text-gray-600">{{ $courseContents[0]->course_description ?? "-"}}</p>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-8 mb-8">
                <h2 class="text-2xl font-semibold text-gray-600 mb-6">Available Course Files</h2>
                <ul class="divide-y divide-gray-200 space-y-6">
                    @foreach($courseContents as $content)
                        <li class="flex items-center justify-between py-6 px-4 bg-gray-50 hover:bg-gray-100 transition duration-300 ease-in-out rounded-lg shadow-md">
                            <div>
                                <p class="text-xl font-semibold text-gray-900">{{ $content->cleaned_file_name }}</p>
                                <p class="text-sm text-gray-500">File Type: {{ $content->mime_type }}</p>
                            </div>
                            <a href="{{ asset('storage/' . $content->file_path) }}" download class="bg-blue-600 text-white py-3 px-5 rounded-lg flex items-center gap-2 hover:bg-blue-700 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v4a1 1 0 002 0V5h3v2a1 1 0 002 0V5h3v2a1 1 0 002 0V5h3v3a1 1 0 002 0V4a1 1 0 00-1-1H3zm4 8a1 1 0 011-1h4a1 1 0 011 1v4h2v-4a3 3 0 00-3-3H8a3 3 0 00-3 3v4h2v-4z" clip-rule="evenodd" />
                                </svg>
                                Download
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-8">
                <h2 class="text-2xl font-semibold text-gray-600 mb-6">Quizzes</h2>
                <ul class="space-y-6">
                    <li class="py-6 px-4 bg-gray-50 hover:bg-gray-100 transition duration-300 ease-in-out rounded-lg shadow-md">
                        <div class="flex justify-between">
                            <p class="text-xl font-semibold text-gray-900">Quiz 1</p>
                            <a href="#" class="bg-green-600 text-white py-3 px-5 rounded-lg flex items-center gap-2 hover:bg-green-700 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.7.3L17.7 9H14a1 1 0 01-1-1V5a1 1 0 01-1-1H9a1 1 0 01-1 1v3a1 1 0 01-1 1H2.3L9.7 3.3A1 1 0 0110 3zm0 2a1 1 0 01.7.3L15.7 9H13a1 1 0 01-1-1V5a1 1 0 01-1-1H9a1 1 0 01-1 1v3a1 1 0 01-1 1H2.3L9.7 5.3A1 1 0 0110 5z" clip-rule="evenodd" />
                                </svg>
                                Take Quiz
                            </a>
                        </div>
                    </li>
                    <li class="py-6 px-4 bg-gray-50 hover:bg-gray-100 transition duration-300 ease-in-out rounded-lg shadow-md">
                        <div class="flex justify-between">
                            <p class="text-xl font-semibold text-gray-900">Quiz 2</p>
                            <a href="#" class="bg-green-600 text-white py-3 px-5 rounded-lg flex items-center gap-2 hover:bg-green-700 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.7.3L17.7 9H14a1 1 0 01-1-1V5a1 1 0 01-1-1H9a1 1 0 01-1 1v3a1 1 0 01-1 1H2.3L9.7 3.3A1 1 0 0110 3zm0 2a1 1 0 01.7.3L15.7 9H13a1 1 0 01-1-1V5a1 1 0 01-1-1H9a1 1 0 01-1 1v3a1 1 0 01-1 1H2.3L9.7 5.3A1 1 0 0110 5z" clip-rule="evenodd" />
                                </svg>
                                Take Quiz
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
