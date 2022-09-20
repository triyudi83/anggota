<link rel="stylesheet" type="text/css" href="<?= base_url() . 'assets/css/dropify.min.css' ?>">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"><?= $modal_title ?></h4>
</div>
<form method="post" id="" method="<?= $method ?>" enctype="multipart/form-data" action="<?= $action ?>">
    <div class="box-body">
        <div class="form-group row">
            <label class="col-sm-2 control-label">Gambar</label>
            <div class="col-sm-9">
                <input type="hidden" class="form-control" name="kd_gambar" id="gambar" value="<?= $kd_gambar ?>">
                <input type="file" class="dropify" data-height="300" name="filefoto" id="gambar" accept="image/png, image/gif, image/jpeg" <?= ($button != 'Tambah') ? 'data-default-file="' . base_url('assets/images/' . $gambar) . '"' : '' ?>>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label">Caption</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="caption1" id="caption_1" value="<?= $caption_1 ?>" required>
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
        $('.dropify').dropify({
            messages: {
                default: 'Drag atau drop untuk memilih gambar',
                replace: 'Ganti',
                remove: 'Hapus',
                error: 'error'
            }
        });
    });
</script>