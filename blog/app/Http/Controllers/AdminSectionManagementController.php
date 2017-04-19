<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use Session;
class AdminSectionManagementController extends Controller
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
        $sections = Section::all();
        return view('Adminsectionmanagement',['sections'=>$sections]);
    }

    public function store(Request $request)
    {

      $this->validate($request, [
         'name' => 'required',
         'description' => 'required'
       ]);

      $section = new Section;

      $postName = $request->name;
      $postDescription = $request->description;

      $section->name = $postName;
      $section->description= $postDescription;

      Session::flash('flash_messsage', 'Section successfully added!');
      $section->save();

      return redirect()->route('adminsectionmanagement.index');
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
      $section = Section::find($id);

      if (isset($request->name)) {
      $postName = $request->name;
      $section->name = $postName;
      }
      if (isset($request->description)) {
      $postDescription = $request->description;
      $section->description = $postDescription;
      }

      $section->save();

      if (isset($request->editForm)) {
        return redirect()->route('adminsectionmanagement.index');
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
      $section = Section::find($id);
      $section->delete();
      return redirect()->route('adminsectionmanagement.index');
    }


}
