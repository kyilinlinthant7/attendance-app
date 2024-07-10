@extends('hrms.layouts.base')

@section('content')
        <!-- START CONTENT -->
<div class="content">

    <header id="topbar" class="alt">
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
                    <a href=""> Leave </a>
                </li>
                <li class="breadcrumb-current-item"> Add Leave Record </li>
            </ol>

        </div>
    </header>
    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn" >
        <!-- -------------- Column Center -------------- -->
        <div class="chute-affix">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">                       
                            <span class="panel-title hidden-xs"> Add Leave Record </span>
                        </div>

                        <div class="panel-body pn">

                            <div class="table-responsive">
                                <div class="panel-body p25 pb10">

                                    @if(Session::has('flash_message'))
                                        <div class="alert alert-success">
                                            {{Session::get('flash_message')}}
                                        </div>
                                    @endif
                                    {!! Form::open(array('url' =>'/save-leave-record' ,'class'=>'form-horizontal',"enctype"=>"multipart/form-data")) !!}

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Employee </label>
                                            <div class="col-md-6">
                                                <select class="select2-multiple form-control select-primary"
                                                        name="name" id="name" required>
                                                    <option value="" selected>Select Employee</option>
                                                    @foreach ($emps as $emp)
                                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Casual Leave </label>
                                            <div class="col-md-6">
                                                 <input type="text" name="casual" id="input002" class="select2-single form-control" placeholder="Casual Leave " >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Earned Leave </label>
                                            <div class="col-md-6">
                                                 <input type="text" name="earned" id="input002" class="select2-single form-control" placeholder="Earned Leave">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Medical Leave </label>
                                            <div class="col-md-6">
                                                 <input type="text" name="medical" id="input002" class="select2-single form-control" placeholder="Medical Leave">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Maternity Leave </label>
                                            <div class="col-md-6">
                                                 <input type="text" name="maternity" id="input002" class="select2-single form-control" placeholder="Maternity Leave">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Paternity Leave </label>
                                            <div class="col-md-6">
                                                 <input type="text" name="paternity" id="input002" class="select2-single form-control" placeholder="Paternity Leave" >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Compassionate Leave </label>
                                            <div class="col-md-6">
                                                 <input type="text" name="compassionate" id="input002" class="select2-single form-control" placeholder="Compassionate Leave" >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Without Pay Leave </label>
                                            <div class="col-md-6">
                                                 <input type="text" name="withoutpay" id="input002" class="select2-single form-control" placeholder="Without Pay Leave" >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Absent Leave </label>
                                            <div class="col-md-6">
                                                 <input type="text" name="absent" id="input002" class="select2-single form-control" placeholder="Absent Leave" >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Remark </label>
                                            <div class="col-md-6">
                                                 <textarea type="text" name="remark" id="input002" class="select2-single form-control" placeholder="Remark" ></textarea>
                                            </div>
                                        </div>

                                    


                                        <div class="form-group">
                                            <label class="col-md-3 control-label"></label>
                                            <div class="col-md-2">
                                                <input type="submit" class="btn btn-bordered btn-info btn-block" value="Submit">
                                            </div>
                                            <div class="col-md-2"><a href="add-leave-record">
                                                <input type="button" class="btn btn-bordered btn-success btn-block" value="Reset"></a></div>
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
