<?php

use App\Helpers\DatabaseHelper;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EnrollmentsController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use App\Models\Admin;
use App\Models\Quiz;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!DatabaseHelper::isDatabaseConnected()) {
        return view('error.NoDatabaseConnection');
    }


    return view('index');
})->name('index');


Route::get('/admin/login', function () {
    return view('admins.adminLogin');
})->name('login');

Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');


Route::middleware(['auth:admin'])->group(function () {




    Route::get('/admin/dashbord', [AdminController::class, 'getDashboard'])->name('admin.dashbord');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::delete('/admin/deleteStudent', [AdminController::class, 'deleteStudent'])->name('admin.deleteStudent');
    Route::put('/admin/updateStudentData', [AdminController::class, 'updateStudentData'])->name('admin.updateStudentData');



    Route::get('/admin/createNewStudent', [AdminController::class, 'getStudentForm'])->name('admin.getCreateStudentForm');
    Route::get('/classroom/create', [ClassroomController::class, 'getForm'])->name('classroom.getForm');
    Route::post('/classroom/create', [ClassroomController::class, 'store'])->name('classroom.store');
    Route::get('/classroom/show', [ClassroomController::class, 'get'])->name('classroom.show');

    Route::get('/admin/getStudents', [AdminController::class, 'getStudents'])->name('admin.getStudents');

    Route::get('/enrollment/create', [EnrollmentsController::class, 'getForm'])->name('enrollment.getForm');
    Route::post('/enrollment/create', [EnrollmentsController::class, 'store'])->name('enrollment.store');
    Route::get('/enrollment/show', [EnrollmentsController::class, 'get',])->name('enrollment.show');
    Route::post('/admin/createStudent', [StudentController::class, 'store'])->name('admin.createStudent');
    Route::post('/admin/updateBalance', [AdminController::class, 'updateStudentBalance'])->name('admin.updateStudentBalance');
    Route::post('/depratment/createDepartment', [DepartmentController::class, 'store'])->name('dept.store');
    Route::get('/department/createDepartment', [DepartmentController::class, 'getForm'])->name('dept.getForm');
    Route::get('/professor/createProfessor', [ProfessorController::class, 'showForm'])->name('admin.getCreateProfessor');
    Route::post('/professor/createProfessor', [ProfessorController::class, 'store'])->name('professors.store');
    Route::delete('/admin/deleteProfessor', [AdminController::class, 'deleteProfessor'])->name('admin.deleteProfessor');
    Route::put('/admin/updateProfessor', [AdminController::class, 'updateProfessorData'])->name('admin.updateProfessor');
    Route::delete('/admin/deleteCourse', [CourseController::class, 'delete'])->name('admin.deleteCourse');
    Route::put('/admin/updateCourse', [CourseController::class, 'updateCourseData'])->name('admin.updateCourse');
    Route::delete('/admin/deleteClassroom', [ClassroomController::class, 'delete'])->name('admin.deleteClassroom');
    Route::put('/admin/updateClassroom', [ClassroomController::class, 'update'])->name('admin.updateClassroom');
    Route::delete('/admin/deleteDepartment', [DepartmentController::class, 'delete'])->name('admin.deleteDepartment');
    Route::put('/admin/updateDepartment', [DepartmentController::class, 'update'])->name('admin.updateDepartment');
    Route::delete('/admin/deleteEnrollment', [EnrollmentsController::class, 'delete'])->name('admin.deleteEnrollment');





    Route::get('/course/createCourse', [CourseController::class, 'getForm'])->name('course.getForm');
    Route::get('/course/showCourses', [CourseController::class, 'get'])->name('course.get');
    Route::post('/course/createCourse', [CourseController::class, 'store'])->name('course.store');
    Route::get('/professor/show', [ProfessorController::class, 'showProfessors'])->name('professors.show');
    Route::get('/depratment/showDepartment', [DepartmentController::class, 'get'])->name('dept.get');


    Route::get('/schedule/create', [ScheduleController::class, 'getForm'])->name('schedule.getForm');
    Route::post('/schedule/createSchedule', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::get('/schedule/createSchedule', [ScheduleController::class, 'get'])->name('schedule.show');
});

Route::post('/professor/login', [ProfessorController::class, 'login'])->name('professor.login');
Route::get('/professor/login', [ProfessorController::class, 'getLoginForm'])->name('professor.getForm');
Route::middleware(['auth:professor'])->group(function () {

    Route::get('/professor/dashboard', [ProfessorController::class, 'dashboard'])->name('professor.dashboard');
    Route::get('/professor/profile', [ProfessorController::class, 'professorProfile'])->name('professor.profile');
    Route::get('/professors/showEnrollments', [ProfessorController::class, 'showStudentEnroll'])->name('professor.studentsEnrollments');
    Route::post('/professor/upload', [FileController::class, 'store'])->name('files.store');
    Route::get('/professor/upload', [FileController::class, 'getForm'])->name('files.getForm');
    Route::get('/professor/grades', [ProfessorController::class, 'getGradesForm'])->name('professor.getGradesForm');
    Route::post('/professor/grade/{studentId}/{courseId}', [ProfessorController::class, 'storeGrade'])->name('professor.storeGrade');
    Route::get('/professor/students', [ProfessorController::class, 'showStudents'])->name('professor.showStudents');
    Route::get('/professor/quiz', [QuizController::class, 'getQuiz'])->name('professor.quiz');
    Route::post('/professor/createQuiz', [QuizController::class, 'store'])->name('quiz.store');
    Route::get('/professor/quizQustions', [QuizController::class, 'getQuizQustions'])->name('quiz.getQustions');
    Route::post('/professor/quizQustions', [QuizController::class, 'storeQustion'])->name('quiz.storeQustion');
    Route::get('/professor/answares', [QuizController::class, 'answares'])->name('quiz.getAnsware');
    Route::post('/professor/storeAnswer', [QuizController::class, 'storeAnsware'])->name('quiz.storeAnswer');
    Route::get('/professor/showQuizzes', [QuizController::class, 'showQuizzes'])->name('quizzes.show');
    Route::delete('/professor/deleteQuiz', [QuizController::class, 'deleteQuiz'])->name('quiz.delete');
    Route::put('/quiz/update', [QuizController::class, 'updateQuiz'])->name('quiz.update');
    Route::post('/quiz/toggle-status', [QuizController::class, 'quizActivation'])->name('quiz.toggleStatus');
    Route::get('/quiz/studentsAttempts', [QuizController::class, 'StudentsAttempts'])->name('quiz.studentsAttempts');
    Route::get('quiz/userAnswers', [QuizController::class, 'getStudentAnswers'])->name('quiz.studentAnswer');
    Route::post('/quiz/attempts/submit', [QuizController::class, 'submitStudentScore'])->name('quiz.scoreSubmit');
});


Route::get('/students/login', [StudentController::class, 'getForm'])->name('student.getForm');
Route::post('/student/login', [StudentController::class, 'login'])->name('student.login');

Route::middleware(['auth:student'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashbord');
    Route::get('/student/dashboard/{course_name}/{course_id}', [StudentController::class, 'getCourseContent'])->name('student.coursecontent');
    Route::get('/student/enrollments', [StudentController::class, 'showEnrollments'])->name('student.enrollment');
    Route::post('/student/enrollments', [StudentController::class, 'makeEnrollment'])->name('student.enroll');
    Route::post('/student/logout', [StudentController::class, 'logout'])->name('student.logout');
    Route::get('/student/profile', [StudentController::class, 'getProfile'])->name('student.profile');
    Route::get('/student/coursrs', [StudentController::class, 'studentCourses'])->name('student.courses');
    Route::post('/student/startQuiz', [QuizController::class, 'startQuiz'])->name('quiz.start');
    Route::get('/quiz/attempt', [QuizController::class, 'getQuizPage'])->name('quiz.page');
    Route::post('/quiz/submit', [QuizController::class, 'submitQuiz'])->name('quiz.submit');
});
