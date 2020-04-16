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
        <div class="col-md-4">
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
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis</th>
                                            <th>Item</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td scope="row">1</td>
                                                <td>Shopee</td>
                                                <td>J21</td>
                                            </tr>
                                            <tr>
                                                <td scope="row">2</td>
                                                <td>Shopee</td>
                                                <td>J21</td>
                                            </tr>
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-primary card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">attach_money</i>
                    </div>
                    <h4 class="card-title">Input penjualan</h4>
                </div>
                <form action="<?= base_url('Admin-gudang/insert-penjualan')?>" method="post" accept-charset="utf-8"
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
                                    class="form-control" required="true" />
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
                                            class="form-control" required="true" />
                                            <small class="text-danger"><?php echo form_error('insert_id_barang'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Jumlah</label>
                                            <input type="number" name="insert_jumlah_barang[0]"
                                            value=""
                                            class="form-control" required="true" min="0"/>
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
        $cloned_element.find('[name="insert_jumlah_barang[0]"]').attr("name", "insert_jumlah_barang["+$element_index+"]").val(null);

        $cloned_element.find('[name="autocomplete_insert_id_barang['+$element_index+']"]').focus();

        md.setInputAutoComplete($cloned_element.find('[name="autocomplete_insert_id_barang['+$element_index+']"]'), $barang);
    }

    $barang = JSON.parse('<?= json_encode($barang_lookup);?>');

    $(document).ready(function () {
        $('#insert_penjualan_jenis_transaksi').focus();
        md.setInputAutoComplete('[name="autocomplete_insert_id_barang[0]"]', $barang);

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

    });
</script>