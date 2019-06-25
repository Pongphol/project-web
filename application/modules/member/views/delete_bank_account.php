<div class="container-fluid mt-5" style="width: 60%;">
    <div class="mx-auto">
        <div class="card border-info mb-3">
            <div class="card-header">ลบบัญชีธนาคาร</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="<?php echo base_url('delete_bank_account'); ?>" method="POST">
                            <table class="table table-hover table-bordered profile">
                                <tbody>
                                    <tr>
                                        <th scope="row" class="text-center">ธนาคาร</th>
                                        <td>
                                            <select id="bank_type" name="bank_type" class="form-control">
                                                <option value="">-- เลือกธนาคาร --</option>
                                                <?php foreach($banking_list as $bank): ?>
                                                <?php echo "<option style='background-image:url(". base_url($bank->picture) .")'" . set_select('bank_type', "{$bank->id}") . " value='{$bank->id}'>{$bank->name} ({$bank->number})</option>" ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('bank_type'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td>
                                            <input type="submit" id="btn_delete_bank_account" class="btn btn-danger" value="ลบ">
                                            <a href="<?php echo base_url('profile'); ?>" class="btn btn-warning">ย้อนกลับ</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

$('#btn_delete_bank_account').on('click',function(e){

    e.preventDefault();
    var form = $(this).parents('form');

    Swal.fire({
      title: "ลบบัญชีธนาคาร?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "ยืนยัน",
      cancelButtonText: "ยกเลิก"
    }).then((result) =>  {
        if (result.value)
        {
            form.submit();
        }
    });

});

</script>