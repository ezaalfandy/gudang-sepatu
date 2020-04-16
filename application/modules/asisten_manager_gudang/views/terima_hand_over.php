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
                        <b> Danger - </b> '.$this->session->userdata('message').'</span>
                    </div>
                ';
                }
            ?>
        </div>
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <form novalidate="novalidate" id="formEditHandOver" action="<?= base_url('asisten-manager-gudang/terima-hand-over')?>" method="post" accept-charset="utf-8">
                    <div class="card-header card-header-icon card-header-info">
                        <div class="card-icon">
                            <i class="material-icons">edit_drive_file</i>
                        </div>
                        <h4 class="card-title ">#<?= $data_hand_over->kode_hand_over?></h4>
                    </div>
                    <div class="card-body px-5">
                        <div class="row mt-4">
                            
                            <input type="hidden" name="edit_id_hand_over" value="<?= $data_hand_over->id_hand_over?>">

                            <div class="col-md-12">
                                <div class="form-group is-filled">
                                    <label for="autocomplete_edit_hand_over_id_gudang_asal"> Gudang asal</label>
                                    <input type="hidden" name="edit_id_gudang_asal" value="<?= $data_hand_over->id_gudang_asal?>">
                                    <input type="text" name="autocomplete_edit_id_gudang_asal"
                                    value="<?php echo set_value('edit_id_gudang_asal'); ?>" id="autocomplete_edit_hand_over_id_gudang_asal"
                                    class="form-control" required="true"/>
                                    <small class="text-danger"><?php echo form_error('edit_id_gudang_asal'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group is-filled">
                                    <label for="autocomplete_edit_hand_over_id_gudang_tujuan" > Gudang Tujuan</label>
                                    <input type="hidden" name="edit_id_gudang_tujuan">

                                    <input type="text" name="autocomplete_edit_id_gudang_tujuan"
                                    value="<?php echo set_value('edit_id_gudang_tujuan'); ?>" id="autocomplete_edit_hand_over_id_gudang_tujuan"
                                    class="form-control" required="true" notEqualTo="#autocomplete_edit_hand_over_id_gudang_asal"/>
                                    <small class="text-danger"><?php echo form_error('edit_id_gudang_tujuan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="edit_hand_over_tanggal_dibuat">Tanggal Terbit</label>
                                    <input type="date" name="edit_tanggal_dibuat"
                                    value="<?php echo set_value('edit_tanggal_dibuat'); ?>" id="edit_hand_over_tanggal_dibuat"
                                    class="form-control" required="true"/>
                                    <small class="text-danger"><?php echo form_error('edit_tanggal_dibuat'); ?></small>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center rincian_barang_container">
                            <div class="col-md-12 mt-5">
                                <h5 class="text-center">Rincian Barang</h5>
                            </div>

                            <?php for ($i=0; $i < count($data_detail_hand_over) ; $i++):?>
                                <div class="col-md-12 input_barang mb-4 py-3 border border-dark">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nama Barang</label>
                                                <input type="hidden" name="edit_id_barang[<?= $i?>]">
                                                <input type="text" name="autocomplete_edit_id_barang[<?= $i?>]"
                                                class="form-control" required="true" />
                                                <small class="text-danger"><?php echo form_error('edit_id_barang'); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Jumlah</label>
                                                <input type="number" name="edit_jumlah_barang[<?= $i?>]"
                                                value="<?= $data_detail_hand_over[$i]->jumlah ?>"
                                                class="form-control" required="true" min="0"/>
                                                <small class="text-danger"><?php echo form_error('edit_jumlah_barang'); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select name="edit_satuan[<?= $i?>]" class="selectpicker form-control" data-size="3" data-style="btn btn-light btn-sm" title="Single Select" class="form-control">
                                                    <option value="kodi" <?php echo ($data_detail_hand_over[$i]->satuan == 'kodi') ?  'selected' : ''?>>Kodi</option>
                                                    <option value="lusin" <?php echo ($data_detail_hand_over[$i]->satuan == 'lusin') ? 'selected' : ''?>>Lusin</option>
                                                    <option value="pasang" <?php echo ($data_detail_hand_over[$i]->satuan == 'pasang') ? 'selected' : ''?>>Pasang</option>
                                                </select>
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
                            <?php endfor;?>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button class="btn btn-sm btn-outline-primary mt-3 mb-5" onclick="tambah_rincian_barang()" type="button">
                                Tambah Item
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php if($data_hand_over->status_hand_over == 'diproses'):?>
                        <div class="card-footer">
                            <input type="submit" value="Terima Hand Over" class="btn btn-success btn-block">
                        </div>
                    <?php endif?>
                </form>
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

        $available_barang_lookup = [];
        foreach ($data_barang as $k => $v) {
            $available_barang_lookup[] = array(
                "value" => $v->merek.'  '.$v->tipe.'  '.$v->warna.'  '.$v->ukuran.' ('.$v->kode_barang.')',
                "code" => $v->id_barang,
                "max" => $v->jumlah_stok
            );
        }

        $data_barang_hand_over = [];
    
        foreach ($data_detail_hand_over as $k => $v) {
            $data_barang_hand_over[] = array(
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

        $cloned_element.find('[name="autocomplete_edit_id_barang[0]"]').attr("name", "autocomplete_edit_id_barang["+$element_index+"]").val(null);
        $cloned_element.find('[name="edit_jumlah_barang[0]"]').attr("name", "edit_jumlah_barang["+$element_index+"]").val(null);
        $cloned_element.find('[name="edit_satuan[0]"]').attr("name", "edit_satuan["+$element_index+"]");

        $cloned_element.find('.bootstrap-select').replaceWith(function() { return $('select', this); });
        $cloned_element.find('.bs-title-option').remove();
        $cloned_element.find('[name="edit_satuan['+$element_index+']"]').selectpicker(); 
        
        $cloned_element.find('[name="autocomplete_edit_id_barang[0]"]').focus();
        
        md.setInputAutoComplete($cloned_element.find('[name="autocomplete_edit_id_barang['+$element_index+']"]'), $available_barang);
    }

    $gudang = JSON.parse('<?= json_encode($gudang_lookup);?>');
    $available_barang = JSON.parse('<?= json_encode($available_barang_lookup);?>');

    
    $data_barang_hand_over = JSON.parse('<?= json_encode($data_barang_hand_over);?>');

    $(document).ready(function () {

        $('#formEditHandOver').on('click', '.remove_rincian_barang', function(){
            if($('.input_barang').length > 1){
                $(this).parents('.input_barang').fadeOut(function(){
                    $(this).remove();
                })
            }
        })
        
        $('#formEditHandOver').on('change','[name*="edit_satuan"]',  function () {
            $pembagi = md.convertSatuanToPasang($(this).val());
            $input_jumlah = $(this).parents('.input_barang').find('[name*="edit_jumlah_barang"]');
            $input_jumlah.attr('max', parseInt($input_jumlah.data('jumlahPasang') / $pembagi).toFixed() );
        });

        //aktivasi autocomplete
        setAutoCompleteGudangAsal('#autocomplete_edit_hand_over_id_gudang_asal', $gudang);
        md.setInputAutoComplete('#autocomplete_edit_hand_over_id_gudang_tujuan', $gudang);

        //set nilai autocomplete
        $('#autocomplete_edit_hand_over_id_gudang_tujuan').val('<?= $data_hand_over->kode_gudang_tujuan.' - '.$data_hand_over->kabupaten_kota_tujuan?>').autocomplete('onValueChange').parents('.form-group').addClass('is-filled');
        $('#autocomplete_edit_hand_over_id_gudang_asal').val('<?= $data_hand_over->kode_gudang_asal.' - '.$data_hand_over->kabupaten_kota_asal?>').autocomplete('onValueChange').parents('.form-group').addClass('is-filled');

        $.each($data_barang_hand_over, function (i, v) { 
            setAutoCompleteBarang('[name="autocomplete_edit_id_barang['+i+']"]', $available_barang)
            $('[name="autocomplete_edit_id_barang['+i+']"]').val(v.value).autocomplete('onValueChange').parents('.form-group').addClass('is-filled');
        });

        $('#edit_hand_over_tanggal_dibuat').val('<?= $data_hand_over->tanggal_dibuat?>').parents('.form-group').addClass('is-filled');
        $('#formEditHandOver').validate();
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
                    $.getJSON("<?= base_url('Asisten-manager-gudang/get-specific-stok-barang/')?>"+suggestion.code,
                        function (data, textStatus, jqXHR) {

                            $cloned_element.appendTo(".rincian_barang_container");
                            $cloned_element.find('[name="autocomplete_edit_id_barang[0]"]').attr("name", "autocomplete_edit_id_barang[0]").val(null);
                            $cloned_element.find('[name="edit_jumlah_barang[0]"]').attr("name", "edit_jumlah_barang[0]").val(null);
                            $cloned_element.find('[name="edit_satuan[0]"]').attr("name", "edit_satuan[0]").val(null);
                            
                            //Inisialisasi ulang selectpicker
                            md.reInitSelectpicker($cloned_element.find('[name="edit_satuan[0]"]'))

                            $available_barang = [];
                            $.each(data, function (i, v) { 
                                $available_barang.push({
                                    "value" : v.merek+'  '+v.tipe+'  '+v.warna+'  '+v.ukuran+' ('+v.kode_barang+') stok : '+v.jumlah_stok+' pasang',
                                    "code" : v.id_barang,
                                    "max" : v.jumlah_stok
                                });
                            });
                            setAutoCompleteBarang('[name="autocomplete_edit_id_barang[0]"]', $available_barang);
                            
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

                $satuan = $($element).parents('.input_barang').find('[name*="edit_satuan"]').val();

                $pembagi = md.convertSatuanToPasang($satuan);
                $input_jumlah = $($element).parents('.input_barang').find('[name*="edit_jumlah_barang"]');
                
                $input_jumlah.attr('data-jumlah-pasang',suggestion.max);
                $input_jumlah.attr('max', parseInt(suggestion.max / $pembagi).toFixed() );

            },
            autoSelectFirst: true
        });
    }

</script>