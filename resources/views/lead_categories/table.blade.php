<div class="table-responsive-sm">
    <table class="table table-striped" id="lead-category-table">
        <thead>
            <tr>
                <th>Niche Category</th>
                <th>Total</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($leadCategories as $leadCategory)
            <tr>
            <td>{{ $leadCategory->category_name }}</td>
            <td>{{ $leadCategory->leads_count }}</td>
                <td>
                    {!! Form::open(['route' => ['lead-category.destroy', $leadCategory->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('lead-category.show', [$leadCategory->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('lead-category.edit', [$leadCategory->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
