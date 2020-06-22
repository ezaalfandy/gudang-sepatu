<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <?php
        if($this->session->flashdata('status') === 'success')
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
          <h4 class="card-title">Tambah Barang</h4>
        </div>
        <form action="<?= base_url('asisten-manager-gudang/insert-barang')?>" method="post" accept-charset="utf-8"
          novalidate="novalidate" id="formTambahBarang" enctype="multipart/form-data">
          <div class="card-body ">

            <div class="form-group">
              <input type="hidden" name="kode_merek" value="<?php echo set_value('merek'); ?>" />

              <label for="autocomplete_insert_barang_merek">Merek</label>
              <input type="text" name="autocomplete_insert_merek" value="<?php echo set_value('merek'); ?>"
                id="autocomplete_insert_barang_merek" class="form-control" required="true" />
            </div>

            <div class="form-group">
              <label for="insert_barang_tipe">Tipe</label>
              <input type="text" name="insert_tipe" value="<?php echo set_value('tipe'); ?>" id="insert_barang_tipe"
                class="form-control" required="true" maxLength="3" />
            </div>

            <div class="form-group">
              <input type="hidden" name="kode_warna" />
              <label for="autocomplete_insert_barang_warna">Warna</label>
              <input type="text" name="autocomplete_insert_warna" value="<?php echo set_value('warna'); ?>"
                id="autocomplete_insert_barang_warna" class="form-control" required="true" />
            </div>

            <div class="form-group">
              <label for="insert_barang_ukuran">Ukuran</label>
              <input type="number" name="insert_ukuran" value="<?php echo set_value('ukuran'); ?>"
                id="insert_barang_ukuran" class="form-control" required="true" min="0" />
            </div>

            <div class="form-group">
              <label for="insert_barang_alarm_stok_minimal">Alarm Stok Minimal</label>
              <input type="number" name="insert_alarm_stok_minimal"
                value="<?php echo set_value('alarm_stok_minimal'); ?>" id="insert_barang_alarm_stok_minimal"
                class="form-control" required="true" min="0" />
            </div>

            <div class="form-group">
              <div class="fileinput fileinput-new text-center mt-3" data-provides="fileinput">
                <div class="fileinput-new thumbnail">
                  <img src="<?= base_url('assets/img/image_placeholder.jpg')?>" alt="..." class="drop-shadow-sm">
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                <div>
                  <span class="btn btn-default btn-file">
                    <span class="fileinput-new">Upload Gambar</span>
                    <span class="fileinput-exists">Ganti</span>
                    <input type="file" name="insert_barang_gambar[]" multiple extension="jpg|gif|png|jpeg">
                  </span>
                  <a href="#pablo" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"><i
                      class="fa fa-times"></i> Hapus</a>
                </div>
              </div>
            </div>

          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-fill btn-primary">Tambah</button>
            <button type="reset" class="btn btn-default btn-link">Reset</button>
          </div>
        </form>
      </div>
    </div>
    <div class="col-md-12 col-lg-8">
      <div class="card">
        <div class="card-header card-header-icon card-header-primary">
          <div class="row">
            <div class="card-icon">
              <i class="material-icons">assessment</i>
            </div>
            <h4 class="card-title ">Data Barang</h4>
          </div>
        </div>
        <div class="card-body">

          <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modalImportExcel">
            Import Excel
          </button>
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
                  <td>Stok Total</td>
                  <td data-priority="1">Aksi</td>
                </tr>
              </thead>
              <tbody>
                <?php foreach($data_barang as $k_barang => $v_barang):?>
                <tr>
                  <td></td>
                  <td><?= $v_barang->kode_barang?></td>
                  <td><?= $v_barang->merek?></td>
                  <td><?= $v_barang->tipe?></td>
                  <td><?= $v_barang->warna?></td>
                  <td><?= $v_barang->ukuran?></td>
                  <td><?= $v_barang->stok_tersedia?></td>
                  <td>
                    <div class="row">
                      <div class="col-md-6 px-1">
                        <button class="btn btn-danger btn-sm btn-block"
                          onclick="deleteBarang(<?= $v_barang->id_barang?>)">
                          <i class="material-icons">
                            delete
                          </i>
                        </button>
                      </div>
                      <div class="col-md-6 px-1">
                        <button class="btn btn-info btn-sm btn-block"
                          onclick="openModalEditBarang(<?= $v_barang->id_barang?>)">
                          <i class="material-icons">
                            create
                          </i>
                        </button>
                      </div>
                      <div class="col-md-12 px-1">
                        <a class="btn btn-primary btn-sm btn-block"
                          href="<?= base_url('asisten-manager-gudang/view-detail-barang/').$v_barang->kode_barang?>">
                          <i class="material-icons">
                            search
                          </i> Lihat Stok
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


<div class="modal fade" id="modalEditBarang" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form novalidate="novalidate" id="formEditBarang" action="<?= base_url('asisten-manager-gudang/edit-barang')?>"
        method="post" accept-charset="utf-8" class="mb-0">
        <div class="modal-header">
          <h5 class="modal-title">Edit Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="edit_id_barang" value="<?php echo set_value('edit_id_barang'); ?>"
            id="edit_barang_id_barang" required="true" />

          <div class="form-group">
            <input type="hidden" name="kode_merek" value="<?php echo set_value('merek'); ?>" />

            <label for="autocomplete_edit_barang_merek">Merek</label>
            <input type="text" name="autocomplete_edit_merek" value="<?php echo set_value('merek'); ?>"
              id="autocomplete_edit_barang_merek" class="form-control" required="true" />
          </div>

          <div class="form-group">
            <label for="edit_barang_tipe">Tipe</label>
            <input type="text" name="edit_tipe" value="<?php echo set_value('tipe'); ?>" id="edit_barang_tipe"
              class="form-control" required="true" maxLength="3" />
          </div>

          <div class="form-group">
            <input type="hidden" name="kode_warna" />
            <label for="autocomplete_edit_barang_warna">Warna</label>
            <input type="text" name="autocomplete_edit_warna" value="<?php echo set_value('warna'); ?>"
              id="autocomplete_edit_barang_warna" class="form-control" required="true" />
          </div>

          <div class="form-group">
            <label for="edit_barang_ukuran"> Ukuran</label>
            <input type="number" name="edit_ukuran" value="<?php echo set_value('edit_ukuran'); ?>"
              id="edit_barang_ukuran" class="form-control" required="true" min="0" />
            <small class="text-danger"><?php echo form_error('edit_ukuran'); ?></small>
          </div>

        </div>
        <div class="modal-footer">
          <input type="submit" value="Ubah" class="btn btn-primary" />
          <input type="button" value="Cancel" class="btn btn-outline-primary" data-dismiss="modal" />
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalImportExcel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form novalidate="novalidate" id="formImportExcel" action="<?= base_url('asisten-manager-gudang/import-excel-barang')?>"
        method="post" class="m-0" accept-charset="utf-8" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Import data barang dari excel</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div>
            <label for="inputFileExcel">File Excel</label>
            <input type="file" name="file_excel" class="d-block" id="inputFileExcel" required="true">
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" value="Import" class="btn btn-primary" />
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  <?php
    $merek_lookup = [];
  foreach($data_merek as $k => $v) {
    $merek_lookup[] = array(
      "value" => $v -> nama_merek,
      "code" => $v -> kode_merek
    );
  }

  $warna_lookup = [];
  foreach($data_warna as $k => $v) {
    $warna_lookup[] = array(
      "value" => $v -> nama_warna,
      "code" => $v -> kode_warna
    );
  }

  ?>
  $merek = JSON.parse('<?= json_encode($merek_lookup);?>');
  $warna = JSON.parse('<?= json_encode($warna_lookup);?>');


  md.setInputAutoComplete('#autocomplete_insert_barang_merek', $merek);
  md.setInputAutoComplete('#autocomplete_insert_barang_warna', $warna);

  md.setInputAutoComplete('#autocomplete_edit_barang_merek', $merek);
  md.setInputAutoComplete('#autocomplete_edit_barang_warna', $warna);

  function deleteBarang($id_barang) {
    swal({
      title: 'Apakah Anda Yakin ?',
      text: "Data Barang akan dihapus dan tidak dapat dikembalikan !",
      type: 'warning',
      showCancelButton: true,
      confirmButtonClass: 'btn btn-danger',
      cancelButtonClass: 'btn btn-default btn-link',
      confirmButtonText: 'Ya, Hapus',
      buttonsStyling: false
    }).then(function (result) {
      if (result.value === true) {
        window.location.href = "<?= base_url('asisten-manager-gudang/delete-barang/')?>" + $id_barang;
      }
    })
  }

  $(document).ready(function () {
    var t_barang = $('#tableBarang').DataTable({
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

    md.setFormValidation($('#formTambahBarang'));
    md.setFormValidation($('#formEditBarang'));
    md.setFormValidation($('#formImportExcel'));
  });

  function openModalEditBarang($id_barang) {
    $.getJSON("<?= base_url('asisten-manager-gudang/get-specific-barang/')?>" + $id_barang,
      function (data, textStatus, jqXHR) {
        $('#formEditBarang .form-group').addClass('is-filled');
        $('#formEditBarang [name="edit_id_barang"]').val(data.id_barang);
        $('#formEditBarang [name="edit_kode_barang"]').val(data.kode_barang);
        $('#formEditBarang [name="autocomplete_edit_merek"]').val(data.merek).autocomplete('onValueChange');;
        $('#formEditBarang [name="edit_tipe"]').val(data.tipe);
        $('#formEditBarang [name="autocomplete_edit_warna"]').val(data.warna).autocomplete('onValueChange');;
        $('#formEditBarang [name="edit_ukuran"]').val(data.ukuran);
        $('#modalEditBarang').modal('show');
      }
    );
  }
</script>