<?php

  namespace App\Http\Controllers;

  use App\Models\Employee;
  use App\Models\LeaveType;
  use App\Models\LeaveApply;
  use App\Models\LeaveRecord;
  use App\Models\AssignProject;
  use App\Models\Project;
  use App\Shift;
  use App\User;
  use Illuminate\Contracts\Mail\Mailer;
  use Illuminate\Http\Request;
  use Illuminate\Support\Str;

  class LeaveController extends Controller
  {
    /**
     * LeaveController constructor.
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
      $this->mailer = $mailer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addLeaveType()
    {
      return view('hrms.leave.add_leave_type');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    Public function processLeaveType(Request $request)
    {
      $leave = new LeaveType;
      $leave->leave_type = $request->leave_type;
      $leave->description = $request->description;
      $leave->save();

      \Session::flash('flash_message', 'Leave Type successfully added!');
      return redirect()->back();

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLeaveType()
    {
      $leaves = LeaveType::paginate(10);
      return view('hrms.leave.show_leave_type', compact('leaves'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEdit($id)
    {
      $result = LeaveType::whereid($id)->first();
      return view('hrms.leave.add_leave_type', compact('result'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    Public function doEdit(Request $request, $id)
    {
      $leave_type = $request->leave_type;
      $description = $request->description;

      $edit = LeaveType::findOrFail($id);
      if (!empty($leave_type)) {
        $edit->leave_type = $leave_type;
      }
      if (!empty($description)) {
        $edit->description = $description;
      }
      $edit->save();

      \Session::flash('flash_message', 'Leave Type successfully updated!');
      return redirect('leave-type-listing');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doDelete($id)
    {
      $leave = LeaveType::find($id);
      
      if ($leave) {
          $leave->delete_status = 1;
      } else {
          \Session::flash('flash_message1', 'Fail to Delete!');
          return redirect('leave-type-listing');
      }
      
      \Session::flash('flash_message1', 'Leave Type successfully Deleted!');
      return redirect('leave-type-listing');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function doApply()
    {
      $emps = Employee::select('id', 'name')->get();
      $sites = Project::select('id', 'name')->get();
      $leaves = LeaveType::get();

      return view('hrms.leave.apply_leave', compact('leaves', 'emps', 'sites'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processApply(Request $request)
    {
        $images = $request->file('photo');
        $all_values_null = true;
        $shift = Shift::where('id', $request->shift_id)->first();

        foreach ($images as $image) {
            if ($image !== null) {
                $all_values_null = false;
                break;
            }
        }
        if (!$all_values_null) {
            foreach ($images as $image) {
              if (isset($image)) {
                $name = Str::random(10).'.'.$image->extension();
                $image->move(public_path().'/medicalleave/', $name);
                $data[] = $name;
              }
            }   
            
        } else {
          $data = [];
        }
        
        $photo = json_encode($data);
      
      $data = LeaveApply::create([
          'leader' => $request->leader,
          'emp_id' => $request->emp,
          'site_id' => $request->site,
          'shift_id' => $request->shift_id,
          'leave_type' => $request->leave_type,
          'dateFrom' => $request->dateFrom,
          'dateTo' => $request->dateTo,
          'total' => $request->total,
          'date_claim' => $request->claimdate,
          'content' => $request->content,
          'photo' => $photo
      ]);

      \Session::flash('flash_message', 'Leave successfully applied!');
      return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showMyLeave()
    {

      $datas = LeaveApply::where('delete_status', 0)->orderby('id', 'DESC')->paginate(10);
        
      $leaves = [];
      $i = 0;
      
      foreach ($datas as $data) {
          
        $leader_id = $data->leader;

        $leader_name = Employee::where('id', $leader_id)->select('name')->first();

       if ($leader_name) {
           $leader = $leader_name->name;
       } else {
            $leader  = '';
       }
       
       $emps = Employee::where('id', $data->emp_id)->select('name')->first();
       
       if ($emps) {
           $emp = $emps->name;
       } else {
            $emp = '';
       }
       
       $siteName = Project::where('id', $data->site_id)->select('name')->first();
       
       if ($siteName) {
           $site = $siteName->name;
       } else {
           $site = '';
       }

        $leaves[$i] = [
          'id' => $data->id,
          'leader' =>  $leader,
          'name' => $emp,
          'site_name' => $site,
          'leavetype' => $data->leave_type,
          'dateFrom' => $data->dateFrom,
          'dateTo' => $data->dateTo,
          'total' => $data->total,
          'claim' => $data->date_claim,
          'content' => $data->content,
          'cc_remark' => $data->cc_remark,
          'hr_remark' => $data->hr_remark,
          'manager_status' => $data->manager_status,
          'hr_status' => $data->hr_status,
          'status' => $data->status,
          'emp_id' => $data->emp_id,
        ];

        $i++;

      }
      return view('hrms.leave.show_my_leaves', compact('leaves', 'datas'));
    }


    public function applyLeaveEdit(Request $request, $id) 
    {
      $emps = Employee::select('id', 'name')->get();
      $leaves = LeaveType::get();
      $applyLeave = LeaveApply::findOrFail($id);
      $sites = Project::select('id','name')->get();

      return view('hrms.leave.edit_apply_leave', compact('emps', 'leaves', 'sites', 'applyLeave'));
    }
    
    
    public function editLeaveApply(Request $request,$id) 
    {
        $data = LeaveApply::findOrFail($id);

        $images = $request->file('photo');
        $all_values_null = true;
        foreach ($images as $image) {
            if ($image !== null) {
                $all_values_null = false;
                break;
            }
        }
        if (!$all_values_null) {
            foreach ($images as $image) {
              if (isset($image)) {
                $name = Str::random(10).'.'.$image->extension();
                $image->move(public_path().'/medicalleave/', $name);
                $img[] = $name;
              }
            }   
            $photo=json_encode($img);  
        } else { 
          $photo = $data->photo;
        }

        $data->update([
          'leader' => $request->leader,
          'emp_id' => $request->emp,
          'site_id' => $request->site,
          'leave_type' => $request->leave_type,
          'dateFrom' => $request->dateFrom,
          'dateTo' => $request->dateTo,
          'total' => $request->total,
          'date_claim' => $request->claimdate,
          'content' => $request->content,
          'cc_remark' => $request->cc_remark,
          'hr_remark' => $request->hr_remark,
          'photo' => $photo,
        ]);

      \Session::flash('flash_message', 'Leave Successfully updated');
        return redirect()->back();
    }
    
    public function deleteLeave($id) 
    {
        $leave = LeaveApply::find($id);
        
        if ($leave) {
            $leave->update(['delete_status' => 1]);
        } else {
            \Session::flash('flash_message', 'Fail to Delete.');
            return redirect()->back();
        }
        
        \Session::flash('flash_message', 'Leave Successfully Deleted!');
        return redirect()->back();
    }
    
    public function searchLeave(Request $request) 
    {
      $datas = LeaveApply::leftjoin('employees','employees.id',' = ','leave_applies.emp_id')
          ->leftjoin('projects','projects.id',' = ','leave_applies.site_id')
          ->where('employees.name', 'LIKE', '%' . $request->keywords . '%')
          ->orWhere('projects.name','LIKE', '%' . $request->keywords . '%')
          ->orWhere('leave_applies.leave_type', 'LIKE', '%' . $request->keywords . '%')
          ->orWhere('leave_applies.date_claim','LIKE', '%' . $request->keywords . '%')
          ->select('leave_applies.id as apid','employees.*','projects.*','leave_applies.*')
          ->paginate(10);
     
      $leaves = [];
      $i = 0;
      foreach ($datas as $data) {
        $leader_id = $data->leader;

        $leader_name = Employee::where('id',$leader_id)->select('name')->first();

        if ($leader_name) {
          $led_name = $leader_name->name;
        } else {
          $led_name = '';
        }

        $leaves[$i] = [
          'id' => $data->apid,
          'leader' => $led_name,
          'name' => $data->employees->name,
          'leavetype' => $data->leave_type,
          'dateFrom' => $data->dateFrom,
          'dateTo' => $data->dateTo,
          'total' => $data->total,
          'claim' => $data->date_claim,
          'content' => $data->content,
          'cc_remark' => $data->cc_remark,
          'hr_remark' => $data->hr_remark,
          'manager_status' => $data->manager_status,
          'hr_status' => $data->hr_status,
          'status' => $data->status,
          'emp_id' => $data->emp_id,
        ];

        $i++;

      }
      return view('hrms.leave.show_my_leaves', compact('leaves','datas'));
    }
    
    
    public function viewLeave($id)
    {
      $data = LeaveApply::findOrFail($id);

      $leader = Employee::where('id', $data->leader)->select('name')->first();
      if ($leader) {
        $led = $leader->name;
      } else {
        $led = '';
      }

      $emps = Employee::where('id', $data->emp_id)->select('name')->first();
      if ($emps) {
        $emp = $emps->name;
      } else {
        $emp = '';
      }

      $sites = Project::where('id', $data->site_id)->select('name')->first();
      if ($sites) {
        $site = $sites->name;
      } else {
        $site = '';
      }

      $images = json_decode($data->photo);

      if ($images) {
        $image = $images;
      } else {
        $image = [];
      }

     $leave[0] = [
          'leader' => $led,
          'employee' => $emp,
          'site' => $site,
          'leave_type' => $data->leave_type,
          'dateFrom' => $data->dateFrom,
          'dateTo' => $data->dateTo,
          'total' => $data->total,
          'date_claim' => $data->date_claim,
          'content' => $data->content,
          'cc_remark' => $data->cc_remark,
          'hr_remark' => $data->hr_remark,
          'image' => $image,
          'manager_status' => $data->manager_status,
          'hr_status' => $data->hr_status,
          'status' => $data->status
     ];

      return view('hrms.leave.view', compact('leave', 'image'));
    }


#------------------------------------------------------------Levae Record---------------------------------------------------------------------
    
    public function addLeaveRecord(Request $request) 
    {
      $emps = Employee::select('id', 'name')->get();
      return view('hrms.leave.add_leave_record', compact('emps'));
    }

    public function saveLeaveRecord(Request $request) 
    {
      LeaveRecord::create([
        'employee_id' => $request->name,
        'casual_leave' => $request->casual,
        'earned_leave' => $request->earned,
        'medical_leave' => $request->medical,
        'maternity_leave' => $request->maternity,
        'paternity_leave' => $request->paternity,
        'compassionate_leave' => $request->compassionate,
        'without_pay_leave' => $request->withoutpay,
        'absent_leave' => $request->absent,
        'remark' => $request->remark
      ]);

      \Session::flash('flash_message', 'Leave Record successfully Add');

      return redirect()->route('leave-record');
    }

    public function editleaveRecord(Request $request, $id) 
    {
      $leave = LeaveRecord::findOrFail($id);
      $emps = Employee::select('id','name')->get();

      return view('hrms.leave.edit_leave_record', compact('emps', 'leave'));
    }

    public function saveEditLeaveRecord(Request $request, $id) 
    {
      $data = LeaveRecord::findOrFail($id);

      $data->update([
        'employee_id' => $request->name,
        'casual_leave' => $request->casual,
        'earned_leave' => $request->earned,
        'medical_leave' => $request->medical,
        'maternity_leave' => $request->maternity,
        'paternity_leave' => $request->paternity,
        'compassionate_leave' => $request->compassionate,
        'without_pay_leave' => $request->withoutpay,
        'absent_leave' => $request->absent,
        'remark' => $request->remark
      ]);

      \Session::flash('flash_message', 'Leave Record successfully Update');
      return redirect()->route('leave-record');
    }

    
    
    public function leaverecord(Request $request) 
    {
      $leaves = LeaveRecord::leftjoin('employees', 'employees.id', ' = ', 'leave_record.employee_id')->paginate(15);
      
      $column = '';
      $string = '';
      $dateFrom = '';
      $dateTo = '';
      
      return view('hrms.leave.leave_record', compact('leaves', 'column', 'string'));
    }
    
    public function deleteLeaveRecord($id) 
    {
      LeaveRecord::destroy($id);

      \Session::flash('flash_message', 'Leave Record successfully Deleted');
      return redirect()->route('leave-record');
    }

    public function searchLeaveRecord(Request $request) 
    {
      $leaves = LeaveRecord::leftjoin('employees','employees.id',' = ','leave_record.employee_id')
          ->where('employees.name', 'LIKE', '%' . $request->keywords . '%')
          ->paginate(15);
      
      $column = '';
      $string = '';
      $dateFrom = '';
      $dateTo = '';
      return view('hrms.leave.leave_record', compact('leaves', 'column', 'string'));
    }
    
    public function changeStatus(Request $request) 
    {
        $id = $request->id;
        $status = $request->status;
        $data = LeaveApply::findOrFail($id);

        if ($status == 1 || $status == 0 || $status == 3) {
            $data->update([
                'status' => $status,
            ]);

            return response()->json(['success' => "Status Changed"]);
        } else {
            $data->update([
                'status' => $status
            ]);
      
            $leaverecord = LeaveRecord::where('employee_id', $request->emp)->first();
      
            if ($leaverecord) {
      
            $data = LeaveRecord::findOrFail($leaverecord->id);
      
            if ($request->leave_type == 'Casual Leave') {
                $day = ($data->casual_leave)-($request->total);
          
                $data->update([
                    'casual_leave' => $day
                ]);
      
            } elseif ($request->leave_type == 'Earned Leave') {
                $day = ($data->earned_leave)-($request->total);
                $data->update([
                  'earned_leave' => $day
                ]);
            } elseif ($request->leave_type == 'Medical Leave') {
                $day = ($data->cmedical_leave)-($request->total);
                $data->update([
                  'medical_leave' => $day
                ]);
            } elseif ($request->leave_type == 'Maternity Leave') {
                $day = ($data->maternity_leave)-($request->total);
                $data->update([
                  'maternity_leave' => $day
                ]);
            } elseif ($request->leave_type == 'Paternity Leave') {
                $day = ($data->paternity_leave)-($request->total);
                $data->update([
                  'paternity_leave' => $day
                ]);
            } elseif ($request->leave_type == 'Compassionate Leave') {
                $day = ($data->compassionate_leave)-($request->total);
                $data->update([
                  'compassionate_leave' => $day
                ]);
            } elseif ($request->leave_type == 'WithoutPay Leave') {
                $day = ($data->without_pay_leave)-($request->total);
                $data->update([
                  'without_pay_leave' => $day
                ]);
            }

              return response()->json(['success' => "Status Changed"]);
            }
        }
    }
   
  }

