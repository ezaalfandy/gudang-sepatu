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
                <div class="card-header card-header-icon card-header-info">
                    <div class="card-icon">
                        <i class="material-icons">search</i>
                    </div>
                    <h4 class="card-title ">#<?= $data_pre_order->kode_pre_order?></h4>
                </div>
                <div class="card-body px-5">
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group is-filled">
                                <label for="view_pre_order_id_supplier"> Supplier</label>
                                <input type="text" name="view_id_supplier"
                                value="<?= $data_pre_order->kode_supplier.' '.$data_pre_order->nama_supplier.' - '.$data_pre_order->alamat_supplier?>" id="view_pre_order_id_supplier"
                                class="form-control" required="true" disabled/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group is-filled">
                                <label for="view_pre_order_id_gudang_tujuan" > Gudang Tujuan</label>
                                <input type="hidden" name="view_id_gudang_tujuan">

                                <input type="text" name="view_id_gudang_tujuan"
                                value="<?= $data_pre_order->kode_gudang.' '.$data_pre_order->kabupaten_kota?>" id="view_pre_order_id_gudang_tujuan"
                                class="form-control" required="true" disabled/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="view_pre_order_tanggal_dibuat">Tanggal Terbit</label>
                                <input type="date" name="view_tanggal_dibuat"
                                value="<?= $data_pre_order->tanggal_dibuat?>" id="view_pre_order_tanggal_dibuat"
                                class="form-control" required="true" disabled/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="view_pre_order_tanggal_setor">Tanggal Setor</label>
                                <input type="date" name="view_tanggal_setor"
                                value="<?= $data_pre_order->tanggal_setor?>" id="view_pre_order_tanggal_setor"
                                class="form-control" required="true" disabled/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="view_pre_order_total_harga">Total Harga</label>
                                <input type="text" name="view_total_harga"
                                value="<?= $data_pre_order->total_harga?>" id="view_pre_order_total_harga"
                                class="form-control" disabled/>
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
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Nama Barang</label>
                                            <input type="hidden" name="view_id_barang[<?= $i?>]">
                                            <input type="text" name="view_id_barang[<?= $i?>]"
                                            class="form-control" required="true"  value="<?= $data_detail_pre_order[$i]->kode_barang.' - '.$data_detail_pre_order[$i]->merek.' '.$data_detail_pre_order[$i]->tipe.' '.$data_detail_pre_order[$i]->warna.' Ukuran '.$data_detail_pre_order[$i]->ukuran?>" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Jumlah</label>
                                            <input type="number" name="view_jumlah_barang[<?= $i?>]"
                                            value="<?= $data_detail_pre_order[$i]->jumlah ?>"
                                            class="form-control" required="true" min="0" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select name="view_satuan[<?= $i?>]" class="selectpicker form-control" data-size="3" data-style="btn btn-light btn-sm" title="Single Select" disabled>
                                                <option value="kodi" <?php echo ($data_detail_pre_order[$i]->satuan == 'kodi') ?  'selected' : ''?>>Kodi</option>
                                                <option value="lusin" <?php echo ($data_detail_pre_order[$i]->satuan == 'lusin') ? 'selected' : ''?>>Lusin</option>
                                                <option value="pasang" <?php echo ($data_detail_pre_order[$i]->satuan == 'pasang') ? 'selected' : ''?>>Pasang</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Harga per satuan</label>
                                            <input type="number" min="0" name="view_harga_per_satuan[<?= $i?>]"
                                            value="<?= $data_detail_pre_order[$i]->harga_per_satuan ?>"
                                            class="form-control" disabled/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endfor;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>