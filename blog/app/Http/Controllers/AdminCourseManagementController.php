<?php

namespace App\Http\Controllers;

use App\Subject;
use App\User;
use App\Section;
use App\Course;
use DB;
use Illuminate\Http\Request;

class AdminCourseManagementController extends Controller
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
        $subjects = Subject::all();
        $sections = Section::all();
        $professors = User::where('role','=','professor')->get();
        $courses = Course::all();


        return view('Admincoursemanagement',array('subjects'=>$subjects,'professors'=>$professors,
        'sections'=>$sections,'courses'=>$courses));
    }

    public function store(Request $request)
    {
      $courses = new Course;

      $postSectionName = $request->section_name;
      $postSubjectName = $request->subject_name;
      $postProfNumber = $request->professor_no;


      $courses->section_name = $postSectionName;
      $courses->subject_name= $postSubjectName;
      $courses->professor_no= $postProfNumber;

      $courses->save();

      return redirect()->route('admincoursemanagement.index');
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

      if (isset($request->user_no)) {
        $postUserNo = $request->user_no;
        $subject->user_no = $postUserNo;
      }
      if (isset($request->name)) {
      $postName = $request->name;
      $subject->name = $postName;
      }

      $subject->save();

      if (isset($request->editForm)) {
        return redirect()->route('admincoursemanagement.index');
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
      $subject = Subject::find($id);
      $subject->delete();
      return redirect()->route('admincoursemanagement.index');
    }
}
