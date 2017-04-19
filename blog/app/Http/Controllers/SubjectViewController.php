<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Announcement;
use App\Course;
use App\Student;
use App\Exam;
use App\Module;
use App\Result;
use App\Homework;
use App\Seatwork;
use Session;
use Storage;
use File;
use DB;
use Illuminate\Http\Response;
use Auth;

class SubjectViewController extends Controller
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
    public function getindex(){
      return view('SubjectView');
    }
    public function index(Request $request,$course_id)
    {
        $loggedin = Auth::user()->user_no;
        $courses = DB::table('courses')
          ->where('courses.id',$course_id)
          ->leftJoin('subjects','subjects.name','=','courses.subject_name')
          ->get();
        $students =   DB::table('students')
            ->where('students.course_id',$course_id)
            ->leftJoin('users','users.user_no','=','students.student_no')
            ->get();
        $announcements = Announcement::where('course_id',$course_id)->get();//professor
        $activeannounce = Announcement::where([['course_id',$course_id], ['status', '=', 'active']])->get();//student
        $modules = Module::where('course_id',$course_id)->get();//professor
        $activemodule = Module::where([['course_id',$course_id], ['status', '=', 'active']])->get();//student
        $exams = Exam::where('course_id',$course_id)->get();
        $activeexams = Exam::where([['course_id',$course_id], ['status', '=', 'active']]  )->get();
        $studentexams = DB::table('students')
          ->leftJoin('results','results.student_no','=','students.student_no')
          ->where('course_id',$course_id)
          ->get();
        $studresults = DB::table('exams')
          ->where('exams.course_id',$course_id)
          ->leftJoin('results','results.exam_id','=','exams.id')
          ->where('student_no',$loggedin)
          ->get();
        $profresults =  DB::table('results')
          ->leftJoin('users','users.user_no','=','results.student_no')
          ->leftJoin('exams','exams.id','=','results.exam_id')
          ->where('exams.course_id',$course_id)
          ->get();
        $profsubjectshandled = DB::table('courses')
          ->leftJoin('subjects','subjects.name','=','courses.subject_name')
          ->where('professor_no',$loggedin)
          ->get();
        $studsubjectshandled = DB::table('students')
          ->leftJoin('courses', 'courses.id', '=', 'students.course_id')
          ->where('student_no',$loggedin)
          ->get();
        $hwresults = DB::table('homeworks')
          ->where('course_id',$course_id)
          ->select('student_no', DB::raw('group_concat(score SEPARATOR " ") AS `score`,sum(score) as `total`,sum(total) as `totalhw`,(sum(score)/sum(total))*100 as `percentage`'))
          ->groupBy('student_no')
          ->get();
        $hwavg = DB::table('homeworks')
          ->where('course_id',$course_id)
          ->select('homework_no', DB::raw('avg(score) AS `average score per hw`,MAX(total) as `scorehw`'))
          ->groupBy('homework_no')
          ->get();
        $swresults = DB::table('seatworks')
          ->where('course_id',$course_id)
          ->select('student_no', DB::raw('group_concat(score SEPARATOR " ") AS `score`,sum(score) as `total`,sum(total) as `totalhw`,(sum(score)/sum(total))*100 as `percentage`'))
          ->groupBy('student_no')
          ->get();
        $swavg = DB::table('seatworks')
          ->where('course_id',$course_id)
          ->select('seatwork_no', DB::raw('avg(score) AS `average score per hw`,MAX(total) as `scorehw`'))
          ->groupBy('seatwork_no')
          ->get();
        $hwresult = DB::table('homeworks')
          ->where('course_id',$course_id)
          ->select(DB::raw('student_no, avg(score) AS `average`'))
          ->groupBy('student_no')
          ->get();
        return view('SubjectView',compact('announcements','activeannounce','modules','activemodule','courses','students','exams','activeexams','studentexams','studresults','examstatus'
        ,'profresults','profsubjectshandled','studsubjectshandled','hwresults','hwavg','swresults','swavg'));
    }
}
