<?php

namespace App\Http\Controllers;

use App\Subject;
use App\User;
use App\Section;
use App\Course;
use App\Student;
use DB;
use Illuminate\Http\Request;

class AdminStudentManagementController extends Controller
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
        $courses = Course::all();
        $students = User::where('role','=','student')->get();
        $assigned = Student::all();
        return view('Adminstudentmanagement',array('courses'=>$courses,'students'=>$students,'assigned'=>$assigned));
    }

    public function store(Request $request)
    {
      $student = new Student;

      $postCourseId = $request->course_id;
      $postStudentNumber = $request->student_no;

      $student->course_id = $postCourseId;
      $student->student_no= $postStudentNumber;

      $student->save();

      return redirect()->route('adminstudentmanagement.index');
    }

    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $subject = Subject::find($id);

      if (isset($request->course_id)) {
        $postUserNo = $request->user_no;
        $subject->user_no = $postUserNo;
      }
      if (isset($request->name)) {
      $postName = $request->name;
      $subject->name = $postName;
      }

      $subject->save();

      if (isset($request->editForm)) {
        return redirect()->route('adminstudentmanagement.index');
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $student = Student::find($id);
      $student->delete();
      return redirect()->route('adminstudentmanagement.index');
    }
}
