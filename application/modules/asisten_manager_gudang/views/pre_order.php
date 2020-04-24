<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <?php
        if($this->session->flashdata('status') === 'success'){
          echo '
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="material-icons">close</i>
              </button>
              <span>
                <b> Success - </b> '.$this->session->userdata('message').'</span>
            </div>
          ';
        }elseif ($this->session->flashdata('status') === 'failed') {
          echo '
            <div class="alert alert-danger">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="material-icons">close</i>
              </button>
              <span>
                <b> Danger - </b> '.$this->session->userdata('message').'</span>
            </div>
          ';
        }
      ?>
    </div>
    <div class="col-md-12 col-lg-12">
      <div class="card">
        <div class="card-header card-header-icon card-header-info">
          <div class="card-icon">
            <i class="material-icons">insert_drive_file</i>
          </div>
          <h4 class="card-title ">Pre Order On Proses</h4>
        </div>
        <div class="card-body">
          <div class="col-lg-3 offset-lg-9">
            <a class="btn btn-primary btn-block my-4" href="<?= base_url('asisten-manager-gudang/view-insert-pre-order')?>">
              <i class="material-icons">add</i>
              Tambah
            </a>
          </div>
          <div class="table-responsive pb-5">
            <table class="table table-striped tablePreOrder">
              <thead>
                <tr>
                  <td>No</td>
                  <td>kode_pre_order</td>
                  <td>Supplier</td>
                  <td>Gudang Tujuan</td>
                  <td>Tanggal Terbit</td>
                  <td>Aksi</td>
                  <td>Print</td>
                </tr>
              </thead>
              <tbody>
                <?php $n = 1;?>
                <?php foreach($data_pre_order as $k_pre_order => $v_pre_order):?>
                  <?php if($v_pre_order->status_pre_order == 'diproses'):?>

                    <tr>
                      <td><?= $n++?></td>
                      <td><?= $v_pre_order->kode_pre_order?></td>
                      <td><?= $v_pre_order->kode_supplier.' - '.$v_pre_order->nama_supplier.' ('.$v_pre_order->telepon_supplier.')'?></td>
                      <td><?= $v_pre_order->kode_gudang.' <br> '.$v_pre_order->alamat.', '.$v_pre_order->kabupaten_kota.' <br> '.$v_pre_order->provinsi.' ('.$v_pre_order->kode_pos.')'?></td>
                      <td><?= $v_pre_order->tanggal_dibuat_formatted?></td>
                      <td>
                        <div class="row">
                          <div class="col-md-12">
                            <a class="btn btn-success btn-sm btn-block" href="<?= base_url('asisten-manager-gudang/view-terima-pre-order/').$v_pre_order->kode_pre_order?>">
                              Terima
                            </a>
                          </div>
                          <div class="col-md-12">
                            <a class="btn btn-info btn-sm btn-block" href="<?= base_url('asisten-manager-gudang/view-edit-pre-order/').$v_pre_order->kode_pre_order?>">
                              Edit
                            </a>
                          </div>
                          <div class="col-md-12">
                            <button class="btn btn-danger btn-sm btn-block" onclick="deletePreOrder(<?= $v_pre_order->id_pre_order?>)">
                              Hapus
                            </button>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="row">
                          <div class="col-md-12">
                            <a class="btn btn-primary btn-sm btn-block" target="_blank" href="<?= base_url('asisten-manager-gudang/cetak-pre-order/').$v_pre_order->id_pre_order?>">
                              <i class="material-icons">
                                print
                              </i> Surat
                            </a>
                          </div>
                          <div class="col-md-12">
                            <a class="btn btn-warning btn-sm btn-block" target="_blank" href="<?= base_url('asisten-manager-gudang/cetak-barcode-pre-order/').$v_pre_order->id_pre_order?>">
                              <i class="material-icons">
                                print
                              </i> Barcode
                            </a>
                          </div>
                        </div>
                      </td>
                    </tr>

                  <?php endif?>
                <?php endforeach;?>
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 col-lg-12">
      <div class="card">
        <div class="card-header card-header-icon card-header-success">
          <div class="card-icon">
            <i class="material-icons">insert_drive_file</i>
          </div>
          <h4 class="card-title ">Pre Order Diterima</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive pb-5">
            <table class="table table-striped tablePreOrder">
              <thead>
                <tr>
                  <td>No</td>
                  <td>kode_pre_order</td>
                  <td>Supplier</td>
                  <td>Gudang Tujuan</td>
                  <td>Tanggal Terbit</td>
                  <td>Aksi</td>
                  <td>Print</td>
                </tr>
              </thead>
              <tbody>
                <?php $n = 1;?>
                <?php foreach($data_pre_order as $k_pre_order => $v_pre_order):?>
                  <?php if($v_pre_order->status_pre_order == 'diterima'):?>
                    <tr>
                      <td><?= $n++?></td>
                      <td><?= $v_pre_order->kode_pre_order?></td>
                      <td><?= $v_pre_order->kode_supplier.' - '.$v_pre_order->nama_supplier.' ('.$v_pre_order->telepon_supplier.')'?></td>
                      <td><?= $v_pre_order->kode_gudang.' <br> '.$v_pre_order->alamat.', '.$v_pre_order->kabupaten_kota.' <br> '.$v_pre_order->provinsi.' ('.$v_pre_order->kode_pos.')'?></td>
                      <td><?= $v_pre_order->tanggal_dibuat_formatted?></td>
                      <td>
                        <div class="row">
                          <div class="col-md-12">
                            <button class="btn btn-danger btn-sm btn-block" onclick="deletePreOrder(<?= $v_pre_order->id_pre_order?>)">
                              Hapus
                            </button>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="row">
                          <div class="col-md-12">
                            <a class="btn btn-primary btn-sm btn-block" target="_blank" href="<?= base_url('asisten-manager-gudang/cetak-pre-order/').$v_pre_order->id_pre_order?>">
                              <i class="material-icons">
                                print
                              </i> Surat
                            </a>
                          </div>
                          <div class="col-md-12">
                            <a class="btn btn-warning btn-sm btn-block" target="_blank" href="<?= base_url('asisten-manager-gudang/cetak-barcode-pre-order/').$v_pre_order->id_pre_order?>">
                              <i class="material-icons">
                                print
                              </i> Barcode
                            </a>
                          </div>
                        </div>
                      </td>
                    </tr>

                  <?php endif?>
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
  <?php
    $gudang_lookup = [];
    foreach ($data_gudang as $k => $v) {
      $gudang_lookup[] = array(
        "value" => $v->kode_gudang.' - '.$v->kabupaten_kota,
        "code" => $v->id_gudang
      );
    }
    
    $supplier_lookup = [];
    foreach ($data_supplier as $k => $v) {
      $supplier_lookup[] = array(
        "value" => $v->nama_supplier.' - '.$v->alamat_supplier,
        "code" => $v->id_supplier
      );
    }

    $barang_lookup = [];
    foreach ($data_barang as $k => $v) {
      $barang_lookup[] = array(
        "value" => $v->merek.'  '.$v->tipe.'  '.$v->warna.'  '.$v->ukuran.' ('.$v->kode_barang.')',
        "code" => $v->id_barang
      );
    }

  ?>

  $gudang = JSON.parse('<?= json_encode($gudang_lookup);?>');
  $supplier = JSON.parse('<?= json_encode($supplier_lookup);?>');
  $barang = JSON.parse('<?= json_encode($barang_lookup);?>');
  
  $(document).ready(function () {

    var table_pre_order = $('.tablePreOrder').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      "columnDefs": [
        { "width": "10%", "targets": -1 },
        { "width": "10%", "targets": -2 }
      ],
      responsive: false
    });
    
    md.setInputAutoComplete('#autocomplete_insert_pre_order_id_gudang_tujuan', $gudang);
    md.setInputAutoComplete('#autocomplete_insert_pre_order_id_supplier', $supplier);
    md.setInputAutoComplete('[name="autocomplete_insert_id_barang[0]"]', $barang);

    $('#formInsertPreOrder').validate();
    $('#formEditPreOrder').validate();
  });

  function deletePreOrder($id_pre_order) {
    swal({
      title: 'Apakah Anda Yakin ?',
      text: "Data Pre Order akan dihapus dan tidak dapat dikembalikan !",
      type: 'warning',
      showCancelButton: true,
      confirmButtonClass: 'btn btn-danger',
      cancelButtonClass: 'btn btn-default btn-link',
      confirmButtonText: 'Ya, Hapus',
      buttonsStyling: false
    }).then(function (result) {
      if (result.value === true) {
        window.location.href = "<?= base_url('asisten-manager-gudang/delete-pre-order/')?>" + $id_pre_order;
      }
    })
  }

  function terimaPreOrder($id_pre_order) {
    swal({
      title: 'Apakah Anda Yakin ?',
      text: "Data Pre Order akan diterima, pastikan sudah melakukan pengecakan terlebih dahulu !",
      type: 'info',
      showCancelButton: true,
      confirmButtonClass: 'btn btn-info',
      cancelButtonClass: 'btn btn-default btn-link',
      confirmButtonText: 'Ya, Terima',
      buttonsStyling: false
    }).then(function (result) {
      if (result.value === true) {
        window.location.href = "<?= base_url('asisten-manager-gudang/terima-pre-order/')?>" + $id_pre_order;
      }
    })
  }

  function openModalPreOrder($id_pre_order) {
    $.getJSON("<?= base_url('asisten-manager-gudang/get-specificpre-order/')?>" + $id_pre_order,
      function (data, textStatus, jqXHR) {
        $('#formEditPreOrder [name="edit_id_pre_order"]').val(data.id_pre_order);
        $('#formEditPreOrder [name="edit_id_admin"]').val(data.id_admin);
        $('#formEditPreOrder [name="edit_id_gudang_tujuan"]').val(data.id_gudang_tujuan);
        $('#formEditPreOrder [name="edit_kode_pre_order"]').val(data.kode_pre_order);
        $('#modalEditPreOrder').modal('show');
      }
    );
  }
</script>