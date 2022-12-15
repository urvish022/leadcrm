@extends('layouts.app')
@push('styles')
    <style>
        .import-leads-button{
            border: 1px solid;
            padding: 10px;
        }
        .import-leads-button:hover{
            background-color:white;
            color:black;
            text-decoration: none;
        }
        .filter-button{
            border: 1px solid;
            padding: 10px;
        }
        .filter-button:hover{
            background-color:white;
            color:black;
            text-decoration: none;
        }
    </style>
@endpush
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Companies</li>

    </ol>
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <a class="filter-button pull-right" href="#" onclick="filterPopup()"><i class="fa fa-filter fa-lg"></i>&nbsp;Filter</a>
                <a class="import-leads-button pull-right" href="{{ route('leads.import') }}"><i class="fa fa-plus-square fa-lg"></i>&nbsp;Import Companies</a>
                <a class="import-leads-button pull-right" href="#" onclick="exportLeads()"><i class="fa fa-download fa-lg"></i>&nbsp;Export</a>
            </div>
        </div>
        <br>
        <div class="row" style="display:none" id="bulk_select_section">
            <div class="col-lg-12">
                <div>
                    <button type="button" class="btn btn-danger pull-right" ><i class="fa fa-trash fa-lg"></i>&nbsp;Delete</button>
                </div>
                <div>
                    <button type="button" class="btn btn-warning pull-right" onclick="openBulkStatusPopup()"><i class="fa fa-tag fa-lg"></i>&nbsp;Change Status</button>
                </div>
                <div>
                    <button type="button" class="btn btn-success pull-right" onclick="scheduleEmail()"><i class="fa fa-rocket fa-lg"></i>&nbsp;Schedule</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             Companies
                             <!-- <a class="pull-right" href="{{ route('leads.create') }}"><i class="fa fa-plus-square fa-lg"></i></a> -->
                         </div>
                         <div class="card-body">
                             @include('leads.table')
                              <div class="pull-right mr-3">
                              </div>
                         </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>
@endsection

