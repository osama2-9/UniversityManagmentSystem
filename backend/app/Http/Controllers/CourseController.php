<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function getForm()
    {
        $professors = DB::select('SELECT * FROM professors');
        $departments = DB::select('SELECT * FROM departments');
        return view('admins.createCourse', ['departments' => $departments, 'professors' => $professors]);
    }

    public function store(Request $req)
    {
        $inputs = $req->all();

        $existingCourse = DB::table('courses')->where('course_code', $inputs['course_code'])->first();
        if ($existingCourse) {
            $professors = DB::table('professors')->get();
            $departments = DB::table('departments')->get();

            return view('admins.createCourse', [
                'error' => 'Course with this course code already exists.',
                'professors' => $professors,
                'departments' => $departments
            ]);
        }


        try {
            DB::insert('INSERT INTO courses (course_name, course_code, professor_id, department_id, credits, course_level ,course_description) VALUES (?, ?, ?, ?, ?, ? ,?)', [
                $inputs['course_name'],
                $inputs['course_code'],
                $inputs['professor_id'],
                $inputs['department_id'],
                $inputs['credits'],
                $inputs['course_level'],
                $inputs['course_description']
            ]);

            $professors = DB::table('professors')->get();
            $departments = DB::table('departments')->get();

            return view('admins.createCourse', [
                'success' => "{$inputs['course_name']} created successfully",
                'professors' => $professors,
                'departments' => $departments
            ]);
        } catch (\Exception $e) {
            $professors = DB::table('professors')->get();
            $departments = DB::table('departments')->get();

            return view('admins.createCourse', [
                'error' => 'Failed to create course. Please try again.',
                'professors' => $professors,
                'departments' => $departments
            ]);
        }
    }



    public function get()
    {
        // Retrieve courses along with professor and department information
        $courses = DB::select('SELECT
        c.id AS course_id,
        c.course_name,
        c.course_code,
        p.full_name AS professor_name,
        d.dept_name AS department_name,
        d.id AS department_id,
        p.id AS professor_id,
        c.credits,
        c.course_level,
        c.isActive
    FROM
        courses AS c
    JOIN
        professors AS p ON c.professor_id = p.id
    JOIN
        departments AS d ON c.department_id = d.id');

        $departments = DB::select('SELECT id, dept_name FROM departments');

        $professors = DB::select('SELECT id, full_name FROM professors');

        if (count($courses) === 0) {
            return view('admins.showCourse', ['error' => "No courses found", 'departments' => $departments, 'professors' => $professors]);
        }

        return view('admins.showCourse', [
            'courses' => $courses,
            'departments' => $departments,
            'professors' => $professors
        ]);
    }

    public function delete(Request $req)
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return redirect()->back()->with('error', 'Can\'t delete course');
        }

        $validated = $req->validate([
            'course_id' => "required|exists:courses,id"
        ]);

        $delete = DB::delete('DELETE FROM courses WHERE id = ?', [
            $validated['course_id']
        ]);

        if (!$delete) {
            return redirect()->back()->with('error', 'Error while deleting the course');
        }

        return redirect()->back()->with('success', 'Course deleted successfully');
    }

    public function updateCourseData(Request $req)
    {
        $validated = $req->validate([
            'course_id' => "required|exists:courses,id",
            "course_name" => "required",
            "course_code" => "required",
            "department_id" => "required",
            "professor_id" => "required",
            'credits' => "required",
            'course_level' => "required",
            "isActive" => "required"
        ]);

        $updateData = DB::update("UPDATE courses
    SET course_name = ?,
        course_code = ?,
        department_id = ?,
        professor_id = ?,
        credits = ?,
        course_level = ?,
        isActive=?

    WHERE id = ?", [
            $validated['course_name'],
            $validated['course_code'],
            $validated['department_id'],
            $validated['professor_id'],
            $validated['credits'],
            $validated['course_level'],
            $validated['isActive'],
            $validated['course_id'],
        ]);


        if (!$updateData) {
            return redirect()->back()->with('error', 'error while update course');
        }
        return redirect()->back()->with('success', 'course updated');
    }
}
