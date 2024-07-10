@extends('hrms.layouts.base');

@section('content')
{{-- <header style="margin-top: 100px"></header> --}}

@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{Session::get('flash_message')}}
    </div>
@endif
<form method="post" action="/" id="custom-form-wizard" class="form-horizontal" style="margin-top: 50px;margin-left:50px;margin-right:30px">
    <div class="wizard steps-bg steps-left">
        
      <!------------------- step 1 --------------------------->
        <h4 class="wizard-section-title">
            <i class="fa fa-user pr5"></i> Personal Details<br>Step one</h4>
        <section class="wizard-section">

            <div class="form-group">
                <label class="col-md-3 control-label">Employee ID</label>
                <div class="col-md-8">
                    <input type="text" name="emp_code" id="emp_code"
                        class="select2-single form-control" value="{{$emps->employee_id}}" placeholder="Enter Employee ID">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Finger Print ID</label>
                <div class="col-md-8">
                    <input type="text" name="fingerprint" id="fingerprint"
                        class="select2-single form-control" value="{{$emps->finger_print_id}}" placeholder="Enter Finger Print ID">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Employee Name</label>
                <div class="col-md-8">
                    <input type="text" name="name" id="name"
                        class="select2-single form-control" value="{{$emps->name}}" placeholder="Enter Name"
                        required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Position</label>
                <div class="col-md-8">
                    <input type="text" name="position" id="position"
                        class="select2-single form-control" value="{{$emps->position}}" placeholder="Enter Position">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Department</label>
                <div class="col-md-8">
                    <input type="text" name="department" id="department"
                        class="select2-single form-control" value="{{$emps->department}}" placeholder="Enter Department">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Sub Department</label>
                <div class="col-md-8">
                    <input type="text" name="subdepartment" id="subdepartment"
                        class="select2-single form-control" value="{{$emps->sub_department}}" placeholder="Enter Sub Department">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Branch/Location</label>
                <div class="col-md-8">
                    <input type="text" name="branch" id="branch"
                        class="select2-single form-control" value="{{$emps->branch_location}}" placeholder="Enter Branch Location">
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-3 control-label">Site Name</label>
                <div class="col-md-8">
                    <select class="select2-multiple form-control select-primary"
                     name="site" id="site">
                        @foreach ($projects as $project )
                            @if($project->id == $emps->site_name)
                                <option value="{{$project->id}}" selected>{{$project->name}}</option>
                            @else
                                <option value="{{$project->id}}">{{$project->name}}</option>
                            @endif
                        @endforeach
                       
                    </select>
                </div>
            </div>

        </section>


        <!------------------END Step 1 ------------------------->


        <!------------------- Step 2 ----------------------------->

        <h4 class="wizard-section-title">
            <i class="fa fa-user pr5"></i> Personal Details<br>Step Two</h4>
        <section class="wizard-section">

            <div class="form-group">
                <label class="col-md-3 control-label"> Shift</label>
                <div class="col-md-8">
                    <select class="select2-multiple form-control select-primary"
                        name="shift" id="shift">
                        <option value="{{$emps->shift}}" selected>{{$emps->shift}}</option>
                        <option value="Morning">Day</option>
                        <option value="Night">Night</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Employment Status </label>
                <div class="col-md-6">
                    <select class="select2-multiple form-control select-primary"
                        name="status" id="status">
                        <option value="{{$emps->status}}" selected>{{$emps->status}}</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-3 control-label"> Date </label>
                <div class="col-md-6">
                    <input type="date" class="form-control" name="status_date" id="status_date" value="{{$emps->status_date}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"> Reason </label>
                <div class="col-md-6">
                    <textarea class="form-control" name="reason" id="reason" placeholder="Enter reason for employment status...">{{$emps->reason}}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Region/City </label>
                <div class="col-md-6">
                    <select class="select2-multiple form-control select-primary"
                        name="city" id="city">
                        <option value="{{$emps->region_city}}" selected>{{$emps->region_city}}</option>
                        <option value="Morning">Yangon</option>
                        <option value="Day">Mandalay</option>
                        <option value="Day">Laukkai</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Gender </label>
                <div class="col-md-6">
                    <select class="select2-multiple form-control select-primary"
                        name="gender" id="gender">
                        <option value="{{$emps->gender}}" selected>{{$emps->gender}}</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Date Of Birth </label>
                <div class="col-md-6">
                    <input type="date" name="dob" id="dob" value="{{$emps->date_of_birth}}" placeholder="Choose date of Birth"
                        class="select2-single form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Join Date </label>
                <div class="col-md-6">
                    <input type="date" name="joindate" id="joindate" value="{{$emps->date_of_joining}}" placeholder="Choose join date"
                        class="select2-single form-control" 
                    >
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Service </label>
                <div class="col-md-6">
                    <input type="text" name="service" id="service"
                        class="select2-single form-control" value="{{$emps->service}}" placeholder="Enter Service(Year & Month)">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Age </label>
                <div class="col-md-6">
                    <input type="text" name="age" id="age"
                        class="select2-single form-control" value="{{$emps->age}}" placeholder="Enter Employee Age">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Age Group </label>
                <div class="col-md-6">
                    <select class="select2-multiple form-control select-primary"
                        name="agegroup" id="agegroup">
                        <option value="{{$emps->age_group}}" selected>{{$emps->age_group}}</option>
                        <option value="under25">Under 25</option>
                        <option value="between25and45">Between 25 and 45</option>
                        <option value="above45">Above 45</option>
                    </select>
                </div>
            </div>
        </section>

        <!------------------END Step 2---------------------------------->




        <!----------------Step 3 ---------------------------------------->

        <h4 class="wizard-section-title">
            <i class="fa fa-user pr5"></i> Personal Details<br>Step Three</h4>
        <section class="wizard-section">
            <div class="form-group">
                <label class="col-md-3 control-label"> Basic Salary(Monthly) </label>
                <div class="col-md-6">
                    <input type="text" name="basicsalarymonthly" id="basicsalary"
                        class="select2-single form-control" value="{{$emps->basic_salary_monthly}}" placeholder="Enter Basic Salary(Monthly)">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Basic Salary(Yearly) </label>
                <div class="col-md-6">
                    <input type="text" name="basicsalaryyearly" id="basicsalary"
                        class="select2-single form-control" value="{{$emps->basic_salary_yearly}}" placeholder="Enter Basic Salary(Monthly)">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Salary Currnecy </label>
                <div class="col-md-6">
                    <select class="select2-multiple form-control select-primary"
                        name="currency" id="currency">
                        <option value="{{$emps->salarycurrency}}" selected>{{$emps->salary_currency}}</option>
                        <option value="ks">Kyats</option>
                        <option value="$">Dollar</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Covid-19 Vaccine Status </label>
                <div class="col-md-6">
                    <select class="select2-multiple form-control select-primary"
                        name="covid" id="covid">
                        <option value="{{$emps->covid19_vaccine_status}}" selected>{{$emps->covid19_vaccine_status}}</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Marital Status </label>
                <div class="col-md-6">
                    <select class="select2-multiple form-control select-primary"
                        name="marital" id="marital">
                        <option value="{{$emps->marital_status}}" selected>{{$emps->marital_status}}</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Child </label>
                <div class="col-md-6">
                    <select class="select2-multiple form-control select-primary"
                        name="child" id="child">
                        <option value="{{$emps->child}}" selected>{{$emps->child}}</option>
                        <option value="withchild">Yes</option>
                        <option value="withoutChild">No</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> With Parent </label>
                <div class="col-md-6">
                    <select class="select2-multiple form-control select-primary"
                        name="parent" id="parent">
                        <option value="{{$emps->with_parent}}" selected>{{$emps->with_parent}}</option>
                        <option value="withparent">Yes</option>
                        <option value="withoutparent">No</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> NRC No / Passport No </label>
                <div class="col-md-6">
                    <input type="text" name="nrc" id="nrc"
                        class="select2-single form-control" value="{{$emps->nrc_passport}}" placeholder="NRC or Passport">
                </div>
            </div>
        </section>

        <!---------------------END Step 3 ---------------------------------->




        <!---------------------Step 4 ------------------------------>

        <h4 class="wizard-section-title">
            <i class="fa fa-user pr5"></i>Personal Detail<br>Step Four</h4>
        <section class="wizard-section">
            <div class="form-group">
                <label class="col-md-3 control-label"> SBB Card Number </label>
                <div class="col-md-6">
                    <input type="text" name="sbb" id="sbb"
                        class="select2-single form-control" value="{{$emps->sbb_card_no}}" placeholder="Enter SBB card Number">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Education</label>
                <div class="col-md-6">
                    <input type="text" name="education" id="education"
                           class="select2-single form-control" value="{{$emps->education}}" placeholder="Enter Education">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Phone Number</label>
                <div class="col-md-6">
                    <input type="text" name="phone" id="phone"
                           class="select2-single form-control" value="{{$emps->phone}}" placeholder="Enter Phone Number">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Residential Address</label>
                <div class="col-md-6">
                    <input type="text" name="resaddress" id="resaddress"
                           class="select2-single form-control" value="{{$emps->residential_address}}" placeholder="Enter Residential Address">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Principle Address </label>
                <div class="col-md-6">
                    <input type="text" name="principle" id="principle"
                           class="select2-single form-control" value="{{$emps->principle_address}}" placeholder="Enter Principle Address">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Email </label>
                <div class="col-md-6">
                    <input type="text" name="email" id="email"
                           class="select2-single form-control" value="{{$emps->email}}" placeholder="Enter Email Address">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Report To Whom</label>
                <div class="col-md-6">
                    <input type="text" name="report" id="report"
                           class="select2-single form-control" value="{{$emps->report_to_whom}}" placeholder="Enter Report To whom">
                </div>
            </div>
        </div>
        </section>

        <!----------------------------END Step 4------------------------------->
    </div>
    <!------------------END WIZARD ------------------------------------------>
</form>

<div class="modal fade" tabindex="-1" role="dialog" id="notification-modal">
    @csrf
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="modal-header" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection