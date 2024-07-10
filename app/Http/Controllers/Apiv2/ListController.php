<?php

namespace App\Http\Controllers\Apiv2;

use App\Shift;
use App\OverTime;
use Carbon\Carbon;
use App\Models\Project;
use App\Models\Employee;
use App\Models\PartTime;
use App\Models\LeaveApply;
use App\Models\ForceUpdate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AssignProject;
use App\Models\ForceUpdateIos;
use App\Models\AttendanceFilename;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ListController extends Controller {

#--------------------------------------------------------- ATTENDANCE -------------------------------------------------------------------#

    public function attendanceList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'leader_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => "Leader ID is required."
            ];

            return response()->json($response, 200);
        }

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($start_date && $end_date) {
            $start_date = Carbon::parse($start_date)->format('Y-m-d 00:00:00');
            $end_date = Carbon::parse($end_date)->format('Y-m-d 23:59:59');
        } else {
            $start_date = Carbon::now()->format('Y-m-d 00:00:00');
            $end_date = Carbon::now()->format('Y-m-d 23:59:59');
        }
        
        //start new code
        $leader_id = $request->leader_id;
        $checkLeader = Employee::where('delete_status','0')->where('id', $leader_id)->first();
        
        if ($checkLeader && ($checkLeader->position == 'Leader' || $checkLeader->position == 'Senior Service Associate' || $checkLeader->position == "Supervisor")) {
            $assignProjects = AssignProject::where('delete_status','0')->get()
            ->filter(function ($assignProject) use ($leader_id) {
                return in_array($leader_id, json_decode($assignProject->leader_id));
            })
            ->sortByDesc('created_at')
            ->take(1); // Retrieve only the latest record
            $dataLatest = $assignProjects->first();
            if ($dataLatest) {
                $site_id = $dataLatest->project_id;
                $shift_id = $dataLatest->shift_id;
            } else {
                $site_id = null;
                $shift_id = null;
            }
            // dd($site_id . 'and' . $shift_id);
            
            // $attlists = AttendanceFilename::with(['shift' => function($q) {
            //     $q->where('delete_status', 0)->select('id', 'name', 'site_id', 'full_name', 'start_time', 'end_time')->get();
            // }])->where('leader', $request->leader_id)
            //     ->whereBetween('created_at', [$start_date, $end_date])
            //     ->orderby('created_at', 'DESC')
            //     ->get();
            
            $attlists = AttendanceFilename::with(['shift' => function($q) {
                    $q->where('delete_status', 0)->select('id', 'name', 'site_id', 'full_name', 'start_time', 'end_time')->get();
                }])->whereBetween('created_at', [$start_date, $end_date])
                ->where('site', $site_id)
                ->where('shift_id', $shift_id)
                ->where('delete_status','0')
                ->orderby('created_at', 'DESC')
                ->get();
                // dd($attlists);
        } elseif ($checkLeader && ($checkLeader->position !== 'Leader' || $checkLeader->position !== 'Senior Service Associate')) {
            $attlists = AttendanceFilename::with(['shift' => function($q) {
                    $q->where('delete_status', 0)->select('id', 'name', 'site_id', 'full_name', 'start_time', 'end_time')->get();
                }])->whereBetween('created_at', [$start_date, $end_date])
                // ->where('leader', $request->leader_id)
                ->orderby('created_at', 'DESC')
                ->where('delete_status','0')
                ->get();
        } else {
            $attlists = [];
        }
        //end new code
        $i = 0;
        $arr = [];

        foreach ($attlists as $attlist) {
            $emp_array = json_decode($attlist->emp_arr);

            $datas = Employee::where('delete_status','0')->whereIn('id', $emp_array)->select('id', 'employee_id', 'name')->get(); 
            if ($datas) {
                $emps = $datas;
            } else {
                $emps = [];
            }
            
            $rv_array = json_decode($attlist->rv_arr);

            $rvs = Employee::where('delete_status','0')->whereIn('id', $rv_array)->select('id', 'employee_id', 'name')->get(); 
            if ($rvs) {
                $rv_emps = $rvs;
            } else {
                $rv_emps = [];
            }
               
            $projects = Project::where('delete_status','0')->where('id', $attlist->site)->select('name')->first();  
                
            if ($projects) {
                  $project = $projects->name;
            } else {
                $project = null;
            }
            
            $part_time = json_decode($attlist->part_time);
            $part = PartTime::where('delete_status','0')->whereIn('id', $part_time)->select('id', 'name')->get();

            if ($part) {
                $parttime = $part;
            } else {
                $parttime = [];
            }
            
            
            $dayOff = json_decode($attlist->dayoff);
            $dayoff = Employee::where('delete_status','0')->whereIn('id', $dayOff)->select('id', 'employee_id', 'name')->get(); 
            
            if ($dayoff) {
                $off = $dayoff;
            } else {
                $off = [];
            }
            
            $arr[$i] = [
                "id" => $attlist->id,
                "leader" => $attlist->leader,
                "employee" => $emps,
                "parttime" => $parttime,
                "rv" => $rv_emps,
                "dayoff" => $off,
                "lat" => $attlist->lat,
                "long" => $attlist->long,
                "site_id" => $attlist->site,
                "site" => $project,
                "shift_id" => $attlist->shift_id,
                "shift" => $attlist->shift,
                "date" => Carbon::parse($attlist->date)->format('Y-m-d'),
                "time" => $attlist->time,
                "status" => $attlist->status
                // "created_at"=>Carbon::parse($attlist->created_at)->format('Y-m-d'),
            ];

            $i++;
        }

        $response = [
            'error' => false,
            'message' => "Attendance List",
            'data' => $arr
        ];
        return response()->json($response, 200);
    }

#--------------------------------------------------------- END ATTENDANCE ---------------------------------------------------------------#




#--------------------------------------------------------- LEAVE ------------------------------------------------------------------------#

    public function leaveListForOne(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            $response = [
                'erroe' => true,
                'message' => "User ID is required."
            ];

            return response()->json($response, 200);
        }
      
        // date filter
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($start_date && $end_date) {
            $start_date = Carbon::parse($start_date)->format('Y-m-d 00:00:00');
            $end_date = Carbon::parse($end_date)->format('Y-m-d 23:59:59');
        } else {
            $start_date = Carbon::now()->format('Y-m-d 00:00:00');
            $end_date = Carbon::now()->format('Y-m-d 23:59:59');
        }

        // new code
        //start new code
        $leader_id = $request->user_id;
        $checkLeader = Employee::where('delete_status','0')->where('id', $leader_id)->first();
        
        if ($checkLeader && ($checkLeader->position == 'Leader' || $checkLeader->position == 'Senior Service Associate' || $checkLeader->position == "Supervisor")) {
            $assignProjects = AssignProject::where('delete_status','0')->get()
            ->filter(function ($assignProject) use ($leader_id) {
                return in_array($leader_id, json_decode($assignProject->leader_id));
            })
            ->sortByDesc('created_at')
            ->take(1); // Retrieve only the latest record
            $dataLatest = $assignProjects->first();
            if ($dataLatest) {
                $site_id = $dataLatest->project_id;
                $shift_id = $dataLatest->shift_id;
            } else {
                $site_id = null;
                $shift_id = null;
            }
            
            $leaveLists1 = LeaveApply::with(['shift' => function($q) {
                $q->where('delete_status', 0)->select('id', 'name', 'site_id', 'full_name', 'start_time', 'end_time')->get();
            }])
                ->where('site_id', $site_id)
                ->where('shift_id', $shift_id)
                ->whereBetween("dateFrom", [$start_date, $end_date])
                ->where('delete_status','0')
                ->orderby('created_at', 'DESC')
                ->get();
                
            $leaveLists2 = LeaveApply::with(['shift' => function($q) {
                $q->where('delete_status', 0)->select('id', 'name', 'site_id', 'full_name', 'start_time', 'end_time')->get();
            }])
                ->where('site_id', $site_id)
                ->where('shift_id', $shift_id)
                ->whereBetween("dateTo", [$start_date, $end_date])
                ->where('delete_status','0')
                ->orderby('created_at', 'DESC')
                ->get();
                
            $leaveLists = $leaveLists1->merge($leaveLists2);
        } elseif ($checkLeader && ($checkLeader->position !== 'Leader' || $checkLeader->position !== 'Senior Service Associate')) {
            $leaveLists1 = LeaveApply::with(['shift' => function($q) {
                $q->where('delete_status', 0)->select('id', 'name', 'site_id', 'full_name', 'start_time', 'end_time')->get();
            }])
                ->whereBetween("dateFrom", [$start_date, $end_date])
                ->orderby('created_at', 'DESC')
                ->where('delete_status','0')
                ->get();
                
            $leaveLists2 = LeaveApply::with(['shift' => function($q) {
                $q->where('delete_status', 0)->select('id', 'name', 'site_id', 'full_name', 'start_time', 'end_time')->get();
            }])
                ->whereBetween("dateTo", [$start_date, $end_date])
                ->orderby('created_at', 'DESC')
                ->where('delete_status','0')
                ->get();
                
            $leaveLists = $leaveLists1->merge($leaveLists2);
        } else {
            $leaveLists = [];
        }

        $arr = [];
        $i = 0;

        foreach($leaveLists as $leaveList) {

            $emps = Employee::where('delete_status','0')->where('id', $leaveList->emp_id)->select('employee_id', 'name')->first();
            if ($emps == null) {
                $employee_id = "";
                $emp_name = "";
            } else {
                $employee_id = $emps->employee_id;
                $emp_name = $emps->name;
            }
            
            $site = Project::where('delete_status','0')->where('id', $leaveList->site_id)->first();
            
            if ($site == null) {
                $site_name = "";
            } else {
                $site_name = $site->name;
            }
            
            $photoArr = json_decode($leaveList->photo);
            if (is_array($photoArr) && count($photoArr) > 0) {
                $photos = [];
                foreach ($photoArr as $filename) {
                    $photoPath = "/public/medicalleave/" . $filename;
                    $photoPath = str_replace('\\', '', $photoPath); 
                    $photoPath = str_replace('"', '', $photoPath); 
                    $photos[] = $photoPath;
                }
                $photo = $photos;
            } else {
                $photo = [];
            }
         
            $arr[$i] = [
                "id" => $leaveList->id,
                "leader" => $leaveList->leader,
                "emp_id" =>  $employee_id ,
                "employee_id" => $leaveList->emp_id,
                "name" => $emp_name,
                "site_id" => $leaveList->site_id,
                "site_name" =>  $site_name,
                'shift_id' => $leaveList->shift_id,
                "shift" => $leaveList->shift,
                "leave_type" => $leaveList->leave_type,
                "dateFrom" => Carbon::parse($leaveList->dateFrom)->format('Y-m-d'),
                "dateTo" => Carbon::parse($leaveList->dateTo)->format('Y-m-d'),
                "total" => $leaveList->total,
                "date_claim" => $leaveList->date_claim,
                "content" => $leaveList->content,
                "other" => $leaveList->other,
                "photos" => $photo,
                "status" => $leaveList->status,
            ];

            $i++;
        }
    
        $response = [
            'error' => false,
            'message' => "Leave List of Requested ID",
            'data' => $arr
        ];

        return response()->json($response, 200);

    }

#--------------------------------------------------------- END LEAVE --------------------------------------------------------------------#




#--------------------------------------------------------- ASSIGN -----------------------------------------------------------------------#

    public function assignList()
    {
        $assignLists = AssignProject::where('delete_status','0')->get();
        
        $arr = [];
        $i = 0;
       
        foreach ($assignLists as $assignList) {

            $emp_array = json_decode($assignList->emp_arr);

            $datas = Employee::where('delete_status','0')->whereIn('id', $emp_array)->select('id', 'employee_id', 'name')->get(); 
            
            $leader_id = json_decode($assignList->leader_id);
            $leader = Employee::where('delete_status','0')->whereIn('id', $leader_id)->select('id', 'employee_id', 'name')->get();
            if ($leader == null) {
                $leaderName = '';
            } else {
                $leaderName = $leader;
            }
            
            $project = Project::where('delete_status','0')->where('id', $assignList->project_id)->select('name')->first();
            if ($project == null) {
                $siteName = '';
            } else {
                $siteName = $project->name;
            }

            $authority = Employee::where('delete_status','0')->where('id', $assignList->authority_id)->first();
            if ($authority == null) {
                $authorityName = '';
            } else {
                $authorityName = $authority->name;
            }  
            
            $shift = Shift::where('delete_status','0')->where('id', $assignList->shift_id)->select('id', 'name', 'site_id', 'full_name', 'start_time', 'end_time')->first();
                
            $part = json_decode($assignList->part_time);
            $parttimes = PartTime::where('delete_status','0')->whereIn('id', $part)->select('id', 'name', 'phone', 'address')->get();
            if ($parttimes == null) {
                $parttime = '';
            } else {
                $parttime = $parttimes;
            }

            $rv_id = json_decode($assignList->rv_arr);
            $rv = Employee::where('delete_status','0')->whereIn('id', $rv_id)->select('id', 'employee_id', 'name')->get();
            if ($rv == null) {
                $rvName = '';
            } else {
                $rvName = $rv;
            }

            $arr[$i] = [
                    "id" => $assignList->id,
                    "leader" => $leaderName,
                    "project_id" =>  $assignList->project_id,
                    "project_name" => $siteName,
                    "shift" => $shift,
                    "employee" => $datas,
                    "rv" => $rvName,
                    "parttime" => $parttime,
                    "authority_id" => $assignList->authority_id,
                    "authority_name" => $authorityName,
                    "date_of_assignment" =>  $assignList->date_of_assignment,
                    "date_of_release" =>  $assignList->date_of_assignment,
            ];

            $i++;
        }

        $response = [
            'error' => false,
            'message' => "All Assigns List",
            'data' => $arr
        ];

        return response()->json($response, 200);
        
    }

#--------------------------------------------------------- END ASSIGN -------------------------------------------------------------------#




#--------------------------------------------------------- OVERTIME ---------------------------------------------------------------------#

    public function overtimeList(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => "User ID is required."
            ];

            return response()->json($response, 200);
        }

        // date filter
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($start_date && $end_date) {
            $start_date = Carbon::parse($start_date)->format('Y-m-d 00:00:00');
            $end_date = Carbon::parse($end_date)->format('Y-m-d 23:59:59');
        } else {
            $start_date = Carbon::now()->format('Y-m-d 00:00:00');
            $end_date = Carbon::now()->format('Y-m-d 23:59:59');
        }
        
        // new code
        //start new code
        $leader_id = $request->user_id;
        
        // check leader
        $checkLeader = Employee::where('delete_status','0')->where('id', $leader_id)->first();
        // return response()->json($checkLeader);
        
        if ($checkLeader && ($checkLeader->position == 'Leader' || $checkLeader->position == 'Senior Service Associate' || $checkLeader->position == "Supervisor")) {
            
            $assignProjects = AssignProject::where('delete_status','0')->get()
                ->filter(function ($assignProject) use ($leader_id) {
                    return in_array($leader_id, json_decode($assignProject->leader_id));
                })
                ->sortByDesc('created_at')
                ->take(1); // Retrieve only the latest record
                // dd($assignProjects);
                $dataLatest = $assignProjects->first();
                if ($dataLatest) {
                    $site_id = $dataLatest->project_id;
                    $shift_id = $dataLatest->shift_id;
                } else {
                    $site_id = null;
                    $shift_id = null;
                }
                // return response()->json($site_id);
                $overtimes = OverTime::with(['shift' => function($q) {
                    $q->where('delete_status', 0)->select('id', 'name', 'site_id', 'full_name', 'start_time', 'end_time')->get();
                }])
                // ->where('leader', $request->user_id)
                    ->where('site_id',$site_id)
                    ->where('shift_id', $shift_id)
                    ->whereBetween("otdate", [$start_date, $end_date])
                    ->orderby('created_at', 'DESC')
                    ->where('delete_status','0')
                    ->get();
        } elseif ($checkLeader && ($checkLeader->position !== 'Leader' || $checkLeader->position !== 'Senior Service Associate')) {
        
            $overtimes = OverTime::with(['shift' => function($q) {
                    $q->where('delete_status', 0)->select('id', 'name', 'site_id', 'full_name', 'start_time', 'end_time')->get();
                }])
                    ->whereBetween("otdate", [$start_date, $end_date])
                    ->orderby('created_at', 'DESC')
                    ->where('delete_status','0')
                    ->get();
            
        } else {
            $overtimes = [];
        } 

        $i = 0;
        $arr = [];

        foreach ($overtimes as $overtime) {
            $emp_array = json_decode($overtime->emp_arr);

            if ($emp_array > 0) {
                $j = 0 ;
                foreach ($emp_array as $emp_arr) {
                    $id[$j] = $emp_arr;
                    $datas = Employee::where('delete_status','0')->whereIn('id', $emp_array)->select('id', 'employee_id', 'name')->get(); 
                }
                
                $j++;

            } else {
                $emp_array = [];
            }
            
            $statusText = "";
            if ($overtime->status == 0) {
                $statusText = "Pending";
            } elseif ($overtime->status == 1) {
                $statusText = "Confirmed";
            } else {
                $statusText = "Approved";
            }

            $arr[$i] = [
                "id" => $overtime->id,
                "leader" => $overtime->leader,
                "site_id" => $overtime->site_id,
                "site_name" => $overtime->site_name,
                "shift_id" => $overtime->shift_id,
                "shift" => $overtime->shift,
                "employee" => $datas,
                "otdate" => Carbon::parse($overtime->otdate)->format('Y-m-d'),
                "fromtime" =>  $overtime->fromtime,
                "totime" => $overtime->totime,
                "content" => $overtime->content,
                "remark" => $overtime->remark,
                "completion_report" => $overtime->completion_report,
                "status" => $statusText
            ];

            $i++;
        }

        $response = [
            'error' => false,
            'message' => "All Overtimes List ",
            'data' => $arr
        ];

        return response()->json($response, 200);

    }

#--------------------------------------------------------- END OVERTIME -----------------------------------------------------------------#




#--------------------------------------------------------- FORCE UPDATE ---------------------------------------------------------------------#

    public function forceupdateAndroid(Request $request) 
    {  
        $validator = Validator::make($request->all(), [
           'version' => 'required'
        ]);
        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => "Validator fails!",
                'data' => []
            ];

            return response()->json($response, 200);
        }
        
        $user_version = $request->version;
        $datas = ForceUpdate::first();

        if ($datas) {
            $update_version  = $datas->version;
            $flag_version  = $datas->flag;

            if ($flag_version == 1) {
                if ($user_version >= $update_version) {
                    $response = [
                        'error' => false,
                        'message' => "Your App is already updated.",
                        'data' => [
                                'url'=>'https://play.google.com/store/apps/details?id=com.attendance.cleanpro&pli=1'
                        ]
                    ];

                    return response()->json($response, 200);  

                } else {
                    
                    $response = [
                        'error' => true,
                        'message' => "Your App is need to be update.",
                        'data' => [
                                'url'=>'https://play.google.com/store/apps/details?id=com.attendance.cleanpro&pli=1'
                        ]
                    ];

                    return response()->json($response, 200);  
                }

            } else {
                $response = [
                    'error' => true,
                    'message' => "Your App is up to date.",
                    'data' => [
                            'url'=>'https://play.google.com/store/apps/details?id=com.attendance.cleanpro&pli=1'
                    ]
                ];

                return response()->json($response, 200); 
            }
            
            } else {
                $response = [
                'error' => true,
                'message' => "No setup data.",
                'data' => [
                        'url'=>'https://play.google.com/store/apps/details?id=com.attendance.cleanpro&pli=1'
                ]
            ];

            return response()->json($response, 200);  

        }
   }

    public function forceupdateIos(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'version' => 'required'
        ]);
        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' =>"Validator fails!",
                'data' => []
            ];

            return response()->json($response, 200);
        }
       
        $user_version = $request->version;
        $datas = ForceUpdateIos::first();

        if ($datas) {
            $update_version  = $datas->version;
            $flag_version  = $datas->flag;

            if ($flag_version == 1) {
                if ($user_version >= $update_version) {
                    $response = [
                        'error' => false,
                        'message' => "Your App is already updated.",
                        'data' => [
                                'url'=>'https://apps.apple.com/us/app/cleanpromyanmar/id1665383498'
                        ]
                    ];

                    return response()->json($response, 200);  

                } else {
                    
                    $response = [
                        'error' => true,
                        'message' => "Your App is need to be update.",
                        'data' => [
                                'url'=>'https://apps.apple.com/us/app/cleanpromyanmar/id1665383498'
                        ]
                    ];

                    return response()->json($response, 200);  
                }

            } else {

                $response = [
                    'error' => true,
                    'message' => "Your App is up to date.",
                    'data' => [
                                'url'=>'https://apps.apple.com/us/app/cleanpromyanmar/id1665383498'
                    ]
                ];

                return response()->json($response, 200); 
            }
           
        } else {

            $response = [
                'error' => true,
                'message' => "No setup data.",
                'data' => [
                                'url'=>'https://apps.apple.com/us/app/cleanpromyanmar/id1665383498'
                ]
            ];

            return response()->json($response, 200);  
        } 
    }
#--------------------------------------------------------- END FORCE UPDATE -------------------------------------------------------------#




#--------------------------------------------------------- GET USER PROFILE -------------------------------------------------------------#
 
    public function userProfile(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'leader_id' => 'required'
        ]);
        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => 'Validation error!',
                'data'  =>[]
            ];

            return response()->json($response, 200);
        }

        $user = Employee::where('delete_status','0')->where('id', $request->leader_id)->select('id', 'name', 'employee_id', 'photo')->first();
        
        if ($user->photo == null) {
            $images = '';
        } else {
            $images = asset('public/userimages/'.$user->photo);
        }

        if ($user) {
            $response = [
                'error' => false,
                'message' => 'User Profile Data',
                'data' => [
                    'id' => $user->id,
                    'employee_id' => $user->employee_id,
                    'photo' => $images
                ]
            ];

            return response()->json($response, 200);

        } else {
            $response = [
                'error' => true,
                'message' => 'User does not exists.',
                'data' => []
            ];

            return response()->json($response, 200);
        }
    }
   
#--------------------------------------------------------- END GET USER PROFILE ---------------------------------------------------------#
   
    public function saveuserImage(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'leader_id' => 'required',
            'image'  => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => 'Validation error!',
                'data'  => [$validator->errors()]
            ];

            return response()->json($response, 200);
        }
    
        $user_image = $request->image;
        // $user = Employee::findOrFail($request->leader_id);
        $user = Employee::where('delete_status','0')->where('id',$request->leader_id)->first();

        if ($user) {

            $image_name = Str::random(10).'.'."jpg";
            $decodedImage = base64_decode("$user_image");
            $return = file_put_contents('public/userimages/'.$image_name, $decodedImage);

            if ($user_image) {
                Employee::where('delete_status','0')->where('id', '=', $request->leader_id)->update([
                    'photo' => $image_name
                ]);
                $user_data = Employee::where('delete_status','0')
                            ->where('id', '=', $request->leader_id)
                            ->select('id', 'employee_id', 'name', 'photo')
                            ->first();
                            
                $images=asset('public/userimages/'.$user_data->photo);

                $response = [
                    'error' => false,
                    'message' =>'User image updated successfully.',
                    'data'  => [
                        'id' => $user_data->id,
                        'employee_id' => $user_data->employee_id,
                        'name' => $user_data->name,
                        'photo' => $images
                    ] 
                ];

                return response()->json($response, 200);

            } else {
                $response = [
                    'error' => true,
                    'message'=>'User image uploads fail.',
                    'data'  => []
                ];

                return response()->json($response,200);
            }

        } else {
            $response = [
                'error' => true,
                'message' => 'Phone number does not exists.',
                'data'  => []
            ];

            return response()->json($response, 200);
        }
    }
   
    public function adminAssign(Request $request) 
    {
        $datas = AssignProject::where('delete_status','0')->get();

        $arr = [];
        $i = 0;

        foreach ($datas as $data) {
            $site = Project::where('delete_status','0')->where('id', $data->project_id)->select('*')->first();
            
            if ($site) {
                $site_id = $site->id;
                $site_name = $site->name;
            } else {
                $site_id = 0;
                $site_name = '';
            }

            $shift = Shift::where('delete_status','0')->where('id', $data->shift_id)->select('*')->first();
            if ($shift) {
                $shift_id = $shift->id;
                $shiftObject = Shift::where('delete_status','0')->where('id', $shift_id)->select('id', 'name', 'site_id', 'full_name', 'start_time', 'end_time')->first();
            } else {
                $shift_id = 0;
                $shiftObject = null;
            }
            
            $leader = json_decode($data->leader_id);
            $leaderNames = Employee::where('delete_status','0')->whereIn('id', $leader)->select('id', 'employee_id', 'name')->get();
            if ($leaderNames) {
                $leaderName = $leaderNames;
            } else {
                $leaderName = [];
            }

            $emp_arr = [];
            $emp_arr = json_decode($data->emp_arr);

            $emps = Employee::where('delete_status','0')->whereIn('id', $emp_arr)->select('id', 'employee_id', 'name')->get();
            
            $part = json_decode($data->part_time);
            $parttimes = PartTime::where('delete_status','0')->whereIn('id', $part)->select('id', 'name', 'phone', 'address')->get();
            if ($parttimes == null) {
                $parttime = '';
            } else {
                $parttime = $parttimes;
            }
            
            $rv = json_decode($data->rv_arr);
            $rvNames = Employee::where('delete_status','0')->whereIn('id', $rv)->select('id', 'employee_id', 'name')->get();
            if ($rvNames) {
                $rvName = $rvNames;
            } else {
                $rvName = [];
            }

            $arr[$i] = [
                'id' => $data->id,
                'leader' => $leaderName,
                'site_id' => $site_id,
                'site_name' => $site_name,
                'shift_id' => $shift_id,
                'shift' => $shiftObject,
                'employee' => $emps,
                'parttime' => $parttime,
                'rv' => $rvName
            ];

            $i++;
        }

        $response = [
            'error'=>false,
            'message' => "For Admin Assign List",
            'data' => $arr
        ];

        return response()->json($response, 200);
    }
   
    public function parttimeList()
    {
        $data = PartTime::where('delete_status','0')->select('id', 'name', 'phone', 'address')->get();

        $response = [
            'error' => false,
            'message' => "All PartTime Workers List",
            'data' => $data
        ];

        return response()->json($response, 200);
    }
    
}
