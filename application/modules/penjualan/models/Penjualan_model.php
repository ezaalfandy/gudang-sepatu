<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_model extends CI_Model {

    public function get_all_specific_penjualan($where, $order_by, $limit = 0, $offset = 0){
        
        return $this->db->select("penjualan.*, 
                        DATE_FORMAT(penjualan.tanggal_penjualan, '%W, %d %M %Y') as tanggal_penjualan_formatted,
                        (SELECT DISTINCT GROUP_CONCAT(CONCAT_WS(' ',barang.kode_barang, ' = ', detail_penjualan.jumlah,' pasang') SEPARATOR ' ,<br>')  
                        FROM barang JOIN detail_penjualan on barang.id_barang = detail_penjualan.id_barang WHERE detail_penjualan.id_penjualan = penjualan.id_penjualan) as barang ")
                        ->order_by($order_by)
                        ->where($where)
                        ->get('penjualan', $limit, $offset)
                        ->result();
        
    }
    public function get_all_penjualan($order_by, $limit = 0, $offset = 0){
        
        return $this->db->select("penjualan.*, 
                        DATE_FORMAT(penjualan.tanggal_penjualan, '%W, %d %M %Y') as tanggal_penjualan_formatted,
                        (SELECT DISTINCT GROUP_CONCAT(CONCAT_WS(' ',barang.kode_barang, ' = ', detail_penjualan.jumlah,' pasang') SEPARATOR ' ,<br>')  
                        FROM barang JOIN detail_penjualan on barang.id_barang = detail_penjualan.id_barang WHERE detail_penjualan.id_penjualan = penjualan.id_penjualan) as barang ")
                        ->order_by($order_by)
                        ->get('penjualan', $limit, $offset)
                        ->result();
        
    }

}

/* End of file Penjualan_model.php */

?>