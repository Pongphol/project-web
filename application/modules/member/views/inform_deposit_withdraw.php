<style>
    .form_inform{
        padding : 20px;
        padding-left : 10px;
    }
    td {
        padding : 10px;
    }
</style>
<script>
    $(document).ready(function(){
        /* ฝากเงิน */
        $('#submit_deposit').click(function(){
            if($('#refill_money').val() == ""){
                $('#refill_money').addClass("is-invalid")
                $('#validate_refill_money').addClass("invalid-feedback").text("กรุณากรอกจำนวนเงินที่โอน")
            }
            if($('#admin_bank').val() == null){
                $('#admin_bank').addClass("is-invalid")
                $('#validate_admin_bank').addClass("invalid-feedback").text("กรุณาเลือกธนาคารที่โอน")
            }
            if($('#date_input').val() == ""){
                $('#date_input').addClass("is-invalid")
                $('#validate_date_input').addClass("invalid-feedback").text("กรุณาเลือกวันที่โอน")
            }
            if($('#time_input').val() == ""){
                $('#time_input').addClass("is-invalid")
                $('#validate_time_input').addClass("invalid-feedback").text("กรุณาเลือกวันที่โอน")
            }
            if( $('#refill_money').val() != "" && $('#admin_bank').val() != null && $('#date_input').val() != "" && $('#time_input').val() != ""){
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('member/insert_inform_deposit_ajax'); ?>",
                    data:{
                        id_user : 1,
                        refill_money : $('#refill_money').val(),
                        admin_bank : $('#admin_bank').val(),
                        date : $('#date_input').val(),
                        time : $('#time_input').val(),
                        description : $('#description_input').val() 
                    },
                    success: function(result){
                        if(result == "success"){
                            $.notify('แจ้งฝากเงินสำเร็จ', {
                                className: 'success'
                            });
                            $('#refill_money').val("")
                            $('#admin_bank').val(null)
                            $('#date_input').val("")
                            $('#time_input').val("")
                        }
                    }
                });
            }
        })
        $('#refill_money').keyup(function(){
            if($('#refill_money').val() != ""){
                $('#refill_money').removeClass("is-invalid")
            }
        })
        $('#refill_money').change(function(){
            if($('#refill_money').val() != ""){
                $('#refill_money').removeClass("is-invalid")
            }
        })
        $('#admin_bank').change(function(){
            if($('#admin_bank').val() != null){
                $('#admin_bank').removeClass("is-invalid")
            }
        })
        $('#date_input').change(function(){
            if($('#date_input').val() != ""){
                $('#date_input').removeClass("is-invalid")
            }
        })
        $('#time_input').change(function(){
            if($('#time_input').val() != ""){
                $('#time_input').removeClass("is-invalid")
            }
        })
        /* ถอนเงิน */
        $('#submit_withdraw').click(function(){
            if($('#withdraw_money').val() == ""){
                $('#withdraw_money').addClass("is-invalid")
                $('#validate_withdraw_money').addClass("invalid-feedback").text("กรุณากรอกจำนวนเงินที่ถอน")
            }
            if($('#user_bank').val() == null){
                $('#user_bank').addClass("is-invalid")
                $('#validate_user_bank').addClass("invalid-feedback").text("กรุณาเลือกธนาคารที่โอน")
            }
            if( $('#withdraw_money').val() != "" && $('#user_bank').val() != null){
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('member/insert_inform_withdraw_ajax'); ?>",
                    data:{
                        id_user : 1,
                        withdraw_money : $('#withdraw_money').val(),
                        user_bank : $('#user_bank').val()
                    },
                    success: function(result){
                        console.log(result)
                        if(result == "success"){
                            $.notify('แจ้งถอนเงินสำเร็จ', {
                                className: 'success'
                            });
                        }else{
                            $.notify('ยอดเงินที่ถอนไม่เพียงพอ', {
                                className: 'error'
                            });
                        }
                    }
                });
            }
        })
        $('#withdraw_money').keyup(function(){
            if($('#withdraw_money').val() != ""){
                $('#withdraw_money').removeClass("is-invalid")
            }
        })
        $('#withdraw_money').change(function(){
            if($('#withdraw_money').val() != ""){
                $('#withdraw_money').removeClass("is-invalid")
            }
        })
        $('#user_bank').change(function(){
            if($('#user_bank').val() != null){
                $('#user_bank').removeClass("is-invalid")
            }
        })
    })
</script>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="container mt-5" >
            <div class="card border-secondary mb-12" >
                <div class="card-header"><h4>ฝาก / ถอน</h4></div>
                    <div class="card-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#deposit">แจ้งฝาก</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#withdraw">แจ้งถอน</a>
                            </li>
                        </ul>
                        <div id="myTabContent" class="tab-content form_inform">
                            <div class="tab-pane fade active show" id="deposit">
                               <form>
                                   <fieldset class ="mb-12">
                                        <table class="table table-hover">
                                             <tr class="form-group">
                                                <td>จำนวนเงินที่โอน</td>
                                                <td><input class="form-control" type="number" step="100" min=0 name="refill_money" id="refill_money"><div id="validate_refill_money"></div></td>
                                            </tr>
                                            <tr class="form-group">
                                                <td>บัญชีที่โอนเข้า</td>
                                                <td> 
                                                    <select class="form-control " id="admin_bank">
                                                        <option disabled selected >-- เลือกบัญชีที่โอนเข้า --</option>
                                                        <?php
                                                            foreach($bank_admin as $option)
                                                            {
                                                                echo "<option style='background-image:url(".base_url().$option['picture'].");' value='".$option['id']."'>".$option['name_bank']."</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                    <div id="validate_admin_bank"></div>
                                                </td>
                                            </tr>
                                            <tr class="form-group">
                                                <td>วันที่โอนเงิน</td>
                                                <td><input class="form-control" type="date" name="date_input" id="date_input"><div id="validate_date_input"></div></td>
                                            </tr>
                                            <tr class="form-group">
                                                <td>เวลาที่โอนเงิน</td>
                                                <td><input class="form-control" type="time" id="time_input" name="time_input" min="9:00" max="18:00" required><div id="validate_time_input"> </div></td>
                                            </tr>
                                            <tr class="form-group">
                                                <td>รายละเอียดการโอน</td>
                                                <td><input class="form-control" type="text" name="description_input" id="description_input">
                                                <small  class="form-text text-muted">เช่น สาขาที่โอน หรือ โอนจากธนาคารอะไร เพื่อเพิ่มความรวดเร็วในการตรวจสอบ</small>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align='center'><button type="button" class="btn btn-primary" id="submit_deposit">แจ้งเติมเงิน</button></td>
                                            </tr>
                                        </table>
                                   </fieldset>  
                               </form>
                            </div>
                            <div class="tab-pane fade show" id="withdraw">
                                <form>
                                    <fieldset class ="mb-12">
                                        <table class="table table-hover">
                                            <tr class="form-group">
                                                <td>จำนวนเงินที่ต้องการถอน</td>
                                                <td><input class="form-control" type="number" min=0 name="withdraw_money" id="withdraw_money"><div id="validate_withdraw_money"></div></td>
                                            </tr>
                                            <tr class="form-group">
                                                <td>บัญชีธนาคารที่รับเงิน</td>
                                                <td> 
                                                    <select class="form-control " id="user_bank">
                                                        <option disabled selected >-- เลือกบัญชีที่รับเงิน --</option>
                                                        <?php
                                                            foreach($bank_admin as $option)
                                                            {
                                                                echo "<option style='background-image:url(".base_url().$option['picture'].");' value='".$option['id']."'>".$option['name_bank']."</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                    <div id="validate_user_bank"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align='center'><button type="button" class="btn btn-primary" id="submit_withdraw">แจ้งถอนเงิน</button></td>
                                            </tr>
                                        </table>
                                   </fieldset>  
                               </form>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </body>
</html>