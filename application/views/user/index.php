<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      User Akses Login
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Data Master</a></li>
      <li class="active">User Akses Login</li>
    </ol>
  </section>

  <div class="box-body">
    <?= $this->session->flashdata('flash') ?>
  </div>


  <section class="content">
    <?php
    if (tomboltambah($activeMenu) == 'aktif') { ?>
      <div id="row">
        <!-- Small boxes (Stat box) -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Tambah User Akses Login</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
          </div>
          <!-- /.box-header -->

          <?php echo form_open('User/tambah'); ?>
          <div class="form-horizontal">
            <div class="box-body">
              <div class="form-group row">
                <label class="col-sm-2 control-label">Nama</label>
                <div class="col-sm-9">
                  <select class="form-control select2" name="nik" id="nik" style="width:100%">
                    <option value="">Pilih User</option>
                    <?php foreach ($anggota as $key) { ?>
                      <option value="<?= $key->nik ?>" data-email="<?= $key->email?>"><?= $key->nik ?> - <?= $key->nama ?></option>
                    <?php } ?>
                  </select>
                 
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" name="email" id="email" required onkeyup="cek_email()" readonly>
                  <span class="text-danger" id="spanemail"></span>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 control-label">Password</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" name="password" id="password" required>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 control-label">Level</label>
                <div class="col-sm-9">
                  <select class="form-control select2" name="level" id="level" style="width:100%" required>
                    <option value="">Pilih Level</option>
                    <?php foreach ($role_user as $role) : ?>
                      <option value="<?= $role->id ?>"><?= $role->nama_role ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <!-- kecamatan -->
              <div class="form-group row">
                <label class="col-sm-2 control-label">Wilayah/Kecamatan</label>
                <div class="col-sm-9">
                  <select class="form-control select2" multiple="multiple" name="kecamatan[]" id="kecamatan" style="width:100%" data-placeholder="  Pilih Kecamatan  " required>
                   <option value="all">Semua Kecamatan</option>
                    <?php foreach ($kecamatan as $kec) : ?>
                      <option value="<?= $kec->id_kecamatan ?>"><?= $kec->kecamatan ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <!-- //masa aktif -->
              <div class="form-group row">
                <label class="col-sm-2 control-label">Masa Aktif Login</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control datepicker" name="active" id="masa_aktif" required>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-success" id="simpan">
                <i class="fa fa-check"></i> Simpan
              </button>
            </div>
          </div>
          <?php echo form_close(); ?>
          <!-- /.box-body -->
        </div>
      </div>
    <?php } ?>
    <div id="row">
      <!-- Small boxes (Stat box) -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">User Akses Login</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body  table-responsive">
          <table id="example1" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                <th style="width: 50px">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Level</th>
                <th>Wilayah/Kecamatan</th>
                <th>Masa Aktif Login</th>
                <th width="120px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 0;
              foreach ($user as $t) {
                $no++ ?>
                <tr>
                  <td><?php echo $no; ?></td>
                  <td><?php echo $t['name']; ?></td>
                  <td><?php echo $t['email']; ?></td>
                  <td><?php echo $t['nama_role']; ?></td>
                  <td>
                    <?php 
                    if($t['kecamatan'] == 'all'){
                      echo 'Semua Kecamatan';
                    }else{
                      $hasil = explode(',', $t['kecamatan']);
                      $this->db->select('kecamatan');
                      $this->db->from('tb_kecamatan');
                      $this->db->where_in('id_kecamatan', $hasil);
                      $query = $this->db->get()->result();
                      $s = '';
                      foreach ($query as $key) {
                        echo $s . $key->kecamatan;
                        $s = ', ';
                      }
                    }
                    ?>

                  </td>
                  <td><?php echo date('d-m-Y', strtotime($t['active'])); ?></td>
                  <td>
                      <?php if (tomboledit($activeMenu) == 'aktif') { ?>
                        <a href="<?= base_url() ?>user/edit/<?= $t['id'] ?>" class="btn btn-success btn-sm ActView" title="Edit User Akses"><i class="fa fa-pencil" aria-hidden="true"> </i> Edit</a>
                      <?php } ?>
                      <?php if (tombolhapus($activeMenu) == 'aktif') { ?>
                        <a href="<?= base_url() ?>user/remove/<?= $t['id'] ?>" class="btn btn-danger btn-sm delete" title="Hapus User Akses"><i class="fa fa-trash-o" aria-hidden="true"></i> Hapus</a>
                      <?php } ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->

  <!-- /.content -->
  <div class="modal fade" id="modalView">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>

<script type="text/javascript">
  $(function() {
    
   $('#nik').change(function() {
    var email = $('#nik').find(':selected').data('email');
    $('#email').val(email);
   });

   $('#kecamatan').change(function() {
    var kecamatan = $(this).val();
    var all = kecamatan[0];
    if (all == 'all') {
      $("#kecamatan").html('<option value="all" selected>Semua Kecamatan</option>'+'<option value="3512010">SUMBERMALANG</option>'
            +'<option value="3512020">JATIBANTENG</option>'
            +'<option value="3512030">BANYUGLUGUR</option>'
            +'<option value="3512040">BESUKI</option>'
            +'<option value="3512050">SUBOH</option>'
            +'<option value="3512060">MLANDINGAN</option>'
            +'<option value="3512070">BUNGATAN</option>'
            +'<option value="3512080">KENDIT</option>'
            +'<option value="3512090">PANARUKAN</option>'
            +'<option value="3512100">SITUBONDO</option>'
            +'<option value="3512110">MANGARAN</option>'
            +'<option value="3512120">PANJI</option>'
            +'<option value="3512130">KAPONGAN</option>'
            +'<option value="3512140">ARJASA</option>'
            +'<option value="3512150">JANGKAR</option>'
            +'<option value="3512160">ASEMBAGUS</option>'
            +'<option value="3512170">BANYUPUTIH</option>');
    }
   });
  });
  function cek_email() {
    $("#spanemail").hide();
    var nama = $("#email").val();
    $.ajax({
      url: "<?php echo base_url("index.php/User/cek_email"); ?>", //arahkan pada proses_tambah di controller member
      data: 'email=' + nama,
      type: "POST",
      success: function(msg) {
        if (msg == 1) {
          $("#spanemail").css("color", "#fc5d32");
          $("#nama").css("border-color", "#fc5d32");
          $("#spanemail").html("Email sudah digunakan !");
          $("#simpan").attr("disabled", "disabled");
          $("#nama").val("");
          error = 1;
        } else {
          $("#spanemail").css("color", "#59c113");
          $("#nama").css("border-color", "#59c113");
          $("#spanemail").html("");
          $("#simpan").attr("disabled", false);

          error = 0;
        }

        $("#spanemail").fadeIn(1000);
      }
    });

  }
</script>