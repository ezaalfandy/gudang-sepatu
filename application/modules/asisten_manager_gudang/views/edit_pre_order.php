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
                <form novalidate="novalidate" id="formEditPreOrder" action="<?= base_url('asisten-manager-gudang/edit-pre-order')?>" method="post" accept-charset="utf-8">
                    <div class="card-header card-header-icon card-header-info">
                        <div class="card-icon">
                            <i class="material-icons">edit_drive_file</i>
                        </div>
                        <h4 class="card-title ">#<?= $data_pre_order->kode_pre_order?></h4>
                    </div>
                    <div class="card-body px-5">
                        <div class="row mt-4">
                            
                            <input type="hidden" name="edit_id_pre_order" value="<?= $data_pre_order->id_pre_order?>">

                            <div class="col-md-12">
                                <div class="form-group is-filled">
                                    <label for="autocomplete_edit_pre_order_id_supplier"> Supplier</label>
                                    <input type="hidden" name="edit_id_supplier">
                                    <input type="text" name="autocomplete_edit_id_supplier"
                                    value="<?php echo set_value('edit_id_supplier'); ?>" id="autocomplete_edit_pre_order_id_supplier"
                                    class="form-control" required="true"/>
                                    <small class="text-danger"><?php echo form_error('edit_id_supplier'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group is-filled">
                                    <label for="autocomplete_edit_pre_order_id_gudang_tujuan" > Gudang Tujuan</label>
                                    <input type="hidden" name="edit_id_gudang_tujuan">

                                    <input type="text" name="autocomplete_edit_id_gudang_tujuan"
                                    value="<?php echo set_value('edit_id_gudang_tujuan'); ?>" id="autocomplete_edit_pre_order_id_gudang_tujuan"
                                    class="form-control" required="true"/>
                                    <small class="text-danger"><?php echo form_error('edit_id_gudang_tujuan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="edit_pre_order_tanggal_dibuat">Tanggal Terbit</label>
                                    <input type="date" name="edit_tanggal_dibuat"
                                    value="<?php echo set_value('edit_tanggal_dibuat'); ?>" id="edit_pre_order_tanggal_dibuat"
                                    class="form-control" required="true"/>
                                    <small class="text-danger"><?php echo form_error('edit_tanggal_dibuat'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="edit_pre_order_tanggal_setor">Tanggal Setor</label>
                                    <input type="date" name="edit_tanggal_setor"
                                    value="<?php echo set_value('edit_tanggal_setor'); ?>" id="edit_pre_order_tanggal_setor"
                                    class="form-control" required="true"/>
                                    <small class="text-danger"><?php echo form_error('edit_tanggal_setor'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="edit_pre_order_total_harga">Total Harga</label>
                                    <input type="text" name="edit_total_harga"
                                    value="<?php echo set_value('edit_total_harga'); ?>" id="edit_pre_order_total_harga"
                                    class="form-control" readonly/>
                                    <small class="text-danger"><?php echo form_error('edit_total_harga'); ?></small>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center rincian_barang_container">
                            <div class="col-md-12 mt-5">
                                <h5 class="text-center">Rincian Barang</h5>
                            </div>

                            <?php for ($i=0; $i < count($data_detail_pre_order) ; $i++):?>
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
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Jumlah</label>
                                                <input type="number" name="edit_jumlah_barang[<?= $i?>]"
                                                value="<?= $data_detail_pre_order[$i]->jumlah ?>"
                                                class="form-control" required="true" min="0"/>
                                                <small class="text-danger"><?php echo form_error('edit_jumlah_barang'); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <select name="edit_satuan[<?= $i?>]" class="selectpicker form-control" data-size="3" data-style="btn btn-light btn-sm" title="Single Select" class="form-control">
                                                    <option value="kodi" <?php echo ($data_detail_pre_order[$i]->satuan == 'kodi') ?  'selected' : ''?>>Kodi</option>
                                                    <option value="lusin" <?php echo ($data_detail_pre_order[$i]->satuan == 'lusin') ? 'selected' : ''?>>Lusin</option>
                                                    <option value="pasang" <?php echo ($data_detail_pre_order[$i]->satuan == 'pasang') ? 'selected' : ''?>>Pasang</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Harga per satuan</label>
                                                <input type="number" min="0" name="edit_harga_per_satuan[<?= $i?>]"
                                                value="<?= $data_detail_pre_order[$i]->harga_per_satuan ?>"
                                                class="form-control" />
                                                <small class="text-danger"><?php echo form_error('edit_harga_per_satuan'); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-md-2 d-flex justify-content-center align-items-center p-0">
                                            <button type="button" class="btn btn-danger btn-sm remove_rincian_barang">
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
                    <div class="card-footer">
                        <input type="submit" value="Ubah" class="btn btn-info btn-block">
                    </div>
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

        $data_barang_pre_order = [];
    
        foreach ($data_detail_pre_order as $k => $v) {
            $data_barang_pre_order[] = array(
                "value" => $v->merek.'  '.$v->tipe.'  '.$v->warna.'  '.$v->ukuran.' ('.$v->kode_barang.')',
                "code" => $v->id_barang
            );
        }
    ?>
    
    function tambah_rincian_barang(){
        $element_index = $(".input_barang").length;
        $cloned_element = $(".input_barang").first().clone();

        $cloned_element.appendTo( ".rincian_barang_container");

        $cloned_element.find('[name="edit_id_barang[0]"]').attr("name", "edit_id_barang["+$element_index+"]");
        $cloned_element.find('[name="autocomplete_edit_id_barang[0]"]').attr("name", "autocomplete_edit_id_barang["+$element_index+"]").val(null);
        $cloned_element.find('[name="edit_jumlah_barang[0]"]').attr("name", "edit_jumlah_barang["+$element_index+"]").val(null);
        $cloned_element.find('[name="edit_harga_per_satuan[0]"]').attr("name", "edit_harga_per_satuan["+$element_index+"]").val(null);
        $cloned_element.find('[name="edit_satuan[0]"]').attr("name", "edit_satuan["+$element_index+"]");

        $cloned_element.find('.bootstrap-select').replaceWith(function() { return $('select', this); });
        $cloned_element.find('.bs-title-option').remove();
        $cloned_element.find('[name="edit_satuan['+$element_index+']"]').selectpicker(); 

        $cloned_element.find('[name="autocomplete_edit_id_barang['+$element_index+']"]').focus();    

        md.setInputAutoComplete($cloned_element.find('[name="autocomplete_edit_id_barang['+$element_index+']"]'), $barang);
    }

    $gudang = JSON.parse('<?= json_encode($gudang_lookup);?>');
    $supplier = JSON.parse('<?= json_encode($supplier_lookup);?>');
    $barang = JSON.parse('<?= json_encode($barang_lookup);?>');

    
    $data_barang_pre_order = JSON.parse('<?= json_encode($data_barang_pre_order);?>');
    $(document).ready(function () {

        $('#formEditPreOrder').on('click', '.remove_rincian_barang', function(){
            if($('.input_barang').length > 1){
                $(this).parents('.input_barang').fadeOut(function(){
                    $(this).remove();
                })
            }
        })
        
        //aktivasi autocomplete
        md.setInputAutoComplete('#autocomplete_edit_pre_order_id_gudang_tujuan', $gudang);
        md.setInputAutoComplete('#autocomplete_edit_pre_order_id_supplier', $supplier);
        md.setInputAutoComplete('[name="autocomplete_edit_id_barang[0]"]', $barang);

        //set nilai autocomplete
        $('#autocomplete_edit_pre_order_id_gudang_tujuan').val('<?= $data_pre_order->kode_gudang.' - '.$data_pre_order->kabupaten_kota?>').autocomplete('onValueChange').parents('.form-group').addClass('is-filled');
        $('#autocomplete_edit_pre_order_id_supplier').val('<?= $data_pre_order->nama_supplier.' - '.$data_pre_order->alamat_supplier?>').autocomplete('onValueChange').parents('.form-group').addClass('is-filled');

        $.each($data_barang_pre_order, function (i, v) { 
            md.setInputAutoComplete('[name="autocomplete_edit_id_barang['+i+']"]', $barang)
            $('[name="autocomplete_edit_id_barang['+i+']"]').val(v.value).autocomplete('onValueChange').parents('.form-group').addClass('is-filled');
        });
        
        $('#edit_pre_order_total_harga').val('Rp <?= number_format($data_pre_order->total_harga, 0, ".", ".")?>').parents('.form-group').addClass('is-filled');

        $('#edit_pre_order_tanggal_dibuat').val('<?= $data_pre_order->tanggal_dibuat?>').parents('.form-group').addClass('is-filled');
        $('#edit_pre_order_tanggal_setor').val('<?= $data_pre_order->tanggal_setor?>').parents('.form-group').addClass('is-filled');
        $('#formEditPreOrder').validate();
    });

</script>