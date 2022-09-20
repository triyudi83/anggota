<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"><?= $modal_title ?></h4>
</div>
<form method="post" id="<?= $formID ?>">
    <div class="modal-body">
        <table class='table table-bordered'>
            <tr>
                <td>Susunan Pengurus</td>
                <td>
                    <select class="form-control select2" name="susunan" id="susunan" style="width:100%">
                        <option value="">Pilih Susunan Pengurus</option>
                        <?php foreach ($susunan as $s) { ?>
                            <option value="<?= $s->id ?>" <?= ($s->id == $key->susunan_id) ? 'selected' : '' ?>> <?= $s->nama ?></option>
                        <?php } ?>
                    </select>
                    <span class="text-danger" id="susunanError"></span>
                </td>
            </tr>
            <tr>
                <td width='200'>Level Kepengurusan</td>
                <td>
                    <input type="text" name="level" value="<?php echo ($this->input->post('level') ? $this->input->post('level') : $key->level); ?>" class="form-control" id="levela">
                    <span class="text-danger" id="levelError"></span>
                </td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
            <input type="hidden" name="id" value="<?= $key->id_pengurus; ?>" id="id" required />
            <button type="submit" class="btn btn-info" id="simpana"><i class="fa fa-floppy-o"></i> Update</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Kembali</button>

    </div>

</form>
<script type="text/javascript">
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2();
        $("#formEdit").submit(function(event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?= $action ?>",
                dataType: "JSON",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        window.location.href = '<?= base_url("pengurus") ?>';
                    } else {
                        $.each(data.message, function(key, value) {
                            $('#' + key + 'Error').html(value);
                        });
                    }
                    if ($.isEmptyObject(data.error)) {

                    } else {
                        $.each(data.message, function(key, value) {
                            var ErrorID = '#' + key + 'Error';
                            $(ErrorID).removeClass("d-none");
                            $(ErrorID).addClass("text-danger");
                            $(ErrorID).text(value);
                        });
                    }
                }
            });
            return false;
        })

    });
</script>