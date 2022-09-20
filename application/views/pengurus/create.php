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
                            <option value="<?= $s->id ?>"> <?= $s->nama ?></option>
                        <?php } ?>
                    </select>
                    <span class="text-danger" id="susunanError"></span>
                </td>
            </tr>
            <tr>
                <td width='200'>Level Kepengurusan</td>
                <td>
                    <input type="text" name="level" class="form-control" id="levela">
                    <span class="text-danger" id="levelError"></span>
                </td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
            <button type="submit" class="btn btn-info" id="simpana"><i class="fa fa-floppy-o"></i> <?= $button ?></button>
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
                            $('#' + key + 'Error').html(value);
                        });
                    }

                }
            });
            return false;
        })

    });
</script>