@extends('hrms.layouts.base')

<style>
    .p25 {
        margin-left: 70px;
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
                                        <span class="panel-title hidden-xs" style="color: black"> Edit Project Assignment </span>
                                    @else
                                        <span class="panel-title hidden-xs" style="color: black"> Assign Project</span>
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
                                                    <select class="select2-multiple form-control select-primary" name="project_id" id="projectSelect">
                                                        <option value="">Select Site...</option>
                                                        @foreach($projects as $project)
                                                            <option value="{{$project->id}}">{{$project->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Select Shift: </label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary" name="shift_id" id="shiftSelect">
                                                        <!-- Options will be dynamically populated by JavaScript -->
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Select Leaders: </label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary"
                                                            name="leader[]" multiple>
                                                        @foreach($emps as $emp)
                                                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Select Employees: </label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary" name="emp[]"  multiple="multiple">
                                                        @foreach($emps as $emp)
                                                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Select RV Employees: </label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary" name="rv[]"  multiple="multiple">
                                                        @foreach($emps as $emp)
                                                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Authorized Person:</label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple form-control select-primary"
                                                            name="authority_id" required>
                                                        @foreach($emps as $emp)
                                                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="datepicker1" class="col-md-3 control-label"> Date of Assignment: </label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar text-alert pr11"></i>
                                                        </div>
                                                        @if(\Route::getFacadeRoot()->current()->uri() == 'edit-project-assignment/{id}')
                                                            <input type="text" id="datepicker1" class="select2-single form-control" name="doa" value="@if($emps && $emps->date_of_assignment){{$emps->date_of_assignment}}@endif" required>
                                                        @else
                                                            <input type="text" id="datepicker1" class="select2-single form-control" name="doa" required>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" style="margin-top: 30px">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-2">
                                                    <input type="submit" class="btn btn-bordered btn-info btn-block" value="Submit">
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="/assign-project" style="text-decoration: none">
                                                        <input type="button" class="btn btn-bordered btn-success btn-block" value="Reset">
                                                    </a>
                                                </div>
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

        </section>
    </div>  

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $(".select2-multiple").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);
            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });

        $('#projectSelect').change(function(){
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






 




