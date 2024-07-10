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
                                    <span class="panel-title hidden-xs" style="color: black"> Sites/Projects List </span>
                                    <div class="text-right">
                                        <a href="/add-project" class="btn btn-success" style="margin-top: -50px;">Create</a>
                                    </div>
                                    
                                    {!! Form::open(array('url' =>'/project-search' ,'class'=>'form-horizontal',"enctype"=>"multipart/form-data")) !!}
                                    <div class="panel-menu allcp-form theme-primary mtn" style="border-left: none; border-right: none;">
                                        <div class="row" style="margin-left: 15px; margin-top:10px">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="search" name="keywords" value="" placeholder="Enter search keywords..." style="border:2px solid #F7730E; margin-left: -29px;">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="submit" name="search" value="search" class="btn btn-primary">Search</a>
                                            </div>
                                            <div class="col-md-1">
                                                <a href="/list-project" class="btn btn-warning">Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                <div class="panel-body pn">
                                    @if(Session::has('flash_message'))
                                        <div class="alert alert-success">
                                            {{ Session::get('flash_message') }}
                                        </div>
                                    @endif
                                    <div class="table-responsive">
                                        <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                            <thead>
                                            <tr class="bg-light">
                                                <th class="text-center" style="font-size:15px">No</th>
                                                <th class="text-left" style="font-size:15px">Project Name</th>
                                                <th class="text-left" style="font-size:15px">Short Term</th>
                                                <th class="text-left" style="font-size:15px">Client Name</th>
                                                <th class="text-left" style="font-size:15px">Description</th>
                                                <th class="text-left" style="font-size:15px">Actions</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                                @php
                                                $itemNo = $projects->firstItem();
                                                @endphp
                                            @foreach($projects as $project)
                                                <tr>
                                                    <td class="text-left" style="font-size:14px">{{$itemNo++}}</td>
                                                    <td class="text-left" style="font-size:14px">{{$project->name}}</td>
                                                    <td class="text-left" style="font-size:14px">{{$project->short_term}}</td>
                                                    <td class="text-left" style="font-size:14px">{{$project->client_id}}</td>
                                                    <td class="text-left" style="font-size:14px">{{$project->description}}</td>
                                                    <td class="text-left">
                                                        <a href="/edit-project/{{$project->id}}" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
                                                        <a href="/delete-project/{{$project->id}}" onclick="return confirm('Are you sure want to delete the site?')" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>    
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                {!! $projects->render() !!}
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