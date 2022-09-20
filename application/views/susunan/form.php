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
                <form action="<?= $action ?>" method="post" enctype="multipart/form-data" id="formID">
                    <div class="box-body form-horizontal">
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama</label>
                            <div class="col-sm-9">
                                <input type="hidden" class="form-control" name="id" id="nama" value="<?= $id?>">
                                <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama?>">
                                <span class="text-danger" id="namaError"></span>
                            </div>
                        </div>
                        <!-- alamat -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="alamat" id="alamat"><?= $alamat ?></textarea>
                                <span class="text-danger" id="alamatError"></span>
                            </div>
                        </div>
                        <!-- provinsi -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Provinsi</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="provinsi" id="provinsi" style="width:100%">
                                    <option value="">Pilih Provinsi</option>
                                    <?php foreach ($provinsi as $key => $value) { ?>
                                        <option value="<?= $value->id_provinsi ?>" <?= ($value->id_provinsi == $provinsi_id) ? 'selected' : ''?> ><?= $value->name_prov ?></option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger" id="provinsiError"></span>
                            </div>
                        </div>
                        <!-- kabupaten -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kabupaten</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="kabupaten" id="kabupaten" style="width:100%">
                                    <option value="">Pilih Kabupaten</option>
                                    <?php 
                                        if($kota_id != ''){
                                            foreach ($kabupaten as $key => $value) { ?>
                                                <option value="<?= $value->id_kota ?>" <?= ($value->id_kota == $kota_id) ? 'selected' : ''?> ><?= $value->name_kota ?></option>
                                            <?php }
                                        }
                                    ?>

                                </select>
                                <span class="text-danger" id="kabupatenError"></span>
                            </div>
                        </div>
                        <!-- kecamatan -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kecamatan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="kecamatan" id="kecamatan" style="width:100%">
                                    <option value="">Pilih Kecamatan</option>
                                    <?php 
                                        if($kecamatan_id != ''){
                                            foreach ($kecamatan as $key => $value) { ?>
                                                <option value="<?= $value->id_kecamatan ?>" <?= ($value->id_kecamatan == $kecamatan_id) ? 'selected' : ''?> ><?= $value->kecamatan ?></option>
                                            <?php }
                                        }
                                    ?>
                                </select>
                                <span class="text-danger" id="kecamatanError"></span>
                            </div>
                        </div>
                        <!-- desa -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Desa</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="desa" id="desa" style="width:100%">
                                    <option value="">Pilih Desa</option>
                                    <?php 
                                        if($desa_id != ''){
                                            foreach ($desa as $key => $value) { ?>
                                                <option value="<?= $value->id_kelurahan ?>" <?= ($value->id_kelurahan == $desa_id) ? 'selected' : ''?> ><?= $value->kelurahan ?></option>
                                            <?php }
                                        }
                                    ?>
                                </select>
                                <span class="text-danger" id="desaError"></span>
                            </div>
                        </div>
                        <!-- no_telp -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">No. Telp</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="no_telp" id="no_telp" value="<?= $no_hp?>">
                                <span class="text-danger" id="no_telpError"></span>
                            </div>
                        </div>
                        <!-- email -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="email" id="email" value="<?= $email?>">
                                <span class="text-danger" id="emailError"></span>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-success"><?= $button ?></button>
                            <a href="<?= base_url('susunan') ?>" class="btn btn-default">Batal</a>
                        </div>
                    </div>
                </form>
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

