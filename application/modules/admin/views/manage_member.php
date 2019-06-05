<div class="container mt-5" style="width: 80%;">
    <div class="card border-secondary mb-12" >
        <div class="card-header"><h4>จัดการสมาชิก</h4></div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="member_table" class="table table-bordered">
                    <thead>
                        <th>ชื่อผู้ใช้</th>
                        <th>จัดการ</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function() {
    var dataTable = $('#member_table').DataTable({
        "processing" : true, 
        "serverSide" : true, 
        "order" : [],
        "ajax" : {
            url : "<?php echo base_url('admin/get_all_member'); ?>", 
            type : "POST"
        },
        "columnDefs" : [
            {
                "target" : [0, 3, 4],
                "orderable" : false
            }
        ]
    });
});

</script>