@extends('hrms.layouts.base')

@section('content')
       
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
                <li class="breadcrumb-current-item"> Leave Detail</li>
            </ol>
        </div>
    </header>


    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">
        <!-- -------------- Column Center -------------- -->
        <div class="chute-affix">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title hidden-xs" style="color: black">Leave Detail of {{$leave[0]["employee"]}} </span><br />
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <tr class="bg btn-success">
                                                    <th class="text-left" style="font-size: 18px">Leave Request:</th>
                                                    <th class="text-left" style="font-size: 18px">Details</th>
                                                </tr>
                                                <tr>
                                                    <td class="text-left" style="font-size: 15px">Leader Name</td>
                                                    <td class="text-left" style="font-size: 15px">{{$leave[0]["leader"]}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left" style="font-size: 15px">Employee Name</td>
                                                    <td class="text-left" style="font-size: 15px">{{$leave[0]["employee"]}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left" style="font-size: 15px">Leave Type</td>
                                                    <td class="text-left" style="font-size: 15px">{{$leave[0]["leave_type"]}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left" style="font-size: 15px">Date From</td>
                                                    <td class="text-left" style="font-size: 15px">{{$leave[0]["dateFrom"]}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left" style="font-size: 15px">Date To</td>
                                                    <td class="text-left" style="font-size: 15px">{{$leave[0]["dateTo"]}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left" style="font-size: 15px">Total Days</td>
                                                    <td class="text-left" style="font-size: 15px">{{$leave[0]["total"]}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left" style="font-size: 15px">Claim Date</td>
                                                    <td class="text-left" style="font-size: 15px">{{$leave[0]["date_claim"]}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left" style="font-size: 15px">Content</td>
                                                    <td class="text-left" style="font-size: 15px">{{$leave[0]["content"]}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left" style="font-size: 15px">CC Remark</td>
                                                    <td class="text-left" style="font-size: 15px">{{$leave[0]["cc_remark"]}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left" style="font-size: 15px">HR Remark</td>
                                                    <td class="text-left" style="font-size: 15px">{{$leave[0]["hr_remark"]}}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="text-left" style="font-size: 15px">Confirm State</td>
                                                    @if($leave[0]["status"]== 0)
                                                        <td class="text-left" style="font-size: 17px;color:yellowgreen"><i class="fa fa-external-link"> Pending </i></td>
                                                    @elseif ($leave[0]["status"]== 1)
                                                        <td class="text-left" style="font-size: 17px;color:green"><i class="fa fa-check"> Approved </i></td>
                                                    @else
                                                        <td class="text-left" style="font-size: 17px;color:red"><i class="fa fa-times"> Disapproved </i></td>
                                                    @endif
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 style="font-size:18px;font-weight:bold">Related Image For Leave</h4>
                                        @if(!empty($image))
                                            @foreach ($leave[0]["image"] as $img )
                                                <img src="{{asset('public/medicalleave/'. $img)}}" class="img-thumbnail" style="height:250px;width:230px"/>
                                            @endforeach
                                        @else
                                            <p style="font-style:italic">There is no photo for this leave</p>
                                        @endif
                                    </div>   
                                </div>
                                <div class="col-md-3">
                                    <a href="/my-leave-list" class="btn btn-primary">Back</a>
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