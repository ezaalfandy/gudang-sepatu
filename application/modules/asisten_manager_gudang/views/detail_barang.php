<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">assessment</i>
                    </div>
                    <h4 class="card-title"><?= $data_barang->merek.' '.$data_barang->tipe.' '.$data_barang->warna.' '.$data_barang->ukuran?></h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="table-responsive table-sales">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                No
                                            </th>
                                            <th>
                                                Gudang
                                            </th>
                                            <th>
                                                Stok
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $n= 1;?>
                                        <?php foreach ($data_stok_barang as $key => $value):?>
                                            <tr>   
                                                <td>
                                                    <?= $n++;?>
                                                </td>
                                                <td>
                                                    <?= $value->kode_gudang.' - '.$value->alamat.', '.$value->kabupaten_kota.' '.$value->provinsi.' ('.$value->nomor_telepon.')'?>
                                                </td>
                                                <td class="text-right">
                                                    <?= $value->jumlah_stok?>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div id="carouselGambarBarang" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <?php
                                        for ($i=0; $i < count($data_gambar_barang); $i++) 
                                        {
                                            if($i == 0)
                                            {
                                                echo '<li data-target="#carouselGambarBarang" data-slide-to="0" class="active"></li>';
                                            }else
                                            {
                                                echo '<li data-target="#carouselGambarBarang" data-slide-to="'.$i.'"></li>';
                                            }
                                        }
                                    ?>
                                </ol>
                                <div class="carousel-inner" role="listbox">
                                    <?php
                                        for ($i=0; $i < count($data_gambar_barang); $i++) 
                                        {
                                            if($i == 0)
                                            {   
                                                echo '
                                                    <div class="carousel-item active">
                                                        <img src="'.base_url('uploads/barang/').$data_gambar_barang[$i]->nama_file.'" alt="'.$i.'slide" class="img-fluid">
                                                    </div>
                                                ';
                                            }else
                                            {
                                                echo '
                                                    <div class="carousel-item">
                                                        <img src="'.base_url('uploads/barang/').$data_gambar_barang[$i]->nama_file.'" alt="'.$i.'slide"  class="img-fluid">
                                                    </div>
                                                ';
                                            }
                                        }
                                    ?>
                                </div>
                                <a class="carousel-control-prev" href="#carouselGambarBarang" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselGambarBarang" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>