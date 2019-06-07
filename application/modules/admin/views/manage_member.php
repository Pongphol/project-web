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
                <h5 class="modal-title" id="status_member_title">สถานะผู้ใช้</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" id="member_id">
                    <select class="form-control" id="status_member_field"></select> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="updateStatusMember()" class="btn btn-primary">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="change_criteria_member" tabindex="-1" role="dialog" aria-labelledy="myModalLable" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="criteria_title">เปลี่ยนเกณฑ์ตารางหวย</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="criteria_member" class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>เลข</th>
                                <th>ส่วนลด</th>
                                <th>จ่าย</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_edit_criteria" class="btn btn-warning" value="edit">แก้ไข</button>
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

function getCriteriaMember(id)
{
    $.ajax({
        url : "<?php echo base_url('account/get_criteria_member'); ?>",
        data : { id : id },
        type : "GET",
        contentType : "application/json;charset=UTF-8",
        dataType : "JSON",
        success : function (response) {

            var tbody = $('#criteria_member > tbody');
            tbody.empty();

            $('#change_criteria_member').find('h5#criteria_title').text('เปลี่ยนเกณฑ์ตารางหวย (' + response.user_name + ')');

            $.each(response.criteria, function (key, crit) {
                tbody.append(
                    "<tr id='" + response.user_id + "'>" + 
                    "<input type='hidden' name='criteria_id' value='" + crit['id'] + "'>" +
                    "<td class='criteria_name'>" + crit['name'] + "</td>" +
                    "<td><input type='number' class='form-control' name='discount' disabled='disabled' value='" + crit['discount'] + "'></td>" + 
                    "<td><input type='number' class='form-control' name='pay' disabled='disabled' value='" + crit['pay'] + "'></td>" + 
                    "</tr>"
                );
            });

        }
    })
}

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

            $('#status_member_modal').find('h5#status_member_title').text('สถานะผู้ใช้ (' + response.user_name + ')');

            $.each(response.status_member, function (key, value) {
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

$("#member_table").on("click", "#btn_show_change_criteria_user", function(){
    $('#criteria_member').find("input[type=number]")
            .attr("disabled", true);

    $('button#btn_edit_criteria').val('edit')
            .text('แก้ไข')
            .removeClass('btn-info')
            .addClass('btn-warning');
    
    $('#criteria_member > tbody').empty();

    $('#change_criteria_member').modal('show');
});

$('#btn_edit_criteria').on("click", function () {
    
    var tbody = $('#criteria_member > tbody');
    var btn_criteria = $('button#btn_edit_criteria');

    if (btn_criteria.val() === 'edit')
    {
        $('#criteria_member').find("input[type=number]")
            .removeAttr('disabled');
        
        btn_criteria.val('save')
            .text('อัพเดท')
            .removeClass('btn-warning')
            .addClass('btn-info');

        if (this.hasAttribute('onclick'))
        {
            btn_criteria.removeAttr('onclick');
        }

        btn_criteria.attr('onclick', 'updateCriteriaUser()');
    }
    else
    {
        $('#criteria_member').find("input[type=number]")
            .attr("disabled", true);
        
        btn_criteria.val('edit')
            .text('แก้ไข')
            .removeClass('btn-info')
            .addClass('btn-warning');
    }
     
});

function updateCriteriaUser()
{
    var ary = [];

    $('#criteria_member tr').each(function (a, b) {
        
        var criteria_id = $('input[name=criteria_id]', b).val();
        var name = $('td.criteria_name', b).text();
        var discount = $('input[name=discount]', b).val();
        var pay = $('input[name=pay]', b).val();

        if (discount === undefined || pay === undefined)
        {
            return;
        }

        ary.push(
            {
                id : criteria_id, 
                name : name, 
                discount : discount,
                pay : pay
            }
        );
    
    });

    var trid = $('#criteria_member > tbody').find('tr').attr('id');
    update_data = JSON.stringify(ary);
    
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('account/update_criteria_member'); ?>",
        dataType : 'JSON',
        data :{
            id : trid, 
            update_data : update_data
        },
        success: function(response){
            if(response.success == true)
            {
                $.notify(response.message, {
                    className: 'success'
                });
            }
        }
    });
}

function updateCriteriaUserdd(obj)
{
    var tr_id = $(obj).closest('tr').attr('id');
    var update_data = [];

    update_data.push(
        $("tr#" + tr_id + " button.change_lotto").val(),
        $("tr#" + tr_id + " input[name=discount]").val(),
        $("tr#" + tr_id + " input[name=pay]").val()
    );

    $.ajax({
        type: "POST",
        url: "<?php echo base_url('account/update_criteria_member'); ?>",
        dataType : 'JSON',
        data :{
            update_data : update_data
        },
        success: function(response){
            if(response.success == true)
            {
                $.notify('อัพเดทสำเร็จ', {
                    className: 'success'
                });
            }
        }
    });
}

</script>