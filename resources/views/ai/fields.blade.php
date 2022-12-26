<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control','id'=>'title']) !!}
</div>

<x-tiny-editor />

<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('ai.index') }}" class="btn btn-secondary">Cancel</a>
</div>
