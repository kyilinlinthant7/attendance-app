<?php

namespace App\Http\Controllers;
use App\Shift;
use App\OverTime;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OverTimeController extends Controller
{
    public function addOvertime(Request $request)
    {
        $emps = Employee::get();
        $sites = Project::get();

        return view('hrms.overtime.add', compact('emps', 'sites'));
    }

    public function saveOverTime(Request $request)
    {
        $emp_arr = json_encode($request->emp);

        OverTime::create([
            'leader' => $request->leader,
            'site_id' => $request->site,
            'shift_id' => $request->shift_id,
            'emp_arr' => $emp_arr,
            'otdate' => $request->otdate,
            'ot_type' => $request->ot_type,
            'fromtime' => $request->timeFrom,
            'totime' => $request->timeTo,
            'content' => $request->content,
            'remark' => $request->remark,
            'completion_report' => $request->work
        ]);
        \Session::flash('flash_message', 'OverTime successfully Added!');
        return redirect()->route('overtime-list');
    }

    public function show()
    {
        $overtimes = Overtime::where('delete_status', 0)->orderby('id', 'DESC')->paginate(10);

        $ots = [];
        $i = 0;
        
        foreach ($overtimes as $overtime) {
            $emp_arr = json_decode($overtime->emp_arr);

            $emp = Employee::whereIn('id', $emp_arr)->select('name')->get();

            $led = Employee::where('id', $overtime->leader)->select('name')->first();

            if ($led) {
                $leader = $led->name;
            } else {
                $leader = '';
            }

            $sites = Project::where('id', $overtime->site_id)->select('name')->first();

            if ($sites) {
                $site = $sites->name;
            } else {
                $site = '';
            }

            $shifts = Shift::where('id', $overtime->shift_id)->select('name')->first();

            if ($shifts) {
                $shift = $shifts->name;
            } else {
                $shift = '';
            }

            $ots[$i] = [
                'id' => $overtime->id,
                'site_name' => $site,
                'shift' => $shift,
                'leader' => $leader,
                'emp' => $emp,
                'otdate' => $overtime->otdate,
                'ot_type' => $overtime->ot_type,
                'fromtime' => $overtime->fromtime,
                'totime' => $overtime->totime,
                'content' => $overtime->content,
                'remark' => $overtime->remark,
                'report' => $overtime->completion_report,
                'status' => $overtime->status
            ];
            $i++;
        }
        
        $sites = Project::get();
        
        $durations = [];
        $totalMinutes = 0;
        $timeEntries = Overtime::all();
        
        foreach ($timeEntries as $timeEntry) {
            $fromTime = Carbon::parse($timeEntry->fromtime);
            $toTime = Carbon::parse($timeEntry->totime);
            $duration = $fromTime->diff($toTime)->format('%H:%I');
            $durations[$timeEntry->id] = $duration;
        }

        foreach ($durations as $time) {
            // Convert each time string to Carbon instance
            $carbonTime = Carbon::parse($time);

            // Calculate the total minutes
            $totalMinutes += $carbonTime->hour * 60 + $carbonTime->minute;
        }

        // Convert total minutes back to hours and minutes
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        // Format the total time
        $totalTime = sprintf("%02d:%02d", $hours, $minutes);
        
        return view('hrms.overtime.list', compact('overtimes', 'ots', 'sites', 'shifts','totalTime'));
    }

    public function editOT($id) 
    {
        $emps = Employee::get();
        $sites = Project::get();
        $ot = OverTime::findOrFail($id);
        $emp_array = json_decode($ot->emp_arr);
        $selectedSite = Project::where('id', $ot->site_id)->select('id', 'name')->first();
        $shifts = $selectedSite ? $selectedSite->shifts()->select('id', 'name')->get() : collect();

        return view('hrms.overtime.edit', compact('emps', 'sites', 'ot', 'emp_array', 'shifts'));
    }

    public function processEditOt(Request $request, $id) 
    {
        $data = OverTime::findOrFail($id);
        $emp_arr = json_encode($request->emp);

        $data->update([
            'leader' => $request->leader,
            'site_id' => $request->site,
            'shift_id' => $request->shift_id,
            'emp_arr' => $emp_arr,
            'otdate' => $request->otdate,
            'ot_type' => $request->ot_type,
            'fromtime' => $request->timeFrom,
            'totime' => $request->timeTo,
            'content' => $request->content,
            'remark' => $request->remark,
            'completion_report' => $request->work
        ]);

        \Session::flash('flash_message', 'OverTime successfully Updated!');
        return redirect()->route('overtime-list');
    }

    public function deleteOvertime($id) 
    {
        $ot = OverTime::find($id);
        
        if ($ot) {
            $ot->update(['delete_status' => 1]);
        } else {
            \Session::flash('flash_message', 'Fail to Delete.');
            return redirect()->back();
        }

        \Session::flash('flash_message', 'OverTime successfully Deleted!');
        return redirect()->back();
    }

    public function searchOverTime(Request $request)
    {
        $overtimes = Overtime::leftjoin('projects','projects.id','=','over_times.site_id')
                ->leftjoin('employees','employees.id','=','over_times.leader')
                ->where('over_times.delete_status', 0)
                ->where('projects.name', 'LIKE', '%' . $request->keywords . '%')
                ->orWhere('employees.name', 'LIKE', '%' . $request->keywords . '%')
                ->select('over_times.id as oid','over_times.status as st','over_times.*','projects.*','employees.*')
                ->paginate(10);
        
        // new searches
        if ($request->searches) {
            if ($request->select_site) {
                $overtimes = Overtime::where('site_id', $request->select_site)
                  ->orderBy('id', 'DESC')
                  ->paginate(10);
            } 
            if ($request->select_shift) {
                $overtimes = Overtime::where('shift_id', $request->select_shift)
                  ->orderBy('id', 'DESC')
                  ->paginate(10);
            }
            if ($request->has('date_input')) {
                $dateInput = $request->date_input;
                $overtimes = Overtime::where(function ($query) use ($dateInput) {
                  $query->whereRaw("DATE_FORMAT(STR_TO_DATE(otdate, '%Y-%m-%d'), '%Y-%m-%d') = ?", [$dateInput])
                      ->orWhereRaw("DATE_FORMAT(STR_TO_DATE(otdate, '%d-%m-%Y'), '%Y-%m-%d') = ?", [$dateInput])
                      ->orWhereRaw("DATE_FORMAT(STR_TO_DATE(otdate, '%m/%d/%Y'), '%Y-%m-%d') = ?", [$dateInput])
                      ->orwhereRaw("DATE_FORMAT(STR_TO_DATE(otdate, '%W, %d-%m-%Y'), '%Y-%m-%d') = ?", [$dateInput]);
                })
                ->orderBy('id', 'DESC')
                ->paginate(10);
            }
        }

        $ots = [];
        $i = 0;
        
        foreach ($overtimes as $overtime) {
            $emp_arr = json_decode($overtime->emp_arr);
    
            $emp = Employee::whereIn('id', $emp_arr)->select('name')->get();
    
            $led = Employee::where('id', $overtime->leader)->select('name')->first();
    
            if ($led) {
                $leader = $led->name;
            } else {
                $leader = '';
            }
    
            $sites = Project::where('id', $overtime->site_id)->select('name')->first();
    
            if ($sites) {
                $site = $sites->name;
            } else {
                $site = '';
            }
            
            $shifts = Shift::where('id', $overtime->shift_id)->select('name')->first();

            if ($shifts) {
                $shift = $shifts->name;
            } else {
                $shift = 0;
            }
    
            $ots[$i] = [
                'id' => $overtime->id,
                'site_name' => $site,
                'shift' => $shift,
                'leader' => $leader,
                'emp' => $emp,
                'otdate' => $overtime->otdate,
                'ot_type' => $overtime->ot_type,
                'fromtime' => $overtime->fromtime,
                'totime' => $overtime->totime,
                'content' => $overtime->content,
                'remark' => $overtime->remark,
                'report' => $overtime->completion_report,
                'status' => $overtime->st
            ];
            $i++;
        }
        
        $sites = Project::all();
        $shifts = Shift::pluck('name')->toArray();
        
        $durations = [];
        $totalMinutes = 0;
        $timeEntries = Overtime::all();
        
        foreach ($timeEntries as $timeEntry) {
            $fromTime = Carbon::parse($timeEntry->fromtime);
            $toTime = Carbon::parse($timeEntry->totime);
            $duration = $fromTime->diff($toTime)->format('%H:%I');
            $durations[$timeEntry->id] = $duration;
        }

        foreach ($durations as $time) {
            // Convert each time string to Carbon instance
            $carbonTime = Carbon::parse($time);

            // Calculate the total minutes
            $totalMinutes += $carbonTime->hour * 60 + $carbonTime->minute;
        }

        // Convert total minutes back to hours and minutes
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        // Format the total time
        $totalTime = sprintf("%02d:%02d", $hours, $minutes);
        
        // $overtimes->appends(['keywords' => $request->keywords]);
        
        return view('hrms.overtime.list', compact('overtimes', 'ots', 'sites', 'shifts','totalTime'));
    }
    
    public function changeStatus(Request $request) 
    {   
        $id = $request->id;
        $data = OverTime::findOrFail($id);
        
        $data->update([
          'status' => $request->status,
        ]);

        return response()->json(['success' => "Status Changed"]);
    }
}
