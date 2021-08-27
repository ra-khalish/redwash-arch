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
    <script src="<?= base_url('assets/')?>js/script.js"></script>
    <script src="<?= base_url('assets/')?>js/profile.js"></script>
    <!--Datatables-->
    <!-- Page level plugins -->
    <script src="<?= base_url('assets/');?>js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/');?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
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
  // Timer Notifikasi
  $("#notif").delay(350).slideDown('slow');
  $("#notif").alert().delay(3000).slideUp('slow');
    
  // Tab untuk Edit Profile
  $(document).ready(function(){
    $(".nav-tabs a").click(function(){
    $(this).tab('show');
    });

    // Setup datatables
    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
    {
      return {
        "iStart": oSettings._iDisplayStart,
        "iEnd": oSettings.fnDisplayEnd(),
        "iLength": oSettings._iDisplayLength,
        "iTotal": oSettings.fnRecordsTotal(),
        "iFilteredTotal": oSettings.fnRecordsDisplay(),
        "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
        "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
      };
    };

    var table = $("#tsc-user").dataTable({
      initComplete: function() {
        var api = this.api();
        $('#tsc-user_filter input')
          .off('.DT')
          .on('input.DT', function() {
            api.search(this.value).draw();
        });
      },
      oLanguage: {
      sProcessing: "Loading..."
      },
      processing: true,
      serverSide: true,
      ajax: {"url": "<?php echo base_url().'user/userTransaction'?>", "type": "POST"},
        columns: [
          {"data": "code_booking"},
          {"data": "noplat"},
          //render number format for price
          {"data": "pay", render: $.fn.dataTable.render.number(',', '.', '')},
          {"data": "tot_cost", render: $.fn.dataTable.render.number(',', '.', '')},
          {"data": "ch_cost", render: $.fn.dataTable.render.number(',', '.', '')},
          {"data": "ctime"},
          {"data": "etime"},
          {"data": "status",
            "render": function (data, type, row, meta) {
              if(data === 'Queue'){
                var label = 'badge-primary';
              }else if (data === 'Processed'){
                var label = 'badge-warning';
              }else if (data === 'Completed'){
                var label = 'badge-info';
              }else{
                label = 'badge-success';
              }
              return '<h5><span class="badge ' + label + '">' + data + '</span></h5>';
            }
          },
          {"data": "view",
            "orderable": false,
            "searchable": false,
          }
        ],
      order: [[0, 'asc']],
      lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
              
      rowCallback: function(row, data, iDisplayIndex) {
          var info = this.fnPagingInfo();
          var page = info.iPage;
          var length = info.iLength;
          var index = page * length + (iDisplayIndex + 1);
          $('td:eq(0)', row).html();
      }
    });
    // end setup datatables

    // get delete Records
    $('#tsc-user').on('click','.delete_record',function(){
    var booking = $(this).data('booking');
    $('#ModalDelete').modal('show');
    $('[name="code_booking"]').val(booking);
    });
    //End delete Records
  });

  // Tombol refresh
  function refreshPage(){
      window.location.reload();
  } 
</script>
  </script>
  
  </body>
</html>