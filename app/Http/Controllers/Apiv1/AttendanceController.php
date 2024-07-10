<?php

namespace App\Http\Controllers\Apiv1;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\AttendanceFilename;
use App\Models\Project;
use App\Models\LeaveApply;
use App\OverTime;
use App\Models\AssignProject;
use App\LoginUser;
use App\Models\Employee;
use App\Models\PartTime;


use Validator;
use Log;

class AttendanceController extends Controller {

    public function attendance(Request $request){
        $validator = Validator::make($request->all(),[
            'emp_arr' =>'required',
            'leader'=>'required',
            'site'=>'required',
            'date'=>'required',     
        ]);

        if($validator->fails()){
            $response=[
                'error' =>true,
                'message'=>"Employee ID, Site Name and Date Are Required",
            ];
            return response()->json($response, 200);
        }
       // log::info($request->emp_arr);
        $emp_id_arr=json_encode($request->emp_arr);
        $part_time=json_encode($request->parttime);
        

        $dayoff = json_encode($request->dayOff);

       
        $data=AttendanceFilename::create([
            'leader'=>$request->leader,
            'emp_arr'=>$emp_id_arr,
            'part_time'=> $part_time,
            'dayoff'=>$dayoff,
            'site'=>$request->site,
            'date'=>date_format(date_create($request->date), 'm/d/Y'),
            'time'=>$request->time,
            'lat'=>$request->lat,
            'long'=>$request->long
        ]);

       // log::info($data);
        if(isset($data)){
            $response=[
                'error'=>false,
                'message'=>"Successfully Created"
            ];
            return response()->json($response, 200);
        }
    }
#-----------------------------END ATTENDENCE ------------------------------------------------------------------------------------------#





    
#------------------------------SITE ----------------------------------------------------------------------------------------------------#
    public function createSite(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required',
        ]);

        if($validator->fails()){
            $response=[
                'error'=>true,
                'message'=>"Site Name Is Required"
            ];

            return response()->json($response, 200);
        }

        $data=Project::create([
            'name'=>$request->name,
            'description'=>$request->desc,
            'short_term'=>$request->site_code,
            'client_id'=>$request->client,
        ]);

        if(isset($data)){
            $response=[
                'error'=>false,
                'message'=>"Site Successfully Created"
            ];
            return response()->json($response,200);
        }else{
            $response=[
                'error'=>true,
                "message"=>"Something Wrong Please Try Again"
            ];

            return response()->json($response, 200);
        }
    }

    public function site(Request $request){
        $sites  =Project::get();

        $response=[
            'error'=>false,
            'message'=>"Site List",
            'data'=>$sites
        ];
        return response()->json($response, 200);
    }

    public function editSite(Request $request){

        $validator=Validator::make($request->all(),[
            'id'=>'required',
            'name'=>'required'
        ]);
        if($validator->fails()){
            $response=[
                'error'=>true,
                'message'=>"Site name and site id are required"
            ];
            return response()->json($response, 200);
        }


        $data=Project::findOrFail($request->id);

        $data->update([
            'name'=>$request->name,
            'description'=>$request->desc,
            'short_term'=>$request->site_code,
            'client_id'=>$request->client
        ]);

        $response=[
            'error'=>false,
            'message'=>"Site Successfully Updated"
        ];

        return response()->json($response, 200);
    }

     public function doDelete(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'id'=>'required'
        ]);
        
        if($validator->fails()){
            $response=[
                'error'=>true,
                'message'=>"site id is required"
            ];
            return response()->json($response, 200);
        }

        $project = project::findOrFail($request->id);
        $project->delete();
        AssignProject::where('project_id',$request->id)->delete();
        
        $response=[
            'error'=>'false',
            'message'=>"Site Deleted"
        ];

        return response()->json($response, 200);
        
    }
#----------------------------------END SITE---------------------------------------------------------------------#





#-------------------------------------LEAVE --------------------------------------------------------------------#
    
    public function leave(Request $request){
        $validator = Validator::make($request->all(),[
            'emp_id' =>'required',
            'leader'=>'required',
            'leave_type'=>'required',
            'dateFrom'=>'required',
            'dateTo'=>'required',
            'totalLeave'=>'required'  
        ]);

        if($validator->fails()){
            $response=[
                'error' =>true,
                'message'=>"Fill Emp_id,Leave_type,Date",
            ];
            return response()->json($response, 200);
        }
        
        $datas=AssignProject::get();
        
        foreach($datas as $data){
           
              $led=json_decode($data->leader_id); 
            
            if($led==null){
                $leader=[];
            }else{
                $leader=$led;
            }
           
            if(in_array($request->leader,$leader)){
                $id=$data->project_id;
                $site=Project::where('id',$id)->first();

                break;
            }

        }
      
        $photos=$request->photo;
        
        log::info($photos);

        if(!empty($photos)){
            foreach($photos as $photo){
                $image_name = Str::random(5).'.'."jpg";
                $decodedImage = base64_decode("$photo");
                $return = file_put_contents('public/medicalleave/'.$image_name, $decodedImage);

                //log::info($return);
                $img[]=$image_name;
            }
        }else{
            $img=[];
        }

        $image=json_encode($img);
        
      
        

        $data=LeaveApply::create([
            'leader'=>$request->leader,
            'emp_id' =>$request->emp_id,
            'name'=>$request->name,
            'site_id'=>$site->id,
            'site_name'=>$site->name,
            'leave_type'=>$request->leave_type,
            'dateFrom'=>date_format(date_create($request->dateFrom), 'm/d/Y'),
            'dateTo'=>date_format(date_create($request->dateTo), 'm/d/Y'),
            'total'=>$request->totalLeave,
            'date_claim'=>date_format(date_create($request->date_claim), 'm/d/Y'),
            'content'=>$request->content,
            'other'=>$request->other,
            'photo'=>$image
        ]);

       // log::info($data);

        if(isset($data)){
            $response=[
                'error'=>false,
                'message'=>"Leave Successfully Applied"
            ];
            return response()->json($response, 200);
        }else{
            $response=[
                'error'=>true,
                'message'=>"Something Wrong.Please Try Again"
            ];
            return response()->json($response, 200);
        }
    }
    
#-----------------------------------END LEAVE------------------------------------------------------------------#




#-----------------------------------OVERTIME------------------------------------------------------------------#
    //OverTime
    public function overtime(Request $request){
        $validator = Validator::make($request->all(),[
            'emp_arr'=>'required',
            'otdate'=>'required',
            'fromtime'=>'required',
            'totime'=>'required',
            'leader'=>'required'
        ]);

        if($validator->fails()){
            $response=[
                'error'=>true,
                'message'=>"Fill Required Field"
            ];
            return response()->json($response, 200);
        }
        $emp_id_arr=json_encode($request->emp_arr);

        $data=OverTime::create([
            'leader'=>$request->leader,
            'site_id'=>$request->site_id,
            'emp_arr'=>$emp_id_arr,
            'otdate'=>date_format(date_create($request->otdate), 'm/d/Y'),
            'fromtime'=>$request->fromtime,
            'totime'=>$request->totime,
            'content'=>$request->content,
            'remark'=>$request->remark,
            'completion_report'=>$request->completion_report
        ]);

        if(isset($data)){
            $response=[
                'error'=>false,
                'message'=>"OverTime Successfully Applied"
            ];
            return response()->json($response, 200);
        }else{
            $response=[
                'error'=>true,
                'message'=>"Something Wrong.Please Try Again"
            ];

            return response()->json($response, 200);
        }

    }
#----------------------------------END OVERTIME------------------------------------------------------------#




#----------------------------------ASSIGN------------------------------------------------------------------#

    #----------------------------ASSIGN-------------------------------------->
    //For Assign
    public function assign(Request $request){

        $validator =Validator::make($request->all(),[
            'leader_id'=>'required',
            'project_id'=>'required',
            'emp_arr'=>'required',
            'doa'=>'required',
        ]);

        if($validator->fails()){
            $response=[
                'error'=>true,
                'message'=>"Fill Required Field"
            ];
            return response()->json($response, 200);
        };

        $emp=json_encode($request->emp_arr);

        $leader=json_encode($request->leader_id);



        $data=AssignProject::create([
            'leader_id'=>$leader,
            'project_id'=>$request->project_id,
            'emp_arr'=>$emp,
            'authority_id'=>$request->authority_id,
            'date_of_assignment'=>date_format(date_create($request->doa), 'm/d/Y'),
            'date_of_release'=>date_format(date_create($request->dor), 'm/d/Y'),
        ]);

        if(isset($data)){
            $response=[
                'error'=>false,
                'message'=>"Successfully Assigned"
            ];
            return response()->json($response, 200);
        }else{
            $response=[
                'error'=>true,
                'message'=>"Something Wrong"
            ];
            return response()->json($response, 200);
        }
    }

    public function deleteAssign(Request $request){
        $validator=Validator::make($request->all(),[
            'id'=>'required'
        ]);
        if($validator->fails()){
            $response=[
                'error'=>true,
                'message'=>"Assign id is required"
            ];
            return response()->json($response, 200);
        }

        $project = AssignProject::findOrFail($request->id);
        $project->delete();
        
        $response=[
            'error'=>'false',
            'message'=>"Assign Deleted"
        ];

        return response()->json($response, 200);
    }

    public function editAssign(Request $request){
        $validator=Validator::make($request->all(),[
            'id'=>'required',
            'leader_id'=>'required',
            'project_id'=>'required',
            'emp_arr'=>'required',
            'doa'=>'required',
        ]);
        if($validator->fails()){
            $response=[
                'error'=>true,
                'message'=>"Fill Required Field"
            ];
            return response()->json($response, 200);
        }

        $emp =json_encode($request->emp_arr);
        
        $parttime=json_encode($request->parttime);
        
        $data=AssignProject::findOrFail($request->id);

        $leader=json_encode($request->leader_id);

        $data->update([
            'leader_id'=>$leader,
            'project_id'=>$request->project_id,
            'emp_arr'=>$emp,
            'part_time'=>$parttime,
            'authority_id'=>$request->authority_id,
            'date_of_assignment'=>date_format(date_create($request->doa), 'm/d/Y'),
            'date_of_release'=>date_format(date_create($request->dor), 'm/d/Y'),
        ]);

        $response=[
            'error'=>false,
            'message'=>"Site Successfully Updated"
        ];

        return response()->json($response, 200);
    }
#--------------------------------------------END ASSIGN ---------------------------------------------------------------------


#-------------------------------User Account deleted-------------------------------------------#
    public function deleteAccount(Request $request){
        $validator=Validator::make($request->all(),[
            'user_id'=>'required'
        ]);

        if($validator->fails()){
            $response=[
                'error'=>true,
                'message'=>"User Id required"
            ];
            return response()->json($response, 200);
        }

            LoginUser::destroy($request->user_id);

            $response=[
                'error'=>false,
                'message'=>"User Successfully Deleted"
            ];
            return response()->json($response, 200);
    }
#---------------------------------------DELETE ACCOUNT END-------------------------------------------#


        public function adminOvertime(Request $request){
            $validator = Validator::make($request->all(),[
                'emp_arr'=>'required',
                'otdate'=>'required',
                'fromtime'=>'required',
                'totime'=>'required',
                'leader'=>'required',
                
            ]);

            if($validator->fails()){
                $response=[
                    'error'=>true,
                    'message'=>"Fill Required Field"
                ];
                return response()->json($response, 200);
            }
            $emp_id_arr=json_encode($request->emp_arr);

            $data=OverTime::create([
                'leader'=>$request->leader,
                'site_id'=>$request->site_id,
                'site_name'=>$request->site_name,
                'emp_arr'=>$emp_id_arr,
                'otdate'=>date_format(date_create($request->otdate), 'm/d/Y'),
                'fromtime'=>$request->fromtime,
                'totime'=>$request->totime,
                'content'=>$request->content,
                'remark'=>$request->remark,
                'completion_report'=>$request->completion_report
                
            ]);

            if(isset($data)){
                $response=[
                    'error'=>false,
                    'message'=>"OverTime Successfully Applied"
                ];
                return response()->json($response, 200);
            }else{
                $response=[
                    'error'=>true,
                    'message'=>"Something Wrong.Please Try Again"
                ];

                return response()->json($response, 200);
            }

        }

        public function adminLeave(Request $request){
            $validator = Validator::make($request->all(),[
                'emp_id' =>'required',
                'leave_type'=>'required',
                'dateFrom'=>'required',
                'dateTo'=>'required',
                'totalLeave'=>'required',
                'leader'=>'required' 
            ]);
    
            if($validator->fails()){
                $response=[
                    'error' =>true,
                    'message'=>"Fill Emp_id,Leave_type,Date",
                ];
                return response()->json($response, 200);
            }
    
            //log::info($request->totalLeave);
            //log::info($request->reason);
            $photo=json_encode($request->photo);
    
            $data=LeaveApply::create([
                'leader'=>$request->leader,
                'emp_id' =>$request->emp_id,
                'name'=>$request->name,
                'site_id'=>$request->site_id,
                'site_name'=>$request->site_name,
                'leave_type'=>$request->leave_type,
                'dateFrom'=>date_format(date_create($request->dateFrom), 'm/d/Y'),
                'dateTo'=>date_format(date_create($request->dateTo), 'm/d/Y'),
                'total'=>$request->totalLeave,
                'date_claim'=>date_format(date_create($request->date_claim), 'm/d/Y'),
                'content'=>$request->content,
                'photo'=>$photo
            ]);
    
            log::info($data);
    
            if(isset($data)){
                $response=[
                    'error'=>false,
                    'message'=>"Leave Successfully Applied"
                ];
                return response()->json($response, 200);
            }else{
                $response=[
                    'error'=>true,
                    'message'=>"Something Wrong.Please Try Again"
                ];
                return response()->json($response, 200);
            }
        }
        
        public function employee(){
            $data=Employee::select('id','employee_id','name')->get();
            
            $response=[
                'error'=>false,
                'message'=>'Employee List',
                'data'=>$data
                
            ];
             return response()->json($response, 200);
        }
        
        
        public function parttime(Request $request){
            $validator = Validator::make($request->all(),[
                'name' =>'required',
            ]);
    
            if($validator->fails()){
                $response=[
                    'error' =>true,
                    'message'=>"Name is required",
                ];
                return response()->json($response, 200);
            }
    
            $data=PartTime::create([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'address'=>$request->address,
            ]);
    
            if(isset($data)){
                $response=[
                    'error'=>false,
                    'message'=>"PartTime Worker Successfully Added"
                ];
                return response()->json($response, 200);
            }else{
                $response=[
                    'error'=>true,
                    'message'=>"Something Wrong.Please Try Again"
                ];
                return response()->json($response, 200);
            }
        }

}
