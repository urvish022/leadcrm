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
        <li class="breadcrumb-item">Leads</li>
        
    </ol>
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-lg-12">
                <a class="filter-button pull-right" href="#" onclick="filterPopup()"><i class="fa fa-filter fa-lg"></i>&nbsp;Filter</a>
                <a class="import-leads-button pull-right" href="{{ route('leads.import') }}"><i class="fa fa-plus-square fa-lg"></i>&nbsp;Import Leads</a>
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
                             Leads
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

