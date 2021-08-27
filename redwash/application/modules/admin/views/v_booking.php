<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $title;?></h1>

<!-- Basic Card Example -->
<div class="card shadow mb-4">
    <div class="card-body">
    <div class="card mx-auto" style="max-width: 640px;">
    <div class="card-body">
    <h5><span class="badge badge-info float-right"><?= $codebooking?></span></h5>
    <h5 class="card-title">Booking Form</h5>
    <h6 class="card-subtitle text-muted">Fill input form for booking</h6>
    <span class="float-right"><?= form_error('code_booking'); ?></span>
    <hr class="sidebar-divider pb-1">

    <form action="<?= base_url('admin/fmbooking');?>" id="bookform" method="POST">
      <div class="form-group row">
        <input type="hidden" class="form-control" id="code_booking" name="code_booking" value="<?= $codebooking?>" readonly>
      </div>
      <div>
        <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?= $user['user_id'];?>" readonly>
      </div>
      <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Name <span class="text-danger">*</span></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="nm_consumer" name="nm_consumer" value="<?= set_value('nm_consumer');?>" required>
          <?= form_error('nm_consumer'); ?>
        </div>
      </div>
      <div class="form-group row">
        <label for="contact" class="col-sm-2 col-form-label">Phone <span class="text-danger">*</span></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="contact" name="contact" value="<?= set_value('contact');?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required maxlength="12">
          <?= form_error('contact'); ?>
        </div>
      </div>
      <div class="form-group row">
        <label for="noplat" class="col-sm-2 col-form-label">No Plat <span class="text-danger">*</span></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="noplat" name="noplat" value="<?= set_value('noplat');?>" onkeyup="this.value = this.value.toUpperCase();" maxlength="12" required>
          <?= form_error('noplat'); ?>
        </div>
      </div>
      <div class="form-group row">
        <label for="typemotor" class="col-sm-2 col-form-label">Type <span class="text-danger">*</span></label>
        <div class="col-sm-10">
        <select class="form-control" name="typemotor" id="typemotor" required>
          <option value="">Choose</option>
          <?php foreach ($typemc as $key => $tm): ?>
          <option value="<?= $tm->price?>"><?= $tm->motor_type;?></option>
          <?php endforeach?>
        </select>
        <?= form_error('typemotor'); ?>
        </div>
      </div>
      <div class="form-group row">
        <label for="total" class="col-sm-2 col-form-label">Total Amount :</label>
        <div class="col-sm-10">
          <input type="text" readonly class="form-control-plaintext form-control-lg" id="tot_cost" name="tot_cost" value="0" required>
        </div>
      </div>
      <hr class="sidebar-divider pb-3">
      <div class="form-group row">
        <div class="col-sm-10">
          <button type="submit" class="btn btn-primary float-left">Submit</button>
        </div>
      </div>
    </form>

    </div>
    </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->