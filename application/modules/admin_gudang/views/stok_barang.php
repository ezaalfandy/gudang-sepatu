<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-danger card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">assessment</i>
                    </div>
                    <h4 class="card-title"><?= $data_gudang->kode_gudang.' '.$data_gudang->kabupaten_kota.' ('.$data_gudang->nomor_telepon.')'?></h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive table-sales">
                                <table class="table table-bordered table-striped table-hover tableStokBarang">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Barang</th>
                                            <th>Nama</th>
                                            <th>Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $n= 1;?>
                                        <?php foreach ($data_stok_barang as $key => $value):?>
                                            <tr>   
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
    </div>
</div>

<script>
    $(document).ready(function () {
        var tableStokBarang = $('.tableStokBarang').DataTable({
            "pagingType": "full_numbers",
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
    });
</script>