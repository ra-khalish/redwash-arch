<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Red Wash</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/template_landy/')?>vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/template_landy/')?>vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/template_landy/')?>css/landy-iconfont.css">
    <!-- Google fonts - Open Sans-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800">
    <!-- owl carousel-->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/template_landy/')?>vendor/owl.carousel/assets/owl.carousel.css">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/template_landy/')?>vendor/owl.carousel/assets/owl.theme.default.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/template_landy/')?>css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/template_landy/')?>css/custom.css">
    <link href="<?= base_url('assets/');?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= base_url('assets/')?>css/style.css">
    <link href="<?= base_url('assets/');?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="favicon.png">
  </head>
  <body>
    <!-- navbar-->
    <header class="header">
      <nav class="navbar navbar-expand-lg fixed-top"><a href="#" class="navbar-brand">Red Wash</a>
        <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><span></span><span></span><span></span></button>
        <div id="navbarSupportedContent" class="collapse navbar-collapse">
          <ul class="navbar-nav ml-auto align-items-start align-items-lg-center">
        <?php if($this->session->userdata('status') == 'user'):?>
            <!-- Example single danger button -->
            <!-- Nav Item - User Information -->
            <li class="nav-item"><a href="<?= base_url('user_queue');?>" class="nav-link link-scroll">Queue</a></li>
            <li class="nav-item"><a href="<?= base_url('user_booking');?>" class="nav-link link-scroll">Booking</a></li>
            <li class="nav-item dropdown no-arrow">
              <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="mr-2"><?= $user['user_name'];?></span>
              </button>

              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?= base_url('user_profile');?>">
                  My Profile
                </a>
                <a class="dropdown-item" href="<?= base_url('user_transaction');?>">
                  Transaction
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= base_url('logout');?>" data-toggle="modal" data-target="#logoutModal">
                  Logout
                </a>
              </div>
            </li>
          </ul>
        <?php else:?>
          <div class="navbar-text">   
            <!-- Button trigger modal--><a href="<?= base_url('registration');?>" class="btn btn-primary navbar-btn btn-shadow btn-gradient">Sign Up</a>
            <!-- Button trigger modal--><!--<a href="#" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary navbar-btn btn-shadow btn-gradient">Sign Up</a>-->
          </div>
        <?php endif;?>
        </div>
      </nav>
    </header>