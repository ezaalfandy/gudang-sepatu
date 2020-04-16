<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre Order <?= $data_pre_order->kode_pre_order?></title>
    <link href="<?= base_url('assets/')?>css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/')?>css/print.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/')?>img/joemen-icon.png">
    
    <script src="<?= base_url('assets/')?>js/core/jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/')?>js/jquery-barcode.min.js" type="text/javascript"></script>
</head>
<body>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-2 px-5">
                <img src="<?= base_url('assets/img/joemen.png')?>" class="img-fluid">
            </div>
            <div class="col-md-10 pl-5">
                <div class="col-md-12">
                    <h3 class="text-right font-weight-bold">Pre Order</h3>
                </div>
                <div class="col-md-12 text-right mt-4">
                    <div id="barcode" class="d-inline-block">
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-5">
            <div class="offset-md-7 col-md-3 text-right">
                <p class="font-weight-bold m-1">Nomor Pre Order :</p>
                <p class="font-weight-bold m-1">Tanggal :</p>
                <p class="font-weight-bold m-1">Tanggal Jatuh Tempo:</p>
            </div>
            <div class="col-md-2 text-right">
                <p class="m-1"><?= $data_pre_order->kode_pre_order?></p>
                <p class="m-1"><?= $data_pre_order->tanggal_dibuat_formatted_2?></p>
                <p class="m-1"><?= $data_pre_order->tanggal_setor_formatted_2?></p>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-md-5">
                <h5 class="font-weight-bold">Dari :</h5>
                <p>
                    Modern Shoes<br>
                    Dsn. Sumberjo Ds. Kintelan RT 02 RW 04
                    <br>
                    Puri - Mojokerto
                </p>
            </div>
            <div class="offset-md-2 col-md-5">
                <h5 class="font-weight-bold">Kepada :</h5>
                <p>
                    <?= $data_pre_order->nama_supplier?><br>
                    <?= $data_pre_order->alamat_supplier?>
                    <br>
                    <?= $data_pre_order->telepon_supplier?>
                </p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Barang</td>
                            <td>Jumlah</td>
                            <td>Harga Satuan</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $n = 1;?>
                        <?php foreach($data_detail_pre_order as $k_detail_pre_order => $v_detail_pre_order):?>
                            <tr>
                                <td><?= $n++; ?></td>
                                <td><?= $v_detail_pre_order->merek.' '.$v_detail_pre_order->tipe.' '.$v_detail_pre_order->warna.' '.$v_detail_pre_order->ukuran ?></td>
                                <td><?= $v_detail_pre_order->jumlah.' '.$v_detail_pre_order->satuan ?></td>
                                <td class="text-right">Rp <?= number_format($v_detail_pre_order->harga_per_satuan, 0, ".", ".").' / '.$v_detail_pre_order->satuan?></td>
                            </tr>
                        <?php endforeach;?>

                        <tr>
                            <td colspan="3"> 
                                <b>Total</b>
                            </td>
                            <td class="text-right"> 
                                Rp <?= number_format($data_pre_order->total_harga, 0, ".", ".") ?>
                            </td>
                        </tr>
                    </tbody>
                </table>    
            </div>
        </div>
        <div class="row">
            <div class="offset-md-6 col-md-6 text-center pb-5">
                <div class="ttd">

                </div>
                <h5 class="font-weight-bold mt-5">
                    <u><?= ucwords($this->session->userdata('nama'));?></u>
                </h5>        
            </div>
        </div>
    </div>
</body>
</html>

<script>
    $('#barcode').barcode(
        "<?= $data_pre_order->kode_pre_order?>",
        "code128",
        {
            barHeight: 30,
            barWidth: 1,
            moduleSize: 5,
            fontSize: 12,
            output: "svg"
        }
    );
    $(document).ready(function () {
        window.print();
    });
</script>