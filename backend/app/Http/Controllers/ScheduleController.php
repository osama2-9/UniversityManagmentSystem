<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    public function getForm()
    {
        $courses = DB::select('SELECT courses.id, courses.course_name ,courses.course_code FROM courses');
        $professors = DB::select('SELECT professors.id, professors.full_name FROM professors');
        $classrooms = DB::select('SELECT classrooms.id, classrooms.room_number FROM classrooms');
        $departments = DB::table('departments')->get(['id', 'dept_name']);

        return view('admins.createSchedule', [
            'courses' => $courses,
            'professors' => $professors,
            'classrooms' => $classrooms,
            'departments' => $departments,
        ]);
    }
    public function store(Request $req)
    {
        $validated = $req->validate([
            'course_id' => 'required|exists:courses,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'professor_id' => 'required|exists:professors,id',
            'department_id' => 'required|exists:departments,id',
            'day_of_week' => 'required|array',
            'start_time' => 'required',
            'year_of_create' => 'required',
            'end_time' => 'required',
        ]);

        $day = implode(',', $validated['day_of_week']);
        try {
            $newSchedule = DB::insert('INSERT INTO schedules (course_id, classroom_id, professor_id, department_id, day_of_week, year_of_create, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                $validated['course_id'],
                $validated['classroom_id'],
                $validated['professor_id'],
                $validated['department_id'],
                $day,
                $validated['year_of_create'],
                $validated['start_time'],
                $validated['end_time']
            ]);

            if ($newSchedule) {
                return redirect()->back()->with('success', 'New schedule created successfully.');
            }
        } catch (\Exception $e) {
            Log::error('Schedule creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create the schedule. Please try again.');
        }
    }



    public function get()
    {
        $schedules = DB::select('SELECT
    courses.course_name, 
    professors.full_name, 
    classrooms.room_number, 
    schedules.start_time, 
    schedules.end_time, 
    schedules.day_of_week AS days,
    schedules.id AS schedule_id
FROM 
    schedules
JOIN 
    courses ON schedules.course_id = courses.id
JOIN 
    professors ON schedules.professor_id = professors.id
JOIN 
    classrooms ON schedules.classroom_id = classrooms.id;
');
        if (count($schedules) === 0) {
            return view('admins.showSchedule', ['error' => "No data found"]);
        }
        return view('admins.showSchedule', ['schedules' => $schedules]);
    }
}
