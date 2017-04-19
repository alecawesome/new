<?php

namespace App\Http\Controllers;

use App\Exam;
use App\User;
use Session;
use DB;
use Illuminate\Http\Request;

class ExamController extends Controller
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
    }

    public function store(Request $request)
    {
            $this->validate($request, [
            'name' => 'required|min:3|max:30',
            'total_points' => 'required|numeric|min:1|max:100',
            ]);

            $exam = new Exam;
            $postExamName = $request->name;
            $postTotalPoints = $request->total_points;
            $postType = $request->type;
            $postId = $request->course_id;

            $exam->name = $postExamName;
            $exam->total_points= $postTotalPoints;
            $exam->course_id= $postId;
            $exam->type = $postType;

            $exam->save();
            Session::flash('flash_message', 'Exam successfully added!');
            return redirect()->back();
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
      $exam = Exam::find($id);

      if (isset($request->name)) {
      $postName = $request->name;
      $exam->name = $postName;
      }
      if (isset($request->total_points)) {
      $postPoints = $request->total_points;
      $exam->total_points = $postPoints;
      }
      if (isset($request->type)) {
      $postType = $request->type;
      $exam->type = $postType;
      }

      $exam->save();
      Session::flash('flash_message', 'Exam successfully edited!');
      if (isset($request->editForm)) {
        return redirect()->back();
      }
    }
    public function updateExamStatus(Request $request,$id)
    {
      $change = Exam::where('id',$id)->update(array('status'=>'active'));
      return redirect()->back();
    }
    public function deactivateExam(Request $request,$id)
    {
      $change = Exam::where('id',$id)->update(array('status'=>'deactivated'));
      return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
