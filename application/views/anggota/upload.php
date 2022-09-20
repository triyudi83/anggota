<link rel="stylesheet" type="text/css" href="<?= base_url() . 'assets/css/dropify.min.css' ?>">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"><?= $modal_title ?></h4>
</div>
<form method="post" id="FormID" enctype="multipart/form-data" action="<?= $action ?>">
    <div class="box-body">
        <div class="form-group row">
            <label class="col-sm-2 control-label">KTA</label>
            <div class="col-sm-9">
                <input type="hidden" class="form-control" name="kd_gambar" id="gambar" value="<?= $anggota->nik ?>">
                <input type="file" class="dropify" onchange="ValidateSize(this)" data-max-file-size="5M" data-height="300" name="filefoto" id="gambar" accept="image/png, image/gif, image/jpeg" <?= ($button != 'Tambah') ? 'data-default-file="' . base_url($anggota->kta) . '"' : '' ?>>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label">NIK</label>
            <div class="col-sm-9">
                <input type="hidden" class="form-control" name="id" id="id" value="<?= $anggota->id ?>" readonly>
                <input type="text" class="form-control" name="nik" id="nik" value="<?= $anggota->nik ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label">Nama</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="nama" id="nama" value="<?= $anggota->nama ?>" readonly>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-info" id="simpana"><i class="fa fa-floppy-o"></i> <?= $button ?></button>
        <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Kembali</button>
    </div>
</form>
<script type="text/javascript" src="<?php echo base_url() . 'assets/css/dropify.min.js' ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#FormID').submit(function(e) {
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
            $.ajax({
                url: url,
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    var data = JSON.parse(data);
                    if (data.status === 'success') {
                        
                        setTimeout(function() {
                            $('#modalView').modal('hide');
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.value) {
                                    location.reload();
                                }
                            });
                         }, 2000);
                        
                        
                    } else {
                        Swal.close();
                        $.each(data.message, function(key, value) {
                            $('#' + key + 'Error').html('');
                            $('#' + key + 'Error').html(value);
                        });
                    }
                }
            })
        });

        $('.dropify').dropify({
            messages: {
                default: 'Drag atau drop untuk memilih gambar',
                replace: 'Ganti',
                remove: 'Hapus',
                error: 'error'
            }
        });
    });

    function ValidateSize(file) {
        var FileSize = file.files[0].size / 5120 / 5120; // in MB
        if (FileSize > 5) {
            alert('Maaf File anda terlalu besar');
            $(file).val(''); //for clearing with Jquery
        }
    }
</script>