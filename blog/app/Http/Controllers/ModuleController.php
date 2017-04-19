<?php

namespace App\Http\Controllers;

use App\Module;
use App\User;
use DB;
use Session;
use Storage;
use File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ModuleController extends Controller
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
       $file = $request->filefield;
       $extension = $file->getClientOriginalExtension();
       Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));
       $entry = new Module();
       $postId = $request->course_id;

       $entry->course_id=$postId;
       $entry->mime = $file->getClientMimeType();
       $entry->original_filename = $file->getClientOriginalName();
       $entry->filename = $file->getFilename().'.'.$extension;

       $entry->save();
       Session::flash('flash_message', 'Module successfully added!');
       return redirect()->back();
     }
     public function getModule(Request $request, $filename){

      $entry = Module::where('filename', '=', $filename)->firstOrFail();
      $file = Storage::disk('local')->get($entry->filename);

       return (new Response($file, 200))
               ->header('Content-Type', $entry->mime);
       //return response()->download($file_path);
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

     }
     public function deactivateModule(Request $request,$id)
     {
         $change = Module::where('id',$id)->update(array('status'=>'deactivated'));
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
