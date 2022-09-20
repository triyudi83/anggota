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
            <h3 class="box-title">Data Slide</h3><br /><br />
            <?php if (tomboltambah($activeMenu) == 'aktif') { ?>
              <a href="<?php echo site_url('Slide/create'); ?>" class="btn btn-success btn-sm ActView">Tambah Data</a>
            <?php } ?>
          </div>
          <div class="box-body  table-responsive">

            <table id="example1" class="table table-bordered table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Gambar</th>
                  <th>Caption 1</th>
                  <th>action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($key as $data) {
                ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= '<img src="' . base_url() . 'assets/images/' . $data['gambar'] . '" width="100px">'; ?></td>

                    <td><?= $data['caption_1']; ?></td>
                    <td>
                      <div class="btn-group btn-group-sm">
                        
                        <a href="<?= base_url('Slide/show/' . $data['kd_gambar'])?>" class="btn btn-info btn-sm ActView" title="View Tiket"><i class="fa fa-search" aria-hidden="true"></i></a>
                        <?php if (tomboledit($activeMenu) == 'aktif') { ?>
                          <a href="<?= base_url('Slide/edit/' . $data['kd_gambar'])?>" class="btn btn-success btn-sm ActView" title="Edit Tiket"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <?php } ?>
                        <?php if (tombolhapus($activeMenu) == 'aktif') { ?>
                          <a href="<?= base_url('Slide/delete/' . $data['kd_gambar'])?>" class="btn btn-danger btn-sm delete" title="Hapus Tiket"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        <?php } ?>
                      </div>
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
  <div class="modal fade" id="modalView">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
  $(document).ready(function() {

    $(document).on('click', '.Del', function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Apakah Anda Yakin ?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Tidak',
        confirmButtonText: 'Ya'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "DELETE",
            url: $(this).attr('href'),
            dataType: "JSON",
            success: function(data) {
              if ($.isEmptyObject(data.error)) {
                Swal.fire({
                  title: data.title,
                  text: data.success,
                  icon: data.icon,
                  timer: 1000
                })
                setTimeout(function() {
                  $("#example1").DataTable().ajax.reload();
                }, 1000);
              } else {
                Swal.fire({
                  title: data.title,
                  text: data.error,
                  icon: data.icon,
                  timer: 1000
                })
              }
            }
          });
          return false;

        }
      })
    });
  });
</script>