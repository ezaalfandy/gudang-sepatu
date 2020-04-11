<?php

    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Pre_order_model extends CI_Model {
    
        public function get_all_pre_order(){
            return $this->db->select("gudang.*, supplier.*, pre_order.*, DATE_FORMAT(pre_order.tanggal_dibuat, '%W, %d %M %Y') as tanggal_dibuat_formatted, DATE_FORMAT(pre_order.tanggal_dibuat, '%d-%m-%Y') as tanggal_dibuat_formatted_2, DATE_FORMAT(pre_order.tanggal_setor, '%d-%m-%Y') as tanggal_setor_formatted_2")
                            ->join('gudang', 'gudang.id_gudang = pre_order.id_gudang_tujuan')
                            ->join('supplier', 'supplier.id_supplier = pre_order.id_supplier')
                            ->get('pre_order')
                            ->result();
        }
        
        public function get_all_specific_detail_pre_order($where){
            return $this->db->join('barang', 'barang.id_barang = detail_pre_order.id_barang')
                            ->where($where)
                            ->get('detail_pre_order')
                            ->result();
        }

        public function get_specific_pre_order($where){
            return $this->db->select("gudang.*, supplier.*, pre_order.*, DATE_FORMAT(pre_order.tanggal_dibuat, '%W, %d %M %Y') as tanggal_dibuat_formatted, DATE_FORMAT(pre_order.tanggal_dibuat, '%d-%m-%Y') as tanggal_dibuat_formatted_2, DATE_FORMAT(pre_order.tanggal_setor, '%d-%m-%Y') as tanggal_setor_formatted_2")
                            ->join('gudang', 'gudang.id_gudang = pre_order.id_gudang_tujuan')
                            ->join('supplier', 'supplier.id_supplier = pre_order.id_supplier')
                            ->where($where)
                            ->get('pre_order')
                            ->row();
        }

        public function get_all_specific_pre_order($where){
            return $this->db->select("gudang.*, supplier.*, pre_order.*, DATE_FORMAT(pre_order.tanggal_dibuat, '%W, %d %M %Y') as tanggal_dibuat_formatted, DATE_FORMAT(pre_order.tanggal_dibuat, '%d-%m-%Y') as tanggal_dibuat_formatted_2, DATE_FORMAT(pre_order.tanggal_setor, '%d-%m-%Y') as tanggal_setor_formatted_2")
                            ->join('gudang', 'gudang.id_gudang = pre_order.id_gudang_tujuan')
                            ->join('supplier', 'supplier.id_supplier = pre_order.id_supplier')
                            ->where($where)
                            ->get('pre_order')
                            ->result();
        }
    
    }
    
    /* End of file Pre_order_model.php */
    
?>