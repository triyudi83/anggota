<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      SIMBADA DPC PPP KAB. SITUBONDO
      <small>Sistem Informasi Basis Data</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Dashboard</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3> <?= count($baru) ?> </h3>

            <p>Calon Anggota</p>
          </div>
          <div class="icon">
            <i class="fa fa-user-plus"></i>
          </div>
          <a href="https://simbada.dpcpppsitubondo.or.id/anggota/register" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3><?php
                $a = count($aktif);
                $b = count($nonaktif);
                $c = $a + $b;
                echo $c;
                ?> </h3>
            <p>Jumlah Anggota</p>
          </div>
          <div class="icon">
            <i class="fa fa-users"></i>
          </div>
          <a href="https://simbada.dpcpppsitubondo.or.id/anggota/aktif" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-primary">
          <div class="inner">
            <h3> <?= count($aktif) ?> </h3>

            <p>Anggota Aktif</p>
          </div>
          <div class="icon">
            <i class="fa fa-user"></i>
          </div>
          <a href="https://simbada.dpcpppsitubondo.or.id/anggota/aktif" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3><?= count($nonaktif) ?> </h3>
            </h3>
            <p>Anggota Tidak Aktif</p>
          </div>
          <div class="icon">
            <i class="fa fa-user-times"></i>
          </div>
          <a href="https://simbada.dpcpppsitubondo.or.id/anggota/tidakaktif" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Data Anggota Tahun <?= date('Y') ?></h3>
          </div>
          <div class="box-body">
            <div class="chart">
              <canvas id="barChart" style="height: 320px; width: 710px;" height="320" width="710"></canvas>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Data Anggota Per Kecamatan</h3>
          </div>
          <div class="box-body">
            <div class="chart">
              <canvas id="myChart" style="height: 320px; width: 710px;" height="320" width="710"></canvas>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
      <div class="col-md-6">

        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Data Anggota Per Kecamatan Per Jenis Kelamin Laki - Laki</h3>
          </div>
          <div class="box-body">
            <div class="chart">
              <canvas id="myjk" style="height: 320px; width: 710px;" height="640" width="1420"></canvas>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
      <div class="col-md-6">

        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Data Anggota Per Kecamatan Per Jenis Kelamin Perempuan</h3>
          </div>
          <div class="box-body">
            <div class="chart">
              <canvas id="myjkp" style="height: 320px; width: 710px;" height="640" width="1420"></canvas>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.2/chart.min.js" integrity="sha512-zjlf0U0eJmSo1Le4/zcZI51ks5SjuQXkU0yOdsOBubjSmio9iCUp8XPLkEAADZNBdR9crRy3cniZ65LF2w8sRA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= base_url('assets/') ?>bower_components/fastclick/lib/fastclick.js"></script>
<script>
  const ctx = document.getElementById('myChart');
  const ctxjk = document.getElementById('myjk');
  const ctxjkp = document.getElementById('myjkp');
  const ctx2 = document.getElementById('barChart');
  const myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?= json_encode($kecamatan) ?>,
      datasets: [{
        label: 'Jumlah Anggota Per Kecamatan',
        data: <?= json_encode($diagram_batang) ?>,
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.4
      }]
    },
    options: {
      scales: {
            y: {
                suggestedMin: 1,
                suggestedMax: 5,
                beginAtZero: true
            }
        }
    }
  });

  const myChartjk = new Chart(ctxjk, {
    type: 'line',
    data: {
      labels: <?= json_encode($kecamatan) ?>,
      datasets: [{
          label: 'Jumlah Anggota Laki Laki ',
          data: <?= json_encode($diagram_laki) ?>,
          fill: false,
          borderColor: 'rgb(75, 192, 192)',
          tension: 0.4
        }

      ]
    },
    options: {
      scales: {
            y: {
                suggestedMin: 1,
                suggestedMax: 5,
                beginAtZero: true
            }
        }
    }
  });

  const myChartjkp = new Chart(ctxjkp, {
    type: 'line',
    data: {
      labels: <?= json_encode($kecamatan) ?>,
      datasets: [{
          label: 'Jumlah Anggota Perempuan',
          data: <?= json_encode($diagram_perempuan) ?>,
          fill: false,
          borderColor: 'rgb(255,20,147)',
          tension: 0.4
        }

      ]
    },
    options: {
      scales: {
            y: {
                suggestedMin: 1,
                suggestedMax: 5,
                beginAtZero: true
            }
        }
    }
  });

  const barChart = new Chart(ctx2, {
    type: 'bar',
    data: {
      datasets: [{
          label: 'Jumlah Anggota Aktif',
          data: <?= json_encode($diagram_aktif) ?>,
          backgroundColor: [
            'rgba(255, 99, 132)',
          ],
          borderWidth: 1,
        },
        {
          label: 'Jumlah Anggota Tidak Aktif',
          data: <?= json_encode($diagram_nonaktif) ?>,
          backgroundColor: [
            'rgba(54, 162, 235)',
          ],
          borderWidth: 1
        }

      ]

    },
    options: {
      scales: {
            y: {
                suggestedMin: 1,
                suggestedMax: 5,
                beginAtZero: true
            }
        }
    }
  });
</script>