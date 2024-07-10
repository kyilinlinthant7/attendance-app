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
                            <span class="panel-title hidden-xs">Apply for Attendance</span>
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
                                    <form class="form-horizontal" action="{{route('add-attendence')}}" method="POST">
                                        
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Site:</label>
                                            <div class="col-md-6">
                                                <select class="select2-multiple form-control select-primary" name="site" id="site" required>
                                                    <option value="" selected>Select Site</option>
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
                                                    <!-- Options will be dynamically populated by JavaScript -->
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Leader:</label>
                                            <div class="col-md-6">
                                                <select class="select2-multiple form-control select-primary" name="leader" id="leader" required>
                                                    <option value="" selected>Select Leader</option>
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
                                                    <option value="" selected>Select Employee</option>
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
                                                    <option value="" selected>Select Day Off</option>
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
                                                    <option value="" selected>Select RV</option>
                                                    @foreach ($emps as $emp )
                                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                        
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Date:</label>
                                            <div class="col-md-6">
                                                <input type="date" class="select2-single form-control" name="date" id="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                            </div>
                                        </div>
                        
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Time:</label>
                                            <div class="col-md-6">
                                                <input type="time" class="select2-single form-control" name="time" id="time" value="{{ \Carbon\Carbon::now()->format('H:i') }}" required>
                                            </div>
                                        </div>
                        
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Latitude:</label>
                                            <div class="col-md-6">
                                                <input type="location" class="select2-single form-control" name="lat" id="lat">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Longitude:</label>
                                            <div class="col-md-6">
                                                <input type="location" class="select2-single form-control" name="long" id="long">
                                            </div>
                                        </div>
                        
                                        <div class="form-group" style="margin-top: 30px; margin-left: 88px;">
                                            <label class="col-md-2 control-label"></label>
                                            <div class="col-md-2">
                                                <input type="submit" class="btn btn-bordered btn-info btn-block" value="Submit">
                                            </div>
                                            <div class="col-md-2">
                                                <a href="/addattendence" style="text-decoration: none;"><input type="button" class="btn btn-bordered btn-success btn-block" value="Reset"></a>
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
<script>
    $(document).ready(function(){
        $('#site').on('change',function(){
            var id = $('#site').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "/att",
                type: "POST",
                dataType: "json",
                data:{
                    id:id,
                },
                success: function(data){
                    var id = data[0].id;
                    var name = data[0].name;

                    console.log(data[1]);
                    var leader = $('select[name="leader"]');
                    var employee= $('select[name="emp[]"]');
                    leader.empty();
                    employee.empty();

                    $.each(data[2], function( index, value ) {
                        $.each(data[0], function( dex, item ) {
                            var option;
                            if(value.id == item.id){
                                option = $('<option></option>').attr('value', value.id).text(value.name).prop('selected', true);
                            }else{
                                option = $('<option></option>').attr('value', value.id).text(value.name);
                            }
                            leader.append(option);
                        });
                        $.each(data[1], function( dex, item ) {
                            var emOption;
                            if(value.id == item.id){
                                emOption = $('<option></option>').attr('value', value.id).text(value.name).prop('selected', true);
                            }else{
                                emOption = $('<option></option>').attr('value', value.id).text(value.name);
                            }
                            employee.append(emOption);
                        });
                    });   
                }        
            });
        });

        // shift auto select
        $(".select2-multiple").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);
            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });

        $('#site').change(function(){
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
@endsection
