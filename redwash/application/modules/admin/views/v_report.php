        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800"><?= $title;?></h1>

          <?= $this->session->flashdata('alert');?>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Report</h6>
            </div>
            <div class="card-body">

            <form action="<?= base_url('admin/data_report')?>" id="report">
              <div class="form-row">
                <div class="col-md-4 mb-3">
                  <label for="validationDefault01">Start Date</label>
                  <input type="text" class="form-control" id="startDate" name="startDate" required>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="validationDefault02">End Date</label>
                  <input type="text" class="form-control" id="endDate" name="endDate" required>
                </div>
              </div>
              <h6>Max input one month<span class="text-danger">*</span></h6>
              <button class="btn btn-success" id="btnload" type="submit">Load Report</button>
            </form>

            <hr class="sidebar-divider">

            <div id="result"></div>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
