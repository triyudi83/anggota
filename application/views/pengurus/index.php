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
                    <h3 class="box-title">Pencarian Data</h3>

                </div>
                <div class="form-horizontal">
                    <div class="box-body">
                        <!-- susunan -->
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Susunan Pengurus</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="susunan" style="width:100%" id="susunan">
                                    <option value="" data-nama="">Pilih Susunan</option>
                                    <?php foreach ($susunan as $susunan) : ?>
                                        <option value="<?= $susunan->id ?>" data-nama="<?= $susunan->nama ?>"><?= $susunan->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="text-danger" id="Errorsusunan"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Level Kepengurusan</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="level" id="level" style="width:100%">
                                    <option value="" data-level="">Pilih Level Kepengurusan</option>
                                </select>
                                <span class="text-danger" id="Errorlevel"></span>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
        <div id="row">
            <!-- Small boxes (Stat box) -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <?php if (tomboltambah($activeMenu) == 'aktif') { ?>
                        <a href="<?= site_url('pengurus/create'); ?>" class="btn btn-success ActView"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Data</a>
                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body  table-responsive">
                    <button style="margin-bottom: 10px" class="btn btn-primary delete_all btn-sm" data-url="<?= base_url('pengurus/itemdelete') ?>">Hapus Semua Item</button>
                    <table id="example" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="master"></th>
                                <th>No</th>
                                <th>Susunan Kepengurusan</th>
                                <th>Level Kepengurusan</th>
                                <th style="width: 150px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0;
                            foreach ($pengurus as $t) {
                                $no++ ?>
                                <tr>
                                    <td><input type="checkbox" class="sub_chk" data-id="<?= $t['id_pengurus'] ?>"></td>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $t['nama_susunan']; ?></td>
                                    <td><?php echo $t['level']; ?></td>
                                    <td>
                                        <?php if (tomboledit($activeMenu) == 'aktif') { ?>
                                            <a href="<?= base_url() ?>pengurus/edit/<?= $t['id_pengurus'] ?>" class="btn btn-success btn-sm ActView" title="Edit <?= $activeMenu ?>"><i class="fa fa-pencil" aria-hidden="true"> </i> Edit</a>
                                        <?php } ?>
                                        <?php if (tombolhapus($activeMenu) == 'aktif') { ?>
                                            <a href="<?= base_url() ?>pengurus/remove/<?= $t['id_pengurus'] ?>" class="btn btn-danger btn-sm delete" title="Hapus <?= $activeMenu ?>"><i class="fa fa-trash-o" aria-hidden="true"></i> Hapus</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
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

<script type="text/javascript">
    $(document).ready(function() {
        var tabel = $('#example').DataTable({
            scrollY: true,
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
                left: 1,
                right: 1
            },
            columnDefs: [{
                width: 100,
                targets: -1
            }],
        });
        $('#susunan').change(function() {
            var id = $(this).val();
            var nama = $(this).find(':selected').data('nama');
            tabel.columns(3).search('').draw();
            console.log(nama);
            $.ajax({
                url: '<?= base_url("setting/get_level"); ?>',
                type: 'POST',
                data: {
                    susunan_id: id
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $("#level").html(data.list);
                    tabel.columns(2).search(nama).draw();
                },
            });
        });


        $('#level').change(function() {
            var id = $(this).val();
            var nama = $(this).find(':selected').data('level');
            tabel.columns(3).search(nama).draw();
        });


        $('#formID').on('submit', function(e) {
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
                        //reload page
                        location.reload();
                    } else {
                        $.each(data.message, function(key, value) {
                            $('#Error' + key).html(value);
                        });
                    }
                }
            });
        });
    });
</script>