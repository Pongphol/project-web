<div class="container mt-5" >
    <div class="card border-secondary mb-12" >
        <div class="card-header"><h4>ตารางกำหนดราคาหวย</h4></div>
        <div class="card-body">
            <table id="criteria" class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>เลข</th>
                        <th>ส่วนลด</th>
                        <th>จ่าย</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $tr_id = 1;
                        foreach($criteria as $crit) 
                        {
                            echo "
                                <tr id='" . $tr_id++ . "'>
                                    <td>{$crit->name}</td>
                                    <td><input type='number' class='form-control' name='discount' disabled='disabled' value='{$crit->discount}'></td>
                                    <td><input type='number' class='form-control' name='pay' disabled='disabled' value='{$crit->pay}'></td>
                                    <td><button type='button' class='btn btn-warning change_lotto' value='" . $crit->id . "'>แก้ไข</button></td>
                                </tr>
                            ";
                        }
                        
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>

$('button.change_lotto[type=button]').click(function() {
    var tr_id = $(this).closest('tr').attr('id');
    $(this).closest('tr#' + tr_id).find("input[type=number]").removeAttr('disabled');

    var $this = $(this).toggleClass('change_lotto')
    ;
    if($(this).hasClass('change_lotto'))
    {
        // บันทึก
        $(this).closest('tr#' + tr_id)
            .find("input[type=number]")
            .attr("disabled", true);
        $(this).removeClass('btn-info')
            .addClass('btn-warning')
            .text('แก้ไข');
    }
    else
    {
        // แก้ไข
        if (this.hasAttribute('onclick'))
        {
            //$(this).prop('onclick', null);
            $(this).removeAttr('onclick');
        }
        $(this).removeClass('btn-warning').attr('onclick', 'change_price_lotto(this)').addClass('btn-info').text('บันทึก');
    }
});

function change_price_lotto(obj)
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
        url: "<?php echo base_url('admin/update_criteria'); ?>",
        dataType : 'JSON',
        data :{
            update_data : update_data
        },
        success: function(response){
            if(response.success == true){
                $.notify('อัพเดทสำเร็จ', {
                    className: 'success'
                });
            }
        }
    });
}


</script>