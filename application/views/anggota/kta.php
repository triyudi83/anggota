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
                    <h3 class="box-title"><?= $activeMenu ?></h3>

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
                                <th>NO</th>
                                <th>NIK</th>
                                <th>NAMA LENGKAP</th>
                                <th>BAGIAN</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($register as $key => $register) : ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $register->nik ?></td>
                                    <td><?= $register->nama ?></td>
                                    <td><?= $register->keterangan ?></td>
                                    <td>
                                        <?php if ($register->kta != NULL) : ?>
                                            <span class="label label-success">Sudah Upload KTA</span>
                                        <?php else : ?>
                                            <span class="label label-danger">Belum Upload KTA</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>

                                    <?php if (tomboledit($activeMenu) == 'aktif') { ?>
                                        <a href="<?= base_url('anggota/kta/detail/' . $register->id) ?>" class="btn btn-warning btn-xs"><i class="fa fa-search"></i> Lihat Data</a>
                                    <?php } ?>
                                    <a href="<?= base_url('anggota/kta/upload/' . $register->id) ?>" class="btn btn-success btn-xs ActView"><i class="fa fa-upload"></i> Upload KTA</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
    $(function() {
        $('.uploadkta').on('click', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            alert(url);
        });
    });
</script>