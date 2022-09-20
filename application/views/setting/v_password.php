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
        <?= $this->session->flashdata('alert') ?>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Identitas User Akses Login</h3>
                    </div>
                    <?= form_open("Setting/gantipassword", array('class' => 'form-horizontal')); ?>

                    <div class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group row">
                                <label class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="email" id="email" value="<?= $key['email']; ?>" readonly>
                                    <input type="hidden" class="form-control" name="id" id="id" value="<?= $key['id']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group row">
                                <label class="col-sm-2 control-label">Nama</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama" id="nama" value="<?= $key['name']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group row">
                                <label class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="password" id="password" value="<?= $key['password']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group row">

                                <div class="col-sm-9">
                                    <a href="<?= site_url('hakakses'); ?>" class="btn btn-default">Batal</a>
                                    <button type="submit" class="btn btn-warning" name="save">Simpan</button>
                                </div>

                            </div>
                        </div>

                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
    </section>
</div>