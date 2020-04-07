<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hand_over_model extends CI_Model {

    public function get_all_hand_over(){
        return $this->db->select("hand_over.*,
        DATE_FORMAT(hand_over.tanggal_dibuat, '%W, %d %M %Y') as tanggal_dibuat_formatted, 
        DATE_FORMAT(hand_over.tanggal_dibuat, '%d-%m-%Y') as tanggal_dibuat_formatted_2, 
        (SELECT CONCAT_WS(' ', gudang.kode_gudang, ' ', gudang.kabupaten_kota, ' ', gudang.provinsi) FROM gudang where id_gudang = id_gudang_asal) as gudang_asal,
        (SELECT CONCAT_WS(' ', gudang.kode_gudang, ' ', gudang.kabupaten_kota, ' ', gudang.provinsi) FROM gudang where id_gudang = id_gudang_tujuan) as gudang_tujuan")
                        ->get('hand_over')
                        ->result();
    }
    
    public function get_all_detail_hand_over_by_id_hand_over($id_hand_over){
        return $this->db->join('barang', 'barang.id_barang = detail_hand_over.id_barang')
                        ->where('detail_hand_over.id_hand_over', $id_hand_over)
                        ->get('detail_hand_over')
                        ->result();
    }

    public function get_specific_hand_over($where){

        return $this->db->select("hand_over.*,
        DATE_FORMAT(hand_over.tanggal_dibuat, '%W, %d %M %Y') as tanggal_dibuat_formatted, 
        DATE_FORMAT(hand_over.tanggal_dibuat, '%d-%m-%Y') as tanggal_dibuat_formatted_2, 
        (SELECT CONCAT_WS(' ', gudang.kode_gudang, ' ', gudang.alamat , '<br>', gudang.kabupaten_kota, ' - ', gudang.provinsi, '<br>', gudang.kode_pos, ' - ', gudang.nomor_telepon) FROM gudang where id_gudang = id_gudang_asal) as gudang_asal,
        (SELECT CONCAT_WS(' ', gudang.kode_gudang, ' ', gudang.alamat , '<br>', gudang.kabupaten_kota, ' - ', gudang.provinsi, '<br>', gudang.kode_pos, ' - ', gudang.nomor_telepon) FROM gudang where id_gudang = id_gudang_tujuan) as gudang_tujuan")
                        ->where($where)
                        ->get('hand_over')
                        ->row();
    }


}

/* End of file Hand_over_model.php */

?>