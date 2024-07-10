<?php

namespace App\Repositories;

use App\Models\Employee; 
use Maatwebsite\Excel\Facades\Excel;

class ExportEmployeeStatus
{
    public function export($status)
    {
        try {
            $employees = Employee::where('delete_status', 0)
                        ->where('status', $status)
                        ->get();
            
            if ($employees->isEmpty()) {
                return response()->json(['error' => 'No employee data found.'], 404);
            }
            
            $excelData = []; 
            
            foreach ($employees as $emp) {
                $excelData[] = [
                    "Employee ID" => $emp->employee_id,
                    "Fingerprint ID" => $emp->finger_print_id,
                    "Name" => $emp->name,
                    "Position" => $emp->position,
                    "Father Name" => $emp->father_name,
                    "Department" => $emp->department,
                    "Sub Department" => $emp->sub_department,
                    "Branch Location" => $emp->branch_location,
                    "Site Name" => $emp->site_name,
                    "Shift" => $emp->shift,
                    "Employment Status" => $emp->status,
                    "Probation Date From" => $emp->probation_date_from,
                    "Probation Date To" => $emp->probation_date_to,
                    "Permanent Date From" => $emp->permanent_date_from,
                    "Permanent Date To" => $emp->permanent_date_to,
                    "Resign Date From" => $emp->resign_date_from,
                    "Resign Date To" => $emp->resign_date_to,
                    "Warning Date From" => $emp->warning_date_from,
                    "Warning Date To" => $emp->warning_date_to,
                    "Dismiss Date From" => $emp->dismiss_date_from,
                    "Dismiss Date To" => $emp->dismiss_date_to,
                    "Terminate Date From" => $emp->terminate_date_from,
                    "Terminate Date To" => $emp->terminate_date_to,
                    "Promotion Date From" => $emp->promotion_date_from,
                    "Promotion Date To" => $emp->promotion_date_to,
                    "Increment Date From" => $emp->increment_date_from,
                    "Increment Date To" => $emp->increment_date_to,
                    "Reason" => $emp->reason,
                    "Attach File" => $emp->attach_file,
                    "Business Unit" => $emp->business_sbu_name,
                    "Region City" => $emp->region_city,
                    "Gender" => $emp->gender,
                    "Date of Birth" => $emp->date_of_birth,
                    "Join Date" => $emp->date_of_joining,
                    "Service Year" => $emp->service,
                    "Age" => $emp->age,
                    "Age Group" => $emp->age_group,
                    "Basic Salary Monthly" => $emp->basic_salary_monthly,
                    "Basic Salary Yearly" => $emp->basic_salary_yearly,
                    "Salary Currency" => $emp->salary_currency,
                    "Covid 19 vaccine Status" => $emp->covid19_vaccine_status,
                    "Marital Status" => $emp->marital_status,
                    "Child" => $emp->child,
                    "With Parent" => $emp->with_parent,
                    "NRC/Passport" => $emp->nrc_passport,
                    "SBB Card No." => $emp->sbb_card_no,
                    "Education" => $emp->education,
                    "Phone" => $emp->phone,
                    "Residential Address" => $emp->residential_status,
                    "Principle Address" => $emp->principle_address,
                    "Email" => $emp->email,
                    "Report to Whom" => $emp->report_to_whom,
                    "Photo" => $emp->photo,
                ];
            }

            return Excel::create('employees_status', function ($excel) use ($excelData) {
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
