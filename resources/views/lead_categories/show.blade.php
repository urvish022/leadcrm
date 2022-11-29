@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('lead-category.index') }}">Lead Category</a>
            </li>
            <li class="breadcrumb-item active">Detail</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
                @include('coreui-templates::common.errors')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong>Details</strong>
                                <a href="{{ route('lead-category.index') }}" class="btn btn-light">Back</a>
                                <a class="pull-right" href="{{ route('lead-email-templates.create').'/'.request('lead_category') }}"><i class="fa fa-plus-square fa-lg"></i></a>
                            </div>
                            <div class="card-body">
                                @include('lead_categories.show_fields')
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection