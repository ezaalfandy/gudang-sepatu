<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">person</i>
                            </div>
                            <h4 class="card-title">
                                <?= $data_supplier->kode_supplier.' - '.$data_supplier->nama_supplier.' ('.$data_supplier->telepon_supplier.')'?>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-sales">
                                <table class="table table-bordered table-striped table-hover" id="tablePreOrder">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Tanggal terbit</th>
                                            <th>Tanggal Setor</th>
                                            <th>Total Harga</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $n= 1;?>
                                        <?php foreach ($data_pre_order as $key => $value):?>
                                        <tr>
                                            <td>
                                                <?= $n++;?>
                                            </td>
                                            <td>
                                                <?= $value->kode_pre_order?>
                                            </td>
                                            <td>
                                                <?= $value->tanggal_dibuat_formatted?>
                                            </td>
                                            <td>
                                                <?= $value->tanggal_setor_formatted?>
                                            </td>
                                            <td>
                                                <?= number_format($value->total_harga, 0, ".", ".")?>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-block btn-sm"
                                                    href="<?= base_url('asisten-manager-gudang/view-detail-pre-order/'.$value->kode_pre_order)?>"
                                                    target="_blank">
                                                    Cek Pre Order
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
                        <div class="card-header card-header-info" data-header-animation="false">
                            <div class="ct-chart" id="preOrder"></div>
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
</div>

<script>
    $(document).ready(function () {
        var tablePreOrder = $('#tablePreOrder').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "columnDefs": [
                { "width": "20%", "targets": -1 }
            ],
            responsive: false
        });
        tablePreOrder.on('order.dt search.dt', function () {
            tablePreOrder.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
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

    if( $('#preOrder').length != 0) {
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

        <?php if($data_grafik_pre_order != NULL):?>
            dataPreOrder = {
                labels: <?= json_encode(array_column($data_grafik_pre_order, 'hari')) ?>,
                    series: [
                    <?= json_encode(array_column($data_grafik_pre_order, 'jumlah')) ?>
                    ]
            };

            optionsPreOrder = {
                lineSmooth: Chartist.Interpolation.cardinal({
                    tension: 0
                }),
                low: 0,
                high: 1.3 * <?= max(array_column($data_grafik_pre_order, 'jumlah')) ?>,
                chartPadding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                }
            }

            var preOrder = new Chartist.Line('#preOrder', dataPreOrder, optionsPreOrder);
            md.startAnimationForLineChart(preOrder);
        <?php endif;?>
    }
</script>