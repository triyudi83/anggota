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
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Susunan Pengurus</label>
                        <div class="col-sm-9">
                            <select name="kunci" class="form-control select2" style="width:100%" required id="kunci">
                                <option value="">Pilih Susunan Pengurus</option>
                                <?php foreach ($susunan as $key) { ?>
                                    <option value="<?= $key->nama ?>"><?= $key->nama ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Nama Pengurus</label>
                        <div class="col-sm-9">
                            <select name="list" class="form-control select2" style="width:100%" required id="list">
                                <option value="">Pilih Nama Pengurus</option>
                                <?php foreach ($list as $list) { ?>
                                    <option value="<?= $list->nama ?>"><?= $list->nama ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div id="row">
            <!-- Small boxes (Stat box) -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $activeMenu ?></h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body  table-responsive">

                    <table id="example" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengurus</th>
                                <th>Level</th>
                                <th>Jabatan</th>
                                <th>Nama Lengkap</th>
                                <th>Awal Menjabat</th>
                                <th>Akhir Menjabat</th>
                            </tr>
                        </thead>
                        <tbody>

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

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '<?= $ajax ?>',
            scrollY: true,
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
                left: 1,
                right: 1
            },
            "columns": [{
                    "data": "id",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": "susunan"
                },
                {
                    "data": "level"
                },
                {
                    "data": "jabatan"
                },
                {
                    "data": "member"
                },
                {
                    "data": "awal_jabatan"
                },
                {
                    "data": "akhir_jabatan"
                },
            ],
            columnDefs: [{
                width: 100,
                targets: -1
            }],
        });

        $('#kunci').on('change', function() {
            var id = $(this).val();
            table.columns(1).search(id).draw();
        });
        $('#list').on('change', function() {
            var id = $(this).val();
            table.columns(4).search(id).draw();
        });
    });
</script>