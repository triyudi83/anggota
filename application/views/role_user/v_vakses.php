
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
      <h1>
        Hak Akses Login
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('Welcome'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url('akses'); ?>">Hak Akses Login</a></li>
        <li class="active">Hak Akses Login</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
          <div class="col-lg-12">
              <div class="box box-success">
                  <div class="box-header with-border">
                      <h3 class="box-title">Setting Hak Akses</h3>
                  </div>
                  <?php echo form_open("role/store_hakakses", array( 'class' => 'form-horizontal')); ?>
                  <div class="form-horizontal">
                    <div class="box-body">           
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Role User</label>
                            <div class="col-sm-9">
                                <input type="hidden" class="form-control" name="nip" id="nip" value="<?php echo $karyawan->id; ?>" readonly>
                                <input type="text" class="form-control" name="role" id="role" value="<?php echo $karyawan->nama_role; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">           
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Keterangan</label>
                            <div class="col-sm-9">
                            <textarea class="form-control" name="keterangan" id="keterangan" rows="3"><?= $karyawan->keterangan ?></textarea>
                            </div>
                        </div>
                    </div>
                    </div>
              </div>
          </div>
      </div>
    <div class="row">
        <div class="col-lg-12">
        <div class="box box-success">

            <div class="box-header with-border">
                <h3 class="box-title">Hak Akses</h3>
            </div>
            <div class="box-body table-responsive">
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
                  $no =1;
                  foreach ($akses as $akses) { ?>
                <tr>
                  <td>
                  <!-- <input type="hidden" name="id" value="<?php echo $akses->nip ?>"> -->
                  <input type="hidden" name="submenu[]" value="<?php echo $akses->id_submenu ?>">
                  <?php echo $akses->menu.' - '.$akses->submenu; ?></td>
                  <td><input type="checkbox" class="icheckbox_flat-green" name="view[]" value="<?php echo $akses->id_submenu ?>" <?php if($akses->view == '1'){ echo "checked"; } ?>> </td>
                  <td><input type="checkbox" class="icheckbox_flat-green" name="add[]" value="<?php echo $akses->id_submenu ?>" <?php if($akses->add == '1'){ echo "checked"; } ?> ></td>
                  <td><input type="checkbox" class="icheckbox_flat-green"  name="edit[]" value="<?php echo $akses->id_submenu ?>" <?php if($akses->edit == '1'){ echo "checked"; } ?> ></td>
                  <td><input type="checkbox" class="icheckbox_flat-green" name="delete[]" value="<?php echo $akses->id_submenu ?>" <?php if($akses->delete == '1'){ echo "checked"; } ?> ></td>
                </tr>
                  <?php } ?>
                </tbody>
              </table>
              <a href="<?php echo site_url('role'); ?>" class="btn btn-default">Batal</a>
              <button type="submit" class="btn btn-warning" name="save" >Simpan</button>
                                
            </div>
            <?php echo form_close(); ?>
        </div>
        </div>
    </div>
</section>
</div>