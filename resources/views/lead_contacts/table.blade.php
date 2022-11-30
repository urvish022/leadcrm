<div class="table-responsive-sm">
    {{$dt_html->table(['class'=>"table table-striped","width"=>"100%"],true)}}
</div>

@push('scripts')
{!! $dt_html->scripts() !!}
<script>
    function updateStatus(id,status)
    {
        var message = status == 'active' ? 'Are you sure? Do you want to inactive this contact?' : 'Are you sure? Do you want to active this contact?';
        if(confirm(message)){
            $.ajax({
                url: "lead-contacts/update-status/"+id,
                dataType: 'json',
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                success: function (res) {
                    $('.table-striped').DataTable().ajax.reload();
                }
            });
        }
    }
</script>
@endpush

