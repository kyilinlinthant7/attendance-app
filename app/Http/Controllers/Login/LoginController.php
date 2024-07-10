<?php

namespace App\Http\Controllers\Login;

use App\Shift;
use App\LoginUser;
use App\Models\Project;
use App\Models\Employee;
use App\Models\PartTime;
use Illuminate\Http\Request;
use App\Models\AssignProject;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller {
    
    public function showLoginForm()
    {
        return view('leader.login');
    }

    public function login(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' =>'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => "Name and Password are required. Please enter both fields.",
            ];
            return response()->json($response, 200);
        }

        $name = $request->name;
        $pass = $request->password; 

        $users = Employee::select('id', 'name', 'photo', 'employee_id')->get();

        $i = 0;
        $data = [];
        foreach ($users as $user) {
            $data[$i] = $user->name;
            $i++;
        }


        if (in_array($name, $data)) {

            foreach ($users as $user) {
           
                if ($user->name == $name) {
                    $emp_id = $user->id;
                    $password = LoginUser::where('emp_id', $user->id)->select('id', 'default_password', 'updated_password', 'role')->first();
                    
                   if ($user->photo == null) {
                       $images = "";
                   } else {
                       $images = asset('public/userimages/'.$user->photo);
                   }
                   
                   $datas=AssignProject::get();

                   
                   foreach ($datas as $data) {
                       $leader = json_decode($data->leader_id);
                       
                       if ($leader == null) {
                           $leaders = [];
                       } else {
                           $leaders = $leader;
                       }

                       if (in_array($user->id, $leaders)) {
                            $emps = AssignProject::where('id', $data->id)->select('id', 'project_id', 'emp_arr', 'part_time')->first();
                            $sites_id[] = AssignProject::with('project.shifts')->where('id', $data->id)->select('id', 'project_id','shift_id', 'emp_arr', 'part_time')->get();
                       } else {
                           $emps = null;
                           $sites_id = [];
                       }
                    }
                  
                    if (!empty($emps)) {
                            
                            if (Hash::check($pass, $password->default_password)) {
            
                                $response = [
                                    'error' => false,
                                    'message' => "Correct.Please Change Password!",
                                ];
                                
                                return response()->json($response, 200);
            
                            } elseif (Hash::check($pass, $password->updated_password)) {
            
                                $response = [
                                    'error' => false,
                                    'message' => "Correct!!",
                                    'data' => [
                                        'id' => $password->id,
                                        'user_id' => $emp_id,
                                        'employee_id' => $user->employee_id,
                                        'name' => $name,
                                        'photo' => $images,
                                        'role' => $password->role,
                                        'site_id' => $sites_id,
                                    ]
                                ];
                                return view('leader.login_select_site', compact('name', 'sites_id', 'emp_id')); 
            
                            } else {
            
                                $response = [
                                    'error' =>true,
                                    'message' => "Incorrect Password!!",
                                ];
                                return response()->json($response);
                            } 
                    } else {
                       return redirect()->back(); 
                    }
                }
            }

        } else {
            return("No User Name In The Records");
        }
    }

    public function loginCheck(Request $request)
    {
        $userId = $request->user_id;
        $site = $request->site;
        $shift = $request->shift;

        $searchAssign = AssignProject::where('delete_status','0')
                        ->where('project_id', $site)
                        ->where('shift_id', $shift)
                        ->get()
                        ->filter(function ($assignProject) use ($userId) {
                            return in_array($userId, json_decode($assignProject->leader_id));
                        })
                        
                        ->sortByDesc('created_at')
                        ->take(1);

        $checkAssign = $searchAssign->first();

        $username = $request->user_name;
        $eId = Employee::find($userId);
        if ($eId) {
            $empId = $eId->employee_id;
        } else {
            $empId = null;
        }

        if (!empty($checkAssign)) {
            return view('leader.home', compact('userId', 'site', 'shift', 'checkAssign', 'username', 'empId'));
        } else {
            return redirect()->back();
        }
    }
    
    public function changePassword(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'old' =>'required',
            'new' =>'required',
            'renew' =>'required',
        ]);
        
        if ($validator->fails()) {
            $response = [
                'erroe' => true,
                'message' => "Please Enter All Field"
            ];
            return response()->json($response);
        }

        $name = $request->name;
        $pass = $request->old;
        $newpass = $request->new;
        $renewpass  = $request->renew;
        $default = 999999;

        if ($newpass == $renewpass) { 

            $users = Employee::select('id', 'name')->get();

            $i = 0;
            $data = [];
            foreach ($users as $user) {
                $data[$i] = $user->name;
                $i++;
            }

            if (in_array($name, $data)) {

                foreach ($users as $user) {

                    if ($user->name == $name) {
                        
                        $password = LoginUser::where('emp_id',$user->id)->select('id', 'default_password', 'updated_password')->first();
                        $datas = LoginUser::findOrFail($password->id);
                        if (Hash::check($pass, $password->default_password)) {
                            $datas->update([
                                'default_password' => Hash::make($default),
                                'updated_password' => Hash::make($newpass),
                            ]);
                            $response = [
                                'error' => false,
                                'message' => "Password updated! LOGIN again with updated password."
                            ];
                                return response()->json($response, 200);
                            break;
                        } elseif (Hash::check($pass, $password->updated_password)) {
                            $datas->update([
                                'default_password' => Hash::make($default),
                                'updated_password' =>  Hash::make($newpass),
                            ]);
                            $response = [
                                'error' => false,
                                'message' => "Password updated! LOGIN again with updated password."
                            ];
                                return response()->json($response, 200);
                            break;
                        } else {
                            $response = [
                                'error' => true,
                                'message' => "The supplied password does not matches with the one we have in records"
                            ];
                            return response()->json($response, 200);
                        }  
                    }
                }
            } else {
                $response = [
                    'error' => true,
                    'message' => "No User Name In The Records."
                ];
                return response()->json($response, 200);
            }
        } else {
            $response = [
                'error' => true,
                'message' => "New password must be same!"
            ];

            return response()->json($response, 200);
        }
    }
    
    
    //This api for login (Data passing when parttime edit)
    public function loginData(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'user_id' =>'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'error' =>true,
                'message' => "User ID is required",
            ];
            return response()->json($response, 200);
        }


        $datas = AssignProject::get(); 
        
        $pj = null;
        $pj_id = null;

        foreach ($datas as $data) {
            $leader = json_decode($data->leader_id);
            if ($leader) {
                $led = $leader;
            } else {
                $led = [];
            }
            if (in_array($request->user_id, $led)) {
                $assign_id = $data->id;
                $emps = AssignProject::where('id', $assign_id)->first();
                    break;
            } else {
                $emps = [];
            }
        }

        if (!empty($emps)) {
            $project = Project::where('id', $emps->project_id)->select('id', 'name')->first();
            
            if ($project) {
                $pj = $project->name;
                $pj_id = $project->id;
            } else {
                $pj = null;
                $pj_id = null;
            }

            if ($emps->part_time == null) {
                $parttimes = [];
            } else {
                $part=json_decode($emps->part_time);
                $parttimes = PartTime::whereIn('id', $part)->select('id', 'name', 'phone')->get();
            }

            $emp_array = json_decode($emps->emp_arr);
            $employee = Employee::whereIn('id', $emp_array)->select('id', 'name', 'employee_id')->get();

            if ($employee) {
                $employee_arr = $employee;
            } else {
                $employee_arr = [];
            }
            
            $rv_array = json_decode($emps->rv_arr);
            $rv = Employee::whereIn('id', $rv_array)->select('id', 'name', 'employee_id')->get();

            if ($rv) {
                $rv_arr = $rv;
            } else {
                $rv_arr = [];
            }

            $shift_id = $emps->shift_id;
            $shiftObject = Shift::where('id', $shift_id)->select('name', 'full_name', 'start_time', 'end_time')->first();
                    
        } else {
            $pj = '';
            $employee_arr = [];
            $parttimes = [];
            $rv_arr = [];
            $shift_id = null;
            $shiftObject = null;
        }

        $response = [
            'error' => false,
            'message' => "Correct!!",
            'data' => [
                'site' => $pj,
                'site_id' =>$pj_id, 
                'shift_id' => $shift_id,
                'shift' => $shiftObject,
                'employee' => $employee_arr,
                'parttime' => $parttimes,
                'rv' => $rv_arr
            ]
        ];
        
        return response()->json($response, 200);                
    }
    
    public function hseChecklist()
    {
        $response = [
            'error' => false,
            'message' => "Correct!!",
            'data' => [
                'url' => 'https://www.hr.busybeesexpertservice.com/hse-checklists'
            ]
        ];
        return response()->json($response, 200);
    }
}
 
