<footer class="main-footer">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6"><a href="#" class="brand">Red Wash</a>
            <ul class="contact-info list-unstyled">
              <li><a href="Wisma Harapan 1">Wisma Harapan 1 Jalan Lembah Hijau RT.001/007</a></li>
              <li><a href="Mekarsari Cimanggis">Mekarsari Cimanggis</a></li>
              <li><a href="Depok">Depok</a></li>
              <li><a href="Jawa Barat">Jawa Barat 16452</a></li>
              <li><a href="Indonesia">Indonesia</a></li>
              <li><a href="tel:62 896 6208 0514">+62 896 6208 0514</a></li>
            </ul>
          </div>
          <div class="col-lg-3 col-md-6">
            <h5>Operational Hour</h5>
            <ul class="links list-unstyled">
              <li> <a href="#">Monday : Vacation</a></li>
              <li> <a href="#">Tuesday : 10:00-22:00</a></li>
              <li> <a href="#">Wednesday : 10:00-22:00</a></li>
              <li> <a href="#">Thursday : 10:00-22:00</a></li>
              <li> <a href="#">Friday : 10:00-22:00</a></li>
              <li> <a href="#">Saturday : 10:00-22:00</a></li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
    <!-- Javascript files-->
    <script src="<?= base_url('assets/');?>js/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"> </script>
    <script src="<?= base_url('assets/vendor/template_landy/')?>vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/vendor/template_landy/')?>vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="<?= base_url('assets/vendor/template_landy/')?>vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="<?= base_url('assets/vendor/template_landy/')?>js/front.js"></script>
    <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?= base_url('logout');?>">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <script>
    $("#notif").delay(350).slideDown('slow');
    $("#notif").alert().delay(3000).slideUp('slow');
  </script>
  </body>
</html>