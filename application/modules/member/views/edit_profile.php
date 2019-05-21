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
                                            <input type="email" class="form-control" name="email" value="<?php echo $account->email; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="text-center">ชื่อ</th>
                                        <td>
                                            <input type="text" class="form-control" name="fname" value="<?php echo $account->fname; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="text-center">นามสกุล</th>
                                        <td>
                                            <input type="text" class="form-control" name="lname" value="<?php echo $account->lname; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="text-center">เบอร์โทร</th>
                                        <td>
                                            <input type="text" class="form-control" name="phone" value="<?php echo $account->phone; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td><input type="submit" class="btn btn-info" value="บันทึก"></td>
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