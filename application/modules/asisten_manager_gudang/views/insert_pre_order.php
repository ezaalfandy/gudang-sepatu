<div class="container-fluid">
  <div class="row justify-content-center">
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
    <div class="col-md-11">
        <div class="wizard-container">
            <div class="card card-wizard active" data-color="blue" id="wizardPreOrder">
            <form novalidate="novalidate" id="formInsertPreOrder"
        action="<?= base_url('asisten-manager-gudang/insert-pre-order')?>" method="post" accept-charset="utf-8">
                <div class="card-header text-center">
                    <h3 class="card-title">
                        Tambah Data Pre Order
                    </h3>
                <h5 class="card-description">Pastikan anda mengisi formulir dengan benar.</h5>
                </div>
                <div class="wizard-navigation">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" href="#data_pre_order" data-toggle="tab" role="tab">
                                Data Pre Order
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#data_detail_pre_order" data-toggle="tab" role="tab">
                                Detail Item
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="data_pre_order">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="autocomplete_insert_pre_order_id_supplier"> Supplier</label>
                                        <input type="hidden" name="insert_id_supplier">

                                        <input type="text" name="autocomplete_insert_id_supplier"
                                        value="<?php echo set_value('insert_id_supplier'); ?>" id="autocomplete_insert_pre_order_id_supplier"
                                        class="form-control" required="true"/>
                                        <small class="text-danger"><?php echo form_error('insert_id_supplier'); ?></small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="autocomplete_insert_pre_order_id_gudang_tujuan" > Gudang Tujuan</label>
                                        <input type="hidden" name="insert_id_gudang_tujuan">

                                        <input type="text" name="autocomplete_insert_id_gudang_tujuan"
                                        value="<?php echo set_value('insert_id_gudang_tujuan'); ?>" id="autocomplete_insert_pre_order_id_gudang_tujuan"
                                        class="form-control" required="true"/>
                                        <small class="text-danger"><?php echo form_error('insert_id_gudang_tujuan'); ?></small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="insert_pre_order_tanggal_dibuat">Tanggal Terbit</label>
                                        <input type="text" name="insert_tanggal_dibuat"
                                        value="<?php echo set_value('insert_tanggal_dibuat', Date("d-m-Y")); ?>" id="insert_pre_order_tanggal_dibuat"
                                        class="form-control datepicker" required="true"/>
                                        <small class="text-danger"><?php echo form_error('insert_tanggal_dibuat'); ?></small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="insert_pre_order_tanggal_setor">Tanggal Setor</label>
                                        <input type="text" name="insert_tanggal_setor"
                                        value="<?php echo set_value('insert_tanggal_setor', Date("d-m-Y", strtotime("+1 week"))); ?>" id="insert_pre_order_tanggal_setor"
                                        class="form-control datepicker" required="true"/>
                                        <small class="text-danger"><?php echo form_error('insert_tanggal_setor'); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="data_detail_pre_order">
                            <div class="row justify-content-center rincian_barang_container">
                                <div class="col-md-12 input_barang mb-4 py-3 border border-dark">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nama Barang</label>
                                                <input type="hidden" name="insert_id_barang[]">
                                                <input type="text" name="autocomplete_insert_id_barang[0]"
                                                value=""
                                                class="form-control" required="true" />
                                                <small class="text-danger"><?php echo form_error('insert_id_barang'); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Jumlah</label>
                                                <input type="number" name="insert_jumlah_barang[0]"
                                                value=""
                                                class="form-control" required="true" min="0"/>
                                                <small class="text-danger"><?php echo form_error('insert_jumlah_barang'); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <select name="insert_satuan[0]" class="selectpicker form-control" data-size="3" data-style="btn btn-light btn-sm" title="Single Select">
                                                    <option value="kodi" selected>Kodi</option>
                                                    <option value="lusin">Lusin</option>
                                                    <option value="pasang">Pasang</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Harga per satuan</label>
                                                <input type="number" min="0" name="insert_harga_per_satuan[0]"
                                                value="0"
                                                class="form-control" />
                                                <small class="text-danger"><?php echo form_error('insert_harga_per_satuan'); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-md-2 d-flex justify-content-center align-items-center p-0">
                                            <button type="button" class="btn btn-danger btn-sm  mt-3  remove_rincian_barang">
                                                <span class="material-icons">
                                                remove_circle
                                                </span> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-sm btn-outline-primary btn-block mt-3 mb-5" onclick="tambah_rincian_barang()" type="button">
                                    Tambah Item
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="mr-auto">
                        <input type="button" class="btn btn-previous btn-fill btn-default btn-wd disabled" name="previous" value="Previous">
                    </div>
                    <div class="ml-auto">
                        <input type="button" class="btn btn-next btn-fill btn-info btn-wd" name="next" value="Next">
                        <input type="button" class="btn btn-finish btn-fill btn-info btn-wd" name="finish" value="Finish" style="display: none;">
                    </div>
                <div class="clearfix"></div>
                </div>
            </form>
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

    // $barang_lookup = [];
    // foreach ($data_barang as $k => $v) {
    //   $barang_lookup[] = array(
    //     "value" => $v->merek.'  '.$v->tipe.'  '.$v->warna.'  '.$v->ukuran.' ('.$v->kode_barang.')',
    //     "code" => $v->id_barang
    //   );
    // }

  ?>

  function tambah_rincian_barang(){
    $element_index = $(".input_barang").length;
    $cloned_element = $(".input_barang").first().clone();

    $cloned_element.appendTo( ".rincian_barang_container");

    $cloned_element.find('[name="autocomplete_insert_id_barang[0]"]').attr("name", "autocomplete_insert_id_barang["+$element_index+"]").val(null);
    $cloned_element.find('[name="insert_jumlah_barang[0]"]').attr("name", "insert_jumlah_barang["+$element_index+"]").val(null);
    $cloned_element.find('[name="insert_harga_per_satuan[0]"]').attr("name", "insert_harga_per_satuan["+$element_index+"]")
    $cloned_element.find('[name="insert_satuan[0]"]').attr("name", "insert_satuan["+$element_index+"]");

    $cloned_element.find('.bootstrap-select').replaceWith(function() { return $('select', this); });
    $cloned_element.find('.bs-title-option').remove();
    $cloned_element.find('[name="insert_satuan['+$element_index+']"]').selectpicker(); 

    $cloned_element.find('[name="autocomplete_insert_id_barang['+$element_index+']"]').focus();    

    md.setInputAutoCompleteAjax($cloned_element.find('[name="autocomplete_insert_id_barang['+$element_index+']"]'), '<?= base_url('asisten-manager-gudang/get-ajax-lookup-barang')?>');
  }
  

  $gudang = JSON.parse('<?= json_encode($gudang_lookup);?>');
  $supplier = JSON.parse('<?= json_encode($supplier_lookup);?>');
  
  $(document).ready(function () {
    md.initMaterialWizard('#wizardPreOrder', $('#formInsertPreOrder').validate());
    md.initFormExtendedDatetimepickers();

    $('#wizardPreOrder').on('click', '.remove_rincian_barang', function(){
      if($('.input_barang').length > 1){
        $(this).parents('.input_barang').fadeOut(function(){
          $(this).remove();
        })
      }
    })
    
    md.setInputAutoComplete('#autocomplete_insert_pre_order_id_gudang_tujuan', $gudang);
    md.setInputAutoComplete('#autocomplete_insert_pre_order_id_supplier', $supplier);
    md.setInputAutoCompleteAjax('[name="autocomplete_insert_id_barang[0]"]', '<?= base_url('asisten-manager-gudang/get-ajax-lookup-barang')?>');

  });

</script>