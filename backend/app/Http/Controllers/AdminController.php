<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Models\Admin;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function getStudentForm()
    {
        $departments = DB::table('departments')->get(['id', 'dept_name']);
        return view('admins.createStudent', ['departments' => $departments]);
    }


    public function getDashboard()
    {
        $admin = Auth::guard('admin')->user();
        $std_number = DB::select('SELECT COUNT(id) AS stdnumber FROM students')[0]->stdnumber;
        $prof_number = DB::select('SELECT COUNT(id) AS profnumber FROM professors')[0]->profnumber;
        $ongoingCourses_number = DB::select('SELECT COUNT(id) AS ocnumber FROM courses WHERE isActive = 1')[0]->ocnumber;
        $enrollments_number = DB::select('SELECT COUNT(id) AS enronumber FROM courses ')[0]->enronumber;

        return view('admins.dashbord', [
            'admin' => $admin,
            'stdNumber' => $std_number,
            'profNumber' => $prof_number,
            'ocnumber' => $ongoingCourses_number,
            'enronumber' => $enrollments_number
        ]);
    }

    public function login(Request $request)
    {
        $inputs = $request->only('email', 'admin_password', 'remember');


        $request->validate([
            'email' => 'required|email',
            'admin_password' => 'required',
        ]);

        $admin = Admin::where('email', $inputs['email'])->first();


        if (!$admin) {
            return back()->withErrors(['error' => "No user found"]);
        }


        if (!Hash::check($inputs['admin_password'], $admin->admin_password)) {
            return back()->withErrors(['error' => "Invalid password"]);
        }

        $remember = $inputs['remember'] ?? false;
        $cookieExpiration = $remember ? 43200 : 60;

        Cookie::queue(Cookie::make('admin_token', env('SECRET'), $cookieExpiration, null, null, true, true, false, 'Strict'));

        Auth::guard('admin')->login($admin, $remember);

        return redirect()->route('admin.dashbord');
    }


    public function logout(Request $req)
    {
        Auth::guard('admin')->logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        Cookie::queue(Cookie::forget('admin_token'));
        return view('Home');
    }


    public function deleteStudent(Request $req)
    {
        $inputs = $req->validate([
            'student_code' => 'required'
        ]);

        $student = Student::where('student_code', $inputs['student_code'])->first();

        if (!$student) {
            return redirect()->back()->with('error', 'No user found');
        }

        $student->delete();

        return redirect()->back()->with('success', "{$student->first_name} {$student->last_name} deleted successfully");
    }

    public function updateStudentData(Request $req)
    {
        $inputs = $req->validate([
            'student_code' => 'required',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20'
        ]);

        $student = Student::where('student_code', $inputs['student_code'])->first();

        if (!$student) {
            return redirect()->back()->with('error', 'No student found');
        }

        $student->first_name = $inputs['first_name'];
        $student->last_name = $inputs['last_name'];
        $student->email = $inputs['email'];
        $student->phone = $inputs['phone'];

        if (!$student->save()) {
            return redirect()->back()->with('error', 'Error while updating student');
        }

        return redirect()->back()->with('success', 'Student data updated successfully');
    }



    public function store(StoreAdminRequest $req)
    {
        $inputs = $req->validated();

        $hashedPassword =  Hash::make($inputs['admin_password']);
        $newAdmin = DB::insert('INSERT INTO admins (full_name ,email ,admin_password) VALUES (? ,?, ?)', [
            $inputs['full_name'],
            $inputs['email'],
            $hashedPassword


        ]);
        if ($newAdmin) {
            return response()->json([
                'message' => "New Admin Created"
            ], 201);
        } else {
            return response()->json([
                'error' => "Feaild to create admin"
            ]);
        }
    }

    public function getStudents(Request $request)
    {


        $query = DB::table('students as s')
            ->join('departments as d', 's.department_id', '=', 'd.id')
            ->select('s.*', 'd.dept_name');


        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('s.student_code', 'LIKE', '%' . $search . '%');
        }


        $students = $query->paginate(10);


        return view('admins.showStudents', [
            'students' => $students,
            'message' => $students->isEmpty() ? 'No students found' : null,
        ]);
    }


    public function updateStudentBalance(Request $req)
    {
        $input = $req->validate([
            'student_code' => "required",
            'balance' => "required"
        ]);
        $updateBalance = DB::table('students')->where('student_code', $input['student_code'])->update(['balance' => $input['balance']]);
        if ($updateBalance) {
            return redirect()->back()->with('success', 'Student balance updated successfully');
        } else {
            return redirect()->back()->with('error', 'error while update balance');
        }
    }

    public function deleteProfessor(Request $req)
    {
        $validated = $req->validate([
            'professor_id' => "required|exists:professors,id"
        ]);

        if (!$validated) {
            return redirect()->back()->with('error', 'No professor found');
        }

        $delete = DB::delete('DELETE FROM professors WHERE id=?', [
            $validated['professor_id']
        ]);
        if (!$delete) {
            return redirect()->back()->with('error', 'Can\'t delete professor');
        }
        return redirect()->back()->with('success', 'professor deleted successfully');
    }



    public function updateProfessorData(Request $req)
    {
        $validated = $req->validate([
            'professor_id' => "required|exists:professors,id",
            'full_name' => "required",
            'office' => "required",
            'professor_address' => "required",
            'department_id' => "required|exists:departments,id"
        ]);
        $updateProfessor = DB::update("UPDATE professors SET full_name=?, office = ?, professor_address = ?, department_id = ? WHERE id = ?", [
            $validated['full_name'],
            $validated['office'],
            $validated['professor_address'],
            $validated['department_id'],
            $validated['professor_id']
        ]);

        if ($updateProfessor) {
            return redirect()->back()->with('success', 'Professor updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update professor');
        }
    }
}
