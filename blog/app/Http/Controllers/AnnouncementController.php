<?php

namespace App\Http\Controllers;

use App\Announcement;
use App\User;
use DB;
use Session;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
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
         'title' => 'required|min:10|max:100',
         'content' => 'required|min:10|max:200'
       ]);
       $announce = new Announcement;
       $postAnnouncementTitle = $request->title;
       $postcontent = $request->content;
       $postId = $request->course_id;

       $announce->title = $postAnnouncementTitle;
       $announce->content= $postcontent;
       $announce->course_id= $postId;
       $announce->save();
       Session::flash('flash_message', 'Announcement successfully added!');
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
     public function updateAnnounceStatus(Request $request,$id)
     {
       $change = Announcement::where('id',$id)->update(array('status'=>'active'));
       return redirect()->back();
     }
     public function deactivateAnnounce(Request $request,$id)
     {
       $change = Announcement::where('id',$id)->update(array('status'=>'deactivated'));
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
