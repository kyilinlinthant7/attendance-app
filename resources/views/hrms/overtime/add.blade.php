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
                                <span class="panel-title hidden-xs" style="color: black"> Add OverTime </span>
                            </div>

                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <div class="panel-body p25 pb10">
                                        @if(Session::has('flash_message'))
                                            <div class="alert alert-success">
                                                {{Session::get('flash_message')}}
                                            </div>
                                        @endif
                                        {!! Form::open(array('url' =>'save-overtime' ,'class'=>'form-horizontal',"enctype"=>"multipart/form-data")) !!}
                                        
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Site Name:</label>
                                            <div class="col-md-6">
                                                <select name="site" id="site"  class="select2-multiple form-control select-primary">
                                                    <option value=" "Selected>Select Site Name</option>
                                                    @foreach ($sites as $site)
                                                        <option value="{{$site->id}}">{{$site->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Shift Name:</label>
                                            <div class="col-md-6">
                                                <select class="select2-multiple form-control select-primary" name="shift_id" id="shiftSelect">
                                                    <!-- Options will be dynamically populated by JavaScript -->
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Leader:</label>
                                            <div class="col-md-6">
                                                <select name="leader" id="leader"  class="select2-multiple form-control select-primary">
                                                        <option value="">Please Select User</option>
                                                    @foreach($emps as $emp)
                                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Employee:</label>
                                            <div class="col-md-6">
                                                <select name="emp[]" id="emp"  class="select2-multiple form-control select-primary" multiple>
                                                    <option value=" ">Please Select Employee</option>
                                                    @foreach($emps as $emp)
                                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
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
                                                    <input type="text" class="select2-multiple form-control select-primary" name="otdate" id="datepicker1">
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
                                                        <option value="0">Normal</option>
                                                        <option value="1">Dayoff</option>
                                                        <option value="2">Public Holiday</option>
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
                                                    <input type="text" class="select2-single form-control" name="timeFrom" id="timepicker1" required>
                                                </div>
                                            </div>
    
                                            <label for="date_to" class="col-md-3 control-label" style="margin-left: -90px"> Time To :</label>
                                            <div class="col-md-2" id="getdate">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-clock-o text-alert pr10"></i>
                                                    </div>
                                                    <input type="text"  class="select2-single form-control" name="timeTo" id="timepicker4" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">OT Content:</label>
                                            <div class="col-md-6">
                                                <textarea type="text" class="select2-multiple form-control select-primary" name="content" ></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Remark:</label>
                                            <div class="col-md-6">
                                                <input type="text" class="select2-multiple form-control select-primary" name="remark" >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Completion Report:</label>
                                            <div class="col-md-6">
                                                <textarea type="text" class="select2-multiple form-control select-primary" name="work" ></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group" style="margin-top: 30px;">
                                            <label class="col-md-3 control-label"></label>
                                            <div class="col-md-2">
                                                <input type="submit" class="btn btn-bordered btn-info btn-block" value="Save">
                                            </div>
                                            <div class="col-md-2"><a href="/add-overtime" style="text-decoration: none;">
                                                <input type="button" class="btn btn-bordered btn-success btn-block" value="Reset"></a>
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








 
