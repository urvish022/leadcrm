@if(is_null($leadContacts))
<div class="form-group col-sm-6">
    {!! Form::label('categories', 'Categories:') !!}
    <select class="form-control" name="category_id" onchange="categoryChange(this.value)" style="width: 100%">
        <option value="">Select</option>
        @foreach ($categories as $val)
            <option value="{{$val->id}}">{{$val->category_name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group col-sm-6">
    {!! Form::label('prospect', 'Prospect:') !!}
    <select class="form-control" name="lead_id" id="lead_id" style="width: 100%">
        <option value="">Select</option>
    </select>
</div>
@endif
<div class="form-group col-sm-6">
    {!! Form::label('first_name', 'First Name:') !!}
    {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('last_name', 'Last Name:') !!}
    {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('linkedin_profile', 'Linkedin Profile:') !!}
    {!! Form::text('linkedin_profile', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('lead-contacts.index') }}" class="btn btn-secondary">Cancel</a>
</div>
@push('scripts')
<script type="text/javascript">
    function categoryChange(id)
    {
        $.ajax({
            url: "niche-lead-contacts/"+id,
            dataType: 'json',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            success: function (res) {
                if(res.status){
                    var prospects = res.data;
                    $('#lead_id').empty();
                    $.each(prospects, function(key, value) {

                        $('#lead_id').append($("<option></option>")
                                        .attr("value", value.id)
                                        .text(value.company_name));
                    });
                }
            }
        });
    }
</script>
@endpush
