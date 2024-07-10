<?php

namespace App\Repositories;

use App\Models\AttendanceFilename;
use App\Models\Employee; 
use App\Models\LeaveApply; 
use App\OverTime; 
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ExportEmployeeDetail
{
    public function export($dateFrom, $dateTo)
    {
        try {
            $employees = Employee::where('delete_status', 0)->get();
            
            if ($employees->isEmpty()) {
                return response()->json(['error' => 'No employee data found.'], 404);
            }
            
            $excelData = []; 
            
            foreach ($employees as $emp) {
                
                $emid = ["$emp->id"];
                $employee_id = json_encode($emid);
                
                $attendanceToday = AttendanceFilename::where('delete_status', 0)
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->whereRaw('JSON_CONTAINS(emp_arr, ?)', [$employee_id])
                ->get();
                
                $isAttendance = $attendanceToday->isEmpty();
                
                $isLeave = LeaveApply::where('delete_status', 0)
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->where('emp_id', $emp->id)
                ->first();
                
                $casual = ''; $earn = ''; $medical = ''; $mater = ''; $pater = ''; $other = ''; $absent = ''; $totalDays = '';
                if ($isLeave) 
                {
                    $totalDays = $isLeave->total ?? 0;
                    
                    switch ($isLeave->leave_type) {
                        case 'Casual Leave':
                            $casual = $totalDays;
                            break;
                        case 'Earned Leave':
                            $earn = $totalDays;
                            break;
                        case 'Medical Leave':
                            $medical = $totalDays;
                            break;
                        case 'Maternity Leave':
                            $mater = $totalDays;
                            break;
                        case 'Paternity Leave':
                            $pater = $totalDays;
                            break;
                        case 'Other Leave':
                            $other = $totalDays;
                            break;
                        default:
                            $absent = '1';
                            break;
                    }
                }
                
                $dayoffToday = AttendanceFilename::where('delete_status', 0)
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->whereRaw('JSON_CONTAINS(dayoff, ?)', [$employee_id])
                ->get();
                $isNotDayOff = $dayoffToday->isEmpty();
                
                $overtime = OverTime::where('delete_status', 0)
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->whereRaw('JSON_CONTAINS(emp_arr, ?)', [$employee_id])
                ->first();
                
                $normal = ''; $dayoff = ''; $holiday = ''; $otTime = '';
                
                if ($overtime) {
                    
                    $fromTime = Carbon::parse($overtime["fromtime"]);
                    $toTime = Carbon::parse($overtime["totime"]);
                    
                    if ($toTime->lessThan($fromTime)) {
                        $toTime->addDay();
                    }
                    
                    $diffInMinutes = $toTime->diffInMinutes($fromTime);
                    
                    $hours = floor($diffInMinutes / 60);
                    $minutes = $diffInMinutes % 60;
                    
                    $otTime = sprintf('%02d:%02d', $hours, $minutes);
                    
                   if ($overtime->ot_type == "0") {
                        $normal = $otTime;
                    } elseif ($overtime->ot_type == "1") {
                        $dayoff = $otTime;
                    } elseif ($overtime->ot_type == "2") {
                        $holiday = $otTime;
                    } 
                }
                
                $startDate = Carbon::createFromFormat('Y-m-d', $dateFrom);
                $endDate = Carbon::createFromFormat('Y-m-d', $dateTo);
                
                for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                    
                    $dateFilterFormat = $date->format('d-m-Y');
                
                    $excelData[] = [
                        "Emp No." => $emp->employee_id,
                        "AC-No." => "",
                        'Name' => $emp->name,
                        'Position' => $emp->position,
                        'Join Date' => $emp->date_of_joining,
                        'Service Year' => $emp->service,
                        'Gender' => $emp->gender,
                        'Auto-Assign' => "",
                        'Date' => $dateFilterFormat,
                        'Shift Assign' => "",
                        'On Duty' => "",
                        'Off Duty' => "",
                        'Check In' => "",
                        'Check Out' => "",
                        'Normal' => "",
                        'Late minutes' => "",
                        'Early' => "",
                        'Absent' => $absent,
                        'OT Time' => $otTime,
                        "Work Time" => "",
                        "Exception" => "",
                        "Must C/In" => "",
                        "Must C/Out" => "",
                        "Department" => $emp->department,
                        "Sub Department" => $emp->sub_department,
                        "Site Name" => $emp->site_name,
                        "Location" => $emp->location,
                        "Business Unit" => $emp->business_sbu_name,
                        "Status" => $emp->status,
                        "NDays" => $isAttendance ? "" : "1",
                        "Off Days" => $isNotDayOff ? "" : "1",
                        "Holiday" => "",
                        "ATT_Time" => "",
                        "NDays_OT" => $normal,
                        "Day_Off_OT" => $dayoff,
                        "Holiday_OT" => $holiday,
                        "Total Leave" => $totalDays,
                        "CL" => $casual,
                        "EL" => $earn,
                        "ML" => $medical,
                        "MnL" => $mater,
                        "PnL" => $pater,
                        "WPL" => $other,
                    ];
                }
            }

            return Excel::create('employees_detail', function ($excel) use ($excelData) {
                $excel->sheet('Sheet 1', function ($sheet) use ($excelData) {
                    $sheet->fromArray($excelData);
                });
            })->download('xlsx');             
                        
        } catch (\Exception $e) {
            \Log::error('Error exporting data:', [$e->getMessage()]);
            return response()->json(['error' => 'Error exporting employee data.'], 500);
        }
    }
}
