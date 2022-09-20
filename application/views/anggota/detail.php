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
                    <h3 class="box-title"><?= $title ?></h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body  table-responsive">
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-success" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">DATA PRIBADI </strong>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">NIK </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $anggota->nik ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Nama </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $anggota->nama ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Tempat Lahir </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $anggota->tempatlahir ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Tanggal Lahir </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= date('d-m-Y', strtotime($anggota->tanggallahir)) ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Umur </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= hitung_umur($anggota->tanggallahir) ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Jenis Kelamin </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $anggota->jk ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Provinsi </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $anggota->name_prov ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Kabupaten </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $anggota->name_kota ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Kecamatan </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $anggota->kecamatan ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Kelurahan </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $anggota->kelurahan ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Alamat </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;">
                                <?= $anggota->alamat ?> RT : <?= $anggota->rt ?> RW : <?= $anggota->rw ?>
                            </span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Status Pernikahan </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $anggota->pernikahan ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Hobby </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $anggota->hobby ?></span>
                        </li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item  list-group-item-success" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">DATA MEDIA SOSIAL </strong>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">No HP </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $anggota->hp ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Email </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span><?= $anggota->email ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Facebook </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $anggota->facebook ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Instagram </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $anggota->instagram ?></span>
                        </li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-success" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">DATA LAINNYA </strong>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Keahlian </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $anggota->keahlian ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Pengalaman Kerja </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $anggota->kerja ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Pengalaman Organisasi </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $anggota->organisasi ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">KTP </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;">
                                <img class="img-fluid" src="<?= base_url($anggota->ktp) ?>" height="204px" width="325px">
                            </span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Foto </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><img class="img-fluid" src="<?= base_url($anggota->foto) ?>" height="211px" width="144px"></span>
                        </li>

                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">KTA </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <?php if ($anggota->kta != NULL) : ?>
                                <span style="text-transform: uppercase;">
                                    <img class="img-fluid" src="<?= base_url($anggota->kta) ?>" height="204px" width="325px">
                                </span>
                            <?php else : ?>

                                <span style="text-transform: uppercase;">Belum Upload KTA</span>
                            <?php endif; ?>
                        </li>
                        <?php if ($anggota->status == ' Baru') : ?>
                            <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                                <strong style="width: 180px; display: inline-block;">Status </strong>
                                <span style="display: inline-block; width: 10px;">:</span>
                                <span style="text-transform: uppercase;">
                                    <button class="btn btn-danger btn-sm">
                                        <?= $anggota->status ?></span>
                                </button>
                            </li>
                        <?php else : ?>
                            <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                                <strong style="width: 180px; display: inline-block;">Status Anggota</strong>
                                <span style="display: inline-block; width: 10px;">:</span>
                                <span style="text-transform: uppercase;">
                                    <button class="btn btn-success btn-sm">
                                        <?= ($anggota->status_anggota == 'Tidak') ? 'Tidak Aktif' : 'Aktif' ?></span>
                                </button>
                            <?php endif; ?>

                            <?php if ($anggota->status_anggota == 'Tidak') : ?>
                            <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                                <strong style="width: 180px; display: inline-block;">Keterangan </strong>
                                <span style="display: inline-block; width: 10px;">:</span>
                                <span style="text-transform: uppercase;"><?= $anggota->keterangan ?></span>
                            </li>

                            <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                                <strong style="width: 180px; display: inline-block;">Tanggal Tidak Aktif</strong>
                                <span style="display: inline-block; width: 10px;">:</span>
                                <span style="text-transform: uppercase;"><?= date('d-m-Y', strtotime($anggota->tgl_nonaktif)) ?></span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="box-footer">
                    <?= $button ?>
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
        $('.verifikasi').on('click', function(e) {
            Swal.fire({
                title: '<h1>Mohon Tunggu Sebentar!</h1>',
                html: '<h4>Data Sedang Kami Proses</h4>', // add html attribute if you want or remove
                width: '500px',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });
        })
    });
</script>