<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_stok_model extends CI_Model {
    
    public function reduce_total_stock($id_barang, $quantity)
    {
        $current_stock = $this->db->where('id_barang', $id_barang)
                                ->get('barang')->row()->stok_tersedia;
        
        $this->db->where('id_barang', $id_barang)
                 ->update('barang', array('stok_tersedia' => ($current_stock - $quantity) ));
        if($this->db->affected_rows() > 0)
        { 
            return true;
        }else
        {
            return false;
        }
    }

    public function add_total_stock($id_barang, $quantity)
    {
        $current_stock = $this->db->where('id_barang', $id_barang)
                                ->get('barang')->row()->stok_tersedia;
        
        $this->db->where('id_barang', $id_barang)
                 ->update('barang', array('stok_tersedia' => ($current_stock + $quantity) ));
        if($this->db->affected_rows() > 0)
        { 
            return true;
        }else
        {
            return false;
        }
    }
    
    public function reduce_specific_stok_barang($where, $quantity)
    {
        $current_stock = $this->db->where($where)
                                ->get('stok_barang')
                                ->row()
                                ->jumlah_stok;
        
        $this->db->where($where)
                 ->update('stok_barang', array('jumlah_stok' => ($current_stock - $quantity) ));
        if($this->db->affected_rows() > 0)
        { 
            return true;
        }else
        {
            return false;
        }
    }

    public function add_specific_stok_barang($where, $quantity)
    {
        $current_stock = $this->db->where($where)
                                ->get('stok_barang')
                                ->row()
                                ->jumlah_stok;
        
        $this->db->where($where)
                 ->update('stok_barang', array('jumlah_stok' => ($current_stock + $quantity) ));
        if($this->db->affected_rows() > 0)
        { 
            return true;
        }else
        {
            return false;
        }
    }

    public function create_specific_stok_barang_to_all_gudang($id_barang)
    {   
        /*
            FUNGSI INI DIGUNAKAN UNTUK MENGINPUT KAN DATA STOK DARI SATU BARANG KE SEMUA GUDANG,
            DIGUNAKAN KETIKA MENGINPUTKAN DATA BARANG BARU
        */

        $all_gudang = $this->db->get('gudang')->result();
        
        foreach ($all_gudang as $k_gudang => $v_gudang) {
            $data = array(
                "id_gudang" => $v_gudang->id_gudang,
                "id_barang" => $id_barang,
                "jumlah_stok" => 0
            );
            $this->db->insert('stok_barang', $data);
            
        }

        return true;
    }

    public function create_all_stok_barang_to_specific_gudang($id_gudang)
    {   
        /*
            FUNGSI INI DIGUNAKAN UNTUK MENGINPUTKAN SEMUA DATA BARANG YANG ADA KE DATA STOK DAN DIARAHKAN KE SPECIFIC 
            GUDANG, DIGUNAKAN KETIKA MENGINPUT DATA GUDANG BARU
        */
        $all_barang = $this->db->get('barang')->result();
        
        foreach ($all_barang as $k_barang => $v_barang) {
            $data = array(
                "id_barang" => $v_barang->id_barang,
                "id_gudang" => $id_gudang,
                "jumlah_stok" => 0
            );
            $this->db->insert('stok_barang', $data);
            
        }

        return true;
    }
    

}

/* End of file Manajemen_stok_model.php */

?>