<script>
    $(document).ready(function(){
        get_inform_deposit()
        get_inform_withdraw()
        validate_table()
        //select_all()
        //unselect_all()
    })

    $(document).ajaxComplete(function() {
        select_all();
    });

    /*รับข้อมูลแจ้งเติมเงิน */
    function get_inform_deposit()
    {
        $.ajax({
                type: "GET",
                url: "<?php echo base_url('admin/get_inform_deposit_ajax'); ?>",
                dataType : 'json',
                success: function(result){
                    $('#inform_deposit').html(result)
                     $('input').iCheck({
                        checkboxClass: 'icheckbox_square-blue'
                    });
                }  
        });
    }
    /*function select_all()
    {
        $("#checkAll_deposit").change(function(){
            $('.dep').each(function (ind,ele){
                if(!$(ele).prop('disabled'))
                {
                    $(ele).iCheck('check');
                }
            });
        });
        $("#checkAll_withdraw").change(function(){
            $('.wit').each(function (ind,ele){
                if(!$(ele).prop('disabled'))
                {
                    $(ele).iCheck('check');
                }
            });
        });
    }*/

    function select_all()
    {
        var checkall_withdraw = $('input#checkAll_withdraw');
        var checkboxes_withdraw = $('input.wit');

        checkall_withdraw.on('ifChecked ifUnchecked', function(event) {
            if (event.type == 'ifChecked') {
                checkboxes_withdraw.iCheck('check');
            } else {
                checkboxes_withdraw.iCheck('uncheck');
            }
        });
    
    }

    function unselect_all()
    {
        $("#checkAll_deposit").change(function(){
            $('.dep').each(function (ind,ele){
                if(!$(ele).prop('disabled'))
                {
                    $(ele).iCheck('checked');
                }
            });
        });
        $("#checkAll_withdraw").change(function(){
            $('.wit').each(function (ind,ele){
                if(!$(ele).prop('disabled'))
                {
                    $(ele).iCheck('checked');
                }
            });
        });
    }
    /*รับข้อมูลแจ้งถอนเงิน */
    function get_inform_withdraw()
    {
        $.ajax({
                type: "GET",
                url: "<?php echo base_url('admin/get_inform_withdraw_ajax'); ?>",
                dataType : 'json',
                success: function(result){
                    $('#inform_withdraw').html(result)
                    $('input.wit').iCheck({
                        checkboxClass: 'icheckbox_square-blue'
                    });
                } 
        });
    }
    /*อนุมัติการเติมเงิน */
    function approval_deposit()
    {
        var selected = new Array();
		$("input:checkbox[name=inform]:checked").each(function(){
      		selected.push($(this).val());
		});
        $.ajax({
                type: "POST",
                url: "<?php echo base_url('admin/update_status_confirm_deposit'); ?>",
                data :{
                    id : selected
                },
                success: function(result){
                    get_inform_deposit()
                }
        });
    }
     /*อนุมัติการถอนเงิน */
    function approval_withdraw()
    {
        var selected = new Array();
		$("input:checkbox[name=inform]:checked").each(function(){
      		selected.push($(this).val());
		});
        $.ajax({
                type: "POST",
                url: "<?php echo base_url('admin/update_status_confirm_withdraw'); ?>",
                data :{
                    id : selected
                },
                success: function(result){
                    get_inform_withdraw()
                }
        });
    }
    /*แสดงหน้าจอไม่อนุมัติการเติมเงิน*/
    function push_modal_unconfirm_deposit(id_deposit)
    {
        $.ajax({
                type: "POST",
                url: "<?php echo base_url('admin/get_data_unconfirm_deposit'); ?>",
                dataType : 'json',
                data :{
                    id : id_deposit
                },
                success: function(result){
                    $('#detail_deposit').html(result)
                    $('#unconfirm_deposit_button').val(id_deposit)
                }
        });
        $('#unconfirm_deposit').modal('show');
    }
    /*ไม่อนุมัติการเติมเงิน*/
    function unconfirm_deposit()
    {
        var id_deposit = $('#unconfirm_deposit_button').val()
        if($('#detail_unconfirm_deposit').val() == "")
        {
            $('#detail_unconfirm_deposit').addClass("is-invalid")
            $('#validate_detail_unconfirm_dep').addClass("invalid-feedback").text("กรุณากรอกหมายเหตุการไม่อนุมัติ")
        }
        else
        {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('admin/update_status_unconfirm_deposit'); ?>",
                data :{
                    id : id_deposit,
                    detail : $('#detail_unconfirm_deposit').val()
                },
                success: function(result){
                    get_inform_deposit()
                    $('#unconfirm_deposit').modal('hide');
                }
            });
        }
    }
    /*แสดงหน้าจอไม่อนุมัติการถอนเงิน*/
    function push_modal_unconfirm_withdraw(id_withdraw)
    {
        $.ajax({
                type: "POST",
                url: "<?php echo base_url('admin/get_data_unconfirm_withdraw'); ?>",
                dataType : 'json',
                data :{
                    id : id_withdraw
                },
                success: function(result){
                    $('#detail_withdraw').html(result)
                    $('#unconfirm_withdraw_button').val(id_withdraw)
                }
        });
        $('#unconfirm_withdraw').modal('show');
    }
    /*ไม่อนุมัติการถอนเงิน*/
    function unconfirm_withdraw()
    {
        var id_deposit = $('#unconfirm_withdraw_button').val()
        if($('#detail_unconfirm_withdraw').val() == "")
        {
            $('#detail_unconfirm_withdraw').addClass("is-invalid")
            $('#validate_detail_unconfirm_wit').addClass("invalid-feedback").text("กรุณากรอกหมายเหตุการไม่อนุมัติ")
        }
        else
        {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('admin/update_status_unconfirm_withdraw'); ?>",
                data :{
                    id : id_deposit,
                    detail : $('#detail_unconfirm_withdraw').val()
                },
                success: function(result){
                    get_inform_withdraw()
                    $('#unconfirm_withdraw').modal('hide');
                }
            });
        }
    }
    /*ตรวจสอบเพื่อไม่ให้มีการเลือกซํ้าซ้อน*/
    function validate_table()
    {
        $('.tab_deposit').click(function(){
            $(".wit").prop("checked",false);
            $("#checkAll_withdraw").prop("checked",false);
        })
        $('.tab_withdraw').click(function(){
            $(".dep").prop("checked",false);
            $("#checkAll_deposit").prop("checked",false);
        })
    }
    
</script>

<div class="container mt-5" >
    <div class="card border-secondary mb-12" >
        <div class="card-header"><h4>อนุมัติการแจ้งฝากถอน</h4></div>
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item tab_deposit">
                        <a class="nav-link active" data-toggle="tab" href="#deposit">คำร้องฝากเงิน</a>
                    </li>
                    <li class="nav-item tab_withdraw">
                        <a class="nav-link " data-toggle="tab" href="#withdraw">คำร้องถอนเงิน</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content form_inform">
                    <div class="tab-pane fade active show" id="deposit">
                        <p class="bs-component" style="margin-top: 15px;">
                            <button type="button" class="btn btn-success" onclick="approval_deposit()">อนุมัติ</button>
                        </p>
                        <table class="table table-hover" id="table_deposit">
                            <thead align='center'>
                                <tr>
                                    <th class="cus_checkbox"><input type='checkbox' id="checkAll_deposit" class='test' ></th>
                                    <th>ผู้เติมเงิน</th>
                                    <th>ธนาคาร</th>
                                    <th>หมายเลขบัญชี</th>
                                    <th>จำนวนเงินฝาก</th>
                                    <th>วันที่</th>
                                    <th>เวลา</th>
                                    <th>ดำเนินการ</th>
                                </tr>
                            </thead >
                            <tbody id="inform_deposit" align='center'>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade show" id="withdraw">
                        <p class="bs-component" style="margin-top: 15px;">
                            <button type="button" class="btn btn-success" onclick="approval_withdraw()">อนุมัติ</button>
                        </p>
                        <table class="table table-hover" id="table_withdraw">
                            <thead align='center'>
                                <tr>
                                    <th class="cus_checkbox"><input type='checkbox' id="checkAll_withdraw"></th>
                                    <th>ผู้ถอน</th>
                                    <th>ธนาคาร</th>
                                    <th>หมายเลขบัญชี</th>
                                    <th>จำนวนเงินถอน</th>
                                    <th>ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody id="inform_withdraw" align='center'>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</div>

<div class="modal fade" id="unconfirm_deposit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header ">
        <h5 class="modal-title" id="exampleModalCenterTitle">ไม่อนุมัติ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
            <thead id="detail_deposit">
            </thead>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="unconfirm_deposit()" id="unconfirm_deposit_button" class="btn btn-danger">ยืนยันการไม่อนุมัติ</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="unconfirm_withdraw" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header ">
        <h5 class="modal-title" id="exampleModalCenterTitle">ไม่อนุมัติ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
            <thead id="detail_withdraw">
            </thead>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="unconfirm_withdraw()" id="unconfirm_withdraw_button" class="btn btn-danger">ยืนยันการไม่อนุมัติ</button>
      </div>
    </div>
  </div>
</div>