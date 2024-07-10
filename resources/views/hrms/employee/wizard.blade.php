@extends('hrms.layouts.base')

@section('content')
{{-- <header style="margin-top: 100px"></header> --}}

<br><br>
<form method="post" action="/" id="custom-form-wizard" class="form-horizontal" style="margin-top: 50px; margin-left: 50px; margin-right: 30px;" enctype="multipart/form-data">
    
    <div class="wizard steps-bg steps-left">

      <!------------------- step 1 --------------------------->
        <h4 class="wizard-section-title">
            <i class="fa fa-user pr5"></i> Personal Info<br>Step one</h4>
        <section class="wizard-section">

            <div class="form-group">
                <label class="col-md-3 control-label">Employee ID:</label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="hidden" value="{{$emps->id}}" id="url" name="url">
                         
                        <input type="text" name="emp_code" id="emp_code"
                            class="select2-single form-control" value="{{$emps->employee_id}}" placeholder="Enter Employee ID">
                    @else
                        <input type="text" name="emp_code" id="emp_code"
                            class="select2-single form-control" placeholder="Enter Employee ID">
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Finger Print ID:</label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="text" name="fingerprint" id="fingerprint"
                            class="select2-single form-control" value="{{$emps->finger_print_id}}" placeholder="Enter Finger Print ID">
                    @else
                        <input type="text" name="fingerprint" id="fingerprint"
                            class="select2-single form-control" placeholder="Enter Finger Print ID">
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Employee Name:</label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="text" name="name" id="name"
                            class="select2-single form-control" value="{{$emps->name}}" placeholder="Enter Name"
                            required>
                    @else
                        <input type="text" name="name" id="name"
                            class="select2-single form-control" placeholder="Enter Name"
                            required>
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-3 control-label">Father Name:</label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="text" name="father" id="father" class="select2-single form-control" value="{{$emps->father_name}}" placeholder="Enter Name">
                    @else
                        <input type="text" name="father" id="father" class="select2-single form-control" placeholder="Enter Father's Name">
                    @endif
                </div>
            </div>
            
            <!--<div class="form-group">-->
            <!--    <label class="col-md-3 control-label"> Photo: </label>-->
            <!--    <div class="col-md-4">-->
                    <!--@if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')-->
                    <!--    <input type="file" class="form-control" name="photo" id="photo" accept="image/*">-->
                        <!--<input type="text" name="photo_value" id="photo_value" value="@if($emps->photo) {{ $emps->photo }} @endif">-->
                    <!--@else-->
                    <!--    <input type="file" class="form-control" name="photo" id="photo" accept="image/*">-->
                    <!--@endif-->
                    
            <!--       <input type="file" class="form-control" name="photo" id="photo" accept="image/*">\-->
            <!--    </div>-->
            <!--</div>-->
            
            <div class="form-group">
                <label class="col-md-3 control-label"> Gender: </label>
                <div class="col-md-2">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <select class="select2-multiple form-control select-primary" name="gender" id="gender">
                            <option value="male" @if($emps->gender == 'male' || $emps->gender == 'Male') selected @endif>Male</option>
                            <option value="female" @if($emps->gender == 'female' || $emps->gender == 'Female') selected @endif>Female</option>
                        </select>
                    @else
                        <select class="select2-multiple form-control select-primary" name="gender" id="gender">
                            <option value="" selected>Select One</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    @endif    
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-3 control-label"> Date Of Birth: </label>
                <div class="col-md-2">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="date" name="dob" id="dob" value="{{ \Carbon\Carbon::parse($emps->date_of_birth)->format('Y-m-d') }}" placeholder="Choose date of Birth" class="select2-single form-control">
                    @else
                        <input type="date" name="dob" id="dob" placeholder="Choose date of Birth" class="select2-single form-control">
                    @endif  
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-3 control-label"> Age: </label>
                <div class="col-md-2">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="number" min="18" name="age" id="age" class="select2-single form-control" value="{{$emps->age}}">
                    @else
                        <input type="number" min="18" name="age" id="age" class="select2-single form-control">
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Age Group: </label>
                <div class="col-md-2">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <select class="select2-multiple form-control select-primary" name="agegroup" id="agegroup">
                            <option value="under25" @if($emps->age_group == 'under25') selected @endif>Under 25</option>
                            <option value="between25and45" @if($emps->age_group == 'between25and45') selected @endif>Between 25 and 45</option>
                            <option value="above45" @if($emps->age_group == 'above45') selected @endif>Above 45</option>
                        </select>
                    @else
                        <select class="select2-multiple form-control select-primary" name="agegroup" id="agegroup">
                            <option value="" selected>Select One</option>
                            <option value="under25">Under 25</option>
                            <option value="between25and45">Between 25 and 45</option>
                            <option value="above45">Above 45</option>
                        </select>
                    @endif
                </div>
            </div>
            
        </section>


        <!------------------END Step 1 ------------------------->


        <!------------------- Step 2 ----------------------------->

        <h4 class="wizard-section-title">
        <i class="fa fa-user pr5"></i> Job Info &emsp;&emsp; <br>Step Two</h4>
        <section class="wizard-section">
            <div class="form-group">
                <label class="col-md-3 control-label"> Position: </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="text" name="position" id="position" class="select2-single form-control" value="{{$emps->position}}" placeholder="Enter Poition">
                    @else
                        <input type="text" name="position" id="position" class="select2-single form-control" placeholder="Enter Poition">
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-3 control-label"> Department: </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <select name="department" id="department" class="select2-multiple form-control" style="width: 100%"style="width: 100%"
                            <option value="">Select Department</option>
                            <option value="Management" @if($emps->department == 'Management') selected @endif>Management</option>
                            <option value="Admin" @if($emps->department == 'Admin') selected @endif>Admin</option>
                            <option value="Digital Marketing" @if($emps->department == 'Digital Marketing') selected @endif>Digital Marketing</option>
                            <option value="Finance & Account" @if($emps->department == 'Finance & Account') selected @endif>Finance & Account</option>
                            <option value="Human Resources" @if($emps->department == 'Human Resources') selected @endif>Human Resources</option>
                            <option value="Sales & Marketing" @if($emps->department == 'Sales & Marketing') selected @endif>Sales & Marketing</option>
                            <option value="Operation" @if($emps->department == 'Operation') selected @endif>Operation</option>
                            <option value="Contract Cleaning" @if($emps->department == 'Contract Cleaning') selected @endif>Contract Cleaning</option>
                            <option value="Health Safety & Environmental" @if($emps->department == 'Health Safety & Environmental') selected @endif>Health Safety & Environmental</option>
                            <option value="QA/AC" @if($emps->department == 'QA/AC') selected @endif>QA/AC</option>
                            <option value="IT" @if($emps->department == 'IT') selected @endif>IT</option>
                        </select>
                        <!--<input type="text" name="department" id="department1" class="form-control" value="{{$emps->department}}" placeholder="Enter Department Name">-->
                    @else
                        <select name="department" id="department" class="select2-multiple form-control" style="width: 100%">
                            <option value="">Select Department</option>
                            <option value="Management">Management</option>
                            <option value="Admin">Admin</option>
                            <option value="Digital Marketing">Digital Marketing</option>
                            <option value="Finance & Account">Finance & Account</option>
                            <option value="Human Resources">Human Resources</option>
                            <option value="Sales & Marketing">Sales & Marketing</option>
                            <option value="Sales & Marketing">Operation</option>
                            <option value="Contract Cleaning">Contract Cleaning</option>
                            <option value="Health Safety & Environmental">Health Safety & Environmental</option>
                            <option value="QA/AC">QA/AC</option>
                            <option value="IT">IT</option>
                        </select>
                        <!--<input type="text" name="department" id="department" class="select2-single form-control" placeholder="Enter Department Name">-->
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-3 control-label">Sub Department:</label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <select name="subdepartment" id="subdepartment" class="form-control" style="width: 100%">
                            <option value="">Select Sub-Department</option>
                            <option value="Management" @if($emps->sub_department == 'Management') selected @endif>Management</option>
                            <option value="Administration" @if($emps->sub_department == 'Administration') selected @endif>Administration</option>
                            <option value="Q-First" @if($emps->sub_department == 'Q-First') selected @endif>Q-First</option>
                            <option value="Finance & Account" @if($emps->sub_department == 'Finance & Account') selected @endif>Finance & Account</option>
                            <option value="Human Resource" @if($emps->sub_department == 'Human Resource') selected @endif>Human Resource</option>
                            <option value="Sales & Marketing" @if($emps->sub_department == 'Sales & Marketing') selected @endif>Sales & Marketing</option>
                            <option value="Operation" @if($emps->sub_department == 'Operation') selected @endif>Operation</option>
                            <option value="Contract" @if($emps->sub_department == 'Contract') selected @endif>Contract</option>
                            <option value="High Rise Team" @if($emps->sub_department == 'High Rise Team') selected @endif>High Rise Team</option>
                            <option value="M & E" @if($emps->sub_department == 'M & E') selected @endif>M & E</option>
                            <option value="QA/QC" @if($emps->sub_department == 'QA/QC') selected @endif>QA/QC</option>
                            <option value="IT" @if($emps->sub_department == 'IT') selected @endif>IT</option>
                        </select>
                        <!--<input type="text" name="subdepartment" id="subdepartment" class="select2-single form-control" value="{{$emps->sub_department}}" placeholder="Enter Sub Department Name">-->
                    @else
                        <select name="subdepartment" id="subdepartment" class="select2-multiple form-control" style="width: 100%">
                            <option value="">Select Sub-Department</option>
                            <option value="Management">Management</option>
                            <option value="Administration">Administration</option>
                            <option value="Q-First">Q-First</option>
                            <option value="Finance & Account">Finance & Account</option>
                            <option value="Human Resource">Human Resource</option>
                            <option value="Sales & Marketing">Sales & Marketing</option>
                            <option value="Operation">Operation</option>
                            <option value="Contract">Contract</option>
                            <option value="High Rise Team">High Rise Team</option>
                            <option value="M & E">M & E</option>
                            <option value="QA/QC">QA/QC</option>
                            <option value="IT">IT</option>
                        </select>
                        <!--<input type="text" name="subdepartment" id="subdepartment" class="select2-single form-control"  placeholder="Enter Sub Department Name">-->
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Branch/Location:</label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <select name="branch" id="branch" class="form-control select2-multiple" style="width: 100%">
                            <option value="">Select a Location</option>
                            <option value="Yangon" @if($emps->branch_location == "Yangon") selected @endif>Yangon</option>
                            <option value="Mandalay" @if($emps->branch_location == "Mandalay") selected @endif>Mandalay</option>
                        </select>
                    @else
                        <select name="branch" id="branch" class="form-control select2-multiple" style="width: 100%">
                            <option value="">Select a City</option>
                            <option value="Yangon">Yangon</option>
                            <option value="Mandalay">Mandalay</option>
                        </select>
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-3 control-label"> Region/City: </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <select class="select2-multiple form-control select-primary" name="city" id="city" style="width: 100%">
                            <option value="{{$emps->region_city}}" selected>{{$emps->region_city}}</option>
                            <option value="Yangon">Yangon</option>
                            <option value="Mandalay">Mandalay</option>
                            <option value="Laukkai">Laukkai</option>
                        </select>
                    @else
                        <select class="select2-multiple form-control select-primary" name="city" id="city" style="width: 100%">
                            <option value="" selected>Select a City</option>
                            <option value="Yangon">Yangon</option>
                            <option value="Mandalay">Mandalay</option>
                            <option value="Laukkai">Laukkai</option>
                        </select>
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-3 control-label">Business / SBU Name:</label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <select name="sbu" id="sbu" class="form-control select2-multiple" style="width: 100%">
                            <option value="">Select SBU...</option>
                            @foreach($sbuNames as $sbu)
                                <option value="{{ $sbu->name }}" @if($emps->business_sbu_name) selected @endif>{{ $sbu->name }}</option>
                            @endforeach
                        </select>
                    @else
                        <select name="sbu" id="sbu" class="form-control select2-multiple" style="width: 100%">
                            <option value="">Select SBU...</option>
                            @foreach($sbuNames as $sbu)
                                <option value="{{ $sbu->name }}">{{ $sbu->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
                <div class="col-md-2">
                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addNewSbuModal"><i class="fas fa-plus"></i> Add New SBU</a>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-3 control-label"> Join Date: </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="date" class="form-control" name="joindate" id="joindate" value="{{ \Carbon\Carbon::parse($emps->date_of_joining)->format('Y-m-d') }}">
                    @else
                        <input type="date" class="form-control" name="joindate" id="joindate">
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Site Name:</label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <select class="select2-multiple form-control select-primary" name="site" id="site" style="width: 100%">
                            @foreach ($projects as $project )
                                @if($project->id == $emps->site_name)
                                    <option value="{{$project->id}}" selected>{{$project->name}}</option>
                                @else
                                    <option value="{{$project->id}}">{{$project->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    @else
                        <select class="select2-multiple form-control select-primary" name="site" id="site" style="width: 100%">
                            <option value="" selected>Select One</option>
                            @foreach ($projects as $project )
                                <option value="{{$project->id}}">{{$project->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
                
                <label class="col-md-2 control-label"> Shift:</label>
                <div class="col-md-2">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <select class="select2-multiple form-control select-primary"
                            name="shift" id="shift">
                            <option value="{{$emps->shift}}" selected>{{$emps->shift}}</option>
                            <option value="Day">Day</option>
                            <option value="Night">Night</option>
                        </select>
                    @else
                        <select class="select2-multiple form-control select-primary"
                            name="shift" id="shift">
                            <option value="" selected>Select One</option>
                            <option value="Day">Day</option>
                            <option value="Night">Night</option>
                        </select>
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-3 control-label"> Service: </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="text" name="service" id="service" class="select2-single form-control" value="{{$emps->service}}" placeholder="Enter Service (Year & Month)">
                    @else
                        <input type="text" name="service" id="service" class="select2-single form-control" placeholder="Enter Service (Year & Month)">
                    @endif
                </div>
            </div>
            
            <!--<div class="form-group">-->
            <!--    <label class="col-md-3 control-label"> Attach File: </label>-->
            <!--    <div class="col-md-4">-->
            <!--        @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')-->
            <!--            <input type="file" class="form-control" name="attach_file" id="attach_file" value="{{$emps->attach_file}}">-->
            <!--        @else-->
            <!--            <input type="file" class="form-control" name="attach_file" id="attach_file">-->
            <!--        @endif-->
            <!--    </div>-->
            <!--</div>-->

            <div class="form-group">
                <label class="col-md-3 control-label"> Employment Status: </label>
                <div class="col-md-2">
                    <select class="select2-multiple form-control select-primary" name="status" id="statusSelect" onchange="toggleDateInputs()">
                        @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                            <option value="{{$emps->status}}" selected>{{$emps->status}}</option>
                        @else
                            <option value="" selected>Select One</option>
                        @endif
                        <option value="Probation">Probation</option>
                        <option value="Permanent">Permanent</option>
                        <option value="Resign">Resign</option>
                        <option value="Warning">Warning</option>
                        <option value="Dismiss">Dismiss</option>
                        <option value="Terminate">Terminate</option>
                        <option value="Promotion">Promotion</option>
                        <option value="Increment">Increment</option>
                    </select>
                </div>
                
                <!-- Employment Status Date -->
                <label class="col-md-1 control-label"> From: </label>
                <div class="col-md-2" id="fromDateInputs">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="date" class="form-control" name="probation_date_from" id="probation_date_from" value="{{$emps->probation_date_from}}">
                        <input type="date" class="form-control" name="permanent_date_from" id="permanent_date_from" value="{{$emps->permanent_date_from}}">
                        <input type="date" class="form-control" name="resign_date_from" id="resign_date_from" value="{{$emps->resign_date_from}}">
                        <input type="date" class="form-control" name="warning_date_from" id="warning_date_from" value="{{$emps->warning_date_from}}">
                        <input type="date" class="form-control" name="dismiss_date_from" id="dismiss_date_from" value="{{$emps->dismiss_date_from}}">
                        <input type="date" class="form-control" name="terminate_date_from" id="terminate_date_from" value="{{$emps->terminate_date_from}}">
                        <input type="date" class="form-control" name="promotion_date_from" id="promotion_date_from" value="{{$emps->promotion_date_from}}">
                        <input type="date" class="form-control" name="increment_date_from" id="increment_date_from" value="{{$emps->increment_date_from}}">
                    @else
                        <input type="date" class="form-control" name="probation_date_from" id="probation_date_from">
                        <input type="date" class="form-control" name="permanent_date_from" id="permanent_date_from">
                        <input type="date" class="form-control" name="resign_date_from" id="resign_date_from">
                        <input type="date" class="form-control" name="warning_date_from" id="warning_date_from">
                        <input type="date" class="form-control" name="dismiss_date_from" id="dismiss_date_from">
                        <input type="date" class="form-control" name="terminate_date_from" id="terminate_date_from">
                        <input type="date" class="form-control" name="promotion_date_from" id="promotion_date_from">
                        <input type="date" class="form-control" name="increment_date_from" id="increment_date_from">
                    @endif
                </div>
                <label class="col-md-1 control-label"> To: </label>
                <div class="col-md-2" id="toDateInputs">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="date" class="form-control" name="probation_date_to" id="probation_date_to" value="{{$emps->probation_date_to}}">
                        <input type="date" class="form-control" name="permanent_date_to" id="permanent_date_to" value="{{$emps->permanent_date_to}}">
                        <input type="date" class="form-control" name="resign_date_to" id="resign_date_to" value="{{$emps->resign_date_to}}">
                        <input type="date" class="form-control" name="warning_date_to" id="warning_date_to" value="{{$emps->warning_date_to}}">
                        <input type="date" class="form-control" name="dismiss_date_to" id="dismiss_date_to" value="{{$emps->dismiss_date_to}}">
                        <input type="date" class="form-control" name="terminate_date_to" id="terminate_date_to" value="{{$emps->terminate_date_to}}">
                        <input type="date" class="form-control" name="promotion_date_to" id="promotion_date_to" value="{{$emps->promotion_date_to}}">
                        <input type="date" class="form-control" name="increment_date_to" id="increment_date_to" value="{{$emps->increment_date_to}}">
                    @else
                        <input type="date" class="form-control" name="probation_date_to" id="probation_date_to">
                        <input type="date" class="form-control" name="permanent_date_to" id="permanent_date_to">
                        <input type="date" class="form-control" name="resign_date_to" id="resign_date_to">
                        <input type="date" class="form-control" name="warning_date_to" id="warning_date_to">
                        <input type="date" class="form-control" name="dismiss_date_to" id="dismiss_date_to">
                        <input type="date" class="form-control" name="terminate_date_to" id="terminate_date_to">
                        <input type="date" class="form-control" name="promotion_date_to" id="promotion_date_to">
                        <input type="date" class="form-control" name="increment_date_to" id="increment_date_to">
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-3 control-label"> Reason: </label>
                <div class="col-md-6">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <textarea class="form-control" name="reason" id="reason" placeholder="Enter reason for employment status...">{{$emps->reason}}</textarea>
                    @else
                        <textarea class="form-control" name="reason" id="reason" placeholder="Enter reason for employment status..."></textarea>
                    @endif
                </div>
            </div>

        </section>

        <!------------------END Step 2---------------------------------->




        <!----------------Step 3 ---------------------------------------->

        <h4 class="wizard-section-title">
            <i class="fa fa-user pr5"></i> Payroll Info &emsp; <br>Step Three</h4>
        <section class="wizard-section">
            <div class="form-group">
                <label class="col-md-3 control-label"> Basic Salary (Monthly): </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="text" name="basicsalarymonthly" id="basicsalarymonthly" class="select2-single form-control" value="{{$emps->basic_salary_monthly}}" placeholder="Enter Basic Salary (Monthly)">
                    @else
                        <input type="text" name="basicsalarymonthly" id="basicsalarymonthly" class="select2-single form-control" placeholder="Enter Basic Salary (Monthly)"> 
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Basic Salary (Yearly): </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="text" name="basicsalaryyearly" id="basicsalaryyearly" class="select2-single form-control" value="{{$emps->basic_salary_yearly}}" placeholder="Enter Basic Salary (Yearly)">
                    @else
                        <input type="text" name="basicsalaryyearly" id="basicsalaryyearly" class="select2-single form-control" placeholder="Enter Basic Salary (Yearly)"> 
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Salary Currnecy: </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <select class="select2-multiple form-control select-primary" name="currency" id="currency">
                            <option value="{{$emps->salarycurrency}}" selected>{{$emps->salary_currency}}</option>
                            <option value="ks">Kyats</option>
                            <option value="Dollar">Dollar</option>
                            <option value="Yen">Yen</option>
                        </select>
                    @else
                        <select class="select2-multiple form-control select-primary" name="currency" id="currency">
                            <option value="" selected>Select One</option>
                            <option value="kyat">Kyats</option>
                            <option value="Dollar">Dollar</option>
                            <option value="Yen">Yen</option>
                        </select>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Covid-19 Vaccine Status: </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <select class="select2-multiple form-control select-primary"
                            name="covid" id="covid">
                            <option value="{{$emps->covid19_vaccine_status}}" selected>{{$emps->covid19_vaccine_status}}</option>
                            <option value="Done">Done</option>
                            <option value="Not yet">Not yet </option>
                        </select>
                    @else
                        <select class="select2-multiple form-control select-primary"
                            name="covid" id="covid">
                            <option value="" selected>Select One</option>
                            <option value="Done">Done</option>
                            <option value="Not Yet">Not Yet</option>
                        </select>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Marital Status: </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <select class="select2-multiple form-control select-primary" name="marital" id="marital">
                            <option value="Single" @if($emps->marital_status == 'Single') selected @endif>Single</option>
                            <option value="Married" @if($emps->marital_status == 'Married') selected @endif>Married</option>
                        </select>
                    @else
                        <select class="select2-multiple form-control select-primary" name="marital" id="marital">
                            <option value="" selected>Select One</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                        </select>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Child: </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <select class="select2-multiple form-control select-primary"
                            name="child" id="child">
                            <option value="{{$emps->child}}" selected>{{$emps->child}}</option>
                            <option value="withchild">Yes</option>
                            <option value="withoutChild">No</option>
                        </select>
                    @else
                        <select class="select2-multiple form-control select-primary"
                            name="child" id="child">
                            <option value="" selected>Select One</option>
                            <option value="withchild">Yes</option>
                            <option value="withoutChild">No</option>
                        </select>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> With Parent: </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <select class="select2-multiple form-control select-primary" name="parent" id="parent" style="width: 200px;">
                            <option value="{{$emps->with_parent}}" selected>{{$emps->with_parent}}</option>
                            <option value="withparent">With Parent</option>
                            <option value="withoutparent">Without Parent</option>
                        </select>
                    @else
                        <select class="select2-multiple form-control select-primary" name="parent" id="parent" style="width: 200px;">
                            <option value="" selected>Select One</option>
                            <option value="withparent">With Parent</option>
                            <option value="withoutparent">Without Parent</option>
                        </select>
                    @endif
                </div>
            </div>

        </section>

        <!---------------------END Step 3 ---------------------------------->




        <!---------------------Step 4 ------------------------------>

        <h4 class="wizard-section-title">
            <i class="fa fa-user pr5"></i>General Detail<br>Step Four</h4>
        <section class="wizard-section">
            
            <div class="form-group">
                <label class="col-md-3 control-label"> NRC No / Passport No: </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="text" name="nrc" id="nrc"
                            class="select2-single form-control" value="{{$emps->nrc_passport}}" placeholder="NRC or Passport">
                    @else
                        <input type="text" name="nrc" id="nrc"
                            class="select2-single form-control" placeholder="NRC or Passport">
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-3 control-label"> SBB Card Number: </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="text" name="sbb" id="sbb"
                        class="select2-single form-control" value="{{$emps->sbb_card_no}}" placeholder="Enter SBB card Number">
                    @else
                        <input type="text" name="sbb" id="sbb"
                        class="select2-single form-control" placeholder="Enter SBB card Number">
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Education:</label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="text" name="education" id="education"
                        class="select2-single form-control" value="{{$emps->education}}" placeholder="Enter Education">
                    @else
                        <input type="text" name="education" id="education"
                        class="select2-single form-control" placeholder="Enter Education">
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Phone Number:</label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="text" name="phone" id="phone"
                        class="select2-single form-control" value="{{$emps->phone}}" placeholder="Enter Phone Number">
                    @else
                        <input type="text" name="phone" id="phone"
                        class="select2-single form-control" placeholder="Enter Phone Number">
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Residential Address: </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="text" name="resaddress" id="resaddress"
                        class="select2-single form-control" value="{{$emps->residential_address}}" placeholder="Enter Residential Address">
                    @else
                        <input type="text" name="resaddress" id="resaddress"
                        class="select2-single form-control" placeholder="Enter Residential Address">
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Principle Address: </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="text" name="principle" id="principle"
                        class="select2-single form-control" value="{{$emps->principle_address}}" placeholder="Enter Principle Address">
                    @else
                        <input type="text" name="principle" id="principle"
                        class="select2-single form-control" placeholder="Enter Principle Address">
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Email: </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="email" name="email" id="email" class="select2-single form-control" value="{{$emps->email}}" placeholder="Enter Email Address">
                    @else
                        <input type="email" name="email" id="email" class="select2-single form-control"  placeholder="Enter Email Address">
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"> Report To Whom: </label>
                <div class="col-md-4">
                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                        <input type="text" name="report" id="report" class="select2-single form-control" value="{{$emps->report_to_whom}}" placeholder="Enter Report To whom">
                    @else
                        <input type="text" name="report" id="report" class="select2-single form-control" placeholder="Enter Report To whom">
                    @endif
                </div>
            </div>
        </div>
        </section>

        <!----------------------------END Step 4------------------------------->
    </div>
    <!------------------END WIZARD ------------------------------------------>
</form>

<!-- Add New SBU Form -->
<div class="modal fade" id="addNewSbuModal" tabindex="-1" role="dialog" aria-labelledby="addNewSbuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            @if(Session::has('flash_message'))
                <div class="alert alert-success">
                    {{Session::get('flash_message')}}
                </div>
            @endif
            <form  action="/save-sbu-name" method="POST" class="form-horizontal">
            <div class="modal-header">
                <h3 class="modal-title text-center" id="exampleModalLabel"> Add New Business Sub Unit <span aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" style="float:right">&times;</span></h3>
            </div>
            <div class="modal-body">
                <div class="form-group modal-field">
                    <label for="name" class="col-md-3 control-label">SBU Name:</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-building" aria-hidden="true"></i>
                            </div>
                            <input type="text" id="sbu_name" class="select2-single form-control" name="sbu_name" placeholder="Enter SBU Name..." required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit"  class="btn btn-success">Save</button>
            </div>
        </form>
        </div>
    </div>
</div>
                                        
<div class="modal fade" tabindex="-1" role="dialog" id="notification-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="modal-header" class="modal-header">
                <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="ok" data-dismiss="modal">Ok</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    function toggleDateInputs() {
        
        var status = document.getElementById("statusSelect").value;
        var fromDateInputs = document.getElementById("fromDateInputs");
        var toDateInputs = document.getElementById("toDateInputs");

        fromDateInputs.innerHTML = "";
        toDateInputs.innerHTML = "";

        if (status === "Probation" || status === "Permanent" || status === "Resign" || status === "Warning" || status === "Dismiss" || status === "Terminate" || status === "Promotion" || status === "Increment") {
            var fromDateInput = document.createElement("input");
            fromDateInput.type = "date";
            fromDateInput.className = "form-control";
            fromDateInput.name = status.toLowerCase() + "_date_from";
            fromDateInput.id = status.toLowerCase() + "_date_from";
            fromDateInputs.appendChild(fromDateInput);

            var toDateInput = document.createElement("input");
            toDateInput.type = "date";
            toDateInput.className = "form-control";
            toDateInput.name = status.toLowerCase() + "_date_to";
            toDateInput.id = status.toLowerCase() + "_date_to";
            toDateInputs.appendChild(toDateInput);
        }
    }

    toggleDateInputs();
    document.getElementById("statusSelect").addEventListener("change", toggleDateInputs);
</script>
    
@endsection
