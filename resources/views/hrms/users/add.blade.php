@extends('hrms.layouts.base')

@section('content')


<div class="content">
    <!--<header id="topbar" class="alt">-->
    <!--    <div clss="topbae-left">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li class="breadcrumb-icon">-->
    <!--                <a href="/dashboard">-->
    <!--                    <span class="fa fa-home"></span>-->
    <!--                </a>-->
    <!--            </li>-->
    <!--            <li class="breadcrumb-active">-->
    <!--                <a href="/dashboard"> Dashboard </a>-->
    <!--            </li>-->
    <!--            <li class="breadcrumb-link">-->
    <!--                <a href=""> User </a>-->
    <!--            </li>-->
    <!--            <li class="breadcrumb-current-item"> Add User</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</header>-->


    <section id="content" class="table-layout animated fadeIn">
        <!-- -------------- Column Center -------------- -->
        <div class="chute-affix">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                        <div class="panel">
                            <div class="panel-heading text-center">
                                <span class="panel-title hidden-xs" style="color: black"> Create New User </span>
                            </div>

                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <div class="panel-body p25 pb10">
                                        @if(Session::has('flash_message'))
                                            <div class="alert alert-success">
                                                {{Session::get('flash_message')}}
                                            </div>
                                        @endif
                                        {!! Form::open(array('url' =>'/save-user' ,'class'=>'form-horizontal',"enctype"=>"multipart/form-data")) !!}

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Role</label>
                                            <div class="col-md-6">
                                                @if(Auth::user()->isHR() || Auth::user()->isAdmin() )
                                                    <select name="role" id="role"  class="select2-multiple form-control select-primary">
                                                        <option value=""> Please Select Role</option>
                                                        <option vlaue="Clean Pro Manager">Clean Pro Manager</option>  
                                                        <option vlaue="Clean Pro Administrator">Clean Pro Administrator</option>
                                                        <option vlaue="Clean Pro Admin">Clean Pro Admin</option>
                                                        <option vlaue="HR Manager">HR Manager</option>
                                                        <option vlaue="Assistant HR Manager">Assistant HR Manager</option>
                                                        <option vlaue="HR Officer (Recruit & Select)">HR Officer (Recruit & Select)</option>
                                                        <option vlaue="HR Officer (Compen & Benefit)">HR Officer (Compen & Benefit)</option>
                                                        <option vlaue="HR Officer (ER & Dev)">HR Officer (ER & Dev)</option>
                                                        <option value="HR Assistant">HR Assistant</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="leader">Leader</option>
                                                    </select>
                                                @else
                                                    <select name="role" id="role"  class="select2-multiple form-control select-primary">
                                                        <option value=""> Please Select Role</option>
                                                        <option value="leader">Leader</option>
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <div class="form-group">
                                                <label class="col-md-3 control-label">Username </label>
                                                <div class="col-md-6">
                                                <select name="name" id="name"  class="select2-multiple form-control js-select-2">
                                                    <option value="0">Please Select User</option>
                                                    @foreach($emps as $key => $value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Password </label>
                                            <div class="col-md-6">
                                                <input type="text" name="password" id="password"
                                                    class="select2-single form-control" placeholder="Password" required readonly
                                                  >
                                            </div>
                                            <div class="col md-3">
                                                <a href="javascript:void(0)" id="genpass" class="btn btn-success">gen pass</a>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"></label>
                                            <div class="col-md-2">

                                                <input type="submit" class="btn btn-bordered btn-info btn-block"
                                                       value="Save">
                                            </div>
                                            <div class="col-md-2"><a href="/add-user" style="text-decoration: none">
                                                    <input type="button"
                                                           class="btn btn-bordered btn-success btn-block"
                                                           value="Reset"></a>
                                            </div>
                                        </div>

                                        {{-- </form> --}}
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

@endsection


 
