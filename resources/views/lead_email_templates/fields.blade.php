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

<div class="form-group col-sm-6">
    {!! Form::label('body', 'Body:') !!}
    {!! Form::textarea('body', null, ['class' => 'form-control my-editor','id'=>'trumbowyg-body']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('keywords', 'Keywords:') !!}
    {!! Form::text('keywords', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('lead-email-templates.index') }}" class="btn btn-secondary">Cancel</a>
</div>

@push('scripts')
<script type="text/javascript">
$('#trumbowyg-body').trumbowyg();
</script>
@endpush