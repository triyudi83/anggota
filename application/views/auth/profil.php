<div class="row">
    <!-- /.col -->
    <div class="col-md-12">
        <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user">

            <div class="box-body  table-responsive">

                <div class="col-md-12">

                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-green-gradient" style="
                        min-height: 100px;
                        height: auto;
                        margin: 0;
                        padding-top: 20px;
                        padding-bottom: 50px;
                        overflow:auto">
                        <h2 class="widget-user-username" style="text-align: center;">HALAMAN CEK ANGGOTA</h2>

                    </div>
                    <div class="widget-user-image" style="
                        padding-top: 20px;
                        padding-bottom: 50px;
                        height: auto;
                        overflow:auto">
                        <img class=" img-square" src="<?= base_url() . $key->foto ?>" alt="User Avatar">
                    </div>
                    <br>
                    <br>

                    <div class="box-footer">
                        <br>
                        <br>
                        <div class="row">
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success" style="padding-top: 7px;padding-bottom:7px">
                                    <strong style="width: 200px; display: inline-block;">DATA KEANGGOTAAN </strong>
                                </li>
                                <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                                    <strong style="width: 180px; display: inline-block;">NAMA LENGKAP </strong>
                                    <span style="display: inline-block; width: 10px;">:</span>
                                    <span style="text-transform: uppercase;"><?= $key->nama ?></span>
                                </li>
                                <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                                    <strong style="width: 180px; display: inline-block;">BAGIAN </strong>
                                    <span style="display: inline-block; width: 10px;">:</span>
                                    <span style="text-transform: uppercase;"><?= $key->bagian ?></span>
                                </li>
                                <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                                    <strong style="width: 180px; display: inline-block;">STATUS KEANGGOTAAN </strong>
                                    <span style="display: inline-block; width: 10px;">:</span>
                                    <span style="text-transform: uppercase;">
                                        <?php if ($key->status_anggota == 'Tidak') : ?>
                                            <span class="label label-danger">Tidak Aktif</span>
                                        <?php else : ?>
                                            <span class="label label-success"><?= $key->status_anggota ?></span>
                                        <?php endif ?>
                                    </span>
                                </li>
                                <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                                    <strong style="width: 180px; display: inline-block;">KETERANGAN </strong>
                                    <span style="display: inline-block; width: 10px;">:</span>
                                    <span style="text-transform: uppercase;"><?= $key->keterangan ?></span>
                                </li>
                            </ul>


                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Tutup Halaman</button>
                                    <a href="https://dpcpppsitubondo.or.id" class="btn btn-success" target="_blank">Kunjungi Website</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.widget-user -->
    </div>
</div>