<?php

    function konversi_ke_mode_seri($detail_pre_order)
    {
        $barang = array();
        foreach ($detail_pre_order as $key => $value) {

            $barang[$value->merek.' '.$value->tipe.' '.$value->warna]['ukuran']
            [$value->ukuran] = $value->jumlah;

            $barang[$value->merek.' '.$value->tipe.' '.$value->warna]['id_barang']
            = $value->merek.'-'.$value->tipe.'-'.$value->warna;
        }

        /*Array
        (
            [Joemen J84 HITAM SIILVER] => Array
                (
                    [ukuran] => Array
                        (
                            [39] => 4
                            [40] => 4
                            [41] => 4
                            [42] => 4
                            [43] => 4
                        )
                    [id_barang] => Joemen-J84-HITAM SIILVER
                )

        )*/

        //Pengecekan kelengkapan dalam 1 kodi
        foreach ($barang as $k => $v) {
            if(count($v['ukuran']) !== 5 || array_sum($v['ukuran']) % 20 !== 0){
                return false;
            }
        }

        return $barang;
    }
?>