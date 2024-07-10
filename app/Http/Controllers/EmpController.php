<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Role;
use App\Models\Project;
use App\Models\SBU;
use App\LoginUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\ExportEmployeeDetail;
use App\Repositories\ExportEmployeeSummary;
use App\Repositories\ExportEmployeeSiteName;
use App\Repositories\ExportEmployeeStatus;
use App\Repositories\PrintEmployeeCV;
use Illuminate\Support\Facades\File;

class EmpController extends Controller
{
    protected $exportEmployeeDetail;
    protected $exportEmployeeSummary;
    protected $exportEmployeeStatus;
    protected $printEmployeeCV;
    
    public function __construct(ExportEmployeeDetail $exportEmployeeDetail, ExportEmployeeSummary $exportEmployeeSummary, ExportEmployeeStatus $exportEmployeeStatus, ExportEmployeeSiteName $exportEmployeeSiteName, PrintEmployeeCV $printEmployeeCV)
    {
        $this->exportEmployeeDetail = $exportEmployeeDetail;
        $this->exportEmployeeSummary = $exportEmployeeSummary;
        $this->exportEmployeeStatus = $exportEmployeeStatus;
        $this->exportEmployeeSiteName = $exportEmployeeSiteName;
        $this->printEmployeeCV = $printEmployeeCV;
    }
    
    public function addEmployee()
    {
        $roles = Role::get();
        $projects = Project::where('delete_status', 0)->get();
        $sbuNames = SBU::get();

        return view('hrms.employee.wizard', compact('roles', 'projects', 'sbuNames'));
    }
    
    public function addSbu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        SBU::create([
            'name' => $request->sbu_name,
        ]);

        return redirect()->back();
    }

    public function processEmployee(Request $request)
    {
        $emps = Employee::updateOrCreate([
            'id' => $request->id
            ], [
            'employee_id' => $request->emp_code,
            'finger_print_id' => $request->fingerprint,
            'name' => $request->name,
            'father_name' => $request->father,
            'position' => $request->position,
            'department' => $request->department,
            'sub_department' => $request->subdepartment,
            'branch_location' => $request->branch,
            'site_name' => $request->site,
            'shift' => $request->shift,
            'status' => $request->status,
            'probation_date_from' => $request->probation_date_from,
            'probation_date_to' => $request->probation_date_to,
            'permanent_date_from' => $request->permanent_date_from,
            'permanent_date_to' => $request->permanent_date_to,
            'resign_date_from' => $request->resign_date_from,
            'resign_date_to' => $request->resign_date_to,
            'warning_date_from' => $request->warning_date_from,
            'warning_date_to' => $request->warning_date_to,
            'dismiss_date_from' => $request->dismiss_date_from,
            'dismiss_date_to' => $request->dismiss_date_to,
            'terminate_date_from' => $request->terminate_date_from,
            'terminate_date_to' => $request->terminate_date_to,
            'promotion_date_from' => $request->promotion_date_from,
            'promotion_date_to' => $request->promotion_date_to,
            'increment_date_from' => $request->increment_date_from,
            'increment_date_to' => $request->increment_date_to,
            'reason' => $request->reason,
            'business_sbu_name' => $request->sbu,
            'region_city' => $request->city,
            'gender' => $request->gender,
            'date_of_birth' => $request->dob,
            'date_of_joining' => $request->joindate,
            'service' => $request->service,
            'age' => $request->age,
            'age_group' => $request->agegroup,
            'basic_salary_monthly' => $request->basicsalarymonthly,
            'basic_salary_yearly' => $request->basicsalaryyearly,
            'salary_currency' => $request->currency,
            'covid19_vaccine_status' => $request->covid,
            'marital_status' => $request->marital,
            'child' => $request->child,
            'with_parent' => $request->parent,
            'nrc_passport' => $request->nrc,
            'sbb_card_no' => $request->sbb,
            'education' => $request->education,
            'phone' => $request->phone,
            'residential_address' => $request->resaddress,
            'principle_address' => $request->principle,
            'email' => $request->email,
            'report_to_whom' => $request->report
        ]);
        
        return response()->json(['success'=>'Employee successfully Created!']);
        
    }

    public function showEmployee()
    {
        $emps = Employee::where('delete_status', 0)->orderby('id', 'DESC')->paginate(40);
        $sites = Project::get();

        $string = '';
        $column = '';
        
        return view('hrms.employee.show_emp', compact('emps', 'string', 'column', 'sites'));
    }

    public function showEdit($id)
    {
        $emps = Employee::findOrFail($id);
        $roles = Role::get();
        $projects = Project::get();
        $sbuNames = SBU::get();
        
        return view('hrms.employee.wizard', compact('emps', 'roles', 'projects', 'sbuNames'));
    }

    public function doDelete($id)
    {
        $emp = Employee::findOrFail($id);
        $user = LoginUser::where('emp_id', $id);
        
        if($emp) {
            $emp->update(['delete_status' => 1]);
            
        } else {
            \Session::flash('flash_message', 'Fail to Delete!');
        }
      
        \Session::flash('flash_message', 'Employee successfully Deleted!');
        return redirect()->route('employee-manager');
    }

    public function importFile()
    {
        return view('hrms.employee.upload');
    }

    public function uploadFile(Request $request)
    {
        $files = Input::file('upload_file');
        
        /* try {*/
        foreach ($files as $file) {
            Excel::load($file, function ($reader) {
                $rows = $reader->get('employee_id', 'finger_print_id', 'name', 'position', 'father_name', 'department', 'sub_department', 'branch_location', 'site_name', 'shift', 'status', 'business_sbu_name', 'region_city', 'gender' , 'date_of_birth', 'date_of_joining', 'service', 'age', 'age_group', 'basic_salary_monthly', 'basic_salary_yearly', 'salary_currency', 'covid19_vaccine_status', 'marital_status', 'child', 'with_parent', 'nrc_passport', 'sbb_card_no', 'education' , 'phone', 'residential_address', 'principle_address', 'email', 'report_to_whom', 'photo');
                foreach ($rows as $row) {
                    // \Log::info($row->role);
                    $attachment = new Employee();
                    $dateOfBirth = Carbon::createFromFormat('d-M-Y', $row->date_of_birth)->format('Y-m-d');
                    $dateOfJoining = Carbon::createFromFormat('d-M-Y', $row->date_of_joining)->format('Y-m-d');
                
                    if (isset($row->name)) {
                        $attachment->employee_id = $row->employee_id;
                        $attachment->finger_print_id = $row->finger_print_id;
                        $attachment->name = $row->name;
                        $attachment->position = $row->position;
                        $attachment->father_name = $row->father_name;
                        $attachment->department = $row->department;
                        $attachment->sub_department = $row->sub_department;
                        $attachment->branch_location = $row->branch_location;
                        $attachment->site_name = $row->site_name;
                        $attachment->shift = $row->shift;
                        $attachment->status = $row->status;
                        $attachment->probation_date_from = $row->probation_date_from;
                        $attachment->probation_date_to = $row->probation_date_to;
                        $attachment->permanent_date_from = $row->permanent_date_from;
                        $attachment->permanent_date_to = $row->permanent_date_to;
                        $attachment->resign_date_from = $row->resign_date_from;
                        $attachment->resign_date_to = $row->resign_date_to;
                        $attachment->warning_date_from = $row->warning_date_from;
                        $attachment->warning_date_to = $row->warning_date_to;
                        $attachment->dismiss_date_from = $row->dismiss_date_from;
                        $attachment->dismiss_date_to = $row->dismiss_date_to;
                        $attachment->terminate_date_from = $row->terminate_date_from;
                        $attachment->terminate_date_to = $row->terminate_date_to;
                        $attachment->promotion_date_from = $row->promotion_date_from;
                        $attachment->promotion_date_to = $row->promotion_date_to;
                        $attachment->increment_date_from = $row->increment_date_from;
                        $attachment->increment_date_to = $row->increment_date_to;
                        $attachment->reason = $row->reason;
                        $attachment->business_sbu_name = $row->business_sbu_name;
                        $attachment->region_city = $row->region_city;
                        $attachment->gender = $row->gender;
                        $attachment->date_of_birth = $dateOfBirth;
                        $attachment->date_of_joining = $dateOfJoining;
                        $attachment->service = $row->service;
                        $attachment->age = $row->age;
                        $attachment->age_group = $row->age_group;
                        $attachment->basic_salary_monthly = $row->basic_salary_monthly;
                        $attachment->basic_salary_yearly = $row->basic_salary_yearly;
                        $attachment->salary_currency = $row->salary_currency;
                        $attachment->covid19_vaccine_status = $row->covid19_vaccine_status;
                        $attachment->marital_status = $row->marital_status;
                        $attachment->child = $row->child;
                        $attachment->with_parent = $row->with_parent;
                        $attachment->nrc_passport = $row->nrc_passport;
                        $attachment->sbb_card_no = $row->sbb_card_no;
                        $attachment->education = $row->education;
                        $attachment->phone = $row->phone;
                        $attachment->residential_address = $row->residential_address;
                        $attachment->principle_address = $row->principle_address;
                        $attachment->email = $row->email;
                        $attachment->report_to_whom = $row->report_to_whom;
                        $attachment->photo = $row->photo;
                        
                        $attachment->save();
                    }
                }
                return 1;
                //return redirect('upload_form');*/
            });

        }
        /*catch (\Exception $e) {
          return $e->getMessage();*/

        \Session::flash('success', ' Employee details uploaded successfully.');
        
        return redirect()->route('employee-manager');
    }

    public function searchEmployee(Request $request)
    {
        $string = '';
        $column = 'name';
        
        $empsQuery = Employee::query();
        $empsQuery->where('delete_status', '==', 0);
        
        // search text inputs
        if ($request->each_search == "Search") {
            switch ($request->column) {
                case "employee_id":
                case "nrc_passport":
                case "region_city":
                case "phone":
                case "position":
                case "date_of_joining":
                case "site_name":
                case "service":
                    $column = $request->column;
                    $empsQuery->where($column, 'LIKE', '%' . $request->keywords . '%');
                    break;
                case "department":
                    $column = 'department';
                    $empsQuery->where('department', 'LIKE', '%' . $request->keywords . '%')
                        ->orWhere('sub_department', 'LIKE', '%' . $request->keywords . '%');
                    break;
                default:
                    $empsQuery->where('name', 'LIKE', '%' . $request->keywords . '%');
                    break;
            }
        }

        // search option and drop-down
        if ($request->gender_age_search == "Search") {
            if ($request->age == "age_group_1") {
                $empsQuery->where('age', '<', 25);
            } elseif ($request->age == "age_group_2") {
                $empsQuery->whereBetween('age', [25, 45]);
            } elseif ($request->age == "age_group_3") {
                $empsQuery->where('age', '>', 45);
            }

            if ($request->gender == "male") {
                $empsQuery->where('gender', 'Male');
            } elseif ($request->gender == "female") {
                $empsQuery->where('gender', 'Female');
            }
        }

        // employment status search
        if ($request->status_service_search) {
            $empsQuery->where('status', 'LIKE', '%' . $request->status . '%');
            if ($request->service == 'service_1') {
                $empsQuery->whereRaw('DATEDIFF(CURDATE(), date_of_joining) < 365');
            } elseif ($request->service == 'service_2') {
                $empsQuery->whereRaw('DATEDIFF(CURDATE(), date_of_joining) BETWEEN 365 AND 730');
            } elseif ($request->service == 'service_3') {
                $empsQuery->whereRaw('DATEDIFF(CURDATE(), date_of_joining) BETWEEN 730 AND 1095');
            } elseif ($request->service == 'service_4') {
                $empsQuery->whereRaw('DATEDIFF(CURDATE(), date_of_joining) > 1095');
            }
            // search date range
            if ($request->start_date && $request->end_date) {
                $startDate = date('Y-m-d', strtotime($request->start_date));
                $endDate = date('Y-m-d', strtotime($request->end_date));
                
                $empsQuery->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('date_of_joining', [$startDate, $endDate])
                        ->orWhereBetween(DB::raw("DATE_FORMAT(date_of_joining, '%Y-%m-%d')"), [$startDate, $endDate]);
                });
            }
            // site name search
            if ($request->site) {
                $empsQuery->where('site_name', $request->site);
            }
            
            // salary search
            if ($request->minimum_salary && $request->maximum_salary) {
                $minimumSalary = (float)$request->minimum_salary;
                $maximumSalary = (float)$request->maximum_salary;

                $empsQuery->whereRaw('CAST(basic_salary_monthly AS DECIMAL(10,2)) BETWEEN ? AND ?', [$minimumSalary, $maximumSalary]);
            }
        }

        $emps = $empsQuery->orderby('id', 'DESC')->paginate(40);
        $sites = Project::get();

        // $currentPage = $request->input('page', 1);
        // $currentPage = min($currentPage, $originalEmps->lastPage());

        // $items = $originalEmps->slice(($currentPage - 1) * $originalEmps->perPage(), $originalEmps->perPage());

        // $emps = new LengthAwarePaginator(
        //     $items,
        //     $originalEmps->total(),
        //     $originalEmps->perPage(),
        //     $currentPage,
        //     ['path' => $originalEmps->url()]
        // );

        return view('hrms.employee.show_emp', compact('emps', 'string', 'column', 'sites'));
    }
    
    public function viewEmployee($id){
        
        $emp = Employee::findOrFail($id);

        return view('hrms.employee.view', compact('emp'));
    }
    
    public function showProbation()
    {
        $emps = Employee::where('status', 'Probation')->orderby('id', 'DESC')->paginate(40);

        $string='';
        $column='';
        $searching = false;
        
        $empStatus = 'Probation';
        
        return view('hrms.employee.show_specific_emp', compact('emps', 'string', 'column', 'empStatus', 'searching'));
    }

    public function showPermanent()
    {
        $emps = Employee::where('status', 'Permanent')->orderby('id', 'DESC')->paginate(40);

        $string='';
        $column='';
        $searching = false;
        
        $empStatus = 'Permanent';
        
        return view('hrms.employee.show_specific_emp', compact('emps', 'string', 'column', 'empStatus', 'searching'));
    }
    
    public function showResign()
    {
        $emps = Employee::where('status', 'Resign')->orderby('id', 'DESC')->paginate(40);

        $string='';
        $column='';
        $searching = false;
        
        $empStatus = 'Resign';
        
        return view('hrms.employee.show_specific_emp', compact('emps', 'string', 'column', 'empStatus', 'searching'));
    }
    
    public function showWarning()
    {
        $emps = Employee::where('status', 'Warning')->orderby('id', 'DESC')->paginate(40);

        $string='';
        $column='';
        $searching = false;
        
        $empStatus = 'Warning';
        
        return view('hrms.employee.show_specific_emp', compact('emps', 'string', 'column', 'empStatus', 'searching'));
    }
    
    public function showTerminate()
    {
        $emps = Employee::where('status', 'Terminate')->orderby('id', 'DESC')->paginate(40);

        $string='';
        $column='';
        $searching = false;
        
        $empStatus = 'Terminate';
        
        return view('hrms.employee.show_specific_emp', compact('emps', 'string', 'column', 'empStatus', 'searching'));
    }
    
    public function showDismiss()
    {
        $emps = Employee::where('status', 'Dismiss')->orderby('id', 'DESC')->paginate(40);

        $string='';
        $column='';
        $searching = false;
        
        $empStatus = 'Dismiss';
        
        return view('hrms.employee.show_specific_emp', compact('emps', 'string', 'column', 'empStatus', 'searching'));
    }
    
    public function searchSpecificEmployee(Request $request)
    {
        $string = '';
        $column = 'name';
        $empStatus = $request->emp_status;
        $searching = true;
        
        $empsQuery = Employee::where('status', $empStatus);
        
        // search text inputs
        if ($request->each_search == "Search") {
            switch ($request->column) {
                case "employee_id":
                case "nrc_passport":
                case "region_city":
                case "phone":
                case "position":
                case "date_of_joining":
                case "site_name":
                case "service":
                    $column = $request->column;
                    $empsQuery->where($column, 'LIKE', '%' . $request->keywords . '%');
                    break;
                case "department":
                    $column = 'department';
                    $empsQuery->where('department', 'LIKE', '%' . $request->keywords . '%')
                        ->orWhere('sub_department', 'LIKE', '%' . $request->keywords . '%');
                    break;
                default:
                    $empsQuery->where('name', 'LIKE', '%' . $request->keywords . '%');
                    break;
            }
        }

        // search option and drop-down
        if ($request->gender_age_search == "Search") {
            if ($request->age == "age_group_1") {
                $empsQuery->where('age', '<', 25);
            } elseif ($request->age == "age_group_2") {
                $empsQuery->whereBetween('age', [25, 45]);
            } elseif ($request->age == "age_group_3") {
                $empsQuery->where('age', '>', 45);
            }

            if ($request->gender == "male") {
                $empsQuery->where('gender', 'Male');
            } elseif ($request->gender == "female") {
                $empsQuery->where('gender', 'Female');
            }
        }

        // employment status search
        if ($request->status_service_search) {
            $empsQuery->where('status', 'LIKE', '%' . $request->status . '%');
            if ($request->service == 'service_1') {
                $empsQuery->whereRaw('DATEDIFF(CURDATE(), date_of_joining) < 365');
            } elseif ($request->service == 'service_2') {
                $empsQuery->whereRaw('DATEDIFF(CURDATE(), date_of_joining) BETWEEN 365 AND 730');
            } elseif ($request->service == 'service_3') {
                $empsQuery->whereRaw('DATEDIFF(CURDATE(), date_of_joining) BETWEEN 730 AND 1095');
            } elseif ($request->service == 'service_4') {
                $empsQuery->whereRaw('DATEDIFF(CURDATE(), date_of_joining) > 1095');
            }
            // search date range
            if ($request->start_date && $request->end_date) {
                $startDate = date('Y-m-d', strtotime($request->start_date));
                $endDate = date('Y-m-d', strtotime($request->end_date));
                
                $empsQuery->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('date_of_joining', [$startDate, $endDate])
                        ->orWhereBetween(DB::raw("DATE_FORMAT(date_of_joining, '%Y-%m-%d')"), [$startDate, $endDate]);
                });
            }
            // salary search
            if ($request->minimum_salary && $request->maximum_salary) {
                $minimumSalary = (float)$request->minimum_salary;
                $maximumSalary = (float)$request->maximum_salary;

                $empsQuery->whereRaw('CAST(basic_salary_monthly AS DECIMAL(10,2)) BETWEEN ? AND ?', [$minimumSalary, $maximumSalary]);
            }
        }

        $emps = $empsQuery->orderby('id', 'DESC')->paginate(40);

        return view('hrms.employee.show_specific_emp', compact('emps', 'string', 'column', 'empStatus', 'searching'));
        
    }
    
    public function showExports()
    {
        return view('hrms.employee.show_exports');
    }
    
    public function exportDetail(Request $request)
    {
        $dateFrom = $request->has('date_from') ? $request->date_from : Carbon::today()->format('Y-m-d');
        $dateTo = $request->has('date_to') ? $request->date_to : Carbon::today()->format('Y-m-d');

        return $this->exportEmployeeDetail->export($dateFrom, $dateTo);
    }
    
    public function exportSummary(Request $request) 
    {
        $monthFilter = $request->input('month_filter', Carbon::today()->format('Y-m'));
    
        return $this->exportEmployeeSummary->export($monthFilter);
    }
    
    public function exportEmpStatus(Request $request)
    {
        $status = $request->emp_status;
        
        return $this->exportEmployeeStatus->export($status);
    }
    
    public function exportEmpSiteName(Request $request)
    {
        $siteName = $request->site;
        
        return $this->exportEmployeeSiteName->export($siteName);
    }
    
    public function printEmployee($id)
    {
        $emp = Employee::findOrFail($id);
        
        // education
        $eduSchools = is_string($emp->edu_school) ? json_decode($emp->edu_school, true) : $emp->edu_school;
        $eduDurations = is_string($emp->edu_duration) ? json_decode($emp->edu_duration, true) : $emp->edu_duration;
        $eduPassConts = is_string($emp->edu_pass_cont) ? json_decode($emp->edu_pass_cont, true) : $emp->edu_pass_cont;
        $eduDegrees = is_string($emp->edu_degree) ? json_decode($emp->edu_degree, true) : $emp->edu_degree;
        $eduRemarks = is_string($emp->edu_remark) ? json_decode($emp->edu_remark, true) : $emp->edu_remark;
        // work
        $expCompanies = is_string($emp->exp_company) ? json_decode($emp->exp_company, true) : $emp->exp_company;
        $expDurations = is_string($emp->exp_duration) ? json_decode($emp->exp_duration, true) : $emp->exp_duration;
        $expPositions = is_string($emp->exp_position) ? json_decode($emp->exp_position, true) : $emp->exp_position;
        $expSalaries = is_string($emp->exp_salary) ? json_decode($emp->exp_salary, true) : $emp->exp_salary;
        $expBriefJDs = is_string($emp->exp_brief_jd) ? json_decode($emp->exp_brief_jd, true) : $emp->exp_brief_jd;
        $expRemarks = is_string($emp->exp_remark) ? json_decode($emp->exp_remark, true) : $emp->exp_remark;
        // training
        $trainSubjects = is_string($emp->train_subject) ? json_decode($emp->train_subject, true) : $emp->train_subject;
        $trainDurations = is_string($emp->train_duration) ? json_decode($emp->train_duration, true) : $emp->train_duration;
        $trainDegrees = is_string($emp->train_degree) ? json_decode($emp->train_degree, true) : $emp->train_degree;
        $trainAmounts = is_string($emp->train_amount) ? json_decode($emp->train_amount, true) : $emp->train_amount;
        $trainPNPs = is_string($emp->train_p_np) ? json_decode($emp->train_p_np, true) : $emp->train_p_np;
        $trainCNCs = is_string($emp->train_c_nc) ? json_decode($emp->train_c_nc, true) : $emp->train_c_nc;
        $trainSDCDPs = is_string($emp->train_sd_cdp) ? json_decode($emp->train_sd_cdp, true) : $emp->train_sd_cdp;
        $trainOCSs = is_string($emp->train_o_cs) ? json_decode($emp->train_o_cs, true) : $emp->train_o_cs;
        $trainIntExts = is_string($emp->train_int_ext) ? json_decode($emp->train_int_ext, true) : $emp->train_int_ext;
        // status
        $stsEffectiveDates = is_string($emp->sts_effective_date) ? json_decode($emp->sts_effective_date, true) : $emp->sts_effective_date;
        $stsReasonOfChanges = is_string($emp->sts_reason_of_change) ? json_decode($emp->sts_reason_of_change, true) : $emp->sts_reason_of_change;
        $stsFromDates = is_string($emp->sts_from_date) ? json_decode($emp->sts_from_date, true) : $emp->sts_from_date;
        $stsToDates = is_string($emp->sts_to_date) ? json_decode($emp->sts_to_date, true) : $emp->sts_to_date;
        $stsOtherChanges = is_string($emp->sts_other_change) ? json_decode($emp->sts_other_change, true) : $emp->sts_other_change;
        $stsRemarks = is_string($emp->sts_remark) ? json_decode($emp->sts_remark, true) : $emp->sts_remark;
        // action
        $actionDates = is_string($emp->action_date) ? json_decode($emp->action_date, true) : $emp->action_date;
        $actionIncidentRecords = is_string($emp->action_incident_record) ? json_decode($emp->action_incident_record, true) : $emp->action_incident_record;
        $actionStatus = is_string($emp->action_status) ? json_decode($emp->action_status, true) : $emp->action_status;
        $actionRemarks = is_string($emp->action_remark) ? json_decode($emp->action_remark, true) : $emp->action_remark;
        // loan
        $loanDates = is_string($emp->loan_date) ? json_decode($emp->loan_date, true) : $emp->loan_date;
        $loanReasons = is_string($emp->loan_reason) ? json_decode($emp->loan_reason, true) : $emp->loan_reason;
        $loanAmounts = is_string($emp->loan_amount) ? json_decode($emp->loan_amount, true) : $emp->loan_amount;
        $loanRemarks = is_string($emp->loan_remark) ? json_decode($emp->loan_remark, true) : $emp->loan_remark;
        // supply
        $supplyItems = is_string($emp->supply_items) ? json_decode($emp->supply_items, true) : $emp->supply_items;
        $supplyStatus = is_string($emp->supply_status) ? json_decode($emp->supply_status, true) : $emp->supply_status;
        $supplyDates = is_string($emp->supply_date) ? json_decode($emp->supply_date, true) : $emp->supply_date;
        $supplyNumbers = is_string($emp->supply_number) ? json_decode($emp->supply_number, true) : $emp->supply_number;
        $supplyAmounts = is_string($emp->supply_amount) ? json_decode($emp->supply_amount, true) : $emp->supply_amount;
        $supplyRemarks = is_string($emp->supply_remark) ? json_decode($emp->supply_remark, true) : $emp->supply_remark;
        
        return view('hrms.employee.print_view', compact('emp', 'eduSchools', 'eduDurations', 'eduPassConts', 'eduDegrees', 'eduRemarks', 'expCompanies', 'expDurations', 'expPositions', 'expSalaries', 'expBriefJDs', 'expRemarks', 'trainSubjects', 'trainDurations', 'trainDegrees', 'trainAmounts', 'trainPNPs', 'trainCNCs', 'trainSDCDPs', 'trainOCSs', 'trainIntExts', 'stsEffectiveDates', 'stsReasonOfChanges', 'stsFromDates', 'stsToDates', 'stsOtherChanges', 'stsRemarks', 'actionDates', 'actionIncidentRecords', 'actionStatus', 'actionRemarks', 'loanDates', 'loanReasons', 'loanAmounts', 'loanRemarks', 'supplyItems', 'supplyStatus', 'supplyDates', 'supplyNumbers', 'supplyAmounts', 'supplyRemarks'));
    }
    
    public function editEmployeeCV(Request $request, $id)
    {
        $photoPath = "";
        $photo = $request->file('cv_photo');
        
        $emp = Employee::findOrFail($id);
        
        // Check if the remove_photo flag is set to true
        if ($request->input('remove_photo') === 'true') {
            if ($emp->cv_photo && File::exists($emp->cv_photo)) {
                File::delete($emp->cv_photo);
            }
            $photoPath = null;
        } elseif ($request->hasFile('cv_photo')) {
            if ($emp->cv_photo && File::exists($emp->cv_photo)) {
                File::delete($emp->cv_photo);
            }
    
            $imageName = Carbon::now()->format('YmdHis') . '.' . $photo->getClientOriginalExtension();
            
            if ($photo->move('public/cv_photos/', $imageName)) {
                $photoPath = "public/cv_photos/" . $imageName;
            } else {
                return response()->json(['error' => 'Failed to move the uploaded file'], 500);
            }
        } else {
            $photoPath = $emp->cv_photo;
        }
        
        $emp->name = $request->name;
        $emp->employee_id = $request->employee_id;
        $emp->nrc_passport = $request->nrc_passport;
        $emp->manpower_request_id = $request->manpower_request_id;
        $emp->date_of_birth = $request->date_of_birth;
        $emp->position = $request->position;
        $emp->department = $request->department;
        $emp->father_name = $request->father_name;
        $emp->mother_name = $request->mother_name;
        $emp->company = $request->company;
        $emp->marital_status = $request->marital_status;
        $emp->benefit = $request->salary_benefit;
        $emp->blood_type = $request->blood_type;
        $emp->insurance = $request->insurance;
        $emp->height_weight = $request->height_weight;
        $emp->ssb = $request->ssb;
        $emp->phone = $request->phone;
        $emp->ferry = $request->ferry;
        $emp->residential_address = $request->current_address;
        $emp->principle_address = $request->permanent_address;
        // education
        $emp->edu_school = $request->edu_school;
        $emp->edu_duration = $request->edu_duration;
        $emp->edu_pass_cont = $request->edu_pass_cont;
        $emp->edu_degree = $request->edu_degree;
        $emp->edu_remark = $request->edu_remark;
        // work
        $emp->exp_company = $request->exp_company;
        $emp->exp_duration = $request->exp_duration;
        $emp->exp_position = $request->exp_position;
        $emp->exp_salary = $request->exp_salary;
        $emp->exp_brief_jd = $request->exp_brief_jd;
        $emp->exp_remark = $request->exp_remark;
        // training
        $emp->train_subject = $request->train_subject;
        $emp->train_duration = $request->train_duration;
        $emp->train_degree = $request->train_degree;
        $emp->train_amount = $request->train_amount;
        $emp->train_p_np = $request->train_p_np;
        $emp->train_c_nc = $request->train_c_nc;
        $emp->train_sd_cdp = $request->train_sd_cdp;
        $emp->train_o_cs = $request->train_o_cs;
        $emp->train_int_ext = $request->train_int_ext;
        // skill
        $emp->language_skill = $request->language_skill;
        $emp->computer_skill = $request->computer_skill;
        $emp->other_skill = $request->other_skill;
        // status
        $emp->sts_effective_date = $request->sts_effective_date;
        $emp->sts_reason_of_change = $request->sts_reason_of_change;
        $emp->sts_from_date = $request->sts_from_date;
        $emp->sts_to_date = $request->sts_to_date;
        $emp->sts_other_change = $request->sts_other_change;
        $emp->sts_remark = $request->sts_remark;
        // action
        $emp->action_date = $request->action_date;
        $emp->action_incident_record = $request->action_incident_record;
        $emp->action_status = $request->action_status;
        $emp->action_remark = $request->action_remark;
        // loan
        $emp->loan_date = $request->loan_date;
        $emp->loan_reason = $request->loan_reason;
        $emp->loan_amount = $request->loan_amount;
        $emp->loan_remark = $request->loan_remark;
        // supply
        $emp->supply_items = $request->supply_items;
        $emp->supply_status = $request->supply_status;
        $emp->supply_date = $request->supply_date;
        $emp->supply_number = $request->supply_number;
        $emp->supply_amount = $request->supply_amount;
        $emp->supply_remark = $request->supply_remark;
        
        $emp->other_remark = $request->other_remark;
        $emp->cv_photo = $photoPath;
        
        $emp->update();
        
        return redirect()->back()->with('success', 'Employee CV is updated successfully!');
    }
    
    public function printEmployeeCV(Request $request, $id)
    {
        return $this->printEmployeeCV->print();
    }
    
    public function showPrintView($id)
    {
        $emp = Employee::find($id);
        
        // education
        $eduSchools = is_string($emp->edu_school) ? json_decode($emp->edu_school, true) : $emp->edu_school;
        $eduDurations = is_string($emp->edu_duration) ? json_decode($emp->edu_duration, true) : $emp->edu_duration;
        $eduPassConts = is_string($emp->edu_pass_cont) ? json_decode($emp->edu_pass_cont, true) : $emp->edu_pass_cont;
        $eduDegrees = is_string($emp->edu_degree) ? json_decode($emp->edu_degree, true) : $emp->edu_degree;
        $eduRemarks = is_string($emp->edu_remark) ? json_decode($emp->edu_remark, true) : $emp->edu_remark;
        // work
        $expCompanies = is_string($emp->exp_company) ? json_decode($emp->exp_company, true) : $emp->exp_company;
        $expDurations = is_string($emp->exp_duration) ? json_decode($emp->exp_duration, true) : $emp->exp_duration;
        $expPositions = is_string($emp->exp_position) ? json_decode($emp->exp_position, true) : $emp->exp_position;
        $expSalaries = is_string($emp->exp_salary) ? json_decode($emp->exp_salary, true) : $emp->exp_salary;
        $expBriefJDs = is_string($emp->exp_brief_jd) ? json_decode($emp->exp_brief_jd, true) : $emp->exp_brief_jd;
        $expRemarks = is_string($emp->exp_remark) ? json_decode($emp->exp_remark, true) : $emp->exp_remark;
        // training
        $trainSubjects = is_string($emp->train_subject) ? json_decode($emp->train_subject, true) : $emp->train_subject;
        $trainDurations = is_string($emp->train_duration) ? json_decode($emp->train_duration, true) : $emp->train_duration;
        $trainDegrees = is_string($emp->train_degree) ? json_decode($emp->train_degree, true) : $emp->train_degree;
        $trainAmounts = is_string($emp->train_amount) ? json_decode($emp->train_amount, true) : $emp->train_amount;
        $trainPNPs = is_string($emp->train_p_np) ? json_decode($emp->train_p_np, true) : $emp->train_p_np;
        $trainCNCs = is_string($emp->train_c_nc) ? json_decode($emp->train_c_nc, true) : $emp->train_c_nc;
        $trainSDCDPs = is_string($emp->train_sd_cdp) ? json_decode($emp->train_sd_cdp, true) : $emp->train_sd_cdp;
        $trainOCSs = is_string($emp->train_o_cs) ? json_decode($emp->train_o_cs, true) : $emp->train_o_cs;
        $trainIntExts = is_string($emp->train_int_ext) ? json_decode($emp->train_int_ext, true) : $emp->train_int_ext;
        // status
        $stsEffectiveDates = is_string($emp->sts_effective_date) ? json_decode($emp->sts_effective_date, true) : $emp->sts_effective_date;
        $stsReasonOfChanges = is_string($emp->sts_reason_of_change) ? json_decode($emp->sts_reason_of_change, true) : $emp->sts_reason_of_change;
        $stsFromDates = is_string($emp->sts_from_date) ? json_decode($emp->sts_from_date, true) : $emp->sts_from_date;
        $stsToDates = is_string($emp->sts_to_date) ? json_decode($emp->sts_to_date, true) : $emp->sts_to_date;
        $stsOtherChanges = is_string($emp->sts_other_change) ? json_decode($emp->sts_other_change, true) : $emp->sts_other_change;
        $stsRemarks = is_string($emp->sts_remark) ? json_decode($emp->sts_remark, true) : $emp->sts_remark;
        // action
        $actionDates = is_string($emp->action_date) ? json_decode($emp->action_date, true) : $emp->action_date;
        $actionIncidentRecords = is_string($emp->action_incident_record) ? json_decode($emp->action_incident_record, true) : $emp->action_incident_record;
        $actionStatus = is_string($emp->action_status) ? json_decode($emp->action_status, true) : $emp->action_status;
        $actionRemarks = is_string($emp->action_remark) ? json_decode($emp->action_remark, true) : $emp->action_remark;
        // loan
        $loanDates = is_string($emp->loan_date) ? json_decode($emp->loan_date, true) : $emp->loan_date;
        $loanReasons = is_string($emp->loan_reason) ? json_decode($emp->loan_reason, true) : $emp->loan_reason;
        $loanAmounts = is_string($emp->loan_amount) ? json_decode($emp->loan_amount, true) : $emp->loan_amount;
        $loanRemarks = is_string($emp->loan_remark) ? json_decode($emp->loan_remark, true) : $emp->loan_remark;
        // supply
        $supplyItems = is_string($emp->supply_items) ? json_decode($emp->supply_items, true) : $emp->supply_items;
        $supplyStatus = is_string($emp->supply_status) ? json_decode($emp->supply_status, true) : $emp->supply_status;
        $supplyDates = is_string($emp->supply_date) ? json_decode($emp->supply_date, true) : $emp->supply_date;
        $supplyNumbers = is_string($emp->supply_number) ? json_decode($emp->supply_number, true) : $emp->supply_number;
        $supplyAmounts = is_string($emp->supply_amount) ? json_decode($emp->supply_amount, true) : $emp->supply_amount;
        $supplyRemarks = is_string($emp->supply_remark) ? json_decode($emp->supply_remark, true) : $emp->supply_remark;
        
        return view('hrms.employee.cv_print_view', compact('emp', 'eduSchools', 'eduDurations', 'eduPassConts', 'eduDegrees', 'eduRemarks', 'expCompanies', 'expDurations', 'expPositions', 'expSalaries', 'expBriefJDs', 'expRemarks', 'trainSubjects', 'trainDurations', 'trainDegrees', 'trainAmounts', 'trainPNPs', 'trainCNCs', 'trainSDCDPs', 'trainOCSs', 'trainIntExts', 'stsEffectiveDates', 'stsReasonOfChanges', 'stsFromDates', 'stsToDates', 'stsOtherChanges', 'stsRemarks', 'actionDates', 'actionIncidentRecords', 'actionStatus', 'actionRemarks', 'loanDates', 'loanReasons', 'loanAmounts', 'loanRemarks', 'supplyItems', 'supplyStatus', 'supplyDates', 'supplyNumbers', 'supplyAmounts', 'supplyRemarks'));
    }

}
















