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
            <div class="card card-wizard active" data-color="blue" id="wizardHandOver">
            <form novalidate="novalidate" id="formInsertHandOver"
        action="<?= base_url('asisten-manager-gudang/insert-hand-over')?>" method="post" accept-charset="utf-8">
                <div class="card-header text-center">
                    <h3 class="card-title">
                        Tambah Data Hand Over
                    </h3>
                <h5 class="card-description">Pastikan anda mengisi formulir dengan benar.</h5>
                </div>
                <div class="wizard-navigation">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" href="#data_hand_over" data-toggle="tab" role="tab">
                                Data Hand Over
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#data_detail_hand_over" data-toggle="tab" role="tab">
                                Detail Item
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="data_hand_over">
                            <div class="row justify-content-center px-5">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="autocomplete_insert_hand_over_id_gudang_asal"> Gudang asal</label>
                                        <input type="hidden" name="insert_id_gudang_asal">

                                        <input type="text" name="autocomplete_insert_id_gudang_asal"
                                        value="<?php echo set_value('insert_id_gudang_asal'); ?>" id="autocomplete_insert_hand_over_id_gudang_asal"
                                        class="form-control" required="true"/>
                                        <small class="text-danger"><?php echo form_error('insert_id_gudang_asal'); ?></small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="autocomplete_insert_hand_over_id_gudang_tujuan" > Gudang Tujuan</label>
                                        <input type="hidden" name="insert_id_gudang_tujuan">

                                        <input type="text" name="autocomplete_insert_id_gudang_tujuan"
                                        value="<?php echo set_value('insert_id_gudang_tujuan'); ?>" id="autocomplete_insert_hand_over_id_gudang_tujuan"
                                        class="form-control" required="true" notEqualTo="#autocomplete_insert_hand_over_id_gudang_asal"/>

                                        <small class="text-danger"><?php echo form_error('insert_id_gudang_tujuan'); ?></small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="insert_hand_over_tanggal_dibuat">Tanggal Terbit</label>
                                        <input type="text" name="insert_tanggal_dibuat"
                                        value="<?php echo set_value('insert_tanggal_dibuat', Date('d-m-Y')); ?>" id="insert_hand_over_tanggal_dibuat"
                                        class="form-control datepicker" required="true"/>
                                        <small class="text-danger"><?php echo form_error('insert_tanggal_dibuat'); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="data_detail_hand_over">
                            <div class="row justify-content-center rincian_barang_container">
                                <div class="col-md-12 input_barang mb-4 py-3 border border-dark">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Barang</label>
                                                <input type="hidden" name="insert_id_barang[]">
                                                <input type="text" name="autocomplete_insert_id_barang[0]"
                                                value=""
                                                class="form-control" required="true" />
                                                <small class="text-danger"><?php echo form_error('insert_id_barang'); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
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
                                        <div class="col-md-12 d-flex justify-content-center align-items-center p-0">
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
    $cloned_element.find('[name="insert_satuan[0]"]').attr("name", "insert_satuan["+$element_index+"]");

    $cloned_element.find('.bootstrap-select').replaceWith(function() { return $('select', this); });
    $cloned_element.find('.bs-title-option').remove();
    $cloned_element.find('[name="insert_satuan['+$element_index+']"]').selectpicker(); 
    
    $cloned_element.find('[name="autocomplete_insert_id_barang[0]"]').focus();
    
    md.setInputAutoComplete($cloned_element.find('[name="autocomplete_insert_id_barang['+$element_index+']"]'), $barang);
  }
  

  $gudang = JSON.parse('<?= json_encode($gudang_lookup);?>');
  $barang = JSON.parse('<?= json_encode($barang_lookup);?>');
  
  $(document).ready(function () {
    md.initMaterialWizard('#wizardHandOver', $('#formInsertHandOver').validate());
    md.initFormExtendedDatetimepickers();
    
    $('#formInsertHandOver').on('click', '.remove_rincian_barang', function()
        {
            if($('.input_barang').length > 1)
            {
                $(this).parents('.input_barang').fadeOut(function()
                {
                    $(this).remove();
                })
            }
        }
    )

    $('#formInsertHandOver').on('change','[name*="insert_satuan"]',  function () {
        $pembagi = md.convertSatuanToPasang($(this).val());
        $input_jumlah = $(this).parents('.input_barang').find('[name*="insert_jumlah_barang"]');
        $input_jumlah.attr('max', parseInt($input_jumlah.data('jumlahPasang') / $pembagi).toFixed() );

    });

    md.setInputAutoComplete('#autocomplete_insert_hand_over_id_gudang_tujuan', $gudang);
    setAutoCompleteGudangAsal('#autocomplete_insert_hand_over_id_gudang_asal', $gudang);
    md.setInputAutoComplete('[name="autocomplete_insert_id_barang[0]"]', $barang);

  });


  function setAutoCompleteGudangAsal($element, $lookup){

    $($element).autocomplete({
        lookup: $lookup,
        onSelect: function (suggestion) {
          $hidden_input = $($element).siblings('[type="hidden"]');
          if(suggestion.code !== $hidden_input.val())
          {
            //HARUS DILAKUKAN PENGECEKAN, CODE DIBAWAH AKAN DI RUN APABILA USER MENGUBAH PILIHAN GUDANG ASAL
            $hidden_input.val(suggestion.code);

            //KETIKA GUDANG ASAL DIHAPUS/DIUBAH, INPUTAN DETAIL BARANG AKAN HILANG
            $cloned_element = $(".input_barang").first().clone();
            $('.rincian_barang_container').empty();

            //MENGAMBIL DATA BARANG YANG VALID BERDASARKAN GUDANG ASAL YANG DIPILIH
            $.getJSON("<?= base_url('Asisten-manager-gudang/get-all-specific-stok-barang/')?>"+suggestion.code,
              function (data, textStatus, jqXHR) {

                $cloned_element.appendTo(".rincian_barang_container");
                $cloned_element.find('[name="autocomplete_insert_id_barang[0]"]').attr("name", "autocomplete_insert_id_barang[0]").val(null);
                $cloned_element.find('[name="insert_jumlah_barang[0]"]').attr("name", "insert_jumlah_barang[0]").val(null);
                $cloned_element.find('[name="insert_satuan[0]"]').attr("name", "insert_satuan[0]").val(null);
                
                //Inisialisasi ulang selectpicker
                md.reInitSelectpicker($cloned_element.find('[name="insert_satuan[0]"]'))

                $barang = [];
                $.each(data, function (i, v) { 
                  $barang.push({
                    "value" : v.merek+'  '+v.tipe+'  '+v.warna+'  '+v.ukuran+' ('+v.kode_barang+') stok : '+v.jumlah_stok+' pasang',
                    "code" : v.id_barang,
                    "max" : v.jumlah_stok
                  });
                });
                setAutoCompleteBarang('[name="autocomplete_insert_id_barang[0]"]', $barang);
                
              }
            );
          }

        },
        autoSelectFirst: true
    });

    $($element).on("focusout", function(){
      setTimeout(function(){
        var status = false;
        $.each($lookup, function (i, v) { 

          if(v.value == $($element).val()){
            status = true;
          }
        });

        if(status == false){
          $($element).val(null)
          //MENSET INPUT ID KE NOL
          $hidden_input = $($element).siblings('[type="hidden"]');
          $hidden_input.val(null);
        }
      }, 1000);
    });

  }

  function setAutoCompleteBarang($element, $lookup){
    $($element).autocomplete({
      lookup: $lookup,
      onSelect: function (suggestion) {
        /*
          Blok kode dibawah ini digunakan untuk menseting attribut max 
          pada input jumlah barang berdasarkan stok yang tersedia
        */
        $hidden_input = $($element).siblings('[type="hidden"]');
        $hidden_input.val(suggestion.code);

        $satuan = $($element).parents('.input_barang').find('[name*="insert_satuan"]').val();

        $pembagi = md.convertSatuanToPasang($satuan);
        $input_jumlah = $($element).parents('.input_barang').find('[name*="insert_jumlah_barang"]');
        
        $input_jumlah.attr('data-jumlah-pasang',suggestion.max);
        $input_jumlah.attr('max', parseInt(suggestion.max / $pembagi).toFixed() );
      },
      autoSelectFirst: true
    });
  }
</script>