<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CourseExportController extends Controller {

    /*Export Data*/
    public function download(Request $request){
        $course=DB::table('courses')->select('subject_name','section_name','professor_no')->get();
        $tot_record_found=0;
        if(count($course)>0){
            $tot_record_found=1;
            //First Methos

            $export_data="subject_name,section_name,professor_no\n";
            //$export= serialize($export_data);

            foreach($course as $value){
                $export_data.=$value->subject_name.','.$value->section_name.','.$value->professor_no."\n";
            }



            return response($export_data)
                ->header('Content-Type','application/csv')
                ->header('Content-Disposition', 'attachment; filename="Course.csv"')
                ->header('Pragma','no-cache')
                ->header('Expires','0');
        }
        return view('download',['record_found' =>$tot_record_found]);
    }

}
