  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title;?></h1>

      <!-- Basic Card Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">My Profile</h6>
        </div>
        <div class="card-body mx-auto">
          <div class="card" style="max-width: 540px;">
            <div class="row no-gutters">
              <div class="col-md-4">
                <img src="<?= base_url('assets/img/profile/'). $user['user_image'];?>" class="card-img">
              </div>
            <div class="col-md-8">
              <div class="card-body">
                <ul class="list-group list-group-flush my-n3">
                  <li class="list-group-item">Name: <?= $user['user_name']?></li>
                  <li class="list-group-item">Username: <?= $user['user_username']?></li>
                  <li class="list-group-item">Email: <?= $user['user_email']?></li>
                  <li class="list-group-item">Member since <?= date('d F Y', $user['user_ctime']);?></li>
                </ul>
                <div class="card-body text-center my-2">
                  <a href="#" class="card-link">Card link</a>
                  <a href="#" class="card-link">Another link</a>
                </div>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- /.container-fluid -->

  </div>
  <!-- End of Main Content -->