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
        margin-top: 20px;
        width: 66%;
        margin-left: 15.2%;
        padding: 20px  0 20px 0;
        border-radius: 10px;
    }
    #shiftDataList {
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
    <div class="content">
        <!-- <header id="topbar" class="alt">
            <div class="topbar-left">
                <ol class="breadcrumb">
                    <li class="breadcrumb-icon">
                        <a href="/dashboard">
                            <span class="fa fa-home"></span>
                        </a>
                    </li>
                    <li class="breadcrumb-active">
                        <a href="/dashboard"> Dashboard </a>
                    </li>
                    <li class="breadcrumb-link">
                        <a href=""> Client </a>
                    </li>
                    <li class="breadcrumb-current-item"> Add Client</li>
                </ol>
            </div>
        </header> -->
        <!-- -------------- Content -------------- -->
        <section id="content" class="table-layout animated fadeIn">
            <!-- -------------- Column Center -------------- -->
            <div class="chute-affix">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-success">
                            <div class="panel">
                                <!-- Project form -->
                                <div class="panel-heading text-center">
                                    <span class="panel-title hidden-xs" style="color:black"> Add Site/Project </span>
                                </div>

                                <div class="panel-body pn">
                                    <div class="table-responsive">
                                        <div class="panel-body p25 pb10">
                                            @if(Session::has('flash_message'))
                                                <div class="alert alert-success">
                                                    {{Session::get('flash_message')}}
                                                </div>
                                            @endif
                                            {!! Form::open(array('url' =>'/add-site' ,'class'=>'form-horizontal',"enctype"=>"multipart/form-data")) !!}
                                            {{-- <form action="{{url('/add-site')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                            @csrf --}}
                                           
                                            <div class="form-group">
                                            <label class="col-md-4"> <span class="control-labels">Site's Name:</span></label>
                                                <div class="col-md-6">
                                                    <input type="text" name="site" id="" class="select2-single form-control" placeholder="Enter Site's Name..." required>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4"> <span class="control-labels">Short Term:</span></label>
                                                <div class="col-md-6">
                                                    <input type="text" name="short_term" id="" class="select2-single form-control" placeholder="Enter Project Name (Short Term)...">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                            <label class="col-md-4"> <span class="control-labels">Description:</span></label>
                                                <div class="col-md-6">
                                                    <textarea class="form-control" name="description" placeholder="Enter Description..."></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                            <label class="col-md-4"> <span class="control-labels">Client Name:</span></label>
                                                <div class="col-md-6">
                                                    <input type="text" name="client_name" id="" class="select2-single form-control" placeholder="Enter Client Name...">
                                                </div>
                                            </div>
                                                
                                            <div class="form-group">
                                                <label class="col-md-3 control-labels"></label>
                                                <div class="col-md-2">
                                                    <input type="submit" class="btn btn-bordered btn-info btn-block" value="Save">
                                                </div>
                                                <div class="col-md-2"><a href="/add-project" style="text-decoration: none">
                                                    <input type="button" class="btn btn-bordered btn-success btn-block" value="Reset"></a>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="button" class="btn btn-bordered btn-info btn-block" data-toggle="modal" data-target="#shiftModal" value="+ Add Shift" id="add-shift-btn">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="shiftListBox" style="display: none">
                                    <h4 id="shiftTitle">Shifts</h4> 
                                    <span class="text-danger note-span">Note: Please save your project after shifts modified.</span>
                                    <ul id="shiftDataList">
                                        
                                    </ul>

                                    <input type="hidden" name="shift_data">
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    {{-- </form> --}}
                    {!! Form::close() !!}

                    <!-- Add Shift form -->
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
        </section>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() 
    {
        var shiftDataArray = [];
        var isEditing = false;
        var editingIndex = null;

        // for saving a new shift or updating an existing shift
        $('#shiftModal').on('click', '.save-shift-btn', function() 
        {
            var shiftName = $('input[name="shift_name"]').val();
            var fullName = $('input[name="full_name"]').val();
            var startTime = $('input[name="start_time"]').val();
            var endTime = $('input[name="end_time"]').val();

            // create a new shift 
            var shiftData = {
                shiftName: shiftName,
                fullName: fullName,
                startTime: startTime,
                endTime: endTime
            };

            if (isEditing) {
                shiftDataArray[editingIndex] = shiftData;
            } else {
                shiftDataArray.push(shiftData);
            }

            updateHiddenInput();

            isEditing = false;
            editingIndex = null;

            $('input[name="shift_name"]').val('');
            $('input[name="full_name"]').val('');
            $('input[name="start_time"]').val('');
            $('input[name="end_time"]').val('');

            $('#shiftListBox').show();

            renderShiftData();
        });

        // for removing a shift
        $('#shiftListBox').on('click', '.remove-shift-btn', function() {
            var index = $(this).closest('li').index();

            shiftDataArray.splice(index, 1);

            updateHiddenInput();

            renderShiftData();
        });

        // editing a shift
        $('#shiftListBox').on('click', '.edit-shift-btn', function() {
            editingIndex = $(this).data('shift-id');

            var shiftData = shiftDataArray[editingIndex];

            $('input[name="shift_name"]').val(shiftData.shiftName);
            $('input[name="full_name"]').val(shiftData.fullName);
            $('input[name="start_time"]').val(shiftData.startTime);
            $('input[name="end_time"]').val(shiftData.endTime);

            isEditing = true;

            $('#shiftModal').modal('show');
        });

        function renderShiftData() {
            var html = '';
            shiftDataArray.forEach(function(shiftData, index) {
                // convert time to 12-hour format
                var startTime = new Date("1970-01-01T" + shiftData.startTime);
                var startTimeString = startTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                var endTime = new Date("1970-01-01T" + shiftData.endTime);
                var endTimeString = endTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                html += '<li data-shift-id="' + index + '">' +
                    'Shift Name&ensp;- ' + shiftData.shiftName + '<br>' +
                    'Full Name&ensp; - ' + shiftData.fullName + '<br>' +
                    'Start Time&ensp; - ' + startTimeString + '<br>' +
                    'End Time&emsp;- ' + endTimeString + '<br><br>' +
                    '<button type="button" class="btn btn-sm btn-primary edit-shift-btn" data-shift-id="' + index + '">Edit</button>' +
                    '<button type="button" class="btn btn-sm btn-danger remove-shift-btn rm-btn" data-shift-id="' + index + '">Remove</button> <br><br><br>' +
                    '</li>';
            });
            $('#shiftDataList').html(html);
        }

        function updateHiddenInput() {
            $('input[name="shift_data"]').val(JSON.stringify(shiftDataArray));
        }
    });
</script>


