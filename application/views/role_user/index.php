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


    <section class="content">
        <div id="row">
            <!-- Small boxes (Stat box) -->
            <div class="box box-success">
                <div class="box-header with-border">
                <?php if (tomboltambah($activeMenu) == 'aktif') { ?>
                    <a href="<?= base_url('role/create'); ?>" class="btn btn-success btn-sm ActView">Tambah Data</a>
                  <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body  table-responsive">
                    <table id="example" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                          <tr>
                            <th style="width: 50px">No</th>
                            <th>Role User</th>
                            <th>Keterangan</th>
                            <th style="width: 100px">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                        
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


<script>
$(document).ready(function() {
  $('#example').DataTable({
    "serverSide": true,
    "responsive": true,
    "ajax": "<?= base_url('role/data'); ?>",
    "columns": [
      { "data": "id",
        render: function ( data, type, row, meta ) {
              return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      { "data": "nama_role" },
      { "data": "keterangan" },
      { "data": "action" }
    ],
    scrollY: true,
        scrollX:        true,
        scrollCollapse: true,
        fixedColumns:   {
            left: 1,
            right:1
        },
        columnDefs: [
                { width: 100, targets: -1 }
        ],
  });
});

$(document).on('click', '.ActDelete', function (e) {
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
              success: function (data) {
                  if ($.isEmptyObject(data.error)) {
                      Swal.fire({
                          title: data.title,
                          text: data.success,
                          icon: data.icon,
                          timer: 1000
                      })
                      setTimeout(function () {
                          //window.location.href = data.url;
                         $("#example").DataTable().ajax.reload();
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
</script>

