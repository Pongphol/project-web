<div class="container mt-5" >
    <div class="card border-secondary mb-12" >
        <div class="card-header"><h4>จำกัดจำนวนหวย</h4></div>
            <div class="card-body">
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
                <ul class="nav nav-tabs">
                    <li class="nav-item tab_deposit">
                        <a class="nav-link active" data-toggle="tab" href="#mylimit">จำนวนของฉัน</a>
                    </li>
                    <li class="nav-item tab_withdraw">
                        <a class="nav-link " data-toggle="tab" href="#other">จำนวนของเจ้าอื่น</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content form_inform">
                    <div class="tab-pane fade active show" id="mylimit">
                    </div>
                    <div class="tab-pane fade show" id="other">
                        
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
                }
            });
        })
        
    }
</script>
