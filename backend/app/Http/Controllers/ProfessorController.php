<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfessorRequest;
use App\Models\Professor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfessorController extends Controller
{



    public function getLoginForm()
    {

        return view('professors.ProfessorLogin');
    }


    public function showStudents()
    {
        $professor = Auth::guard('professor')->user();

        $students = DB::table('enrollments as e')
            ->join('students as s', 'e.student_id', '=', 's.id')
            ->join('professors as p', 'e.professor_id', '=', 'p.id')
            ->join('courses as c', 'e.course_id', '=', 'c.id')
            ->where('p.id', $professor->id)
            ->select(
                's.student_code',
                's.first_name',
                's.last_name',
                's.email',
                's.semester',
                's.major',
                's.date_of_birth',
                'c.course_name',
                'c.course_code',
                'c.credits',
                'e.created_at'
            )
            ->orderBy('e.created_at', 'DESC')
            ->paginate(10);

        return view('professors.showStudents', ['students' => $students]);
    }

    public function dashboard()
    {

        $professor = Auth::guard('professor')->user();

        $auth = cookie('professor_token');

        if (!$auth || !$professor) {
            return redirect()->route('professor.getForm');
        }


        $students = DB::select('SELECT DISTINCT s.* ,c.course_name ,c.course_code
FROM students s
JOIN enrollments e ON e.student_id = s.id
JOIN professors p ON p.id = e.professor_id
JOIN courses c ON e.course_id = c.id
WHERE p.id = ?
ORDER BY s.created_at DESC
LIMIT 3

', [$professor->id]);


        $files = DB::table('course_content')->get();
        $studentsGrades = DB::select('SELECT
    s.first_name,
    s.last_name,
    s.email,
    s.student_code,
    c.course_name,
    e.grade
FROM
    enrollments e
JOIN
    students s ON e.student_id = s.id
JOIN
    courses c ON e.course_id = c.id
WHERE
    e.professor_id = ?
 ', [$professor->id]);

        return view('professors.ProfessorDashbord', [
            'professor' => $professor,
            'students' => $students,
            'files' => $files,
            'grades' => $studentsGrades

        ]);
    }


    public function login(Request $req)
    {
        $validated = $req->validate([
            'email' => 'required|email',
            'professor_password' => 'required',
        ]);


        $findProfessor = Professor::where('email', $validated['email'])->first();


        if (empty($findProfessor)) {
            return redirect()->back()->with('error', 'Invalid email or password.');
        }

        if ($findProfessor->professor_password != $validated['professor_password']) {
            return redirect()->back()->with('error', "Invalid Email or passwors");
        }

        try {
            $token = env('SECRET');
            $cookies = Cookie::make('professot_auth', $token, 1440, null, null, true, true, false, 'Strict');
            Cookie::queue($cookies);

            Auth::guard('professor')->login($findProfessor);
            return redirect()->route('professor.dashboard');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Login failed, please try again.');
        }
    }

    public function showForm()
    {
        $dept = DB::select('SELECT * FROM departments');
        return view('admins.createProfessor', ['departments' => $dept]);
    }
    public function showProfessors()
    {
        $data = DB::select('
        SELECT
            p.id AS profId,
            p.full_name,
            p.email,
            p.department_id,
            p.phone,
            p.office,
            p.professor_address,
            d.dept_name,
            d.id as department_id
        FROM
            professors as p
        INNER JOIN
            departments as d
        ON
            p.department_id = d.id;
    ');

        $departments = DB::select('SELECT d.dept_name, d.id as department_id FROM departments as d');

        return view('admins.showProfessors', ['professors' => $data, 'departments' => $departments]);
    }

    public function store(Request $req)
    {
        $validatedData = $req->validate([
            'full_name' => 'required',
            'email' => 'required|unique:professors|email',
            'professor_address' => 'required',
            'office' => 'required|unique:professors',
            'phone' => 'required|unique:professors',
            'department_id' => 'required',
        ]);

        $randomPassword = bin2hex(random_bytes(4));

        try {
            DB::insert(
                'INSERT INTO professors (full_name, email, professor_address, phone, office, department_id, professor_password)
            VALUES (?, ?, ?, ?, ?, ?, ?)',
                [
                    $validatedData['full_name'],
                    $validatedData['email'],
                    $validatedData['professor_address'],
                    $validatedData['phone'],
                    $validatedData['office'],
                    $validatedData['department_id'],
                    $randomPassword
                ]
            );

            return redirect()->route('admin.getCreateProfessor')
                ->with('success', 'New professor created successfully! Password: ' . $randomPassword);
        } catch (\Exception $e) {
            Log::error('Failed to create professor: ' . $e->getMessage());

            return redirect()->route('admin.getCreateProfessor')
                ->with('error', 'Failed to create professor. Please try again.');
        }
    }

    public function showStudentEnroll()
    {
        $professor = Auth::guard('professor')->user();


        if (!$professor) {
            return redirect()->back()->with('error', 'Unauthorized');
        }


        $studentsEnrollment = DB::select("SELECT students.id, students.first_name, students.last_name, students.email, departments.dept_name, courses.course_name, enrollments.created_at AS enrollment_date, enrollments.grade
FROM enrollments
 JOIN students ON enrollments.student_id = students.id
 JOIN courses ON enrollments.course_id = courses.id
 JOIN professors ON enrollments.professor_id = professors.id
 JOIN departments ON students.department_id = departments.id WHERE professors.id = ?", [
            $professor->id
        ]);

        if (!$studentsEnrollment) {
            return view('professors.studentsEnrollment', ['error' => 'No enrollments found']);
        }


        return view('professors.studentsEnrollment', ['studentsEnrollment' => $studentsEnrollment]);
    }


    public function delete($profId)
    {
        $deleteProfessor = DB::delete('DELETE FROM professors WHERE id=?', [
            $profId
        ]);
        if ($deleteProfessor) {
            return response()->json([
                'message' => "Professor deleted"
            ], 200);
        } else {
            return response()->json([
                'error' => "Feild to delete"
            ], 500);
        }
    }

    public function getGradesForm()
    {

        $professor = Auth::guard('professor')->user();
        if (!$professor) {
            return view('Home');
        }

        $enrollments = DB::table('enrollments as e')
            ->join('courses as c', 'e.course_id', '=', 'c.id')
            ->join('professors as p', 'p.id', '=', 'e.professor_id')
            ->join('students as s', 'e.student_id', '=', 's.id')
            ->join('departments as d', 's.department_id', '=', 'd.id')
            ->select(
                'e.student_id',
                's.first_name',
                's.last_name',
                's.email',
                'd.dept_name',
                's.major',
                's.student_code',
                'c.course_name',
                'c.course_code',
                'e.course_id',
                'e.grade'
            )
            ->where('e.professor_id', '=', $professor->id)
            ->get();

        if ($enrollments) {
            return view('professors.addStudentGrades', ['enrollments' => $enrollments]);
        }
    }

    public function storeGrade(Request $request, $studentId, $courseId)
    {
        if (!$studentId || !$courseId) {
            return view('professors.addStudentGrades')->with('noStudentFound', 'No student found');
        }

        if (!Auth::guard('professor')->user()) {
            return view('Home');
        }

        $grade = $request->input('grade');

        $updated = DB::table('enrollments')
            ->where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->update(['grade' => $grade]);

        if ($updated) {
            return to_route('professor.studentsEnrollments')->with('success', 'New grade stored successfully');
        } else {
            return to_route('professor.studentsEnrollments')->with('error', 'Internal Server Error');
        }
    }
    public function professorProfile()
    {
        $professor = Auth::guard('professor')->user();

        if (!$professor) {
            return redirect()->back()->with('error', 'Cannot access this page');
        }

        $data = DB::select('
        SELECT p.full_name, p.email, p.professor_address, p.phone, p.office, d.dept_name, d.building
        FROM professors as p
        JOIN departments as d
        ON d.id = p.department_id
        WHERE p.id = ?', [$professor->id]);

        $courses = DB::select('
        SELECT c.course_name, c.course_code
        FROM courses as c
        JOIN professors as pc
        ON c.professor_id= pc.id
        WHERE c.professor_id = ?', [$professor->id]);

        if (!$data || !$courses) {
            return redirect()->back()->with('error', 'Cannot access this data');
        }

        return view('professors.profile', [
            'professor' => $data[0],
            'courses' => $courses
        ]);
    }
}
