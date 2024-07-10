<?php

namespace App\Repositories;

use App\Models\AttendanceFilename;
use App\Models\Employee; 
use App\Models\LeaveApply; 
use App\OverTime; 
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ExportEmployeeSummary
{
    public function export($monthFilter)
    {
        try {
            $employees = Employee::where('delete_status', 0)->get();
            
            if ($employees->isEmpty()) {
                return response()->json(['error' => 'No employee data found.'], 404);
            }
            
            $excelData = []; 
            
            foreach ($employees as $emp) {
                
                $emid = ["$emp->id"];
                $employeeId = json_encode($emid);
                
                $resignDate = "";
                $lastDate = "";
                
                if ($emp->status == 'Resign') {
                    $resignDate = $emp->status_date_from;
                    $lastDate = $emp->status_date_to;
                }
                
                if ($monthFilter) {
                    [$year, $month] = explode('-', $monthFilter);
                } else {
                    $year = date('Y');
                    $month = date('m');
                }
                
                $totalDays = date('t', mktime(0, 0, 0, $month, 1, $year));
                
                $totalAttendanceDays = AttendanceFilename::where('delete_status', 0)
                    ->whereRaw('JSON_CONTAINS(emp_arr, ?)', [$employeeId])
                    ->whereYear('created_at', '=', Carbon::parse($monthFilter)->year)
                    ->whereMonth('created_at', '=', Carbon::parse($monthFilter)->month)
                    ->count();
                    
                $totalOffDays = AttendanceFilename::where('delete_status', 0)
                    ->whereRaw('JSON_CONTAINS(dayoff, ?)', [$employeeId])
                    ->whereYear('created_at', '=', Carbon::parse($monthFilter)->year)
                    ->whereMonth('created_at', '=', Carbon::parse($monthFilter)->month)
                    ->count();
                    
                $totalCasualLeaveDays = LeaveApply::where('delete_status', 0)
                    ->where('emp_id', $emp->id)
                    ->where('leave_type', 'Casual Leave')
                    ->whereYear('dateFrom', '=', Carbon::parse($monthFilter)->year)
                    ->whereMonth('dateFrom', '=', Carbon::parse($monthFilter)->month)
                    ->sum('total');
                $formattedTotalCasualLeaveDays = number_format($totalCasualLeaveDays, 1);
                if ($formattedTotalCasualLeaveDays == (int)$totalCasualLeaveDays) {
                    $formattedTotalCasualLeaveDays = (int)$totalCasualLeaveDays;
                }
                
                $totalEarnLeaveDays = LeaveApply::where('delete_status', 0)
                    ->where('emp_id', $emp->id)
                    ->where('leave_type', 'Earn Leave')
                    ->whereYear('dateFrom', '=', Carbon::parse($monthFilter)->year)
                    ->whereMonth('dateFrom', '=', Carbon::parse($monthFilter)->month)
                    ->sum('total');
                $formattedTotalEarnLeaveDays = number_format($totalEarnLeaveDays, 1);
                if ($formattedTotalEarnLeaveDays == (int)$totalEarnLeaveDays) {
                    $formattedTotalEarnLeaveDays = (int)$totalEarnLeaveDays;
                }
                
                $totalMedicalLeaveDays = LeaveApply::where('delete_status', 0)
                    ->where('emp_id', $emp->id)
                    ->where('leave_type', 'Medical Leave')
                    ->whereYear('dateFrom', '=', Carbon::parse($monthFilter)->year)
                    ->whereMonth('dateFrom', '=', Carbon::parse($monthFilter)->month)
                    ->sum('total');
                $formattedTotalMedicalLeaveDays = number_format($totalMedicalLeaveDays, 1);
                if ($formattedTotalMedicalLeaveDays == (int)$totalMedicalLeaveDays) {
                    $formattedTotalMedicalLeaveDays = (int)$totalMedicalLeaveDays;
                }
                
                $totalMaternityLeaveDays = LeaveApply::where('delete_status', 0)
                    ->where('emp_id', $emp->id)
                    ->where('leave_type', 'Medical Leave')
                    ->whereYear('dateFrom', '=', Carbon::parse($monthFilter)->year)
                    ->whereMonth('dateFrom', '=', Carbon::parse($monthFilter)->month)
                    ->sum('total');
                $formattedTotalMaternityLeaveDays = number_format($totalMaternityLeaveDays, 1);
                if ($formattedTotalMaternityLeaveDays == (int)$totalMaternityLeaveDays) {
                    $formattedTotalMaternityLeaveDays = (int)$totalMaternityLeaveDays;
                }
                
                $totalPaternityLeaveDays = LeaveApply::where('delete_status', 0)
                    ->where('emp_id', $emp->id)
                    ->where('leave_type', 'Medical Leave')
                    ->whereYear('dateFrom', '=', Carbon::parse($monthFilter)->year)
                    ->whereMonth('dateFrom', '=', Carbon::parse($monthFilter)->month)
                    ->sum('total');
                $formattedTotalPaternityLeaveDays = number_format($totalPaternityLeaveDays, 1);
                if ($formattedTotalPaternityLeaveDays == (int)$totalPaternityLeaveDays) {
                    $formattedTotalPaternityLeaveDays = (int)$totalPaternityLeaveDays;
                }
                
                $totalOtherLeaveDays = LeaveApply::where('delete_status', 0)
                    ->where('emp_id', $emp->id)
                    ->where('leave_type', 'Other Leave')
                    ->whereYear('dateFrom', '=', Carbon::parse($monthFilter)->year)
                    ->whereMonth('dateFrom', '=', Carbon::parse($monthFilter)->month)
                    ->sum('total');
                $formattedTotalOtherLeaveDays = number_format($totalOtherLeaveDays, 1);
                if ($formattedTotalOtherLeaveDays == (int)$totalOtherLeaveDays) {
                    $formattedTotalOtherLeaveDays = (int)$totalOtherLeaveDays;
                }
                
                $totalAbsentDays = LeaveApply::where('delete_status', 0)
                    ->where('emp_id', $emp->id)
                    ->where('leave_type', 'Absent')
                    ->whereYear('dateFrom', '=', Carbon::parse($monthFilter)->year)
                    ->whereMonth('dateFrom', '=', Carbon::parse($monthFilter)->month)
                    ->sum('total');
                $formattedTotalAbsentDays = number_format($totalAbsentDays, 1);
                if ($formattedTotalAbsentDays == (int)$totalAbsentDays) {
                    $formattedTotalAbsentDays = (int)$totalAbsentDays;
                }
                
                $totalNormalDaysOt = OverTime::where('delete_status', 0)
                    ->whereRaw('JSON_CONTAINS(emp_arr, ?)', [$employeeId])
                    ->where('ot_type', 0)
                    ->whereYear('otdate', '=', Carbon::parse($monthFilter)->year)
                    ->whereMonth('otdate', '=', Carbon::parse($monthFilter)->month)
                    ->count();
                    
                $totalDayoffOt = OverTime::where('delete_status', 0)
                    ->whereRaw('JSON_CONTAINS(emp_arr, ?)', [$employeeId])
                    ->where('ot_type', 1)
                    ->whereYear('otdate', '=', Carbon::parse($monthFilter)->year)
                    ->whereMonth('otdate', '=', Carbon::parse($monthFilter)->month)
                    ->count();
                    
                $totalHolidayOt = OverTime::where('delete_status', 0)
                    ->whereRaw('JSON_CONTAINS(emp_arr, ?)', [$employeeId])
                    ->where('ot_type', 2)
                    ->whereYear('otdate', '=', Carbon::parse($monthFilter)->year)
                    ->whereMonth('otdate', '=', Carbon::parse($monthFilter)->month)
                    ->count();

                $excelData[] = [
                    "Emp No." => $emp->employee_id,
                    "AC-No." => "",
                    'Name' => $emp->name,
                    'Position' => $emp->position,
                    'Department' => $emp->department,
                    'Sub Department' => $emp->sub_department,
                    'Site Name' => $emp->site_name,
                    'Location' => $emp->region_city,
                    'Business Unit' => $emp->business_sbu_name,
                    'Status' => $emp->status,
                    'Join Date' => $emp->date_of_joining,
                    'Confirmation Date' => "",
                    'Resign Date' => $resignDate,
                    'Last Date' => $lastDate,
                    'Service Year' => $emp->service,
                    'Gender' => $emp->gender,
                    'Todal WD' => $totalDays,
                    'NDays' => (string)$totalAttendanceDays,
                    'OffDays' => (string)$totalOffDays,
                    'Holiday' => "0",
                    'CL' => (string)$formattedTotalCasualLeaveDays,
                    'EL' => (string)$formattedTotalEarnLeaveDays,
                    'ML' => (string)$formattedTotalMedicalLeaveDays,
                    'MnL' => (string)$formattedTotalMaternityLeaveDays,
                    'PnL' => (string)$formattedTotalPaternityLeaveDays,
                    'WPL' => (string)$formattedTotalOtherLeaveDays,
                    'ABS' => (string)$formattedTotalAbsentDays,
                    'NDays_OT' => (string)$totalNormalDaysOt,
                    'Day_Off_OT' => (string)$totalDayoffOt,
                    'Holiday_OT' => (string)$totalHolidayOt,
                    'Late Times' => "",
                ];
            }

            return Excel::create('employees_summary', function ($excel) use ($excelData) {
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
