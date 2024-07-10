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
                                    <span class="panel-title hidden-xs" style="color: black"> Project Assignment Listings </span>
                                    <div class="text-right">
                                        <a href="/assign-project" class="btn btn-success" style="margin-top: -50px;">Create</a>
                                    </div>
                                    {!! Form::open(array('url' =>'/assign-search', 'class'=>'form-horizontal', "enctype"=>"multipart/form-data")) !!}
                                        <div class="panel-menu allcp-form theme-primary mtn">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="search" name="keywords" value="" placeholder="search site name" style="border:2px solid #F7730E">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="submit" name="search" value="search" class="btn btn-primary">Search</a>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a href="/project-assignment-listing" class="btn btn-warning">Reset</a>
                                                    </div>
                                                </div>
                                    {!! Form::close() !!}
                                    
                                    {!! Form::open(array('url' =>'/assign-site-search', 'class'=>'form-horizontal', "enctype"=>"multipart/form-data")) !!}
                                                <div class="col-md-5">
                                                    <div class="col-md-8">
                                                        <select class="select2-multiple form-control" name="site_id">
                                                            <option>Select Site Name</option>
                                                            @if(isset($sites) && count($sites) > 0)
                                                                @foreach($sites as $site)
                                                                    <option value="{{ $site->id }}">{{ $site->name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="submit" name="site_search" value="site_search" class="btn btn-primary">Search</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
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
                                                <th class="text-left" style="font-size:15px">Id</th>
                                                <th class="text-left" style="font-size:15px">Project</th>
                                                <th class="text-left" style="font-size:15px">Shift</th>
                                                <th class="text-left" style="font-size:15px">Leader</th>
                                                <th class="text-left" style="font-size:15px; width: 150px;">Employee</th>
                                                <th class="text-left" style="font-size:15px">PartTime</th>
                                                <th class="text-left" style="font-size:15px">RV</th>
                                                <th class="text-left" style="font-size:15px">Authorized Person</th>
                                                <th class="text-left" style="font-size:15px">Date of Assignment</th>
                                                <th class="text-left" style="font-size:15px">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i =0;?>
                                                @if(isset($projects) && count($projects) > 0)
                                                    @foreach($projects as $project)
                                                        <tr>
                                                            <td class="text-left" style="font-size:14px">{{$i+=1}}</td>
                                                            <td class="text-left" style="font-size:14px">{{$project["project_name"]}}</td>
                                                            <td class="text-left" style="font-size:14px">{{$project["shift_name"] ?? ''}}</td>
                                                            <td class="text-left" style="font-size:14px">
                                                                @php $j = 1; @endphp
                                                                @foreach ($project["leader_name"] as $leader)
                                                                    {{$j++}}. {{$leader["name"]}}<br>     
                                                                @endforeach
                                                            </td>
                                                            <td class="text-left" style="font-size:14px;font-weight:bold"> 
                                                                @php $j = 1; @endphp
                                                                @foreach ($project["employee"] as $emp)

                                                                {{$j++}}. {{$emp["name"]}}<br>     
                                                                @endforeach
                                                            </td>
                                                            <td class="text-left" style="font-size:14px;font-weight:bold"> 
                                                                @php $j = 1; @endphp
                                                                @foreach ($project["parttimes"] as $part)

                                                                {{$j++}}. {{$part["name"]}}<br>     
                                                                @endforeach
                                                            </td>
                                                            <td class="text-left" style="font-size:14px">
                                                                @php $j = 1; @endphp
                                                                @foreach ($project["rv_name"] as $rv)
                                                                    {{$j++}}. {{$rv["name"]}}<br>     
                                                                @endforeach
                                                            </td>
                                                            <td class="text-left" style="font-size:14px">{{$project["authority_name"]}}</td>
                                                            <td class="text-left" style="font-size:14px">{{$project["date_of_assignment"]}}</td>
                                                            <td class="text-left" >
                                                                <a href="/edit-project-assignment/{{$project["id"]}}" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
                                                                <a href="/delete-project-assignment/{{$project["id"]}}" class="btn btn-danger" style="margin-top: 5px" onclick="return confirm('Are you sure want to delete the site?')"><span class="glyphicon glyphicon-trash"></span></a> 
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        {!! $assignLists->render() !!}
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="12" class="text-center" style="font-size:20px">There is no item to display.</td>
                                                    </tr>
                                                @endif
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