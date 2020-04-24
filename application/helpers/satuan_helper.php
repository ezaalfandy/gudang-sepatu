<?php
    function convert_satuan_to_pengali($satuan){
        switch ($satuan) {
            case 'kodi':
                return 20;
            case 'lusin':
                return 12;
            case 'pasang':
                return 1;
            default:
                return 1;
        }
    }
?>