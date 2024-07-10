@extends('hrms.layouts.base')

<style>
    @media screen and (min-width: 1024px) {
        #filter_select {
            height: 35px;
            width: 160px;
            margin-left: -35px;
        }
        #date_input {
            margin-right: -10px;
        }
    }
    #search {
        margin-left: -12px;
    }
    #filter_select {
        height: 35px;
    }
    #date_input_from, #date_input_to {
        width: 90px;
        font-size: 12px;
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
                            <div class="panel-heading">
                                <span class="panel-title hidden-xs" style="color: black"> Attendance List </span>
                                <form action="{{ route('att-export') }}" method="GET" class="text-right">
                                    <button type="submit" class="btn btn-success" style="margin-right: 12px; margin-top: -30px;">Export</a>
                                </form>
                            </div>
                            <!-- summary report for each status -->
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="text-danger text-center" style="margin-right: 14px; border: 1px solid gray; padding: 5px 0px;">{{ $counts['pending'] }} Pending<?php if ($counts['pending'] > 1) echo 's'; ?></p>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-primary text-center" style="margin-right: 14px; border: 1px solid gray; padding: 5px 0px;">{{ $counts['confirm'] }} Confirmed</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-success text-center" style="margin-right: 14px; border: 1px solid gray; padding: 5px 0px;">{{ $counts['approve'] }} Approved</p>
                                </div>
                            </div>
                            
                            <div class="panel-body pn" style="margin-top: -8px;">
                                @if(Session::has('flash_message'))
                                    <div class="alert alert-success">
                                        {{ Session::get('flash_message') }}
                                    </div>
                                @endif
                                {!! Form::open(array('url' =>'/search-attendance', 'class'=>'form-horizontal',"enctype"=>"multipart/form-data")) !!}
                                        <div class="panel-menu allcp-form theme-primary mtn">
                                            <div class="row" style="margin-top: 10px;">
                                                <div class="col-lg-4 col-md-4 col-sm-6">
                                                    <select class="select2-multiple form-control" name="site_id">
                                                        <option value="">Select Site Name</option>
                                                        @if(isset($sites) && count($sites) > 0)
                                                            @foreach($sites as $site)
                                                                <option value="{{ $site->id }}">{{ $site->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                
                                                <div class="col-lg-6 col-md-4 col-sm-12 text-right" style="padding-right: 35px;">
                                                    <div class="col-lg-6 col-md-6 col-sm-12 text-right">
                                                        <input type="date" name="date_input_from" id="date_input_from" style="height: 35px; display: none;">
                                                        <input type="date" name="date_input_to" id="date_input_to" style="height: 35px; display: none;">
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-8">
                                                        <select name="date_filter" id="filter_select">
                                                            <option value="today" @if($checkStatus === 'today') selected @endif>Today</option>
                                                            <option value="all_time" @if($checkStatus === 'all time') selected @endif>All Time</option>
                                                            <option value="filter_by_date" @if($checkStatus === 'date input') selected @endif>Filter by Date</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2 col-md-4 col-sm-4">
                                                        <button type="submit" name="date_search" value="search" class="btn btn-primary">Search</a>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                <div class="table-responsive">
                                    <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                        <thead>
                                            <tr class="bg-light">
                                                <th class="text-left" style="font-size:15px">Id</th>
                                                <th class="text-left" style="font-size:15px">Leader</th>
                                                <th class="text-left" style="font-size:15px">Site</th>
                                                <th class="text-left" style="font-size:15px">Shift</th>
                                                <th class="text-left" style="font-size:15px">Employee</th>
                                                <th class="text-left" style="font-size:15px">DayOff</th>
                                                <th class="text-left" style="font-size:15px">PartTime</th>
                                                <th class="text-left" style="font-size:15px">RV</th>
                                                <th class="text-left" style="font-size:15px">Date</th>
                                                <th class="text-left" style="font-size:15px; width:100px;">Time</th>
                                                @if(Auth::user()->isAdmin() || Auth::user()->isCpManager() || Auth::user()->isCpAdministrator() || Auth::user()->isCpAdmin() || Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isHrOfficerRecruit() || Auth::user()->isHrOfficerCompen() || Auth::user()->isHrER() || Auth::user()->isHrAssistant())
                                                    <th class="text-left" style="font-size:15px">Status</th>
                                                @endif
                                                <th class="text-left" style="font-size:15px">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($arr) && count($arr) > 0)
                                                @foreach($arr as $i => $ar)
                                                    <tr>
                                                        <td class="text-left" style="font-size:14px">{{ $i + 1 }}</td>
                                                        <td class="text-left" style="font-size:14px">{{ $ar['leader'] ?? '' }}</td>
                                                        <td class="text-left" style="font-size:14px">{{ $ar['site'] ?? '' }}</td>
                                                        <td class="text-left" style="font-size:14px">{{ $ar['shift'] ?? '' }}</td>
                                                        <td class="text-left" style="font-size:14px">
                                                            @foreach($ar['emp_arr'] ?? [] as $j => $emp)
                                                                {{ $j + 1 }}. {{ $emp['name'] ?? '' }}<br>
                                                            @endforeach
                                                        </td>
                                                        <td class="text-left" style="font-size:14px">
                                                            @foreach($ar['dayoff'] ?? [] as $j => $dayoff)
                                                                {{ $j + 1 }}. {{ $dayoff['name'] ?? '' }}<br>
                                                            @endforeach
                                                        </td>
                                                        <td class="text-left" style="font-size:14px">
                                                            @foreach($ar['parttime'] ?? [] as $j => $part)
                                                                {{ $j + 1 }}. {{ $part['name'] ?? '' }}<br>
                                                            @endforeach
                                                        </td>
                                                        <td class="text-left" style="font-size:14px">
                                                            @foreach($ar['rvs'] ?? [] as $j => $rvs)
                                                                {{ $j + 1 }}. {{ $rvs['name'] ?? '' }}<br>
                                                            @endforeach
                                                        </td>
                                                        <td class="text-left" style="font-size:14px">{{ Carbon\Carbon::parse($ar['date'])->format('d/m/Y') ?? '' }}</td>
                                                        <td class="text-left" style="font-size:14px">{{ !empty($ar['time']) ? (new \DateTime($ar['time']))->format('h:i A') : '' }}</td>
                                                        @if(Auth::user()->isAdmin() || Auth::user()->isCpManager() || Auth::user()->isCpAdministrator() || Auth::user()->isCpAdmin() || Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isHrOfficerRecruit() || Auth::user()->isHrOfficerCompen() || Auth::user()->isHrER() || Auth::user()->isHrAssistant())
                                                            <td class="text-left" style="font-size:14px"> 
                                                                @if($ar['status'] == 0)
                                                                    <select name="status" class="form-control form-select" style="background-color: #daa520; width: 90px; color: white; cursor: pointer;">
                                                                        <option value="0" data-old-value ="{{ $ar['id'] }}" selected @if($ar['status'] == 1 || $ar['status'] == 2) disabled @endif>PENDING</option>
                                                                        @if(Auth::user()->isCpManager() || Auth::user()->isCpAdministrator() || Auth::user()->isCpAdmin())
                                                                            <option value="1" data-old-value ="{{ $ar['id'] }}" @if($ar['status'] == 1 || $ar['status'] == 2) disabled @endif>CONFIRM</option>
                                                                            <option value="2" data-old-value ="{{ $ar['id'] }}" disabled>APPROVE</option>
                                                                        @elseif(Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isHrOfficerRecruit() || Auth::user()->isHrOfficerCompen() || Auth::user()->isHrER() || Auth::user()->isHrAssistant())
                                                                            <option value="1" data-old-value ="{{ $ar['id'] }}" disabled>CONFIRM</option>
                                                                            <option value="2" data-old-value ="{{ $ar['id'] }}" @if($ar['status'] == 0) disabled @endif>APPROVE</option>
                                                                        @endif
                                                                    </select>
                                                                @else
                                                                    <select name="status" class="form-control form-select" @if($ar['status'] == 2) style="background-color: #28a745; color: white; width: 90px; cursor: pointer;" @else style="background-color: #1d82cf; color: white; width: 90px; cursor: pointer;" @endif>
                                                                        <option value="0" data-old-value ="{{ $ar['id'] }}" @if($ar['status'] == 1 || $ar['status'] == 2) disabled @endif>PENDING</option>
                                                                        @if(Auth::user()->isCpManager() || Auth::user()->isCpAdministrator() || Auth::user()->isCpAdmin())
                                                                            <option value="1" data-old-value ="{{ $ar['id'] }}" @if($ar['status'] == 1) selected @endif @if($ar['status'] == 1 || $ar['status'] == 2) disabled @endif>CONFIRM</option>
                                                                            <option value="2" data-old-value ="{{ $ar['id'] }}" @if($ar['status'] == 2) selected @endif disabled>APPROVE</option>
                                                                        @elseif(Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isHrOfficerRecruit() || Auth::user()->isHrOfficerCompen() || Auth::user()->isHrER() || Auth::user()->isHrAssistant())
                                                                            <option value="1" data-old-value ="{{ $ar['id'] }}" @if($ar['status'] == 1) selected @endif disabled>CONFIRM</option>
                                                                            <option value="2" data-old-value ="{{ $ar['id'] }}" @if($ar['status'] == 2) selected @endif @if($ar['status'] == 0) disabled @endif>APPROVE</option>
                                                                        @elseif(Auth::user()->isAdmin())
                                                                            <option value="1" data-old-value ="{{ $ar['id'] }}" @if($ar['status'] == 1) selected @endif>CONFIRM</option>
                                                                            <option value="2" data-old-value ="{{ $ar['id'] }}" @if($ar['status'] == 2) selected @endif>APPROVE</option>
                                                                        @endif
                                                                    </select>
                                                                @endif   
                                                            </td> 
                                                        @endif
                                                        <td class="text-left" style="font-size: 10px;">
                                                            <a href="/map-view/{{ $ar['id'] }}" class="btn btn-warning" style="width: 40px;"><i class="fas fa-map"></i></a>
                                                            <br>
                                                            <a href="/editAtt/{{ $ar['id'] }}" class="btn btn-primary" style="width: 40px;margin-top:5px;"><i class="fas fa-edit"></i></a> 
                                                            <br>
                                                            <a href="/deleteAtt/{{ $ar['id'] }}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete the attendance?')" style="margin-top: 5px; width: 40px;"><i class="fas fa-trash"></i></a>   
                                                            <br><br><br>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="12" class="text-center" style="font-size:17px">There is no item to display.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            
                            <div class="card-footer d-flex justify-content-center">
                                 {{$datas->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        $('select[name=status]').on('change',function() {
            var value = $(this).val();
            var selectOption = $('option:selected',this);
            var id = selectOption.data('old-value');
           

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "/change-status",
                type: "POST",
                dataType: "json",
                data:{
                    id:id,
                    status:value
                },
                success: function() {
                    swal.fire({
                        title: "Success",
                        text: "Status Successfully Changed!",
                        icon: "success",
                    }).then(function() {
                        window.location.reload();
                    })
                }
                        
            });
        });

        // show hide filter date input
        $('#filter_select').on('change', function() {
            if ($(this).val() === 'filter_by_date') {
                $('#date_input_from').show();
                $('#date_input_to').show();
            } else {
                $('#date_input_from').hide();
                $('#date_input_to').hide();
            }
        });
    });
</script>
@endsection