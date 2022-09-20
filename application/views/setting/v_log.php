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
    <section class="content" style="margin-top: 10px;">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header bg-success" style="padding: 15px 10px;">
                        <h3 class="box-title">
                            <strong><?= $activeMenu ?></strong>
                        </h3>
                    </div>
                    <div class="box-body  table-responsive">
                        <table id="example1" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($log as $no => $l) : ?>
                                    <tr>
                                        <td><?= $no + 1 ?></td>
                                        <td><?= date('d-m-Y G:i:s', strtotime($l['tgl_update'])) ?></td>
                                        <td><?= $l['name'] ?></td>
                                        <td width="65%"><?= $l['ket'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>