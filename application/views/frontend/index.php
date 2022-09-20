<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMBADA DPC PPP SITUBONDO</title>

    <link rel="stylesheet" href="<?= base_url('assets/') ?>frontend/asset/css/normalize.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>frontend/asset/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>frontend/asset/css/fontawesome-all.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="<?= base_url('assets/login/') ?>images/favicon1.ico">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>frontend/asset/css/owl.carousel.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>frontend/asset/css/daterangepicker.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- <link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/bootstrap-daterangepicker/daterangepicker.css"> -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>frontend/asset/css/main.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() . 'assets/css/dropify.min.css' ?>">

    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>

</head>

<body>
    <div class="master">

        <section class="hero">

            <div class="owl-carousel hero-slider">
                <?php foreach ($slide as $slide) { ?>
                    <div class="item">
                        <img src="<?= base_url('assets/') ?>images/<?= $slide->gambar; ?>" alt="" style="height:500px">
                    </div>
                <?php } ?>
            </div>
        </section>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash') ?>"></div>


        <section class="reg-form">
            <div class="container">
                <div class="row">
                    <div class="col-md-2">&nbsp;</div>
                    <div class="col-md-8">

                        <form action="<?= base_url('form/save') ?>" method="post" enctype="multipart/form-data" id="formID">

                            <?php //  echo form_open_multipart(base_url('form/save'), 'id="myform"') 
                            ?>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h2>Pendaftaran</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h3>DATA PRIBADI</h3>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 inp-group">
                                    <label for="nik">Nomor Induk Kependudukan (NIK)<span style="color:red;">* <i>wajib diisi </i></span> </label>
                                    <input type="text" name="nik" maxlength="16" minlength="16" id="nik" placeholder="Contoh: 3312xxxxxxxxxx" required onkeyup="cek_nik()">
                                    <span class="text-danger" id="spannik"></span>
                                    <span class="text-danger" id="nikError"></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 inp-group">
                                    <label for="nama">Nama<span style="color:red;">* <i>wajib diisi </i></span></label>
                                    <input type="text" name="nama" id="nama" placeholder="Contoh: John Doe" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 inp-group">
                                    <label for="nama">Bagian<span style="color:red;">* <i>wajib diisi </i></span></label>
                                    <input type="text" name="bagian" id="bagian" placeholder="Contoh: Bagian Administrasi" required>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-12 inp-group">
                                    <label for="foto">Upload Foto Diri <span style="color:red;">* <i>wajib diisi </i></span></label>
                                   
                                    <input type="file" class="dropify" data-height="300" name="filefoto" id="gambar" accept="image/png, image/gif, image/jpeg"
                                        required data-allowed-file-extensions="png jpg jpeg" data-max-file-size="5M" data-errors-position="outside">
                                    <label for="ktp"><span style="color:red;"><i>Ekstensi Foto .jpg, .png, .jpeg, Maksimal 5000 KB</i></span></label>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-1">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox" required>
                                    </div>
                                </div>
                                <div class="col-11">
                                    <div class="form-check">
                                        <label for="checkbox">
                                            <p style="text-align: justify;">Dengan ini menyatakan bersedia bergabung menjadi anggota Partai Persatuan Pembangunan dan menaati aturan sesuai dengan AD/ART Partai, Setuju dan membaca Kebijakan Privacy Official Website DPC PPP Situbondo.
                                                <a href="#"><span>Baca Dahulu</span></a>
                                            </p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 inp-group text-center">
                                    <button type="submit" id="formSave">DAFTAR</button>
                                </div>
                            </div><?php // echo form_close(); 
                                    ?>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p>Copyright © 2022 DPC PPP SITUBONDO. Developed By Hosterweb.</p>
                    </div>
                </div>
            </div>
        </footer>

    </div>


    <script type="text/javascript" src="<?= base_url('assets/') ?>frontend/asset/js/jquery-1.11.0.min.js"></script>

    <script src="<?= base_url('assets/') ?>frontend/asset/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/') ?>frontend/asset/js/daterangepicker.js"></script>

    <script src="<?= base_url('assets/') ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url() ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="<?= base_url('assets/') ?>plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="<?= base_url('assets/') ?>plugins/sweetalert2/dist/scriptswal.js"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/css/dropify.min.js' ?>"></script>

    <script type="text/javascript">
        function ValidateSize(file) {
            var FileSize = file.files[0].size / 1024 / 1024; // in MB
            if (FileSize > 5) {
                alert('Maaf File anda terlalu besar');
                $(file).val(''); //for clearing with Jquery
            }
        }


        function Angkasaja(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        function cek_nik() {
            $("#spannik").hide();
            var nik = $("#nik").val().trim();
            $.ajax({
                url: "<?php echo base_url("index.php/Frontend/cek_nik"); ?>", //arahkan pada proses_tambah di controller member
                data: 'nik=' + nik,
                type: "POST",
                success: function(msg) {
                    if (msg == 1) {
                        $("#spannik").css("color", "#fc5d32");
                        $("#nik").css("border-color", "#fc5d32");
                        $("#spannik").html("NIK sudah terdaftar !");
                        $("#simpan").attr("disabled", "disabled");
                        $("#nik").val("");
                        error = 1;
                    } else {
                        $("#spannik").css("color", "#59c113");
                        $("#nik").css("border-color", "#59c113");
                        $("#spannik").html("");
                        $("#simpan").attr("disabled", false);

                        error = 0;
                    }

                    $("#spannik").fadeIn(1000);
                }
            });
        }

        $(document).ready(function() {
            
            $('.dropify').dropify({
            messages: {
                default: 'Drag atau drop untuk memilih gambar',
                replace: 'Ganti',
                remove: 'Hapus',
                error: 'error'

            }
        });
            $('.select2').select2();
            $(".hero-slider").owlCarousel({
                autoplayTimeout: 10000,
                pagination: true,
                navigation: true,
                singleItem: true,
                autoPlay: true,
                //timer
            });
            $('input[id="birthday"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY'), 10)
            }, function(start, end, label) {
                var years = moment().diff(start, 'years');
                $('input[name="umur"]').val(years);
            });

            $("#id_provinsi").change(function() { // Ketika user mengganti atau memilih data provinsi

                $.ajax({
                    type: "POST", // Method pengiriman data bisa dengan GET atau POST
                    url: "<?php echo base_url("index.php/Frontend/get_kota"); ?>", // Isi dengan url/path file php yang dituju
                    data: {
                        id_provinsi: $("#id_provinsi").val()
                    },
                    dataType: "json",
                    beforeSend: function(e) {
                        if (e && e.overrideMimeType) {
                            e.overrideMimeType("application/json;charset=UTF-8");
                        }
                    },
                    success: function(response) {
                        $("#id_kota").html(response.list_kota).show();
                    },
                    error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
                    }
                });
            });

            $("#id_kota").change(function() { // Ketika user mengganti atau memilih data provinsi

                $.ajax({
                    type: "POST", // Method pengiriman data bisa dengan GET atau POST
                    url: "<?php echo base_url("index.php/Frontend/get_kec"); ?>", // Isi dengan url/path file php yang dituju
                    data: {
                        id_kota: $("#id_kota").val()
                    }, // data yang akan dikirim ke file yang dituju
                    dataType: "json",
                    beforeSend: function(e) {
                        if (e && e.overrideMimeType) {
                            e.overrideMimeType("application/json;charset=UTF-8");
                        }
                    },
                    success: function(response) {
                        $("#id_kecamatan").html(response.list_kec).show();
                    },
                    error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
                    }
                });
            });

            $("#id_kecamatan").change(function() { // Ketika user mengganti atau memilih data provinsi

                $.ajax({
                    type: "POST", // Method pengiriman data bisa dengan GET atau POST
                    url: "<?php echo base_url("index.php/Frontend/get_kel"); ?>", // Isi dengan url/path file php yang dituju
                    data: {
                        id_kecamatan: $("#id_kecamatan").val()
                    }, // data yang akan dikirim ke file yang dituju
                    dataType: "json",
                    beforeSend: function(e) {
                        if (e && e.overrideMimeType) {
                            e.overrideMimeType("application/json;charset=UTF-8");
                        }
                    },
                    success: function(response) {
                        $("#id_kelurahan").html(response.list_kel).show();
                    },
                    error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
                    }
                });
            });

            $('#formID').on('submit', function(e) {
                e.preventDefault();
                $('#formSave').attr('disabled', 'disabled');
                Swal.fire({
                    title: '<h1>Mohon Tunggu Sebentar!</h1>',
                    html: '<h4>Data Sedang Kami Proses</h4>', // add html attribute if you want or remove
                    width: '500px',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
                var url = $(this).attr('action');
                var data = new FormData(this);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                title: 'Berhasil',
                                text: response.message,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.value) {
                                    window.location.href = '<?= base_url("form") ?>';
                                }
                            })
                        } else {
                            $.each(response.message, function(key, value) {
                                $('#' + key + 'Error').html(value);
                            });
                            $('#formSave').removeAttr('disabled');
                            Swal.fire({
                                title: 'Gagal',
                                text: 'Data Gagal Disimpan',
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            })
                        }

                    }
                });
            });

        });

        // $('#myform').on('submit', function(e) {
        // //     Swal.fire({
        // //         title: '<h1>Mohon Tunggu Sebentar!</h1>',
        // //         html: '<h4>Data Sedang Kami Proses</h4>', // add html attribute if you want or remove
        // //         width: '500px',
        // //         allowOutsideClick: false,
        // //         onBeforeOpen: () => {
        // //             Swal.showLoading()
        // //         },
        // //     });
        // });
    </script>
</body>

</html>