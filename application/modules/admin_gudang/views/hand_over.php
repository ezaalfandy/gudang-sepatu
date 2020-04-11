<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <?php
        if($this->session->flashdata('status') == 'success')
        {
          echo '
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="material-icons">close</i>
              </button>
              <span>
                <b> Success - </b> '.$this->session->userdata('message').'</span>
            </div>
          ';
        }elseif ($this->session->flashdata('status') == 'failed') {
          echo '
            <div class="alert alert-danger">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="material-icons">close</i>
              </button>
              <span>
                <b> Failed - </b> '.$this->session->userdata('message').'</span>
            </div>
          ';
        }
      ?>
    </div>
    <div class="col-md-12 col-lg-12">
      <div class="card">
        <div class="card-header card-header-icon card-header-primary">
          <div class="card-icon">
            <i class="material-icons">insert_drive_file</i>
          </div>
          <h4 class="card-title ">Data Hand Over On Proses</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive pb-5">
            <table class="table table-striped table-hovered tableHandOver">
              <thead>
                <tr>
                  <td>No</td>
                  <td>kode_hand_over</td>
                  <td>Gudang Asal</td>
                  <td>Gudang Tujuan</td>
                  <td>Tanggal Terbit</td>
                  <td>Aksi</td>
                </tr>
              </thead>
              <tbody>
                <?php foreach($data_hand_over as $k_hand_over => $v_hand_over):?>
                  <?php if($v_hand_over->status_hand_over == 'diproses'):?>
                    <tr>
                      <td></td>
                      <td><?= $v_hand_over->kode_hand_over?></td>
                      <td><?= $v_hand_over->gudang_asal?></td>
                      <td><?= $v_hand_over->gudang_tujuan?></td>
                      <td><?= $v_hand_over->tanggal_dibuat_formatted?></td>
                      <td>
                        <div class="row">
                            <?php if($v_hand_over->id_gudang_asal != $this->session->userdata('id_gudang')):?>
                                <div class="col-md-12 px-1">
                                    <button class="btn btn-success btn-sm btn-block" onclick="terimaHandOver(<?= $v_hand_over->id_hand_over?>)">
                                    Terima
                                    </button>
                                </div>
                            <?php endif;?>
                            <div class="col-md-12 px-1">
                                <a class="btn btn-primary btn-sm btn-block" target="_blank" href="<?= base_url('admin-gudang/cetak-hand-over/').$v_hand_over->id_hand_over?>">
                                <i class="material-icons">
                                    print
                                </i> Surat
                                </a>
                            </div>
                        </div>
                      </td>
                    </tr>
                  <?php endif;?>
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
          <h4 class="card-title ">Data Hand Over Diterima</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive pb-5">
            <table class="table table-striped table-hovered tableHandOver">
              <thead>
                <tr>
                  <td>No</td>
                  <td>kode_hand_over</td>
                  <td>Gudang Asal</td>
                  <td>Gudang Tujuan</td>
                  <td>Tanggal Terbit</td>
                  <td>Aksi</td>
                </tr>
              </thead>
              <tbody>
                <?php foreach($data_hand_over as $k_hand_over => $v_hand_over):?>
                  <?php if($v_hand_over->status_hand_over == 'diterima'):?>
                    <tr>
                      <td></td>
                      <td><?= $v_hand_over->kode_hand_over?></td>
                      <td><?= $v_hand_over->gudang_asal?></td>
                      <td><?= $v_hand_over->gudang_tujuan?></td>
                      <td><?= $v_hand_over->tanggal_dibuat_formatted?></td>
                      <td>
                        <div class="row">
                          <div class="col-md-12 px-1">
                            <a class="btn btn-primary btn-sm btn-block" target="_blank" href="<?= base_url('admin-gudang/cetak-hand-over/').$v_hand_over->id_hand_over?>">
                              <i class="material-icons">
                                print
                              </i> Surat
                            </a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php endif;?>
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
    
    var tablehand_over = $('.tableHandOver').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      "columnDefs": [
        { "width": "15%", "targets": -1 }
      ],
      responsive: false
    });
    
    tablehand_over.on('order.dt search.dt', function () {
      tablehand_over.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();
  });
  
  function terimaHandOver($id_hand_over) {
    swal({
      title: 'Apakah Anda Yakin ?',
      text: "Data Hand Over akan diterima, pastikan sudah melakukan pengecakan terlebih dahulu !",
      type: 'info',
      showCancelButton: true,
      confirmButtonClass: 'btn btn-info',
      cancelButtonClass: 'btn btn-default btn-link',
      confirmButtonText: 'Ya, Terima',
      buttonsStyling: false
    }).then(function (result) {
      if (result.value === true) {
        window.location.href = "<?= base_url('admin-gudang/terima-hand-over/')?>" + $id_hand_over;
      }
    })
  }

</script>