<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Session;
use DB;

class AdminUserManagementController extends Controller
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
        $userslist = User::all();
        $studno = User::select('user_no')->where('role','=','student')->orderBy('user_no','desc')->first();
        return view('Adminusermanagement',compact('userslist','studno'));
    }

    public function store(Request $request)
    {
      $this->validate($request, [
          'user_no' => 'required',
          'password' => 'required',
          'firstname' => 'required',
          'lastname' => 'required',
          'middlename' => 'required',
          'email' => 'required',
        ]);

      $user = new User;

      $postUserNo = $request->user_no;
      $postPassword = $request->password;
      $postFirstname = $request->firstname;
      $postLastname = $request->lastname;
      $postMiddlename = $request->middlename;
      $postEmail = $request->email;
      $postRole = $request->role;

      $user->user_no = $postUserNo;
      $user->password = bcrypt($postPassword);
      $user->firstname = $postFirstname;
      $user->lastname = $postLastname;
      $user->middlename = $postMiddlename;
      $user->email = $postEmail;
      $user->role = $postRole;

      $user->save();
      Session::flash('flash_messsage', 'User successfully added!');

      return redirect()->route('adminusermanagement.index')->with('message','Your User has been Created!');
    }
    public function deactivateUser(Request $request,$id)
    {
      $change = User::where('id',$id)->update(array('status'=>'deactivated'));
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
      $user = User::find($id);

      if (isset($request->user_no)) {
        $postUserNo = $request->user_no;
        $user->user_no = $postUserNo;
      }
      if (isset($request->password)) {
      $postPassword = $request->password;
      $user->password = $postPassword;
      }

      if (isset($request->firstname)) {
        $postFirstname = $request->firstname;
        $user->firstname = $postFirstname;
      }

      if (isset($request->lastname)) {
          $postLastname = $request->lastname;
          $user->lastname = $postLastname;
       }
       if (isset($request->middlename)) {
           $postMiddlename = $request->middlename;
           $user->middlename = $postMiddlename;
        }
        if (isset($request->email)) {
            $postEmail = $request->email;
            $user->email = $postEmail;
        }
        if (isset($request->role)) {
            $postRole = $request->role;
            $user->role = $postRole;
        }


      $user->save();

      if (isset($request->editForm)) {
        return redirect()->route('adminusermanagement.index');
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
      $user = User::find($id);
      $user->delete();
      return redirect()->route('adminusermanagement.index');
    }
}
