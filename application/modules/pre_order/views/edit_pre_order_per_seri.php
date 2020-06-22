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
                <form novalidate="novalidate" id="formEditPreOrder" action="<?= base_url('asisten-manager-gudang/edit-pre-order/')?>" method="post" accept-charset="utf-8">
                    <div class="card-header card-header-icon card-header-info">
                        <div class="card-icon">
                            <i class="material-icons">edit_drive_file</i>
                        </div>
                        <h4 class="card-title ">#<?= $data_pre_order->kode_pre_order?> - Mode Seri <a href="<?= base_url('asisten-manager-gudang/view-edit-pre-order/'.$data_pre_order->kode_pre_order.'/mode-satuan')?>" class="text-primary"><small>(ganti)</small></a></h4>
                    </div>
                    <div class="card-body px-5">
                        <div class="row mt-4">
                            
                            <input type="hidden" name="edit_id_pre_order" value="<?= $data_pre_order->id_pre_order?>"  required="true">

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

                            <?php $index = 0;?>
                            <?php foreach ($seri as $k => $v):?>
                                <div class="col-md-12 input_barang mb-4 py-3 border border-dark">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Nama Barang</label>
                                                <input type="hidden" name="edit_id_barang[<?= $index?>]" value="<?= $v['id_barang']?>">
                                                <input type="text" name="autocomplete_edit_id_barang[<?= $index?>]"
                                                class="form-control" required="true"  value="<?= $k?>"/>
                                                <small class="text-danger"><?php echo form_error('edit_id_barang'); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Jumlah(kodi)</label>
                                                <input type="number" name="edit_jumlah_barang[<?= $index?>]"
                                                value="<?= array_sum($v['ukuran']) / 20 ?>"
                                                class="form-control" required="true" min="0"/>
                                                <small class="text-danger"><?php echo form_error('edit_jumlah_barang'); ?></small>
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
                            <?php $index++;?>
                            <?php endforeach;?>
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

        $data_barang_pre_order = [];
    
        foreach ($seri as $k => $v) {
            $data_barang_pre_order[] = array(
                "value" => $k,
                "code" => $k
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
        $cloned_element.find('[name="edit_harga_per_satuan[0]"]').attr("name", "edit_harga_per_satuan["+$element_index+"]").val(0);
        $cloned_element.find('[name="edit_satuan[0]"]').attr("name", "edit_satuan["+$element_index+"]");

        $cloned_element.find('.bootstrap-select').replaceWith(function() { return $('select', this); });
        $cloned_element.find('.bs-title-option').remove();
        $cloned_element.find('[name="edit_satuan['+$element_index+']"]').selectpicker(); 

        $cloned_element.find('[name="autocomplete_edit_id_barang['+$element_index+']"]').focus();    

        md.setInputAutoCompleteAjax($cloned_element.find('[name="autocomplete_edit_id_barang['+$element_index+']"]'), '<?= base_url('asisten-manager-gudang/get-ajax-lookup-barang')?>');
    }

    $gudang = JSON.parse('<?= json_encode($gudang_lookup);?>');
    $supplier = JSON.parse('<?= json_encode($supplier_lookup);?>');
    
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
        md.setInputAutoCompleteAjax('[name="autocomplete_edit_id_barang[0]"]', '<?= base_url('asisten-manager-gudang/get-ajax-lookup-barang')?>');

        //set nilai autocomplete
        $('#autocomplete_edit_pre_order_id_gudang_tujuan').val('<?= $data_pre_order->kode_gudang.' - '.$data_pre_order->kabupaten_kota?>').autocomplete('onValueChange').parents('.form-group').addClass('is-filled');
        $('#autocomplete_edit_pre_order_id_supplier').val('<?= $data_pre_order->nama_supplier.' - '.$data_pre_order->alamat_supplier?>').autocomplete('onValueChange').parents('.form-group').addClass('is-filled');

        $.each($data_barang_pre_order, function (i, v) { 
            md.setInputAutoCompleteAjax('[name="autocomplete_edit_id_barang['+i+']"]', '<?= base_url('asisten-manager-gudang/get-ajax-lookup-barang')?>');
        });
        
        $('#edit_pre_order_total_harga').val('Rp <?= number_format($data_pre_order->total_harga, 0, ".", ".")?>').parents('.form-group').addClass('is-filled');

        $('#edit_pre_order_tanggal_dibuat').val('<?= $data_pre_order->tanggal_dibuat?>').parents('.form-group').addClass('is-filled');
        $('#edit_pre_order_tanggal_setor').val('<?= $data_pre_order->tanggal_setor?>').parents('.form-group').addClass('is-filled');
        $('#formEditPreOrder').validate();
    });

</script>