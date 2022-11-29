<div class="table-responsive-sm">
    {{$dt_html->table(['class'=>"table table-striped","width"=>"100%"],true)}}
</div>

@push('scripts')
{!! $dt_html->scripts() !!}
@endpush