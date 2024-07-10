<?php

namespace App\Http\Controllers\Apiv1;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\AttendanceFilename;
use App\Models\Project;
use App\Models\LeaveApply;
use App\Models\Employee;
use App\Models\AssignProject;
use App\Models\ForceUpdate;
use App\Models\ForceUpdateIos;
use App\Models\PartTime;
use App\OverTime;
use Carbon\Carbon;
use Validator;
use Log;

class ListController extends Controller {
    
    public function listAttendence(Request $request){

         $validator =Validator::make($request->all(),[
            'user_id'=>'required'
        ]);

        if($validator->fails()){
            $response=[
                'error'=>true,
                'message'=>"User id is required"
            ];
            return response()->json($response, 200);
        }
        $attlists=AttendanceFilename::where('leader',$request->user_id)->whereMonth('created_at','=',Carbon::now()->month)->orderby('created_at','DESC')->get();

        $i=0;
        $arr=[];

        foreach($attlists as $attlist){
            $emp_array =json_decode($attlist->emp_arr);

            
            $datas = Employee::whereIn('id',$emp_array)->select('id','employee_id','name')->get(); 
            
            if($datas){
                $emps=$datas;
            }else{
                $emps=[];
            }
               

            $projects=Project::where('id',$attlist->site)->select('name')->first();  
                
            if($projects){
                  $project=$projects->name;
            }else{
                $project='';
            }
            
            $part_time=json_decode($attlist->part_time);
            $part=PartTime::whereIn('id',$part_time)->select('id','name')->get();

            if($part){
                $parttime=$part;
            }else{
                $parttime=[];
            }
            
            
            $dayOff =json_decode($attlist->dayoff);
            $dayoff = Employee::whereIn('id',$dayOff)->select('id','employee_id','name')->get(); 
            
            if($dayoff){
                $off=$dayoff;
            }else{
                $off=[];
            }
            

            $arr[$i]=[
                "id"=> $attlist->id,
                "employee"=>$emps,
                "parttime"=>$parttime,
                "dayoff"=>$off,
                "site"=> $project,
                "date"=> $attlist->date,
                "time"=> $attlist->time,
            ];

            $i++;
        }
       

        $response=[
            'error'=>false,
            'message'=>"Attendance List",
            'data'=>$arr
        ];
        return response()->json($response, 200);
    }

    public function listLeave(Request $request){
        $validator =Validator::make($request->all(),[
            'user_id'=>'required'
        ]);
    
        if($validator->fails()){
            $response=[
                'erroe'=>true,
                'message'=>"User id is required"
            ];
            return response()->json($response, 200);
        }
    
      
        $leavelists=LeaveApply::where('leader',$request->user_id)->orderby('created_at','DESC')->get();
        
    
        $arr=[];
        $i=0;
        foreach($leavelists as $leavelist){
            $emps=Employee::where('id',$leavelist->emp_id)->select('employee_id','name')->first();
            if($emps==null){
                $employee_id=" ";
                $emp_name="";
            }else{
                $employee_id=$emps->employee_id;
                $emp_name=$emps->name;
            }
            
            $site=Project::where('id',$leavelist->site_id)->first();
            
            if($site==null){
                $site_name=" ";
            }else{
                $site_name=$site->name;
            }
            
            //  return gettype($leavelist->total);
         
    
            $arr[$i]=[
                "id"=> $leavelist->id,
                "leader"=>$leavelist->leader,
                "emp_id"=> $employee_id ,
                "employee_id"=>$leavelist->emp_id,
                "name"=>$emp_name,
                "site_id"=>$leavelist->site_id,
                "site_name"=> $site_name,
                "leave_type"=>$leavelist->leave_type,
                "dateFrom"=>$leavelist->dateFrom,
                "dateTo"=>$leavelist->dateTo,
                "total"=>$leavelist->total,
                // "total"=> number_format($leavelist->total, 1),
                "date_claim"=>$leavelist->date_claim,
                "content"=>$leavelist->content,
                "other"=>$leavelist->other,
                "photo"=> "[]",
                "status"=> $leavelist->status,
            ];
            $i++;
        }
        
    
        //log::info($leavelists);
    
        //log::info($arr);
    
        $response=[
            'error'=>false,
            'message'=>"Leave List",
            'data'=>$arr
        ];
        return response()->json($response, 200);
    }

    public function assignList(){

        $assignLists=AssignProject::get();
        

        $arr =[];
        $i=0;
       
        foreach($assignLists as $assignList){
            $emp_array =json_decode($assignList->emp_arr);
           
           
                $datas = Employee::whereIn('id',$emp_array)->select('id','employee_id','name')->get(); 
                
                $leader_id=json_decode($assignList->leader_id);
                
                $leader=Employee::whereIn('id',$leader_id)->select('id','employee_id','name')->get();
                
                if($leader == null){
                    $leaderName = '';
                }else{
                    $leaderName = $leader;
                }
               
                $project=Project::where('id',$assignList->project_id)->select('name')->first();
                
                if($project == null){
                    $siteName = '';
                }else{
                    $siteName = $project->name;
                }

                $authority=Employee::where('id',$assignList->authority_id)->first();
                
                if($authority == null){
                    $authorityName = '';
                }else{
                    $authorityName = $authority->name;
                }
                
                if($assignList->shift==null){
                    $shift=[];
                }else{
                    $shift=json_decode($assignList->shift);
                }
                
                
                $part=json_decode($assignList->part_time);
                
                $parttimes=PartTime::whereIn('id',$part)->select('id','name','phone','address')->get();
                if($parttimes == null){
                    $parttime = '';
                }else{
                    $parttime = $parttimes;
                }

            $arr[$i]=[
                    "id"=>$assignList->id,
                    "leader"=>$leaderName,
                    "project_id"=> $assignList->project_id,
                    "project_name"=>$siteName,
                    "employee"=>$datas,
                    "parttime"=>$parttime,
                    "authority_id"=>$assignList->authority_id,
                    "authority_name"=>$authorityName,
                    "date_of_assignment"=> $assignList->date_of_assignment,
                    "date_of_release"=> '',
                ];

            $i++;
            
        }



        $response=[
            'error'=>false,
            'message'=>"Assign List",
            'data'=>$arr
        ];
        return response()->json($response, 200);
    }
    
    
    public function overtimeList(Request $request){
        $validator =Validator::make($request->all(),[
            'user_id'=>'required'
        ]);

        if($validator->fails()){
            $response=[
                'erroe'=>true,
                'message'=>"User id is required"
            ];
            return response()->json($response, 200);
        }
        $overtimes=OverTime::where('leader',$request->user_id)->whereMonth('created_at','=',Carbon::now()->month)->orderby('created_at','DESC')->get();

      
        $i=0;
        $arr=[];
        foreach ($overtimes as $overtime) {
            $emp_array=json_decode($overtime->emp_arr);

            log::info($emp_array);
            if($emp_array>0){
                $j = 0 ;
                foreach($emp_array as $emp_arr){
                    $id[$j]=$emp_arr;
                    $datas = Employee::whereIn('id',$emp_array)->select('id','employee_id','name')->get(); 
                   // log::info($employee);

                }
                
                $j++;
            }else{
                $emps=[];
            }
            $arr[$i]=[
                "id"=> $overtime->id,
                "employee"=>$datas,
                "otdate"=>$overtime->otdate,
                "fromtime"=> $overtime->fromtime,
                "totime"=>$overtime->totime,
                "content"=>$overtime->content,
                "remark"=>$overtime->remark,
                "completion_report"=>$overtime->completion_report,
               
            ];
        $i++;
        }
        $response=[
            'error'=>false,
            'message'=>"Overtimes List ",
            'data'=>$arr
        ];
        return response()->json($response, 200);
    }
    
    
    ####===========================Force Update==================================================###

    public function forceupdateAndroid(Request $request){
        
        $validator = Validator::make($request->all(),[
           'version' => 'required'
       ]);
       if($validator->fails()){
           $response = [
               'error' =>true,
               'message' =>"Validator Fail!",
               'data' =>[]
           ];
           return response()->json($response,200);
       }
       
       $user_version = $request->version;
       $datas = ForceUpdate::first();
       if($datas){
           $update_version  = $datas->version;
           $flag_version  = $datas->flag;
           if($flag_version == 1){
               if($user_version >= $update_version){
                   $response =[
                       'error' => false,
                       'message' => "Your App is already updated",
                       'data' => [
                               'url'=>'https://play.google.com/store/apps/details?id=com.attendance.cleanpro&pli=1'

                       ]
                   ];

                   return response()->json($response, 200);  
               }else{
                   
                   $response =[
                       'error' => true,
                       'message' => "Your App is need to be update",
                       'data' => [
                               'url'=>'https://play.google.com/store/apps/details?id=com.attendance.cleanpro&pli=1'

                       ]
                   ];

                   return response()->json($response, 200);  
               }
           }else{
               $response =[
                   'error' => true,
                   'message' => "Your App is up to date",
                   'data' => [
                           'url'=>'https://play.google.com/store/apps/details?id=com.attendance.cleanpro&pli=1'

                   ]
               ];

               return response()->json($response, 200); 
           }
           
       }else{
           $response =[
               'error' => true,
               'message' => "No setup data.",
               'data' => [
                    'url'=>'https://play.google.com/store/apps/details?id=com.attendance.cleanpro&pli=1'
               ]
           ];

           return response()->json($response, 200);  
       }
       
   }
   public function forceupdateIos(Request $request){
       
        $validator = Validator::make($request->all(),[
           'version' => 'required'
       ]);
       if($validator->fails()){
           $response = [
               'error' =>true,
               'message' =>"Validator Fail!",
               'data' =>[]
           ];
           return response()->json($response,200);
       }
       
       $user_version = $request->version;
       $datas = ForceUpdateIos::first();
       if($datas){
           $update_version  = $datas->version;
           $flag_version  = $datas->flag;
           if($flag_version == 1){
               if($user_version >= $update_version){
                   $response =[
                       'error' => false,
                       'message' => "Your App is already updated",
                       'data' => [
                               'url'=>'https://apps.apple.com/us/app/cleanpromyanmar/id1665383498'
                       ]
                   ];

                   return response()->json($response, 200);  
               }else{
                   
                   $response =[
                       'error' => true,
                       'message' => "Your App is need to be update",
                       'data' => [
                               'url'=>'https://apps.apple.com/us/app/cleanpromyanmar/id1665383498'

                       ]
                   ];

                   return response()->json($response, 200);  
               }
           }else{
               $response =[
                   'error' => true,
                   'message' => "Your App is up to date",
                   'data' => [
                           'url'=>'https://apps.apple.com/us/app/cleanpromyanmar/id1665383498'

                   ]
               ];

               return response()->json($response, 200); 
           }
           
       }else{
           $response =[
               'error' => true,
               'message' => "No setup data.",
               'data' => [
                           'url'=>'https://apps.apple.com/us/app/cleanpromyanmar/id1665383498'

               ]
           ];

           return response()->json($response, 200);  
       }
       
   }
   
   
 #=============================Get User Profile===========================================================
 
   public function userProfile(Request $request){
        $validator=Validator::make($request->all(),[
            'leader_id'=>'required'
        ]);

        if($validator->fails()){
            $response = [
                'error' => true,
                'message' => 'Validation Error!',
                'data'  =>[]
            ];
            return response()->json($response,200);
        }

       // log::info($request->leader_id);

        $user=Employee::where('id',$request->leader_id)->select('id','name','employee_id','photo')->first();
        
        if($user->photo==null){
            $images='';
        }else{
             $images=asset('public/userimages/'.$user->photo);
        }

       

        if($user){
            $response=[
                'error'=>false,
                'message'=>'User Profile Data!',
                'data'=>[
                    'id'=>$user->id,
                    'employee_id'=>$user->employee_id,
                    'photo'=>$images
                ]
            ];
            return response()->json($response, 200);
        }else{
            $response=[
                'error' => true,
                'message' => 'User Does Not Have!',
                'data'  =>[]
            ];
            return response()->json($response, 200);
        }
   }
   
 #--------------------------------------Save User Image========================================================
   
   public function saveuserImage(Request $request){
        $validator = Validator::make($request->all(),[
            'leader_id' => 'required',
            'image'  => 'required',
        ]);
        if($validator->fails()){
            $response = [
                'error' => true,
                'message' => 'Validation Error!',
                'data'  =>[$validator->errors()]
            ];
            return response()->json($response,200);
        }

       // log::info($request->image);
       
        $user_image = $request->image;

        log::info($user_image);

        $user=Employee::findOrFail($request->leader_id);

        log::info($user);
        if($user){

            // $path = "/userimages";
            // $image_name = Str::random(10).'.'.$user_image->getClientOriginalExtension();
            // $user_image ->move(public_path($path),$image_name);
            
            $image_name = Str::random(10).'.'."jpg";
            $decodedImage = base64_decode("$user_image");
            $return = file_put_contents('public/userimages/'.$image_name, $decodedImage);

            log::info($image_name);

            if($user_image){
                Employee::where('id','=',$request->leader_id)->update([
                    'photo' => $image_name
                ]);
                $user_data = Employee::where('id','=',$request->leader_id)
                            ->select('id','employee_id','name','photo')
                            ->first();
                            
                
                $images=asset('public/userimages/'.$user_data->photo);

               // log::info($images);

                $response = [
                    'error' => false,
                    'message'=>'User Image Update Success!',
                    'data'  =>[
                        'id'=>$user_data->id,
                        'employee_id'=>$user_data->employee_id ,
                        'name'=> $user_data->name,
                        'photo'=>$images
                    ] 
                ];
                return response()->json($response,200);
            }else{
                $response = [
                    'error' => true,
                    'message'=>'User Image Upload Fail!',
                    'data'  => []
                ];
                return response()->json($response,200);
            }


        }else{
            $response = [
                'error' => true,
                'message' => 'Phone Number Does Not Have!',
                'data'  =>[]
            ];
            return response()->json($response,200);
        }
   }
   
   public function assign(Request $request){
        $datas=AssignProject::get();

        $arr=[];
        $i=0;

        foreach($datas as $data){

            $site=Project::where('id',$data->project_id)->select('*')->first();
            
            if($site){
                $site_id=$site->id;
                $site_name=$site->name;
            }else{
                $site_id=0;
                $site_name='';
            }

            // $leader=Employee::where('id',$data->leader_id)->select('*')->first();
            
            // if($leader){
            //     $leader_id=$data->leader_id;
            //     $leader_name=$leader->name;
            // }else{
            //     $leader_id=0;
            //     $leader_name='';
            // }
            
            $leader=json_decode($data->leader_id);
            
            
            $leaderNames=Employee::whereIn('id',$leader)->select('id','employee_id','name')->get();
            
            if($leaderNames){
                $leader_name=$leaderNames;
            }else{
                $leader_name=[];
            }

            $emp_arr=[];

            $emp_arr=json_decode($data->emp_arr);

            $emps=Employee::whereIn('id',$emp_arr)->select('id','employee_id','name')->get();
            
            $part=json_decode($data->part_time);
                
            $parttimes=PartTime::whereIn('id',$part)->select('id','name','phone','address')->get();
            if($parttimes == null){
                $parttime = '';
            }else{
                $parttime = $parttimes;
            }

            $arr[$i]=[
                'id'=>$data->id,
                'leader'=>$leaderNames,
                'site_id'=>$site_id,
                'site_name'=>$site_name,
                'employee'=>$emps,
                'parttime'=>$parttime
                
            ];
            $i++;
        }

        $response=[
            'error'=>false,
            'message'=>"For Admin Assign List",
            'data'=>$arr
        ];
        return response()->json($response, 200);
   }
   
   public function parttimeList(){
    $data=PartTime::select('id','name','phone','address')->get();

    $response=[
        'error'=>false,
        'message'=>"PartTime Worker List",
        'data'=>$data
    ];

    return response()->json($response, 200);
}
    
   
}