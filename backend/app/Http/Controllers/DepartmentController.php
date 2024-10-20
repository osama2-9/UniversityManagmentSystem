<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{

    public function getForm()
    {
        return view('admins.createDepartment');
    }

    public function store(Request $req)
    {
        $inputs = $req->all();
        $newDepartment =  DB::insert('INSERT INTO departments (dept_name ,building ,phone ,credit_price) VALUES (? ,? ,? ,?)', [
            $inputs['dept_name'],
            $inputs['building'],
            $inputs['phone'],
            $inputs['credit_price']
        ]);
        if ($newDepartment) {
            return redirect()->route('dept.getForm')->with('success', 'New Department Created Successfully');
        } else {
            return redirect()->route('dept.getForm')->with('error', 'Feild To Create Department');
        }
    }

    public function get()
    {
        $dept = DB::select('SELECT * FROM departments');
        if (count($dept) === 0) {

            return view('admins.showDepartment', ['error' => "No departments found"]);
        } else {
            return view('admins.showDepartment', ['departments' => $dept]);
        }
    }

    public function delete(Request $req)
    {
        $validated = $req->validate([
            'department_id' => 'required|exists:departments,id'
        ]);

        $department = Department::find($validated['department_id']);

        if ($department) {
            $department->delete();

            return redirect()->back()->with('success', 'Department deleted successfully.');
        }

        return redirect()->back()->with('error', 'Department not found.');
    }

    public function update(Request $req)
    {
        $validated = $req->validate([
            'department_id' => "required|exists:departments,id",
            'dept_name' => "required",
            'phone' => "required",
            'building' => "required"
        ]);

        $department = Department::find($validated['department_id']);
        if(!$department){
            return redirect()->back()->with('error' ,'department not found');
        }

        $department->dept_name = $validated['dept_name'];
        $department->phone = $validated['phone'];
        $department->building = $validated['building'];

        if($department->save()){
            return redirect()->back()->with('success' ,'department updated successfully') ;
        }
        return redirect()->back()->with('error', 'error while update department');
    }
}
