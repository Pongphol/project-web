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
                    $('#history_inform').html(result).DataTable();
                    
                }  
        });
    }
</script>
<div class="container mt-5" >
    <div class="card border-secondary mb-12" >
        <div class="card-header"><h4>ประวัติการแจ้งฝากถอน</h4></div>
            <div class="card-body">
                <table class="table" id="history_inform">
                 
                </table>
            </div>
    </div>
</div>