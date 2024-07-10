@extends('hrms.layouts.base')

<style>
    #select_shift {
        /*height: 35px;*/
        width: 150px;
    }
    #date_input {
        height: 35px !important;
        border: 1px solid #aaa;
        border-radius: 4px;
        /*height: 35px;*/
        /*width: 150px;*/
    }
    #select_site {
        width: 180px;
        /*height: 35px;*/
    }
    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 1px solid #aaa;
        border-radius: 4px;
        height: 33px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #000;
        line-height: 36px !important;
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
                                    <span class="panel-title hidden-xs" style="color: black"> OverTime List </span>
                                    <span class="btn btn-sm btn-info" style="margin-left: 30px; margin-top: -6px;">
                                        Total OverTime : {{$totalTime}} hrs
                                    </span>
                                </div>
                                <div class="text-right">
                                    <a href="/add-overtime" class="btn btn-success" style="margin-top: -20px;">Create</a>
                                </div>
                               
                                <div class="panel-body pn">
                                    @if(Session::has('flash_message'))
                                        <div class="alert alert-success">
                                            {{ Session::get('flash_message') }}
                                        </div>
                                    @endif
                                   
                                    {!! Form::open(array('url' =>'/search-overtime' ,'class'=>'form-horizontal',"enctype"=>"multipart/form-data")) !!}
                                    <div class="panel-menu allcp-form theme-primary mtn">
                                        <div class="row" style="margin-left: 15px;">
                                            <div class="col-md-3">
                                                <!--<div class="form-group">-->
                                                    <input type="text" class="form-control" id="search" name="keywords" value="" placeholder="Enter search keywords..." style="border:2px solid #F7730E; margin-left: -40px;">
                                                <!--</div>-->
                                            </div>
                                            <div class="col-md-1">
                                                <!--<button type="submit" name="search" value="search" class="btn btn-primary">Search</a>-->
                                                <input type="submit" name="search" value="search" class="btn btn-primary" style="margin-left:-20px;">
                                            </div>
                                            <!--<div class="col-md-1">-->
                                            <!--    <a href="/overtime-list" class="btn btn-warning">Reset</a>-->
                                            <!--</div>-->
                                            
                                            <!-- new filters (Date/Site+Shift) -->
                                            <div class="col-md-3" style="width:auto;">
                                                <select name="select_site" id="select_site">
                                                    <option value="">Select Site</option>
                                                    @if (isset($sites))
                                                        @foreach ($sites as $site) 
                                                            <option value="{{$site->id}}">{{$site->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <!--<select name="select_shift" id="select_shift" style="margin-left: -55px">-->
                                                <!--    <option value="">Select Shift</option>-->
                                                <!--</select>-->
                                                <select name="select_shift" id="select_shift" style="margin-left: 0px">
                                                    <option value="">Select Shift</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <!--<input type="date" name="date_input" id="date_input" style="margin-left: -80px">-->
                                                <input type="date" name="date_input" id="date_input" style="margin-left: 0px;">
                                            </div>
                                            <div class="col-md-1">
                                                <!--<button type="submit" name="searches" value="search" class="btn btn-primary" style="margin-left: -14px">Search</a>-->
                                                <button type="submit" name="searches" value="search" class="btn btn-primary" style="margin-left: -40px">Search</a>
                                            </div>
                                        </div>
                                    </div>

                                    {!! Form::close() !!}
                                    <div class="table-responsive">
                                        <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                            <thead>
                                                <tr class="bg-light">
                                                    <th class="text-left" style="font-size:15px">No</th>
                                                    <th class="text-left" style="font-size:15px">Site</th>
                                                    <th class="text-left" style="font-size:15px">Shift</th>
                                                    <th class="text-left" style="font-size:15px">Leader</th>
                                                    <th class="text-left" style="font-size:15px">Employee</th>
                                                    <th class="text-left" style="font-size:15px">OT_Date</th>
                                                    <th class="text-left" style="font-size:15px">Type</th>
                                                    <th class="text-left" style="font-size:15px">From</th>
                                                    <th class="text-left" style="font-size:15px">To</th>
                                                    <th class="text-left" style="font-size:15px">Duration</th>
                                                    <th class="text-left" style="font-size:15px">Content</th>
                                                    <!--<th class="text-left" style="font-size:15px">Remark</th>-->
                                                    <!--<th class="text-left" style="font-size:15px">Completion Report</th>-->
                                                    <th class="text-left" style="font-size:15px">Status</th>
                                                    <th class="text-left" style="font-size:15px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0;?>

                                            @if(isset($ots) && count($ots) > 0)
                                                @foreach($ots as $ot)
                                                <tr>
                                                    <td class="text-left" style="font-size: 14px;">{{$i+=1}}</td>
                                                    <td class="text-left" style="font-size: 14px;">{{$ot["site_name"]}}</td>
                                                    <td class="text-left" style="font-size: 14px;">@if($ot["shift"] !== 0) {{$ot["shift"]}} @endif</td>
                                                    <td class="text-left" style="font-size: 14px;">{{$ot["leader"]}}</td>
                                                    <td class="text-left" style="font-size: 14px;">
                                                        @php $j = 1;@endphp
                                                        @foreach ($ot["emp"] as $emps)
                                                            {{$j++}}. {{$emps["name"]}}<br>     
                                                        @endforeach
                                                    </td>
                                                    <td class="text-left" style="font-size: 14px;">{{$ot["otdate"]}}</td>
                                                    <td class="text-left" style="font-size: 14px;">
                                                        @if($ot["ot_type"] === 2)
                                                        <div class="text-center" style="background: orange; padding: 2px 10px; color: black; width: 113px !important;">
                                                            Public Holiday
                                                        </div>
                                                        @elseif($ot["ot_type"] === 1)
                                                        <div class="text-center" style="background: red; padding: 2px 10px; color: white; width: 113px !important;">
                                                            Dayoff
                                                        </div>
                                                        @else
                                                            <div class="text-center" style="background: lightgreen; padding: 2px 10px; color: black; width: 113px !important;">
                                                            Normal
                                                        </div>
                                                        @endif
                                                    </td>
                                                    <td class="text-left" style="font-size: 14px;">{{$ot["fromtime"]}}</td>
                                                    <td class="text-left" style="font-size: 14px;">{{$ot["totime"]}}</td>
                                                    <td class="text-left" style="font-size: 14px;">
                                                        @php
                                                            $fromTime = \Carbon\Carbon::parse($ot["fromtime"]);
                                                            $toTime = \Carbon\Carbon::parse($ot["totime"]);
                                                            $duration = 0;
                                                        
                                                            if ($toTime->lessThan($fromTime)) {
                                                                $toTime->addDay(); 
                                                            }
                                                        
                                                            $diffInMinutes = $toTime->diffInMinutes($fromTime);
                                                        
                                                            $hours = floor($diffInMinutes / 60);
                                                            $minutes = $diffInMinutes % 60;
                                                        
                                                            $duration = sprintf('%02d:%02d', $hours, $minutes);
                                                        @endphp
                                                        {{ $duration }}
                                                        @if((\Carbon\Carbon::parse($ot["fromtime"])->diff(\Carbon\Carbon::parse($ot["totime"]))->format('%H:%I')) > 1)
                                                            hrs
                                                        @else
                                                            hr
                                                        @endif
                                                    </td>
                                                    <td class="text-left" style="font-size: 14px;">{{$ot["content"]}}</td>
                                                    
                                                     @if(Auth::user()->isAdmin() || Auth::user()->isCpManager() || Auth::user()->isCpAdministrator() || Auth::user()->isCpAdmin() || Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isHrOfficerRecruit() || Auth::user()->isHrOfficerCompen() || Auth::user()->isHrER() || Auth::user()->isHrAssistant())
                                                        <td class="text-left" style="font-size:14px"> 
                                                            @if($ot["status"] == 0)
                                                                <select name="status" class="form-control form-select" style="background-color: #daa520; width: 90px; color: white; cursor: pointer;">
                                                                    <option value="0" data-old-value ="{{$ot["id"]}}" selected @if($ot["status"] == 1 || $ot["status"] == 2) disabled @endif>PENDING</option>
                                                                    <!-- if CP, only available confirm -->
                                                                    @if(Auth::user()->isCpManager() || Auth::user()->isCpAdministrator() || Auth::user()->isCpAdmin())
                                                                        <option value="1" data-old-value ="{{$ot["id"]}}" @if($ot["status"] == 1 || $ot["status"] == 2) disabled @endif>CONFIRM</option>
                                                                        <option value="2" data-old-value ="{{$ot["id"]}}" disabled>APPROVE</option>
                                                                    <!-- if HR, only available approve for confirmed attendances -->
                                                                    @elseif(Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isHrOfficerRecruit() || Auth::user()->isHrOfficerCompen() || Auth::user()->isHrER() || Auth::user()->isHrAssistant())
                                                                        <option value="1" data-old-value ="{{$ot["id"]}}" disabled>CONFIRM</option>
                                                                        <option value="2" data-old-value ="{{$ot["id"]}}" @if($ot["status"] == 0) disabled @endif>APPROVE</option>
                                                                    @endif
                                                                </select>
                                                            @else
                                                                <select name="status" class="form-control form-select" @if($ot["status"] == 2) style="background-color: #28a745; color: white; width: 90px; cursor: pointer;" @else style="background-color: #1d82cf; color: white; width: 90px; cursor: pointer;" @endif>
                                                                    <option value="0" data-old-value ="{{$ot["id"]}}" @if($ot["status"] == 1 || $ot["status"] == 2) disabled @endif>PENDING</option>
                                                                    <!-- if CP, only available confirm -->
                                                                    @if(Auth::user()->isCpManager() || Auth::user()->isCpAdministrator() || Auth::user()->isCpAdmin())
                                                                        <option value="1" data-old-value ="{{$ot["id"]}}" @if($ot["status"] == 1) selected @endif @if($ot["status"] == 1 || $ot["status"] == 2) disabled @endif>CONFIRM</option>
                                                                        <option value="2" data-old-value ="{{$ot["id"]}}" @if($ot["status"] == 2) selected @endif disabled>APPROVE</option>
                                                                    <!-- if HR, only available approve for confirmed attendances -->
                                                                    @elseif(Auth::user()->isHR() || Auth::user()->isAssistantHrManager() || Auth::user()->isHrOfficerRecruit() || Auth::user()->isHrOfficerCompen() || Auth::user()->isHrER() || Auth::user()->isHrAssistant())
                                                                        <option value="1" data-old-value ="{{$ot["id"]}}" @if($ot["status"] == 1) selected @endif disabled>CONFIRM</option>
                                                                        <option value="2" data-old-value ="{{$ot["id"]}}" @if($ot["status"] == 2) selected @endif @if($ot["status"] == 0) disabled @endif>APPROVE</option>
                                                                    <!-- if Admin, shows all -->
                                                                    @elseif(Auth::user()->isAdmin())
                                                                        <option value="1" data-old-value ="{{$ot["id"]}}" @if($ot["status"] == 1) selected @endif>CONFIRM</option>
                                                                        <option value="2" data-old-value ="{{$ot["id"]}}" @if($ot["status"] == 2) selected @endif>APPROVE</option>
                                                                    @endif
                                                                </select>
                                                            @endif   
                                                        </td> 
                                                    @endif
                                                    <td class="text-center">
                                                        <a href="/edit-overtime/{{$ot["id"]}}" class="btn btn-primary" style="height: 25px; padding-top: 12px;"><span class="glyphicon glyphicon-edit"></span></a> <br>
                                                        <!--<a href="/delete-overtime/{{$ot["id"]}}" class="btn btn-danger" style="margin-top: 0px; height: 25px; padding-top: 12px;"><span class="glyphicon glyphicon-trash"></span></a>-->
                                                        <a href="/delete-overtime/{{$ot["id"]}}" class="btn btn-danger" style="margin-top: 5px; height: 25px; padding-top: 12px;" onclick="return confirm('Are you sure you want to delete this item?');"><span class="glyphicon glyphicon-trash"></span></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                            <tr>
                                                <td colspan="12" class="text-center" style="font-size:20px">There is no item to display.</td>
                                            </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                   
                                </div>
                                @if($overtimes->total() > 10)
                                <div class="card-footer d-flex justify-content-center">
                                    {{ $overtimes->links() }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    
    <script>
        $(document).ready(function() {
            $('#select_site').select2();
            $('#select_shift').select2();

            $('select[name=status]').on('change',function() {
                var value = $(this).val();
                var selectOption = $('option:selected',this);
                var id = selectOption.data('old-value');
                
                swal.fire({
                    title: "Are you sure?",
                    html: "<div style='font-size: 18px;'>Are you sure you want to change status? Check OT Type before change status.</div>",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, change status!",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "/overtime-change-status",
                            type: "POST",
                            dataType: "json",
                            data: {
                                id: id,
                                status: value
                            },
                            success: function() {
                                swal.fire({
                                    title: "Success",
                                    text: "Status Successfully Changed!",
                                    icon: "success",
                                }).then(function() {
                                    window.location.reload();
                                });
                            }
                        });
                    } else {
                        window.location.reload();
                    }
                });

            });

            // auto know each site's associative shifts
            $('#select_site').change(function(){
                var projectId = $(this).val();
                $('#select_shift').empty();
                $.ajax({
                    url: "{{ route('get.shifts', ['projectId' => ':projectId']) }}".replace(':projectId', projectId),
                    type: 'GET',
                    success: function(response){
                        $('#select_shift').empty();
                        $.each(response, function(index, shift){
                            $('#select_shift').append('<option value="'+ shift.id +'">'+ shift.name +'</option>');
                        });
                    }
                });
            });
        });
    </script>
@endsection