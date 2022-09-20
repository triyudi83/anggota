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
                </div>
                <div class="box-body form-horizontal">
                    <ul class="list-group">
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Nama Pengurus </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $database->nama ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Alamat </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $database->alamat ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Provinsi </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $database->name_prov ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Kota </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $database->name_kota ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Kecamatan </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $database->kecamatan ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Desa </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $database->kelurahan ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">No. Telp </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span style="text-transform: uppercase;"><?= $database->phone ?></span>
                        </li>
                        <li class="list-group-item" style="padding-top: 7px;padding-bottom:7px">
                            <strong style="width: 180px; display: inline-block;">Email </strong>
                            <span style="display: inline-block; width: 10px;">:</span>
                            <span><?= $database->email ?></span>
                        </li>

                    </ul>
                </div>

            </div>
        </div>
        <div id="row">
            <!-- Small boxes (Stat box) -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <?php if (tomboltambah($activeMenu) == 'aktif') { ?>
                        <a href="<?= site_url('susunan/pengurus/' . $database->id); ?>" class="btn btn-success ActView"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Data Susunan Pengurus</a>
                    <?php } ?>
                </div>
                <div class="box-body table-responsive">
                    <table id="example" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Pengurus</th>
                                <th>Level</th>
                                <th>Jabatan</th>
                                <th>Awal Menjabat</th>
                                <th>Akhir Menjabat</th>
                                <th>Status Menjabat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

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
        var tanggal = new Date();
        var table = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '<?= $ajax ?>',
            scrollY: true,
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
                left: 1,
                right: 1
            },
            "columns": [{
                    "data": "id",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": "member"
                },
                {
                    "data": "susunan"
                },
                {
                    "data": "level"
                },
                {
                    "data": "jabatan"
                },
                {
                    "data": "awal_jabatan"
                },
                {
                    "data": "akhir_jabatan"
                },
                {
                    "data": "status"
                },
                {
                    "data": "action",
                    "orderable": false,
                    "searchable": false
                }
            ],
            columnDefs: [{
                width: 100,
                targets: -1
            }],
        });

        $('#provinsi').change(function() {
            var id = $(this).val();
            $.ajax({
                url: '<?= base_url("frontend/get_kota"); ?>',
                type: 'POST',
                data: {
                    id_provinsi: id
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $("#kabupaten").html(data.list_kota);
                    $("#kecamatan").html('<option value="">Pilih Kecamatan</option>');
                    $("#desa").html('<option value="">Pilih Desa</option>');
                },
            });
        });
        $('#kabupaten').change(function() {
            var id = $(this).val();
            $.ajax({
                url: '<?= base_url("frontend/get_kec"); ?>',
                type: 'POST',
                data: {
                    id_kota: id
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $("#kecamatan").html(data.list_kec);
                    $("#desa").html('<option value="">Pilih Desa</option>');
                },
            });
        });
        $('#kecamatan').change(function() {
            var id = $(this).val();
            $.ajax({
                url: '<?= base_url("frontend/get_kel"); ?>',
                type: 'POST',
                data: {
                    id_kecamatan: id
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $("#desa").html(data.list_kel);
                },
            });
        });

        $('#formID').on('submit', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var data = $(this).serialize();
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    var data = JSON.parse(response);
                    console.log(data);
                    if (data.status == 'success') {
                        window.location.href = '<?= base_url("susunan") ?>';
                    } else {
                        $.each(data.message, function(key, value) {
                            $('#' + key + 'Error').html(value);
                        });
                    }
                }
            });
        });
    });
</script>