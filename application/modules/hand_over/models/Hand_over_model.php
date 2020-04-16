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
    
    public function get_all_specific_detail_hand_over($where){
        return $this->db->join('barang', 'barang.id_barang = detail_hand_over.id_barang')
                        ->where($where)
                        ->get('detail_hand_over')
                        ->result();
    }

    public function get_specific_hand_over($where){

        return $this->db->join('gudang as gudang_asal', 'hand_over.id_gudang_asal = gudang_asal.id_gudang')
                        ->join('gudang as gudang_tujuan', 'hand_over.id_gudang_tujuan = gudang_tujuan.id_gudang')
                        ->join('admin_management', 'admin_management.id_admin_management = hand_over.id_admin')
                        ->select("hand_over.*, admin_management.*,
                        gudang_asal.kode_gudang as kode_gudang_asal,
                        gudang_asal.kabupaten_kota as kabupaten_kota_asal,
                        gudang_tujuan.kode_gudang as kode_gudang_tujuan,
                        gudang_tujuan.kabupaten_kota as kabupaten_kota_tujuan,
                        DATE_FORMAT(hand_over.tanggal_dibuat, '%W, %d %M %Y') as tanggal_dibuat_formatted, 
                        DATE_FORMAT(hand_over.tanggal_dibuat, '%d-%m-%Y') as tanggal_dibuat_formatted_2, 
                        (SELECT CONCAT_WS(' ', gudang.kode_gudang, ' ', gudang.alamat , '<br>', gudang.kabupaten_kota, ' - ', gudang.provinsi, '<br>', gudang.kode_pos, ' - ', gudang.nomor_telepon) FROM gudang where id_gudang = id_gudang_asal) as gudang_asal,
                        (SELECT CONCAT_WS(' ', gudang.kode_gudang, ' ', gudang.alamat , '<br>', gudang.kabupaten_kota, ' - ', gudang.provinsi, '<br>', gudang.kode_pos, ' - ', gudang.nomor_telepon) FROM gudang where id_gudang = id_gudang_tujuan) as gudang_tujuan")
                        ->where($where)
                        ->get('hand_over')
                        ->row();
    }

    
    public function get_all_specific_hand_over($where){

        return $this->db->join('gudang as gudang_asal', 'hand_over.id_gudang_asal = gudang_asal.id_gudang')
                        ->join('gudang as gudang_tujuan', 'hand_over.id_gudang_tujuan = gudang_tujuan.id_gudang')
                        ->select("hand_over.*, 
                        gudang_asal.kode_gudang as kode_gudang_asal,
                        gudang_asal.kabupaten_kota as kabupaten_kota_asal,
                        gudang_tujuan.kode_gudang as kode_gudang_tujuan,
                        gudang_tujuan.kabupaten_kota as kabupaten_kota_tujuan,
                        DATE_FORMAT(hand_over.tanggal_dibuat, '%W, %d %M %Y') as tanggal_dibuat_formatted, 
                        DATE_FORMAT(hand_over.tanggal_dibuat, '%d-%m-%Y') as tanggal_dibuat_formatted_2, 
                        (SELECT CONCAT_WS(' ', gudang.kode_gudang, ' ', gudang.alamat , '<br>', gudang.kabupaten_kota, ' - ', gudang.provinsi, '<br>', gudang.kode_pos, ' - ', gudang.nomor_telepon) FROM gudang where id_gudang = id_gudang_asal) as gudang_asal,
                        (SELECT CONCAT_WS(' ', gudang.kode_gudang, ' ', gudang.alamat , '<br>', gudang.kabupaten_kota, ' - ', gudang.provinsi, '<br>', gudang.kode_pos, ' - ', gudang.nomor_telepon) FROM gudang where id_gudang = id_gudang_tujuan) as gudang_tujuan")
                        ->where($where)
                        ->get('hand_over')
                        ->result();
    }


}

/* End of file Hand_over_model.php */

?>