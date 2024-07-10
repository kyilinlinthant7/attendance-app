@extends('hrms.layouts.base')

<style>
    .pv10 {
        height: 180px;
    }
</style>

@section('content')

<!-- -------------- /Topbar -------------- -->

<!-- -------------- Content -------------- -->
<section id="content" class="table-layout animated fadeIn">

    <!-- -------------- Column Center -------------- -->
    <div class="chute chute-center">
        
        <hr style="margin-top: 20px; margin-bottom: 30px;">
        
        <div class="row">
            <!--<h2 class="text-center text-primary" style="margin-bottom: 30px">Today Summary Reports</h2>-->
            <div class="col-sm-4 col-xl-3">
                <div class="panel panel-tile">
                    <div class="panel-body">
                        <div class="row pv10">
                            <div class="col-xs-5 ph10">
                                <img src="{{ URL::asset('public/assets/img/pages/attendance.png') }}" class="img-responsive mauto" alt=""/></div>
                            <div class="col-xs-7 pl5">
                                <h5 class="text-muted text-center"> <a href="{{route('show-attendance')}}">Total Attendance </a></h5>
                                <p class="text-center">{{ $totalAttendance }} records</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xl-3">
                <div class="panel panel-tile">
                    <div class="panel-body">
                        <div class="row pv10">
                            <div class="col-xs-5 ph10"><img src="{{ URL::asset('public/assets/img/pages/leave.png') }}" class="img-responsive mauto" alt=""/></div>
                            <div class="col-xs-7 pl5">
                                <h5 class="text-muted text-center"> <a href="{{route('leave-record')}}">Total Leave </a></h5>
                                <p class="text-center">{{ $totalLeaves }} leaves</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xl-3">
                <div class="panel panel-tile">
                    <div class="panel-body">
                        <div class="row pv10">
                            <div class="col-xs-5 ph10"><img src="{{ URL::asset('public/assets/img/pages/absence.png') }}" class="img-responsive mauto" alt=""/></div>
                            <div class="col-xs-7 pl5">
                                <h5 class="text-muted text-center"> <a href="{{route('show-attendance')}}">Total Absence </a></h5>
                                <p class="text-center">{{ $totalAbsence }} absences</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xl-3">
                <div class="panel panel-tile">
                    <div class="panel-body">
                        <div class="row pv10">
                            <div class="col-xs-5 ph10"><img src="{{ URL::asset('public/assets/img/pages/overtime.png') }}" class="img-responsive mauto" alt=""/></div>
                            <div class="col-xs-7 pl5">
                                <h5 class="text-muted text-center"> <a href="{{route('overtime-list')}}">Total OT Hours </a></h5>
                                <p class="text-center">Total : {{ $totalOvertimeHours }} hours</p>
                                <p class="text-center" style="font-size: 10px;">Normal OT: {{ $totalNormalOvertimeHours }} hours</p>
                                <p class="text-center" style="font-size: 10px;">Dayoff OT: {{ $totalDayoffOvertimeHours }} hours</p>
                                <p class="text-center" style="font-size: 10px;">Public Holiday OT: {{ $totalHolidayOvertimeHours }} hours</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-4 col-xl-3">
                <div class="panel panel-tile">
                    <div class="panel-body">
                        <div class="row pv10">
                            <div class="col-xs-5 ph10"><img src="{{ URL::asset('public/assets/img/pages/manpower.png') }}" class="img-responsive mauto" alt=""/></div>
                            <div class="col-xs-7 pl5">
                                <h5 class="text-muted text-center"> <a href="{{route('employee-manager')}}">Total Manpowers </a></h5>
                                <p class="text-center">{{ $totalManpowers }} manpowers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div><div class="col-sm-4 col-xl-3">
                <div class="panel panel-tile">
                    <div class="panel-body">
                        <div class="row pv10">
                            <div class="col-xs-5 ph10"><img src="{{ URL::asset('public/assets/img/pages/resign.png') }}" class="img-responsive mauto" alt=""/></div>
                            <div class="col-xs-7 pl5">
                                <h5 class="text-muted text-center"> <a href="{{route('employee-manager')}}">Total Resigned </a></h5>
                                <p class="text-center">{{ $totalResigns }} employees</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <hr style="margin-top: 10px; margin-bottom: 50px;">

        <!-- -------------- Quick Links -------------- -->
        <div class="row">
                <div class="col-sm-6 col-xl-3">
                    <div class="panel panel-tile">
                        <div class="panel-body">
                            <div class="row pv10">
                                <div class="col-xs-5 ph10"><img src="{{ URL::asset('public/assets/img/pages/Laptop Sketch-64x64') }}"
                                                                class="img-responsive mauto" style="height: 100px; width: 100px;" alt=""/></div>
                                <div class="col-xs-7 pl5">
                                    <h3 class="text-muted"> <a href="{{route('asset-listing')}}"> SITE <br /> MANAGER </a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="panel panel-tile">
                        <div class="panel-body">
                            <div class="row pv10">
                                <div class="col-xs-5 ph10"><img src="{{ URL::asset('public/assets/img/pages/clipart6.png') }}" class="img-responsive mauto" alt=""/></div>
                                <div class="col-xs-7 pl5">
                                    <h3 class="text-muted"><a href="{{route('hr-policy')}}"> HR POLICIES </a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($events)
                <div class="col-md-12">
                    <h3 class="mb10 mr5 notification" data-note-style="primary" style="color: darkturquoise">Latest &nbsp; Events </h3>
                @foreach (array_chunk($events, 3, true) as $results)
                    <table class="table">
                        <tr>
                            @foreach($results as $event)
                            <td>
                                <div class='fc-event fc-event-primary' data-event="primary">
                                <div class="fc-event-icon" style="color: darkslateblue">
                                    <span class="fa fa-exclamation"></span>
                                </div>
                                <div class="fc-event-desc blink" id="blink">
                                    <a href="{{route('create-event')}}" ><b>{{ \Carbon\Carbon::createFromTimestamp(strtotime($event->date))->diffForHumans()}} </b> {{$event->name}}</a>
                                </div>
                                    </div>
                            </td>
                            @endforeach
                        </tr>
                    </table>
                    @endforeach
               </div>
                @endif

                @if($meetings)
                <div class="col-md-12">
                    <h3 class=" mb10 mr5 notification" data-note-style="primary" style="color: darkturquoise"> Latest &nbsp;&nbsp; Meetings </h3>
                    @foreach (array_chunk($meetings, 3, true) as $results)
                        <table class="table">
                            <tr>
                                @foreach($results as $meeting)
                                    <td>
                                        <div class='fc-event fc-event-primary' data-event="primary">
                                            <div class="fc-event-icon" style="color: darkslateblue">
                                                <span class="fa fa-exclamation"></span>
                                            </div>
                                            <div class="fc-event-desc blink" id="blink">
                                                <b>{{ \Carbon\Carbon::createFromTimestamp(strtotime($meeting->date))->diffForHumans()}} </b> {{$meeting->name}}
                                            </div>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        </table>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        </section>
    @endsection