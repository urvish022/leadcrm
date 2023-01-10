<div class="form-group col-sm-6">
    {!! Form::label('categories', 'Categories:') !!}
    <select class="form-control" name="category_id" style="width: 100%">
        <option value="">Select</option>
        @foreach ($categories as $val)
            <option value="{{$val->id}}">{{$val->category_name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group col-sm-6">
    {!! Form::label('company_name', 'Company Name:') !!}
    {!! Form::text('company_name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('company_email', 'Company Email:') !!}
    {!! Form::text('company_email', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('company_phone_number', 'Company Phone Number:') !!}
    {!! Form::text('company_phone_number', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('company_website', 'Company Website:') !!}
    {!! Form::text('company_website', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('total_employees', 'Total Employee:') !!}
    {!! Form::text('total_employees', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('facebook_url', 'Facebook URL:') !!}
    {!! Form::text('facebook_url', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('linkedin_url', 'Linkedin URL:') !!}
    {!! Form::text('linkedin_url', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('twitter_url', 'Twitter URL:') !!}
    {!! Form::text('twitter_url', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('industry_type', 'Industry Type:') !!}
    {!! Form::text('industry_type', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('company_city', 'Company City:') !!}
    {!! Form::text('company_city', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('company_state', 'Company State:') !!}
    {!! Form::text('company_state', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('company_origin', 'Company Country:') !!}
    <select class="form-control" name="company_origin" style="width: 100%">
        <option value="">Select</option>
        <option value="USA">USA</option>
        <option value="UK">UK</option>
        <option value="Australia">Australia</option>
        <option value="Canada">Canada</option>
        <option value="Canada">South Africa</option>
    </select>
</div>
<div class="form-group col-sm-6">
    {!! Form::label('company_address', 'Company Address:') !!}
    {!! Form::text('company_address', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('annual_revenue', 'Annual Revenue:') !!}
    {!! Form::text('annual_revenue', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('keywords', 'Keywords:') !!}
    {!! Form::text('keywords', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6" >
    {!! Form::label('status', 'Status:') !!}
    <select class="form-control" name="status" style="width: 100%">
        <option value="">Select</option>
        @foreach (LeadsModel::getAllStatus() as $val)
            <option value="{{$val}}">{{ucfirst($val)}}</option>
        @endforeach
    </select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('leads.index') }}" class="btn btn-secondary">Cancel</a>
</div>
