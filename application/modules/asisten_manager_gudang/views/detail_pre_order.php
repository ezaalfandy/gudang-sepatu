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
    <div class="col-md-12 col-lg-12">
      <div class="card">
        <div class="card-header card-header-icon card-header-primary">
          <h4 class="card-title "><?= $data_pre_order->kode_pre_order?></h4>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-2 px-5">
                    <img src="<?= base_url('assets/img/joemen.png')?>" class="img-fluid">
                </div>
                <div class="col-md-10 pl-5">
                    <h3 class="text-right font-weight-bold">Pre Order</h3>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-7 col-md-3 text-right">
                    <p class="font-weight-bold">Nomor Pre Order :</p>
                    <p class="font-weight-bold">Tanggal :</p>
                    <p class="font-weight-bold">Tanggal Jatuh Tempo:</p>
                </div>
                <div class="col-md-2 text-right">
                    <p class="font-weight-bold"><?= $data_pre_order->kode_pre_order?></p>
                    <p class="font-weight-bold"><?= $data_pre_order->tanggal_dibuat_formatted_2?></p>
                    <p class="font-weight-bold"><?= $data_pre_order->tanggal_setor_formatted_2?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <h4 class="font-weight-bold">Dari :</h4>
                    <p class="font-weight-bold">
                        Modern Shoes<br>
                        Dsn. Sumberjo Ds. Kintelan RT 02 RW 04
                        <br>
                        Puri - Mojokerto
                    </p>
                </div>
                <div class="offset-md-2 col-md-5">
                    <h4 class="font-weight-bold">Kepada :</h4>
                    <p class="font-weight-bold">
                        <?= $data_pre_order->nama_supplier?><br>
                        <?= $data_pre_order->alamat_supplier?>
                        <br>
                        <?= $data_pre_order->telepon_supplier?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered">
                        <thead class="bg-dark text-white">
                            <tr>
                                <td>No</td>
                                <td>Barang</td>
                                <td>Jumlah</td>
                                <td>Keterangan</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $n = 1;?>
                            <?php foreach($data_detail_pre_order as $k_detail_pre_order => $v_detail_pre_order):?>
                                <tr>
                                    <td><?= $n++; ?></td>
                                    <td><?= $v_detail_pre_order->merek.' '.$v_detail_pre_order->tipe.' '.$v_detail_pre_order->warna.' '.$v_detail_pre_order->ukuran ?></td>
                                    <td><?= $v_detail_pre_order->jumlah ?></td>
                                    <td><?= $v_detail_pre_order->keterangan ?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>    
                </div>
            </div>
            <div class="row">
                <div class="offset-md-6 col-md-6 text-center pb-5">
                     <p class="py-6 my-5"></p>
                     <h4 class="font-weight-bold mt-5">
                        <u><?= ucwords($this->session->userdata('nama'));?></u>
                     </h4>        
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalTambahPreOrder" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

    <form novalidate="novalidate" id="formInsertPreOrder"
      action="<?= base_url('asisten-manager-gudang/insert-pre-order')?>" method="post" accept-charset="utf-8">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Pre Order</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <div class="row mt-3">
            <div class="col-md-6">
              <div class="form-group">
                <label for="autocomplete_insert_pre_order_id_supplier"> Supplier</label>
                <input type="hidden" name="insert_id_supplier">

                <input type="text" name="autocomplete_insert_id_supplier"
                  value="<?php echo set_value('insert_id_supplier'); ?>" id="autocomplete_insert_pre_order_id_supplier"
                  class="form-control" required="true"/>
                <small class="text-danger"><?php echo form_error('insert_id_supplier'); ?></small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="autocomplete_insert_pre_order_id_gudang_tujuan" > Gudang Tujuan</label>
                <input type="hidden" name="insert_id_gudang_tujuan">

                <input type="text" name="autocomplete_insert_id_gudang_tujuan"
                  value="<?php echo set_value('insert_id_gudang_tujuan'); ?>" id="autocomplete_insert_pre_order_id_gudang_tujuan"
                  class="form-control" required="true"/>
                <small class="text-danger"><?php echo form_error('insert_id_gudang_tujuan'); ?></small>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="insert_pre_order_tanggal_dibuat">Tanggal Terbit</label>
                <input type="date" name="insert_tanggal_dibuat"
                  value="<?php echo set_value('insert_tanggal_dibuat'); ?>" id="insert_pre_order_tanggal_dibuat"
                  class="form-control" required="true"/>
                <small class="text-danger"><?php echo form_error('insert_tanggal_dibuat'); ?></small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="insert_pre_order_tanggal_setor">Tanggal Setor</label>
                <input type="date" name="insert_tanggal_setor"
                  value="<?php echo set_value('insert_tanggal_setor'); ?>" id="insert_pre_order_tanggal_setor"
                  class="form-control" required="true"/>
                <small class="text-danger"><?php echo form_error('insert_tanggal_setor'); ?></small>
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
                  class="form-control" required="true" />
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
              <button type="button" class="btn btn-danger btn-outline-primary btn-sm remove_rincian_barang">
                <span class="material-icons text-danger">
                  remove_circle
                </span> Hapus
              </button>
            </div>
            
          </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-3">
                <button class="btn btn-link btn-primary btn-block mt-3 mb-5" onclick="tambah_rincian_barang()" type="button">
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

  function tambah_rincian_barang(){
    $element_index = $(".input_barang").length;
    $cloned_element = $(".input_barang").first().clone();
    $cloned_element.appendTo( ".rincian_barang_container");

    $cloned_element.find('[name="autocomplete_insert_id_barang[0]"]').attr("name", "autocomplete_insert_id_barang["+$element_index+"]").val(null);
    $cloned_element.find('[name="insert_jumlah_barang[0]"]').attr("name", "insert_jumlah_barang["+$element_index+"]").val(null);
    $cloned_element.find('[name="insert_keterangan[0]"]').attr("name", "insert_keterangan["+$element_index+"]").val(null);

    md.setInputAutoComplete($cloned_element.find('[name="autocomplete_insert_id_barang['+$element_index+']"]'), $barang);
  }
  

  $gudang = JSON.parse('<?= json_encode($gudang_lookup);?>');
  $supplier = JSON.parse('<?= json_encode($supplier_lookup);?>');
  $barang = JSON.parse('<?= json_encode($barang_lookup);?>');
  
  $(document).ready(function () {
    
  $('#modalTambahPreOrder').on('click', '.remove_rincian_barang', function(){
    if($('.input_barang').length > 1){
      $(this).parents('.input_barang').remove();
    }
  })

    var tablepre_order = $('#tablePreOrder').DataTable({
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

    // $('#insert_pre_order_id_gudang_tujuan').autocomplete({
    //     lookup: $gudang,
    //     showNoSuggestionNotice: true,
    //     onInvalidateSelection: function(){
    //       console.log("tes")
    //     }
    // });
    
    md.setInputAutoComplete('#autocomplete_insert_pre_order_id_gudang_tujuan', $gudang);
    md.setInputAutoComplete('#autocomplete_insert_pre_order_id_supplier', $supplier);
    md.setInputAutoComplete('[name="autocomplete_insert_id_barang[0]"]', $barang);


    // $('#insert_pre_order_id_supplier').autocomplete({
    //     lookup: $supplier,
    //     onSelect: function (suggestion) {
    //       $('#insert_pre_order_id_supplier').val(suggestion.data)
    //     }
    // });
    
    
    // $('.insert_pre_order_id_barang').autocomplete({
    //     lookup: $barang,
    //     onSelect: function (suggestion) {
    //       $(this).val(suggestion.data)
    //     }
    // });

    tablepre_order.on('order.dt search.dt', function () {
      tablepre_order.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();

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