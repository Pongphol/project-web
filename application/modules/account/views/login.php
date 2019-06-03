<div class="container-fluid mt-5">
    <div class="mx-auto" style="width: 60%;">
        <form id="form-user" action="<?php echo base_url('account/signin'); ?>" method="POST">
            <div class="card">
                <div class="card-header"><h5 class="font-weight-bold">เข้าสู่ระบบ</h5></div>
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
                        <div class="row">
                            <div class="col">
                                <a href="<?php echo base_url('account/register'); ?>">
                                <input type="button" class="btn btn-primary" value="สมัครสมาชิก">
                                </a>
                            </div>
                            <div class="col" align='right'>
                                <input type="submit" class="btn btn-success" value="ลงชื่อเข้าใช้งาน">
                            </div>
                        </div>
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

    setInterval(function() {
        c--;
        if (c >= 0)
        {
            $('.cd').text(c);
        }
    },1000);

}

$('#form-user').submit(function(e) {
    e.preventDefault();
    
    var me = $(this);

    $.ajax({
        type : 'POST',
        url : "<?php echo base_url('account/signin'); ?>",
        data : me.serialize(),
        dataType : 'JSON',
        success : function(response) {
            if (response.success == true)
            {
                $('div.form-group').hide();
                $('#the-message').append(
                    '<div class="alert alert-success">' +  
                    '<h4 class="alert-heading">เข้าสู่ระบบสำเร็จ !</h4>' + 
                    '<p>ระบบกำลังพาท่านไปสู่หน้าเว็บภายใน <span class="cd" id="5"></span> วินาที</p>' + 
                    '</div>'
                );
                $('.form-group').removeClass('has-error').removeClass('has-success');
                $('text-danger').remove();
                me[0].reset();
                countdown();
                $('.alert-success').delay(0).show(10, function() {
                    $(this).delay(5000).hide(10, function() {
                        $(this).remove();
                        if (response.account_role == 'admin')
                        {
                            window.location.href = "<?php echo base_url('admin/approval_inform'); ?>";
                        }
                        else
                        {
                            window.location.href = "<?php echo base_url('welcome'); ?>";
                        }
                    });
                });
            }
            else
            {

                if(typeof(response.message) != "undefined" && response.message !== null)
                {
                    $('#username').closest('div.form-group').find('.text-danger').remove();
                    $('#password').closest('div.form-group').find('.text-danger').remove();
                    $('#password').after('<p class="text-danger">' + response.message + '</p>');
                }

                $.each(response.messages, function(key, value) {
                    var element = $('#' + key);
                    element.closest('div.form-group').find('.text-danger').remove();
                    element.after(value);
                });
            }
        }
    });
});
</script>