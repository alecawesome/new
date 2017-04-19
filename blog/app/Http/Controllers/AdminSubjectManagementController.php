<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use App\User;
use Session;
class AdminSubjectManagementController extends Controller
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
        $subjectlist = Subject::all();
        return view('Adminsubjectmanagement',['subjects'=>$subjectlist]);
    }

    public function store(Request $request)
    {
      $this->validate($request, [
      'name' => 'required',
      'description' => 'required'
    ]);
      $subject = new Subject;

      $postName = $request->name;
      $postDescription = $request->description;

      $subject->name = $postName;
      $subject->description = $postDescription;

      $subject->save();
      Session::flash('flash_messsage', 'Subject successfully added!');
      return redirect()->route('adminsubjectmanagement.index');
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

      if (isset($request->name)) {
        $postName = $request->name;
        $subject->name = $postName;
      }
      if (isset($request->description)) {
      $postDescription = $request->description;
      $subject->description = $postDescription;
      }

      $subject->save();

      if (isset($request->editForm)) {
        return redirect()->route('adminsubjectmanagement.index');
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
      return redirect()->route('adminsubjectmanagement.index');
    }
}
