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
          <h4 class="card-title ">Data Hand Over Keluar</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive pb-5">
            <table class="table table-striped table-hovered tableHandOver">
              <thead>
                <tr>
                  <td>No</td>
                  <td>kode_hand_over</td>
                  <td>Gudang Tujuan</td>
                  <td>Tanggal Terbit</td>
                  <td>Status</td>
                  <td>Aksi</td>
                </tr>
              </thead>
              <tbody>
                <?php $n = 1;?>
                <?php foreach($data_hand_over as $k_hand_over => $v_hand_over):?>
                  <tr>
                    <td><?= $n++?></td>
                    <td><?= $v_hand_over->kode_hand_over?></td>
                    <td><?= $v_hand_over->gudang_tujuan?></td>
                    <td><?= $v_hand_over->tanggal_dibuat_formatted?></td>
                    <td>
                      <?php 
                        if($v_hand_over->status_hand_over == 'diterima')
                        {
                          echo '<span class="badge badge-success badge-pill"> DITERIMA </span>';
                        }elseif($v_hand_over->status_hand_over == 'diproses')
                        {
                          echo '<span class="badge badge-warning badge-pill"> DIPROSES </span>';
                        }else{
                          echo '<span class="badge badge-danger badge-pill"> DITOLAK </span>';
                        }
                      ?>
                    </td>
                    <td>
                      <div class="row">
                        <div class="col-md-12 px-1">
                            <a class="btn btn-info btn-sm btn-block" href="<?= base_url('admin-gudang/view-detail-hand-over/').$v_hand_over->kode_hand_over?>">
                              <i class="material-icons">
                                  search
                              </i> Lihat
                            </a>
                        </div>
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