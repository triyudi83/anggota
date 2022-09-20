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
                    <h3 class="box-title"><?= $activeMenu ?></h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body  table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 50px">No</th>
                                <th>Jabatan</th>
                                <th style="width: 150px">Actions</th>
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

<script type="text/javascript">
    function cek_jabatan() {
        $("#spanjabatan").hide();
        var jabatan = $("#jabatan").val().trim();
        $.ajax({
            url: "<?php echo base_url("index.php/Jabatan/cek_jabatan"); ?>", //arahkan pada proses_tambah di controller member
            data: 'jabatan=' + jabatan,
            type: "POST",
            success: function(msg) {
                if (msg == 1) {
                    $("#spanjabatan").css("color", "#fc5d32");
                    $("#jabatan").css("border-color", "#fc5d32");
                    $("#spanjabatan").html("jabatan sudah digunakan !");
                    $("#simpan").attr("disabled", "disabled");
                    $("#jabatan").val("");
                    error = 1;
                } else {
                    $("#spanjabatan").css("color", "#59c113");
                    $("#jabatan").css("border-color", "#59c113");
                    $("#spanjabatan").html("");
                    $("#simpan").attr("disabled", false);

                    error = 0;
                }

                $("#spanjabatan").fadeIn(1000);
            }
        });
    }
</script>