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
          <h4 class="card-title">Tambah Gudang</h4>
        </div>
        <form novalidate="novalidate" id="formInsertGudang"
          action="<?= base_url('asisten-manager-gudang/insert-gudang')?>" method="post" accept-charset="utf-8">
          <div class="card-body">

            <div class="form-group">
              <label for="insert_gudang_kode_gudang"> Kode Gudang</label>
              <input type="text" name="insert_kode_gudang" value="<?php echo set_value('insert_kode_gudang'); ?>"
                id="insert_gudang_kode_gudang" class="form-control" required="true"  maxLength="3"/>
              <small class="text-danger"><?php echo form_error('insert_kode_gudang'); ?></small>
            </div>

            <div class="form-group">
              <label for="insert_gudang_alamat"> Alamat</label>
              <input type="text" name="insert_alamat" value="<?php echo set_value('insert_alamat'); ?>"
                id="insert_gudang_alamat" class="form-control" required="true" />
              <small class="text-danger"><?php echo form_error('insert_alamat'); ?></small>
            </div>

            <div class="form-group">
              <label for="insert_gudang_kabupaten_kota"> Kabupaten Kota</label>
              <input type="text" name="insert_kabupaten_kota" value="<?php echo set_value('insert_kabupaten_kota'); ?>"
                id="insert_gudang_kabupaten_kota" class="form-control" required="true" />
              <small class="text-danger"><?php echo form_error('insert_kabupaten_kota'); ?></small>
            </div>

            <div class="form-group">
              <label for="insert_gudang_provinsi"> Provinsi</label>
              <input type="text" name="insert_provinsi" value="<?php echo set_value('insert_provinsi'); ?>"
                id="insert_gudang_provinsi" class="form-control" required="true" />
              <small class="text-danger"><?php echo form_error('insert_provinsi'); ?></small>
            </div>

            <div class="form-group">
              <label for="insert_gudang_kode_pos"> Kode Pos</label>
              <input type="number" name="insert_kode_pos" value="<?php echo set_value('insert_kode_pos'); ?>"
                id="insert_gudang_kode_pos" class="form-control" required="true" min="0" />
              <small class="text-danger"><?php echo form_error('insert_kode_pos'); ?></small>
            </div>

            <div class="form-group">
              <label for="insert_gudang_nomor_telepon"> Nomor Telepon</label>
              <input type="text" name="insert_nomor_telepon" value="<?php echo set_value('insert_nomor_telepon'); ?>"
                id="insert_gudang_nomor_telepon" class="form-control" required="true" />
              <small class="text-danger"><?php echo form_error('insert_nomor_telepon'); ?></small>
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
            <i class="material-icons">home</i>
          </div>
          <h4 class="card-title ">Data Gudang</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive pb-5">
            <table class="table table-striped" id="tableGudang">
              <thead>
                <tr>
                  <td>No</td>
                  <td> Kode Gudang</td>
                  <td> Alamat</td>
                  <td> Nomor Telepon</td>
                  <td>Aksi</td>
                </tr>
              </thead>
              <tbody>
                <?php foreach($data_gudang as $k_gudang => $v_gudang):?>
                <tr>
                  <td></td>
                  <td><?= $v_gudang->kode_gudang?></td>
                  <td><?= $v_gudang->alamat.'.<br>'.$v_gudang->kabupaten_kota.' - '.$v_gudang->provinsi.' ('.$v_gudang->kode_pos.')'?></td>
                  <td><?= $v_gudang->nomor_telepon?></td>
                  <td>
                    <div class="row">
                      <div class="col-md-6 px-1">
                        <button class="btn btn-danger btn-sm btn-block" onclick="deleteGudang(<?= $v_gudang->id_gudang?>)">
                          <i class="material-icons">
                            delete
                          </i>
                        </button>
                      </div>
                      <div class="col-md-6 px-1">
                        <button class="btn btn-info btn-sm btn-block" onclick="openModalGudang(<?= $v_gudang->id_gudang?>)">
                          <i class="material-icons">
                            create
                          </i>
                        </button>
                      </div>
                      <div class="col-md-12 px-1">
                        <a class="btn btn-primary btn-sm btn-block" href="<?= base_url('asisten-manager-gudang/view-detail-gudang/'.$v_gudang->kode_gudang)?>">
                          <i class="material-icons">
                            search
                          </i>Detail
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

<div class="modal fade" id="modalEditGudang" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form novalidate="novalidate" id="formEditGudang"
        action="<?= base_url('asisten-manager-gudang/edit-gudang')?>" method="post" accept-charset="utf-8">

        <div class="modal-header">
          <h5 class="modal-title">Edit Gudang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="edit_id_gudang" value="<?php echo set_value('edit_id_gudang'); ?>"
              id="edit_gudang_id_gudang" required="true" />
          
          <div class="form-group">
            <label for="edit_gudang_kode_gudang"> Kode Gudang</label>
            <input type="text" name="edit_kode_gudang" value="<?php echo set_value('edit_kode_gudang'); ?>"
              id="edit_gudang_kode_gudang" class="form-control" required="true"  maxLength="3"/>
            <small class="text-danger"><?php echo form_error('edit_kode_gudang'); ?></small>
          </div>

          <div class="form-group">
            <label for="edit_gudang_alamat"> Alamat</label>
            <input type="text" name="edit_alamat" value="<?php echo set_value('edit_alamat'); ?>"
              id="edit_gudang_alamat" class="form-control" required="true" />
            <small class="text-danger"><?php echo form_error('edit_alamat'); ?></small>
          </div>

          <div class="form-group">
            <label for="edit_gudang_kabupaten_kota"> Kabupaten Kota</label>
            <input type="text" name="edit_kabupaten_kota" value="<?php echo set_value('edit_kabupaten_kota'); ?>"
              id="edit_gudang_kabupaten_kota" class="form-control" required="true" />
            <small class="text-danger"><?php echo form_error('edit_kabupaten_kota'); ?></small>
          </div>

          <div class="form-group">
            <label for="edit_gudang_provinsi"> Provinsi</label>
            <input type="text" name="edit_provinsi" value="<?php echo set_value('edit_provinsi'); ?>"
              id="edit_gudang_provinsi" class="form-control" required="true" />
            <small class="text-danger"><?php echo form_error('edit_provinsi'); ?></small>
          </div>

          <div class="form-group">
            <label for="edit_gudang_kode_pos"> Kode Pos</label>
            <input type="number" name="edit_kode_pos" value="<?php echo set_value('edit_kode_pos'); ?>"
              id="edit_gudang_kode_pos" class="form-control" required="true" min="0" />
            <small class="text-danger"><?php echo form_error('edit_kode_pos'); ?></small>
          </div>

          <div class="form-group">
            <label for="edit_gudang_nomor_telepon"> Nomor Telepon</label>
            <input type="text" name="edit_nomor_telepon" value="<?php echo set_value('edit_nomor_telepon'); ?>"
              id="edit_gudang_nomor_telepon" class="form-control" required="true" />
            <small class="text-danger"><?php echo form_error('edit_nomor_telepon'); ?></small>
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


<script>
  $(document).ready(function () {
    var tablegudang = $('#tableGudang').DataTable({
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

    tablegudang.on('order.dt search.dt', function () {
      tablegudang.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();

    $('#formInsertGudang').validate();
    $('#formEditGudang').validate();
  });

  function deleteGudang($id_gudang) {
    swal({
      title: 'Apakah Anda Yakin ?',
      text: "Data Gudang akan dihapus dan tidak dapat dikembalikan !",
      type: 'warning',
      showCancelButton: true,
      confirmButtonClass: 'btn btn-danger',
      cancelButtonClass: 'btn btn-default btn-link',
      confirmButtonText: 'Ya, Hapus',
      buttonsStyling: false
    }).then(function (result) {
      if (result.value === true) {
        window.location.href = "<?= base_url('asisten-manager-gudang/delete-gudang/')?>" + $id_gudang;
      }
    })
  }

  function openModalGudang($id_gudang) {
    $.getJSON("<?= base_url('asisten-manager-gudang/get-specific-gudang/')?>" + $id_gudang,
      function (data, textStatus, jqXHR) {

        $('#formEditGudang [name="edit_id_gudang"]').val(data.id_gudang);
        $('#formEditGudang [name="edit_kode_gudang"]').val(data.kode_gudang);
        $('#formEditGudang [name="edit_alamat"]').val(data.alamat);
        $('#formEditGudang [name="edit_kabupaten_kota"]').val(data.kabupaten_kota);
        $('#formEditGudang [name="edit_provinsi"]').val(data.provinsi);
        $('#formEditGudang [name="edit_kode_pos"]').val(data.kode_pos);
        $('#formEditGudang [name="edit_nomor_telepon"]').val(data.nomor_telepon);
        $('#modalEditGudang').modal('show');
      }
    );
  }
</script>