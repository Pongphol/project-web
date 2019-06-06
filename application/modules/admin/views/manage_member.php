<div class="container mt-5" style="width: 80%;">
    <div class="card border-secondary mb-12" >
        <div class="card-header"><h4>จัดการสมาชิก</h4></div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="member_table" class="table table-bordered">
                    <thead>
                        <th>ไอดีผู้ใช้</th>
                        <th>ชื่อผู้ใช้</th>
                        <th>จัดการ</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="status_member_modal" tabindex="-1" role="dialog" aria-labelledy="myModalLable" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">สถานะผู้ใช้</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <form method="POST">
                        <input type="hidden" id="member_id">
                        <select class="form-control" id="status_member_field"></select> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="updateStatusMember()" class="btn btn-primary">ยืนยัน</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function() {
    var dataTable = $('#member_table').DataTable({
        "processing" : true, 
        "serverSide" : true, 
        "order" : [],
        "ajax" : {
            url : "<?php echo base_url('admin/get_all_member'); ?>", 
            type : "POST"
        },
        "columnDefs" : [
            { "width": "15%", "targets": 0 },
            { "width": "40%", "targets": 1 },
            { "orderable" : false, "target" : [0, 2] }
        ]
    });
});

function getStatusMember(id)
{
    $.ajax({
        url : "<?php echo base_url('account/get_status_member'); ?>",
        data : { id : id },
        type : "GET",
        contentType : "application/json;charset=UTF-8",
        dataType : "JSON",
        success : function (response) {

            $('#member_id').val(response.result.id);
            $('#status_member_field').empty();

            $.each(response.status_member, function(key, value) {
                $('#status_member_field').append($("<option></option>")
                    .attr("value",key)
                    .text(value));
                if (response.result.status.toLowerCase() == key.toLowerCase())
                {
                    $('#status_member_field').val(key).prop('selected', true);
                }
            });

        }
    })
}

function updateStatusMember()
{
    var data = {
        id : $('#member_id').val(),
        status : $('#status_member_field').val()
    };

    $.ajax({
        url : "<?php echo base_url('account/update_status_member'); ?>",
        type: 'POST',
        data : { id : data.id, status : data.status },
        dataType : "JSON",
        success : function (response) {

            if (response.success === true)
            {
                toastr.success(response.message, null, { timeOut: 2000 });
                $('#status_member_modal').modal('toggle');
            }
            else
            {
                $('#status_member_modal').modal('toggle');
            }
            
        }
    });
}

$("#member_table").on("click", "#btn_show_status_member", function(){
    $('#status_member_modal').modal('show');
});

</script>