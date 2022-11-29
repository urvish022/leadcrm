<div class="form-group col-sm-6" >
    {!! Form::label('category', 'Category:') !!}
    <select class="form-control" name="category_id" style="width: 100%">
        <option value="">Select</option>
        @foreach($categories as $val)
        <option value="{{$val['id']}}" >{{$val['category_name']}}</option>
        @endforeach
    </select>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('file', 'File:') !!}
    <input type="file" name="leads_file" class="form-control">
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('leads.index') }}" class="btn btn-secondary">Cancel</a>
</div>
