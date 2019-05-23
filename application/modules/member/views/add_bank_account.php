<div class="container-fluid mt-5" style="width: 60%;">
    <div class="mx-auto">
        <div class="card border-info mb-3">
            <div class="card-header">เพิ่มบัญชีธนาคาร</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="<?php echo base_url('add_bank_account'); ?>" method="POST">
                            <table class="table table-hover table-bordered profile">
                                <tbody>
                                    <tr>
                                        <th scope="row" class="text-center">ธนาคาร</th>
                                        <td>
                                            <select id="bank_type" name="bank_type" class="form-control">
                                                <option value="">-- เลือกธนาคาร --</option>
                                                <?php foreach($banking_list as $bank): ?>
                                                <?php echo "<option style='background-image:url(". base_url($bank->picture) .")'" . set_select('bank_type', "{$bank->id}") . " value='{$bank->id}'>{$bank->name}</option>" ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('bank_type'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="text-center">หมายเลขบัญชี</th>
                                        <td>
                                            <input type="text" class="form-control" name="bank_number" required value="<?php echo set_value('bank_number'); ?>">
                                            <?php echo form_error('bank_number'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td>
                                            <input type="submit" class="btn btn-info" value="เพิ่ม">
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