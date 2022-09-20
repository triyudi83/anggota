<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
  <h4 class="modal-title"><?= $modal_title ?></h4>
</div>
<form method="post" id="<?= $formID ?>">
  <div class="modal-body">
    <table class='table table-bordered'>
      <tr>
        <td width='200'>Nama </td>
        <td>
          <input type="text" name="nama" value="<?php echo ($this->input->post('nama') ? $this->input->post('nama') : $key->name); ?>" class="form-control" id="nama">
        </td>
      </tr>
      <tr>
        <td width='200'>Email</td>
        <td>
          <input type="email" name="email" value="<?php echo ($this->input->post('email') ? $this->input->post('email') : $key->email); ?>" class="form-control" id="email" readonly>
          <span class="text-danger" id="spanJabatana"></span>
        </td>
      </tr>
      <tr>
        <td width='200'>Password</td>
        <td>
          <input type="password" name="password" value="" class="form-control" id="password">
          <span class="text-danger">
            Kosongkan jika tidak ingin mengubah password
          </span>
        </td>
      </tr>
      <tr>
        <td width='200'>Level</td>
        <td>
          <select class="form-control select2" name="level" id="level" style="width:100%">
            <option value="">Pilih Level</option>
            <?php foreach ($role_user as $role) : ?>
              <option value="<?= $role->id ?>" <?= ($key->role_user == $role->id ? 'selected' : '') ?>> <?= $role->nama_role ?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>
      <tr>
        <td width='200'>Wilayah</td>
        <td>
          <select class="form-control select2" multiple="multiple" name="kecamatan[]" id="kec" style="width:100%" data-placeholder="Pilih Kecamatan">
              <option value="all" <?= ($key->kecamatan == 'all') ? 'selected' : '' ?>>Semua Kecamatan</option>
            <?php 
              $hasil = str_replace(',', ' ', $key->kecamatan);
              foreach ($kecamatan as $kec) : ?>
              <option value="<?= $kec->id_kecamatan ?>"
                <?php if (strpos($hasil, $kec->id_kecamatan) !== false) {
                  echo 'selected';
                } ?>
                ><?= $kec->kecamatan ?></option>

            <?php endforeach; ?>
          </select>
        </td>
      </tr>
      <tr>
        <td width='200'>Masa Aktif</td>
        <td>
          <input type="text" name="masa_aktif" value="<?= date('d-m-Y', strtotime($key->active)) ?>" class="form-control datepicker" id="masa_aktif">
        </td>
      </tr>
    </table>
  </div>
  <div class="modal-footer">
      <input type="hidden" name="id" value="<?= $key->id; ?>" id="id" required />
      <button type="submit" class="btn btn-info" id="simpana"><i class="fa fa-floppy-o"></i> Update </button>
      <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Kembali</button>
  </div>

</form>
<script type="text/javascript">
  $(function() {
    //Initialize Select2 Elements
    $('.select2').select2()
    $('.datepicker').datepicker({
      autoclose: true,
      //format
      format: 'dd-mm-yyyy'
    })
  
   $('#kec').change(function() {
    var kecamatan = $(this).val();
    var all = kecamatan[0];
    console.log(all);
    if(all == 'all'){
      $("#kec").html('<option value="all" selected>Semua Kecamatan</option>'+'<option value="3512010">SUMBERMALANG</option>'
+'<option value="3512020">JATIBANTENG</option>'
+'<option value="3512030">BANYUGLUGUR</option>'
+'<option value="3512040">BESUKI</option>'
+'<option value="3512050">SUBOH</option>'
+'<option value="3512060">MLANDINGAN</option>'
+'<option value="3512070">BUNGATAN</option>'
+'<option value="3512080">KENDIT</option>'
+'<option value="3512090">PANARUKAN</option>'
+'<option value="3512100">SITUBONDO</option>'
+'<option value="3512110">MANGARAN</option>'
+'<option value="3512120">PANJI</option>'
+'<option value="3512130">KAPONGAN</option>'
+'<option value="3512140">ARJASA</option>'
+'<option value="3512150">JANGKAR</option>'
+'<option value="3512160">ASEMBAGUS</option>'
+'<option value="3512170">BANYUPUTIH</option>');
    }
    
   });

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
          if ($.isEmptyObject(data.error)) {
            Swal.fire({
              title: 'Berhasil!',
              text: data.success,
              icon: 'success',
              timer: 1000
            })
            $('#modalView').modal('hide');
            setTimeout(function() {
              //window.location.href = data.url;
              location.reload();
            }, 1000);
          } else {
            $.each(data.error, function(key, value) {
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

  function cek_jabatanedit() {
    $("#spanJabatana").hide();
    var jabatan = $("#jabatana").val().trim();
    var id = $("#id_jabatan").val().trim();
    $.ajax({
      url: "<?php echo base_url("jabatan/cek_jabatanedit"); ?>", //arahkan pada proses_tambah di controller member
      data: {
        jabatan: jabatan,
        id: id
      },
      type: "POST",
      success: function(msg) {
        if (msg == 1) {
          $("#spanJabatana").css("color", "#fc5d32");
          $("#jabatan").css("border-color", "#fc5d32");
          $("#spanJabatana").html("jabatan Sudah Ada");
          $("#simpana").attr("disabled", "disabled");
          error = 1;
        } else {
          $("#spanJabatana").css("color", "#59c113");
          $("#jabatan").css("border-color", "#59c113");
          $("#spanJabatana").html("");
          $("#simpana").attr("disabled", false);

          error = 0;
        }

        $("#spanJabatana").fadeIn(1000);
      }
    });
  };
</script>