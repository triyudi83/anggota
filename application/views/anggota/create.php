<link rel="stylesheet" type="text/css" href="<?= base_url() . 'assets/css/dropify.min.css' ?>">

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

                <form action="<?= base_url('anggota/aktif/store') ?>" method="post" enctype="multipart/form-data" id="formID">
                    <div class="box-body form-horizontal">
                        <div class="box box-success box-solid">
                            <div class="box-header with-border">
                                <h4 class="box-title">DATA PRIBADI</h4>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">NIK</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nik" class="form-control" required value="<?= set_value('nik') ?>" class="form-control" placeholder="Contoh: 35xxxxxx" minlength="16" maxlength="16" onkeypress="return Angkasaja(event)" required>
                                        <span class="text-danger" id="nikError">* <i>wajib diisi </i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama" class="form-control" required value="<?= set_value('nama') ?>">
                                        <span class="text-danger" id="namaError">* <i>wajib diisi </i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Bagian</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="bagian" class="form-control" required value="<?= set_value('bagian') ?>">
                                        <span class="text-danger" id="bagianError">* <i>wajib diisi </i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Foto</label>
                                    <div class="col-sm-4">
                                        <input type="file" class="dropify" data-height="250" name="foto" id="gambar" accept="image/png, image/gif, image/jpeg" data-max-file-size="5M" required>
                                        <span class="text-danger" id="fotoError"><i>Ekstensi Foto .jpg, .png, .jpeg, Maksimal 5 MB</i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Status Anggota</label>
                                    <div class="col-sm-9">
                                        <select name="status_anggota" class="form-control select2" style="width:100%" required>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Tidak">Tidak Aktif</option>
                                        </select>
                                        <span class="text-danger" id="statusAnggotaError">* <i>wajib diisi </i></span>
                                    </div>
                                </div>
                                <!-- keterangan -->
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Keterangan ..."><?= set_value('keterangan') ?></textarea>
                                    </div>
                                </div>

                                
                        </div>
    
                       
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="<?= base_url('anggota/aktif') ?>" class="btn btn-danger">Batal</a>
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
           
            Swal.fire({
                    title: '<h1>Mohon Tunggu Sebentar!</h1>',
                    html: '<h4>Data Sedang Kami Proses</h4>', // add html attribute if you want or remove
                    width: '500px',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
           

            var url = $(this).attr('action');
            var data = new FormData(this);
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                contentType: false,
                cache: false,
                processData: false,

                success: function(response) {
                    var data = JSON.parse(response);
                    console.log(data);
                    if (data.status == 'success') {
                        
                        setTimeout(function() {
                            Swal.fire({
                            title: 'Berhasil',
                            text: data.message,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = '<?= base_url("anggota/aktif") ?>';
                            }
                        })
                        }, 2000);
                        
                    } else {
                        Swal.close();
                        $.each(data.message, function(key, value) {
                            $('#' + key + 'Error').html(value);
                        });


                    }

                }
            });
        });


        $('#tanggallahir').on('change', function() {
            var birthDay = document.getElementById("tanggallahir").value;
            var now = moment().format('DD-MM-YYYY');
            let date1 = moment(birthDay, 'DD-MM-YYYY');
            let date2 = moment(now, 'DD-MM-YYYY');


            var daysDiff = date2.diff(date1, 'years');
            if (daysDiff == 'NaN') {
                $('#umur').val('');
            } else {
                $('#umur').val(daysDiff);
            }
        });
    });
</script>