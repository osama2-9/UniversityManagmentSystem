<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class QuizController extends Controller
{



    public function getQuiz()
    {
        $professor = Auth::guard('professor')->user();

        $courses = DB::table('courses as c')
            ->join('professors as p', 'c.professor_id', '=', 'p.id')
            ->select('c.course_name', 'c.id as course_id')
            ->where('p.id', $professor->id)
            ->get();


        if ($courses->isEmpty()) {
            return view('professors.Quiz', ['courses' => null]);
        }


        return view('professors.Quiz', ['courses' => $courses]);
    }


    public function store(Request $req)
    {
        $professor = Auth::guard('professor')->user();

        $validated = $req->validate([
            'course_id' => "required|exists:courses,id",
            'quiz_title' => "required|string|max:255",
            'quiz_description' => "required|string|max:224",
            'start_time' => "required|date",
            'end_time' => "required|date|after:start_time",
            'total_marks' => "required|numeric|min:1",
            'quiz_duration' => "required|integer",
        ]);

        $start_time = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validated['start_time']);
        $end_time = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validated['end_time']);

        $inserted = DB::insert('INSERT INTO quizzes (course_id, professor_id, quiz_title, quiz_description, start_time, end_time, total_marks, isQuizActive, quiz_duration) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $validated['course_id'],
            $professor->id,
            $validated['quiz_title'],
            $validated['quiz_description'],
            $start_time,
            $end_time,
            $validated['total_marks'],
            $req->has('isQuizActive') ? true : false,
            $validated['quiz_duration'],
        ]);

        if (!$inserted) {
            return redirect()->back()->with('error', 'Error while creating the quiz, please try again later.');
        }

        return redirect()->back()->with('success', 'Quiz created successfully!');
    }


    public function getQuizQustions()
    {
        $professor = Auth::guard('professor')->user();
        $getAvalibleQuizzes = DB::select('SELECT q.quiz_title ,q.id as quiz_id FROM quizzes q JOIN professors p on q.professor_id =p.id WHERE p.id =?', [
            $professor->id
        ]);
        return view('professors.QuizQustions', ['quizzes' => $getAvalibleQuizzes]);
    }



    public function storeQustion(Request $req)
    {
        $validated = $req->validate([
            'quiz_id' => "required|exists:quizzes,id",
            'question_text' => "required|string|max:1000",
            'question_type' => "required|in:multiple_choice,true_false,short_answer",
            'mark' => "required|integer|min:1"
        ]);

        $newQuestion = DB::insert(
            'INSERT INTO questions (quiz_id ,question_text ,question_type,mark) VALUES (? ,? ,?,?)',
            [
                $validated['quiz_id'],
                $validated['question_text'],
                $validated['question_type'],
                $validated['mark']
            ]
        );

        if (!$newQuestion) {
            return redirect()->back()->with('error', 'Error while adding the question, please try again later.');
        }
        return redirect()->back()->with('success', 'Question added successfully!');
    }

    public function answares()
    {
        $questions = DB::select('SELECT q.question_text, q.question_type, q.id, q.quiz_id FROM questions q');
        return view('professors.QuizAnswares', ['questions' => $questions]);
    }




    public function storeAnsware(Request $req)
    {
        $validatedQID = $req->validate([
            'question_id' => "required|exists:questions,id",
        ]);

        $question = DB::table('questions')->where('id', $validatedQID['question_id'])->first();

        if ($question->question_type === 'multiple_choice') {
            $validated = $req->validate([
                'multiple_choice_answers' => 'required|array|min:2',
                'multiple_choice_answers.*' => 'required|string',
                'is_correct' => 'required|array',
            ]);

            foreach ($validated['multiple_choice_answers'] as $key => $text) {
                $is_correct = in_array($key, $validated['is_correct']) ? 1 : 0;
                DB::insert('INSERT INTO answers (question_id, answer_text, is_correct) VALUES (?, ?, ?)', [
                    $validatedQID['question_id'],
                    $text,
                    $is_correct,
                ]);
            }
        } elseif ($question->question_type === 'true_false') {
            $validated = $req->validate([
                'true_false_answer' => 'required|in:true,false',
            ]);

            DB::insert('INSERT INTO answers (question_id, answer_text, is_correct) VALUES (?, ?, ?)', [
                $validatedQID['question_id'],
                $validated['true_false_answer'],
                $validated['true_false_answer'] === 'true' ? 1 : 0,
            ]);
        } elseif ($question->question_type === 'short_answer') {
            $validated = $req->validate([
                'short_answer_text' => 'required|string',
            ]);

            DB::insert('INSERT INTO answers (question_id, answer_text, is_correct) VALUES (?, ?, ?)', [
                $validatedQID['question_id'],
                $validated['short_answer_text'],
                1,
            ]);
        }

        return redirect()->back()->with('success', 'Answer saved successfully!');
    }

    public function startQuiz(Request $req)
    {
        $validated = $req->validate([
            'quiz_id' => "required|exists:quizzes,id"
        ]);

        $student = Auth::guard('student')->user();
        if (!$student) {
            return view('Home');
        }

        $existingAttempt = DB::select('SELECT * FROM quiz_attempts WHERE student_id = ? AND quiz_id = ?', [
            $student->id,
            $validated['quiz_id']
        ]);

        if (!empty($existingAttempt)) {
            return redirect()->back()->with('error', 'You have already started this quiz.');
        }

        $quiz = DB::select('SELECT * FROM quizzes WHERE id = ?', [
            $validated['quiz_id']
        ]);

        if (!empty($quiz)) {
            $quiz = $quiz[0];

            $current_time = now();
            if ($quiz && $quiz->isQuizActive && $current_time->between($quiz->start_time, $quiz->end_time)) {
                $newAttempt = DB::insert('INSERT INTO quiz_attempts (student_id, quiz_id, start_time) VALUES (?, ?, ?)', [
                    $student->id,
                    $validated['quiz_id'],
                    now()
                ]);

                if (!$newAttempt) {
                    return redirect()->back()->with('error', 'Error while starting the quiz.');
                }

                $attemptId = DB::getPdo()->lastInsertId();

                return redirect()->route('quiz.page', ['quiz_id' => $quiz->id, 'attempt_id' => $attemptId, 'std_code' => $student->student_code]);
            } else {
                return redirect()->back()->with('error', 'Quiz is not active or outside the allowed time window.');
            }
        } else {
            return redirect()->back()->with('error', 'Quiz not found.');
        }
    }

    public function getQuizPage(Request $req)
    {
        $student = Auth::guard('student')->user();
        if (!$student) {
            return redirect()->back()->with('error', 'Cannot start quiz');
        }

        $quizId = $req->query('quiz_id');
        $attemptId = $req->query('attempt_id');
        $studentCode = $req->query('std_code');

        $isQuizCompleted = DB::select('SELECT * FROM quiz_attempts WHERE id = ? AND is_completed = 1', [
            $attemptId
        ]);

        if ($isQuizCompleted) {
            return redirect()->route('student.dashbord')->with('error', 'You have already completed this quiz.');
        }

        if (!is_numeric($quizId) || !is_numeric($attemptId)) {
            return redirect()->back()->with('error', 'Invalid quiz or attempt ID');
        }

        if ($student->student_code !== $studentCode) {
            return redirect()->back()->with('error', 'Invalid student code');
        }

        $getQuizData = DB::select('SELECT q.id AS quiz_id, q.quiz_title, q.professor_id, q.total_marks, q.start_time, q.end_time, q.quiz_duration
                           FROM quizzes q WHERE q.id = ?', [$quizId]);
        if (empty($getQuizData)) {
            return redirect()->back()->with('error', 'Cannot access this page');
        }

        $quizData = $getQuizData[0];

        $totalSeconds = $quizData->quiz_duration * 60;
        $endTime = now()->addSeconds($totalSeconds)->toISOString();

        $allowedStudents = DB::select('SELECT s.student_code as allowed_student_code
                               FROM enrollments e
                               JOIN students s ON e.student_id = s.id
                               WHERE e.professor_id = ?', [$quizData->professor_id]);

        $allowedStudentCodes = array_column($allowedStudents, 'allowed_student_code');
        if (!in_array($student->student_code, $allowedStudentCodes)) {
            return redirect()->back()->with('error', 'You are not allowed to take this quiz');
        }

        $questions = DB::select('SELECT qu.id AS question_id, qu.question_text, qu.question_type,
                                a.id AS answer_id, a.answer_text, a.is_correct
                         FROM quizzes q
                         JOIN questions qu ON q.id = qu.quiz_id
                         LEFT JOIN answers a ON qu.id = a.question_id
                         WHERE q.id = ?', [$quizId]);

        $formattedQuestions = [];
        foreach ($questions as $question) {
            if (!isset($formattedQuestions[$question->question_id])) {
                $formattedQuestions[$question->question_id] = [
                    "question_id" => $question->question_id,
                    'question_text' => $question->question_text,
                    'question_type' => $question->question_type,
                    'answers' => []
                ];
            }

            if ($question->answer_text !== null) {
                $formattedQuestions[$question->question_id]['answers'][] = [
                    'id' => $question->answer_id,
                    'answer_text' => $question->answer_text,
                    'is_correct' => $question->is_correct,
                ];
            }
        }

        return view('students.QuizPage', [
            'questions' => array_values($formattedQuestions),
            'quizData' => $quizData,
            'totalSeconds' => $totalSeconds,
            'endTime' => $endTime,
        ]);
    }






    public function submitQuiz(Request $request)
    {
        $studentId = $request->input('student_id');
        $quizId = $request->input('quiz_id');
        $attemptId = $request->input('attempt_id');
        $answers = $request->input('answers');

        if (!$studentId || !$quizId || !$answers || !$attemptId) {
            return redirect()->back()->with('error', 'Missing required data.');
        }

        DB::transaction(function () use ($studentId, $quizId, $attemptId, $answers) {
            foreach ($answers as $questionId => $answerValue) {
                $submittedAnswer = null;
                $answerId = null;

                if (is_numeric($answerValue)) {
                    $answer = DB::select(
                        'SELECT id, answer_text FROM answers WHERE id = ?',
                        [$answerValue]
                    );

                    if ($answer) {
                        $submittedAnswer = $answer[0]->answer_text;
                        $answerId = $answer[0]->id;
                    }
                } else {
                    $submittedAnswer = $answerValue;
                }

                $correctAnswer = DB::select(
                    'SELECT id FROM answers WHERE question_id = ? AND is_correct = 1',
                    [$questionId]
                );

                $correctAnswerId = null;
                if ($correctAnswer) {
                    $correctAnswerId = $correctAnswer[0]->id;
                }

                DB::insert(
                    'INSERT INTO user_answers (student_id, quiz_attempt_id, question_id, submitted_answer, correct_answer_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)',
                    [
                        $studentId,
                        $attemptId,
                        $questionId,
                        $submittedAnswer,
                        $correctAnswerId,
                        now(),
                        now(),
                    ]
                );
            }

            DB::update(
                'UPDATE quiz_attempts SET end_time = ?, is_completed = 1 WHERE id = ?',
                [
                    now(),
                    $attemptId,
                ]
            );
        });

        return redirect()->route('student.dashbord')
            ->with('success', 'Quiz submitted successfully.');
    }


    public function showQuizzes()
    {
        $professor = Auth::guard('professor')->user();

        if (!$professor) {
            return view('Home');
        }

        $quizzes = DB::table('quizzes as q')
            ->join('courses as c', 'q.course_id', '=', 'c.id')
            ->where('q.professor_id', $professor->id)
            ->select('q.id as quiz_id', 'q.quiz_title', 'q.quiz_duration', 'q.quiz_description', 'q.created_at', 'c.course_name as course_title', 'q.start_time', 'q.end_time', 'q.total_marks', "q.isQuizActive")
            ->get();

        return view('professors.ShowQuizzes', ['quizzes' => $quizzes]);
    }

    public function deleteQuiz(Request $req)
    {
        $validated = $req->validate([
            'quiz_id' => "required|exists:quizzes,id"
        ]);
        $professor = Auth::guard('professor')->user();
        if (!$professor) {
            return view('welcome');
        }
        $delete = DB::table('quizzes')->delete($validated['quiz_id']);
        if (!$delete) {
            return redirect()->back()->with('error', "error while delete quiz");
        }
        return redirect()->back()->with('success', 'quiz deleted successfully');
    }
    public function updateQuiz(Request $req)
    {
        $validated = $req->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'quiz_title' => 'required|string|max:255',
            'quiz_description' => 'required|string|max:500',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'total_marks' => 'required|integer',
            "quiz_duration" => "required"
        ]);

        $updateQuiz = DB::table('quizzes')
            ->where('id', $validated['quiz_id'])
            ->update([
                'quiz_title' => $validated['quiz_title'],
                'quiz_description' => $validated['quiz_description'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'total_marks' => $validated['total_marks'],
                'quiz_duration' => $validated['quiz_duration'],
                'updated_at' => now(),
            ]);

        return redirect()->back()->with(
            $updateQuiz ? 'success' : 'error',
            $updateQuiz ? 'Quiz updated successfully' : 'Failed to update quiz'
        );
    }

    public function quizActivation(Request $req)
    {
        $validated = $req->validate([
            'quiz_id' => 'required|exists:quizzes,id',
        ]);

        $quiz = DB::table('quizzes')->where('id', $validated['quiz_id'])->first();

        if (!$quiz) {
            return redirect()->back()->with('error', 'Quiz not found');
        }

        $currentTime = now();
        if (!$currentTime->between($quiz->start_time, $quiz->end_time)) {
            return redirect()->back()->with('error', 'you can\'t active the quiz after the time finish');
        };

        $quizquestions = DB::table('questions')
            ->where('quiz_id', $validated['quiz_id'])
            ->count();

        if ($quizquestions === 0) {
            return redirect()->back()->with('error', 'You must add questions before activating the quiz!');
        }

        $newStatus = !$quiz->isQuizActive;

        DB::table('quizzes')->where('id', $validated['quiz_id'])->update([
            'isQuizActive' => $newStatus,
        ]);

        return redirect()->back()->with('success', 'Quiz status updated successfully');
    }

    public function StudentsAttempts()
    {
        $students = DB::select('
        SELECT s.id as student_id, qa.id as attempt_id,qa.start_time, c.course_name, qa.end_time, s.first_name, s.last_name, s.email,
               qa.score, q.quiz_title, q.total_marks
        FROM quiz_attempts qa
        JOIN students s ON qa.student_id = s.id
        JOIN quizzes q ON qa.quiz_id = q.id
        JOIN courses c ON q.course_id = c.id
    ');

        if (!$students) {
            return redirect()->back()->with('error', 'Cannot get attempts');
        }

        return view('professors.StudentsAttempts', ['studentAttempts' => $students]);
    }
    public function getStudentAnswers(Request $req)
    {
        $validated = $req->validate([
            'student_id' => "required|exists:students,id",
            'attempt_id' => "required|exists:quiz_attempts,id",

        ]);

        $studentId = $validated['student_id'];
        $attemptId = $validated['attempt_id'];

        $answers = DB::select('
        SELECT qa.id as attempt_id, qa.score, qa.start_time, qa.end_time,
               q.question_text, a.answer_text, ua.submitted_answer, q.question_type
        FROM quiz_attempts qa
        JOIN user_answers ua ON qa.id = ua.quiz_attempt_id
        JOIN questions q ON ua.question_id = q.id
        JOIN answers a ON ua.correct_answer_id = a.id
        WHERE qa.student_id = ? AND qa.id = ?
    ', [$studentId, $attemptId]);

        return response()->json($answers);
    }

    public function submitStudentScore(Request $req)
    {
        $validated = $req->validate([
            'attempt_id' => "required|exists:students,id",
            'score' => 'required'
        ]);

        $studentAttempt = DB::table('quiz_attempts as qa')->where('id', $validated['attempt_id'])->update([
            'score' => $validated['score']
        ]);
        if (!$studentAttempt) {
            return redirect()->back()->with('error', 'cant update');
        }
        return redirect()->back()->with('success', 'score updated');
    }
}
