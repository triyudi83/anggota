
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
                <?php if(tomboltambah($activeMenu) == 'aktif'){?>
                <a href="<?= site_url('susunan/create'); ?>">
                <button type="button" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Data
                </button>
                </a>
              <?php } ?>
                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <?php if (tombolhapus($activeMenu) == 'aktif') { ?>
                <button style="margin-bottom: 10px" class="btn btn-primary delete_all btn-sm" data-url="<?= base_url('susunan/itemdelete') ?>">Hapus Semua Item</button>
                <?php } ?>
                    <table id="example1" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="master"></th>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Provinsi</th>
                                <th>Kota</th>
                                <th>Kecamatan</th>
                                <th>No. Telp</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($susunan as $susunan) : ?>
                                <tr>
                                <td><input type="checkbox" class="sub_chk" data-id="<?=$susunan->id ?>"></td>
                                    <td><?= $no++; ?></td>
                                    <td><?= $susunan->nama; ?></td>
                                    <td><?= $susunan->alamat; ?></td>
                                    <td><?= $susunan->name_prov; ?></td>
                                    <td><?= $susunan->name_kota; ?></td>
                                    <td><?= $susunan->kecamatan; ?></td>
                                    <td><?= $susunan->phone; ?></td>
                                    <td>
                                        <a href="<?= site_url('susunan/detail/'.$susunan->id); ?>"  class="btn btn-info btn-xs">Detail</a>
                                        <?php if (tomboledit($activeMenu) == 'aktif') { ?>
                                            <a href="<?= site_url('susunan/edit/' . $susunan->id); ?>" class="btn btn-primary btn-xs">Edit</a>
                                        <?php } ?>
                                        <?php if (tombolhapus($activeMenu) == 'aktif') { ?>
                                            <a href="<?= site_url('susunan/hapus/' . $susunan->id); ?>" class="btn btn-danger btn-xs delete">Hapus</a>
                                        <?php } ?>
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




