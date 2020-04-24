<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre Order <?= $data_pre_order->kode_pre_order?></title>
    <link href="<?= base_url('assets/')?>css/print-barcode.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/')?>img/joemen-icon.png">
    
    <script src="<?= base_url('assets/')?>js/core/jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/')?>js/jquery-barcode.min.js" type="text/javascript"></script>
</head>
<body>

    <?php foreach($data_detail_pre_order as $k_detail_pre_order => $v_detail_pre_order){
        $pengali = convert_satuan_to_pengali($v_detail_pre_order->satuan);
        for ($i=0; $i < $v_detail_pre_order->jumlah * $pengali; $i++) { 
            echo '
                <div class="barcode'.$v_detail_pre_order->id_barang.' barcode">

                </div>
            ';
        }
    }?>
    <script>
        <?php foreach($data_detail_pre_order as $k_detail_pre_order => $v_detail_pre_order):?>
            $('.barcode<?= $v_detail_pre_order->id_barang?>').barcode(
                "<?= $v_detail_pre_order->kode_barang?>",
                "code128",
                {
                    barHeight: 30,
                    barWidth: 1,
                    moduleSize: 5,
                    fontSize: 12,
                    output: "svg"
                }
            );
        <?php endforeach;?>
        $(document).ready(function () {
            window.print();
        });
    </script>
</body>
</html>