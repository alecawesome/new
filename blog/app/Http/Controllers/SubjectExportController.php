<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SubjectExportController extends Controller {

    /*Export Data*/
    public function download(Request $request){
        $Subject=DB::table('subjects')->select('name','description')->get();
        $tot_record_found=0;
        if(count($Subject)>0){
            $tot_record_found=1;
            //First Methos

            $export_data="name,description\n";
            //$export= serialize($export_data);

            foreach($Subject as $value){
                $export_data.=$value->name.','.$value->description."\n";
            }



            return response($export_data)
                ->header('Content-Type','application/csv')
                ->header('Content-Disposition', 'attachment; filename="Subject.csv"')
                ->header('Pragma','no-cache')
                ->header('Expires','0');
        }
        return view('download',['record_found' =>$tot_record_found]);
    }

}
