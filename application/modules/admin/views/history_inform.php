<script>
    $(document).ready(function(){
        get_history_inform()
    })
    function get_history_inform()
    {
        $.ajax({
                type: "GET",
                url: "<?php echo base_url('admin/get_history_inform'); ?>",
                dataType : 'json',
                success: function(result){
                    $('#history_inform').html(result)
                }  
        });
    }
</script>
<div class="container mt-5" >
    <div class="card border-secondary mb-12" >
        <div class="card-header"><h4>ประวัติการแจ้งฝากถอน</h4></div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th>รูปแบบ</th>
                        <th>ผู้ใช้</th>
                        <th>จำนวน</th>
                        <th>วันถูกแจ้ง</th>
                        <th>วันรับแจ้ง</th>
                        <th>สถานะ</th>
                        <th>รายละเอียด</th>
                    </thead>
                    <tbody id="history_inform">
                        
                    </tbody>
                </table>
            </div>
    </div>
</div>