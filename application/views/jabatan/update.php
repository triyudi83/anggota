<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"><?= $modal_title ?></h4>
</div>
<form method="post" id="formEdit" action="<?= $action ?>">
    <div class="modal-body form-horizontal">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Susunan Pengurus</label>
            <div class="col-sm-9">
                <select class="form-control select2" name="susunan" style="width:100%" id="susunan_edit">
                    <option value="">Pilih Susunan</option>
                    <?php foreach ($susunan as $susunan) : ?>
                        <option value="<?= $susunan->id ?>" <?= ($susunan->id == $key->susunan_id) ? 'selected' : '' ?>><?= $susunan->nama ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="text-danger" id="Editsusunan"></span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label">Level Kepengurusan</label>
            <div class="col-sm-9">
                <select class="form-control select2" name="level" id="level" style="width:100%">
                    <option value="">Pilih Level Kepengurusan</option>
                    <?php foreach ($level as $level) : ?>
                        <option value="<?= $level->id_pengurus ?>" <?= ($level->id_pengurus == $key->pengurus_id) ? 'selected' : '' ?>><?= $level->level ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="text-danger" id="Editlevel"></span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label">Jabatan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="jabatan" id="jabatan" value="<?= $key->jabatan ?>">
                <span class="text-danger" id="Editjabatan"></span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label">Keterangan</label>
            <div class="col-sm-9">
                <select class="form-control select2" name="keterangan" id="keteranganEdit" style="width:100%">
                    <option value="">Pilih Keterangan</option>
                    <option value="1" <?= ($key->keterangan == '1') ? 'selected' : '' ?>>Satu Jabatan Satu Orang</option>
                    <option value="2" <?= ($key->keterangan == '2') ? 'selected' : '' ?>>Satu Jabatan Banyak Orang</option>
                </select>
                <span class="text-danger" id="Editketerangan"></span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
            <input type="hidden" name="id" value="<?= $key->id_jabatan; ?>" id="id" required />
            <button type="submit" class="btn btn-sm btn-info" id="simpana"><i class="fa fa-floppy-o"></i> Update</button>
            <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal" aria-label="Close">Kembali</button>
    </div>

</form>
<script type="text/javascript">
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
        $('#formEdit').on('submit', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var data = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function(data) {
                    var data = JSON.parse(data);
                    if (data.status == 'success') {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message,
                            icon: 'success',
                            timer: 1000
                        })
                        $('#modalView').modal('hide');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        $.each(data.message, function(key, value) {
                            $('#Edit' + key).html(value);
                        });
                    }

                }
            });
        });

        $('#susunan_edit').change(function() {
            var id = $(this).val();
            $.ajax({
                url: '<?= base_url("setting/get_level"); ?>',
                type: 'POST',
                data: {
                    susunan_id: id
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $("#level").html(data.list);
                },
            });
        });
    });

    function cek_jabatanedit() {
        $("#spanJabatana").hide();
        var jabatan = $("#jabatana").val() || '';
        var id = $("#id").val() || '';
        $.ajax({
            url: "<?php echo base_url("Jabatan/cek_jabatanedit"); ?>", //arahkan pada proses_tambah di controller member
            data: {
                jabatan: jabatan,
                id: id
            },
            type: "POST",
            success: function(msg) {
                if (msg == 1) {
                    $("#spanJabatana").css("color", "#fc5d32");
                    $("#jabatana").css("border-color", "#fc5d32");
                    $("#spanJabatana").html("jabatan Sudah Ada");
                    $("#simpana").attr("disabled", "disabled");
                    error = 1;
                } else {
                    $("#spanJabatana").css("color", "#59c113");
                    $("#jabatana").css("border-color", "#59c113");
                    $("#spanJabatana").html("");
                    $("#simpana").attr("disabled", false);

                    error = 0;
                }

                $("#spanJabatana").fadeIn(1000);
            }
        });
    };
</script>