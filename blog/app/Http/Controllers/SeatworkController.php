<?php

namespace App\Http\Controllers;

use App\Seatwork;
use App\User;
use DB;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class SeatworkController extends Controller
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
         'score' => 'required|min:1|max:100',
       ]);
       $postTotal = $request->total;
       $postId = $request->course_id;
       $postNumber = $request->seatwork_no;
       $score = Input::get(array('score'));
       foreach($score as $key => $value)
       {
       $sw = new Seatwork;
       $sw->student_no = $key;
       $sw->course_id= $postId;
       $sw->seatwork_no = $postNumber;
       $sw->score= $value;
       $sw->total= $postTotal;

       $sw->save();
       }
       Session::flash('flash_message', 'Seatwork Score successfully added!');
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
       $announce = Announcement::find($id);

       if (isset($request->title)) {
       $postTitle = $request->title;
       $announce->title = $postTitle;
       }
       if (isset($request->content)) {
       $postContent = $request->content;
       $announce->content = $postContent;
       }
       $announce ->save();
       Session::flash('flash_message', 'Announcement successfully edited!');
       if (isset($request->editForm)) {
         return redirect()->back();
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

     }
}
