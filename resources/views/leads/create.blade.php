@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
         <a href="{!! route('leads.index') !!}">Prospect</a>
      </li>
      <li class="breadcrumb-item active">Create</li>
    </ol>
     <div class="container-fluid">
          <div class="animated fadeIn">
                @include('coreui-templates::common.errors')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-plus-square-o fa-lg"></i>
                                <strong>Create Prospect</strong>
                            </div>
                            <div class="card-body">
                                @if(request()->route()->getName() == 'leads.import')
                                {!! Form::open(['route' => 'leads.mass-store','enctype="multipart/form-data"']) !!}
                                   @include('leads.import_fields')
                                {!! Form::close() !!}
                                @else
                                {!! Form::open(['route' => 'leads.store']) !!}
                                   @include('leads.fields')
                                {!! Form::close() !!}
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
@endsection
