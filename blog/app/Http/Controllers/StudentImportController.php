<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Http\Requests;


class StudentImportController extends Controller
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
           foreach($data as $value){

           // Table update
           $coureid=$data['course_id'];
           $studno=$data['student_no'];

           $student=Student::firstOrNew(['course_id'=>$courseid,'student_no'=>$studno]);

           $student->save();
         }
        }



    }
  }
