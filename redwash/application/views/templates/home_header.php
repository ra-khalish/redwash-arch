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
    <!-- Favicon-->
    <link rel="shortcut icon" href="favicon.png">
  </head>
  <body>
    <!-- navbar-->
    <header class="header">
      <nav class="navbar navbar-expand-lg fixed-top"><a href="<?= base_url('home');?>" class="navbar-brand">Red Wash</a>
        <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><span></span><span></span><span></span></button>
        <div id="navbarSupportedContent" class="collapse navbar-collapse">
          <ul class="navbar-nav ml-auto align-items-start align-items-lg-center">
            <li class="nav-item"><a href="#about-us" class="nav-link link-scroll">About Us</a></li>
            <li class="nav-item"><a href="#features" class="nav-link link-scroll">Features</a></li>
            <li class="nav-item"><a href="#testimonials" class="nav-link link-scroll">Testimonials</a></li>
        <?php if($this->session->userdata('status') == 'user'):?>
            <li class="nav-item"><a href="<?= base_url('user/queue');?>" class="nav-link">RedWash Queue</a></li>
            <!-- Example single danger button -->
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="mr-2"><?= $user['user_name'];?></span>
              </button>

              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  Profile
                </a>
                <a class="dropdown-item" href="#">
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
            <!-- Button trigger modal--><a href="<?= base_url('login');?>" id="login-button" class="btn btn-primary navbar-btn btn-shadow btn-gradient">Login</a>
            <!-- Button trigger modal--><!--<a href="#" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary navbar-btn btn-shadow btn-gradient">Sign Up</a>-->
          </div>
        <?php endif;?>
        </div>
      </nav>
    </header>
    <?= $this->session->flashdata('alert');?>

    <!-- Login -->
    <div id="loginModal" tabindex="-1" role="dialog" aria-labelledby="logineModalLabel" aria-hidden="true" class="modal fade">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 id="loginModalLabel" class="modal-title">Login</h5>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
            <form id="signupform" class="login_form" action="<?= base_url('auth/do_login');?>" method="POST">
              <div class="alert alert-danger d-none" id="msg_div">
                <span id="res_message"></span>
              </div>
              <div class="form-group">
                <label for="fullname">Username</label>
                <input type="text" name="username" placeholder="Username" id="username">
              </div>
              <div class="form-group">
                <label for="username">Password</label>
                <input type="password" name="password" placeholder="Password" id="password">
              </div>
              <div class="form-group">
                <button type="submit" id="send_form" class="submit btn btn-primary btn-shadow btn-gradient">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>