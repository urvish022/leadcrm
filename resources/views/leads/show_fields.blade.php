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
    {!! Form::label('reach_type', 'Current Reach Type:') !!}
    <p>{{ ucfirst($leads->reach_type) }}</p>
</div>

<div class="form-group">
    {!! Form::label('status', 'Current Status:') !!}
    <p>{{ ucfirst($leads->status) }}</p>
</div>

<div class="form-group">
    {!! Form::label('lead_details', 'Contacts:') !!}
    <table border="1" style="width:100%;spacing">
    <thead>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Linkedin Profile</th>
        <th>Status</th>
        <th>Action</th>
    </thead>
    <tbdoy>
        @foreach($leads->lead_contacts as $val)
        <tr>
            <td>{{$val->first_name}} {{$val->last_name}}</td>
            <td>{{$val->email}}</td>
            <td>{{$val->phone}}</td>
            <td><a href="{{$val->linkedin_profile}}" target="_blank">{{$val->linkedin_profile}}</a></td>
            <td>
                @if($val->status == 1)
                Active
                @else
                Inactive
                @endif
            </td>
            <td>
                <a href="/lead-contacts/{{$val->id}}" target="_blank"><i class="fa fa-eye"></i></a>
                &nbsp;
                <a href="/lead-contacts/{{$val->id}}/edit" target="_blank"><i class="fa fa-pencil"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>
</div>

<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ date('d-m-Y H:i',strtotime($leads->created_at)) }}</p>
</div>

<!-- Section: Timeline -->
<!-- <section class="py-5"> -->
   @if($leads->lead_activities->count() > 0)
    {!! Form::label('activities', 'Activities:') !!}
    <ul class="timeline-with-icons">
        @foreach ($leads->lead_activities as $activitiy)
            <li class="timeline-item mb-5">
                <span class="timeline-icon">
                    @if($activitiy->reach_type == 'email')
                    <i class="fa fa-envelope fa-sm fa-fw"></i>
                    @elseif($activitiy->reach_type == 'call')
                    <i class="fa fa-phone fa-sm fa-fw"></i>
                    @elseif($activitiy->reach_type == 'facebook')
                    <i class="fa fa-facebook fa-sm fa-fw"></i>
                    @elseif($activitiy->reach_type == 'linkedin')
                    <i class="fa fa-linkedin fa-sm fa-fw"></i>
                    @elseif($activitiy->reach_type == 'other')
                    <i class="fa fa-gear fa-sm fa-fw"></i>
                    @endif
                </span>

                <h5 class="fw-bold">{{ucfirst($activitiy->updated_status)}}</h5>
                <p class="mb-2 fw-bold">Reach Type : {{ucfirst($activitiy->reach_type)}}</p>
                <p class="mb-2 fw-bold">Activity Time : {{$activitiy->created_at}}</p>
                <p class="">
                    Notes : {{$activitiy->notes}}
                </p>
            </li>
        @endforeach
    </ul>
   @else
   No Activity Found
   @endif 
<!-- </section> -->
<!-- Section: Timeline -->

