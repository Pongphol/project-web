<script>

$(document).ready(function() {
    $.ajax({
        url : "<?php echo base_url('member/get_lottery_result'); ?>",
        method : "POST",
        dataType : "JSON",
        success : function(response) {
            $('tbody#show_lottery_result').html(response);
        }
    });
});

</script>

<div class="container-fluid mt-5" >
    <div class="mx-auto">
        <div class="card border-info mb-3">
            <div class="card-header">ผลแทงหวย</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>วันที่</th>
                                        <th>เลข</th>
                                        <th>รูปแบบ</th>
                                        <th>จ่ายเต็ม</th>
                                        <th>ส่วนลด</th>
                                        <th>จ่ายจริง</th>
                                        <th>รางวัล</th>
                                        <th>สถานะ</th>
                                        <th>ผล</th>
                                    </tr>
                                </thead>
                                <tbody id="show_lottery_result"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>