<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode <?= $kode_barang?></title>
    <link href="<?= base_url('assets/')?>css/print-barcode.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/')?>img/joemen-icon.png">
    
    <script src="<?= base_url('assets/')?>js/core/jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/')?>js/jquery-barcode.min.js" type="text/javascript"></script>
</head>
<body>
    <?php for($i = 0; $i < $jumlah_barcode; $i++){
        echo '
            <div class="barcode '.$kode_barang.'">

            </div>
        ';
    }?>
    <script>
        $('.<?= $kode_barang?>').barcode(
            "<?= $kode_barang?>",
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
</body>
</html>