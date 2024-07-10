@extends('hrms.layouts.base')

<style>
    .panel-title {
        color: black !important;
    }
    .p25 {
        margin-left: 50px;
        margin-top: -10px !important;
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
                <div class="col-md-12">
                    <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading text-center">
                            <span class="panel-title hidden-xs"> Edit for Attendance</span>
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
                                    <form class="form-horizontal" action="{{route('edit-attendence', $attendance->id)}}" method="POST">

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Site:</label>
                                            <div class="col-md-6">
                                                <select class="select2-multiple form-control select-primary" name="site" id="site" required>
                                                    @if($selectedSite)    
                                                        <option value="{{$selectedSite->id}}" selected>{{$selectedSite->name}}</option>
                                                    @endif
                                                    @foreach ($sites as $site)
                                                        <option value="{{$site->id}}">{{$site->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Shift:</label>
                                            <div class="col-md-6">
                                                <select class="select2-multiple form-control select-primary" name="shift_id" id="shiftSelect">
                                                    @foreach($shifts as $shift)
                                                        @if(is_object($shift))
                                                            <option value="{{ $shift->id }}" {{ $shift->id == $attendance->shift_id ? 'selected' : '' }}>
                                                                {{ $shift->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Leader:</label>
                                            <div class="col-md-6">
                                                <select class="select2-multiple form-control select-primary" name="leader" id="leader" required>
                                                    <option value="{{$leader->id}}" selected>{{$leader->name}}</option>
                                                    @foreach ($emps as $emp )
                                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                        
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Employees:</label>
                                            <div class="col-md-6">
                                                <select class="select2-multiple form-control select-primary" name="emp[]" id="emp" multiple required>
                                                    @foreach ($emp_arr as $arr)
                                                        <option value="{{$arr->id}}" selected>  {{$arr->name}}</option>
                                                    @endforeach
                                                   
                                                    @foreach ($emps as $emp )
                                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Day Off:</label>
                                            <div class="col-md-6">
                                                <select class="select2-multiple form-control select-primary" name="dayoff[]" id="dayoff" multiple>
                                                    @foreach ($dayoffs as $dayoff)
                                                        <option value="{{$dayoff->id}}" selected>  {{$dayoff->name}}</option>
                                                    @endforeach
                                                   
                                                    @foreach ($emps as $emp )
                                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">RV:</label>
                                            <div class="col-md-6">
                                                <select class="select2-multiple form-control select-primary" name="rv[]" id="rv" multiple>
                                                    @foreach ($rvs as $rv)
                                                        <option value="{{$rv->id}}" selected>  {{$rv->name}}</option>
                                                    @endforeach
                                                   
                                                    @foreach ($emps as $emp )
                                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                        
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Date:</label>
                                            <div class="col-md-6">
                                                <input type="date" class="select2-single form-control" name="date" id="date" value="{{date_format(date_create($attendance->date), 'Y-m-d')}}">
                                            </div>
                                        </div>
                        
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Time:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="select2-single form-control" name="time" id="timepicker1" value="{{$attendance->time}}">
                                            </div>
                                        </div>
                        
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Latitude:</label>
                                            <div class="col-md-6">
                                                <input type="location" class="select2-single form-control" name="lat" id="lat" value="{{$attendance->lat}}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Longitude:</label>
                                            <div class="col-md-6">
                                                <input type="location" class="select2-single form-control" name="long" id="long" value="{{$attendance->long}}">
                                            </div>
                                        </div>
                        
                                        <div class="form-group" style="margin-top: 30px; margin-left: 88px;">
                                            <label class="col-md-2 control-label"></label>
                                            <div class="col-md-2">
                                                <input type="submit" class="btn btn-bordered btn-info btn-block" value="Submit">
                                            </div>
                                            <div class="col-md-2">
                                                <a href="/apply-leave" style="text-decoration: none"><input type="button" class="btn btn-bordered btn-success btn-block" value="Reset"></a>
                                            </div>
                                        </div>
                                    </form>
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
    $(document).ready(function() {
        $(".select2-multiple").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);
            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });

        function fetchShifts(projectId) {
            $.ajax({
                url: "{{ route('get.shifts', ['projectId' => ':projectId']) }}".replace(':projectId', projectId),
                type: 'GET',
                success: function(response) {
                    $('#shiftSelect').empty();
                    $.each(response, function(index, shift){
                        $('#shiftSelect').append('<option value="'+ shift.id +'">'+ shift.name +'</option>');
                    });

                    var selectedShiftId = "{{$attendance->shift_id}}";
                    $('#shiftSelect').val(selectedShiftId).trigger('change');
                }  
            });
        }

        var initialProjectId = $('#projectSelect').val();
        fetchShifts(initialProjectId);

        $('#site').change(function(){
            var projectId = $(this).val();
            fetchShifts(projectId);
        });
    });
</script>