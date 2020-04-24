<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">assessment</i>
                            </div>
                            <h4 class="card-title">
                                <?= $data_gudang->kode_gudang.' '.$data_gudang->kabupaten_kota.' ('.$data_gudang->nomor_telepon.')'?>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-sales">
                                <table class="table table-bordered table-striped table-hover tableStokBarang">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Barang</th>
                                            <th>Nama</th>
                                            <th>Stok</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $n= 1;?>
                                        <?php foreach ($data_stok_barang as $key => $value):?>
                                        <tr
                                            <?= ($value->jumlah_stok < $value->alarm_stok_minimal)? 'class="table-danger"' : '' ?>>
                                            <td>
                                                <?= $n++;?>
                                            </td>
                                            <td>
                                                <?= $value->kode_barang?>
                                            </td>
                                            <td>
                                                <?= $value->merek.' Tipe '.$value->tipe.' - '.$value->warna.' ukuran '.$value->ukuran?>
                                            </td>
                                            <td>
                                                <?= $value->jumlah_stok?>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-block btn-sm"
                                                    href="<?= base_url('asisten-manager-gudang/view-detail-barang/'.$value->kode_barang)?>"
                                                    target="_blank">
                                                    Cek barang
                                                </a>
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
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
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
                <div class="col-lg-12">
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
                <div class="col-lg-12">
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
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
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
                                    <th>Gudang</th>
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
                                    <td>
                                        <?= $v->kode_gudang.', '.$v->kabupaten_kota.' '.$v->provinsi.' ('.$v->nomor_telepon.')'?>
                                    </td>
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
        <div class="col-lg-4">
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
        var tableStokBarang = $('.tableStokBarang').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "columnDefs": [
                { "width": "20%", "targets": -1 }
            ],
            responsive: false
        });
        tableStokBarang.on('order.dt search.dt', function () {
            tableStokBarang.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        
        var tableStokHampirHabis = $('#tableStokHampirHabis').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "columnDefs": [
                { "width": "20%", "targets": -1 }
            ],
            responsive: false
        });
        tableStokHampirHabis.on('order.dt search.dt', function () {
            tableStokHampirHabis.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
        
        var tableProdukTerlaris = $('#tableProdukTerlaris').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "columnDefs": [
                { "width": "20%", "targets": -1 }
            ],
            responsive: false
        });
        tableProdukTerlaris.on('order.dt search.dt', function () {
            tableProdukTerlaris.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });

    if($('#penjualanMingguIni').length != 0 || $('#preOrderMingguIni').length != 0 || $('#barangHandOverKeluar').length != 0) {
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
            labels: <?= json_encode(array_column($data_grafik_penjualan_tujuh_hari, 'hari')) ?>,
                series: [
                <?= json_encode(array_column($data_grafik_penjualan_tujuh_hari, 'jumlah')) ?>
                ]
        };

        optionsPenjualanMingguIni = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: 1.3 * <?= max(array_column($data_grafik_penjualan_tujuh_hari, 'jumlah')) ?>,
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
                labels: <?= json_encode(array_column($data_grafik_pre_order_tujuh_hari, 'hari')) ?>,
                    series: [
                    <?= json_encode(array_column($data_grafik_pre_order_tujuh_hari, 'jumlah')) ?>
                    ]
            };

            optionsPreOrderMingguIni = {
                lineSmooth: Chartist.Interpolation.cardinal({
                    tension: 0
                }),
                low: 0,
                high: 1.3 * <?= max(array_column($data_grafik_pre_order_tujuh_hari, 'jumlah')) ?>,
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
                labels: <?= json_encode(array_column($data_grafik_hand_over_tujuh_hari, 'hari')) ?>,
                series: [
                    <?= json_encode(array_column($data_grafik_hand_over_tujuh_hari, 'jumlah')) ?>,
                ]
            };

            var optionsBarangHandOverKeluar = {
                axisX: {
                    showGrid: false
                },
                low: 0,
                high: 1.3 * <?= max(array_column($data_grafik_hand_over_tujuh_hari, 'jumlah')) ?>,
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