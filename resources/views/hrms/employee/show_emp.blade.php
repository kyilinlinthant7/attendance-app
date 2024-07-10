@extends('hrms.layouts.base')

<style>
    #column_option_age {
        height: 35px;
        margin-left: 8.5px;
        width: 172px;
    }
    #column_option_gender {
        width: 145px;
        height: 35px;
    }
    #column_option_status, #column_option_service, #start_date, #end_date, #minimum_salary, #maximum_salary, #site {
        height: 35px;
    }
    #column_option_service {
        margin-right: 7px;
    }
    .emp-img {
        height: 50px !important;
    }
    input[type="date"], select {
        cursor: pointer;
    }
    input[type="date"] {
        width: 108px;
    }
</style>

@section('content')
        <!-- START CONTENT -->
<div class="content">

    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">

        <!-- -------------- Column Center -------------- -->
        <div class="chute-affix">

            <!-- -------------- Products Status Table -------------- -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading col-md-6">
                            <span class="panel-title hidden-xs" style="color:black">Employees List ( {{ $emps->total()}} )</span><br />
                        </div>
                        <div class="col-md-6 text-right">
                            <!-- import button -->
                            <a href="/upload-emp">
                                <input type="button" value="Import" name="button" class="btn btn-primary">
                            </a>

                            <!-- create button -->
                            <a href="/add-employee" class="btn btn-success">Create</a>
                        </div>
                        <br><br><br>

                        <!-- Search Bar -->
                        {!! Form::open(['url' => '/employee-manager', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}

                        <div class="panel-menu allcp-form theme-primary mtn">
                        <div class="row">
                            <!-- search by inputs + select field -->
                            <div class="col-md-3">
                                <input type="text" style="border:2px solid #F7730E; height: 42px !important;" class="field form-control" placeholder="Enter search keywords..." style="height:40px" value="{{$string}}" name="keywords">
                            </div>
                            <div class="col-md-3">
                               <label class="field select" style="margin-left: -20px">
                                   {!! Form::select('column', getEmployeeDropDown(), $column) !!}
                                   <i class="arrow double"></i>
                               </label>
                            </div>
                            <div class="col-md-1">
                                <input type="submit" value="Search" name="each_search" class="btn btn-primary" style="margin-left: -40px">
                            </div>

                            <!-- dropdowns search -->
                            <div class="col-md-2 age-box">
                                <label for="column_option_age"></label>
                                <div class="input-group">
                                    <select name="age" id="column_option_age" class="">
                                        <option value="">Select Age-Group</option>
                                        <option value="age_group_1">Under 25</option>
                                        <option value="age_group_2">Between 25 and 45</option>
                                        <option value="age_group_3">Above 45</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="arrow double"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 gender-box">
                                <label for="column_option_gender"></label>
                                <div class="input-group">
                                    <select name="gender" id="column_option_gender" class="">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="arrow double"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-1">
                                <input type="submit" value="Search" name="gender_age_search" class="btn btn-primary" style="margin-left: -30px">
                            </div>

                            <hr class="col-md-12" style="margin-bottom: -10px">

                            <!-- salary range search -->
                            <div class="col-md-12" style="margin-top: 20px;">
                                <!--@if (Auth::user()->isAdmin() || Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isHrOfficerRecruit() || Auth::user()->isHrOfficerCompen() || Auth::user()->isHrER() || Auth::user()->isHrAssistant())-->
                                <!--    <div class="col-md-2" style="margin-left: -14px">-->
                                <!--        <label for="minimum_salary">Minimun Salary:</label>-->
                                <!--        <input type="number" name="minimum_salary" id="minimum_salary" style="width: 160px" min="0">-->
                                <!--    </div>-->
                                <!--    <div class="col-md-2" style="margin-left: -15px">-->
                                <!--        <label for="maximum_salary">Maximum Salary:</label>-->
                                <!--        <input type="number" name="maximum_salary" id="maximum_salary" style="width: 160px" min="0">-->
                                <!--    </div>-->
                                <!--@endif-->
                                <div class="col-md-3" style="margin-left: -14px">
                                    <label for="site">Site Name:</label>
                                    <select name="site" id="site">
                                        <option value="">Select a Site</option>
                                        @foreach($sites as $site)
                                            <option value="{{ $site->name }}">{{ $site->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <input type="submit" value="Export" class="btn btn-success" style="margin-top: 17px;">
                                </div>
                                    
                                <div class="col-md-8">
                                    <!-- date ranger -->
                                    <div class="col-md-2">
                                        <label for="start_date" style="">Start Date:</label><br>
                                        <input type="date" name="start_date" id="start_date" style="">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date" style="">End Date:</label><br>
                                        <input type="date" name="end_date" id="end_date" style="">
                                    </div>

                                    <div class="col-md-3">
                                        <select name="status" id="column_option_status" style="margin-top: 17px; margin-left: -10px;">
                                            <option value="">Select Employee Status</option>
                                            <option value="Probation">Probation</option>
                                            <option value="Permanent">Permanent</option>
                                            <option value="Resign">Resign</option>
                                            <option value="Warning">Warning</option>
                                            <option value="Dismiss">Dismiss</option>
                                            <option value="Terminate">Terminate</option>
                                            <option value="Promotion">Promotion</option>
                                            @if (Auth::user()->isAdmin() || Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isHrOfficerRecruit() || Auth::user()->isHrOfficerCompen() || Auth::user()->isHrER() || Auth::user()->isHrAssistant())
                                                <option value="increment">Increment</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <select name="service" id="column_option_service" style="margin-top: 17px; margin-left: -4px;">
                                            <option value="">Select Service Year</option>
                                            <option value="service_1">Under 1 Year</option>
                                            <option value="service_2">1 - 2 Years</option>
                                            <option value="service_3">2 - 3 Years</option>
                                            <option value="service_4">Above 3 Years</option>
                                        </select>
                                    </div>

                                    <div class="col-md-1">
                                        <input type="submit" value="Search" name="status_service_search" class="btn btn-primary" style="margin-top: 17px; margin-left: -20px;">
                                    </div>
                                </div>
                            </div>

                            <!--<div class="col-md-2">-->
                            <!--    <a href="">-->
                            <!--    <input type="button" value="Export" name="button" class="btn btn-success"></a>-->
                            <!--</div>-->
                            {!! Form::close() !!}
                            <!--<div class="col-md-2">-->
                            <!--    <a href="/employee-manager" >-->
                            <!--        <input type="submit" value="Reset" class="btn btn-warning"></a>-->
                            <!--</div>-->
                        </div>
                        </div>

                        <!-- Table View -->
                        <div class="panel-body pn" id="table-view">
                            @if(Session::has('flash_message'))
                                <div class="alert alert-success" id="flash-message">
                                    {{ Session::get('flash_message') }}
                                    &emsp; &emsp;
                                    <button type="button" id="close-button" style="background: none; border: none; float: right; font-size: 20px; font-weight: bold; line-height: 1; color: #000; text-shadow: 0 1px 0 #fff; opacity: .5;" onclick="closeAlert()">&times;</button>
                                </div>
                            @endif
                            <script>
                                function closeAlert() {
                                    document.getElementById('flash-message').style.display = 'none';
                                }
                            </script>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Employee ID</th>
                                        <th>Position</th>
                                        <th>Department</th>
                                        <th>Site Name</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Joined Date</th>
                                        <th style="width: 170px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($emps as $emp)
                                        <tr class="bg-light" style="border: 1px solid #a7920c;">
                                            <td style="border-radius: 5px;">
                                                <img src="@if ($emp->photo) {{ URL::asset('public/userimages/' . $emp->photo) }} @else {{ URL::asset('public/userimages/user.png') }} @endif" class="img-responsive emp-img" width="50" height="50" style="border-radius:40%;border:1px solid #000000">
                                            </td>
                                            <td>
                                                <p style="font-size: 16px">{{$emp->name}}</p>
                                            </td>
                                            <td>
                                                <p style="font-size: 12px">{{$emp->employee_id}}</p>
                                            </td>
                                            <td>
                                                <p style="font-size: 14px">{{$emp->position}}</p>
                                            </td>
                                            <td>
                                                <p style="font-size: 14px">{{$emp->sub_department}}</p>
                                            </td>
                                            <td>
                                                <p style="font-size: 14px">
                                                    @if($emp->siteName)
                                                        {{ $emp->siteName->name }}
                                                    @else
                                                        {{ $emp->site_name }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td>
                                                <p style="font-size: 14px">{{$emp->phone}}</p>
                                            </td>
                                            <td>
                                                <p style="font-size: 14px">{{$emp->status}}</p>
                                            </td>
                                            <td>
                                                <?php 
                                                    $date = new DateTime($emp->date_of_joining);
                                                    $formattedDate = $date->format('d-M-Y');
                                                ?>
                                                <p style="font-size: 12px">{{$formattedDate}}</p>
                                            </td>
                                            <td>
                                                <a href="print-emp/{{$emp->id}}" class="btn btn-success" style="font-size: 10px;"><i class="fas fa-print"></i></a>
                                                <a href="view-emp/{{$emp->id}}" class="btn btn-primary" style="font-size: 10px;"><i class="fas fa-eye"></i></a>
                                                <a href="/edit-emp/{{$emp->id}}" class="btn btn-warning" style="font-size: 10px;"><i class="fas fa-edit"></i></a>
                                                <a href="/delete-emp/{{$emp->id}}" class="btn btn-danger" style="font-size: 10px;" onclick="return confirm('Are you sure want to delete the employee?')"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- pagination -->
                            <div class="card-footer d-flex justify-content-center">
                                {{ $emps->appends(request()->input())->links() }}
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
