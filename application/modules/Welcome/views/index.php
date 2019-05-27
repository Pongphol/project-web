<script>
$.ajax({
	type: "GET",
	url: "<?php echo base_url('welcome/get_lotto_latest'); ?>",
	dataType : 'JSON',
	success: function(response){
		$('#show_lotto').html(response);
	}  
});
</script>
<div class="container mt-5" >
    <div class="card border-secondary mb-12" >
        <div class="card-header"><h4>ตรวจหวยล่าสุด</h4></div>
        <div class="card-body">
			<table id="show_lotto" class="table table-bordered">

			</table>
		</div>
	</div>
</div>