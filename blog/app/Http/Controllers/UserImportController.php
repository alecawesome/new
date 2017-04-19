<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;


class UserImportController extends Controller
{

  public function showForm()
  {
    return view('Adminusermanagement');
  }


  public function store(Request $request)
    {
        //get file
        $upload=$request->file('upload-file');
        $filePath=$upload->getRealPath();
        //open and read
        $file=fopen($filePath, 'r');
        $header= fgetcsv($file);
        // dd($header);
        $escapedHeader=[];
        //validate
        foreach ($header as $key => $value) {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('/[^a-z,_]/', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        //looping through othe columns
        while($columns=fgetcsv($file))
        {
            if($columns[0]=="")
            {
                continue;
            }

           $data= array_combine($escapedHeader, $columns);
           // setting type
           foreach ($data as $key => &$value) {
           $value=($key=="user_no" || $key=="email")?(string)$value: (string)$value;
          }
           // Table update
           $user_no=$data['user_no'];
           $password=$data['password'];
           $email=$data['email'];
           $firstname=$data['firstname'];
           $lastname=$data['lastname'];
           $middlename=$data['middlename'];
           $role=$data['role'];
           $status=$data['status'];

           $user= User::firstOrNew(['user_no'=>$user_no]);
           $user->password=bcrypt($password);
           $user->email=$email;
           $user->firstname=$firstname;
           $user->lastname=$lastname;
           $user->middlename=$middlename;
           $user->role=$role;
           $user->status=$status;

           $user->save();
        }


    }
  }
