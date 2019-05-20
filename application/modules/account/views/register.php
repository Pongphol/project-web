<div class="container-fluid mt-5">
    <div class="mx-auto" style="width: 60%;">
        <form id="form-user" action="<?php echo base_url('account/add'); ?>" method="POST">
            <div class="card">
                <div class="card-header"><h5 class="font-weight-bold">สมัครสมาชิก</h5></div>
                <div class="card-body">
                    <div id="the-message"></div>
                    <div class="form-group">
                        <label>ชื่อเข้าใช้งาน</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label>รหัสผ่าน</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label>ยืนยันรหัสผ่าน</label>
                        <input type="password" class="form-control" id="con_password" name="con_password">
                    </div>
                    <div class="form-group">
                        <label>ชื่อ-นามสกุล</label>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" id="fname" name="fname">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" id="lname" name="lname">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>วันเกิด</label>
                        <input type="date" class="form-control" id="birthday" name="birthday">
                    </div>
                    <div class="form-group">
                        <label for="gender">เพศ</label>
                        <select class="form-control" id="gender" name="gender">
                            <option value=""> ------</option>
                            <option value="male">ชาย</option>
                            <option value="female">หญิง</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>เบอร์โทรศัพท์</label>
                        <input type="text" class="form-control" id="phone" name="phone" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label>อีเมล</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label>ธนาคาร</label>
                        <select id="bank_type" name="bank_type" class="form-control">
                            <option value="">-- เลือกธนาคาร --</option>
                            <?php foreach($banking_list as $bank): ?>
                            <?php echo "<option style='background-image:url(". base_url($bank->picture) .")' value='{$bank->id}'>{$bank->name}</option>" ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>หมายเลขบัญชี</label>
                        <input type="text" class="form-control" id="bank_number" name="bank_number">
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

function countdown(){
    var n=$('.cd').attr('id');
    var c=n;
    $('.cd').text(c);
    setInterval(function(){
        c--;
        if(c>=0){
            $('.cd').text(c);
        }
    },1000);
}

$('#form-user').submit(function(e) {
    e.preventDefault();
    
    var me = $(this);

    $.ajax({
        type : 'POST',
        url : "<?php echo base_url('account/add'); ?>",
        data : me.serialize(),
        dataType : 'JSON',
        success : function(response) {
            if (response.success == true)
            {
                $('#the-message').append(
                    '<div class="alert alert-success">' +  
                    '<h4 class="alert-heading">สมัครสมาชิกสำเร็จ !</h4>' + 
                    '<p>ระบบกำลังพาท่านไปหน้าเข้าสู่ระบบภายใน <span class="cd" id="5"></span> วินาที</p>' + 
                    '</div>'
                );
                $('.form-group').removeClass('has-error').removeClass('has-success');
                $('text-danger').remove();
                me[0].reset();
                countdown();
                $('.alert-success').delay(0).show(10, function() {
                    $(this).delay(5000).hide(10, function() {
                        $(this).remove();
                        window.location.href = "<?php echo base_url('account/login'); ?>";
                    });
                });
            }
            else
            {
                $.each(response.messages, function(key, value) {
                    var element = $('#' + key);

                    element.closest('div.form-group')
                        .removeClass('has-error')
                        .addClass(value.length > 0 ? 'has-error' : 'has-success')
                        .find(key == 'lname' ? false : '.text-danger').remove();
                    element.after(value);
                });
            }
        }
    });
});
</script>