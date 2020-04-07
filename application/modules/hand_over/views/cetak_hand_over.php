<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hand Over <?= $data_hand_over->kode_hand_over?></title>
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
                    <h3 class="text-right font-weight-bold">Hand Over</h3>
                </div>
                <div class="col-md-12 text-right mt-4">
                    <div id="barcode" class="d-inline-block">
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-5">
            <div class="offset-md-7 col-md-3 text-right">
                <p class="font-weight-bold m-1">Nomor Hand Over :</p>
                <p class="font-weight-bold m-1">Tanggal :</p>
            </div>
            <div class="col-md-2 text-right">
                <p class="m-1"><?= $data_hand_over->kode_hand_over?></p>
                <p class="m-1"><?= $data_hand_over->tanggal_dibuat_formatted_2?></p>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-md-5">
                <h5 class="font-weight-bold">Dari :</h5>
                <p>
                    <?= $data_hand_over->gudang_asal?>
                </p>
            </div>
            <div class="offset-md-2 col-md-5">
                <h5 class="font-weight-bold">Kepada :</h5>
                <p>
                    <?= $data_hand_over->gudang_tujuan?>
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
                            <td>Keterangan</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $n = 1;?>
                        <?php foreach($data_detail_hand_over as $k_detail_hand_over => $v_detail_hand_over):?>
                            <tr>
                                <td><?= $n++; ?></td>
                                <td><?= $v_detail_hand_over->merek.' '.$v_detail_hand_over->tipe.' '.$v_detail_hand_over->warna.' '.$v_detail_hand_over->ukuran ?></td>
                                <td><?= $v_detail_hand_over->jumlah ?></td>
                                <td><?= $v_detail_hand_over->keterangan ?></td>
                            </tr>
                        <?php endforeach;?>
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
        "<?= $data_hand_over->kode_hand_over?>",
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