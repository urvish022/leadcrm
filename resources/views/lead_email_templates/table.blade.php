<div class="table-responsive-sm">
    <table class="table table-striped" id="lead-category-table">
        <thead>
            <tr>
                <th>Lead Category</th>
                <th>Title</th>
                <th>Subject</th>
                <th>Keywords</th>
                <th>Type</th>
                <th>Active</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leadEmails as $val)
                <tr>
                    <td><a href="{{route('lead-category.show',$val->category_id)}}">{{$val->lead_category->category_name}}</a></td>
                    <td>{{$val->title}}</td>
                    <td>{{$val->subject}}</td>
                    <td>{{$val->keywords}}</td>
                    <td>{{$val->email_type}}</td>
                    <td>
                        @if($val->default_status == 1)
                        <button type="button" disabled class="btn btn-success">Active</button>
                        @else
                        <a href="#" onclick="updateEmailStatus({{$val->id}})" class="btn btn-info">Inactive</a>
                        @endif
                    </td>
                    <td>
                        {!! Form::open(['route' => ['lead-email-templates.destroy', $val->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                        <a href="{{ route('lead-email-templates.edit', [$val->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>    
            @endforeach
        </tbody>
    </table>
</div>

@push('scripts')
<script type="text/javascript">
    function updateEmailStatus(id)
    {
        if(confirm('Are you sure? Do you want to active this template?')){
        $.ajax({
            url: "lead-email-templates/active/"+id,
            dataType: 'json',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            success: function (res) {
                
                location.reload()
            }
        });
    }
    }
</script>
@endpush