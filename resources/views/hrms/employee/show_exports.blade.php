@extends('hrms.layouts.base')

<style>
    .panel {
        height: 280px;
    }
    .btn {
        width: 160px;
    }
    #date_from, #date_to, #month_filter {
        cursor: pointer;
    }
</style>

@section('content')
        <!-- START CONTENT -->
<div class="content">

    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">
        <div class="chute-affix">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                        <div class="panel">
                            <div class="row" style="padding: 0 15px;">
                                <form action="/export-detail" method="POST">
                                    <div class="panel-heading col-md-12">
                                        <span class="panel-title hidden-xs" style="color: black;">Export Employees Detail (Daily)</span><br />
                                    </div>
                                    <div class="col-md-12" style="padding-top: 30px; margin-left: 35%;">
                                        <div class="col-md-2">
                                            <label id="date_from">Date From:</label>
                                            <input type="date" name="date_from" id="date_from" class="form-control">
                                            <br>
                                            <label id="date_to">Date To:</label>
                                            <input type="date" name="date_to" id="date_to" class="form-control">
                                        </div>
                                        <div class="col-md-2" style="padding-top: 25px;">
                                            <input type="submit" value="Export Detail" name="button" id="export_button" class="btn btn-success">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="panel">
                            <div class="row" style="padding: 0 15px;">
                                <form action="/export-summary" method="POST">
                                    <div class="panel-heading col-md-12">
                                        <span class="panel-title hidden-xs" style="color: black;">Export Employees Summary (Monthly)</span><br />
                                    </div>
                                    <div class="col-md-12" style="padding-top: 30px; margin-left: 35%;">
                                        <div class="col-md-2">
                                            <label id="month_filter">Month Filter:</label>
                                            <input type="month" name="month_filter" id="month_filter" class="form-control">
                                        </div>
                                        <div class="col-md-2" style="padding-top: 25px;">
                                            <input type="submit" value="Export Summary" name="button" id="export_button" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
