<div class="container-fluid">
  <div class="row">
    <div class="col-lg-4">
      <div class="card card-chart">
        <div class="card-header card-header-rose" data-header-animation="false">
          <div class="ct-chart" id="barangHandOverKeluar"></div>
        </div>
        <div class="card-body">
          <h4 class="card-title">Barang Hand Over Keluar</h4>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">info</i> Hitungan berdasarkan jumlah barang keluar
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card card-chart">
        <div class="card-header card-header-success" data-header-animation="false">
          <div class="ct-chart" id="penjualanMingguIni"></div>
        </div>
        <div class="card-body">
          <h4 class="card-title">Barang Terjual</h4>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">info</i> Hitungan berdasarkan jumlah barang keluar
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card card-chart">
        <div class="card-header card-header-info" data-header-animation="false">
          <div class="ct-chart" id="preOrderMingguIni"></div>
        </div>
        <div class="card-body">
          <h4 class="card-title">Barang Pre Order Masuk</h4>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">info</i> Hitungan berdasarkan jumlah barang masuk
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-header card-header-icon card-header-rose">
          <div class="card-icon">
            <i class="material-icons">warning</i>
          </div>
          <h4 class="card-title ">Stok Hampir Habis</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="tableStokHampirHabis">
              <thead class=" text-primary">
                <tr>
                  <th>No</th>
                  <th>Barang</th>
                  <th>Stok<br>Tersedia</th>
                  <th>Stok<br>Minimal</th>
                </tr>
              </thead>
              <tbody>
                <?php $n = 1;?>
                <?php foreach ($data_barang_akan_habis as $k => $v):?>
                  <tr>
                    <td><?= $n++?></td>
                    <td><?= $v->kode_barang?></td>
                    <td><?= $v->jumlah_stok?></td>
                    <td><?= $v->alarm_stok_minimal?></td>
                  </tr>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="card">
        <div class="card-header card-header-icon card-header-success">
          <div class="card-icon">
            <i class="material-icons">thumb_up</i>
          </div>
          <h4 class="card-title ">Produk Terlaris Bulan ini</h4>
        </div>
        <div class="card-body">
          <div class="px-3">
            <table class="table table-striped" id="tableProdukTerlaris">
              <thead class=" text-primary">
                <tr>
                  <th>No</th>
                  <th>Barang</th>
                  <th>Jumlah</th>
                </tr>
              </thead>
              <tbody>
                <?php $n = 1;?>
                <?php foreach ($data_produk_terlaris_bulan_ini as $k => $v):?>
                  <tr>
                    <td><?= $n++?></td>
                    <td><?= $v->kode_barang?></td>
                    <td>
                      <?= $v->jumlah_barang_terjual?> 
                    </td>
                  </tr>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>

  $(document).ready(function () {
    var table_stok_hampir_habis = $('#tableStokHampirHabis').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      "columnDefs": [
        { "width": "10%", "targets": -1 }
      ],
      responsive: false
    });

    var table_produk_terlaris = $('#tableProdukTerlaris').DataTable({
      "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      "columnDefs": [
        { "width": "10%", "targets": -1 }
      ],
      responsive: true
    });
  });

  if ($('#penjualanMingguIni').length != 0 || $('#preOrderMingguIni').length != 0 || $('#barangHandOverKeluar').length != 0) {

    var responsiveOptions = [
      ['screen and (max-width: 640px)', {
        seriesBarDistance: 5,
        axisX: {
          labelInterpolationFnc: function (value) {
            return value[0];
          }
        }
      }]
    ];

    <?php if($data_grafik_penjualan_tujuh_hari != NULL):?>
      dataPenjualanMingguIni = {
        labels: <?= json_encode(array_column($data_grafik_penjualan_tujuh_hari, 'hari'))?>,
        series: [
          <?= json_encode(array_column($data_grafik_penjualan_tujuh_hari, 'jumlah'))?>
        ]
      };

      optionsPenjualanMingguIni = {
        lineSmooth: Chartist.Interpolation.cardinal({
          tension: 0
        }),
        low: 0,
        high: 1.3 * <?= max(array_column($data_grafik_penjualan_tujuh_hari, 'jumlah'))?>,
        chartPadding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0
        },
      }
      var penjualanMingguIni = new Chartist.Line('#penjualanMingguIni', dataPenjualanMingguIni, optionsPenjualanMingguIni);
      md.startAnimationForLineChart(penjualanMingguIni);
    <?php endif;?>


    
    <?php if($data_grafik_pre_order_tujuh_hari != NULL):?>
      dataPreOrderMingguIni = {
        labels: <?= json_encode(array_column($data_grafik_pre_order_tujuh_hari, 'hari'))?>,
        series: [
          <?= json_encode(array_column($data_grafik_pre_order_tujuh_hari, 'jumlah'))?>
        ]
      };

      optionsPreOrderMingguIni = {
        lineSmooth: Chartist.Interpolation.cardinal({
          tension: 0
        }),
        low: 0,
        high: 1.3 * <?= max(array_column($data_grafik_pre_order_tujuh_hari, 'jumlah'))?>,
        chartPadding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0
        }
      }

      var preOrderMingguIni = new Chartist.Line('#preOrderMingguIni', dataPreOrderMingguIni, optionsPreOrderMingguIni);
      md.startAnimationForLineChart(preOrderMingguIni);
    <?php endif;?>

    
    <?php if($data_grafik_hand_over_tujuh_hari != NULL):?>
      var dataBarangHandOverKeluar = {
        labels: <?= json_encode(array_column($data_grafik_hand_over_tujuh_hari, 'hari'))?>,
        series: [
          <?= json_encode(array_column($data_grafik_hand_over_tujuh_hari, 'jumlah'))?>,
        ]
      };

      var optionsBarangHandOverKeluar = {
        axisX: {
          showGrid: false
        },
        low: 0,
        high: 1.3 * <?= max(array_column($data_grafik_hand_over_tujuh_hari, 'jumlah'))?>,
        chartPadding: {
          top: 0,
          right: 5,
          bottom: 0,
          left: 0
        }
      };

      var barangHandOverKeluar = Chartist.Bar('#barangHandOverKeluar', dataBarangHandOverKeluar, optionsBarangHandOverKeluar, responsiveOptions);
      md.startAnimationForBarChart(barangHandOverKeluar);
    <?php endif;?>
  }
</script>