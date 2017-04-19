<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Course;

class DashboardController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loggedinuserno = Auth::user()->user_no;
        $profsubjectshandled = DB::table('courses')
          ->leftJoin('subjects','subjects.name','=','courses.subject_name')
          ->where('professor_no',$loggedinuserno)
          ->get();
        $studsubjectshandled = DB::table('students')
          ->leftJoin('courses', 'courses.id', '=', 'students.course_id')
          ->where('student_no',$loggedinuserno)
          ->get();
        /*$announcements = DB::table('courses')
          ->leftJoin('announcements','announcements.course_id','=','courses.id')
          ->where('professor_no',$loggedinuserno)
          ->get();*/
        return view('Dashboard',compact('profsubjectshandled','studsubjectshandled'));
    }
}
