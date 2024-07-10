@extends('hrms.layouts.base')

<style>
    .p25 {
        margin-top: -1px !important;
    }
    #shiftModalLabel {
        margin-left: 35px;
        font-weight: bold;
        font-size: 24px;
    }
    #shiftTitle {
        margin-left: 20px;
        margin-bottom: 20px;
    }
    .shift-form-box {
        height: 220px; 
        padding-top: 20px;
        padding-left: 20px;
    }
    #shiftListBox {
        background-color: lightblue;
        margin-top: 45px;
        width: 70%;
        margin-left: 13.5%;
        padding: 20px  0 20px 0;
        border-radius: 10px;
    }
    #shiftDataList, #shiftExistingDataList {
        margin-left: 20px;
        margin-top: 10px;
    }
    .rm-btn {
        margin-left: 5px;
    }
    .control-labels {
        padding-left: 150px;
    }
    .note-span {
        margin-top: 10px;
        margin-left: 20px;
        font-size: 10px;
        font-weight: bold;
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
                    <div class="col-xs-12">
                        <div class="box box-success">
                            <div class="panel">
                                <div class="panel-heading text-center">
                                    <span class="panel-title hidden-xs" style="color:black"> Edit Site/Project </span>
                                </div>

                                <div class="panel-body pn">
                                    <div class="table-responsive">
                                        <div class="panel-body p25 pb10">
                                            @if(Session::has('flash_message'))
                                                <div class="alert alert-success">
                                                    {{Session::get('flash_message')}}
                                                </div>
                                            @endif
                                            {!! Form::open(array('url'=>array('/edit-project',$project->id), 'class'=>'form-horizontal')) !!}

                                            <div class="form-group">
                                                <label class="col-md-4"> <span class="control-labels">Site's Name:</span></label>
                                                <div class="col-md-6">
                                                    <input type="text" name="site" id=""
                                                           class="select2-single form-control" placeholder="Enter Site's Name..." value="{{$project->name}}"
                                                           required>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4"> <span class="control-labels">Short Term:</span></label>
                                                <div class="col-md-6">
                                                    <input type="text" name="short_term" id=""
                                                        class="select2-single form-control" value="{{$project->short_term}}" placeholder="Enter Project Name (Short Term)..."
                                                        >
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4"> <span class="control-labels">Description:</span></label>
                                                <div class="col-md-6">
                                                    <textarea class="form-control" name="description" placeholder="Enter Description...">{{$project->description}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4"> <span class="control-labels">Client Name:</span></label>
                                                <div class="col-md-6">
                                                    <input type="text" name="client_name" id=""
                                                        class="select2-single form-control" value="{{$project->client_id}}" placeholder="Enter Client Name...">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-2">
                                                    <input type="submit" class="btn btn-bordered btn-info btn-block" value="Save">
                                                </div>
                                                <div class="col-md-2"><a href="" style="text-decoration: none;">
                                                    <input type="button" class="btn btn-bordered btn-success btn-block" value="Reset"></a>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="button" class="btn btn-bordered btn-info btn-block" data-toggle="modal" data-target="#shiftModal" value="+ Add Shift" id="add-shift-btn">
                                                </div>
                                            </div>

                                            <div id="shiftListBox">
                                                <h4 id="shiftTitle">Shifts</h4> 
                                                <span class="text-danger note-span">Note: Please save your project after shifts modified.</span>
                                                <ul id="shiftExistingDataList">
                                                    @php
                                                        $shiftIds = json_decode($project->shifts);
                                                    @endphp

                                                    @if (!empty($shiftIds))
                                                        @foreach ($shiftIds as $index => $shiftId)
                                                            @php
                                                                $shift = App\Shift::where('id', $shiftId)->where('delete_status', 0)->first();
                                                            @endphp

                                                            @if ($shift)
                                                                @php 
                                                                    $startTime = date('h:i A', strtotime($shift->start_time));
                                                                    $endTime = date('h:i A', strtotime($shift->end_time));
                                                                @endphp
                                                                <li data-index="{{ $index }}">
                                                                    Shift Name&ensp;-   {{ $shift->name }}  <br>  
                                                                    Full Name&ensp; -   {{ $shift->full_name }}  <br>  
                                                                    Start Time&ensp; -   {{ $startTime }}  <br>  
                                                                    End Time&emsp;-   {{ $endTime }}  <br><br>
                                                                    <button type="button" class="btn btn-sm btn-primary existing-edit-shift-btn">Edit</button>
                                                                    <button type="button" class="btn btn-sm btn-danger existing-remove-shift-btn rm-btn">Remove</button> <br><br><br>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <li>No shifts found for this project.</li>
                                                    @endif
                                                </ul>
                                                <ul id="shiftDataList">
                                                    
                                                </ul>

                                                <input type="hidden" name="existing_shift_data" id="existing_shift_data" value="@if ($project->shifts) {{ json_encode($shiftData) }} @endif">
                                                <input type="hidden" name="new_shift_data" id="new_shift_data">
                                                
                                                <input type="hidden" name="shift_data" id="shift_data" value="@if ($project->shifts) {{ json_encode($shiftData) }} @endif">
                                                <input type="hidden" name="after_shift_ids" value="@if ($project->shifts) {{ $project->shifts }} @endif">
                                            </div>

                                            {!! Form::close() !!}

                                            <!-- Shift form -->
                                            <div class="modal fade" id="shiftModal" tabindex="-1" role="dialog" aria-labelledby="shiftModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="shiftModalLabel">Add Shift to the Project</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="shift-form-box">
                                                                <div class="form-group">
                                                                    <label class="col-md-3 control-label"> Shift Name </label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" name="shift_name" class="form-control" placeholder="Shift Name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" style="margin-top: 50px;">
                                                                    <label class="col-md-3 control-label"> Full Name </label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" name="full_name" class="form-control" placeholder="Full Name">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" style="margin-top: 100px;">
                                                                    <label class="col-md-3 control-label"> Start Time </label>
                                                                    <div class="col-md-9">
                                                                        <input type="time" name="start_time" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" style="margin-top: 150px;">
                                                                    <label class="col-md-3 control-label"> End Time </label>
                                                                    <div class="col-md-9">
                                                                        <input type="time" name="end_time" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary save-shift-btn">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

        var shiftExistingDataArray = ($('#existing_shift_data').val() !== "") ? JSON.parse($('#existing_shift_data').val()) : [];
        var shiftNewDataArray = [];
        var isEditingNew = false;
        var isEditingExisting = false;
        var editingIndex = null;

        // for saving a new shift
        $('#shiftModal').on('click', '.save-shift-btn', function() {
            var shiftName = $('input[name="shift_name"]').val();
            var fullName = $('input[name="full_name"]').val();
            var startTime = $('input[name="start_time"]').val();
            var endTime = $('input[name="end_time"]').val();
            var shiftId = (isEditingExisting) ? shiftExistingDataArray[editingIndex].id : null; 

            // create a new shift 
            var shiftData = {
                id: shiftId, 
                shiftName: shiftName,
                fullName: fullName,
                startTime: startTime,
                endTime: endTime
            };

            if (isEditingNew) {
                shiftNewDataArray[editingIndex] = shiftData;
            } else if (isEditingExisting) {
                shiftExistingDataArray[editingIndex] = shiftData;
            } else {
                shiftNewDataArray.push(shiftData);
            }

            updateHiddenInput();
            renderShiftDataNew();
            renderShiftDataExisting();

            $('input[name="shift_name"], input[name="full_name"], input[name="start_time"], input[name="end_time"]').val('');

            isEditingNew = false;
            isEditingExisting = false;
            editingIndex = null;

            $('#shiftModal').modal('hide');
        });

        // REMOVE
        // for removing a shift
        $('#shiftListBox').on('click', '.remove-shift-btn', function() {
            var index = $(this).data('shift-id');
            shiftNewDataArray.splice(index, 1);
            updateHiddenInput();
            renderShiftDataNew();
        });
        // for removing an existing shift
        $('#shiftListBox').on('click', '.existing-remove-shift-btn', function() {
            var index = $(this).closest('li').data('index');
            shiftExistingDataArray.splice(index, 1); 
            updateHiddenInput(); 
            renderShiftDataExisting();

            var afterShiftIds = JSON.parse($('input[name="after_shift_ids"]').val());
            afterShiftIds.splice(index, 1);
            $('input[name="after_shift_ids"]').val(JSON.stringify(afterShiftIds));
        });

        // EDIT
        // editing a shift
        $('#shiftListBox').on('click', '.edit-shift-btn', function() {
            isEditingNew = true;
            editingIndex = $(this).closest('li').data('shift-id');
            var shiftDataNew = shiftNewDataArray[editingIndex];

            $('input[name="shift_name"]').val(shiftDataNew.shiftName);
            $('input[name="full_name"]').val(shiftDataNew.fullName);
            $('input[name="start_time"]').val(shiftDataNew.startTime);
            $('input[name="end_time"]').val(shiftDataNew.endTime);

            $('#shiftModal').modal('show');
        });
        // editing an existing shift
        $('#shiftListBox').on('click', '.existing-edit-shift-btn', function() {
            isEditingExisting = true;
            editingIndex = $(this).closest('li').data('index');
            var shiftDataExisting = shiftExistingDataArray[editingIndex]; 

            $('input[name="shift_name"]').val(shiftDataExisting.shiftName);
            $('input[name="full_name"]').val(shiftDataExisting.fullName);
            $('input[name="start_time"]').val(shiftDataExisting.startTime);
            $('input[name="end_time"]').val(shiftDataExisting.endTime);

            $('#shiftModal').modal('show'); 
        });

        function renderShiftDataNew() {
            var html = '';
            shiftNewDataArray.forEach(function(shiftDataNew, index) {
                var startTime = new Date("1970-01-01T" + shiftDataNew.startTime);
                var startTimeString = startTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                var endTime = new Date("1970-01-01T" + shiftDataNew.endTime);
                var endTimeString = endTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                html += '<li data-shift-id="' + index + '">' +
                    'Shift Name&ensp;- ' + shiftDataNew.shiftName + '<br>' +
                    'Full Name&ensp; - ' + shiftDataNew.fullName + '<br>' +
                    'Start Time&ensp; - ' + startTimeString + '<br>' +
                    'End Time&emsp;- ' + endTimeString + '<br><br>' +
                    '<button type="button" class="btn btn-sm btn-primary edit-shift-btn" data-shift-id="' + index + '">Edit</button>' +
                    '<button type="button" class="btn btn-sm btn-danger remove-shift-btn rm-btn" data-shift-id="' + index + '">Remove</button> <br><br><br>' +
                    '</li>';
            });
            $('#shiftDataList').html(html);
        }
        function renderShiftDataExisting() {
            var html = '';
            shiftExistingDataArray.forEach(function(shiftDataExisting, index) {
                var startTime = new Date("1970-01-01T" + shiftDataExisting.startTime);
                var startTimeString = startTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                var endTime = new Date("1970-01-01T" + shiftDataExisting.endTime);
                var endTimeString = endTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                html += '<li data-index="' + index + '">' +
                    'Shift Name&ensp;- ' + shiftDataExisting.shiftName + '<br>' +
                    'Full Name&ensp; - ' + shiftDataExisting.fullName + '<br>' +
                    'Start Time&ensp; - ' + startTimeString + '<br>' +
                    'End Time&emsp;- ' + endTimeString + '<br><br>' +
                    '<button type="button" class="btn btn-sm btn-primary existing-edit-shift-btn">Edit</button>' +
                    '<button type="button" class="btn btn-sm btn-danger existing-remove-shift-btn rm-btn">Remove</button> <br><br><br>' +
                    '</li>';
            });
            $('#shiftExistingDataList').html(html);
        }

        function updateHiddenInput() {
            $('input[name="existing_shift_data"]').val(JSON.stringify(shiftExistingDataArray));
            $('input[name="new_shift_data"]').val(JSON.stringify(shiftNewDataArray));

            var existingShiftData = JSON.parse($('#existing_shift_data').val());
            var newShiftData = JSON.parse($('#new_shift_data').val());
            var shiftDatas = existingShiftData.concat(newShiftData);

            $('input[name="shift_data"]').val(JSON.stringify(shiftDatas));
        }
        
    });

</script>