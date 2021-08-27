        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800"><?= $title;?></h1>

          <?= $this->session->flashdata('alert');?>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Employee</h6>
              </div>
              <div class="card-body">
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#staticBackdrop">
                Add Employee
              </button>
                <div class="table">
                  <table class="table table-bordered table-responsive" id="tableemply" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th width="20%">Name</th>
                        <th width="20%">Username</th>
                        <th>Contact Number</th>
                        <th width="15%">Role</th>
                        <th width="15%">Status</th>
                        <th>Date Create</th>
                        <th width="15%">Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th width="20%">Name</th>
                        <th width="20%">Username</th>
                        <th>Contact Number</th>
                        <th width="15%">Role</th>
                        <th width="15%">Status</th>
                        <th>Date Create</th>
                        <th width="15%">Action</th>
                    </tfoot>
                    <tbody>
                      <!-- DataTable -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<!-- Modal -->
<?php echo form_open('admin/addEmply', array("id" => "form-emply", "class" => "form-horizontal")) ?>
<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
          <label for="name">Username</label>
          <input type="text" class="form-control" id="username" name="username">
        </div>
        <div class="form-group">
          <label for="contact">Contact</label>
          <input type="text" class="form-control" id="contact" name="contact" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="12">
        </div>
        <div class="form-group">
          <label for="password1">Password</label>
          <input type="password" class="form-control" id="password1" name="password1">
        </div>
        <div class="form-group">
          <label for="name">Confirm Password</label>
          <input type="password" class="form-control" id="password2" name="password2">
        </div>
      </div>
      <div class="form-group modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Add</button>
      </div>
    </div>
  </div>
</div>
</form>

<!-- Modal Update Status-->
<form id="update-row-form" action="<?php echo site_url('admin/update_emply');?>" method="post">
<div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Update status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="user_username" class="col-form-label">Username</label>
            <input type="text" name="user_username" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label for="code_booking" class="col-form-label">Name</label>
            <input type="text" name="user_name" class="form-control" placeholder="Code Booking" readonly>
          </div>
          <div class="form-group">
            <label for="status" class="col-form-label">Status:</label>
            <select name="user_is_active" class="form-control" required>
              <option value="1">Active</option>
              <option value="0">Not Active</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Update</button>
      </div>
    </div>
  </div>
</div>
</form>

<!-- Modal Delete Transaction-->
<form id="delete-row-form" action="<?php echo site_url('admin/delete_emply');?>" method="post">
<div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Delete transaction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="user_username" class="form-control" required>
          <strong>Are you sure to delete this record?</strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="submit" class="btn btn-success">Yes</button>
      </div>
    </div>
  </div>
</div>
</form>