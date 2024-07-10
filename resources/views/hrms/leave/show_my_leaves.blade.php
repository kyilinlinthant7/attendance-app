@extends('hrms.layouts.base')

@section('content')
        <!-- START CONTENT -->
<div class="content">
    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">

        <!-- -------------- Column Center -------------- -->
        <div class="chute-affix">

            <!-- -------------- Products Status Table -------------- -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title hidden-xs" style="color: black"> My Leave List </span>
                        </div>
                        <div class="panel-body pn">
                            @if(Session::has('flash_message'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif
                            {!! Form::open(array('url' =>'/search-leave' ,'class'=>'form-horizontal',"enctype"=>"multipart/form-data")) !!}
                            <div class="panel-menu allcp-form theme-primary mtn">
                                <div class="row" style="margin-top:10px">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="search" name="keywords" value="" placeholder="Enter search keywords..." style="border:2px solid #F7730E">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="submit" name="search" value="search" class="btn btn-primary">Search</a>
                                    </div>
                                    <div class="col-md-1">
                                        <a href="/my-leave-list" class="btn btn-warning">Reset</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                    <thead>
                                    <tr class="bg-light">
                                        <th class="text-left" style="font-size:15px;">Id</th>
                                        <th class="text-left" style="font-size:15px;">Leader</th>
                                        <th class="text-left" style="font-size:15px;">Employee</th>
                                        <th class="text-left" style="font-size:15px;">Site</th>
                                        <th class="text-left" style="font-size:15px;">Type</th>
                                        <th class="text-left" style="font-size:15px;">From</th>
                                        <th class="text-left" style="font-size:15px;">To</th>
                                        <th class="text-left" style="font-size:15px;">Total</th>
                                        <th class="text-left" style="font-size:15px;">Claim_at</th>
                                        <th class="text-left" style="font-size:15px; width: 200px;">Content</th>
                                        <!--<th class="text-left" style="font-size:15px;">CC Remark</th>-->
                                        <!--<th class="text-left" style="font-size:15px;">HR Remark</th>-->
                                        <!--<th class="text-left" style="font-size:15px;">Manager Status</th>-->
                                        <th class="text-left" style="font-size:15px;">Status</th>
                                        <th class="text-left" style="font-size:15px; width: 160px;">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 0; ?>
                                    @foreach($leaves as $key=>$leave)
                                        <tr>
                                            <td class="text-left" style="font-size:14px">{{$i+=1}}</td>
                                            <td class="text-left" style="font-size:14px">{{$leave["leader"]}}</td>
                                            <td class="text-left" style="font-size:14px">{{$leave["name"]}}</td>
                                            <td class="text-left" style="font-size:14px">{{$leave["site_name"]}}</td>
                                            <td class="text-left" style="font-size:14px">{{$leave["leavetype"]}}</td>
                                            <td class="text-left" style="font-size:14px">{{$leave["dateFrom"]}}</td>
                                            <td class="text-left" style="font-size:14px">{{$leave["dateTo"]}}</td>
                                            <td class="text-left" style="font-size:14px">{{$leave["total"]}} days</td>
                                            <td class="text-left" style="font-size:14px">{{$leave["claim"]}}</td>
                                            <td class="text-left" style="font-size:14px">{{$leave["content"]}}</td>
                                            <!--<td class="text-left" style="font-size:14px">{{$leave["cc_remark"]}}</td>-->
                                            <!--<td class="text-left" style="font-size:14px">{{$leave["hr_remark"]}}</td>-->
                                            @if(Auth::user()->isHrOfficerCompen() || Auth::user()->isCpAdmin() || Auth::user()->isCpAdministrator() || Auth::user()->isCpManager() || Auth::user()->isAdmin())
                                                <td class="text-left" style="font-size:14px">                               
                                                    @if($leave["status"] == 0)
                                                        <select name="status" class="form-control form-select text-center" style="background-color: #daa520; width: 100px; color: white; cursor: pointer;">
                                                            <option value="0" data-old-value ="{{$leave["id"]}}" data-id="{{$key}}" selected>Pending</option>
                                                            <option value="1" data-old-value ="{{$leave["id"]}}" data-id="{{$key}}">Confirm</option>
                                                            <option value="2" data-old-value ="{{$leave["id"]}}" data-id="{{$key}}">Approve</option>
                                                            <option value="3" data-old-value ="{{$leave["id"]}}" data-id="{{$key}}">DisApprove</option>
                                                            <input type="hidden" value="{{$leave["leavetype"]}}" class="leave_type" id="leave_type{{$key}}">
                                                            <input type="hidden" value="{{$leave["emp_id"]}}" class="emp" id="emp{{$key}}">
                                                            <input type="hidden" value="{{$leave["total"]}}" class="day" id="day{{$key}}">
                                                        </select>
                                                    @elseif($leave["status"] == 1)
                                                        <select name="status" class="form-control form-select text-center" style="background-color: #1d82cf; width: 100px; color: white; cursor: pointer;">
                                                            <option value="1" data-old-value ="{{$leave["id"]}}" data-id="{{$key}}" selected>Confirm</option>
                                                            <option value="0" data-old-value ="{{$leave["id"]}}" data-id="{{$key}}">Pending</option>
                                                            <option value="2" data-old-value ="{{$leave["id"]}}" data-id="{{$key}}">Approve</option>
                                                            <option value="3" data-old-value ="{{$leave["id"]}}" data-id="{{$key}}">DisApprove</option>
                                                            <input type="hidden" value="{{$leave["leavetype"]}}" class="leave_type" id="leave_type{{$key}}">
                                                            
                                                            <input type="hidden" value="{{$leave["emp_id"]}}" class="emp" id="emp{{$key}}">
                                                            <input type="hidden" value="{{$leave["total"]}}" class="day" id="day{{$key}}">
                                                        </select>
                                                    @elseif($leave["status"] == 2)
                                                        <select name="status" class="form-control form-select text-center" style="background-color: #28a745; width: 100px; color: white; cursor: pointer;">
                                                            <option value="2" data-old-value ="{{$leave["id"]}}" data-id="{{$key}}" selected>Approve</option>
                                                            <option value="1" data-old-value ="{{$leave["id"]}}" data-id="{{$key}}">Confirm</option>
                                                            <option value="0" data-old-value ="{{$leave["id"]}}" data-id="{{$key}}">Pending</option> 
                                                            <option value="3" data-old-value ="{{$leave["id"]}}" data-id="{{$key}}">DisApprove</option>
                                                            <input type="hidden" value="{{$leave["leavetype"]}}" class="leave_type" id="leave_type{{$key}}"> 
                                                            <input type="hidden" value="{{$leave["emp_id"]}}" class="emp" id="emp{{$key}}"> 
                                                            <input type="hidden" value="{{$leave["total"]}}" class="day" id="day{{$key}}">
                                                        </select>
                                                    @else
                                                        <select name="status" class="form-control form-select text-center" style="background-color: #f04f4d; width: 100px; color: white; cursor: pointer;">
                                                            <option value="3" data-old-value ="{{$leave["id"]}}" data-id="{{$key}}" selected>DisApprove</option>    
                                                            <option value="2" data-old-value ="{{$leave["id"]}}" data-id="{{$key}}">Approve</option>
                                                            <option value="1" data-old-value ="{{$leave["id"]}}" data-id="{{$key}}">Confirm</option>
                                                            <option value="0" data-old-value ="{{$leave["id"]}}" data-id="{{$key}}">Pending</option>
                                                            <option value="3" data-old-value ="{{$leave["id"]}}" data-id="{{$key}}">DisApprove</option>    
                                                            <input type="hidden" value="{{$leave["leavetype"]}}" class="leave_type" id="leave_type{{$key}}"> 
                                                            <input type="hidden" value="{{$leave["emp_id"]}}" class="emp" id="emp{{$key}}"> 
                                                            <input type="hidden" value="{{$leave["total"]}}" class="day" id="day{{$key}}">
                                                        </select>
                                                    @endif
                                                </td>
                                            @endif
                                            <!--<td class="text-left" style="font-size:15px">-->
                                            <!--    <a href="/view/{{$leave["id"]}}" ><span class="glyphicon glyphicon-eye-open"></a> -->
                                            <!--    <a href="/edit-apply-leave/{{$leave["id"]}}"><span class="glyphicon glyphicon-edit"></a>-->
                                            <!--    <a href="/delete-leave/{{$leave["id"]}}"><span class="glyphicon glyphicon-trash"></a> -->
                                            <!--</td>-->
                                            <td>
                                                <a href="/view/{{$leave["id"]}}" class="btn btn-primary" style="font-size: 10px;"><i class="fas fa-eye"></i></a>
                                                <a href="/edit-apply-leave/{{$leave["id"]}}" class="btn btn-warning" style="font-size: 10px;"><i class="fas fa-edit"></i></a>
                                                <a href="/delete-leave/{{$leave["id"]}}" onclick="return confirm('Are you sure want to delete the leave?')" class="btn btn-danger" style="font-size: 10px;"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                     @if($datas->total() > 10)
                                        <div class="card-footer d-flex justify-content-center">
                                            {{ $datas->links() }}
                                        </div>
                                    @endif
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        $('select[name=status]').on('change',function() {
            var value = $(this).val();
            var selectOption = $('option:selected',this);
            var id = selectOption.data('old-value');
            var key =selectOption.data('id');
            // alert(value);
            if(value == 0 || value == 1 || value == 2  || value == 3 ){
                var leave_type = $('#leave_type'+key).val();
                var emp = $('#emp'+key).val();
                var total = $('#day'+key).val();
            }
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "/change-st",
                type: "POST",
                dataType: "json",
                data:{
                    id:id,
                    status:value,
                    emp:emp,
                    leave_type:leave_type,
                    total:total
                },
                success: function(){

                    swal.fire({
                        title: "Success",
                        text: "Status Successfully Changed!",
                        icon: "success",
                    }).then(function() {
                        window.location.reload();
                    })


                }
                        
            });
        });
    });
</script>
@endsection