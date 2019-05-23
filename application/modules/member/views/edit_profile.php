<div class="container-fluid mt-5" style="width: 60%;">
    <div class="mx-auto">
        <div class="card border-info mb-3">
            <div class="card-header">แก้ไขข้อมูล</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="<?php echo base_url('edit'); ?>" method="POST">
                            <table class="table table-hover table-bordered profile">
                                <tbody>
                                    <tr>
                                        <th scope="row" class="text-center">อีเมล</th>
                                        <td>
                                            <input type="email" class="form-control" name="email" required value="<?php echo (!isset($_POST['email'])) ? $account->email : set_value('email'); ?>">
                                            <?php echo form_error('email'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="text-center">ชื่อ</th>
                                        <td>
                                            <input type="text" class="form-control" name="fname" required value="<?php echo (!isset($_POST['fname'])) ? $account->fname : set_value('fname'); ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="text-center">นามสกุล</th>
                                        <td>
                                            <input type="text" class="form-control" name="lname" required value="<?php echo (!isset($_POST['lname'])) ? $account->lname : set_value('lname'); ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="text-center">เบอร์โทร</th>
                                        <td>
                                            <input type="text" class="form-control" name="phone" required maxlength="10" value="<?php echo (!isset($_POST['phone'])) ? $account->phone : set_value('phone'); ?>">
                                            <?php echo form_error('phone'); ?>
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