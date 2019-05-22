<div class="container-fluid mt-5" style="width: 60%;">
    <div class="mx-auto">
        <div class="card border-info mb-3">
            <div class="card-header">แก้ไขข้อมูล</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="<?php echo base_url('change_password'); ?>" method="POST">
                            <table class="table table-hover table-bordered profile">
                                <tbody>
                                    <tr>
                                        <th scope="row" class="text-center">รหัสผ่าน</th>
                                        <td>
                                            <input type="password" class="form-control" name="password" required value="<?php echo (!isset($_POST['password'])) ? $account->password : set_value('password'); ?>">
                                            <?php echo form_error('password'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="text-center">ยืนยันรหัสผ่าน</th>
                                        <td>
                                            <input type="password" class="form-control" name="con_password" required value="<?php echo (!isset($_POST['con_password'])) ? $account->password : set_value('con_password'); ?>">
                                            <?php echo form_error('con_password'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td>
                                            <input type="submit" class="btn btn-info" value="บันทึก">
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