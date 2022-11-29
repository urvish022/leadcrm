@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('lead-email-templates.index') !!}">Lead Email Templates</a>
          </li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('coreui-templates::common.errors')
             <div class="row">
                 <div class="col-lg-12">
                      <div class="card">
                          <div class="card-header">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>Edit Lead Email Templates</strong>
                          </div>
                          <div class="card-body">
                              {!! Form::model($leadContacts, ['route' => ['lead-email-templates.update', $leadContacts->id], 'method' => 'patch']) !!}
                                <input type="hidden" name="category_id" value="{{$leadContacts->category_id}}">
                              @include('lead_email_templates.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection