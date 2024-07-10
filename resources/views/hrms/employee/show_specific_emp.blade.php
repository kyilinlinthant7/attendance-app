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
    #column_option_status, #column_option_service, #start_date, #end_date, #minimum_salary, #maximum_salary {
        height: 35px;
    }
    #column_option_service {
        margin-right: 7px;
    }
    .emp-img {
        height: 50px !important;
    }
</style>

@section('content')
<!-- START CONTENT -->
<div class="content">
    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">

        <!-- -------------- Column Center -------------- -->
        <div class="chute-affix">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading col-md-6">
                            <span class="panel-title hidden-xs" style="color:black">{{ $empStatus }} Employees List ( {{ $emps->total()}} )</span><br />
                        </div>
                        <div class="panel-heading col-md-6 text-right">
                            <form action="/export-emp" method="POST" style="margin-top: -20px;">
                                <input type="hidden" name="emp_status" value="{{ $empStatus }}" />
                                @if(count($emps) > 0)
                                    <label for="exportEmp" style="color: black; font-size: 12px;">Export {{ $empStatus }} Employees: </label><br>
                                    <button type="submit" class="btn btn-success" id="exportEmp">Export</button>
                                @endif
                            </form>
                        </div>
                        
                        <br><br><br>
                        
                        @if (((count($emps) > 0) && $searching == false) || (count($emps) == 0 && $searching == true) || $searching == true)
                            <!-- Search Bar -->
                            {!! Form::open(['url' => '/employee-search', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
                            <input type="hidden" name="emp_status" value="{{ $empStatus }}">
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
                                <div class="col-md-12" style="margin-top: 20px">
                                    @if (Auth::user()->isAdmin() || Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isHrOfficerRecruit() || Auth::user()->isHrOfficerCompen() || Auth::user()->isHrER() || Auth::user()->isHrAssistant())
                                        <div class="col-md-2" style="margin-left: -14px">
                                            <label for="minimum_salary">Minimun Salary:</label>
                                            <input type="number" name="minimum_salary" id="minimum_salary" style="width: 160px" min="0">
                                        </div>
                                        <div class="col-md-2" style="margin-left: -15px">
                                            <label for="maximum_salary">Maximum Salary:</label>
                                            <input type="number" name="maximum_salary" id="maximum_salary" style="width: 160px" min="0">
                                        </div>
                                    @endif
                                    <div class="col-md-8">
                                        <!-- date ranger -->
                                        <div class="col-md-2">
                                            <label for="start_date" style="margin-left: -5px">Start Date:</label>
                                            <input type="date" name="start_date" id="start_date" style="margin-left: -7px">
                                        </div>
                                        <div class="col-md-2" style="margin-left: 15px">
                                            <label for="end_date" style="margin-left: -10px">End Date:</label>
                                            <input type="date" name="end_date" id="end_date" style="margin-left: -11px">
                                        </div>
    
                                        <div class="col-md-3">
                                            
                                        </div>
    
                                        <div class="col-md-3">
                                            <select name="service" id="column_option_service" style="margin-left: 55px; margin-top: 17px;">
                                                <option value="">Select Service Year</option>
                                                <option value="service_1">Under 1 Year</option>
                                                <option value="service_2">1 - 2 Years</option>
                                                <option value="service_3">2 - 3 Years</option>
                                                <option value="service_4">Above 3 Years</option>
                                            </select>
                                        </div>
    
                                        <div class="col-md-1">
                                            <input type="submit" value="Search" name="status_service_search" class="btn btn-primary" style="margin-left: 38px; margin-top: 17px;">
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            </div>
                        @endif
                        
                        <div class="panel-body pn">
                            @if(Session::has('flash_message'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif
                            <div class="row">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Profile</th>
                                            <th>Name</th>
                                            <th>Employee ID</th>
                                            <th>Position</th>
                                            <th>Department</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Joined Date</th>
                                            <th style="width: 140px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($emps) == 0)
                                            <tr>
                                                <th class="text-center" colspan="9">There is no {{ $empStatus }} employees to show.</th>
                                            </tr>
                                        @endif
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
                                                    <a href="view-emp/{{$emp->id}}" class="btn btn-primary" style="font-size: 10px;"><i class="fas fa-eye"></i></a>
                                                    <a href="/edit-emp/{{$emp->id}}" class="btn btn-warning" style="font-size: 10px;"><i class="fas fa-edit"></i></a>
                                                    <a href="/delete-emp/{{$emp->id}}" class="btn btn-danger" style="font-size: 10px;" onclick="return confirm('Are you sure want to delete the employee?')"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- pagination -->
                            <div class="card-footer d-flex justify-content-center">
                                <!-- {{ $emps->links() }} -->
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
