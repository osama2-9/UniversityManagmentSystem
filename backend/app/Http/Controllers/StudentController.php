<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{

    public function dashboard()
    {
        $student = Auth::guard('student')->user();


        $courses = DB::table('enrollments as e')
            ->join('courses as c', 'e.course_id', '=', 'c.id')
            ->join('professors as p', 'c.professor_id', '=', 'p.id')
            ->select('c.course_name', 'c.id AS course_id', 'c.course_code', 'p.full_name AS professor_name')
            ->where('e.student_id', $student->id)
            ->paginate(5);

        $availableQuizzes = DB::select('
        SELECT
            q.id AS quiz_id,
            q.quiz_title,
            q.quiz_description,
            q.start_time,
            q.end_time,
            q.total_marks,
            c.course_name,
            c.course_code,
            qa.score AS student_score,
            q.isQuizActive

        FROM quizzes q
        JOIN professors p ON q.professor_id = p.id
        JOIN courses c ON q.course_id = c.id
        LEFT JOIN quiz_attempts qa ON qa.quiz_id = q.id AND qa.student_id = ?
        WHERE qa.student_id IS NULL OR qa.student_id = ? AND  q.isQuizActive=1
    ', [
            $student->id,
            $student->id
        ]);

        $now = now();

        foreach ($availableQuizzes as $quiz) {
            if ($quiz->isQuizActive === 0 || !$now->between($quiz->start_time, $quiz->end_time)) {
                continue;
            }
        }
        return view('students.dashboard', [
            'student' => $student,
            'courses' => $courses,
            'quizzes' => $availableQuizzes
        ]);
    }



    public function getCourseContent(Request $req)
    {
        $course_id = $req->route('course_id');
        $course_name = $req->route('course_name');

        if (empty($course_id)) {
            return view('students.dashboard');
        }


        $courseContents = DB::table('courses as c')
            ->join('course_content as cc', 'c.id', '=', 'cc.course_id')
            ->where('c.id', '=', $course_id)
            ->select('c.course_name', 'c.course_code', 'c.course_description', 'cc.file_name', 'cc.file_path')
            ->get();

        foreach ($courseContents as $courseContent) {
            $fileName = $courseContent->file_name;

            $fileNameParts = explode('_', $fileName);

            $courseContent->cleaned_file_name = isset($fileNameParts[1]) ? $fileNameParts[1] : $fileName;

            $courseContent->mime_type = pathinfo($fileName, PATHINFO_EXTENSION);
        }

        return view('students.Coursecontent', ['courseContents' => $courseContents, 'course_name' => $course_name]);
    }



    public function login(Request $req)
    {
        $inputs = $req->only('student_code', 'student_password', 'remember');


        $validated = $req->validate([
            'student_code' => 'required|string',
            'student_password' => 'required|string',
        ]);

        $student = Student::where('student_code', $validated['student_code'])->first();

        if (!$student) {
            return redirect()->back()->with('error', 'No student found with this ID.');
        }
        if ($validated['student_password'] != $student->student_password) {
            return redirect()->back()->with('error', 'No student found with this ID.');
        }
        $rememberMe = isset($inputs['remember']) ? $inputs['remember'] : false;

        $token = env('SECRET');
        $cookieExpiration = $rememberMe ? 43200 : 60;
        $cookie = Cookie::make('student_auth', $token, $cookieExpiration, null, null, true, true, false, 'Strict');
        Cookie::queue($cookie);

        Auth::guard('student')->login($student, $rememberMe);

        return redirect()->route('student.dashbord');
    }

    public function logout(Request $req)
    {
        Auth::guard('student')->logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return view('Home');
    }

    public function getProfile()
    {
        $student = Auth::guard('student')->user();
        if (!$student) {
            return view('Home');
        }

        $student = DB::table('students as s')
            ->join('departments as d', 's.department_id', '=', 'd.id')
            ->select('s.*', 'd.dept_name as department_name')
            ->where('s.id', '=', $student->id)->first();
        return view('students.Profile', ['student' => $student]);
    }


    public function getForm()
    {
        return view('students.StudentLogin');
    }

    public function getstd(Request $req)
    {
        $stdCode = $req->query('student_code');
        $studens = DB::select('SELECT * FROM students WHERE student_code =?', [$stdCode]);
        if ($studens && count($studens) > 0) {
            return response()->json([
                $studens
            ]);
        } else {
            return response()->json([
                'error' => 'Feild to get students'
            ]);
        }
    }

    public function studentCourses()
    {
        $student = Auth::guard('student')->user();

        if (!$student) {
            return view('Home');
        }


        $studentCourses = DB::select('
        SELECT
            s.first_name,
            s.last_name,
            c.course_name,
            p.full_name AS professor_name,
            e.semester,
            e.created_at AS enrollment_date,
            e.grade
        FROM
            students s
        JOIN
            enrollments e ON s.id = e.student_id
        JOIN
            courses c ON e.course_id = c.id
        JOIN
            professors p ON e.professor_id = p.id
        WHERE
            s.id = ?
    ', [$student->id]);


        if (count($studentCourses) == 0) {
            return view('students.Courses', ['studentCourses' => null]);
        }


        return view('students.Courses', ['studentCourses' => $studentCourses]);
    }




    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students',
            'phone' => 'required|string|max:15',
            'gender' => 'required|string|max:10',
            'department_id' => 'required',
            'date_of_birth' => 'required|date',
            'studant_address' => 'required|string',
        ]);

        $year = date('Y');
        $latestStudent = DB::table('students')->whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        $latestIncrement = $latestStudent ? intval(substr($latestStudent->student_code, -4)) : 0;
        $studentCode = '1' . $year . str_pad($latestIncrement + 1, 4, '0', STR_PAD_LEFT);

        $randomPassword = bin2hex(random_bytes(4));


        $result = DB::insert(
            'INSERT INTO students (first_name, last_name, email, phone, gender, department_id, date_of_birth, studant_address, student_password, student_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $validated['first_name'],
                $validated['last_name'],
                $validated['email'],
                $validated['phone'],
                $validated['gender'],
                $validated['department_id'],
                $validated['date_of_birth'],
                $validated['studant_address'],
                $randomPassword,
                $studentCode
            ]
        );

        if ($result) {
            return redirect()->route('admin.createStudent')->with('success', 'Student created successfully.');
        } else {
            return redirect()->route('admin.createStudent')->with('error', 'Failed to create student.');
        }
    }




    public function showEnrollments()
    {
        $student = Auth::guard('student')->user();

        $courses = DB::select("
        SELECT
            c.id AS course_id,
            c.course_name,
            c.credits,
            c.course_level,
            d.dept_name,
            p.full_name AS professor_name,
            s.start_time,
            s.end_time,
            s.day_of_week
        FROM courses c
        JOIN departments d ON c.department_id = d.id
        JOIN students st ON st.department_id = d.id
        JOIN professors p ON p.id = c.professor_id
        JOIN schedules s ON s.course_id = c.id
        WHERE st.id = ?;
    ", [$student->id]);

        if ($courses) {
            $groupedCourses = [];
            foreach ($courses as $course) {
                if (!isset($groupedCourses[$course->course_id])) {
                    $groupedCourses[$course->course_id] = [
                        'course' => [
                            'id' => $course->course_id,
                            'name' => $course->course_name,
                            'credits' => $course->credits,
                            'level' => $course->course_level,
                            'department' => $course->dept_name,
                            'professor' => $course->professor_name,
                        ],
                        'schedules' => []
                    ];
                }

                $groupedCourses[$course->course_id]['schedules'][] = [
                    'start_time' => $course->start_time,
                    'end_time' => $course->end_time,
                    'day_of_week' => $course->day_of_week,
                ];
            }

            return view('students.showCoursesEnrollment', [
                'availableCourses' => $groupedCourses,
                'student' => $student,
            ]);
        }
    }


    public function makeEnrollment(Request $req)
    {
        $student = Auth::guard('student')->user();
        if (!$student) {
            return view('Home');
        }

        $validated = $req->validate([
            'student_id' => 'required',
            'course_id' => 'required',
            'professor_id' => 'required',
            'student_current_semester' => 'required',
            'days_of_week' => 'required',
            'credits' => 'required|integer'
        ]);

        $checkSameCourseEnrollment = DB::select("
        SELECT *
        FROM enrollments
        WHERE student_id = ? AND course_id = ?
    ", [
            $student->id,
            $validated['course_id']
        ]);

        if ($checkSameCourseEnrollment) {
            return redirect()->back()->with('error', 'You are already enrolled in this course.');
        }

        $departmentPricing = DB::select('
        SELECT DISTINCT credit_price
        FROM departments
        WHERE id = ?
    ', [
            $student->department_id
        ]);

        if ($departmentPricing) {
            $creditPrice = (int) $departmentPricing[0]->credit_price;
            $credits = (int) $validated['credits'];
            $paymentValue = $creditPrice * $credits;

            $balanceAfterPayment = $student->balance - $paymentValue;

            if ($balanceAfterPayment < 0) {
                return redirect()->back()->with('error', 'Insufficient balance to enroll in this course.');
            }

            DB::update("
            UPDATE students
            SET students.balance = ?
            WHERE students.id = ?
        ", [
                $balanceAfterPayment,
                $student->id
            ]);
        } else {
            return redirect()->back()->with('error', 'Department pricing not found.');
        }

        DB::insert("
        INSERT INTO enrollments (student_id, course_id, professor_id, student_current_semester, days_of_week)
        VALUES (?, ?, ?, ?, ?)
    ", [
            $validated['student_id'],
            $validated['course_id'],
            $validated['professor_id'],
            $validated['student_current_semester'],
            $validated['days_of_week']
        ]);

        return redirect()->back()->with('success', 'Enrollment successful!');
    }
}
