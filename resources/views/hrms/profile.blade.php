@extends('hrms.layouts.base')

<style>
    .panel-title {
        color: black !important;
    }
</style>

@section('content')

    <section id="content" class="animated fadeIn">

        <div class="row">

            <div class="col-md-6">
                
                @if($details)
                    <div class="box box-success">
                        <div class="panel">
                            <div class="panel-heading text-center">
                                <span class="panel-title">{{$details->name}}</span>
                            </div>
                            <div class="panel-body pn pb5 text-center">
                                <hr class="short br-lighter">
                                <img src="@if(Auth::user()->employeeData && Auth::user()->employeeData->photo) {{ URL::asset('public/userimages/' . Auth::user()->employeeData->photo) }} @else {{ URL::asset('public/userimages/user_white.jpg') }} @endif" width="102px" height="100px" class="img-thumbnail" alt="User Image">
                            </div>
                            <p class="text-center no-margin">{{ $details->userrole ? $details->userrole->role->name : 'Unknown Role' }}</p>
                            <p class="small text-center no-margin"><span class="text-muted">Department:</span> {{$details->department}}</p>
                            <p class="small text-center no-margin"><span class="text-muted">Employee ID:</span> {{$details->code}}</p>
                        </div>
                    </div>
                @endif
                
                <div class="box box-success" style="height: 73px;">
                    <div class="small-box bg-black">
                        <div class="inner datebar" align="center">
                            <p style="color: ghostwhite; background: gray;">{{\Carbon\Carbon::now()->format('l, jS \\of F, Y')}}</p>
                            <h3 style="color: ghostwhite" id="clock"></h3>
                            <br/>
                        </div>
                    </div>
                </div>
                    
                <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title">Bank Details</span>
                        </div>
                        <div class="panel-body pn pb5">
                            <hr class="short br-lighter">

                            <div class="box-body no-padding">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td style="width: 10px" class="text-center"><i class="fa fa-credit-card"></i></td>
                                            <td><strong>Account Number</strong></td>
                                            <td>@if(isset($details->account_number)) {{ $details->account_number ? $details->account_number : '' }} @endif</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 10px" class="text-center"><i class="fa fa-tags"></i></td>
                                            <td><strong>Pf Account Number</strong></td>
                                            <td>@if(isset($details->pf_account_number)) {{ $details->pf_account_number ? $details->pf_account_number : '' }} @endif</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 10px" class="text-center"><i class="fa fa-bank"></i></td>
                                            <td><strong>Bank Name</strong></td>
                                            <td>@if(isset($details->bank_name)) {{ $details->bank_name ? $details->bank_name : '' }} @endif</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 10px" class="text-center"><i class="fa fa-code"></i></td>
                                            <td><strong>Ifsc Code</strong></td>
                                            <td>@if(isset($details->isfc_code)) {{ $details->ifsc_code ? $details->ifsc_code : '' }} @endif</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 10px" class="text-center"><i class="fa fa-tags"></i></td>
                                            <td><strong>Un Number</strong></td>
                                            <td>@if(isset($details->un_number)) {{ $details->un_number ? $details->un_number : '' }} @endif</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-success">
                    <div class="panel">

                        <div class="panel-heading">
                            <span class="panel-title">Personal Details</span>
                        </div>
                        
                        <div class="panel-body pn pb5">
                            
                            <hr class="short br-lighter">

                            <div class="box-body no-padding">

                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                                        </td>
                                        <td><strong>Birthday</strong></td>
                                        <td>{{$details->date_of_birth}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-genderless"></i>
                                        </td>
                                        <td><strong>Gender</strong></td>
                                        <td>{{$details->gender}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-envelope-o"></i>
                                        </td>
                                        <td><strong>Father's Name</strong></td>
                                        <td>{{$details->father_name}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-mobile-phone"></i>
                                        </td>
                                        <td><strong>Cellphone</strong></td>
                                        <td>{{$details->number}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-map-marker"></i>
                                        </td>
                                        <td><strong>Qualification</strong></td>
                                        <td>{{$details->qualification}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-map-marker"></i>
                                        </td>
                                        <td><strong>Current Address</strong></td>
                                        <td>{{$details->current_address}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-map-marker"></i>
                                        </td>
                                        <td><strong>Permanent Address</strong></td>
                                        <td>{{$details->permanent_address}}</td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
            @if($events)
                <div class="col-md-3 pull-right">
                    <div class="box box-success">
                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title"> Events </span>
                            </div>
                            <div class="panel-body pn pb5">
                                <hr class="short br-lighter">
                                @foreach (array_chunk($events, 3, true) as $results)
                                    <table class="table">
                                        @foreach($results as $event)
                                             <tr>
                                                <td>
                                                    <div class='fc-event' data-event="primary">
                                                        <div class="fc-event-desc blink" id="blink">
                                                            <span class="label label-info pull-right">  {{$event->name}} </span></a>
                                                        </div>
                                                    </div>
                                                    <a href="{{route('create-event')}}" > <span class="label label-success pull-right">{{ \Carbon\Carbon::createFromTimestamp(strtotime($event->date))}}</span></a>
                                                </td>
                                             </tr>
                                        @endforeach
                                    </table>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title">Employment Details</span>
                        </div>
                        <div class="panel-body pn pb5">
                            <hr class="short br-lighter">

                            <div class="box-body no-padding">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-key"></i></td>
                                        <td><strong>Employee ID</strong></td>
                                        <td>{{$details->code}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="fa fa-briefcase"></i></td>
                                        <td><strong>Department</strong></td>
                                        <td>{{$details->department}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="fa fa-cubes"></i></td>
                                        <td><strong>Designation</strong></td>
                                        <td>{{ $details->userrole ? $details->userrole->role->name : 'Unknown Role' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="fa fa-calendar"></i></td>
                                        <td><strong>Date Joined</strong></td>
                                        <td>{{$details->date_of_joining}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="fa fa-calendar"></i></td>
                                        <td><strong>Date Confirmed</strong></td>
                                        <td>{{$details->date_of_confirmation}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="fa fa-credit-card"></i></td>
                                        <td><strong>Salary</strong></td>
                                        <td>{{$details->salary}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    </section>

@endsection
<script type="text/javascript">
    function startTime() {
        var today = new Date(),
        curr_hour = today.getHours(),
        curr_min = today.getMinutes(),
        curr_sec = today.getSeconds();
        curr_hour = checkTime(curr_hour);
        curr_min = checkTime(curr_min);
        curr_sec = checkTime(curr_sec);
        document.getElementById('clock').innerHTML = curr_hour + ":" + curr_min + ":" + curr_sec;
    }
    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
    setInterval(startTime, 500);
</script>
