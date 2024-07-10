<?php

namespace App\Http\Controllers\Apiv2;

use App\Shift;
use App\OverTime;
use App\LoginUser;
use Carbon\Carbon;
use App\Models\Project;
use App\Models\Employee;
use App\Models\PartTime;
use App\Models\LeaveApply;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AssignProject;
use App\Models\AttendanceFilename;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller {

#------------------------------------------------------------ ATTENDANCE ---------------------------------------------------------------#

    public function attendanceCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emp_arr' => 'required',
            'leader' => 'required',
            'site_id' => 'required',
            'date' => 'required',     
        ]);

        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => "Please fill required fields. (emp_arr, leader, site_id, date)"
            ];
            
            return response()->json($response, 200);
        }

        $emp_id_arr = json_encode($request->emp_arr);
        $rv_id_arr = json_encode($request->rv);
        $part_time = json_encode($request->parttime);
        $dayoff = json_encode($request->dayoff);
       
        $data = AttendanceFilename::create([
            'leader' => $request->leader,
            'shift_id' => $request->shift_id,
            'emp_arr' => $emp_id_arr,
            'rv_arr' => $rv_id_arr,
            'part_time' =>  $part_time,
            'lat' =>  $request->lat,
            'long' => $request->long,
            'dayoff' => $dayoff,
            'site' => $request->site_id,
            // 'date' => date_format(date_create($request->date), 'm/d/Y'),
            'date' => Carbon::parse($request->date)->format('Y-m-d h:i:s'),
            'time' => $request->time,
            'lat' => $request->lat,
            'long' => $request->long
        ]);

        if (isset($data)) {
            $response = [
                'error' => false,
                'message' => "Attendance created successfully."
            ];

            return response()->json($response, 200);
        }
    }
    
    public function attendanceEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'emp_arr' => 'required',
            'leader' => 'required',
            'site_id' => 'required',
            'date' => 'required',     
        ]);

        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => "Please fill required fields. (id, emp_arr, leader, site_id, date)"
            ];
            
            return response()->json($response, 200);
        }
        
        $emp_id_arr = json_encode($request->emp_arr);
        $rv_id_arr = json_encode($request->rv);
        $part_time = json_encode($request->parttime);
        $dayoff = json_encode($request->dayoff);
        
        // $data = AttendanceFilename::find($request->id);
        $data = AttendanceFilename::where('delete_status','0')->where('id',$request->id)->first();

        if (isset($data)) {
            if ($data->status == 0) {
                $data->update([
                    'leader' => $request->leader,
                    'shift_id' => $request->shift_id,
                    'emp_arr' => $emp_id_arr,
                    'rv_arr' =>  $rv_id_arr,
                    'part_time' =>  $part_time,
                    'lat' =>  $request->lat,
                    'long' => $request->long,
                    'dayoff' => $dayoff,
                    'site' => $request->site_id,
                    // 'date' => date_format(date_create($request->date), 'm/d/Y'),
                    'date' => Carbon::parse($request->date)->format('Y-m-d h:i:s'),
                    'time' => $request->time,
                    'lat' => $request->lat,
                    'long' => $request->long
                ]);
    
                $response = [
                    'error' => false,
                    'message' => "Attendance updated successfully."
                ];
            } else {
                $response = [
                    'error' => false,
                    'message' => "Attendance is already comfirmed by HR. You can't edit anymore."
                ];
            }
        } else {
            $response = [
                'error' => true,
                'message' => "Attendance not found. Please check your ID."
            ];
        }
        
        return response()->json($response, 200);
    }

#------------------------------------------------------------ END ATTENDANCE -----------------------------------------------------------#




#------------------------------------------------------------ SHIFT --------------------------------------------------------------------#
    
    public function shiftCreate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => "Shift Name is required."
            ];

            return response()->json($response, 200);
        }

        $data = Shift::create([
            'name' => $request->name,
            'site_id' => $request->site_id,
            'full_name' => $request->full_name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        if (isset($data)) {
            $response = [
                'error' => false,
                'message' => "Shift created successfully."
            ];
            return response()->json($response,200);
        } else {
            $response = [
                'error' => true,
                "message" => "Something wrong! Please try again."
            ];

            return response()->json($response, 200);
        }
    }

    public function shiftList(Request $request)
    {
        $shifts  = Shift::where('delete_status','0')->get();

        $response = [
            'error' => false,
            'message' => "All Shifts List",
            'data' => $shifts
        ];
        return response()->json($response, 200);
    }

    public function shiftEdit(Request $request) {

        $validator=Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            $response=[
                'error' => true,
                'message' => "Shift ID is required."
            ];
            return response()->json($response, 200);
        }

        // $data = Shift::find($request->id);
        $data = Shift::where('id',$request->id)->where('delete_status','0')->first();
        if (isset($data)) {
            $data->update([
                'name' => $request->name,
                'site_id' => $request->site_id,
                'full_name' => $request->full_name,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);

            $response = [
                'error' => false,
                'message' => "Shift updated successfully."
            ];
        } else {
            $response = [
                'error' => true,
                'message' => "Shift not found. Please check your ID."
            ];
        }

        return response()->json($response, 200);
    }

    public function shiftDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            $response=[
                'error' => true,
                'message' => "Shift id is required."
            ];
            return response()->json($response, 200);
        }

        // $data=Shift::find($request->id);
        $data = Shift::where('id',$request->id)->where('delete_status','0')->first();

        if (isset($data)) {
            $data->delete_status = 1;
            $data->update();

            $response = [
                'error' => false,
                'message' => "Shift deleted successfully."
            ];
        } else {
            $response = [
                'error' => true,
                'message' => "Shift not found. Please check your id."
            ];
        }

        return response()->json($response, 200);
    }

#--------------------------------------------------------- END SHIFT --------------------------------------------------------------------#




#--------------------------------------------------------- SITE -------------------------------------------------------------------------#

    public function siteCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'shifts' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => "Site Name and Shift ID are required."
            ];

            return response()->json($response, 200);
        }

        $data = Project::create([
            'name' => $request->name,
            'short_term' => $request->site_code,
            'description' => $request->desc,
            'client_id' => $request->client,
            'shifts' => json_encode($request->shifts)
        ]);

        if (isset($data)) {
            $response = [
                'error' => false,
                'message' => "Site created successfully."
            ];
        } else {
            $response = [
                'error' => true,
                "message" => "Something wrong! Please try again."
            ];  
        }

        return response()->json($response, 200);
    }

    public function siteList(Request $request) 
    {
        try {
            $sites = Project::where('delete_status','0')->with('shifts')->get();

            $response = [
                'error' => false,
                'message' => "All Sites List",
                'data' => $sites->map(function ($site) {
                    $siteDatas = [
                        'id' => $site->id,
                        'name' => $site->name,
                        'short_term' => $site->short_term,
                        'description' => $site->description,
                        'client_id' => $site->client_id,
                        'created_at' => $site->created_at,
                        'updated_at' => $site->updated_at,
                    ];

                    $shiftIds = json_decode($site->shifts, true);
                    $shifts = Shift::whereIn('id', $shiftIds)->where('delete_status', 0)->get(); 
                    $shiftObjects = [];

                    foreach ($shifts as $shift) {
                        $shiftObjects[] = ['id' => $shift->id, 'name' => $shift->name, 'full_name' => $shift->full_name, 'start_time' => $shift->start_time, 'end_time' => $shift->end_time,];
                    }

                    $siteDatas['shifts'] = $shiftObjects;                

                    return $siteDatas;
                })
            ];
            
            return response()->json($response, 200);

        } catch (\Exception $e) {
            $response = [
                'error' => true,
                'message' => 'Error retrieving data: ' . $e->getMessage(),
            ];
            
            return response()->json($response, 500);
        }
    }

    public function siteEdit(Request $request) 
    {
        $validator=Validator::make($request->all(),[
            'id'=>'required',
            'name'=>'required'
        ]);
        if ($validator->fails()) {
            $response=[
                'error'=>true,
                'message'=>"Site Name and Site ID are required."
            ];
            return response()->json($response, 200);
        }

        // $data = Project::find($request->id);
        $data = Project::where('delete_status','0')->where('id',$request->id)->first();
        if (isset($data)) {
            $data->update([
                'name' => $request->name,
                'description' => $request->desc,
                'short_term' => $request->site_code,
                'client_id' => $request->client,
                'shifts' => json_encode($request->shifts)
            ]);

            $response = [
                'error' => false,
                'message' => "Site updated successfully."
            ];
        } else {
            $response = [
                'error' => true,
                'message' => "Site not found. Please check your ID."
            ];
        }

        return response()->json($response, 200);
    }

    public function siteDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        
        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => "Site ID is required."
            ];

            return response()->json($response, 200);
        }

        // $project = project::find($request->id);
        $data = Project::where('delete_status','0')->where('id',$request->id)->first();

        if (isset($project)) {
            $project->delete();
            AssignProject::where('project_id', $request->id)->delete();

            $response = [
                'error'=>'false',
                'message'=>"Site deleted successfully."
            ];  

        } else {
            $response = [
                'error'=>'true',
                'message'=>"Site not found."
            ];
        }    

        return response()->json($response, 200);
    }

#---------------------------------------------------------- END SITE --------------------------------------------------------------------#




#---------------------------------------------------------- LEAVE -----------------------------------------------------------------------#
    
    public function leaveCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emp_id' =>'required',
            'leader' => 'required',
            'leave_type' => 'required',
            'dateFrom' => 'required',
            'dateTo' => 'required',
            'totalLeave' => 'required'  
        ]);
        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => "Please fill required fields. (emp_id, leader, leave_type, dateFrom, dateTo, totalLeave)",
            ];

            return response()->json($response, 200);
        }
        
        $datas = AssignProject::where('delete_status','0')->get();
        
        foreach ($datas as $data) {

            $led = json_decode($data->leader_id); 
            if ($led == null) {
                $leader = [];
            } else {
                $leader = $led;
            }
           
            if (in_array($request->leader, $leader)) {
                $id = $data->project_id;
                // $site = Project::where('id', $id)->first();
                $site = Project::where('delete_status','0')->where('id', $id)->first();

                break;
            }
        }
      
        // $employee = Employee::find($request->emp_id);
        $employee = Employee::where('id',$request->emp_id)->where('delete_status', 0)->first();
        
        if (isset($employee)) {
            $empName = $employee->name;
        } else {
            $empName = "";
        }
        
        
        // store multiple photos
        $photoPaths = [];
        $photos = $request->file('photos');

        if ($photos) {
            foreach ($photos as $index => $photo) {
                // Process each uploaded file
                $image_name = Str::random(5) . '.' . $photo->getClientOriginalExtension();
                $photo->move('public/medicalleave/', $image_name);
                $photoPaths[] = $image_name;
            }
        }
        
        $photoPathsJson = json_encode($photoPaths);
        
        $data = LeaveApply::create(
            [
                'leader'=>$request->leader,
                'emp_id' =>$request->emp_id,
                'name' => $empName,
                'site_id'=>$request->site_id,
                'site_name'=>$request->site_name,
                'shift_id' => $request->shift_id,
                'leave_type'=>$request->leave_type,
                'dateFrom'=>date_format(date_create($request->dateFrom), 'Y-m-d h:i:s'),
                'dateTo'=>date_format(date_create($request->dateTo), 'Y-m-d h:i:s'),
                'total'=>$request->totalLeave,
                'date_claim'=>date_format(date_create($request->date_claim), 'm/d/Y'),
                'content'=>$request->content,
                'other'=>$request->other,
                'photo'=>$photoPathsJson
            ]
        );

        if (isset($data)) {
            $response = [
                'error' => false,
                'message' => "Leave form submitted successfully."
            ];

            return response()->json($response, 200);

        } else {
            $response = [
                'error' => true,
                'message' => "Something wrong! Please try again."
            ];

            return response()->json($response, 200);
        }
    }
    
    public function leaveEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'emp_id' =>'required',
            'leader' => 'required',
            'leave_type' => 'required',
            'dateFrom' => 'required',
            'dateTo' => 'required',
            'totalLeave' => 'required'  
        ]);
        
        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => "Please fill required fields. (id, emp_id, leader, leave_type, dateFrom, dateTo, totalLeave)",
            ];

            return response()->json($response, 200);
        }
        
        // $leave = LeaveApply::find($request->id);
        $leave = LeaveApply::where('id', $request->id)->where('delete_status','0')->first();

        
        if (!$leave) {
            
            $response = [
                'error' => true,
                'message' => "Leave application not found.",
            ];
    
            return response()->json($response, 404);
            
        } elseif ($leave && $leave->status != 0) {
            
            $response = [
                'error' => true,
                'message' => "You cannot update leave apply since status was changed.",
            ];
            
        } else {
            $datas = AssignProject::where('delete_status','0')->get();
            
            foreach ($datas as $data) {
    
                $led = json_decode($data->leader_id); 
                
                if ($led == null) {
                    $leader = [];
                } else {
                    $leader = $led;
                }
               
                if (in_array($request->leader, $leader)) {
                    
                    $id = $data->project_id;
                    // $site = Project::where('id', $id)->first();
                    $site = Project::where('delete_status','0')->where('id', $id)->first();
    
                    break;
                }
            }

            // $employee = Employee::find($request->emp_id);
            $employee = Employee::where('id',$request->emp_id)->where('delete_status', 0)->first();
            
            if (isset($employee)) {
                $empName = $employee->name;
            } else {
                $empName = "";
            }
    
            // images upload update
            $leave->leader = $request->leader;
            $leave->emp_id = $request->emp_id;
            $leave->name = $empName; 
            $leave->site_id = $request->site_id;
            $leave->site_name = $request->site_name;
            $leave->shift_id = $request->shift_id;
            $leave->leave_type = $request->leave_type;
            $leave->dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d h:i:s');
            $leave->dateTo = date_format(date_create($request->dateTo), 'Y-m-d h:i:s');
            $leave->total = $request->totalLeave;
            $leave->date_claim = date_format(date_create($request->date_claim), 'm/d/Y');
            $leave->content = $request->content;
            $leave->other = $request->other;
        
            // handle file addition
            $photoPaths = [];
            $photos = $request->file('photos');

            if ($photos) {
                // clear the $photoPaths array
                $photoPaths = [];
        
                foreach ($photos as $index => $photo) {
                    // Process each uploaded file
                    $image_name = Str::random(5) . '.' . $photo->getClientOriginalExtension();
                    $photo->move('public/medicalleave/', $image_name);
                    $photoPaths[] = $image_name;
                }
        
                // delete old photos
                if ($leave->photo) {
                    $oldPhotoPaths = json_decode($leave->photo, true);
                    foreach ($oldPhotoPaths as $oldPhoto) {
                        Storage::delete('public/medicalleave/' . $oldPhoto); 
                    }
                }
                
                $leave->photo = json_encode($photoPaths);

            }
            
            $leave->save();

            $response = [
                'error' => false,
                'message' => "Leave form updated successfully."
            ];
        }

        return response()->json($response, 200);
    }
    
#--------------------------------------------------------- END LEAVE --------------------------------------------------------------------#




#--------------------------------------------------------- OVERTIME ---------------------------------------------------------------------#

    public function overtimeCreate(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'emp_arr' => 'required',
            'otdate' => 'required',
            'fromtime' => 'required',
            'totime' => 'required',
            'leader' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => "Please fill required fields. (emp_arr, otdate, fromtime, totime, leader)"
            ];

            return response()->json($response, 200);
        }

        $emp_id_arr = json_encode($request->emp_arr);

        // $siteName = Project::where('id', $request->site_id)->first();
        $siteName = Project::where('delete_status','0')->where('id', $request->site_id)->first();

        if (!isset($siteName)) {
            $siteName = "";
        } else {
            $siteName = $siteName->name;
        }

        $shiftName = Shift::where('id', $request->shift_id)->where('delete_status','0')->first();
        if (!isset($shiftName)) {
            $shiftName = "";
        } else {
            $shiftName = $shiftName->name;
        }

        $data = OverTime::create(
            [
                'leader' => $request->leader,
                'site_id' => $request->site_id,
                'site_name' => $siteName,
                'shift_id' => $request->shift_id,
                'shift_name' => $shiftName,
                'emp_arr' => $emp_id_arr,
                'otdate' => date_format(date_create($request->otdate), 'Y-m-d h:i:s'),
                'fromtime' => $request->fromtime,
                'totime' => $request->totime,
                'content' => $request->content,
                'remark' => $request->remark,
                'completion_report' => $request->completion_report
            ]
        );

        if (isset($data)) {
            $response = [
                'error' => false,
                'message' => "OverTime applied successfully."
            ];

            return response()->json($response, 200);

        } else {
            $response = [
                'error' => true,
                'message' => "Something wrong! Please try again."
            ];

            return response()->json($response, 200);
        }
    }
    
    public function overtimeEdit(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'emp_arr' => 'required',
            'otdate' => 'required',
            'fromtime' => 'required',
            'totime' => 'required',
            'leader' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => "Please fill required fields. (id, emp_arr, otdate, fromtime, totime, leader)"
            ];

            return response()->json($response, 200);
        }

        $emp_id_arr = json_encode($request->emp_arr);

        // $siteName = Project::where('id', $request->site_id)->first();
        $siteName = Project::where('delete_status','0')->where('id', $request->site_id)->first();

        if (!isset($siteName)) {
            $siteName = "";
        } else {
            $siteName = $siteName->name;
        }

        $shiftName = Shift::where('id', $request->shift_id)->where('delete_status','0')->first();
        if (!isset($shiftName)) {
            $shiftName = "";
        } else {
            $shiftName = $shiftName->name;
        }
        
        // $overtime = Overtime::find($request->id);
        $overtime = Overtime::where('delete_status','0')->where('id',$request->id)->first();

        if (!$overtime) {
            $response = [
                'error' => true,
                'message' => "Overtime record not found."
            ];
    
            return response()->json($response, 404);
        } elseif ($overtime && $overtime->status != 0) {
            $response = [
                'error' => true,
                'message' => "You cannot update overtime since status was changed.",
            ];
            
            return response()->json($response, 200);
            
        } else {
            $overtime->update(
                [
                    'leader' => $request->leader,
                    'site_id' => $request->site_id,
                    'site_name' => $siteName,
                    'shift_id' => $request->shift_id,
                    'shift_name' => $shiftName,
                    'emp_arr' => $emp_id_arr,
                    'otdate' => date_format(date_create($request->otdate), 'Y-m-d h:i:s'),
                    'fromtime' => $request->fromtime,
                    'totime' => $request->totime,
                    'content' => $request->content,
                    'remark' => $request->remark,
                    'completion_report' => $request->completion_report
                ]
            );
            
            $response = [
                'error' => false,
                'message' => "OverTime updated successfully."
            ];

            return response()->json($response, 200);
        }
    }

#--------------------------------------------------------- END OVERTIME -----------------------------------------------------------------#




#--------------------------------------------------------- ASSIGN -----------------------------------------------------------------------#

    public function assignCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'leader_id' => 'required',
            'project_id' => 'required',
            'emp_arr' => 'required',
            'doa' => 'required',
            'shift_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => "Please fill required fields. (leader_id)"
            ];

            return response()->json($response, 200);
        };

        $emp = json_encode($request->emp_arr);
        $leader = json_encode($request->leader_id);

        $shiftName = Shift::where('id', $request->shift_id)->where('delete_status','0')->first();
        if (!isset($shiftName)) {
            $shiftName = "";
        } else {
            $shiftName = $shiftName->name;
        }

        $data = AssignProject::create(
            [
                'leader_id' => $leader,
                'project_id' => $request->project_id,
                'emp_arr' => $emp,
                'rv_arr' => json_encode($request->rv_arr),
                'part_time' => json_encode($request->parttime),
                'shift_id'  =>  $request->shift_id,
                'shift_name'  =>  $shiftName,
                'authority_id' => $request->authority_id,
                'date_of_assignment' => date_format(date_create($request->doa), 'm/d/Y'),
                'date_of_release' => date_format(date_create($request->dor), 'm/d/Y'),
            ]
        );

        if (isset($data)) {
            $response = [
                'error' => false,
                'message' => "Assign created successfully.",
            ];

            return response()->json($response, 200);

        } else {
            $response = [
                'error' => true,
                'message' => "Something wrong! Please try again."
            ];

            return response()->json($response, 200);
        }
    }

    public function assignEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'leader_id' => 'required',
            'project_id' => 'required',
            'emp_arr' => 'required',
            'doa' => 'required',
            'shift_id' => 'required'
        ]);
        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => "Please fill required fields."
            ];

            return response()->json($response, 200);
        }

        $data = AssignProject::where('delete_status','0')->where('id',$request->id)->first();

        $emp = json_encode($request->emp_arr);
        $leader = json_encode($request->leader_id);

        $shiftName = Shift::where('id', $request->shift_id)->where('delete_status','0')->first();
        if (!isset($shiftName)) {
            $shiftName = "";
        } else {
            $shiftName = $shiftName->name;
        }

        $data->update(
            [
                'leader_id' => $leader,
                'project_id' => $request->project_id,
                'emp_arr' => $emp,
                'rv_arr' => json_encode($request->rv_arr),
                'part_time' => json_encode($request->parttime),
                'shift_id'  =>  $request->shift_id,
                'shift_name'  =>  $shiftName,
                'authority_id' => $request->authority_id,
                'date_of_assignment' => date_format(date_create($request->doa), 'm/d/Y'),
                'date_of_release' => date_format(date_create($request->dor), 'm/d/Y'),
            ]
        );

        $response = [
            'error' => false,
            'message' => "Assign updated successfully.",       
        ];

        return response()->json($response, 200);
    }

    public function assignDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => "Assign ID is required."
            ];
            
            return response()->json($response, 200);
        }

        // $assign = AssignProject::find($request->id);
        $assign = AssignProject::where('delete_status','0')->where('id',$request->id)->first();
        if (isset($assign)) {
            $assign->delete();
            $response = [
                'error' => 'false',
                'message' => "Assign deleted successfully."
            ];
        } else {
            $response = [
                'error' => 'true',
                'message' => "Assign not found."
            ];
        }
    
        return response()->json($response, 200);
    }

#--------------------------------------------------------- END ASSIGN -------------------------------------------------------------------#




#--------------------------------------------------------- USER ACCOUNT DELETE -----------------------------------------------------------#

    public function deleteAccount(Request $request) {
        $validator=Validator::make($request->all(),[
            'user_id'=>'required'
        ]);

        if ($validator->fails()) {
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

#--------------------------------------------------------- END DELETE ACCOUNT -----------------------------------------------------------#




#--------------------------------------------------------- Admin OT/LEAVE ---------------------------------------------------------------#

    public function adminOvertime(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'emp_arr' => 'required',
            'otdate' => 'required',
            'fromtime' => 'required',
            'totime' => 'required',
            'leader' => 'required',
            
        ]);

        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => "Fill Required Field"
            ];
            return response()->json($response, 200);
        }
        $emp_id_arr = json_encode($request->emp_arr);

        $data = OverTime::create(
            [
                'leader' => $request->leader,
                'site_id' => $request->site_id,
                'site_name' => $request->site_name,
                'emp_arr' => $emp_id_arr,
                'otdate' => date_format(date_create($request->otdate), 'm/d/Y'),
                'fromtime' => $request->fromtime,
                'totime' => $request->totime,
                'content' => $request->content,
                'remark' => $request->remark,
                'completion_report' => $request->completion_report
                
            ]
        );

        if (isset($data)) {
            $response = [
                'error' => false,
                'message' => "OverTime Successfully Applied"
            ];

            return response()->json($response, 200);

        } else {
            $response = [
                'error' => true,
                'message' => "Something wrong! Please try again."
            ];

            return response()->json($response, 200);
        }

    }

    public function adminLeave(Request $request) {
        $validator = Validator::make($request->all(), [
            'emp_id' =>'required',
            'leave_type'=>'required',
            'dateFrom'=>'required',
            'dateTo'=>'required',
            'totalLeave'=>'required',
            'leader'=>'required' 
        ]);

        if ($validator->fails()) {
            $response=[
                'error' =>true,
                'message'=>"Fill Emp_id,Leave_type,Date",
            ];
            return response()->json($response, 200);
        }

        $photo=json_encode($request->photo);

        $data = LeaveApply::create([
            'leader' => $request->leader,
            'emp_id' => $request->emp_id,
            'name' => $request->name,
            'site_id' => $request->site_id,
            'site_name' => $request->site_name,
            'leave_type' => $request->leave_type,
            'dateFrom' => date_format(date_create($request->dateFrom), 'm/d/Y'),
            'dateTo' => date_format(date_create($request->dateTo), 'm/d/Y'),
            'total' => $request->totalLeave,
            'date_claim' => date_format(date_create($request->date_claim), 'm/d/Y'),
            'content' => $request->content,
            'photo' => $photo
        ]);

        if (isset($data)) {
            $response=[
                'error'=>false,
                'message'=>"Leave Successfully Applied"
            ];
            return response()->json($response, 200);
        }else{
            $response=[
                'error'=>true,
                'message'=>"Something wrong! Please try again."
            ];
            return response()->json($response, 200);
        }
    }

#--------------------------------------------------------- END ADMIN OT/LEAVE -----------------------------------------------------------#
        



#--------------------------------------------------------- EMPLOYEE ---------------------------------------------------------------------#

    public function employeeList()
    {
        $data = Employee::where('delete_status', 0)->select('id', 'employee_id', 'name')->get();
        // $data = Employee::select('id', 'employee_id', 'name')->get();
        
        $response = [
            'error' => false,
            'message' => 'All Employees List',
            'data' => $data
            
        ];
        
        return response()->json($response, 200);

    }

#--------------------------------------------------------- END EMPLOYEE -----------------------------------------------------------------#




#--------------------------------------------------------- PART-TIME --------------------------------------------------------------------#

    public function parttimeCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => $validator->errors()->first(),
            ];

            return response()->json($response, 200);
        }

        $existingData = PartTime::where('delete_status', 0)
                                ->where('name', $request->name)
                                ->where('phone', $request->phone)
                                ->where('address', $request->address)
                                ->exists();

        if ($existingData) {
            $response = [
                'error' => true,
                'message' => "Duplicate data found. Please provide unique data.",
            ];

            return response()->json($response, 200);
        }

        $data = PartTime::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if ($data) {
            $response = [
                'error' => false,
                'message' => "Part-time worker created successfully."
            ];

            return response()->json($response, 200);

        } else {
            $response = [
                'error' => true,
                'message' => "Something wrong! Please try again."
            ];

            return response()->json($response, 200);
        }
    }

#--------------------------------------------------------- END PART-TIME ----------------------------------------------------------------#

}
