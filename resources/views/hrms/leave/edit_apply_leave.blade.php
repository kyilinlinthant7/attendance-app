@extends('hrms.layouts.base')

<style>
    .p25 {
        margin-left: 150px;
        margin-top: -10px !important;
    }
</style>

@section('content')
       
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
                            <span class="panel-title hidden-xs" style="color: black"> Apply for Leave Edit</span>
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
                                    {{-- {!! Form::open(['class' => 'form-horizontal', 'method' => 'post']) !!} --}}
                                    {!! Form::open(array('url' =>array('/edit-leave-apply' ,$applyLeave->id) ,'class'=>'form-horizontal',"enctype"=>"multipart/form-data")) !!}


                                    <div class="form-group">
                                        <label class="col-md-2 control-label"> Site </label>
                                        <div class="col-md-6">
                                            <select class="select2-multiple form-control select-primary"
                                                    name="site" id="site">
                                                    @foreach ($sites as $site)
                                                        @if ($site->id == $applyLeave->site_id)
                                                            <option value="{{$site->id}}" selected>{{$site->name}}</option>
                                                        @else
                                                            <option value="{{$site->id}}">{{$site->name}}</option>
                                                        @endif
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label"> Leader </label>
                                        <div class="col-md-6"> 
                                            <select class="select2-multiple form-control select-primary"
                                                    name="leader" id="leader">
                                                <option value="" selected>Select Leader</option>
                                                @foreach ($emps as $emp)
                                                    @if($emp->id == $applyLeave->leader)
                                                        <option value="{{$emp->id}}" selected>{{$emp->name}}</option>
                                                    @else
                                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label"> Employee </label>
                                        <div class="col-md-6">
                                            <select class="select2-multiple form-control select-primary"
                                                    name="emp" id="emp">
                                                @foreach ($emps as $emp)
                                                    @if($emp->id == $applyLeave->emp_id)
                                                        <option value="{{$emp->id}}" selected>{{$emp->name}}</option>
                                                    @else
                                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label"> Leave Type </label>
                                        <div class="col-md-6">
                                            <select class="select2-multiple form-control select-primary leave_type"
                                                    name="leave_type" id="leave_type" required>
                                                    <option value="{{$applyLeave->leave_type}}" selected>{{$applyLeave->leave_type}}</option>
                                                    <option value="Casual Leave" >Casual Leave</option>
                                                    <option value="Earned Leave">Earned Leave</option>
                                                    <option value="Medical Leave">Medical Leave</option>
                                                    <option value="Maternity Leave">Maternity Leave</option>
                                                    <option value="Paternity Leave">Paternity Leave</option>
                                                    <option value="Other Leave">Other Leave</option>
                                                    <option value="Absent">Absent</option>
                                                
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="date_from" class="col-md-2 control-label"> Date From </label>
                                        <div class="col-md-2">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar text-alert pr10"></i>
                                                </div>
                                                <input type="text" id="datepicker1" class="select2-single form-control"
                                                    name="dateFrom" value="{{$applyLeave->dateFrom}}" id="sdate" required>
                                            </div>
                                        </div>

                                        <label for="date_to" class="col-md-2 control-label"> Date To </label>
                                        <div class="col-md-2" id="getdate">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar text-alert pr10"></i>
                                                </div>
                                                <input type="text" id="datepicker4" class="select2-single form-control"
                                                    name="dateTo" value="{{$applyLeave->dateTo}}" id="edate" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-2 control-label"></label>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-primary" id="full" value="full" name="full_day" disabled>Full Day</button>
                                        </div>

                                        <label class="col-md-1 control-label"></label>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-primary" id="half" value="half" name="half_day" disabled>Half Day</button>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="input002" class="col-md-2 control-label"> Days </label>
                                        <div class="col-md-6">
                                            <input id="total_days" name="total"
                                                   type="text" size="90" value="{{$applyLeave->total}}" class="select2-single form-control" readonly/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="date-claim" class="col-md-2 control-label">Date Claim</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar text-alert pr10"></i>
                                                </div>
                                                <input type="text" id="datepicker5" class="select2-single form-control"
                                                   value={{$applyLeave->date_claim}} name="claimdate">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="input002" class="col-md-2 control-label"> Content </label>
                                        <div class="col-md-6">
                                            <textarea type="text" id="textarea1" class="select2-single form-control"
                                                   name="content">{{$applyLeave->content}}
                                            </textarea>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label for="input002" class="col-md-2 control-label">CC Remark </label>
                                        <div class="col-md-6">
                                            <textarea type="text" id="textarea2" class="select2-single form-control"
                                                   name="cc_remark"  value="">{{$applyLeave->cc_remark}}
                                            </textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="input002" class="col-md-2 control-label"> HR Remark </label>
                                        <div class="col-md-6">
                                            <textarea type="text" id="textarea3" class="select2-single form-control"
                                                   name="hr_remark"  value="">{{$applyLeave->hr_remark}}
                                            </textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="input002" class="col-md-2 control-label"> Image </label>
                                        <div class="col-md-6">
                                            <input type="file" id="photo"  class="select2-single form-control"
                                                   name="photo[]" multiple>
                                            
                                        </div>
                                    </div>

                                    
                                    

                                    <div class="form-group">
                                        <label class="col-md-2 control-label"></label>

                                        <div class="col-md-2">
                                            <input type="submit" class="btn btn-bordered btn-info btn-block"
                                                value="Submit">
                                        </div>
                                        <div class="col-md-2"><a href="/edit-apply-leave/{{$applyLeave->id}}">
                                                <input type="button" class="btn btn-bordered btn-success btn-block" value="Reset"></a></div>
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
</div>
@endsection

