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
          <h4 class="card-title ">Data Hand Over</h4>
        </div>
        <div class="card-body">
          <div class="col-lg-3 offset-lg-9">
            <button class="btn btn-primary btn-block my-4"  data-toggle="modal" data-target="#modalTambahHandOver">
              <i class="material-icons">add</i>
              Tambah
            </button>
          </div>
          <div class="table-responsive pb-5">
            <table class="table table-striped" id="tableHandOver">
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
                <tr>
                  <td></td>
                  <td><?= $v_hand_over->kode_hand_over?></td>
                  <td><?= $v_hand_over->gudang_asal?></td>
                  <td><?= $v_hand_over->gudang_tujuan?></td>
                  <td><?= $v_hand_over->tanggal_dibuat_formatted?></td>
                  <td>
                    <div class="row">
                      <div class="col-md-6 px-1">
                        <button class="btn btn-danger btn-sm btn-block" onclick="deleteHandOver(<?= $v_hand_over->id_hand_over?>)">
                          <i class="material-icons">
                            delete
                          </i>
                        </button>
                      </div>
                      <div class="col-md-6 px-1">
                        <a class="btn btn-info btn-sm btn-block" href="<?= base_url('asisten-manager-gudang/view-detail-hand-over/').$v_hand_over->id_hand_over?>">
                          <i class="material-icons">
                            search
                          </i>
                        </a>
                      </div>
                      <div class="col-md-12 px-1">
                        <a class="btn btn-primary btn-sm btn-block" target="_blank" href="<?= base_url('asisten-manager-gudang/cetak-hand-over/').$v_hand_over->id_hand_over?>">
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

<div class="modal fade" id="modalTambahHandOver" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

    <form novalidate="novalidate" id="formInsertHandOver"
      action="<?= base_url('asisten-manager-gudang/insert-hand-over')?>" method="post" accept-charset="utf-8">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Hand Over</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <div class="row mt-3">
            <div class="col-md-4">
              <div class="form-group">
                <label for="autocomplete_insert_hand_over_id_gudang_asal"> Gudang Asal</label>
                <input type="hidden" name="insert_id_gudang_asal">

                <input type="text" name="autocomplete_insert_id_gudang_asal"
                  value="<?php echo set_value('insert_id_gudang_asal'); ?>" id="autocomplete_insert_hand_over_id_gudang_asal"
                  class="form-control" required="true"/>
                <small class="text-danger"><?php echo form_error('insert_id_gudang_asal'); ?></small>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="autocomplete_insert_hand_over_id_gudang_tujuan" > Gudang Tujuan</label>
                <input type="hidden" name="insert_id_gudang_tujuan">

                <input type="text" name="autocomplete_insert_id_gudang_tujuan"
                  value="<?php echo set_value('insert_id_gudang_tujuan'); ?>" id="autocomplete_insert_hand_over_id_gudang_tujuan"
                  class="form-control" required="true"/>
                <small class="text-danger"><?php echo form_error('insert_id_gudang_tujuan'); ?></small>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="insert_hand_over_tanggal_dibuat">Tanggal Terbit</label>
                <input type="date" name="insert_tanggal_dibuat"
                  value="<?php echo set_value('insert_tanggal_dibuat'); ?>" id="insert_hand_over_tanggal_dibuat"
                  class="form-control" required="true"/>
                <small class="text-danger"><?php echo form_error('insert_tanggal_dibuat'); ?></small>
              </div>
            </div>
        </div>

        <div class="rincian_barang_container">
        
          <div class="row">
              <div class="col-md-12 mt-5 text-center">
                <p class="font-weight-bold">Rincian Barang</p>
              </div>
          </div>
          <div class="row input_barang mb-3">

            <div class="col-sm-5">
              <div class="form-group">
                <label>Nama Barang</label>
                <input type="hidden" name="insert_id_barang[]">
                <input type="text" name="autocomplete_insert_id_barang[0]"
                  value="<?php echo set_value('insert_id_barang'); ?>"
                  class="form-control" required="true" />
                <small class="text-danger"><?php echo form_error('insert_id_barang'); ?></small>
              </div>
            </div>
            
            <div class="col-sm-2">
              <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="insert_jumlah_barang[0]"
                  value="<?php echo set_value('insert_jumlah_barang'); ?>"
                  class="form-control" required="true" min="0"/>
                <small class="text-danger"><?php echo form_error('insert_jumlah_barang'); ?></small>
              </div>
            </div>
            
            <div class="col-sm-3">
              <div class="form-group">
                <label>Keterangan</label>
                <input type="text" name="insert_keterangan[0]"
                  value="<?php (set_value('insert_keterangan') === NULL) ?  "  " :  set_value('insert_keterangan'); ?>"
                  class="form-control" />
                <small class="text-danger"><?php echo form_error('insert_keterangan'); ?></small>
              </div>
            </div>

            <div class="col-sm-2 d-flex justify-content-center align-items-center p-0">
              <button type="button" class="btn btn-danger btn-sm remove_rincian_barang">
                <span class="material-icons">
                  remove_circle
                </span> Hapus
              </button>
            </div>
            
          </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-3">
                <button class="btn btn-sm btn-outline-primary btn-block mt-3 mb-5" onclick="tambah_rincian_barang()" type="button">
                  Tambah Item
                </button>
            </div>
        </div>

      </div>

      <div class="modal-footer">
        <input type="submit" value="Submit" class="btn btn-primary" />
        <input type="reset" value="Reset" class="btn btn-primary btn-link" />
      </div>
    </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalEditHandOver" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="http://localhost/form_generator/ " novalidate="novalidate" id="formEditHandOver"
        action="<?= base_url('asisten-manager-gudang/edit-hand-over')?>" method="post" accept-charset="utf-8">

        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <label for="edit_hand_over_id_hand_over"> Id Hand Over</label>
          <div class="form-group">
            <input type="number" name="edit_id_hand_over" value="<?php echo set_value('edit_id_hand_over'); ?>"
              id="edit_hand_over_id_hand_over" class="form-control" required="true" />
            <small class="text-danger"><?php echo form_error('edit_id_hand_over'); ?></small>
          </div>

          <label for="edit_hand_over_id_admin"> Id Admin</label>
          <div class="form-group">
            <input type="number" name="edit_id_admin" value="<?php echo set_value('edit_id_admin'); ?>"
              id="edit_hand_over_id_admin" class="form-control" required="true" />
            <small class="text-danger"><?php echo form_error('edit_id_admin'); ?></small>
          </div>

          <label for="edit_hand_over_id_gudang_asal"> Id Supplier</label>
          <div class="form-group">
            <input type="number" name="edit_id_gudang_asal" value="<?php echo set_value('edit_id_gudang_asal'); ?>"
              id="edit_hand_over_id_gudang_asal" class="form-control" required="true" />
            <small class="text-danger"><?php echo form_error('edit_id_gudang_asal'); ?></small>
          </div>

          <label for="edit_hand_over_id_gudang_tujuan"> Id Gudang Tujuan</label>
          <div class="form-group">
            <input type="number" name="edit_id_gudang_tujuan" value="<?php echo set_value('edit_id_gudang_tujuan'); ?>"
              id="edit_hand_over_id_gudang_tujuan" class="form-control" required="true" />
            <small class="text-danger"><?php echo form_error('edit_id_gudang_tujuan'); ?></small>
          </div>

          <label for="edit_hand_over_kode_hand_over"> Kode Hand Over</label>
          <div class="form-group">
            <input type="text" name="edit_kode_hand_over" value="<?php echo set_value('edit_kode_hand_over'); ?>"
              id="edit_hand_over_kode_hand_over" class="form-control" required="true" />
            <small class="text-danger"><?php echo form_error('edit_kode_hand_over'); ?></small>
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
  <?php
    $gudang_lookup = [];
    foreach ($data_gudang as $k => $v) {
      $gudang_lookup[] = array(
        "value" => $v->alamat.' - '.$v->kode_pos,
        "code" => $v->id_gudang
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

  function tambah_rincian_barang()
        {
    $element_index = $(".input_barang").length;
    $cloned_element = $(".input_barang").first().clone();
    $cloned_element.appendTo( ".rincian_barang_container");

    $cloned_element.find('[name="autocomplete_insert_id_barang[0]"]').attr("name", "autocomplete_insert_id_barang["+$element_index+"]").val(null);
    $cloned_element.find('[name="insert_jumlah_barang[0]"]').attr("name", "insert_jumlah_barang["+$element_index+"]").val(null);
    $cloned_element.find('[name="insert_keterangan[0]"]').attr("name", "insert_keterangan["+$element_index+"]").val(null);

    
    $cloned_element.find('[name="autocomplete_insert_id_barang[0]"]').focus();
    
    md.setInputAutoComplete($cloned_element.find('[name="autocomplete_insert_id_barang['+$element_index+']"]'), $barang);
  }
  

  $gudang = JSON.parse('<?= json_encode($gudang_lookup);?>');
  $barang = JSON.parse('<?= json_encode($barang_lookup);?>');
  
  $(document).ready(function () {
    
  $('#modalTambahHandOver').on('click', '.remove_rincian_barang', function()
        {
    if($('.input_barang').length > 1)
        {
      $(this).parents('.input_barang').fadeOut(function()
        {
        $(this).remove();
      })
    }
  })

    var tablehand_over = $('#tableHandOver').DataTable({
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
    
    md.setInputAutoComplete('#autocomplete_insert_hand_over_id_gudang_tujuan', $gudang);
    md.setInputAutoComplete('#autocomplete_insert_hand_over_id_gudang_asal', $gudang);
    md.setInputAutoComplete('[name="autocomplete_insert_id_barang[0]"]', $barang);

    tablehand_over.on('order.dt search.dt', function () {
      tablehand_over.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();

    $('#formInsertHandOver').validate();
    $('#formEditHandOver').validate();
  });

  function deleteHandOver($id_hand_over) {
    swal({
      title: 'Apakah Anda Yakin ?',
      text: "Data Hand Over akan dihapus dan tidak dapat dikembalikan !",
      type: 'warning',
      showCancelButton: true,
      confirmButtonClass: 'btn btn-danger',
      cancelButtonClass: 'btn btn-default btn-link',
      confirmButtonText: 'Ya, Hapus',
      buttonsStyling: false
    }).then(function (result) {
      if (result.value === true) {
        window.location.href = "<?= base_url('asisten-manager-gudang/delete-hand-over/')?>" + $id_hand_over;
      }
    })
  }

  function openModalHandOver($id_hand_over) {
    $.getJSON("<?= base_url('asisten-manager-gudang/get-specific-hand-over/')?>" + $id_hand_over,
      function (data, textStatus, jqXHR) {
        $('#formEditHandOver [name="edit_id_hand_over"]').val(data.id_hand_over);
        $('#formEditHandOver [name="edit_id_admin"]').val(data.id_admin);
        $('#formEditHandOver [name="edit_id_gudang_tujuan"]').val(data.id_gudang_tujuan);
        $('#formEditHandOver [name="edit_kode_hand_over"]').val(data.kode_hand_over);
        $('#modalEditHandOver').modal('show');
      }
    );
  }
</script>