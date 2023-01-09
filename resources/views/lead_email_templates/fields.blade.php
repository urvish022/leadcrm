<div class="form-group col-sm-6" >
    {!! Form::label('email_type', 'Email Type:') !!}
    <select class="form-control" name="email_type" style="width: 100%">
        <option value="">Select</option>
        @foreach($options as $val)
        <option value="{{$val}}" @if(isset($leadContacts) && $leadContacts->email_type == $val) selected @endif>{{$val}}</option>
        @endforeach
    </select>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('subject', 'Subject:') !!}
    {!! Form::text('subject', null, ['class' => 'form-control']) !!}
</div>

@if(isset($leadContacts))
<x-forms.tinymce-editor fieldName="body" label="Body:" value="{{$leadContacts->body}}" />
@else
<x-forms.tinymce-editor fieldName="body" label="Body:" value="" />
@endif

<div class="form-group col-sm-6">
    {!! Form::label('keywords', 'Keywords:') !!}
    {!! Form::text('keywords', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('lead-email-templates.index') }}" class="btn btn-secondary">Cancel</a>
</div>

