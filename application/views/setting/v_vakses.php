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
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Identitas User Akses Login</h3>
          </div>
          <?php echo form_open("Setting/edit", array('class' => 'form-horizontal')); ?>
          <div class="form-horizontal">
            <div class="box-body">
              <div class="form-group row">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="email" id="email" value="<?= $key['email']; ?>" readonly>
                  <input type="hidden" class="form-control" name="id" id="id" value="<?= $key['id']; ?>" readonly>
                </div>
              </div>
            </div>
            <div class="box-body">
              <div class="form-group row">
                <label class="col-sm-2 control-label">Nama</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="nama" id="nama" value="<?= $key['name']; ?>" readonly>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-success">

          <div class="box-header with-border">
            <h3 class="box-title">Hak Akses</h3>
          </div>
          <div class="box-body  table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Menu &nbsp; <input type="checkbox" onClick='toggle(this)'> Pilih Semua</th>
                  <!-- <th>All</th> -->
                  <th>View</th>
                  <th>Add</th>
                  <th>Edit</th>
                  <th>Hapus</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($akses as $akses) { ?>
                  <tr>
                    <td>
                      <input type="hidden" name="submenu[]" value="<?php echo $akses->id_submenu ?>">
                      <?php echo $akses->menu . ' - ' . $akses->submenu; ?>
                    </td>
                    <td><input type="checkbox" class="icheckbox_flat-green" name="view[]" value="<?php echo $akses->id_submenu ?>" <?php if ($akses->view == '1') {
                                                                                                                                      echo "checked";
                                                                                                                                    } ?>> </td>
                    <td><input type="checkbox" class="icheckbox_flat-green" name="add[]" value="<?php echo $akses->id_submenu ?>" <?php if ($akses->add == '1') {
                                                                                                                                    echo "checked";
                                                                                                                                  } ?>></td>
                    <td><input type="checkbox" class="icheckbox_flat-green" name="edit[]" value="<?php echo $akses->id_submenu ?>" <?php if ($akses->edit == '1') {
                                                                                                                                      echo "checked";
                                                                                                                                    } ?>></td>
                    <td><input type="checkbox" class="icheckbox_flat-green" name="delete[]" value="<?php echo $akses->id_submenu ?>" <?php if ($akses->delete == '1') {
                                                                                                                                        echo "checked";
                                                                                                                                      } ?>></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <a href="<?php echo site_url('hakakses'); ?>" class="btn btn-default">Batal</a>
            <button type="submit" class="btn btn-warning" name="save">Simpan</button>

          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </section>
</div>