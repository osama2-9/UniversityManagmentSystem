<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/admin/login', [AdminController::class, 'login']);

Route::middleware(['auth:admin'])->get('/students/getstd/{student_code}', [StudentController::class, 'getstd']);

Route::post('/user/storeNewStudant', [StudentController::class, 'store']);
Route::delete('/user/delete/{stdId}', [StudentController::class, 'delete']);
Route::post('/department/storeNewDepartment', [DepartmentController::class, 'store']);
Route::delete('/department/delete/{depId}', [DepartmentController::class, 'delete']);
Route::post('/professor/storeNewProfessor', [ProfessorController::class, 'store']);
Route::delete('/professor/delete/{profId}', [ProfessorController::class, 'delete']);
Route::post('/course/createNewCourse', [CourseController::class, 'store']);
Route::delete('/course/delete/{cId}', [CourseController::class, 'delete']);
Route::post('/admin/createNewAdmin', [AdminController::class, 'store']);
