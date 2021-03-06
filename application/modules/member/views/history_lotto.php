<div class="container-fluid mt-5" style="width: 80%;">
    <div class="mx-auto">
        <div class="card border-info mb-3">
            <div class="card-header">ประวัติการแทง</div>
            <div class="card-body">
                <div class="d-flex justify-content-center bd-highlight">
                    <div class="form-group">
                        <label for="exampleSelect1">วันที่แทง</label>
                        <?php if(is_array($buy_date_lotto)) : ?>
                        <?php
                            echo '<select id="buy_date_lotto" class="form-control">';
                            echo "<option disabled selected>เลือกวันที่</option>";
                            foreach ($buy_date_lotto as $date)
                            {
                                echo "<option value='{$date->buy_date}'>" . dateThai($date->buy_date) . "</option>";
                            }
                            echo '</select>';
                        ?>
                        <?php else: ?>
                        <select class="form-control">
                            <option>ไม่พบประวัติการแทง</option>
                        </select>
                        <?php endif; ?>
                    </div>
                </div>
                <ul id="lotto_list"></ul>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $.ajax({
        url : "<?php echo base_url('member/get_lottery_result'); ?>",
        method : "POST",
        dataType : "JSON",
        success : function(response) {
        }
    });
});


$('#buy_date_lotto').on('change', function() {
    var buy_date = $('#buy_date_lotto').val();
    $.ajax({
        method : 'POST',
        url : "<?php echo base_url('member/get_bill'); ?>",
        data : { buy_date : buy_date },
        dataType : 'JSON',
        success : function(response) {
            $('ul#lotto_list').html(response);
        }
    });
});

function showDetail(line)
{
    $("#" + line).slideToggle();
}

</script>