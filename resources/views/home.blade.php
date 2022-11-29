@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">Dashboard</li>
</ol>
<div class="container-fluid">
    
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-primary"> 
                            <div class="card-body pb-0">
                                <div class="text-value">{{$statistics['scrapped']}}</div>
                                <div>Total Scrapped Count</div>
                            </div>
                            <div class="chart-wrapper mt-3 mx-3" style="height:20px;">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-warning"> 
                            <div class="card-body pb-0">
                                <div class="text-value">{{$statistics['leads']}}</div>
                                <div>Total Leads Count</div>
                            </div>
                            <div class="chart-wrapper mt-3 mx-3" style="height:20px;">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-info"> 
                            <div class="card-body pb-0">
                                <div class="text-value">{{$statistics['followup1']}}</div>
                                <div>Total First Followup Count</div>
                            </div>
                            <div class="chart-wrapper mt-3 mx-3" style="height:20px;">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-green"> 
                            <div class="card-body pb-0">
                                <div class="text-value">{{$statistics['in']}}</div>
                                <div>Total IN Count</div>
                            </div>
                            <div class="chart-wrapper mt-3 mx-3" style="height:20px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
@endsection
