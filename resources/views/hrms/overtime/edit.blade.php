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
<div class="content">

    <section id="content" class="table-layout animated fadeIn">
        <!-- -------------- Column Center -------------- -->
        <div class="chute-affix">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                        <div class="panel">
                            <div class="panel-heading text-center">
                                <span class="panel-title hidden-xs" style="color: black"> Edit OverTime </span>
                            </div>

                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <div class="panel-body p25 pb10">
                                        @if(Session::has('flash_message'))
                                            <div class="alert alert-success">
                                                {{Session::get('flash_message')}}
                                            </div>
                                        @endif
                                        {!! Form::open(array('url' =>array('/save-edit-overtime' ,$ot->id),'class'=>'form-horizontal',"enctype"=>"multipart/form-data")) !!}
                                        
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Site Name:</label>
                                            <div class="col-md-6">
                                                <select name="site" id="site"  class="select2-multiple form-control select-primary">
                                                    @foreach ($sites as $site)
                                                        @if($site->id == $ot->site_id)
                                                            <option value="{{$site->id}}" selected>{{$site->name}}</option>
                                                        @else
                                                            <option value="{{$site->id}}">{{$site->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Shift Name:</label>
                                            <div class="col-md-6">
                                                <select class="select2-multiple form-control select-primary" name="shift_id" id="shiftSelect">
                                                    @foreach($shifts as $shift)
                                                        @if(is_object($shift))
                                                            <option value="{{ $shift->id }}" {{ $shift->id == $ot->shift_id ? 'selected' : '' }}>
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
                                                <select name="leader" id="leader"  class="select2-multiple form-control select-primary">
                                                    @foreach($emps as $emp)
                                                        @if($emp->id == $ot->leader)
                                                            <option value="{{$emp->id}}" selected>{{$emp->name}}</option>
                                                        @else
                                                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Employee:</label>
                                            <div class="col-md-6">
                                                <select name="emp[]" id="emp"  class="select2-multiple form-control select-primary" multiple>
                                                    @foreach($emps as $emp)
                                                        @if(in_array($emp->id, $emp_array))
                                                            <option value="{{$emp->id}}" selected>{{$emp->name}}</option>
                                                        @else
                                                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">OT Date:</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar text-alert pr10"></i>
                                                    </div>
                                                    <input type="text" id="datepicker1" class="select2-multiple form-control select-primary" name="otdate"  value="{{$ot->otdate}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">OT Type:</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-briefcase text-alert pr10"></i>
                                                    </div>
                                                    <select class="form-control" name="ot_type">
                                                        <option>Select OT Type...</option>
                                                        <option value="0" @if($ot->ot_type == 0) selected @endif>Normal</option>
                                                        <option value="1" @if($ot->ot_type == 1) selected @endif>Dayoff</option>
                                                        <option value="2" @if($ot->ot_type == 2) selected @endif>Public_Holiday</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="date_from" class="col-md-3 control-label"> Time From :</label>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-clock-o text-alert pr10"></i>
                                                    </div>
                                                    <input type="text"  class="select2-single form-control"
                                                        name="timeFrom" id="timepicker1" value="{{$ot->fromtime}}" required>
                                                </div>
                                            </div>
    
                                            <label for="date_to" class="col-md-3 control-label" style="margin-left: -90px"> Time To :</label>
                                            <div class="col-md-2" id="getdate">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-clock-o text-alert pr10"></i>
                                                    </div>
                                                    <input type="text"  class="select2-single form-control"
                                                        name="timeTo" id="timepicker4" value="{{$ot->totime}}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">OT Content:</label>
                                            <div class="col-md-6">
                                                <textarea type="text" class="select2-multiple form-control select-primary" name="content">{{$ot->content}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Remark:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="select2-multiple form-control select-primary" name="remark" value={{$ot->remark}} >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Completion Report:</label>
                                            <div class="col-md-6">
                                                <textarea type="text" class="select2-multiple form-control select-primary" name="work">{{$ot->completion_report}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group" style="margin-top: 30px;">
                                            <label class="col-md-3 control-label"></label>
                                            <div class="col-md-2">
                                                <input type="submit" class="btn btn-bordered btn-info btn-block" value="Save">
                                            </div>
                                            <div class="col-md-2">
                                                <a href="/edit-overtime/{{$ot->id}}" style="text-decoration: none">
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

                    var selectedShiftId = "{{$ot->shift_id}}";
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







 
