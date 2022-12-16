@push('styles')
<style type="text/css">
    .copy-button {
        padding: 4px 4px 4px 4px;
        display: inline-block;
        border: 1px solid #20a8d8;
        border-radius: 4px;
        outline: 0;
        cursor: pointer
    }
    .popup{
        position: fixed;
    }
</style>
@endpush
<div class="table-responsive-sm">
    {{$dt_html->table(['class'=>"table table-striped","width"=>"100%"],true)}}
</div>
<!-- Mail Template Modal -->
<div class="modal fade bd-example-modal-lg popup" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Mail</h4>
          <button type="button" class="close" onclick="closeMailBoxPopup()" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-success" role="alert" id="copied_alert" style="display:none">
                Data Copied Successfully
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">To: </label>
                <a class="copy-text" data-clipboard-target="#emails">
                    <i class="fa fa-clipboard">
                    </i>
                </a>
                <input type="text" class="form-control" id="emails" readonly="readonly">
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Subject: </label>
                <a class="copy-text" data-clipboard-target="#subject">
                    <i class="fa fa-clipboard">
                    </i>
                </a>
                <input type="text" class="form-control" id="subject" readonly="readonly">
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Body: </label>
                    <a class="copy copyi-button" id="copiq_btn" >
                            <i class="fa fa-clipboard"></i>
                    </a>
                    <div class="my-editor" id="trumbowyg-demo"></div>
                </label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="send_mail_btn" onclick="sendMail()">Send Mail</button>
          <button type="button" class="btn btn-default" onclick="closeMailBoxPopup()">Close</button>
        </div>
      </div>

    </div>
</div>
<!-- Change Bulk Update Status Modal -->
<div class="modal fade bd-example-modal-lg popup" id="bulkstatusModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Change Status</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Select Status: </label>
                <select class="form-control" name="bulk_status_select" id="bulk_status_select">
                    @foreach (LeadsModel::getAllStatus() as $val)
                        <option value="{{$val}}">{{ucfirst($val)}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Select Reach Type: </label>
                <select class="form-control" name="status" id="bulk_reach_type_select">
                    @foreach (LeadsModel::getAllReachTypes() as $val)
                        <option value="{{$val}}">{{ucfirst($val)}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="notes" class="col-form-label">Notes: </label>
                <textarea class="form-control" name="bulk_notes" id="bulk_notes"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="bulkupdateStatus()">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>
<!-- Change Status Modal -->
<div class="modal fade bd-example-modal-lg popup" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Change Status</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Select Status: </label>
                <input type="hidden" value="{{json_encode(LeadsModel::getAllStatus())}}" id="status_hidden_input">
                <input type="hidden" name="selected_lead" id="selected_lead">
                <select class="form-control" name="status_select" id="status_select">
                    @foreach (LeadsModel::getAllStatus() as $val)
                        <option value="{{$val}}">{{ucfirst($val)}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Select Reach Type: </label>
                <select class="form-control" name="status" id="reach_type_select">
                    @foreach (LeadsModel::getAllReachTypes() as $val)
                        <option value="{{$val}}">{{ucfirst($val)}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="notes" class="col-form-label">Notes: </label>
                <textarea class="form-control" name="notes" id="notes"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="updateStatus()">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>
<!-- Filter Modal -->
<div class="modal fade bd-example-modal-lg popup" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Filter</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Select Status: </label>
                <select class="form-control" name="filter_status" id="filter_status_select">
                    <option value="" selected>All</option>
                    @foreach (LeadsModel::getAllStatus() as $val)
                        <option value="{{$val}}">{{ucfirst($val)}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="filterStatus()">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>
<!-- Scheduled Modal -->
<div class="modal fade bd-example-modal-lg popup" id="scheduleEmailModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Schedule Email</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Select Date: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                    </div>
                    <input type="text" id="schedule_date" class="form-control datetimepicker" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="saveSchedule()">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>

@push('scripts')
{!! $dt_html->scripts() !!}
@endpush

@push('scripts')
<script type="text/javascript">
$('#myModal').on('hidden.bs.modal', function () {
    closeMailBoxPopup();
});
$("#select_all_leads").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);

    if($('input[type=checkbox]:checked').length > 0){
        $("#bulk_select_section").show();
    } else {
        $("#bulk_select_section").hide();
    }
});

$(function(){
    new Clipboard('.copy-text');
});

$('#trumbowyg-demo').trumbowyg();

$('#copiq_btn').copiq({
    parent: '.form-group',
    content: '.my-editor',
    onSuccess: function($element, source, selection) {
        $("#copied_alert").show();
        setTimeout(function() {
                $("#copied_alert").hide();
        }, 2000);
    }
});

$('.copy-text').click(function(){
    $("#copied_alert").show();
    setTimeout(function() {
        $("#copied_alert").hide();
    }, 2000);
});

function openBulkStatusPopup(){
    $("#bulkstatusModal").modal('toggle');
    $("#bulkstatusModal").modal('show');
}

function bulkupdateStatus()
{
    var ids = [];
    var status = $("#bulk_status_select").val();
    var reachType = $("#bulk_reach_type_select").val();
    var notes = $("#bulk_notes").val();

    $.each($("input[class='lead-checkboxes']:checked"), function(){
        var data = $(this).attr('id').split("-");
        ids.push(data[1]);
    });

    $.ajax({
        url: "bulk-update-status",
        dataType: 'json',
        data:{
            'ids': ids,
            'status': status,
            'reach': reachType,
            'note': notes
        },
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        success: function (res) {
            if(res.status){
                successMessage(res.message);
            } else {
                errorMessage(res.message);
            }

            $("#bulkstatusModal").modal('hide');
            $('.table-striped').DataTable().ajax.reload();
            $("#bulk_select_section").hide();
        }
    });
}

function checkboxselect()
{
    if($('input[type=checkbox]:checked').length > 0){
        $("#bulk_select_section").show();
    } else {
        $("#bulk_select_section").hide();
    }
}

function deleterow(id)
{
    if(confirm('Are you sure? Do you want to delete this entry?')){
        $.ajax({
            url: "/leads/"+id,
            dataType: 'json',
            data:{
                '_method': 'DELETE',
                'id': id
            },
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE",
            success: function (res) {
                location.reload();
            }
        });
    }
}

function openMailBoxPopup(obj)
{
    const id = $(obj).data('id');
    const category_id = $(obj).data('category-id');
    const status = $(obj).data('status');

    $("#subject").val("");
    $("#emails").val("");
    $('#trumbowyg-demo').empty();

    $.ajax({
        url: "/lead-detail/"+id,
        data:{
            'category_id':category_id,
            'email_type':status
        },
        dataType: 'json',
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        success: function (res) {
            var data = res.data.lead_data;
            var mail_data = res.data.email_template;

            if(!jQuery.isEmptyObject(res)){
                var all_keywords = [];
                var body = mail_data.body;
                var subject = mail_data.subject;
                var keywords = mail_data.keywords;
                all_keywords = keywords.split(", ");
                for(var i=0;i<all_keywords.length;i++)
                {
                    body = body.replaceAll(all_keywords[i],data[all_keywords[i]]);

                    if(all_keywords[i].search('website') > 0){
                        body = body.replaceAll("http://www.website.com/","http://"+data[all_keywords[i]]);
                    }

                    subject = subject.replaceAll(all_keywords[i],data[all_keywords[i]]);
                }

                body = body.replace(/[{}]/g, "");
                subject = subject.replace(/[{}]/g, "");

                var emails = [];
                if(data.company_email != null){
                    emails.push(data.company_email);
                }

                for(var i=0;i< data.lead_contacts.length;i++){
                    emails.push(data.lead_contacts[i].email);
                }

                var emailsList = emails.filter((item,
                index) => emails.indexOf(item) === index);

                if(emailsList.length == 0){
                    $("#emails").val("No emails found!");
                    $("#send_mail_btn").attr('disabled',true);
                } else {
                    $("#emails").val(emailsList.toString());
                    $('#trumbowyg-demo').trumbowyg('html',body);
                    $("#subject").val(subject);
                    $("#send_mail_btn").prop('disabled',false);
                }

            } else {
                $("#send_mail_btn").attr('disabled',true);
            }
        }
    });

    $('#myModal').modal('toggle');
    $('#myModal').modal('show');
    $("#myModal").css("display", "block");
	$('body').css('overflow', 'hidden');

}

function closeMailBoxPopup()
{
    $('#myModal').modal('hide');
    $("#myModal").css("display", "none");
    $('body').css('overflow', 'scroll');
}

function changeStatus(data)
{
    const status = data.status;
    const id = data.id;
    const reach_status = data.reach_type;
    var all_status = JSON.parse($("#status_hidden_input").val());

    var to_position = all_status.indexOf(status);

    $("#statusModal").modal('toggle');
    $("#statusModal").modal('show');

    $("#status_select").val(status);

    $("#selected_lead").val(id);
    $('#status_select option[value='+status+']').attr('selected','selected');

    $("#reach_type_select").val(reach_status);
}

function updateStatus()
{
    if($("#status_select").val() != null){
        const selected_lead = $("#selected_lead").val();
        const selected_status = $("#status_select").val();
        const reach_type_select = $("#reach_type_select").val();
        const notes = $("#notes").val();

        $.ajax({
            url: "/leads-change-status",
            dataType: 'json',
            data:{
                'selected_status': selected_status,
                'selected_lead': selected_lead,
                'reach_type_select': reach_type_select,
                'notes': notes
            },
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            success: function (res) {
                if(res.status){
                    successMessage(res.message);
                } else {
                    errorMessage(res.message);
                }

                $("#statusModal").modal('hide');
                $('.table-striped').DataTable().ajax.reload();
            }
        });
    } else {
        alert('Please update status!');
    }
}

function filterPopup()
{
    $("#filterModal").modal('toggle');
    $("#filterModal").modal('show');
}

function filterStatus()
{
    $("#filterModal").modal('hide');
    $('.table-striped').DataTable().ajax.reload()
}

function sendMail()
{
    var emails = $("#emails").val();
    var subject = $("#subject").val();
    var body = $("#trumbowyg-demo").html();

    $.ajax({
        url: "/send-mail",
        dataType: 'json',
        data:{
            'emails': emails,
            'subject': subject,
            'body': body
        },
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        success: function (res) {
            if(res.status){
                successMessage(res.message);
            } else {
                errorMessage(res.message);
            }

            closeMailBoxPopup();
        }
    });
}

function exportLeads(){
    window.open("{{route('leads.export-leads')}}");
    return;
}

function scheduleEmail()
{
    $("#scheduleEmailModal").modal('toggle');
    $("#scheduleEmailModal").modal('show');
}

function closeScheduleEmailPopup()
{
    $("#scheduleEmailModal").modal('hide');
    $('.table-striped').DataTable().ajax.reload();
}

function saveSchedule()
{
    if($("#schedule_date").val() != ""){

        var ids = [];
        $.each($("input[class='lead-checkboxes']:checked"), function(){
            var data = $(this).attr('id').split("-");
            ids.push(data[1]);
        });

        $.ajax({
            url: "/save-schedule",
            dataType: 'json',
            data:{
                'date': $("#schedule_date").val(),
                'companies': ids
            },
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            success: function (res) {
                if(res.status){
                    successMessage(res.message);
                } else {
                    errorMessage(res.message);
                }

                closeScheduleEmailPopup();
            }
        });
    } else {
        alert('Please select schedule time!');
    }
}
</script>
@endpush
