  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-lg-7">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Login Page</h1>
                  </div>

                  <?= $this->session->flashdata('alert');?>

                  <form class="user" method="post" action="<?= base_url('auth')?>">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Enter Email or Username" value="<?= set_value('username');?>">
                      <?= form_error('username');?>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                      <?= form_error('password');?>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="<?= base_url('forgot-password');?>">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="<?= base_url('registration')?>">Create an Account!</a>
                  </div>
                  <div class="text-center">
                  <a class="btn btn-outline-secondary btn-sm" href="<?= base_url('home')?>" role="button">
                    Back to home
                  </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>