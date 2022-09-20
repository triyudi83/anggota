<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CEK ANGGOTA DPC PPP SITUBONDO</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/iCheck/square/blue.css">

    <link rel="shortcut icon" href="<?= base_url('assets/login/') ?>images/favicon1.ico">
    <link href="<?= base_url('assets/login/') ?>css/style.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition accountbg">

    <div class="content-center">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-md-12">
                    <div class="login-box">
                        <!-- /.login-logo -->
                        <div class="login-box-body">
                            <div class="login-logo">
                                <img src="<?= base_url('assets/login/') ?>images/logo-dark.png" height="30" alt="logo">
                            </div>
                            <p class="login-box-msg"><strong>HALAMAN CEK ANGGOTA DPC PPP KAB. SITUBONDO</strong></p>

                            <div class="form-group has-feedback">
                                <input class="form-control" type="text" id="nama" required="" placeholder="Masukkan NIK / Nama" name="name">
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <div id="hasilcek"></div>

                            </div>
                        </div>
                    </div>
                    <!-- /.login-box-body -->
                </div>
            </div>

            <div class="modal fade" id="modalView">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <!-- /.login-box -->
        </div>
    </div>
    <!-- jQuery 3 -->
    <script src="<?= base_url('assets/') ?>bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?= base_url('assets/') ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?= base_url('assets/') ?>plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });
        });
    </script>

    <script>
        $(document).ready(function() { // Ketika halaman sudah siap (sudah selesai di load)
            // Kita sembunyikan dulu untuk loadingnya
            $("#nama").keyup(function() { // Ketika user mengganti atau memilih data provinsi

                $.ajax({
                    type: "POST", // Method pengiriman data bisa dengan GET atau POST
                    url: "<?php echo base_url("index.php/Cek/search"); ?>", // Isi dengan url/path file php yang dituju
                    data: {
                        cek: $("#nama").val()
                    },
                    dataType: "json",
                    beforeSend: function(e) {
                        if (e && e.overrideMimeType) {
                            e.overrideMimeType("application/json;charset=UTF-8");
                        }
                    },
                    success: function(response) {
                        $("#hasilcek").html(response.list_user).show();
                    },
                    error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
                    }
                });
            });
        });

        $(document).on('click', '.ActView', function(e) {
            e.preventDefault();
            $('#modalView').modal({
                backdrop: 'static',
                keyboard: false,
            });
            $('#modalView .modal-content').html(`<h5 class="text-center">Memuat...</h5>`);
            $('#modalView').modal('show')
            $.get($(this).attr('href'), function(data) {
                $('#modalView .modal-content').html(data);
            });
        });
    </script>

    <script>
        $(document).ready(function() { // Ketika halaman sudah siap (sudah selesai di load)
            // Kita sembunyikan dulu untuk loadingnya
            $("#nama").keypress(function() { // Ketika user mengganti atau memilih data provinsi

                $.ajax({
                    type: "POST", // Method pengiriman data bisa dengan GET atau POST
                    url: "<?php echo base_url("index.php/Cek/search"); ?>", // Isi dengan url/path file php yang dituju
                    data: {
                        cek: $("#nama").val()
                    },
                    dataType: "json",
                    beforeSend: function(e) {
                        if (e && e.overrideMimeType) {
                            e.overrideMimeType("application/json;charset=UTF-8");
                        }
                    },
                    success: function(response) {
                        $("#hasilcek").html(response.list_user).show();
                    },
                    error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
                    }
                });
            });
        });

        $(document).on('click', '.ActView', function(e) {
            e.preventDefault();
            $('#modalView').modal({
                backdrop: 'static',
                keyboard: false,
            });
            $('#modalView .modal-content').html(`<h5 class="text-center">Memuat...</h5>`);
            $('#modalView').modal('show')
            $.get($(this).attr('href'), function(data) {
                $('#modalView .modal-content').html(data);
            });
        });
    </script>
</body>

</html>