<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class UserExportController extends Controller {

    /*Export Data*/
    public function download(Request $request){
        $users=DB::table('users')->select('user_no','password','email','firstname','lastname','middlename','role','status')->get();
        $tot_record_found=0;
        if(count($users)>0){
            $tot_record_found=1;
            //First Methos

            $export_data="user_no,password,email,firstname,lastname,middlename,role,status\n";
            //$export= serialize($export_data);

            foreach($users as $value){
                $export_data.=$value->user_no.','.$value->password.','.$value->email.','.$value->firstname.','.$value->lastname.','.$value->middlename.','.$value->role.','.$value->status."\n";
            }



            return response($export_data)
                ->header('Content-Type','application/csv')
                ->header('Content-Disposition', 'attachment; filename="User.csv"')
                ->header('Pragma','no-cache')
                ->header('Expires','0');
        }
        return view('download',['record_found' =>$tot_record_found]);
    }

}
