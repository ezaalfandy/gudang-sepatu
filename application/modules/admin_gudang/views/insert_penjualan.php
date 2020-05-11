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
        <div class="col-md-5">
            <div class="card">
                <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">shopping_cart</i>
                    </div>
                    <h4 class="card-title">Penjualan Terakhir</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="tablePenjualan">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Jenis</th>
                                            <th>Item</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $n = 1;?>
                                            <?php foreach ($data_penjualan as $k => $v):?>
                                                <tr>
                                                    <td scope="row"><?= $n++?></td>
                                                    <td><?= $v->kode_order?></td>
                                                    <td><?= $v->jenis_transaksi?></td>
                                                    <td><?= $v->barang?></td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <button class="btn btn-danger btn-sm btn-block" onclick="deletePenjualan(<?= $v->id_penjualan?>)">
                                                                    <i class="material-icons">
                                                                        delete
                                                                    </i>
                                                                </button>
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
        <div class="col-md-7">
            <div class="card">
                <div class="card-header card-header-primary card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">attach_money</i>
                    </div>
                    <h4 class="card-title">Input penjualan</h4>
                </div>
                <form action="<?= base_url('admin-gudang/insert-penjualan')?>" method="post" accept-charset="utf-8"
                novalidate="novalidate" id="formPenjualan" enctype="multipart/form-data">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="insert_penjualan_jenis_transaksi">Jenis Transaksi</label>
                                    <select name="insert_jenis_transaksi" class="selectpicker form-control" data-style="btn btn-primary" data-size="4" title="Single Select" id="insert_penjualan_jenis_transaksi">
                                        <option value="lazada" selected>Lazada</option>
                                        <option value="shopee">Shopee</option>
                                        <option value="tokopedia">Tokopedia</option>
                                        <option value="bukalapak">Bukalapak</option>
                                        <option value="blibli">Blibli</option>
                                        <option value="social_media">FB / WA / IG</option>
                                        <option value="offline">Offline / pembelian langsung</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mt-4">
                                    <label for="insert_penjualan_kode_order">Kode Order</label>
                                    <input type="text" name="insert_kode_order" value="<?php echo set_value('merek'); ?>" id="insert_penjualan_kode_order"
                                    class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p class="h5 text-center mt-3">Daftar Item</p>
                            </div>
                            <div class="col-md-12 detail-item-container">
                                <div class="row detail-item">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Barang</label>
                                            <input type="hidden" name="insert_id_barang[]">
                                            <input type="text" name="autocomplete_insert_id_barang[0]"
                                            value=""
                                            class="form-control" />
                                            <small class="text-danger"><?php echo form_error('insert_id_barang'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Jumlah</label>
                                            <input type="number" name="insert_jumlah_barang[0]"
                                            value=""
                                            class="form-control" min="0"/>
                                            <small class="text-danger"><?php echo form_error('insert_jumlah_barang'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex justify-content-center align-items-center p-0">
                                        <button type="button" class="btn btn-danger btn-sm  mt-3  remove_rincian_barang">
                                            <span class="material-icons">
                                            remove_circle
                                            </span> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <button class="btn btn-sm btn-outline-primary my-3" onclick="tambah_rincian_barang()" type="button">
                                Tambah Item
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">Submit</button>
                        <button type="reset" class="btn btn-default btn-link">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $current_autocomplete = null; //variable untuk menyimpan posisi autocomplete saat ini
    <?php
        $barang_lookup = [];
        foreach ($data_stok_barang as $k => $v) {
            $barang_lookup[] = array(
                "value" => $v->merek.'  '.$v->tipe.'  '.$v->warna.'  '.$v->ukuran.' ('.$v->kode_barang.' - '.$v->jumlah_stok.' Pasang)',
                "code" => $v->id_barang,
                "max" => $v->jumlah_stok
            );
        }
    ?>

    function tambah_rincian_barang()
    {
        $element_index = $(".detail-item").length;
        $cloned_element = $(".detail-item").first().clone();
        $cloned_element.appendTo( ".detail-item-container");

        $cloned_element.find('[name="autocomplete_insert_id_barang[0]"]').attr("name", "autocomplete_insert_id_barang["+$element_index+"]").val(null);
        $cloned_element.find('[name="insert_id_barang[]"]').attr("name", "insert_id_barang["+$element_index+"]").val(null);
        $cloned_element.find('[name="insert_jumlah_barang[0]"]').attr("name", "insert_jumlah_barang["+$element_index+"]").val(null);

        $cloned_element.find('[name="autocomplete_insert_id_barang['+$element_index+']"]').focus();

        setAutoCompleteBarang($cloned_element.find('[name="autocomplete_insert_id_barang['+$element_index+']"]'), $barang);
    }

    $barang = JSON.parse('<?= json_encode($barang_lookup);?>');

    $(document).ready(function () {
        var tablePenjualan = $('#tablePenjualan').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "columnDefs": [
                { "width": "40%", "targets": -2 }
            ],
            responsive: false
        });
        
        $('#insert_penjualan_jenis_transaksi').focus();
        setAutoCompleteBarang('[name="autocomplete_insert_id_barang[0]"]', $barang);

        $('#insert_penjualan_jenis_transaksi').on('change', function (e, clickedIndex, isSelected, previousValue) { 
            setTimeout(function(){
                $('#insert_penjualan_kode_order').focus();
            }, 300);
        });
           
        $('#formPenjualan').on('click', '.remove_rincian_barang', function()
            {
                if($('.detail-item').length > 1)
                {
                    $(this).parents('.detail-item').fadeOut(function()
                    {
                        $(this).remove();
                    })
                }
            }
        )
        md.setFormValidation($('#formPenjualan'));
    });

    // Register event listener
    form_penjualan = document.getElementById('formPenjualan');
    onScan.attachTo(form_penjualan);
    form_penjualan.addEventListener('scan', function(sScancode, iQuantity) {

        $element = $(sScancode.explicitOriginalTarget);
        $code = removeXMLInvalidChars(sScancode.detail.scanCode);

        if($element.attr('id') == 'insert_penjualan_kode_order'){
            $('#formPenjualan [name*="autocomplete_insert_id_barang"]').first().focus();
        }else{

            setTimeout(function(){
                //cek jika sudah ada barang sejenis yg diinput, jika ada akan menambah quantity
                $all_autocomplete_input = $('#formPenjualan [name*="autocomplete_insert_id_barang"]');

                $input_existing = cek_jika_barang_sudah_terinput($all_autocomplete_input, $code);
                console.log($input_existing)
                if($input_existing !== false){
                    //kode barang sudah di input sebelumnya
                    $input_jumlah_barang = $($input_existing).parents('.detail-item').find('[name*="insert_jumlah_barang"]');
                    $val = $input_jumlah_barang.val();
                    $input_jumlah_barang.val(parseInt($val) + 1);

                    //Mereset autocomplete terbaru
                    $current_autocomplete.val(null);
                    $current_autocomplete.parents('.detail-item').find('[name*="insert_id_barang"]').val(null);
                }else{
                    $($current_autocomplete).parents('.detail-item').find('[name*="insert_jumlah_barang"]').val(1);
                    tambah_rincian_barang();
                }

            }, 500);
        }
    });

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

                $input_jumlah = $($element).parents('.detail-item').find('[name*="insert_jumlah_barang"]');
                
                $current_autocomplete = $($element);
                $input_jumlah.attr('data-jumlah-pasang',suggestion.max);
                $input_jumlah.attr('max', parseInt(suggestion.max).toFixed() );

                if(suggestion.max == 0){
                    swal('Stok Barang Habis');
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
            }, 200);
        });
    }

    function deletePenjualan($id_penjualan) {
        swal({
            title: 'Apakah Anda Yakin ?',
            text: "Data Penjualan akan dihapus dan tidak dapat dikembalikan !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-danger',
            cancelButtonClass: 'btn btn-default btn-link',
            confirmButtonText: 'Ya, Hapus',
            buttonsStyling: false
        }).then(function (result) {
            if (result.value === true) {
                window.location.href = "<?= base_url('admin-gudang/delete-penjualan-view-insert/')?>" + $id_penjualan;
            }
        })
    }

    function cek_barcode_barang($code){
        //fungsi untuk mengecek apakah yang di scan barcode barang
        if($code.length == 16 && $.isNumeric($code.substring(14, 16)) == true){
            return true;
        }
    }

    function cek_jika_barang_sudah_terinput($all_autocomplete_input, $code){
        //karena event dari scanner selalu tereksekusi setelah event autocomplete maka jumlah input pasti bernilai 1
        $element = [];
        $.each($all_autocomplete_input, function (i, v) { 
            if(v.value.toLowerCase().indexOf($code.toLowerCase()) >= 0){
                $element.push(v);
            }
        });
        if($element.length > 1){
            return $element[0];
        }else{
            return false;
        }
    }

    function removeXMLInvalidChars(string, removeDiscouragedChars = true)
    {
        // remove everything forbidden by XML 1.0 specifications, plus the unicode replacement character U+FFFD
        var regex = /((?:[\0-\x08\x0B\f\x0E-\x1F\uFFFD\uFFFE\uFFFF]|[\uD800-\uDBFF](?![\uDC00-\uDFFF])|(?:[^\uD800-\uDBFF]|^)[\uDC00-\uDFFF]))/g;
        string = string.replace(regex, "");
    
        if (removeDiscouragedChars) {
            // remove everything not suggested by XML 1.0 specifications
            regex = new RegExp(
                "([\\x7F-\\x84]|[\\x86-\\x9F]|[\\uFDD0-\\uFDEF]|(?:\\uD83F[\\uDFFE\\uDFFF])|(?:\\uD87F[\\uDF"+
                "FE\\uDFFF])|(?:\\uD8BF[\\uDFFE\\uDFFF])|(?:\\uD8FF[\\uDFFE\\uDFFF])|(?:\\uD93F[\\uDFFE\\uD"+
                "FFF])|(?:\\uD97F[\\uDFFE\\uDFFF])|(?:\\uD9BF[\\uDFFE\\uDFFF])|(?:\\uD9FF[\\uDFFE\\uDFFF])"+
                "|(?:\\uDA3F[\\uDFFE\\uDFFF])|(?:\\uDA7F[\\uDFFE\\uDFFF])|(?:\\uDABF[\\uDFFE\\uDFFF])|(?:\\"+
                "uDAFF[\\uDFFE\\uDFFF])|(?:\\uDB3F[\\uDFFE\\uDFFF])|(?:\\uDB7F[\\uDFFE\\uDFFF])|(?:\\uDBBF"+
                "[\\uDFFE\\uDFFF])|(?:\\uDBFF[\\uDFFE\\uDFFF])(?:[\\0-\\t\\x0B\\f\\x0E-\\u2027\\u202A-\\uD7FF\\"+
                "uE000-\\uFFFF]|[\\uD800-\\uDBFF][\\uDC00-\\uDFFF]|[\\uD800-\\uDBFF](?![\\uDC00-\\uDFFF])|"+
                "(?:[^\\uD800-\\uDBFF]|^)[\\uDC00-\\uDFFF]))", "g");
            string = string.replace(regex, "");
        }
    
        return string;
    }
</script>