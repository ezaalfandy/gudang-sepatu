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
          <h4 class="card-title">Tambah Supplier</h4>
        </div>
          <form novalidate="novalidate" id="formInsertSupplier" action="<?= base_url('asisten-manager-gudang/insert-supplier')?>" method="post"
            accept-charset="utf-8">

            <div class="card-body">
              <div class="form-group">
                <label for="insert_supplier_kode_supplier"> Kode Supplier</label>
                <input type="text" name="insert_kode_supplier" value="<?php echo set_value('insert_kode_supplier'); ?>"
                  id="insert_supplier_kode_supplier" class="form-control" required="true"  maxLength="3"/>
                <small class="text-danger"><?php echo form_error('insert_kode_supplier'); ?></small>
              </div>

              <div class="form-group">
                <label for="insert_supplier_nama"> Nama</label>
                <input type="text" name="insert_nama" value="<?php echo set_value('insert_nama'); ?>"
                  id="insert_supplier_nama" class="form-control" required="true" />
                <small class="text-danger"><?php echo form_error('insert_nama'); ?></small>
              </div>

              <div class="form-group">
                <label for="insert_supplier_alamat"> Alamat</label>
                <input type="text" name="insert_alamat" value="<?php echo set_value('insert_alamat'); ?>"
                  id="insert_supplier_alamat" class="form-control" required="true" />
                <small class="text-danger"><?php echo form_error('insert_alamat'); ?></small>
              </div>

              <div class="form-group">
                <label for="insert_supplier_telepon"> Telepon</label>
                <input type="text" name="insert_telepon" value="<?php echo set_value('insert_telepon'); ?>"
                  id="insert_supplier_telepon" class="form-control" required="true" />
                <small class="text-danger"><?php echo form_error('insert_telepon'); ?></small>
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
          <h4 class="card-title ">Data Supplier</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive pb-5">
            <table class="table table-striped" id="tableSupplier">
              <thead>
                <tr>
                  <td>No</td>
                  <td> Id Supplier</td>
                  <td> Kode Supplier</td>
                  <td> Nama</td>
                  <td> Alamat</td>
                  <td> Telepon</td>
                  <td>Aksi</td>
                </tr>
              </thead>
              <tbody>
                <?php foreach($data_supplier as $k_supplier => $v_supplier):?>
                <tr>
                  <td></td>
                  <td><?= $v_supplier->id_supplier?></td>
                  <td><?= $v_supplier->kode_supplier?></td>
                  <td><?= $v_supplier->nama_supplier?></td>
                  <td><?= $v_supplier->alamat_supplier?></td>
                  <td><?= $v_supplier->telepon_supplier?></td>
                  <td>
                    <button class="btn btn-danger btn-sm" onclick="deleteSupplier(<?= $v_supplier->id_supplier?>)">
                      <i class="material-icons">
                        delete
                      </i>
                    </button>
                    <button class="btn btn-info btn-sm" onclick="openModalSupplier(<?= $v_supplier->id_supplier?>)">
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


<div class="modal fade" id="modalEditSupplier" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form novalidate="novalidate" id="formEditSupplier"
        action="<?= base_url('asisten-manager-gudang/edit-supplier')?>" method="post" accept-charset="utf-8">

        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        
          <input type="hidden" name="edit_id_supplier" value="<?php echo set_value('edit_id_supplier'); ?>"/>
          <div class="form-group">
            <label for="edit_supplier_kode_supplier"> Kode Supplier</label>
            <input type="text" name="edit_kode_supplier" value="<?php echo set_value('edit_kode_supplier'); ?>"
              id="edit_supplier_kode_supplier" class="form-control" required="true" maxLength="3"/>
            <small class="text-danger"><?php echo form_error('edit_kode_supplier'); ?></small>
          </div>

          <div class="form-group">
            <label for="edit_supplier_nama"> Nama</label>
            <input type="text" name="edit_nama" value="<?php echo set_value('edit_nama'); ?>" id="edit_supplier_nama"
              class="form-control" required="true" />
            <small class="text-danger"><?php echo form_error('edit_nama'); ?></small>
          </div>

          <div class="form-group">
            <label for="edit_supplier_alamat"> Alamat</label>
            <input type="text" name="edit_alamat" value="<?php echo set_value('edit_alamat'); ?>"
              id="edit_supplier_alamat" class="form-control" required="true" />
            <small class="text-danger"><?php echo form_error('edit_alamat'); ?></small>
          </div>

          <div class="form-group">
            <label for="edit_supplier_telepon"> Telepon</label>
            <input type="text" name="edit_telepon" value="<?php echo set_value('edit_telepon'); ?>"
              id="edit_supplier_telepon" class="form-control" required="true" />
            <small class="text-danger"><?php echo form_error('edit_telepon'); ?></small>
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
    var t_supplier = $('#tableSupplier').DataTable({
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

    t_supplier.on('order.dt search.dt', function () {
      t_supplier.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();

    $('#formInsertSupplier').validate();
    $('#formEditSupplier').validate();
  });

  function deleteSupplier($id_supplier) {
    swal({
      title: 'Apakah Anda Yakin ?',
      text: "Data Supplier akan dihapus dan tidak dapat dikembalikan !",
      type: 'warning',
      showCancelButton: true,
      confirmButtonClass: 'btn btn-danger',
      cancelButtonClass: 'btn btn-default btn-link',
      confirmButtonText: 'Ya, Hapus',
      buttonsStyling: false
    }).then(function (result) {
      if (result.value === true) {
        window.location.href = "<?= base_url('asisten-manager-gudang/delete-supplier/')?>" + $id_supplier;
      }
    })
  }

  function openModalSupplier($id_supplier) {
    $.getJSON("<?= base_url('asisten-manager-gudang/get-specific-supplier/')?>" + $id_supplier,
      function (data, textStatus, jqXHR) {
        $('#formEditSupplier [name="edit_id_supplier"]').val(data.id_supplier);
        $('#formEditSupplier [name="edit_kode_supplier"]').val(data.kode_supplier);
        $('#formEditSupplier [name="edit_nama"]').val(data.nama_supplier);
        $('#formEditSupplier [name="edit_alamat"]').val(data.alamat_supplier);
        $('#formEditSupplier [name="edit_telepon"]').val(data.telepon_supplier);
        $('#modalEditSupplier').modal('show');
      }
    );
  }
</script>