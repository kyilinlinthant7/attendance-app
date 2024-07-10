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
                                <span class="panel-title hidden-xs" style="color: black"> Leave Records List </span>
                            </div>
                            <div class="panel-body pn">
                                @if(Session::has('flash_message'))
                                    <div class="alert alert-success">
                                        {{ Session::get('flash_message') }}
                                    </div>
                                @endif
                                    @if(Session::has('flash_message1'))
                                        <div class="alert alert-success">
                                            {{ Session::get('flash_message1') }}
                                        </div>
                                    @endif
                                    {!! Form::open(array('url' =>'/search-leaverecord' ,'class'=>'form-horizontal',"enctype"=>"multipart/form-data")) !!}
                                    <div class="panel-menu allcp-form theme-primary mtn">
                                        <div class="row" style="margin-left: 15px; margin-top:10px">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="search" name="keywords" value="" placeholder="Enter search keywords..." style="border:2px solid #F7730E; margin-left: -30px;">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="submit" name="search" value="search" class="btn btn-primary">Search</a>
                                            </div>
                                            <div class="col-md-1">
                                                <a href="/leaverecord" class="btn btn-warning">Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                            <thead>
                                            <tr class="bg-light">
                                                <th class="text-center" style="font-size:15px">Id</th>
                                                <th class="text-center" style="font-size:15px">Employee</th>
                                                <th class="text-center" style="font-size:15px">Casual Leave</th>
                                                <th class="text-center" style="font-size:15px">Earned Leave</th>
                                                <th class="text-center" style="font-size:15px">Medical Leave</th>
                                                <th class="text-center" style="font-size:15px">Maternity Leave</th>
                                                <th class="text-center" style="font-size:15px">Paternity Leave</th>
                                                <th class="text-center" style="font-size:15px">Compassionate Leave</th>
                                                <th class="text-center" style="font-size:15px">Without Pay Leave</th>
                                                <th class="text-center" style="font-size:15px">Absent Leave</th>
                                                <!--<th class="text-center">Remark</th>-->
                                                @if(Auth::user()->isHrOfficerCompen() || AUth::user()->isAdmin())
                                                    <th class="text-center" style="font-size:15px">Actions</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i =0;?>
                                            @foreach($leaves as $leave)
                                                <tr>
                                                    <td class="text-center" style="font-size:14px">{{$i+=1}}</td>
                                                    <td class="text-center" style="font-size:14px">{{$leave->name}}</td>
                                                    <td class="text-center" style="font-size:14px">{{$leave->casual_leave}}</td>
                                                    <td class="text-center" style="font-size:14px">{{$leave->earned_leave}}</td>
                                                    <td class="text-center" style="font-size:14px">{{$leave->medical_leave}}</td>
                                                    <td class="text-center" style="font-size:14px">{{$leave->maternity_leave}}</td>
                                                    <td class="text-center" style="font-size:14px">{{$leave->paternity_leave}}</td>
                                                    <td class="text-center" style="font-size:14px">{{$leave->compassionate_leave}}</td>
                                                    <td class="text-center" style="font-size:14px">{{$leave->without_pay_leave}}</td>
                                                    <td class="text-center" style="font-size:14px">{{$leave->absent_leave}}</td>
                                                    <!--<td class="text-center">{{$leave->remark}}</td>-->
                                                    
                                                    @if(Auth::user()->isHrOfficerCompen() || Auth::user()->isAdmin())
                                                        <td class="text-center">
                                                            <a href="/edit-leave-record/{{$leave->id}}" class="btn"><span class="glyphicon glyphicon-edit"></span></a>
                                                            <a href="/delete-leave-record/{{$leave->id}}" class="btn"><span class="glyphicon glyphicon-trash"></span></a>       
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            <tr>
                                                {!! $leaves->render() !!}
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
@endsection