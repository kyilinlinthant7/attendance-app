<?php

namespace App\Http\Controllers;

use App\Shift;
use Validator;
use App\Models\Client;
use App\Models\Project;
use App\Models\Employee;
use App\Models\PartTime;
use Illuminate\Http\Request;
use App\Models\AssignProject;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;

class ProjectController extends Controller
{
    public function addProject()
    {
        $model = new \stdClass();
        $model->clients = Client::get();
        return view('hrms.projects.add', compact('model'));
    }

    public function saveProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site' => 'required|unique:projects,name,NULL,id,delete_status,0',
        ]);
    
        if ($validator->fails()) {
            \Session::flash('flash_message', 'Your site name already exists! Please type new site name.');
            return redirect()->back();
        }

        $project = new Project;
        $project->name = $request->site;
        $project->short_term= $request->short_term;
        $project->description = $request->description;
        $project->client_id = $request->client_name;
        $project->save();

        $shiftDataArray = json_decode($request->shift_data, true);

        if ($shiftDataArray) {
            foreach ($shiftDataArray as $shiftData) {
                $shift = new Shift;
                $shift->name = $shiftData['shiftName'];
                $shift->full_name = $shiftData['fullName'];
                $shift->site_id = $project->id;
                $shift->start_time = $shiftData['startTime'];
                $shift->end_time = $shiftData['endTime'];
                $shift->save();
    
                $shiftIds[] = $shift->id;
            }
            $project->shifts = json_encode($shiftIds);
        }

        $project->save();

        \Session::flash('flash_message', 'Project successfully added!');
        return redirect()->back();
    }

    public function showEdit($projectId)
    {
        $project = Project::findOrFail($projectId);

        $shiftIds = json_decode($project->shifts, true);
        $shiftData = [];

        if (is_array($shiftIds) && !empty($shiftIds)) {
            foreach ($shiftIds as $shiftId) {
                $shift = Shift::where('id', $shiftId)
                              ->where('delete_status', 0)
                              ->first();
                if ($shift) {
                    $shiftData[] = [
                        'shiftName' => $shift->name,
                        'fullName' => $shift->full_name,
                        'startTime' => $shift->start_time,
                        'endTime' => $shift->end_time
                    ];
                }
            }
        }        
      
        return view('hrms.projects.edit', compact('project', 'shiftData'));
    }

    public function listProject()
    {
        $projects = Project::where('delete_status', 0)->paginate(10);
        $sites = Project::where('delete_status', 0)->get();
        
        return view('hrms.projects.list', compact('projects', 'sites'));
    }

    public function assignProject()
    {
        $model = new \stdClass();
        $model->projects = Project::get();
        $model->employees = Employee::whereHas('userrole', function($q)
        {
            $q->whereIn('role_id', ['3', '4']);
        })->where('delete_status', '0')->get();

        return view('hrms.projects.assign', compact('model'));
    }
   
    public function processProject(Request $request)
    {
        $project = new Project;
        $project->name = $request->project_name;
        $project->short_term= $request->short_term;
        $project->description = $request->description;
        $project->client_id = $request->client_id;
        $project->save();
        \Session::flash('flash_message', 'Project successfully added!');
        return redirect()->back();
    }

    public function doEdit(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $newShiftDataArray = json_decode($request->new_shift_data, true);
        $beforeShiftIds = json_decode($project->shifts, true) ?? [];
        $afterExistingShiftIds = json_decode($request->after_shift_ids, true) ?? [];
        $existingShiftData = $request->existing_shift_data;
        $newShiftData = $request->new_shift_data;
        
        // removed shifts delete
        $removeShiftIds = array_diff($beforeShiftIds, $afterExistingShiftIds);
        if (!empty($removeShiftIds)) {
            Shift::whereIn('id', $removeShiftIds)->update(['delete_status' => 1]);
        }

        // update existing shifts 
        $existingShiftDataArray = json_decode($existingShiftData, true);
        foreach ($afterExistingShiftIds as $index => $afterExistingShiftId) {
            $shift = Shift::find($afterExistingShiftId);
            if ($shift && isset($existingShiftDataArray[$index])) {
                $exShiftData = $existingShiftDataArray[$index];
                $shift->update([
                    'name' => $exShiftData['shiftName'],
                    'full_name' => $exShiftData['fullName'],
                    'start_time' => $exShiftData['startTime'],
                    'end_time' => $exShiftData['endTime'],
                ]);
            }
        }

        if (is_array($newShiftDataArray)) {
            foreach ($newShiftDataArray as $newShiftData) {
                if ($newShiftData == "") {
                    $newShiftId = isset($newShiftData['id']) ? $newShiftData['id'] : null;
                    $shift = Shift::find($newShiftId);
                    if ($shift) {
                        $shift->update([
                            'name' => $newShiftData['shiftName'],
                            'full_name' => $newShiftData['fullName'],
                            'start_time' => $newShiftData['startTime'],
                            'end_time' => $newShiftData['endTime'],
                        ]);
                    }
                } else {
                    $shift = Shift::create([
                        'name' => $newShiftData['shiftName'],
                        'full_name' => $newShiftData['fullName'],
                        'site_id' => $project->id,
                        'start_time' => $newShiftData['startTime'],
                        'end_time' => $newShiftData['endTime'],
                    ]); 
                    $newShiftId = $shift->id; 
                }

                $beforeShiftIds[] = $newShiftId;
            }
        }

        // update the project's shift IDs
        $project->shifts = json_encode($beforeShiftIds);
        $project->update([
            'name' => $request->site,
            'short_term' => $request->short_term,
            'description' => $request->description,
            'client_id' => $request->client_name,
        ]);

        \Session::flash('flash_message', 'Project updated successfully.');
        return redirect('list-project');
    }

    public function doDelete($id)
    {
        $project = project::find($id);
        
        if ($project) {
            $project->update(['delete_status' => 1]);
        } else {
            \Session::flash('flash_message', 'Fail to Delete!');
            return redirect('list-project');
        }
        
        \Session::flash('flash_message', 'Project successfully Deleted!');
        return redirect('list-project');
    }

    public function getShifts($projectId) 
    {
        $project = Project::findOrFail($projectId);
        $shifts = $project->shifts()->where('delete_status', 0)->get();
        
        return response()->json($shifts);
    }

    public function doAssign()
    {
        $emps = Employee::where('delete_status', 0)->get();
        $leaderEmps = Employee::get()->where('delete_status', '0')->where('position', 'Leader');
        // $serviceEmps = Employee::where('position', 'Service Associate')
        //                 ->orWhere('position', 'Senior Service Associate')
        //                 ->orWhere('position', 'High Rise Technician')
        //                 ->get();
        $serviceEmps = Employee::where('delete_status', 0)
                        ->where(function($query) {
                            $query->where('position', 'Service Associate')
                                  ->orWhere('position', 'Senior Service Associate')
                                  ->orWhere('position', 'High Rise Technician');
                        })
                        ->get();

        $authorEmps = $emps->reject(function ($employee) {
            return ($employee->position === 'Leader' || $employee->position === 'Service Associate') &&
                   in_array($employee->sub_department, ['Human Resource']);
        });        
        
        $projects = Project::where('delete_status', 0)->get();
        $shifts = Shift::where('delete_status', 0)->get();

        return view('hrms.project.assign-project', compact('projects', 'leaderEmps', 'serviceEmps', 'authorEmps', 'emps', 'shifts'));
    }

    public function processAssign(Request $request)
    {
        $emp_array = json_encode($request->emp);
        $leaders = json_encode($request->leader);
        $rv_arr = json_encode($request->rv);

        $shift = Shift::where('id', $request->shift_id)->first();

        $assignment = new AssignProject();
        if ($shift) {
            $assignment->shift_name = $shift->name;
        }

        $assignment->leader_id = $leaders;
        $assignment->project_id = $request->project_id;
        $assignment->shift_id = $request->shift_id;
        $assignment->authority_id = $request->authority_id;
        $assignment->emp_arr = $emp_array;
        $assignment->rv_arr = $rv_arr;
        $assignment->date_of_assignment = date_format(date_create($request->doa), 'Y-m-d');
        $assignment->save();

        \Session::flash('flash_message', 'Project successfully assigned!');
        return redirect()->back(); 
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProjectAssignment()
    {
        $assignLists = AssignProject::where('delete_status', 0)->orderby('id', 'DESC')->paginate(10);
        $sites = Project::where('delete_status', 0)->get();

        $projects = [];
        $i = 0;
        
        foreach($assignLists as $assignList) 
        {
            $emp_array = json_decode($assignList->emp_arr);
            
            $datas = Employee::where('delete_status', 0)->whereIn('id', $emp_array)->select('name')->get();
            
            if ($datas) {
                $data = $datas;
            } else {
                $data = [];
            }
       
            $leader_arr = json_decode($assignList->leader_id);

            $leader = Employee::where('delete_status', 0)->whereIn('id', $leader_arr)->select('name')->get();

            if ($leader) {
                $leader_name = $leader;
            } else {
                $leader_name = [];
            }

            $rv_arr = json_decode($assignList->rv_arr);

            $rv = Employee::where('delete_status', 0)->whereIn('id', $rv_arr)->select('name')->get();

            if ($rv) {
                $rv_name = $rv;
            } else {
                $rv_name = [];
            }
               
            $project = Project::where('delete_status', 0)->where('id', $assignList->project_id)->select('name')->first();
                
            if ($project == null) {
                $proj = null;
            } else {
                $proj = $project->name;
            }

            if ($project == null) {
                $shift_name = null;
            } else {
                $shift_name = $project->shift_name;
            }

            $authority = Employee::where('delete_status', 0)->where('id', $assignList->authority_id)->select('name')->first();
                
            if ($authority == null) {
                $auth_name = null;
            } else {
                $auth_name = $authority->name;
            }
            
            $parttime = json_decode($assignList->part_time);

            $parttimes = PartTime::whereIn('id', $parttime)->select('name')->get();

            if ($parttimes) {
                $part = $parttimes;
            } else {
                $part = [];
            }
            
            $shift_name = $assignList->shift_name;
            $projects[$i] = [
                "id" => $assignList->id, 
                "leader_name" => $leader_name,
                "rv_name" => $rv_name,
                "project_name" => $proj,
                "shift_name" => $shift_name,
                "employee" => $data,
                "parttimes" => $part,
                "authority_id" => $assignList->authority_id,
                "authority_name" => $auth_name,
                "date_of_assignment" => $assignList->date_of_assignment,
            ];
            $i++;
        }

        return view('hrms.project.show-project-assignment', compact('projects', 'assignLists', 'sites'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditAssign($id)
    {
        $assigns = AssignProject::where('delete_status', 0)->where('id', $id)->first();
        $emps = Employee::where('delete_status', 0)->select('id', 'name')->get();
        $projects = project::where('delete_status', 0)->select('id', 'name')->get();
        $parttimes = PartTime::where('delete_status', 0)->select('id', 'name')->get();
        $emp_array = json_decode($assigns->emp_arr);
        $leader_arr = json_decode($assigns->leader_id);
        $rv_arr = json_decode($assigns->rv_arr);

        if ($leader_arr == null) {
            $leader_arr = [];
        }
        if ($rv_arr == null) {
            $rv_arr = [];
        }

        $shifts = Shift::select('id', 'name')->get();

        return view('hrms.project.edit-project-assignment', compact('assigns', 'emps', 'projects', 'emp_array', 'rv_arr', 'leader_arr', 'parttimes', 'shifts'));
    }

    /**
     * @param $id
     * @param Request $dd
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doEditAssign($id, Request $request)
    {
        $emp_arr = json_encode($request->emp_id); 
        $parttime = json_encode($request->parttime);
        $assignment = AssignProject::findOrFail($id);  

        $shift = Shift::find($request->shift_id);

        if ($shift) {
            $shiftName = $shift->name;
        } else {
            $shiftName = null;
        }

        $assignment->update([
            'project_id' => $request->project_id,
            'shift_id' => $request->shift_id,
            'shift_name' => $shiftName,
            'leader_id'=>json_encode($request->leader),
            'rv_arr' => json_encode($request->rv),
            'emp_arr' => $emp_arr,
            'part_time' => $parttime,
            'authority_id' => $request->authority_id,
            'date_of_assignment' => date_format(date_create($request->doa), 'Y-m-d'),
        ]);

        \Session::flash('flash_message', 'Assign site updated successfully.');
        return redirect('project-assignment-listing');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doDeleteAssign($id)
    {
        $assign = AssignProject::find($id);
        
        if ($assign) {
            $assign->update(['delete_status' => 1]);
        } else {
            \Session::flash('flash_message', 'Fail to Delete!');
            return redirect('project-assignment-listing');
        }

        \Session::flash('flash_message', 'Assign site deleted successfully.');
        return redirect('project-assignment-listing');
    }
    
    public function importFile()
    {
        return view('hrms.project.assign-upload');
    }
    
    public function uploadtFile(Request $request)
    {
        $files = Input::file('upload_file');

        foreach ($files as $file) {
            Excel::load($file, function ($reader) {
                $rows = $reader->get(['leader_id', 'project_id', 'emp_arr', 'authority_id', 'shift', 'date_of_assignment', 'date_of_release']);

                foreach ($rows as $row) {

                    $attachment = new AssignProject();

                    if (!empty($row->project_id)) 
                    {
                        $attachment->leader_id  = $row->leader_id;
                        $attachment->project_id = $row->project_id;
                        $attachment->emp_arr  = $row->emp_arr;
                        $attachment->authority_id = $row->authority_id;
                        $attachment->shift = $row->shift;
                        $attachment->date_of_assignment = $row->date_of_assignment;
                    
                        $attachment->save();
                    }
                }
                return 1;
            });
        }

        \Session::flash('success', ' Employee details uploaded successfully.');

        return redirect()->back();
    }
    
    public function searchassign(Request $request) 
    {
        $assignLists = AssignProject::leftJoin('projects', 'projects.id', '=', 'assign_projects.project_id')
            ->where('projects.name', 'LIKE', '%' . $request->keywords . '%')
            ->where('assign_projects.delete_status', 0)
            ->select('assign_projects.id as ass_id', 'assign_projects.*', 'projects.*')
            ->paginate(15);
            
        $sites = Project::where('delete_status', 0)->get();
        
        $projects = [];

        $i = 0;

        foreach($assignLists as $assignList) {
            
            $emp_array = json_decode($assignList->emp_arr);
            
            $datas = Employee::where('delete_status', 0)->whereIn('id', $emp_array)->select('name')->get();
            
            if ($datas) {
                $data = $datas;
            } else {
                $data = [];
            }
                 
            $leader_arr = json_decode($assignList->leader_id);

            $leader = Employee::where('delete_status', 0)->whereIn('id', $leader_arr)->select('name')->get();

            if ($leader) {
                $leader_name = $leader;
            } else {
                $leader_name = [];
            }
               
            $project = Project::where('id', $assignList->project_id)->select('name')->first();
                
            if ($project == null) {
                $proj = null;
            } else {
                $proj = $project->name;
            }

            $authority = Employee::where('delete_status', 0)->where('id', $assignList->authority_id)->select('name')->first();
                
            if ($authority == null) {
                $auth_name = null;
            } else {
                $auth_name = $authority->name;
            }
            
            $parttime = json_decode($assignList->part_time);

            $parttimes = PartTime::whereIn('id', $parttime)->select('name')->get();

            if ($parttimes) {
                $part = $parttimes;
            } else {
                $part = [];
            }
            
            $rv_arr = json_decode($assignList->rv_arr);
            
            $rv = Employee::where('delete_status', 0)->whereIn('id', $rv_arr)->select('name')->get();

            if ($rv) {
                $rv_name = $rv;
            } else {
                $rv_name = [];
            }

            $projects[$i] = [
                "id"=>$assignList->ass_id,
                "leader_name" => $leader_name,
                "project_name" => $proj,
                "employee" => $data,
                "authority_id" => $assignList->authority_id,
                "parttimes" => $part,
                "rv_name" => $rv_name,
                "authority_name" => $auth_name,
                "date_of_assignment" => $assignList->date_of_assignment,
                "date_of_release" => $assignList->date_of_release,
            ];
            
            $i++;
        }

        return view('hrms.project.show-project-assignment', compact('projects', 'assignLists', 'sites'));
    }
    
    public function searchAssignSite(Request $request)
    {
        $assignLists = AssignProject::leftJoin('projects', 'projects.id', '=', 'assign_projects.project_id')
            ->where('projects.id', $request->site_id)
            ->where('assign_projects.delete_status', 0)
            ->select('assign_projects.id as ass_id', 'assign_projects.*', 'projects.*')
            ->paginate(15);
            
        $sites = Project::where('delete_status', 0)->get();
        
        $projects = [];

        $i = 0;

        foreach($assignLists as $assignList) {
            
            $emp_array = json_decode($assignList->emp_arr);
            
            $datas = Employee::where('delete_status', 0)->whereIn('id', $emp_array)->select('name')->get();
            
            if ($datas) {
                $data = $datas;
            } else {
                $data = [];
            }
                 
            $leader_arr = json_decode($assignList->leader_id);

            $leader = Employee::where('delete_status', 0)->whereIn('id', $leader_arr)->select('name')->get();

            if ($leader) {
                $leader_name = $leader;
            } else {
                $leader_name = [];
            }
               
            $project = Project::where('id', $assignList->project_id)->select('name')->first();
                
            if ($project == null) {
                $proj = null;
            } else {
                $proj = $project->name;
            }

            $authority = Employee::where('delete_status', 0)->where('id', $assignList->authority_id)->select('name')->first();
                
            if ($authority == null) {
                $auth_name = null;
            } else {
                $auth_name = $authority->name;
            }
            
            $parttime = json_decode($assignList->part_time);

            $parttimes = PartTime::whereIn('id', $parttime)->select('name')->get();

            if ($parttimes) {
                $part = $parttimes;
            } else {
                $part = [];
            }
            
            $rv_arr = json_decode($assignList->rv_arr);
            
            $rv = Employee::where('delete_status', 0)->whereIn('id', $rv_arr)->select('name')->get();

            if ($rv) {
                $rv_name = $rv;
            } else {
                $rv_name = [];
            }

            $projects[$i] = [
                "id"=>$assignList->ass_id,
                "leader_name" => $leader_name,
                "project_name" => $proj,
                "employee" => $data,
                "authority_id" => $assignList->authority_id,
                "parttimes" => $part,
                "rv_name" => $rv_name,
                "authority_name" => $auth_name,
                "date_of_assignment" => $assignList->date_of_assignment,
                "date_of_release" => $assignList->date_of_release,
            ];
            
            $i++;
        }

        return view('hrms.project.show-project-assignment', compact('projects', 'assignLists', 'sites'));
    }
    
    public function searchProject(Request $request)
    {
        $projects = Project::where('name', 'LIKE', '%' . $request->keywords . '%')
                        ->orWhere('short_term', 'LIKE', '%' . $request->keywords . '%')
                        ->paginate(10);

        return view('hrms.projects.list', compact('projects'));
    }
}
