<div class="container-fluid mt-5">
    <div class="mx-auto" style="width: 60%;">
        <form action="<?php echo base_url('member/register'); ?>" method="POST">
            <div class="card">
                <div class="card-header"><h5 class="font-weight-bold">สมัครสมาชิก</h5></div>
                <div class="card-body">
                    <div class="form-group">
                        <label>ชื่อเข้าใช้งาน</label>
                        <input type="text" class="form-control" name="username" value="<?php echo set_value('username'); ?>">
                        <small class="form-text text-muted">We'll never share your profile with anyone else.</small>
                        <?php echo form_error('username'); ?>
                    </div>
                    <div class="form-group">
                        <label>รหัสผ่าน</label>
                        <input type="text" class="form-control" name="password" value="<?php echo set_value('password'); ?>">
                        <small class="form-text text-muted">We'll never share your profile with anyone else.</small>
                        <?php echo form_error('password'); ?>
                    </div>
                    <div class="form-group">
                        <label>ยืนยันรหัสผ่าน</label>
                        <input type="text" class="form-control" name="con_password" value="<?php echo set_value('con_password'); ?>">
                        <small class="form-text text-muted">We'll never share your profile with anyone else.</small>
                        <?php echo form_error('con_password'); ?>
                    </div>
                    <div class="form-group">
                        <label>ชื่อ-นามสกุล</label>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" name="fname" value="<?php echo set_value('fname'); ?>">
                                <?php echo form_error('fname'); ?>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="lname" value="<?php echo set_value('lname'); ?>">
                                <?php echo form_error('lname'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>วันเกิด</label>
                        <input type="date" class="form-control" name="birthday" value="<?php echo set_value('birthday'); ?>">
                        <small class="form-text text-muted">We'll never share your profile with anyone else.</small>
                        <?php echo form_error('birthday'); ?>
                    </div>
                    <div class="form-group">
                    <label>เพศ</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="male" <?php echo set_radio('gender', 'male'); ?> >
                                <label class="form-check-label" for="inlineRadio1">ชาย</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female" <?php echo set_radio('gender', 'female'); ?> >
                                <label class="form-check-label" for="inlineRadio2">หญิง</label>
                            </div>
                        </div>
                        <?php echo form_error('gender'); ?>
                    </div>
                    <div class="form-group">
                        <label>เบอร์โทรศัพท์</label>
                        <input type="text" class="form-control" name="phone" maxlength="10" value="<?php echo set_value('phone'); ?>">
                        <small class="form-text text-muted">We'll never share your profile with anyone else.</small>
                        <?php echo form_error('phone'); ?>
                    </div>
                    <div class="form-group">
                        <label>อีเมล</label>
                        <input type="email" class="form-control" name="email" value="<?php echo set_value('email'); ?>">
                        <small class="form-text text-muted">We'll never share your profile with anyone else.</small>
                        <?php echo form_error('email'); ?>
                    </div>
                    <div class="form-group">
                        <label>ธนาคาร</label>
                        <select id="demoBasic" name="bank_type" class="form-control">
                            <option selected>--- เลือกธนาคาร ---</option>
                            <?php foreach($banking_list as $bank): ?>
                            <?php echo "<option style='background-image:url(". base_url($bank->picture) .")' value='{$bank->id}'>{$bank->name}</option>" ?>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-muted">We'll never share your profile with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label>หมายเลขบัญชี</label>
                        <input type="text" class="form-control" name="bank_number">
                        <small class="form-text text-muted">We'll never share your profile with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="สมัครสมาชิก">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
$(function(){
    $.notify("Hello World");
});
</script>