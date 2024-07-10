@extends('hrms.layouts.base')

@section('content')
    <!-- START CONTENT -->
    <div class="content">
        <section id="content" class="table-layout animated fadeIn">
            <div class="chute-affix">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-success">
                            <div class="panel">
                                <div class="panel-heading">
                                    <span class="panel-title hidden-xs" style="color: black;"> PartTime Workers List </span>
                                    <div class="text-right">
                                        <a class="btn btn-success" data-toggle="modal" data-target="#createModal" style="margin-top: -35px;"><i class="fas fa-plus"></i> Register </a>
                                    </div>
                                </div>
                                
                                <div class="panel-body pn">
                                    @if(Session::has('flash_message'))
                                        <div class="alert alert-success">
                                            {{ Session::get('flash_message') }}
                                        </div>
                                    @endif
                                    {!! Form::open(array('url' =>'/search-parttime' ,'class'=>'form-horizontal',"enctype"=>"multipart/form-data")) !!}
                                    <div class="panel-menu allcp-form theme-primary mtn">
                                        <div class="row" style="margin-left: 15px; margin-top: 10px;">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="search" name="keywords" value="" placeholder="Enter search keywords..." style="border:2px solid #F7730E; margin-left: -29px;">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="submit" name="search" value="search" class="btn btn-primary">Search</a>
                                            </div>
                                            <div class="col-md-1">
                                                <a href="/parttime-list" class="btn btn-warning">Reset</a>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <a href="/export-parttime" name="button" id="export_button" class="btn btn-success">Export</a>
                                            </div>
                                            
                                            <div class="col-md-5" style="margin-top: -20px;">
                                                {!! $datas->render() !!}
                                            </div>
                                        </div>
                                    </div>

                                    {!! Form::close() !!}
                                    
                                    @if(count($datas))
                                        <div class="table-responsive">
                                            <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                                <thead>
                                                    <tr class="bg-light">
                                                        <th class="text-center" style="font-size:15px">No.</th>
                                                        <th class="text-center" style="font-size:15px">Photo</th>
                                                        <th style="font-size:15px">Name</th>
                                                        <th class="text-center" style="font-size:15px">NRC</th>
                                                        <th class="text-center" style="font-size:15px">DOB</th>
                                                        <th class="text-center" style="font-size:15px">Phone</th>
                                                        <th class="text-center" style="font-size:15px">Address</th>
                                                        <th class="text-center" style="font-size:15px">Date</th>
                                                        <th class="text-center" style="font-size:15px; width: 100px;">Actions</th>  
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0; ?>
                                                    @foreach($datas as $data)
                                                        <tr>
                                                            <td class="text-center" style="font-size:15px">{{$i+=1}}</td>
                                                            <td class="text-center" style="font-size:15px">
                                                                <img src="@if($data->photo) {{ URL::asset($data->photo) }} @else {{ URL::asset('public/userimages/user_white.jpg') }} @endif" style="border-radius: 10%; border:1px solid #000000; margin-left: 12px; height: 65px; width: 65px; object-fit: cover;">
                                                            </td>
                                                            <td style="font-size:15px">{{$data->name}}</td>
                                                            <td class="text-center" style="font-size:15px">{{$data->nrc}}</td>
                                                            <td class="text-center" style="font-size:15px">{{$data->dob}}</td>
                                                            <td class="text-center" style="font-size:15px">{{$data->phone}}</td>
                                                            <td class="text-center" style="font-size:15px">{{$data->address}}</td>
                                                            <td class="text-center" style="font-size:15px">{{$data->created_at}}</td>
                                                            <td class="text-center">
                                                                <a class="btn btn-primary edit-btn" onclick="editPartTime({{ $data->id }})"><i class="fas fa-edit"></i></a>
                                                                <a href="/delete-parttime/{{$data->id}}" onclick="return confirm('Are you sure want to delete the parttime worker?')" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                            @else
                                        <h2>No PartTime found</h2>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- register parttime workers -->
                        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form  action="/save-part-time" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                        <div class="modal-header">
                                            <h3 class="modal-title text-center" id="createModalLabel"> Parttime Worker Create Form  <span aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" style="float:right">&times;</span></h3>
                                        </div>
                                        <div class="modal-body" style="padding-left: 50px;">
                                            <div class="form-group modal-field">
                                                <div class="col-md-11">
                                                    <div class="text-center">
                                                        <img src="{{ URL::asset('public/userimages/user_white.jpg') }}" id="previewImage" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px; border: 1px solid gray;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group modal-field">
                                                <label for="ptname" class="col-md-3 control-label">Name:</label>
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
                                                <label for="ptnrc" class="col-md-3 control-label">NRC:</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fas fa-id-card"></i>
                                                        </div>
                                                        <input type="text" id="ptnrc" class="select2-single form-control" name="ptnrc">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group modal-field">
                                                <label for="ptdob" class="col-md-3 control-label">D.o.b:</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fas fa-birthday-cake"></i>
                                                        </div>
                                                        <input type="date" id="ptdob" class="select2-single form-control" name="ptdob">
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
                                                            <i class="fa fa-address-book" aria-hidden="true"></i>
                                                        </div>
                                                        <input type="text" id="ptaddress" class="select2-single form-control" name="ptaddress" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group modal-field">
                                                <label for="ptphoto" class="col-md-3 control-label">Photo:</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fas fa-photo"></i>
                                                        </div>
                                                        <input type="file" id="ptphoto" class="select2-single form-control" name="photo" accept="image/*" onchange="previewFile()">
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
                        
                        <!-- edit parttime workers -->
                        @foreach($datas as $data)
                            <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $data->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form  action="/edit-part-time/{{$data->id}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h3 class="modal-title text-center" id="editModalLabel"> Parttime Worker Edit Form  <span aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" style="float:right" onclick="reloadPage()">&times;</span></h3>
                                            </div>
                                            <div class="modal-body" style="padding-left: 50px;">
                                                <div class="form-group modal-field">
                                                    <div class="col-md-11">
                                                        <div class="text-center">
                                                            <img src="@if($data->photo) {{ URL::asset($data->photo) }} @else {{ URL::asset('public/userimages/user_white.jpg') }} @endif" id="previewImageEdit{{$data->id}}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px; border: 1px solid gray;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group modal-field">
                                                    <label for="ptname" class="col-md-3 control-label">Name:</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="glyphicon glyphicon-user"></i>
                                                            </div>
                                                            <input type="text" id="ptname" class="select2-single form-control" name="ptname" required value="@if($data->name) {{ $data->name }} @endif">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group modal-field">
                                                    <label for="ptnrc" class="col-md-3 control-label">NRC:</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fas fa-id-card"></i>
                                                            </div>
                                                            <input type="text" id="ptnrc" class="select2-single form-control" name="ptnrc" value="@if($data->nrc) {{ $data->nrc }} @endif">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group modal-field">
                                                    <label for="ptdob" class="col-md-3 control-label">D.o.b:</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fas fa-birthday-cake"></i>
                                                            </div>
                                                            <input type="date" id="ptdob" class="select2-single form-control" name="ptdob" value="{{ $data->dob ? \Carbon\Carbon::parse($data->dob)->format('Y-m-d') : '' }}">
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
                                                            <input type="text" id="ptphone" class="select2-single form-control" name="ptphone" value="@if($data->phone) {{ $data->phone }} @endif">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group modal-field">
                                                    <label for="datepicker2" class="col-md-3 control-label">Address:</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-address-book" aria-hidden="true"></i>
                                                            </div>
                                                            <input type="text" id="ptaddress" class="select2-single form-control" name="ptaddress" required value="@if($data->address) {{ $data->address }} @endif">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group modal-field">
                                                    <label for="ptphotoedit" class="col-md-3 control-label">Photo:</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fas fa-photo"></i>
                                                            </div>
                                                            <input type="file" id="ptphotoedit{{$data->id}}" class="select2-single form-control" name="photo" accept="image/*" onchange="previewFileEdit({{$data->id}})">
                                                            <input type="hidden" id="photo_value" name="photo_value" value="@if($data->photo) {{ $data->photo }} @endif">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" onclick="reloadPage()" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button type="submit"  class="btn btn-success">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection

<script>
    $(document).ready(function() {
        
        $('.modal').on('hidden.bs.modal', function() {
            var modal = $(this);
            var preview = modal.find('.preview-image');
            var fileInput = modal.find('.file-input');
            var photoValueInput = modal.find('.photo-value');
    
            if (photoValueInput.val() !== '') {
                preview.attr('src', photoValueInput.val());
            } else {
                preview.attr('src', "{{ URL::asset('public/userimages/user_white.jpg') }}");
            }
    
            fileInput.val(null);
    
            modal.find('input[type="text"], input[type="date"]').val('');
        });
    });

    // auto show relative data in edit form modal box
    function editPartTime(id) {
        $('#editModal'+id).modal('show');
        fetch('/part-time/' + id)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                $('#editModal'+id+' #ptname').val(data.name);
                $('#editModal'+id+' #ptnrc').val(data.nrc);
                $('#editModal'+id+' #ptdob').val(data.dob);
                $('#editModal'+id+' #ptphone').val(data.phone);
                $('#editModal'+id+' #ptaddress').val(data.address);
                $('#editModal' + id + ' #photo_value').val(data.photo).trigger('change');
            })
            .catch(error => console.error('Error:', error));
    }
    
    // image preview for create form
    function previewFile()
    {
        var preview = document.getElementById('previewImage');
        var file = document.getElementById('ptphoto').files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "{{ URL::asset('public/userimages/user_white.jpg') }}";
        }
    }
    
    // image preview for edit form
    function previewFileEdit(id) {
        var preview = document.getElementById('previewImageEdit'+id);
        var fileInput = document.getElementById('ptphotoedit'+id);
        var closeBtn = document.getElementById('closeBtn');
    
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
    
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
    
            reader.readAsDataURL(fileInput.files[0]);
        } else {
            preview.src = "{{ URL::asset('public/userimages/user_white.jpg') }}";
        }
    }
    
    function reloadPage() {
        location.reload();
    }

</script>



