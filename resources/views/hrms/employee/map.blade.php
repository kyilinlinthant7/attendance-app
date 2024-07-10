@extends('hrms.layouts.base')

    <style>
        .gray-box {
            background-color: #f7f8ff;
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .small-text {
            font-size: 10px;
        }
        .img-detail {
            width: 150px !important;
            height: 150px !important;
            object-fit: cover;
        }
    </style>


@section('content')
    
<div class="content">

    <!-- <header id="topbar" class="alt">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="breadcrumb-icon">
                    <a href="/dashboard">
                        <span class="fa fa-home"></span>
                    </a>
                </li>
                <li class="breadcrumb-active">
                    <a href="/dashboard"> Dashboard </a>
                </li>
                <li class="breadcrumb-link">
                    <a href=""> Employees </a>
                </li>
                <li class="breadcrumb-current-item"> Employee Detail</li>
            </ol>
        </div>
    </header> -->


    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">
        <!-- -------------- Column Center -------------- -->
        <div class="chute-affix">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                        <div class="panel">
                            <div class="row">
                                <div class="panel-heading col-md-8">
                                    <h4 class="panel-title hidden-xs" style="color: black; margin-left: 34px;">Employee Details</h4><br />
                                </div>
                                <div class="col-md-4 text-right" style="margin-left: -24px;">
                                    <div class="col-md-4">
                                        <a href="/employee-manager" class="btn btn-primary"><i class="fas fa-chevron-left"></i> Back</a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="/edit-emp/{{$emp->id}}" class="btn btn-info"><i class="fas fa-edit"></i> Edit</a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="/delete-emp/{{$emp->id}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete the employee?')"><i class="fas fa-trash"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="panel-body" style="margin-top: -10px">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <img src="@if ($emp->photo) {{ URL::asset('public/userimages/' . $emp->photo) }} @else {{ URL::asset('public/userimages/user.png') }} @endif" class="img-responsive img-detail" width="150" height="150" style="border-radius: 5px;">
                                        </div>
                                        <div class="col-md-6 img-responsive" width="150" height="150">
                                            <h5 class="text-center" style="margin-top: 15px; font-weight: bold;">{{$emp->name}}</h5>
                                            <br>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="gray-box">
                                                <p class="small-text">Employee ID</p>
                                                <span>{{$emp->employee_id}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="gray-box">
                                                <p class="small-text">Position</p>
                                                <span>{{$emp->position}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="gray-box">
                                                <p class="small-text">Sub Department</p>
                                                <span>{{$emp->sub_department}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="gray-box">
                                                <p class="small-text">Joined Date</p>
                                                <?php 
                                                    $date = new DateTime($emp->date_of_joining);
                                                    $formattedDate = $date->format('d-M-Y');
                                                ?>
                                                <span>{{$formattedDate}}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-8">

                                        <!-- Personal Info -->
                                        <div class="col-md-12">
                                            <h5 style="margin-left: 5px">Personal Info:</h5>
                                            <div class="gray-box">
                                                <p class="small-text">Full Name</p>
                                                @if($emp->name) <span>{{$emp->name}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Birthdate</p>
                                                <?php 
                                                    $date = new DateTime($emp->date_of_birth);
                                                    $formattedDate = $date->format('d-M-Y');
                                                ?>
                                                @if($emp->date_of_birth) <span>{{$formattedDate}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Age</p>
                                                @if($emp->age) <span>{{$emp->age}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Gender</p>
                                                @if($emp->gender) <span>{{$emp->gender}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Age Group</p>
                                                @if($emp->age_group) <span>{{$emp->age_group}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Father's Name</p>
                                                @if($emp->father_name) <span>{{$emp->father_name}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Region/City</p>
                                                @if($emp->region_city) <span>{{$emp->region_city}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Marital Status</p>
                                                @if($emp->marital_status) <span>{{$emp->marital_status}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Fingerprint ID</p>
                                                @if($emp->finger_print_id) <span>{{$emp->finger_print_id}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="gray-box">
                                                <p class="small-text">Education</p>
                                                @if($emp->education) <span>{{$emp->education}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">NRC/Passport</p>
                                                @if($emp->nrc_passport) <span>{{$emp->nrc_passport}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">SBB Card No.</p>
                                                @if($emp->sbb_card_no) <span>{{$emp->sbb_card_no}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="gray-box">
                                                <p class="small-text">Covid-19 Vaccine Status</p>
                                                @if($emp->covid19_vaccine_status) <span>{{$emp->covid19_vaccine_status}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Children</p>
                                                @if($emp->child) <span>{{$emp->child}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Parent</p>
                                                @if($emp->with_parent) <span>{{$emp->with_parent}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>

                                        <!-- Job Info -->
                                        <div class="col-md-12" style="margin-top: 20px">
                                            <h5 style="margin-left: 5px;">Job Info:</h5>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Fingerprint ID</p>
                                                @if($emp->finger_print_id) <span>{{$emp->finger_print_id}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Fingerprint ID</p>
                                                @if($emp->finger_print_id) <span>{{$emp->finger_print_id}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Department</p>
                                                @if($emp->department) <span>{{$emp->department}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Site</p>
                                                @if($emp->branch_location) <span>{{$emp->branch_location}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Shift</p>
                                                @if($emp->site_name) <span>{{$emp->site_name}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Branch/Location</p>
                                                @if($emp->shift) <span>{{$emp->shift}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Status</p>
                                                @if($emp->status) <span>{{$emp->status}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Business SBU Name</p>
                                                @if($emp->business_sbu_name) <span>{{$emp->business_sbu_name}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Service Time</p>
                                                @if($emp->service) <span>{{$emp->service}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Business SBU Name</p>
                                                @if($emp->business_sbu_name) <span>{{$emp->business_sbu_name}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>

                                        <!-- salary info for HR Manager role only -->
                                        @if(Auth::user()->isAdmin() || Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isHrOfficerRecruit() || Auth::user()->isHrOfficerCompen() || Auth::user()->isHrER() || Auth::user()->isHrAssistant())
                                            <div class="col-md-12">
                                                <div class="gray-box">
                                                    <p class="small-text">Basic Salary(Monthly)</p>
                                                    @if($emp->basic_salary_monthly) <span>{{$emp->basic_salary_monthly}}</span> @else <span> Unknown </span> @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="gray-box">
                                                    <p class="small-text">Basic Salary(Yearly)</p>
                                                    @if($emp->basic_salary_yearly) <span>{{$emp->basic_salary_yearly}}</span> @else <span> Unknown </span> @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="gray-box">
                                                    <p class="small-text">Salary Currency</p>
                                                    @if($emp->salary_currency) <span>{{$emp->salary_currency}}</span> @else <span> Unknown </span> @endif
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Contact Info -->
                                        <div class="col-md-12" style="margin-top: 20px">
                                            <h5 style="margin-left: 5px;">Contact Info:</h5>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Phone</p>
                                                @if($emp->phone) <span>{{$emp->phone}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gray-box">
                                                <p class="small-text">Email</p>
                                                @if($emp->email) <span>{{$emp->email}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="gray-box">
                                                <p class="small-text">Residential Address</p>
                                                @if($emp->residential_address) <span>{{$emp->residential_address}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="gray-box">
                                                <p class="small-text">Principle Address</p>
                                                @if($emp->principle_address) <span>{{$emp->principle_address}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="gray-box">
                                                <p class="small-text">Report to Whom</p>
                                                @if($emp->report_to_whom) <span>{{$emp->report_to_whom}}</span> @else <span> Unknown </span> @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection