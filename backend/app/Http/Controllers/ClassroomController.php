<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassroomController extends Controller
{
    public function getForm()
    {
        return view('admins.createClassroom');
    }
    public function store(Request $req)
    {
        $valiedated = $req->validate([
            'room_number' => "required|unique:classrooms",
            'building' => "required",
            'capacity' => "required"

        ]);


        $newClassroom = DB::insert('INSERT INTO classrooms (room_number ,building ,capacity) VALUES (? ,? ,?)', [
            $valiedated['room_number'],
            $valiedated['building'],
            $valiedated['capacity'],
        ]);
        if ($newClassroom) {
            return view('admins.createClassroom')->with('success', 'New classroom created successfully');
        } else {
            return view('admins.createClassroom')->with('error', 'Feaild to create classroom');
        }
    }

    public function get()
    {
        $classrooms = DB::select('SELECT * FROM classrooms');
        if (count($classrooms) === 0) {
            return view('admins.showClassrooms')->with('message', 'No classrooms found');
        } else {
            return view('admins.showClassrooms', ['classrooms' => $classrooms]);
        }
    }

    public function delete(Request $req)
    {
        $validated = $req->validate([
            'classroom_id' => "required|exists:classrooms,id"
        ]);
        $delete = DB::delete("DELETE FROM classrooms WHERE id=?", [
            $validated['classroom_id']
        ]);
        if (!$delete) {
            return redirect()->back()->with('error', 'cant delete classroom');
        }
        return redirect()->back()->with('success', 'classroom deleted successfully');
    }
    public function update(Request $req)
    {
        $validated = $req->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'room_number' => 'required',
            'building' => 'required',
            'capacity' => 'required|integer',
        ]);

        $classroom = Classroom::find($validated['classroom_id']);

        if (!$classroom) {
            return redirect()->back()->with('error', 'Classroom not found');
        }

        $classroom->room_number = $validated['room_number'];
        $classroom->building = $validated['building'];
        $classroom->capacity = $validated['capacity'];

        if ($classroom->save()) {
            return redirect()->back()->with('success', 'Classroom updated successfully');
        } else {
            return redirect()->back()->with('error', 'Error while updating classroom');
        }
    }

}
