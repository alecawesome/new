<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Http\Requests;


class CourseImportController extends Controller
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
           $name=$data['subject_name'];
           $sec=$data['section_name'];
           $prof=$data['professor_no'];

           $course=Course::firstOrNew(['subject_name'=>$name,'section_name'=>$sec,'professor_no'=>$prof]);

           $course->save();
         }
        }



    }
  }
