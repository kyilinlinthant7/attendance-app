@extends('hrms.layouts.base')

@section('content')

    <div class="content">

    <section id="content" class="table-layout animated fadeIn">
        <div class="chute-affix">
            <!-- -------------- Login Users Table -------------- -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-4">
                                        <span class="panel-title hidden-xs" style="color: black"> Users List </span>
                                    </div>
                                    <div class="col-md-8 text-right" style="margin-top: -20px;">
                                        {!! $users->render() !!}
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body pn">
                                @if(Session::has('flash_message'))
                                    <div class="alert alert-success">
                                        {{ Session::get('flash_message') }}
                                    </div>
                                @endif
                                {!! Form::open(['class' => 'form-horizontal']) !!}
                                <div class="table-responsive">
                                    <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                        <thead>
                                        <tr class="bg-light">
                                            <th class="text-left" style="font-size:15px">No</th>
                                            <th class="text-left" style="font-size:15px">User Name</th>
                                            <th class="text-left" style="font-size:15px">Role</th>
                                            <th class="text-left" style="font-size:15px">Created at</th>
                                            <th class="text-left" style="font-size:15px">Actions</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $itemNo = $users->firstItem();
                                            @endphp
                                            @foreach($users as $user)
                                                <tr>
                                                    <td class="text-left" style="font-size:14px">{{$itemNo++}}</td>
                                                    <td class="text-left" style="font-size:14px">{{$user->email}}</td>
                                                    <td class="text-left" style="font-size:14px">@if($user->role == "leader") Leader @else {{$user->role}} @endif</td>
                                                    <td class="text-left" style="font-size:14px">{{$user->created_at}}</td>
                                                    <td class="text-left" style="font-size:14px">
                                                        <a href="/edit-user/{{$user->id}}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                        <a href="/delete-user/{{$user->id}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete the user?')"><i class="fas fa-trash"></i></a>    
                                                    </td>
                                                </tr>
                                            @endforeach
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