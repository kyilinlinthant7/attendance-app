@extends('hrms.layouts.base')

<style>
    .p25 {
        margin-left: 150px;
        margin-top: -10px !important;
    }
</style>

@section('content')
    <div class="content">
        <section id="content" class="table-layout animated fadeIn">
            <div class="chute-affix">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="panel">
                                <div class="panel-heading text-center">
                                    <span class="panel-title hidden-xs" style="color: black"> Apply for Leave</span>
                                </div>
                                <div class="text-center" id="show-leave-count"></div>
                                    <div class="panel-body pn">
                                        <div class="table-responsive">
                                            <div class="panel-body p25 pb10">
                                                @if(session('message'))
                                                    {{session('message')}}
                                                @endif
                                                @if(Session::has('flash_message'))
                                                    <div class="alert alert-success">
                                                        {{ session::get('flash_message') }}
                                                    </div>
                                                @endif

                                                {!! Form::open(['class' => 'form-horizontal', 'method' => 'post',"enctype"=>"multipart/form-data"]) !!}
                                    
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label"> Site: </label>
                                                    <div class="col-md-6">
                                                        <select class="select2-multiple form-control select-primary" name="site" id="site">
                                                            <option value="" selected>Select Site</option>
                                                            @foreach ($sites as $site)
                                                                <option value="{{$site->id}}">{{$site->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label"> Shift: </label>
                                                    <div class="col-md-6">
                                                        <select class="select2-multiple form-control select-primary" name="shift_id" id="shiftSelect">
                                                            <!-- Options will be dynamically populated by JavaScript -->
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label"> Leader: </label>
                                                    <div class="col-md-6">
                                                        <select class="select2-multiple form-control select-primary"
                                                                name="leader" id="leader">
                                                            <option value="" selected>Select Leader</option>
                                                            @foreach ($emps as $emp)
                                                                <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label"> Employee: </label>
                                                    <div class="col-md-6">
                                                        <select class="select2-multiple form-control select-primary"
                                                                name="emp" id="emp">
                                                            <option value="" selected>Select Employee</option>
                                                            @foreach ($emps as $emp)
                                                                <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label"> Leave Type: </label>
                                                    <div class="col-md-6">
                                                        <select class="select2-multiple form-control select-primary leave_type"
                                                                name="leave_type" id="leave_t" required>
                                                            <option value="" selected>Select One</option>
                                                            <!--@foreach($leaves as $leave)-->
                                                            <!--    <option value="{{$leave->id}}">{{$leave->leave_type}}</option>-->
                                                            <!--@endforeach-->
                                                            <option value="Casual Leave" >Casual Leave</option>
                                                            <option value="Earned Leave">Earned Leave</option>
                                                            <option value="Medical Leave">Medical Leave</option>
                                                            <option value="Maternity Leave">Maternity Leave</option>
                                                            <option value="Paternity Leave">Paternity Leave</option>
                                                            <option value="Other Leave">Other Leave</option>
                                                            <option value="Absent">Absent</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="date_from" class="col-md-2 control-label"> Date From: </label>
                                                    <div class="col-md-2">
                                                        <div class="input-group" style="width: 145px;">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar text-alert pr10"></i>
                                                            </div>
                                                            <input type="text" id="datepicker1" class="select2-single form-control"
                                                                name="dateFrom" id="sdate" required>
                                                        </div>
                                                    </div>

                                                    <label for="date_to" class="col-md-2 control-label" style="margin-left: -19px"> Date To: </label>
                                                    <div class="col-md-2" id="getdate">
                                                        <div class="input-group" style="width: 145px;">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar text-alert pr10"></i>
                                                            </div>
                                                            <input type="text" id="datepicker4" class="select2-single form-control"
                                                                name="dateTo" id="edate" required>
                                                        </div>
                                                    </div>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label"></label>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-primary" id="full" value="full" name="full_day" disabled>Full Day</button>
                                                    </div>

                                                    <label class="col-md-1 control-label"></label>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-primary" id="half" value="half" name="half_day" disabled>Half Day</button>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="input002" class="col-md-2 control-label"> Days: </label>
                                                    <div class="col-md-6">
                                                        <input id="total_days" name="total" value="" 
                                                            type="text" size="90" class="select2-single form-control" readonly/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="date-claim" class="col-md-2 control-label">Date Claim:</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar text-alert pr10"></i>
                                                            </div>
                                                            <input type="text" id="datepicker5" class="select2-single form-control"
                                                                name="claimdate">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input002" class="col-md-2 control-label"> Content: </label>
                                                    <div class="col-md-6">
                                                        <textarea type="text" id="textarea1" class="select2-single form-control"
                                                            name="content"  required>
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="input002" class="col-md-2 control-label"> Image: </label>
                                                    <div class="col-md-6">
                                                        <input type="file" id="photo"  class="form-control"
                                                            name="photo[]" multiple>
                                                    </div>
                                                </div>
                                    
                                                <div class="form-group" style="margin-top: 30px">
                                                    <label class="col-md-2 control-label"></label>

                                                    <div class="col-md-2">
                                                        <input type="submit" class="btn btn-bordered btn-info btn-block"
                                                            value="Submit">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a href="/apply-leave" style="text-decoration: none;">
                                                            <input type="button" class="btn btn-bordered btn-success btn-block" value="Reset">
                                                        </a>
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
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
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() 
    {
        // shift auto select
        $(".select2-multiple").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);
            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });

        $('#site').change(function() {
            var projectId = $(this).val();
            $.ajax({
                url: "{{ route('get.shifts', ['projectId' => ':projectId']) }}".replace(':projectId', projectId),
                type: 'GET',
                success: function(response){
                    $('#shiftSelect').empty();
                    $.each(response, function(index, shift){
                        $('#shiftSelect').append('<option value="'+ shift.id +'">'+ shift.name +'</option>');
                    });
                }
            });
        });
    });
</script>
