
<div class="form-group col-sm-6">
    {!! Form::label('followup_interval_days', 'Followup Interval Days:') !!}
    {!! Form::text('followup_interval_days', $setting->followup_interval_days, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('mail_type', 'Mail Type:') !!}
    {!! Form::text('mail_type', $setting->mail_type, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('mail_host', 'Mail Host:') !!}
    {!! Form::text('mail_host', $setting->mail_host, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('mail_port', 'Mail Port:') !!}
    {!! Form::text('mail_port', $setting->mail_port, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('mail_username', 'Mail Username:') !!}
    {!! Form::text('mail_username', $setting->mail_username, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('mail_password', 'Mail Password:') !!}
    {!! Form::text('mail_password', $setting->mail_password, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('mail_encryption', 'Mail Encryption:') !!}
    {!! Form::text('mail_encryption', $setting->mail_encryption, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('mail_from_address', 'Mail From Address:') !!}
    {!! Form::text('mail_from_address', $setting->mail_from_address, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('mail_from_name', 'Mail From Name:') !!}
    {!! Form::text('mail_from_name', $setting->mail_from_name, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('bcc_name', 'Bcc Name:') !!}
    {!! Form::text('bcc_name', $setting->bcc_name, ['class' => 'form-control']) !!}
</div>

<x-forms.tinymce-editor fieldName="email_signature" label="Email Signature" :value="$setting->email_signature" />

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>
