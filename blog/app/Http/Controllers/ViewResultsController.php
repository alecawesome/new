<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Announcement;
use App\Course;
use App\Student;
use App\Exam;
use App\Module;
use App\Result;
use App\Question;
use Session;
use Storage;
use File;
use DB;
use Auth;

class ViewResultsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboar d.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$exam_id)
    {
      $loggedin = Auth::user()->user_no;
      $profsubjectshandled = DB::table('courses')
        ->leftJoin('subjects','subjects.name','=','courses.subject_name')
        ->where('professor_no',$loggedin)
        ->get();
      $studsubjectshandled = DB::table('students')
        ->leftJoin('courses', 'courses.id', '=', 'students.course_id')
        ->where('student_no',$loggedin)
        ->get();
      $passed = DB::table('results')
        ->where([['exam_id',$exam_id],['rating','=','passed']])
        ->get();
      $failed = DB::table('results')
        ->where([['exam_id',$exam_id],['rating','=','failed']])
        ->get();
      $results = DB::table('results')
        ->where('exam_id',$exam_id)
        ->leftJoin('users', 'users.user_no', '=', 'results.student_no')
        ->get();
      $topresults = DB::table('results')
        ->where('exam_id',$exam_id)
        ->leftJoin('users', 'users.user_no', '=', 'results.student_no')
        ->orderBy('percentage', 'desc')
        ->take(5)
        ->get();
      $bottomresults = DB::table('results')
        ->where('exam_id',$exam_id)
        ->leftJoin('users', 'users.user_no', '=', 'results.student_no')
        ->orderBy('percentage', 'asc')
        ->take(5)
        ->get();
      $questioncount = DB::table('studentans')
        ->where('exam_id',$exam_id)
        ->select(DB::raw('studentans.question_id, sum(if(is_correct = "YES", 1,0)) AS `correct_count`, sum(if(is_correct = "NO", 1,0)) AS `incorrect_count`'))
        ->groupBy('question_id')
        ->get();
      $percentage = DB::table('results')
        ->where('exam_id',$exam_id)
        ->avg('percentage');
      $exams = Exam::where('id',$exam_id)->get();
      $examname = Exam::where('id',$exam_id)->select('name')->get();
      $questions = Question::where('exam_id',$exam_id)->get();
      return view('Viewresults',compact('profsubjectshandled','studsubjectshandled','exams','passed','failed','questions','examname'
                  ,'results','topresults','bottomresults','questioncount','percentage'));
    }
}
