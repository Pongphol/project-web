<script>
    $(document).ready(function(){
   
        get_inform_deposit()
        get_inform_withdraw()
    })
    function get_inform_deposit()
    {
        $.ajax({
                type: "GET",
                url: "<?php echo base_url('admin/get_inform_deposit_ajax'); ?>",
                dataType : 'json',
                success: function(result){
                       
                }  
        });
    }
    function get_inform_withdraw()
    {
        $.ajax({
                type: "GET",
                url: "<?php echo base_url('admin/get_inform_withdraw_ajax'); ?>",
                dataType : 'json',
                success: function(result){
                       console.log(result)
                } 
        });
    }
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
                <div class="card-header"><h4>อนุมัติการแจ้งฝากถอน</h4></div>
                    <div class="card-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#deposit">คำร้องฝากเงิน</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#withdraw">คำร้องถอนเงิน</a>
                            </li>
                        </ul>
                        <div id="myTabContent" class="tab-content form_inform">
                            <div class="tab-pane fade active show" id="deposit">
                                <table class="table table-hover" id="inform_deposit">
                                    <tr>
                                        <td>ผู้เติมเงิน</td>
                                        <td>ธนาคาร</td>
                                        <td>หมายเลขบัญชี</td>
                                        <td>จำนวนเงินฝาก</td>
                                        <td>วันที่</td>
                                        <td>เวลา</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane fade show" id="withdraw">
                                <table class="table table-hover" id="inform_withdraw">
                                    <tr>
                                        <td>ผู้ถอน</td>
                                        <td>ธนาคาร</td>
                                        <td>หมายเลขบัญชี</td>
                                        <td>จำนวนเงินถอน</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </body>
</html>