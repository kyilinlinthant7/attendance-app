<?php

  namespace App\Http\Controllers;

  use App\Shift;
  use Carbon\Carbon;
  use Carbon\Exceptions\InvalidFormatException;
  use App\Models\Project;
  use App\Models\Employee;
  use App\Models\PartTime;
  use Illuminate\Http\Request;
  use App\Models\AssignProject;
  use App\Models\AttendanceManager;
  use App\Models\AttendanceFilename;
  use Maatwebsite\Excel\Facades\Excel;
  use Illuminate\Support\Facades\Input;
  use App\Repositories\UploadRepository;
  use App\Repositories\ExportRepository;
  use Illuminate\Support\Facades\Validator;
  use App\Repositories\ImportAttendanceData;
  use App\Repositories\ExportAttendanceData;

  class AttendanceController extends Controller
  {
    public $export;
    public $upload;
    public $attendanceData;
    protected $exportAttendanceData;

    /**
     * AttendanceController constructor.
     * @param ExportRepository $exportRepository
     * @param UploadRepository $uploadRepository
     * @param ImportAttendanceData $attendanceData
     */
    public function __construct(ExportRepository $exportRepository, UploadRepository $uploadRepository, ImportAttendanceData $attendanceData, ExportAttendanceData $exportAttendanceData)
    {
      $this->export = $exportRepository;
      $this->upload = $uploadRepository;
      $this->attendanceData = $attendanceData;
      $this->exportAttendanceData = $exportAttendanceData;
    }
    
    public function viewMap(Request $request)
    {
        $att_id = $request->id;
        
        $attendance = AttendanceFilename::find($att_id);
        
        return view('hrms.attendance.map_view',compact('attendance'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function importAttendanceFile()
    {
      return view('hrms.attendance.addattendance');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadFile(Request $request)
    {
      $files = Input::file('upload_file');

      foreach ($files as $file) {
        Excel::load($file, function ($reader) {
          $rows = $reader->get(['emp_arr', 'name', 'site', 'date', 'time', 'lat', 'long']);

          foreach ($rows as $row) {
      
            $attachment = new AttendanceFilename();
            
            if (!empty($row->site)) {
              $attachment->emp_arr = $row->emp_arr;

              $attachment->name = $row->name;

              $attachment->site = $row->site;

              $attachment->date = $row->date;
              $attachment->time = $row->time;

              $attachment->lat = $row->lat;
              $attachment->long = $row->long;
              
              $attachment->save();
            }  
          }
          return 1;
        });
    }

     \Session::flash('flash_message1', 'File successfully Uploaded!');
      return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSheetDetails()
    {
      $column = '';
      $string = '';
      $dateFrom = '';
      $dateTo = '';
      $attendances = AttendanceManager::paginate(20);
      return view('hrms.attendance.show_attendance_sheet_details', compact('attendances', 'column', 'string', 'dateFrom', 'dateTo'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doDelete($id)
    {
      $file = AttendanceFilename::find($id);
      
      if ($file) {
        $file->update(['delete_status' => 1]);
      } else {
        \Session::flash('flash_message1', 'Fail to Delete!');
        return redirect()->back();
      }

      \Session::flash('flash_message1', 'File successfully Deleted!');
      return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function searchAttendance(Request $request)
    {
        $sites = Project::where('delete_status', 0)->get();
        $checkStatus = '';
        $datas = collect();
        $counts = ['pending' => 0, 'confirm' => 0, 'approve' => 0];
    
        if ($request->has('date_input_from') && $request->has('date_input_to')) {
            
            $checkStatus = 'date input';
            $dateInputFrom = $request->date_input_from;
            $dateInputTo = date('Y-m-d', strtotime($request->date_input_to . ' +1 day'));
            
            if ($request->site_id) {
                
                $datas = AttendanceFilename::leftJoin('projects', 'projects.id', '=', 'attendance_filenames.site')
                    ->where('attendance_filenames.date', '>=', $dateInputFrom)
                    ->where('attendance_filenames.date', '<', $dateInputTo)
                    ->where('attendance_filenames.site', $request->site_id)
                    ->where('attendance_filenames.delete_status', 0)
                    ->orderBy('attendance_filenames.id', 'DESC')
                    ->paginate(300);
                    
                $countDatas = AttendanceFilename::leftJoin('projects', 'projects.id', '=', 'attendance_filenames.site')
                    ->where('attendance_filenames.date', '>=', $dateInputFrom)
                    ->where('attendance_filenames.date', '<', $dateInputTo)
                    ->where('attendance_filenames.site', $request->site_id)
                    ->where('attendance_filenames.delete_status', 0)
                    ->orderBy('attendance_filenames.id', 'DESC')
                    ->get();
                    
            } else {
                
                $datas = AttendanceFilename::where('date', '>=', $dateInputFrom)
                    ->where('date', '<', $dateInputTo)
                    ->where('delete_status', 0)
                    ->orderBy('id', 'DESC')
                    ->paginate(300);
                    
                $countDatas = AttendanceFilename::where('date', '>=', $dateInputFrom)
                    ->where('date', '<', $dateInputTo)
                    ->where('delete_status', 0)
                    ->orderBy('id', 'DESC')
                    ->get();
                    
            }
            
        } elseif ($request->date_filter == 'today') {
            
            $checkStatus = 'today';
            $todayDate = date('Y-m-d');
            
            if ($request->site_id) {
                
                $datas = AttendanceFilename::leftJoin('projects', 'projects.id', '=', 'attendance_filenames.site')
                    ->where('attendance_filenames.site', $request->site_id)
                    ->where('attendance_filenames.delete_status', 0)
                    ->where(function($query) use ($todayDate) {
                        $query->whereRaw("DATE_FORMAT(STR_TO_DATE(date, '%Y-%m-%d'), '%Y-%m-%d') = ?", [$todayDate])
                              ->orWhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d') = ?", [$todayDate])
                              ->orWhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%m/%d/%Y'), '%Y-%m-%d') = ?", [$todayDate])
                              ->orWhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%W, %d-%m-%Y'), '%Y-%m-%d') = ?", [$todayDate]);
                    })
                    ->orderBy('attendance_filenames.id', 'DESC')
                    ->paginate(300);
                
                $countDatas = AttendanceFilename::leftJoin('projects', 'projects.id', '=', 'attendance_filenames.site')
                    ->where('attendance_filenames.site', $request->site_id)
                    ->where('attendance_filenames.delete_status', 0)
                    ->where(function($query) use ($todayDate) {
                        $query->whereRaw("DATE_FORMAT(STR_TO_DATE(date, '%Y-%m-%d'), '%Y-%m-%d') = ?", [$todayDate])
                              ->orWhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d') = ?", [$todayDate])
                              ->orWhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%m/%d/%Y'), '%Y-%m-%d') = ?", [$todayDate])
                              ->orWhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%W, %d-%m-%Y'), '%Y-%m-%d') = ?", [$todayDate]);
                    })
                    ->orderBy('attendance_filenames.id', 'DESC')
                    ->get();

            } else {
                
                $datas = AttendanceFilename::where('delete_status', 0)
                    ->whereRaw("DATE_FORMAT(STR_TO_DATE(date, '%Y-%m-%d'), '%Y-%m-%d') = ?", [$todayDate])
                    ->orWhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d') = ?", [$todayDate])
                    ->orWhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%m/%d/%Y'), '%Y-%m-%d') = ?", [$todayDate])
                    ->orwhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%W, %d-%m-%Y'), '%Y-%m-%d') = ?", [$todayDate])
                    ->orderBy('id', 'DESC')
                    ->paginate(300);
                    
                $countDatas = AttendanceFilename::where('delete_status', 0)
                    ->whereRaw("DATE_FORMAT(STR_TO_DATE(date, '%Y-%m-%d'), '%Y-%m-%d') = ?", [$todayDate])
                    ->orWhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d') = ?", [$todayDate])
                    ->orWhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%m/%d/%Y'), '%Y-%m-%d') = ?", [$todayDate])
                    ->orwhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%W, %d-%m-%Y'), '%Y-%m-%d') = ?", [$todayDate])
                    ->orderBy('id', 'DESC')
                    ->get();
                    
            }
            
        } else {
            
            $checkStatus = 'all time';
            
            if ($request->site_id) {
        
                $datas = AttendanceFilename::leftJoin('projects', 'projects.id', '=', 'attendance_filenames.site')
                    ->where('attendance_filenames.site', $request->site_id)
                    ->where('attendance_filenames.delete_status', 0)
                    ->orderBy('attendance_filenames.id', 'DESC')
                    ->paginate(300);
                    
                $countDatas = AttendanceFilename::leftJoin('projects', 'projects.id', '=', 'attendance_filenames.site')
                    ->where('attendance_filenames.site', $request->site_id)
                    ->where('attendance_filenames.delete_status', 0)
                    ->orderBy('attendance_filenames.id', 'DESC')
                    ->get();
                    
            } else {
                
                $datas = AttendanceFilename::where('delete_status', 0)
                    ->orderBy('id', 'DESC')
                    ->paginate(300);
                    
                $countDatas = AttendanceFilename::where('delete_status', 0)
                    ->orderBy('id', 'DESC')
                    ->get();
                    
            }
        }
    
        // fetch all data for counts calculation
        $allDatas = AttendanceFilename::where('delete_status', 0)->get();
        $counts = [
            'pending' => $countDatas->where('status', 0)->count(),
            'confirm' => $countDatas->where('status', 1)->count(),
            'approve' => $countDatas->where('status', 2)->count()
        ];
    
        // prepare array for view
        $arr = [];
        foreach ($datas as $data) {
            $arr[] = [
                "id" => $data->id,
                "leader" => Employee::find($data->leader)->name ?? '',
                "site" => Project::find($data->site)->name ?? '',
                "shift" => Shift::find($data->shift_id)->name ?? '',
                "emp_arr" => Employee::whereIn('id', json_decode($data->emp_arr))->select('name')->get(),
                "parttime" => PartTime::whereIn('id', json_decode($data->part_time))->select('name')->get(),
                "date" => $data->date,
                "time" => $data->time,
                "status" => $data->status,
                "dayoff" => Employee::whereIn('id', json_decode($data->dayoff))->select('name')->get(),
                "rvs" => Employee::whereIn('id', json_decode($data->rv_arr))->select('name')->get()
            ];
        }
    
        return view('hrms.attendance.showattendance', compact('arr', 'datas', 'counts', 'checkStatus', 'sites'));
    }

    public function index(Request $request) 
    {
        $emps = Employee::select('id', 'name')->get();
        $sites = Project::select('id', 'name')->get();
        
        return view('hrms.attendance.addattendance', compact('emps', 'sites'));
    }

    public function addAttendence(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'leader' => 'required',
            'emp' => 'required',
            'date' => 'required',
            'time' => 'required'
        ]);

        if ($validator->fails()) {
            \Session::flash('flash_message', 'Fill Required Fields!');
            return redirect()->back();
        }

        $data = AttendanceFilename::create([
            'leader' => $request->leader,
            'emp_arr' => json_encode($request->emp),
            'dayoff' => json_encode($request->dayoff),
            'rv' => json_encode($request->rv),
            'site' => $request->site,
            'shift_id' => $request->shift_id,
            'date' => $request->date,
            'time' => $request->time,
            'lat' => $request->lat,
            'long' => $request->long
        ]);

          \Session::flash('flash_message', 'Attendance Succesfully Created!');
          return redirect()->back();

    }

    public function show(Request $request) 
    {
        $sites = Project::where('delete_status', 0)->get();
        
        $checkStatus = 'today';
        $date = $request->date_search;
      
        if (!$date) {
          $date = date('Y-m-d');
          $checkStatus = 'today';
            $todayDate = date('Y-m-d');
            $datas = AttendanceFilename::where(function ($query) use ($todayDate) {
                  $query->where("delete_status", 0)
                      ->whereRaw("DATE_FORMAT(STR_TO_DATE(date, '%Y-%m-%d'), '%Y-%m-%d') = ?", [$todayDate])
                      ->orWhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d') = ?", [$todayDate])
                      ->orWhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%m/%d/%Y'), '%Y-%m-%d') = ?", [$todayDate])
                      ->orwhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%W, %d-%m-%Y'), '%Y-%m-%d') = ?", [$todayDate]);
            })
            ->orderBy('id', 'DESC')
            ->where('delete_status', 0)
            ->paginate(300);
            
            $counts = [
                'pendingCount' => $datas->where('status', 0)->count(),
                'confirmCount' => $datas->where('status', 1)->count(),
                'approveCount' => $datas->where('status', 2)->count()
            ];
        }
        
        $datas = AttendanceFilename::where('date', $date)->where('delete_status', 0)->orderby('id','DESC')->paginate(300);
        $pendingCount = $datas->where("status", 0)->count();
        $confirmCount = $datas->where("status", 1)->count();
        $approveCount = $datas->where("status", 2)->count();
        $allDatas = AttendanceFilename::where('delete_status', 0)->orderby('id', 'DESC')->get();
        $checkStatus = 'today';
        $todayDate = date('Y-m-d');
        
        $datas = AttendanceFilename::where(function ($query) use ($todayDate) {
          $query->whereRaw("DATE_FORMAT(STR_TO_DATE(date, '%Y-%m-%d'), '%Y-%m-%d') = ?", [$todayDate])
              ->orWhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d') = ?", [$todayDate])
              ->orWhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%m/%d/%Y'), '%Y-%m-%d') = ?", [$todayDate])
              ->orwhereRaw("DATE_FORMAT(STR_TO_DATE(date, '%W, %d-%m-%Y'), '%Y-%m-%d') = ?", [$todayDate]);
        })
        ->orderBy('id', 'DESC')
        ->where('delete_status', 0)
        ->paginate(300);
        
        $counts = [
            'pending' => $datas->where('status', 0)->count(),
            'confirm' => $datas->where('status', 1)->count(),
            'approve' => $datas->where('status', 2)->count()
        ];

        $arr = [];
        $i = 0;
    
        foreach ($datas as $data) {
            
            $leader = Employee::where('id', $data->leader)->select('name')->first();
            
            if ($leader) {
                $led = $leader->name;
            } else {
                $led = '';
            }
        
            $site = Project::where('id', $data->site)->select('name')->first();
            if ($site) {
                $sit = $site->name;
            } else {
                $sit = '';
            }
            
            $shift = Shift::where('id', $data->shift_id)->select('name')->first();
    
            if ($shift) {
                $shi = $shift->name;
            } else {
                $shi = '';
            }

            $emps = json_decode($data->emp_arr);
            $emps = Employee::whereIn('id', $emps)->select('name')->get();
            $part_time = json_decode($data->part_time);
               
            $part = PartTime::whereIn('id', $part_time)->select('name')->get();
        
            if ($part) {
                $parttime = $part;
            } else {
                $parttime = [];
            }
      
            $rv_emps = json_decode($data->rv_arr);
              
            $rv = Employee::whereIn('id', $rv_emps)->select('name')->get();
        
            if ($rv) {
                $rvs = $rv;
            } else {
                $rvs = [];
            }
            
            $doffs = json_decode($data->dayoff);
        
            $off = Employee::whereIn('id', $doffs)->select('name')->get();
    
            if ($off) {
                $dayoff = $off;
            } else {
                $dayoff = [];
            }

            $arr[$i] = [
                "id" => $data->id,
                "leader" => $led,
                "site" => $sit,
                "shift" => $shi,
                "emp_arr" => $emps,
                'parttime'  => $parttime,
                'rvs' => $rvs,
                "date" => $data->date,
                "time" => $data->time,
                "status" => $data->status,
                "dayoff" => $dayoff
            ];
              
            $i++;
    
        }
     
        $attendances = json_encode($arr);      
        return view('hrms.attendance.showattendance', compact('attendances', 'arr', 'datas', 'counts', 'checkStatus', 'sites'));

    }
    
    public function edit($id) 
    {
      $emps = Employee::select('id', 'name')->get();
      $sites = Project::select('id', 'name')->get();
      $attendance = AttendanceFilename::findOrFail($id);
      $leader = Employee::where('id', $attendance->leader)->select('id', 'name')->first();
      $selectedSite = Project::where('id', $attendance->site)->select('id', 'name')->first();
      $emp = json_decode($attendance->emp_arr);
      $emp_arr = Employee::whereIn('id', $emp)->select('id', 'name')->get();

      $shifts = $selectedSite ? $selectedSite->shifts()->select('id', 'name')->get() : collect();
      
      $off = json_decode($attendance->dayoff);
      $rv_emp = json_decode($attendance->rv_arr);

      $dayoffs = Employee::whereIn('id', $off)->select('id', 'name')->get();
      $rvs = Employee::whereIn('id', $rv_emp)->select('id', 'name')->get();

      return view('hrms.attendance.editattendance', compact('emps', 'sites', 'shifts', 'attendance', 'leader', 'selectedSite', 'emp_arr', 'dayoffs', 'rvs'));

    }

    public function editAttendance(Request $request, $id) {
      $validator = Validator::make($request->all(), [
        'leader' => 'required',
        'emp' => 'required',
        'date' => 'required',
        'time' => 'required'
      ]);

      if ($validator->fails()) {
          \Session::flash('flash_message', 'Fill Required Fields!');
          return redirect()->back();
      }

      $att = AttendanceFilename::findOrFail($id);

      $att->update([
          'leader' => $request->leader,
          'emp_arr' => json_encode($request->emp),
          'dayoff' => json_encode($request->dayoff),
          'site' => $request->site,
          'shift_id' => $request->shift_id,
          'date' => $request->date,
          'time' => $request->time,
          'lat' => $request->lat,
          'long' => $request->long
      ]);

      \Session::flash('flash_message', 'Attendance Successfully Updated');
          return redirect('showattendance');
    }

    public function deleteAtt($id) 
    {
        $att = AttendanceFilename::find($id);
        
        if ($att) {
            // AttendanceFilename::destroy($id);
            $att->update(['delete_status' => 1]);
        } else {
            \Session::flash('flash_message', 'Fail to delete!');
            return redirect('showattendance');
        }
        
        \Session::flash('flash_message', 'Attendance Successfully Deleted.');
        return redirect('showattendance');
    }
    
    public function changeStatus(Request $request) {
          $validator = Validator::make($request->all(), [
            'status' => 'required',
            'id' => 'required',
          ]);
    
          $id = $request->id;
    
          $data = AttendanceFileName::findOrFail($id);
          $data->update([
            'status' => $request->status,
          ]);
          return response()->json(['success' => "Status Changed"]);
    }
    
    public function att(Request $request) {

       $data = AssignProject::where('project_id', $request->id)->select('leader_id', 'emp_arr')->first();

       $led = json_decode($data->leader_id);
       $leader = Employee::whereIn('id', $led)->select('id', 'name')->get();

       $emps_arr = json_decode($data->emp_arr);
       $emps = Employee::whereIn('id', $emps_arr)->select('id', 'name')->get();

       $all_leater = Employee::select('id', 'name')->get();

       return response()->json([$leader, $emps, $all_leater]);
       
    }
    
    public function attExport()
    {
        return $this->exportAttendanceData->export();
    }

 }