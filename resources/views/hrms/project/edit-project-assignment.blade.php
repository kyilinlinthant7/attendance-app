@extends('hrms.layouts.base')

<style>
    .modal-field {
        padding-left: 70px;
    }
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
        <section id="content" class="table-layout animated fadeIn" >
            <!-- -------------- Column Center -------------- -->
            <div class="chute-affix">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-success">
                            <div class="panel">
                                <div class="panel-heading text-center">
                                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-project-assignment/{id}')
                                        <span class="panel-title hidden-xs">Edit Project Assignment </span>
                                    @else
                                        <span class="panel-title hidden-xs">Assign Project</span>
                                    @endif
                                </div>

                                <div class="panel-body pn">
                                    <div class="table-responsive">
                                        <div class="panel-body p25 pb10">
                                            @if(Session::has('flash_message'))
                                                <div class="alert alert-success">
                                                    {{Session::get('flash_message')}}
                                                </div>
                                            @endif
                                            {!! Form::open(['class' => 'form-horizontal']) !!}

                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Select Project: </label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary" name="project_id" required id="projectSelect">
                                                        @foreach($projects as $project)
                                                            @if($project->id == $assigns->project_id)
                                                                <option value="{{$project->id}}" selected>{{$project->name}}</option>
                                                            @else
                                                                <option value="{{$project->id}}">{{$project->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Select Shift: </label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary" name="shift_id" id="shiftSelect">
                                                        @foreach($shifts as $shift)
                                                            <option value="{{ $shift->id }}" {{ $shift->id == $assigns->shift_id ? 'selected' : '' }}>
                                                                {{ $shift->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Select Leaders:</label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary" name="leader[]" multiple>
                                                        @foreach($emps as $emp)
                                                            @if(in_array($emp->id, $leader_arr))
                                                                <option value="{{$emp->id}}" selected>{{$emp->name}}</option>
                                                            @else
                                                                <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Select Employees: </label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary" name="emp_id[]" required multiple="multiple">
                                                        @foreach($emps as $emp)
                                                            @if(in_array($emp->id, $emp_array))
                                                                <option value="{{$emp->id}}" selected>{{$emp->name}}</option>
                                                            @else
                                                                <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                   <a class="btn btn-primary" href="" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Part Time</a>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Select RV Employees: </label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary" name="rv[]" multiple="multiple">
                                                        @foreach($emps as $emp)
                                                            @if(in_array($emp->id, $rv_arr))
                                                                <option value="{{$emp->id}}" selected>{{$emp->name}}</option>
                                                            @else
                                                                <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">PartTime: </label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary" name="parttime[]" id="parttime" multiple>
                                                        <!--<option value="" selected>Select One</option>-->
                                                        @foreach($parttimes as $parttime)
                                                            <option  value="{{$parttime->id}}">{{$parttime->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Authorized Person: </label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary" name="authority_id" required>
                                                        @foreach($emps as $emp)
                                                            @if($emp->id == $assigns->authority_id)
                                                                <option value="{{$emp->id}}" selected>{{$emp->name}}</option>
                                                            @else
                                                                <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="datepicker1" class="col-md-3 control-label">Date of Assignment: </label>
                                                <div class="col-md-6">

                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar text-alert pr11"></i>
                                                        </div>
                                                        <input type="text" id="datepicker1" class=" select2-single form-control" name="doa"
                                                               value="@if($assigns){{$assigns->date_of_assignment}}@endif" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" style="margin-top: 30px">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-2">
                                                    <input type="submit" class="btn btn-bordered btn-info btn-block" value="Submit">
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="/edit-project-assignment/{id}" style="text-decoration: none;">
                                                        <input type="button" class="btn btn-bordered btn-success btn-block" value="Reset">
                                                    </a>
                                                </div>
                                            </div>

                                            {!! Form::close() !!}
                                        </div>
                                        
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    @if(Session::has('flash_message'))
                                                        <div class="alert alert-success">
                                                            {{Session::get('flash_message')}}
                                                        </div>
                                                    @endif
                                                    <form  action="/save-part-time" method="POST" class="form-horizontal">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title text-center" id="exampleModalLabel"> Add Part Time Worker  <span aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" style="float:right">&times;</span></h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group modal-field">
                                                            <label for="name" class="col-md-3 control-label">Name:</label>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="glyphicon glyphicon-user"></i>
                                                                    </div>
                                                                    <input type="text" id="ptname" class="select2-single form-control" name="ptname" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group modal-field">
                                                            <label for="datepicker2" class="col-md-3 control-label">Phone:</label>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="glyphicon glyphicon-phone"></i>
                                                                    </div>
                                                                    <input type="text" id="ptphone" class="select2-single form-control" name="ptphone">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group modal-field">
                                                            <label for="datepicker2" class="col-md-3 control-label">Address:</label>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-address-card" aria-hidden="true"></i>
                                                                    </div>
                                                                    <input type="text" id="ptaddress" class="select2-single form-control" name="ptaddress" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        <button type="submit"  class="btn btn-success" >Save</button>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--END------->
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

                    var selectedShiftId = "{{$assigns->shift_id}}";
                    $('#shiftSelect').val(selectedShiftId).trigger('change');
                }  
            });
        }

        var initialProjectId = $('#projectSelect').val();
        fetchShifts(initialProjectId);

        $('#projectSelect').change(function(){
            var projectId = $(this).val();
            fetchShifts(projectId);
        });
    });
</script>





