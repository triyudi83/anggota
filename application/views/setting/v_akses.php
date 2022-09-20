<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?= $activeMenu ?>
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#"><?= $katMenu ?></a></li>
      <li class="active"><?= $activeMenu ?></li>
    </ol>
  </section>
  <div class="box-body">
    <?= $this->session->flashdata('flash') ?>
  </div>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-success">


          <div class="box-header with-border">
            <h3 class="box-title">Data User Akses Login</h3><br /><br />
            <?php if (tomboltambah('Hak Akses') == 'aktif') { ?>

              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-success">
                Tambah Data
              </button>
            <?php } ?>
          </div>
          <div class="box-body  table-responsive">

            <table id="example1" class="table table-bordered table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($user as $t) { ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $t['name']; ?></td>
                    <td><?php echo $t['email']; ?></td>
                    <td>
                      <?php if (tombolview($activeMenu) == 'aktif') { ?>
                        <a href="<?php echo site_url('hakakses/' . $t['id']); ?>" class="btn btn-info">Tambah Hak Akses</a>
                        <a href="javascript:;" data-id="<?php echo $t['id'] ?>" data-password="<?php echo $t['password'] ?>" data-toggle="modal" data-target="#edit-password">
                          <button data-toggle="modal" data-target="#modal-password" class="btn btn-primary">Ganti Password</button>
                        </a>
                      <?php } ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>

    <!-- Main row -->
    <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<div class="modal fade" id="modal-success">
  <div class="modal-dialog">
    <?php echo form_open("User/aksestambahuser", array('class' => 'form-horizontal')); ?>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pilih User Akses Login</h4>
      </div>
      <div class="modal-body">
        <select class="form-control select2" id="iduser" name="iduser" style="width: 100%;" required>
          <option value="">--Pilih--</option>
          <?php foreach ($all as $all) {
          ?>
            <option value="<?php echo $all['id'] ?>"><?php echo $all['name'] . ' - ' . $all['email'] ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
    </div>
    <!-- /.modal-content -->
    <?php echo form_close(); ?>
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="edit-password">
  <div class="modal-dialog">
    <?php echo form_open("Setting/gantipassword", array('class' => 'form-horizontal')); ?>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Ganti Password</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="id">
        <input type="password" name="password" id="password" class="form-control" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </div>
    <?php echo form_close(); ?>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- <script>
  $(document).ready(function() {
    // Untuk sunting
    $('#edit-password').on('show.bs.modal', function(event) {
      var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
      var modal = $(this)

      // Isi nilai pada field
      modal.find('#id').attr("value", div.data('id'));
      modal.find('#password').attr("value", div.data('password'));
    });
  });
</script> -->