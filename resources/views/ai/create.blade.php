@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
         <a href="{!! route('ai.index') !!}">AI Notes</a>
      </li>
      <li class="breadcrumb-item active">Create</li>
    </ol>
     <div class="container-fluid">
          <div class="animated fadeIn">
                @include('coreui-templates::common.errors')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-search fa-lg"></i>
                                <strong>Search</strong>
                            </div>
                            <div class="card-body">
                                <div class="form-group col-sm-6">
                                    {!! Form::label('search', 'OpenAI Search:') !!}
                                    <div class="input-group">
                                        {!! Form::text('search', null, ['class' => 'form-control ','id'=>'search']) !!}
                                        <div class="input-group-append">
                                            <button type="button" id="search-button" onclick="openAISearch()" class="btn btn-primary"><i class="fa fa-fw fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Submit Field -->
                                <div class="form-group col-sm-6">
                                    {!! Form::label('result', 'Result:') !!}
                                    {!! Form::textarea('result', null, ['class' => 'form-control','id'=>'result','rows'=>20]) !!}
                                </div>

                                <div class="form-group col-sm-12">
                                    <button type="button" class="btn btn-primary" disabled id="add-content-button" onclick="addContent()"><i class="fa fa-plus fa-lg"></i>&nbsp;Add Content</button>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-plus-square-o fa-lg"></i>
                                <strong>Create Notes</strong>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => 'ai.store']) !!}
                                    @include('ai.fields')
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
function openAISearch()
{
    var keyword = $("#search").val();
    if(keyword != ""){
        $("#search-button").attr('disabled',true);
        $("#result").focus();
        $("#result").html("Fetching from OpenAI...");
        $.ajax({
            url: "search-openai-content",
            dataType: 'json',
            data:{
                'search': keyword
            },
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            success: function (res) {
                $("#result").html("");
                $("#search-button").attr('disabled',false);
                $("#add-content-button").attr('disabled',false);
                if(res.status){
                    $("#result").html(res.data);
                }
            }
        });
    } else {

    }
}

function addContent()
{
    var result = $("#result").val();
    var content = tinyMCE.activeEditor.getContent();

    // tinyMCE.activeEditor.setContent()
    result = result.replace(new RegExp('\r?\n','g'), '<br />');

    tinyMCE.activeEditor.setContent(content + result);
    // $("#myeditorinstance").val(result);
}
</script>
@endpush
