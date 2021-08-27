<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
  <div class="sidebar-brand-icon rotate-n-15">
    <i class="fab fa-rockrms"></i>
  </div>
  <div class="sidebar-brand-text mx-3">Redwash</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item <?= ($this->uri->uri_string() == 'admin') ? 'active' : '' ?>">
  <a class="nav-link" href="<?= base_url('admin');?>">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  Main
</div>

<li class="nav-item <?= ($title == 'Vehicle Queue') ? 'active' :'' ?>">
  <a class="nav-link pb-0" href="<?= base_url('admin_queue');?>">
    <i class="fas fa-fw fa-motorcycle"></i>
    <span>Vehicle Queue</span></a>
</li>
<li class="nav-item <?= ($title == 'Booking') ? 'active' :'' ?>">
  <a class="nav-link pb-0" href="<?= base_url('admin_booking');?>">
    <i class="fas fa-fw fa-bookmark"></i>
    <span>Booking</span></a>
</li>
<li class="nav-item <?= ($title == 'Booking Management') ? 'active' :'' ?>">
  <a class="nav-link" href="<?= base_url('admin_manage');?>">
    <i class="fas fa-fw fa-clipboard"></i>
    <span>Booking Management</span></a>
</li>

<?php if($this->session->userdata('role_id') == '1'):?>
  <!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  Report & Data
</div>

<!-- Nav Item - Charts -->
<li class="nav-item <?= ($title == 'Booking Archive') ? 'active' :'' ?>">
  <a class="nav-link pb-0" href="<?= base_url('booking_arc');?>">
    <i class="fas fa-fw fa-archive "></i>
    <span>Booking Archive</span></a>
</li>

<li class="nav-item <?= ($title == 'Data Report') ? 'active' :'' ?>">
  <a class="nav-link pb-0" href="<?= base_url('data_report');?>">
    <i class="fas fa-fw fa-print"></i>
    <span>Data Report</span></a>
</li>

<!-- Nav Item - Tables -->

<li class="nav-item <?= ($title == 'Employee Management') ? 'active' :'' ?>">
  <a class="nav-link" href="<?= base_url('data_emply');?>">
    <i class="fas fa-fw fa-users"></i>
    <span>Data Employee</span></a>
</li>
<?php endif;?>

<!-- Divider -->
<hr class="sidebar-divider">
  
  <!-- Heading -->
  <div class="sidebar-heading">
  Settings
  </div>
  
  <!-- Nav Item - Charts -->
  <li class="nav-item <?= ($title == 'My Profile')?'active':''?>">
    <a class="nav-link pb-0" href="<?= base_url('admin/admin_profile')?>">
      <i class="fas fa-fw fa-address-card"></i>
      <span>My Profile</span></a>
  </li>

  <li class="nav-item">
  <a class="nav-link" href="<?=base_url('auth/logout');?>"data-toggle="modal" data-target="#logoutModal">
      <i class="fas fa-fw fa-sign-out-alt"></i>
    <span>Logout</span></a>
  </li>


<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->