<?php if ($this->session->has_userdata('success')) : ?>
    <div class="alert alert-dismissible alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="icon fa fa-check"></i> <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php elseif ($this->session->has_userdata('danger')) : ?>
    <div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="icon fa fa-times"></i> <?php echo $this->session->flashdata('danger'); ?>
    </div>
<?php endif; ?>