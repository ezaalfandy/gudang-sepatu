<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header card-header-icon card-header-primary">
          <div class="card-icon">
            <i class="material-icons">assessment</i>
          </div>
          <h4 class="card-title ">Hasil Pencarian Untuk <?= $data_search_string?></h4>
        </div>
        <div class="card-body">
          <?php if($data_barang == NULL):?>
            <p class="h4 my-4">Tidak ada hasil ditemukan</p>
          <?php else:?>
            <div class="table-responsive pb-5">
              <table class="table table-striped" id="tableBarang">
                <thead>
                  <tr>
                    <td>No</td>
                    <td>Kode Barang</td>
                    <td>Merek</td>
                    <td>Tipe</td>
                    <td>Warna</td>
                    <td>Ukuran</td>
                    <td>Jumlah Stok</td>
                    <td data-priority="1">Aksi</td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($data_barang as $k_barang => $v_barang):?>
                  <tr <?= ($v_barang->jumlah_stok < $v_barang->alarm_stok_minimal)? 'class="table-danger"': '' ?>>
                    <td></td>
                    <td><?= $v_barang->kode_barang?></td>
                    <td><?= $v_barang->merek?></td>
                    <td><?= $v_barang->tipe?></td>
                    <td><?= $v_barang->warna?></td>
                    <td><?= $v_barang->ukuran?></td>
                    <td><?= $v_barang->jumlah_stok?></td>
                    <td>
                      <div class="row">
                        <div class="col-md-12 px-1">
                          <a class="btn btn-primary btn-sm btn-block"
                            href="<?= base_url('asisten-manager-gudang/view-detail-barang/').$v_barang->kode_barang?>">
                            <i class="material-icons">
                              search
                            </i> Detail
                          </a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </div>
          <?php endif;?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    var t_barang = $('#tableBarang').DataTable({
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

    t_barang.on('order.dt search.dt', function () {
      t_barang.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();

    t_barang.on('responsive-resize', function (e, datatable, columns) {
      var count = columns.reduce(function (a, b) {
        return b === false ? a + 1 : a;
      }, 0);
    });

  });

</script>