<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class StudentExportController extends Controller {

    /*Export Data*/
    public function download(Request $request){
        $student=DB::table('students')->select('course_id','student_no')->get();
        $tot_record_found=0;
        if(count($student)>0){
            $tot_record_found=1;
            //First Methos

            $export_data="course_id,student_no\n";
            //$export= serialize($export_data);

            foreach($student as $value){
                $export_data.=$value->course_id.','.$value->student_no."\n";
            }



            return response($export_data)
                ->header('Content-Type','application/csv')
                ->header('Content-Disposition', 'attachment; filename="Student.csv"')
                ->header('Pragma','no-cache')
                ->header('Expires','0');
        }
        return view('download',['record_found' =>$tot_record_found]);
    }

}
