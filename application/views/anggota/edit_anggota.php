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

                <form action="<?= base_url('anggota/aktif/update') ?>" method="post" enctype="multipart/form-data" id="formID">
                    <div class="box-body form-horizontal">
                        <div class="box box-success box-solid">
                            <div class="box-header with-border">
                                <h4 class="box-title">DATA PRIBADI</h4>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">NIK</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="id" class="form-control" value="<?= $anggota->id ?>">
                                        <input type="text" name="nik" class="form-control" value="<?= $anggota->nik ?>" <?= ($this->session->userdata('role_user') == '1') ? '' : 'readonly' ?>>
                                        <span class="text-danger" id="nikError">* <i>wajib diisi </i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama" class="form-control" value="<?= $anggota->nama ?>" required>
                                        <span class="text-danger" id="namaError">* <i>wajib diisi </i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Bagian</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="bagian" class="form-control" value="<?= $anggota->bagian ?>" required>
                                        <span class="text-danger" id="bagianError">* <i>wajib diisi </i></span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Foto</label>
                                    <div class="col-sm-4">
                                        <input type="file" class="dropify" data-height="250" name="foto" id="gambar" accept="image/png, image/gif, image/jpeg" data-default-file="<?= base_url($anggota->foto) ?>" data-max-file-size="5M">
                                        <span class="text-danger" id="fotoError"><i>Ekstensi Foto .jpg, .png, .jpeg, Maksimal 5 MB</i></span>
                                    </div>
                                </div>
                                <div class="form-group" <?= ($this->session->userdata('role_user') == '1') ? '' : 'style="display:none"' ?>>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Status Anggota</label>
                                    <div class="col-sm-9">
                                        <select name="status_anggota" class="form-control select2" style="width:100%" required id="status_anggota">
                                            <option value="Aktif" <?= $anggota->status_anggota == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                                            <option value="Tidak" <?= $anggota->status_anggota == 'Tidak' ? 'selected' : '' ?>>Tidak Aktif</option>
                                        </select>
                                        <span class="text-danger" id="statusAnggotaError">* <i>wajib diisi </i></span>
                                    </div>
                                </div>
                                <div class="form-group nonaktif" <?= ($anggota->status_anggota == 'Aktif') ? 'style="display:none"' : '' ?>>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="tgl_nonaktif" class="form-control datepicker" value="<?= ($anggota->tgl_nonaktif == '') ? '' : date('d-m-Y', strtotime($anggota->tgl_nonaktif)) ?>" id="tgl_nonaktif">
                                        <span class="text-danger" id="keteranganError">* <i>wajib diisi </i></span>
                                    </div>
                                </div>
                                <div class="form-group"?>>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <textarea name="keterangan" class="form-control" rows="3" id="keterangana"> <?= $anggota->keterangan ?></textarea>
                                        <span class="text-danger" id="keteranganError">* <i>wajib diisi </i></span>
                                    </div>
                                </div>
                                
                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-success">Update</button>
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

        $('#status_anggota').on('change', function() {
            var status = $(this).val();
            if (status == 'Tidak') {
                $('.nonaktif').show();
                $("#keterangana").prop('required', true);
                $("#tgl_nonaktif").prop('required', true);
            } else {
                $('.nonaktif').hide();
                $("#keterangana").prop('required', false);
                $("#tgl_nonaktif").prop('required', false);
            }
        });

        $('#formID').on('submit', function(e) {
            e.preventDefault();
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