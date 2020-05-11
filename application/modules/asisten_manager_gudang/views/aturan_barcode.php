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
                <b> Failed- </b> '.$this->session->userdata('message').'</span>
            </div>
          ';
        }
      ?>
    </div>
    <div class="col-md-12 col-lg-4">
      <div class="card">
        <div class="card-header card-header-primary card-header-icon">
          <div class="card-icon">
            <i class="material-icons">add</i>
          </div>
          <h4 class="card-title">Tambah Merek</h4>
        </div>

        <form novalidate="novalidate" id="formInsertMerek"
          action="<?= base_url('asisten-manager-gudang/insert-merek')?>" method="post" accept-charset="utf-8">
          <div class="card-body ">
            <div class="form-group">
              <label for="insert_merek_nama_merek"> Nama Merek</label>
              <input type="text" name="insert_nama_merek" value="<?php echo set_value('insert_nama_merek'); ?>"
                id="insert_merek_nama_merek" class="form-control" required="true" />
              <small class="text-danger"><?php echo form_error('insert_nama_merek'); ?></small>
            </div>

            <div class="form-group">
              <label for="insert_merek_kode_merek"> Kode Merek</label>
              <input type="text" name="insert_kode_merek" value="<?php echo set_value('insert_kode_merek'); ?>"
                id="insert_merek_kode_merek" class="form-control" required="true" maxLength="2" />
              <small class="text-danger"><?php echo form_error('insert_kode_merek'); ?></small>
            </div>
          </div>
          <div class="card-footer">
            <input type="submit" value="Submit" class="btn btn-primary" />
            <input type="reset" value="Reset" class="btn btn-primary btn-link" />
          </div>
        </form>
      </div>
    </div>
    <div class="col-md-12 col-lg-8">
      <div class="card">
        <div class="card-header card-header-icon card-header-primary">
          <div class="card-icon">
            <i class="material-icons">assessment</i>
          </div>
          <h4 class="card-title ">Data Merek</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive pb-5">
            <table class="table table-striped" id="tableMerek">
              <thead>
                <tr>
                  <td>No</td>
                  <td> Nama Merek</td>
                  <td> Kode Merek</td>
                  <td>Aksi</td>
                </tr>
              </thead>
              <tbody>
                <?php foreach($data_merek as $k_merek => $v_merek):?>
                <tr>
                  <td></td>
                  <td><?= $v_merek->nama_merek?></td>
                  <td><?= $v_merek->kode_merek?></td>
                  <td>
                    <div class="row">
                      <div class="col-md-6 px-1">
                        <button class="btn btn-danger btn-sm" onclick="deleteMerek(<?= $v_merek->id_merek?>)">
                          <i class="material-icons">
                            delete
                          </i>
                        </button>
                      </div>
                      <div class="col-md-6 px-1">
                        <button class="btn btn-info btn-sm" onclick="openModalMerek(<?= $v_merek->id_merek?>)">
                          <i class="material-icons">
                            create
                          </i>
                        </button>
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
  <div class="row">
    <div class="col-md-12 col-lg-4">
      <div class="card">
        <div class="card-header card-header-info card-header-icon">
          <div class="card-icon">
            <i class="material-icons">add</i>
          </div>
          <h4 class="card-title">Tambah Warna</h4>
        </div>

        <form novalidate="novalidate" id="formInsertWarna"
          action="<?= base_url('asisten-manager-gudang/insert-warna')?>" method="post" accept-charset="utf-8">
          <div class="card-body ">

            <div class="form-group">
              <label for="insert_warna_nama_warna"> Nama Warna</label>
              <input type="text" name="insert_nama_warna" value="<?php echo set_value('insert_nama_warna'); ?>"
                id="insert_warna_nama_warna" class="form-control" required="true" />
              <small class="text-danger"><?php echo form_error('insert_nama_warna'); ?></small>
            </div>

            <div class="form-group">
              <label for="insert_warna_kode_warna"> Kode Warna</label>
              <input type="text" name="insert_kode_warna" value="<?php echo set_value('insert_kode_warna'); ?>"
                id="insert_warna_kode_warna" class="form-control" required="true" maxLength="2"/>
              <small class="text-danger"><?php echo form_error('insert_kode_warna'); ?></small>
            </div>

          </div>
          <div class="card-footer">
            <input type="submit" value="Submit" class="btn btn-info" />
            <input type="reset" value="Reset" class="btn btn-info btn-link" />
          </div>
        </form>
      </div>
    </div>
    <div class="col-md-12 col-lg-8">
      <div class="card">
        <div class="card-header card-header-icon card-header-info">
          <div class="card-icon">
            <i class="material-icons">assessment</i>
          </div>
          <h4 class="card-title ">Data Warna</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive pb-5">
            <table class="table table-striped" id="tableWarna">
              <thead>
                <tr>
                  <td>No</td>
                  <td> Nama Warna</td>
                  <td> Kode Warna</td>
                  <td>Aksi</td>
                </tr>
              </thead>
              <tbody>
                <?php foreach($data_warna as $k_warna => $v_warna):?>
                <tr>
                  <td></td>
                  <td><?= $v_warna->nama_warna?></td>
                  <td><?= $v_warna->kode_warna?></td>
                  <td>
                    <button class="btn btn-danger btn-sm btn-block" onclick="deleteWarna(<?= $v_warna->id_warna?>)">
                      <i class="material-icons">
                        delete
                      </i>
                    </button>
                    <button class="btn btn-info btn-sm" onclick="openModalWarna(<?= $v_warna->id_warna?>)">
                      <i class="material-icons">
                        create
                      </i>
                    </button>
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

<div class="modal fade" id="modalEditMerek" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form novalidate="novalidate" id="formEditMerek" action="<?= base_url('asisten-manager-gudang/edit-merek')?>"
        method="post" accept-charset="utf-8">
        <div class="modal-header">
          <h5 class="modal-title">Edit Merek</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="edit_id_merek" value="<?php echo set_value('edit_id_merek'); ?>" />

          <div class="form-group">
            <label for="edit_merek_nama_merek"> Nama Merek</label>
            <input type="text" name="edit_nama_merek" value="<?php echo set_value('edit_nama_merek'); ?>"
              id="edit_merek_nama_merek" class="form-control" required="true" />
            <small class="text-danger"><?php echo form_error('edit_nama_merek'); ?></small>
          </div>

          <div class="form-group">
            <label for="edit_merek_kode_merek"> Kode Merek</label>
            <input type="text" name="edit_kode_merek" value="<?php echo set_value('edit_kode_merek'); ?>"
              id="edit_merek_kode_merek" class="form-control" required="true" maxLength="2" />
            <small class="text-danger"><?php echo form_error('edit_kode_merek'); ?></small>
          </div>

        </div>
        <div class="modal-footer">
          <input type="reset" value="Reset" class="btn btn-outline-primary" />

          <input type="submit" value="Submit" class="btn btn-primary" />

        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalEditWarna" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form novalidate="novalidate" id="formEditWarna" action="<?= base_url('asisten-manager-gudang/edit-warna')?>"
        method="post" accept-charset="utf-8">
        <div class="modal-header">
          <h5 class="modal-title">Edit warna</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="edit_id_warna" value="<?php echo set_value('edit_id_warna'); ?>" />

          <div class="form-group">
            <label for="edit_warna_nama_warna"> Nama Warna</label>
            <input type="text" name="edit_nama_warna" value="<?php echo set_value('edit_nama_warna'); ?>"
              id="edit_warna_nama_warna" class="form-control" required="true" />
            <small class="text-danger"><?php echo form_error('edit_nama_warna'); ?></small>
          </div>

          <div class="form-group">
            <label for="edit_warna_kode_warna"> Kode Warna</label>
            <input type="text" name="edit_kode_warna" value="<?php echo set_value('edit_kode_warna'); ?>"
              id="edit_warna_kode_warna" class="form-control" required="true" maxLength="2"/>
            <small class="text-danger"><?php echo form_error('edit_kode_warna'); ?></small>
          </div>

        </div>
        <div class="modal-footer">
          <input type="reset" value="Reset" class="btn btn-outline-info" />
          <input type="submit" value="Submit" class="btn btn-info" />
        </div>
      </form>
    </div>
  </div>
</div>



<script>
  $(document).ready(function () {
    var tableMerek = $('#tableMerek').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      "columnDefs": [
        { "width": "17%", "targets": -1 }
      ],
      responsive: false
    });

    tableMerek.on('order.dt search.dt', function () {
      tableMerek.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();

    $('#formInsertMerek').validate();
    $('#formEditMerek').validate();
  });

  function deleteMerek($id_merek) {
    swal({
      title: 'Apakah Anda Yakin ?',
      text: "Data Merek akan dihapus dan tidak dapat dikembalikan !",
      type: 'warning',
      showCancelButton: true,
      confirmButtonClass: 'btn btn-danger',
      cancelButtonClass: 'btn btn-default btn-link',
      confirmButtonText: 'Ya, Hapus',
      buttonsStyling: false
    }).then(function (result) {
      if (result.value === true) {
        window.location.href = "<?= base_url('asisten-manager-gudang/delete-merek/')?>" + $id_merek;
      }
    })
  }

  function openModalMerek($id_merek) {
    $.getJSON("<?= base_url('asisten-manager-gudang/get-specific-merek/')?>" + $id_merek,
      function (data, textStatus, jqXHR) {

        $('#formEditMerek .form-group').addClass('is-filled');

        $('#formEditMerek [name="edit_id_merek"]').val(data.id_merek);
        $('#formEditMerek [name="edit_nama_merek"]').val(data.nama_merek);
        $('#formEditMerek [name="edit_kode_merek"]').val(data.kode_merek);
        $('#modalEditMerek').modal('show');
      }
    );
  }


  $(document).ready(function () {
    var tableWarna = $('#tableWarna').DataTable({
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

    tableWarna.on('order.dt search.dt', function () {
      tableWarna.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();

    $('#formInsertWarna').validate();
    $('#formEditWarna').validate();
  });

  function deleteWarna($id_warna) {
    swal({
      title: 'Apakah Anda Yakin ?',
      text: "Data Warna akan dihapus dan tidak dapat dikembalikan !",
      type: 'warning',
      showCancelButton: true,
      confirmButtonClass: 'btn btn-danger',
      cancelButtonClass: 'btn btn-default btn-link',
      confirmButtonText: 'Ya, Hapus',
      buttonsStyling: false
    }).then(function (result) {
      if (result.value === true) {
        window.location.href = "<?= base_url('asisten-manager-gudang/delete-warna/')?>" + $id_warna;
      }
    })
  }

  function openModalWarna($id_warna) {
    $.getJSON("<?= base_url('asisten-manager-gudang/get-specific-warna/')?>" + $id_warna,
      function (data, textStatus, jqXHR) {

        $('#formEditWarna .form-group').addClass('is-filled');

        $('#formEditWarna [name="edit_id_warna"]').val(data.id_warna);
        $('#formEditWarna [name="edit_nama_warna"]').val(data.nama_warna);
        $('#formEditWarna [name="edit_kode_warna"]').val(data.kode_warna);
        $('#modalEditWarna').modal('show');
      }
    );
  }
</script>