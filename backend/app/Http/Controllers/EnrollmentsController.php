<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentsController extends Controller
{
    public function getForm()
    {
        $students = DB::select('SELECT * FROM students');
        $professors = DB::select('SELECT * FROM professors');
        $courses = DB::select('SELECT * FROM courses');
        return view('admins.createEnrollment', [
            'students' => $students,
            'professors' => $professors,
            'courses' => $courses
        ]);
    }





    public function store(Request $req)
    {

        $validated = $req->validate([
            'student_id' => "required|exists:students,id",
            'course_id' => "required|exists:courses,id",
            'professor_id' => "required|exists:professors,id",
            'semester' => "required",
        ]);

        $newEnrollment = DB::insert('INSERT INTO enrollments (student_id, course_id, professor_id, semester) VALUES (?, ?, ? ,?)', [
            $validated['student_id'],
            $validated['course_id'],
            $validated['professor_id'],
            $validated['semester']
        ]);

        $professors = DB::table('professors')->get();
        $courses = DB::table('courses')->get();
        $students = DB::table('students')->get();

        return view('admins.createEnrollment', [
            'message' => $newEnrollment ? "New enrollment created" : "Failed to create enrollment",
            'students' => $students,
            'professors' => $professors,
            'courses' => $courses
        ]);
    }


    public function get()
    {
        $enrollments = DB::select('
        SELECT
        enrollments.id as enroll_id,
            students.first_name,
            students.last_name,
            students.id AS stdID,
            courses.course_name,
            courses.course_code,
            professors.full_name AS professor_name,
            courses.credits,
            courses.course_level,
            enrollments.created_at,
            enrollments.updated_at
        FROM enrollments
        JOIN students ON enrollments.student_id = students.id
        JOIN professors ON enrollments.professor_id = professors.id
        JOIN courses ON enrollments.course_id = courses.id
    ');

        if (empty($enrollments)) {
            return view('admins.showEnrollments', [
                'error' => "No Enrollments found"
            ]);
        }

        return view('admins.showEnrollments', [
            'enrollments' => $enrollments
        ]);
    }

    public function delete(Request $req)
    {
        $validated = $req->validate([
            'enrollment_id' => "required|exists:enrollments,id"
        ]);

        $delete = DB::delete("DELETE FROM enrollments WHERE id=?", [
            $validated['enrollment_id']
        ]);
        if (!$delete) {
            return redirect()->back()->with('error', 'error while delete');
        }
        return redirect()->back()->with('success', 'enrollment deleted successfully');
    }
}
