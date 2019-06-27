<!doctype html>
<html lang="en">
<head>
    <title><?php if (isset($title)) { echo $title; } else { echo "Untitled"; } ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/bootstrap.min.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@8/dist/sweetalert2.min.css" id="theme-styles">
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/all.min.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/jquery.fancybox-1.3.4.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/style.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" type="text/css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"> <!-- CSS DataTable -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/js/skins/square/blue.css" type="text/css" media="screen"/>
    <script src="<?php echo base_url(); ?>resources/js/jquery.min.js" type="text/javascript"></script> <!-- JS Jquery -->
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8/dist/sweetalert2.min.js"></script>
    <script src="<?php echo base_url(); ?>resources/js/all.min.js" type="text/javascript"></script> <!-- JS All -->
    <script src="<?php echo base_url(); ?>resources/js/jquery.fancybox-1.3.4.js" type="text/javascript"></script> <!-- JS Fancybox Jquery -->
    <script src="<?php echo base_url(); ?>resources/js/jquery.easing-1.3.pack.js" type="text/javascript"></script> <!-- JS Easing Jquery For Fancybox -->
    <script src=<?php echo base_url()."resources/js/holder.min.js" ?>> </script> <!-- JS Holder -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script> <!-- JS Notify -->
    <script src="<?php echo base_url(); ?>resources/js/bootstrap.min.js" type="text/javascript"></script> <!-- JS Bootstrap -->
    <script src=<?php echo base_url()."resources/js/chosen.jquery.min.js" ?>> </script> <!-- JS Chosen Jquery -->
    <script src=<?php echo base_url()."resources/js/icheck.min.js" ?>> </script> <!-- JS Chosen Jquery -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> <!-- JS DataTable -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> <!-- JS Bootstrap DataTable -->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary custom">
    <a class="navbar-brand" href="<?php echo base_url(''); ?>"><i class="fa fa-home"></i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
            <?php if (is_admin()) : ?>
            <!-- สำหรับแอดมิน -->
            <li class="nav-item <?php if ($this->uri->segment(1) == "approval_inform" || $this->uri->segment(2) == "approval_inform"){ echo 'active'; }?>">
                <a class="nav-link" href="<?php echo base_url('admin/approval_inform'); ?>">อนุมัติการฝากถอน <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item <?php if ($this->uri->segment(1) == "history_inform" || $this->uri->segment(2) == "history_inform"){ echo 'active'; }?>">
                <a class="nav-link" href="<?php echo base_url('admin/history_inform'); ?>">ประวัติการแจ้งฝากถอน <span class="sr-only">(current)</span></a>
            </li>
            <?php else: ?>
            <!-- สำหรับสมาชิกทั่วไป -->
            <li class="nav-item <?php if ($this->uri->segment(1) == "choose_criteria" || $this->uri->segment(2) == "choose_criteria"){ echo 'active'; }?>">
                <a class="nav-link" href="<?php echo base_url('lotto/choose_criteria'); ?>">คีย์เลข<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item <?php if ($this->uri->segment(1) == "inform_deposit_withdraw_show" || $this->uri->segment(2) == "inform_deposit_withdraw_show"){ echo 'active'; }?>">
                <a class="nav-link" href="<?php echo base_url('member/inform_deposit_withdraw_show'); ?>">แจ้งฝาก/ถอน</a>
            </li>
            <?php endif; ?>
        </ul>
        <?php if(is_logged_in() && isset($account)) : ?>
        <ul class="nav nav-pills">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fa-user"></i>&nbsp;<?php echo $account->fname; ?>
                </a>
                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                    <p class="dropdown-item"><i class="fab fa-btc"></i>&nbsp;:&nbsp;<?php echo number_format($account->money); ?></p>
                    <a class="dropdown-item" href="<?php echo base_url('profile'); ?>"><i class="fas fa-address-card"></i>&nbsp;&nbsp;ข้อมูลส่วนตัว</a>
                    <?php if (is_admin()) : ?>
                    <!-- สำหรับแอดมิน -->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo base_url('admin/manage_member'); ?>"><i class="fas fa-cog"></i>&nbsp;&nbsp;จัดการสมาชิก</a>
                    <a class="dropdown-item" href="<?php echo base_url('admin/change_price_lotto'); ?>"><i class="fas fa-table"></i>&nbsp;&nbsp;กำหนดราคาหวย</a>
                    <a class="dropdown-item" href="<?php echo base_url('admin/get_lottery_result'); ?>"><i class="fas fa-award"></i>&nbsp;&nbsp;อัพเดทผลหวย</a>
                    <?php else : ?>
                    <a class="dropdown-item" href="<?php echo base_url('member/show_lottery_result'); ?>"><i class="fas fa-award"></i>&nbsp;&nbsp;ตรวจผลการแทงหวย</a>
                    <!-- สำหรับสมาชิกทั่วไป -->
                    <?php endif; ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo base_url('logout'); ?>"><i class="fas fa-sign-out-alt">
                        </i>&nbsp;&nbsp;ออกจากระบบ
                    </a>
                </div>
            </li>
        </ul>
        <?php else: ?>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link login" href="<?php echo base_url('login'); ?>">เข้าสู่ระบบ</a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
  
</nav>