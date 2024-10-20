<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
    public function getForm()
    {
        $professor = Auth::guard('professor')->user();
        $professorCourses = DB::select("SELECT DISTINCT
    courses.course_name,
    courses.id AS course_id,
    professors.id AS professor_id
FROM
    courses
JOIN
    professors
ON
    courses.professor_id = professors.id
WHERE
    courses.professor_id = {$professor->id};
");

        return view('professors.uploadCourseContent', ['courses' => $professorCourses]);
    }

    public function store(Request $req)
    {
        $professor = Auth::guard("professor")->user();

        $validatedData = $req->validate([
            'course_id' => 'required|exists:courses,id',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png',
            'file_name' => 'required',
        ]);

        if ($req->hasFile('file')) {
            $file = $req->file('file');

            $extension = $file->getClientOriginalExtension();

            $fileName = now()->format('YmdHis') . "_" . $validatedData['file_name'] . "." . $extension;

            $filePath = $file->storeAs('courseContent', $fileName, 'public');

            DB::table('course_content')->insert([
                'course_id' => $validatedData['course_id'],
                'file_name' => $fileName,
                'file_type' => $file->getClientMimeType(),
                'file_path' => $filePath,
                'created_at' => now(),
                'updated_at' => now(),
                'professor_id' => $professor->id
            ]);
        }

        return back()->with('success', 'Course content uploaded successfully.');
    }

}


