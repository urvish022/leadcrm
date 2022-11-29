<!-- Created At Field -->

<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $leadContacts->first_name. " ".$leadContacts->last_name }}</p>
</div>

<div class="form-group">
    {!! Form::label('linkedin_profile', 'Linkedin Profile:') !!}
    <p><a href="{{ $leadContacts->linkedin_profile }}" target="_blank">{{ $leadContacts->linkedin_profile }}</a></p>
</div>

<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p><a href="mailto:{{ $leadContacts->email }}">{{ $leadContacts->email }}</a></p>
</div>

<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $leadContacts->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $leadContacts->updated_at }}</p>
</div>

