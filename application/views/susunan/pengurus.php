<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"><?= $modal_title ?></h4>
</div>
<form id="formID" method="<?= $method ?>" enctype="multipart/form-data" action="<?= $action ?>">
    <div class="box-body form-horizontal">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Pengurus</label>
            <div class="col-sm-10">
                <input type="hidden" class="form-control" id="id" name="id" value="<?= $id ?>">
                <input type="hidden" class="form-control" id="susunan_id" name="susunan_id" value="<?= $susunan_id ?>">
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="<?= $nama ?>" readonly>
                <span class="text-danger" id="namaError"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Pilih Anggota</label>
            <div class="col-sm-10">
                <select class="form-control select2" name="anggota" id="anggota" style="width:100%">
                    <option value="">Pilih Anggota</option>
                    <?php foreach ($anggota as $a) { ?>
                        <option value="<?= $a->nik ?>" <?= ($a->nik == $member_id) ? 'selected' : '' ?>> <?= $a->nik ?> - <?= $a->nama ?></option>
                    <?php } ?>
                </select>
                <span class="text-danger" id="anggotaError"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Level</label>
            <div class="col-sm-10">
                <select class="form-control select2" name="level" id="level" style="width:100%">
                    <option value="">Pilih Level</option>
                    <?php foreach ($level as $l) { ?>
                        <option value="<?= $l->id_pengurus ?>" <?= ($l->id_pengurus == $pengurus_id) ? 'selected' : '' ?>> <?= $l->level ?></option>
                    <?php } ?>
                </select>
                <span class="text-danger" id="levelError"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Pilih Jabatan</label>
            <div class="col-sm-10">
                <select class="form-control select2" name="jabatan" id="jabatan" style="width:100%">
                    <option value="">Pilih Jabatan</option>
                    <?php foreach ($jabatan as $j) { ?>
                        <option value="<?= $j->id_jabatan ?>" <?= ($j->id_jabatan == $jabatan_id) ? 'selected' : '' ?>> <?= $j->jabatan ?></option>
                    <?php } ?>
                </select>
                <span class="text-danger" id="jabatanError"></span>
            </div>
        </div>
        <!-- masa jabatan -->
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Awal Jabatan</label>
            <div class="col-sm-10">
                <input type="text" class="form-control datepicker" id="awal_jabatan" name="awal_jabatan" placeholder="Masa Jabatan" value="<?= $awal_jabatan ?>">
                <span class="text-danger" id="awal_jabatanError"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Akhir Jabatan</label>
            <div class="col-sm-10">
                <input type="text" class="form-control datepicker" id="akhir_jabatan" name="akhir_jabatan" placeholder="Masa Jabatan" value="<?= $akhir_jabatan ?>">
                <span class="text-danger" id="akhir_jabatanError"></span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
       
            <button type="submit" class="btn btn-info" id="simpana"><i class="fa fa-floppy-o"></i> <?= $button ?></button>
            <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Kembali</button>

    </div>
</form>
<script src="<?= base_url('assets/') ?>plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('.datepicker').datepicker({
      autoclose: true,
      //format
      format: 'dd-mm-yyyy'
    })
    
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
                        $('#modalView').modal('hide');
                        swal.fire({
                            title: 'Berhasil',
                            text: data.message,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#example').DataTable().ajax.reload();
                    } else {
                        $.each(data.message, function(key, value) {
                            $('#' + key + 'Error').html(value);
                        });
                    }
                }
            });
        });

        $('#level').change(function() {
            var id = $(this).val();
            $.ajax({
                url: '<?= base_url("setting/get_jabatan"); ?>',
                type: 'POST',
                data: {
                    pengurus_id: id
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $("#jabatan").html(data.list);
                },
            });
        });
    });
</script>