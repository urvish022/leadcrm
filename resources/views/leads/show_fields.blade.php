<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('name', 'Lead By:') !!}
    <p>{{ $leads->created_by->name }}</p>
</div>

<div class="form-group">
    {!! Form::label('lead_category', 'Category:') !!}
    <p>{{ $leads->lead_categories->category_name }}</p>
</div>

<div class="form-group">
    {!! Form::label('company_name', 'Company:') !!}
    <p>{{ $leads->company_name }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('company_website', 'Website:') !!}
    <br>
    <a href="http://".{{$leads->company_website}}>{{ $leads->company_website }}</a>
</div>

<div class="form-group">
    {!! Form::label('company_origin', 'Country:') !!}
    <p>{{ $leads->company_origin }}</p>
</div>

<div class="form-group">
    {!! Form::label('reach_type', 'Reach:') !!}
    <p>{{ ucfirst($leads->reach_type) }}</p>
</div>

<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ ucfirst($leads->status) }}</p>
</div>

<div class="form-group">
    {!! Form::label('lead_details', 'Contacts:') !!}
    <table border="1" style="width:100%">
    <thead>
        <th>Name</th>
        <th>Email</th>
        <th>Linkedin Profile</th>
    </thead>
    <tbdoy>
        @foreach($leads->lead_contacts as $val)
        <tr>
            <td>{{$val->first_name}} {{$val->last_name}}</td>
            <td>{{$val->email}}</td>
            <td><a href="{{$val->linkedin_profile}}" target="_blank">{{$val->linkedin_profile}}</a></td>
        </tr>
        @endforeach
    </tbody>
    </table>
</div>

<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ date('d-m-Y H:i',strtotime($leads->created_at)) }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ date('d-m-Y H:i',strtotime($leads->updated_at)) }}</p>
</div>

