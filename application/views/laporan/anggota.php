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
            <form role="form" action="<?php echo site_url('anggota/export/' . $anggota) ?>" method="post">
                <div class="box box-success">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Kecamatan</label>
                            <div class="col-sm-9">
                                <select name="kec" class="form-control select2" style="width:100%" id="kecamatan">
                                    <option value="">Pilih Kecamatan</option>
                                    <?php foreach ($kecamatan as $key) { ?>
                                        <option value="<?= $key->kecamatan ?>" data-id="<?= $key->id_kecamatan ?>"><?= $key->kecamatan ?></option>
                                    <?php } ?>
                                </select>
                                <input type="hidden" name="kecamatan" id="kec_id" value="">
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <div class="col-sm-12" style="display: flex;">

                                <div class="btn-group">
                                    <button type="submit" class="btn btn-info export-excel">
                                        <span class="glyphicon glyphicon-download-alt"></span> Export Excel
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
            </form>
            <!-- /.box-body -->
        </div>
</div>
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

            <table id="example" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NIK</th>
                        <th>NAMA</th>
                        <th>EMAIL</th>
                        <th>NO. TELP</th>
                        <th>PROVINSI</th>
                        <th>KABUPATEN</th>
                        <th>KECAMATAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($register as $key => $register) : ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $register->nik ?></td>
                            <td><?= $register->nama ?></td>
                            <td><?= $register->email ?></td>
                            <td><?= $register->hp ?></td>
                            <td><?= $register->name_prov ?></td>
                            <td><?= $register->name_kota ?></td>
                            <td><?= $register->kecamatan ?></td>
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
        var tabel = $('#example').DataTable({
            scrollY: true,
            scrollX: true,
            button: true,
            scrollCollapse: true,
            fixedColumns: {
                left: 1,
                right: 1
            },
            columnDefs: [{
                width: 100,
                targets: -1
            }],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(0)', nRow).html(iDisplayIndexFull + 1);
            },
        });


        $('#kecamatan').on('change', function() {
            var id = $(this).val();
            var kecamatan = $('#kecamatan option:selected').attr('data-id');
            $('#kec_id').val(kecamatan);
            tabel.columns(7).search(id).draw();
        });

    });
</script>