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
        <div class="card-header card-header-icon card-header-danger">
          <div class="card-icon">
            <i class="material-icons">insert_drive_file</i>
          </div>
          <h4 class="card-title ">Pre Order On Proses</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive pb-5">
            <table class="table table-striped tablePreOrder">
              <thead>
                <tr>
                  <td>No</td>
                  <td>kode_pre_order</td>
                  <td>Supplier</td>
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
                        <td><?= $v_pre_order->tanggal_dibuat_formatted?></td>
                        <td>
                            <div class="row">
                                <div class="col-md-12">
                                  <button class="btn btn-success btn-sm btn-block" onclick="terimaPreOrder(<?= $v_pre_order->id_pre_order?>)">
                                    Terima
                                  </button>
                                </div>
                                <div class="col-md-12">
                                    <a class="btn btn-info btn-sm btn-block" href="<?= base_url('admin-gudang/view-detail-pre-order/').$v_pre_order->kode_pre_order?>">
                                        <i class="material-icons">
                                            search
                                        </i> Lihat
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="row">
                              <div class="col-md-12">
                                  <a class="btn btn-primary btn-sm btn-block" target="_blank" href="<?= base_url('admin-gudang/cetak-pre-order/').$v_pre_order->id_pre_order?>">
                                      <i class="material-icons">
                                          print
                                      </i> Surat
                                  </a>
                              </div>
                              <div class="col-md-12">
                                  <a class="btn btn-warning btn-sm btn-block" target="_blank" href="<?= base_url('admin-gudang/cetak-barcode-pre-order/').$v_pre_order->id_pre_order?>">
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
                      <td><?= $v_pre_order->tanggal_dibuat_formatted?></td>
                      <td>
                        <div class="row">
                          <div class="col-md-12">
                            <a class="btn btn-info btn-sm btn-block" href="<?= base_url('admin-gudang/view-detail-pre-order/').$v_pre_order->kode_pre_order?>">
                              <i class="material-icons">
                                search
                              </i> Lihat
                            </a>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="row">
                          <div class="col-md-12">
                            <a class="btn btn-primary btn-sm btn-block" target="_blank" href="<?= base_url('admin-gudang/cetak-pre-order/').$v_pre_order->id_pre_order?>">
                              <i class="material-icons">
                                print
                              </i> Surat
                            </a>
                          </div>
                          <div class="col-md-12">
                            <a class="btn btn-warning btn-sm btn-block" target="_blank" href="<?= base_url('admin-gudang/cetak-barcode-pre-order/').$v_pre_order->id_pre_order?>">
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
  });

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
        window.location.href = "<?= base_url('admin-gudang/terima-pre-order/')?>" + $id_pre_order;
      }
    })
  }
</script>