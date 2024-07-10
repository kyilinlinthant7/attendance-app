<?php

namespace App\Repositories;

use App\Models\AttendanceFilename;
use App\Models\Employee; 
use Maatwebsite\Excel\Facades\Excel;

class ExportAttendanceData
{
    public function export()
    {
        try {
            $attendanceData = AttendanceFilename::get(['emp_arr'])->toArray();
    
            if (empty($attendanceData)) {
                return response()->json(['error' => 'No attendance data found'], 404);
            }

            $attendances = [];
            foreach ($attendanceData as $attendance) {
                $employeeIds = json_decode($attendance['emp_arr'], true);
                $employeeNames = [];
                foreach ($employeeIds as $employeeId) {
                    $employee = Employee::find($employeeId);
                    if ($employee) {
                        $employeeNames[] = $employee->name;
                    }
                }
                $attendances[] = implode(", ", $employeeNames);
            }
    
            $excel = Excel::create('attendance_list', function($excel) use ($attendances) {
                $excel->sheet('Sheet 1', function($sheet) use ($attendances) {
                    $sheet->fromArray($attendances);
                });
            });
    
            $excelFile = $excel->string('xlsx');
    
            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="attendance_list.xlsx"',
            ];
    
            return response()->make($excelFile, 200, $headers);
        } catch (\Exception $e) {
            \Log::error('Error exporting attendance:', [$e->getMessage()]);
            return response()->json(['error' => 'Error exporting attendance'], 500);
        }
    }
}

?>
