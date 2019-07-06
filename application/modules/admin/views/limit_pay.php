<div class="container mt-5" >
    <div class="card border-secondary mb-12" >
        <div class="card-header"><h4>จำกัดจำนวนหวย</h4></div>
            <div class="card-body">
            <div style="overflow:auto;">
                <div style="float:left;">
                    <p class="mt-2">
                       <select  id="period">
                            <option disabled selected >-- เลือกงวดลงหวย --</option>
                                <?php
                                    foreach($period as $option)
                                    {
                                        echo "<option value='".$option['id']."'>".$option['start_date']."</option>";
                                    }
                                ?>
                        </select>
                    </p>
                </div>
                <div style="float:right;">
                    <button align='right' type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">รายละเอียด</button>
                </div>
            </div>   
                <ul class="nav nav-tabs">
                    <li class="nav-item tab_deposit">
                        <a class="nav-link active" data-toggle="tab" href="#mylimit">จำนวนของฉัน</a>
                    </li>
                    <li class="nav-item tab_withdraw">
                        <a class="nav-link " data-toggle="tab" href="#other">จำนวนของเจ้าอื่น</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content form_inform">
                    
                </div>
            </div>
    </div>
</div>

<!--หน้ารายละเอียดการอั้นเลข-->
<div class="modal fade" id="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">รายละเอียดการอั้นเลข</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs">
            <li class="nav-item tab_deposit">
                <a class="nav-link active" data-toggle="tab" href="#mylimit_detail">จำนวนของฉัน</a>
            </li>
            <li class="nav-item tab_withdraw">
                <a class="nav-link " data-toggle="tab" href="#other_detail">จำนวนของเจ้าอื่น</a>
            </li>
        </ul>
        <div id="Content" class="tab-content form_inform">
            <div class="tab-pane fade active show" id="mylimit_detail">
                <table class="table table-hover">
                    <thead align='center'>
                        <tr>
                            <th>รูปแบบ</th>
                            <th>จำนวนจ่าย</th>
                        </tr>
                    </thead >
                    <tbody id="inform_mylimit" align='center'></tbody>
                </table>
            </div>

            <div class="tab-pane fade show" id="other_detail">
                <table class="table table-hover">
                    <thead align='center'>
                        <tr>
                            <th>รูปแบบ</th>
                            <th>จำนวนจ่าย</th>
                        </tr>
                    </thead >
                    <tbody id="inform_other" align='center'></tbody>
                </table>
            </div>
                    
        </div>                                                     
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function(){
        get_table_lotto();
    })
    function get_table_lotto(){
        $('#period').on('change',function(){
            var id = $(this).val()
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('admin/get_limit_pay'); ?>",
                dataType : 'json',
                data :{
                    date_id : id
                },
                success: function(result){
                    $('#myTabContent').html(result.html)
                    $('#inform_other').html(result.otherInfo)
                    $('#inform_mylimit').html(result.myInfo)
                }
            });
        })
        
    }
</script>
