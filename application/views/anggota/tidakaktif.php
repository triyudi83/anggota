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
                <div class="box-body">
                <?php if (tombolhapus($activeMenu) == 'aktif') { ?>
                    <button style="margin-bottom: 10px" class="btn btn-primary delete_all btn-sm" data-url="<?= base_url('anggota/delete/all') ?>">Hapus Semua Item</button>
                <?php } ?>  
                <table id="example1" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="master"></th>
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
                                    <td><input type="checkbox" class="sub_chk" data-id="<?= $register->nik ?>"></td>
                                    <td><?= $key+1?></td>
                                    <td><?= $register->nik?></td>
                                    <td><?= $register->nama?></td>
                                    <td><?= $register->keterangan?></td>
                                    <td>
                                        <a href="<?= base_url('anggota/tidakaktif/detail/' . $register->id) ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Lihat Data</a>
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
