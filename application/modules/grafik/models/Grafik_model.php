<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Grafik_model extends CI_Model {
    
        public function get_grafik_penjualan($where, $group_by){
            return $this->db->select("SUM(detail_penjualan.jumlah)as jumlah, barang.*, DATE_FORMAT(penjualan.tanggal_penjualan, '%a') as hari
            , DATE_FORMAT(penjualan.tanggal_penjualan, '%d %b') as tanggal_bulan")
                        ->join('penjualan', 'penjualan.id_penjualan = detail_penjualan.id_penjualan')
                        ->join('barang', 'barang.id_barang = detail_penjualan.id_barang')
                        ->where($where)
                        ->where('penjualan.status_penjualan', 'diterima')
                        ->group_by($group_by)
                        ->get('detail_penjualan')
                        ->result();
            
        }
    
        public function get_grafik_pre_order($where, $group_by){
            return $this->db->select("SUM(
                                IF(detail_pre_order.satuan = 'kodi', detail_pre_order.jumlah * 20,
                                    IF(detail_pre_order.satuan = 'lusin', detail_pre_order.jumlah * 12, detail_pre_order.jumlah)
                                )
                            )as jumlah, 
                            DATE_FORMAT(pre_order.tanggal_setor, '%a') as hari, 
                            DATE_FORMAT(pre_order.tanggal_setor, '%d %b') as tanggal_bulan", FALSE)
                        ->join('pre_order', 'pre_order.id_pre_order = detail_pre_order.id_pre_order', FALSE)
                        ->where($where)
                        ->where('pre_order.status_pre_order', 'diterima')
                        ->group_by($group_by)
                        ->get('detail_pre_order')
                        ->result();
            
        }
        
        public function get_grafik_hand_over($where, $group_by){
            return $this->db->select("SUM(
                                IF(detail_hand_over.satuan = 'kodi', detail_hand_over.jumlah * 20,
                                    IF(detail_hand_over.satuan = 'lusin', detail_hand_over.jumlah * 12, detail_hand_over.jumlah)
                                             )
                            )as jumlah, 
                            DATE_FORMAT(hand_over.tanggal_dibuat, '%a') as hari, 
                            DATE_FORMAT(hand_over.tanggal_dibuat, '%d %b') as tanggal_bulan", FALSE)
                        ->join('hand_over', 'hand_over.id_hand_over = detail_hand_over.id_hand_over', FALSE)
                        ->where($where)
                        ->where('hand_over.status_hand_over', 'diterima')
                        ->group_by($group_by)
                        ->get('detail_hand_over')
                        ->result();
            
        }

        public function get_all_produk_terlaris($where){
            return $this->db->select("SUM(detail_penjualan.jumlah)as jumlah_barang_terjual, barang.*")
                        ->join('barang', 'detail_penjualan.id_barang = barang.id_barang')
                        ->join('penjualan', 'penjualan.id_penjualan = detail_penjualan.id_penjualan')
                        ->where('penjualan.status_penjualan', 'diterima')
                        ->where($where)
                        ->group_by('barang.id_barang')
                        ->get('detail_penjualan')
                        ->result();
            
        }

    }
    
    /* End of file Grafik_model.php */
    
?>