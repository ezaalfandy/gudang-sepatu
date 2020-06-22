<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">shopping_cart</i>
                    </div>
                    <h4 class="card-title">Penjualan Terakhir</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="tablePenjualan">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Item</th>
                                            <th>Tanggal</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $n = 1;?>
                                            <?php foreach ($data_penjualan as $k => $v):?>
                                                <tr>
                                                    <td scope="row"><?= $n++?></td>
                                                    <td><?= $v->kode_order?></td>
                                                    <td><?= $v->barang?></td>
                                                    <td><?= $v->tanggal_penjualan_formatted?></td>
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

        var tablePenjualan = $('#tablePenjualan').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "columnDefs": [
                { "width": "40%", "targets": -2 }
            ],
            responsive: false
        });

    });
        
    function deletePenjualan($id_penjualan) {
        swal({
            title: 'Apakah Anda Yakin ?',
            text: "Data Penjualan akan dihapus dan tidak dapat dikembalikan !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-danger',
            cancelButtonClass: 'btn btn-default btn-link',
            confirmButtonText: 'Ya, Hapus',
            buttonsStyling: false
        }).then(function (result) {
            if (result.value === true) {
                window.location.href = "<?= base_url('admin-gudang/delete-penjualan/')?>" + $id_penjualan;
            }
        })
    }
</script>