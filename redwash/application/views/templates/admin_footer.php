<!-- Footer -->
<footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; RedWash <?= date('Y');?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

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

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('assets/');?>js/jquery-3.4.1.min.js"></script>
  <!--<script src="<?= base_url('assets/');?>vendor/jquery/jquery.min.js"></script>-->
  <script src="<?= base_url('assets/');?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('assets/');?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('assets/');?>js/sb-admin-2.min.js"></script>
  <script src="<?= base_url('assets/');?>js/datepicker/js/gijgo.min.js"></script>
  <script src="<?= base_url('assets/');?>js/script.js"></script>
  <script src="<?= base_url('assets/');?>js/profile.js"></script>
  <script src="<?= base_url('assets/');?>js/datepick.js"></script>

  <!-- Page level plugins -->
  <script src="<?= base_url('assets/');?>js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="<?= base_url('assets/');?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <script>
  $(document).ready(function(){
    // Notification alert
    $("#notif").delay(350).slideDown('slow');
    $("#notif").alert().delay(3000).slideUp('slow');
    
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

    var table = $("#mngwashing").dataTable({
      initComplete: function() {
        var api = this.api();
        $('#mngwashing_filter input')
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
      ajax: {"url": "<?php echo base_url().'admin/get_order'?>", "type": "POST"},
        columns: [
          {"data": "code_booking"},
          {"data": "nm_consumer"},
          {"data": "contact"},
          {"data": "noplat"},
          //render number format for price
          //{"data": "tot_cost", render: $.fn.dataTable.render.number(',', '.', '')},
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
          {"data": "payment",
            "render": function (data, type, row, meta) {
              if(row.status === 'Completed'){
                return data
              }else{
                return "";
              }
            }
          },
          {"data": "action",
            "orderable": false,
            "searchable": false,
          }
        ],
      order: [[0, 'asc']],
              
        rowCallback: function(row, data, iDisplayIndex) {
          var info = this.fnPagingInfo();
          var page = info.iPage;
          var length = info.iLength;
          var index = page * length + (iDisplayIndex + 1);
          $('td:eq(0)', row).html();
        }
    });
    // end setup datatables

    // get Edit Records
    $('#mngwashing').on('click','.edit_record',function(){
      var booking = $(this).data('booking');
      var noplat  = $(this).data('noplat');
      var status  = $(this).data('status');
    $('#ModalUpdate').modal('show');
      $('[name="code_booking"]').val(booking);
      $('[name="noplat"]').val(noplat);
      $('[name="status"]').val(status);
    });
    // End Edit Records

    // get Pay Records
    $('#mngwashing').on('click','.pay_record',function(){
      var booking = $(this).data('booking');
      var noplat  = $(this).data('noplat');
      var tot_cost  = $(this).data('tot_cost');
      var pay  = $(this).data('pay');
      var ch_cost  = $(this).data('ch_cost');
    $('#ModalPay').modal('show');
      $('[name="code_booking"]').val(booking);
      $('[name="noplat"]').val(noplat);
      $('[name="tot_cost"]').val(tot_cost);
      $('[name="pay"]').val(pay);
      $('[name="ch_cost"]').val(ch_cost);
    });
    // End Pay Records

    // get delete Records
    $('#mngwashing').on('click','.delete_record',function(){
      var booking = $(this).data('booking');
    $('#ModalDelete').modal('show');
      $('[name="code_booking"]').val(booking);
    });
    // End delete Records

    //Archive
    var table = $("#arcwashing").dataTable({
      initComplete: function() {
        var api = this.api();
        $('#arcwashing_filter input')
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
      ajax: {"url": "<?php echo base_url().'admin/get_orderarchive'?>", "type": "POST"},
        columns: [
          {"data": "code_booking"},
          {"data": "noplat"},
          //render number format for price
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
          {"data": "ctime"},
          {"data": "etime"},
          {"data": "cashier"},
          {"data": "view",
            "orderable": false,
            "searchable": false
          }
        ],
        order: [[0, 'desc']],
      rowCallback: function(row, data, iDisplayIndex) {
        var info = this.fnPagingInfo();
        var page = info.iPage;
        var length = info.iLength;
        var index = page * length + (iDisplayIndex + 1);
        $('td:eq(0)', row).html();
      }
    });

    // get Pay Records
    $('#arcwashing').on('click','.pay_record',function(){
      var booking = $(this).data('booking');
      var noplat  = $(this).data('noplat');
      var tot_cost  = $(this).data('tot_cost');
      var pay  = $(this).data('pay');
      var ch_cost  = $(this).data('ch_cost');
    $('#ModalPay').modal('show');
      $('[name="code_booking"]').val(booking);
      $('[name="noplat"]').val(noplat);
      $('[name="tot_cost"]').val(tot_cost);
      $('[name="pay"]').val(pay);
      $('[name="ch_cost"]').val(ch_cost);
    });
    // End Pay Records

    // get Info Records
    $('#arcwashing').on('click','.info_record',function(){
      var booking = $(this).data('booking');
      var nmconsumer = $(this).data('nm_consumer');
      var contact = $(this).data('contact');
      var noplat  = $(this).data('noplat');
      var pay  = $(this).data('pay');
      var tcost  = $(this).data('tot_cost');
      var chcost  = $(this).data('ch_cost');
      var status  = $(this).data('status');
    $('#ModalInfo').modal('show');
      $('[id=booking]').text(booking);
      $('[id="nmconsumer"]').text(nmconsumer);
      $('[id="contact"]').text(contact);
      $('[id="noplat"]').text(noplat);
      $('[id="tcost"]').text(tcost);
      $('[id="pay"]').text(pay);
      $('[id="chcost"]').text(chcost);
      $('[id="status"]').text(status);
    });
    // End Info Records

    // get delete Records
    $('#arcwashing').on('click','.delete_record',function(){
      var booking = $(this).data('booking');
    $('#ModalDelete').modal('show');
      $('[name="code_booking"]').val(booking);
    });
    // End delete Records

    //Table Employee
    var table = $("#tableemply").dataTable({
    initComplete: function() {
      var api = this.api();
      $('#tableemply_filter input')
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
      ajax: {"url": "<?php echo base_url().'admin/get_emply'?>", "type": "POST"},
        columns: [
          {"data": "user_name"},
          {"data": "user_username"},
          {"data": "user_contact"},
          {"data": "user_role"},
          //render number format for price
          //{"data": "tot_cost", render: $.fn.dataTable.render.number(',', '.', '')},
          {"data": "user_is_active",
            "render": function (data, type, row, meta) {
              if(data === '1'){
                var label = 'badge-success';
                var status = 'Active';
              }else{
                var label = 'badge-danger';
                var status = 'Not Active';
              }
              return '<h5><span class="badge ' + label + '">' + status + '</span></h5>';
            }
          },
          {"data": "user_ctime"},
          {"data": "view",
            "orderable": false,
            "searchable": false,
          }
        ],
    rowCallback: function(row, data, iDisplayIndex) {
      var info = this.fnPagingInfo();
      var page = info.iPage;
      var length = info.iLength;
      var index = page * length + (iDisplayIndex + 1);
      $('td:eq(0)', row).html();
    }
  });

    // get Edit Records
    $('#tableemply').on('click','.edit_record',function(){
      var username = $(this).data('username');
      var name = $(this).data('name');
      var status  = $(this).data('status');
    $('#ModalUpdate').modal('show');
      $('[name="user_username"]').val(username);
      $('[name="user_name"]').val(name);
      $('[name="user_is_active"]').val(status);
    });
    // End Edit Records

    // get delete Records
    $('#tableemply').on('click','.delete_record',function(){
      var username = $(this).data('username');
    $('#ModalDelete').modal('show');
      $('[name="user_username"]').val(username);
    });
    // End delete Records
    //Table Employee
  });
  </script>

  <script type="text/javascript">
  $(document).ready(function () {
    $("#btnload").click(function() {
              var action = $("#report").attr('action');
              var report = {
                  startDate: $("#startDate").val(),
                  endDate: $("#endDate").val()
              };

              $.ajax({
                  type: "POST",
                  url: action,
                  data: report,
                  beforeSend: function() {
                      $('#btnload').html('Loading...');
                      $('.btn').addClass('disabled');
                  },
                  success: function(result) {
                      $("#result").html(result);
                      $('#btnload').html('Load Report');
                      $('.btn').removeClass('disabled');
                  }
              });
              return false;
          });
        });
  </script>

  <script>
  // Tombol refresh
  function refreshPage(){
      window.location.reload();
  } 

  // Kembalian
  function change() {
    var ch_cost = 0;
    var pay = parseInt($("input[name=pay]").val());
    var tot_cost = parseInt($("#tot_cost").val());

    ch_cost = pay - tot_cost;
    $("input[name=ch_cost]").val(ch_cost);

    if (pay < tot_cost) {
      $("#ch_cost").addClass("text-danger");
    } else {
      $("#ch_cost").removeClass("text-danger");
    }
  }
  </script>
</body>

</html>
