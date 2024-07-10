@extends('hrms.layouts.base')

<style>
    .p25 {
        margin-left: 50px;
        margin-top: -10px !important;
    }
</style>

@section('content')
    <!-- START CONTENT -->
    <div class="content">
    <header style="margin-top: 50px"></header>

        <!-- -------------- Content -------------- -->
        <section id="content" class="table-layout animated fadeIn" >
            <!-- -------------- Column Center -------------- -->
            <div class="chute-affix">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel">
                            <div class="panel-heading text-center">
                                    <span class="panel-title hidden-xs" style="color: black"> Change Password </span>
                            </div>

                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <div class="panel-body p25 pb10">
                                        @if(Session::has('flash_message'))
                                            <div class="alert alert-success">
                                                {{Session::get('flash_message')}}
                                            </div>
                                        @endif
                                        {!! Form::open(['class' => 'form-horizontal', 'id' => 'passwordForm']) !!}

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Old Password: </label>
                                            <div class="col-md-6">

                                                    <input type="password" name="old" id="old_password" class="select2-single form-control" placeholder=" Enter old password...">

                                            </div>
                                        </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> New Passowrd: </label>
                                                <div class="col-md-6">

                                                    <input type="password" name="new" id="new_password" class="select2-single form-control" placeholder="Enter new password...">

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Confirm New Password: </label>
                                                <div class="col-md-6">

                                                    <input type="password" name="confirm" id="confirm_password" class="select2-single form-control" placeholder="Confirm password...">

                                                </div>
                                            </div>

                                            <div class="form-group" style="margin-top: 30px">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-2">
                                                    <input type="submit" class="btn btn-bordered btn-info btn-block" value="Submit">
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="/change-password" style="text-decoration: none;">
                                                        <input type="button" class="btn btn-bordered btn-success btn-block" value="Reset">
                                                    </a>
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