<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Page header -->
    <!-- Page header -->
    <section class="content-header">
        <h1>
            Settings
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Settings</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="margin-top: 10px;">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header bg-success" style="padding: 15px 10px;">
                        <h3 class="box-title">
                            <strong>Web Settings</strong>
                        </h3>
                        <div class="box-tools">
                            <button type="submit" form="form-setting" class="btn btn-success btn-sm">
                                <i class="fa fa-save" style="margin-right: 3px;"></i>
                                Simpan
                            </button>
                        </div>
                    </div>
                    <div class="box-body" style="padding-top: 30px; padding-bottom: 30px;">
                        <form action="<?= base_url('setting/update_setting') ?>" method="post" id="form-setting" enctype="multipart/form-data" autocomplete="off">
                            <div class="container-fluid">
                                <?= $this->session->flashdata('status') ?>
                                <div class="row">
                                    <div class="col-lg-4 text-center">
                                        <div class="card">
                                            <div class="card-body">
                                                <label for="logo_field">
                                                    <div style="width: 300px; background-color: #bdc3c7; overflow: hidden; display: inline-block; border: solid 5px #bdc3c7;">
                                                        <img src="<?= base_url('storage/logo/' . $setting_data['logoperusahaan']) ?>" style="width: 100%;" id="logo_show">
                                                    </div>
                                                </label>
                                                <input type="file" name="logo" id="logo_field" style="display: none;" data-show="#logo_show">
                                                <h5><strong>Logo Perusahaan</strong></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="card">
                                            <div class="card-body" style="padding: 0px 20px;">
                                                <div class="form-group">
                                                    <label for="navbar">Navbar</label>
                                                    <input type="text" name="navbar" id="navbar" class="form-control" placeholder="Navbar" value="<?= $setting_data['navbar'] ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="alamat">Alamat</label>
                                                    <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat" required><?= $setting_data['alamat'] ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tlp">Phone</label>
                                                    <input type="text" name="tlp" id="tlp" class="form-control" placeholder="+62" value="<?= $setting_data['tlp'] ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" name="email" id="email" class="form-control" placeholder="example@mail.com" value="<?= $setting_data['email'] ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="faks">Faks</label>
                                                    <input type="text" name="faks" id="faks" class="form-control" placeholder="Faks" value="<?= $setting_data['faks'] ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="facebook">Facebook</label>
                                                    <input type="text" name="facebook" id="facebook" class="form-control" placeholder="https://facebook.com" value="<?= $setting_data['facebook'] ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="twitter">Twitter</label>
                                                    <input type="text" name="twitter" id="twitter" class="form-control" placeholder="https://twitter.com" value="<?= $setting_data['twitter'] ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="instagram">Instagram</label>
                                                    <input type="text" name="instagram" id="instagram" class="form-control" placeholder="https://instagram.com" value="<?= $setting_data['instagram'] ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="youtube">Youtube</label>
                                                    <input type="text" name="youtube" id="youtube" class="form-control" placeholder="https://youtube.com" value="<?= $setting_data['youtube'] ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type='text/javascript'>
    function readImg(input, showTarget) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $(showTarget).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('input[name=logo]').change(function() {
        readImg(this, $(this).data('show'));
    });
</script>