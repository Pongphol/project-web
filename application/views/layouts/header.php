<!doctype html>
<html lang="en">
<head>
    <title><?php if (isset($title)) { echo $title; } else { echo "Untitled"; } ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/bootstrap.min.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/all.min.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/style.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <script src="<?php echo base_url(); ?>resources/js/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
    <script src="<?php echo base_url(); ?>resources/js/bootstrap.min.js" type="text/javascript"></script>
    <script src=<?php echo base_url()."resources/js/chosen.jquery.min.js" ?>> </script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
    </ul>
    <?php if(is_logged_in()) : ?>
    <ul class="nav nav-pills">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
                <i class="fas fa-user"></i>&nbsp;&nbsp;<?php echo $account->fname; ?>
            </a>
            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                <a class="dropdown-item" href="<?php echo base_url('profile'); ?>"><i class="fas fa-address-card"></i>&nbsp;&nbsp;ข้อมูลส่วนตัว</a>
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
