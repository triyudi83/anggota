

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span></button>
<h4 class="modal-title"><?= $title?></h4>
</div>
    <div class="modal-body">
        <form action="<?= $action ?>" method="<?= $method ?>" enctype="multipart/form-data" id="FormID">
            <div class="form-group row">
                <label class="col-sm-2 control-label">Nama</label>
                <div class="col-sm-9">
                    <input type="hidden" class="form-control" name="id" id="id" value="<?= $id ?>">
                    <input type="text" class="form-control" name="nama_role" id="nama_role" value="<?= $nama_role ?>">
                </div>
                <div class="col-sm-offset-2 col-sm-10">
                    <span class="text-danger" id="nama_roleError"></span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label">Keterangan</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3"><?= $keterangan ?></textarea>
                </div>
                <div class="col-sm-offset-2 col-sm-10">
                    <span class="text-danger" id="keteranganError"></span>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>


  