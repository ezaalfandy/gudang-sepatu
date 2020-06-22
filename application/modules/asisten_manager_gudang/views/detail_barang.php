<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-product">
                        <div class="card-header card-header-image img-raised">
                            
                            <div id="carouselGambarBarang" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <?php
                                        for ($i=0; $i < count($data_gambar_barang); $i++) 
                                        {
                                            if($i == 0)
                                            {
                                                echo '<li data-target="#carouselGambarBarang" data-slide-to="0" class="active"></li>';
                                            }else
                                            {
                                                echo '<li data-target="#carouselGambarBarang" data-slide-to="'.$i.'"></li>';
                                            }
                                        }
                                    ?>
                                </ol>
                                <div class="carousel-inner" role="listbox">
                                    <?php
                                        for ($i=0; $i < count($data_gambar_barang); $i++) 
                                        {
                                            if($i == 0)
                                            {   
                                                echo '
                                                    <div class="carousel-item active">
                                                        <img src="'.base_url('uploads/barang/').$data_gambar_barang[$i]->nama_file.'" alt="'.$i.'slide" class="img-fluid">
                                                    </div>
                                                ';
                                            }else
                                            {
                                                echo '
                                                    <div class="carousel-item">
                                                        <img src="'.base_url('uploads/barang/').$data_gambar_barang[$i]->nama_file.'" alt="'.$i.'slide"  class="img-fluid">
                                                    </div>
                                                ';
                                            }
                                        }
                                    ?>
                                </div>
                                <a class="carousel-control-prev" href="#carouselGambarBarang" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselGambarBarang" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title font-weight-bold mt-3">
                                <?= $data_barang->kode_barang?>
                            </h4>
                            <div class="card-description mb-3">
                                Daftar Varian Sejenis
                            </div>
                            <table class="table table-striped table-hover" id="tableProdukSejenis">
                                <thead>
                                    <tr>
                                        <th>Warna</th>
                                        <th>Ukuran</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data_barang_sejenis as $k => $v):?>
                                        <tr>
                                            <td>
                                                <u>
                                                    <a href="<?= base_url('asisten-manager-gudang/view-detail-barang/').$v->kode_barang?>"
                                                    >    
                                                        <?= $v->warna?>
                                                    </a>
                                                </u>
                                            </td>
                                            <td><?= $v->ukuran?></td>
                                            <td><?= $v->stok_tersedia?></td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#modalCetakBarcode">Cetak barcode</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">assessment</i>
                            </div>
                            <h4 class="card-title">
                                <?= $data_barang->merek.' '.$data_barang->tipe.' '.$data_barang->warna.' '.$data_barang->ukuran?>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-sales">
                                        <table class="table table-bordered table-striped table-hover" id="tableBarang">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        No
                                                    </th>
                                                    <th>
                                                        Gudang
                                                    </th>
                                                    <th>
                                                        Stok
                                                    </th>
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
                                                        <?= $value->kode_gudang.' - '.$value->alamat.', '.$value->kabupaten_kota.' '.$value->provinsi.' ('.$value->nomor_telepon.')'?>
                                                    </td>
                                                    <td class="text-right">
                                                        <?= $value->jumlah_stok?>
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
                <div class="col-lg-12">
                    <div class="card card-chart">
                        <div class="card-header card-header-success" data-header-animation="false">
                            <div class="ct-chart" id="penjualanBulanIni"></div>
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
                            <div class="ct-chart" id="preOrderBulanIni"></div>
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
        </div>
    </div>
    <div class="row">                          
        <div class="col-lg-12">
            <h4 class="font-weight-bold mt-5">Data Penjualan Produk Tipe <?= $data_barang->merek.' '.$data_barang->tipe?> (All Warna & Ukuran)</h4>
        </div>
        <div class="col-lg-8">             
                  
            <div class="card card-chart">
                <div class="card-header card-header-icon card-header-danger">
                    <div class="card-icon">
                        <i class="material-icons">pie_chart</i>
                    </div>
                    <h4 class="card-title">Penjualan semua varian warna dan ukuran</h4>
                </div>
                <div class="card-body py-5">
                    <div class="ct-chart" id="penjualanSemuaVarian"></div>
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
                <div class="card-header card-header-icon card-header-danger">
                    <div class="card-icon">
                        <i class="material-icons">pie_chart</i>
                    </div>
                    <h4 class="card-title">Presentase Ukuran</h4>
                </div>
                <div class="card-body py-3">
                    <div id="penjualanBerdasarkanUkuran" class="ct-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCetakBarcode" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('asisten-manager-gudang/cetak-barcode-by-kode-barang/')?>" method="get" target="_blank" role="form" novalidate="novalidate" id="formCetakBarcode" class="m-0">
                <div class="modal-header">
                    <h5 class="modal-title">Cetak Barcode</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="kode_barang" value="<?= $data_barang->kode_barang?>"/>
                        <label for="insert_jumlah_barcode">Jumlah Barcode</label>
                        <input type="number" name="jumlah_barcode" value=" " id="insert_jumlah_barcode"
                            class="form-control" required="true" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="Submit" class="btn btn-primary">Print</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        
        md.setFormValidation($('#formCetakBarcode'));
        var tableBarang = $('#tableBarang').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: false
        });

        var tableProdukSejenis = $('#tableProdukSejenis').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "order": [[ 0, 'asc' ], [ 1, 'asc' ]],
            responsive: false
        });
    });
      

    if ($('#penjualanBulanIni').length != 0 || $('#preOrderBulanIni').length != 0 || $('#PenjualanAllVarianWarna').length != 0) {

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
            datapenjualanBulanIni = {
                labels: <?= json_encode(array_column($data_grafik_penjualan_tujuh_hari, 'tanggal_bulan'))?>,
                series: [
                <?= json_encode(array_column($data_grafik_penjualan_tujuh_hari, 'jumlah'))?>
                ]
            };

            optionspenjualanBulanIni = {
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
            var penjualanBulanIni = new Chartist.Line('#penjualanBulanIni', datapenjualanBulanIni, optionspenjualanBulanIni);
            md.startAnimationForLineChart(penjualanBulanIni);
        <?php endif;?>

        <?php if($data_grafik_pre_order_tujuh_hari != NULL):?>
            datapreOrderBulanIni = {
                labels: <?= json_encode(array_column($data_grafik_pre_order_tujuh_hari, 'tanggal_bulan'))?>,
                series: [
                    <?= json_encode(array_column($data_grafik_pre_order_tujuh_hari, 'jumlah'))?>
                ]
            };

            optionspreOrderBulanIni = {
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

            var preOrderBulanIni = new Chartist.Line('#preOrderBulanIni', datapreOrderBulanIni, optionspreOrderBulanIni);
            md.startAnimationForLineChart(preOrderBulanIni);
        <?php endif;?>

        <?php if($data_grafik_penjualan_all_varian !== NULL):?>
        
            datapenjualanSemuaVarian = {
                labels: <?= json_encode(array_column($data_grafik_penjualan_all_varian, 'tanggal_bulan'))?>,
                series: [
                <?= json_encode(array_column($data_grafik_penjualan_all_varian, 'jumlah'))?>
                ]
            };

            optionspenjualanSemuaVarian = {
                lineSmooth: Chartist.Interpolation.cardinal({
                    tension: 0
                }),
                low: 0,
                high: 1.3 * <?= max(array_column($data_grafik_penjualan_all_varian, 'jumlah'))?>,
                chartPadding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                },
            }
            var penjualanSemuaVarian = new Chartist.Line('#penjualanSemuaVarian', datapenjualanSemuaVarian, optionspenjualanSemuaVarian);
            md.startAnimationForLineChart(penjualanSemuaVarian);
        <?php endif?>

        <?php if($data_grafik_penjualan_berdasarkan_ukuran !== NULL):?>

            $pie_series = <?= json_encode(array_column($data_grafik_penjualan_berdasarkan_ukuran, 'jumlah'))?>;
            $.each($pie_series, function (i, v) { 
                 $pie_series[i] = parseInt(v);
            });
            var dataPenjualanBerdasarkanUkuran = {
                labels: <?= json_encode(array_column($data_grafik_penjualan_berdasarkan_ukuran, 'ukuran'))?>,
                series: [1, 2]
            };
            
            var optionsPenjualanBerdasarkanUkuran = {
                height: '230px',
                labelInterpolationFnc: function(value) {
                    return value[0]
                }
            };

            var responsiveOptions = [
                ['screen and (min-width: 640px)', {
                    chartPadding: 30,
                    labelOffset: 75,
                    labelDirection: 'explode',
                    labelInterpolationFnc: function(value) {
                        return value;
                    }
                }],
                ['screen and (min-width: 1024px)', {
                    labelOffset: 60,
                    chartPadding: 20
                }]
            ];
            Chartist.Pie('#penjualanBerdasarkanUkuran', dataPenjualanBerdasarkanUkuran, optionsPenjualanBerdasarkanUkuran, responsiveOptions);

        <?php endif?>

    }
</script>