<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hand_over extends MY_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Hand_over_model');
        
    }

    public function _remap($method, $params = array())
    {
        $controller = mb_strtolower(get_class($this));
        $uri_controller = str_replace('-', '_', mb_strtolower($this->uri->segment(1)));
        if( $uri_controller == $controller)
        {
            show_404();
        }else
        {   
            if(method_exists($this, $method))
            {
                return call_user_func_array(array($this, $method), $params);
            }else{
                show_404();
            }
        }
    }

    public function get_all_hand_over()
    {
        return $this->Hand_over_model->get_all_hand_over();
    }

    public function get_specific_hand_over($where)
    {
        return $this->Hand_over_model->get_specific_hand_over($where);
    }

    public function get_all_specific_hand_over($where){
        return $this->Hand_over_model->get_all_specific_hand_over($where);
    }

    public function get_all_specific_detail_hand_over($where){
        return $this->Hand_over_model->get_all_specific_detail_hand_over($where);
    }



    public function insert_hand_over()
    {
        $id_gudang_asal = $this->input->post('insert_id_gudang_asal', TRUE);
        $id_gudang_tujuan = $this->input->post('insert_id_gudang_tujuan', TRUE);
        
        
        $array_model = array(
            'id_admin' => $this->session->userdata('id_admin'),
            'id_gudang_asal' => $id_gudang_asal,
            'id_gudang_tujuan' => $id_gudang_tujuan,
            'kode_hand_over' => ' ',
            'tanggal_dibuat' => Date('Y-m-d', strtotime($this->input->post('insert_tanggal_dibuat', TRUE))),
            'status_hand_over' => 'diproses'
        );

        $id_hand_over = $this->Base_model->insert('hand_over', $array_model);
        if($id_hand_over !== false)
        {
            //UPDATE kode_hand_over setelah insert
            
            $kode_gudang_asal = $this->Base_model->get_specific('gudang', array('id_gudang' => $id_gudang_asal))->kode_gudang;
            $kode_gudang_tujuan = $this->Base_model->get_specific('gudang', array('id_gudang' => $id_gudang_tujuan))->kode_gudang;
            $kode_hand_over = $kode_gudang_asal.sprintf('%05d', $id_hand_over).$kode_gudang_tujuan;

            if($this->Base_model->edit('hand_over', array('id_hand_over' => $id_hand_over), array('kode_hand_over' => $kode_hand_over)) === FALSE)
            {
                return FALSE;
            }
        }else{
            return FALSE;
        }
        return $id_hand_over;
    }
    
    public function terima_hand_over($id_hand_over){
        $all_barang = $this->Base_model->get_all_specific('detail_hand_over', array("id_hand_over" => $id_hand_over) );
        $hand_over = $this->Base_model->get_specific('hand_over', array('id_hand_over' => $id_hand_over));

        if($this->hand_over_diterima($all_barang, $hand_over->id_gudang_asal, $hand_over->id_gudang_tujuan) == true)
        {
            if($this->Base_model->edit(
                'hand_over', 
                array("id_hand_over" => $id_hand_over), 
                array("status_hand_over" => "diterima")) == true
            )
            {
                return true;
            }else
            {
                return false;
            }
        }else
        {
            return false;
        }
    }

    public function insert_detail_hand_over($id_hand_over)
    {

        $id_gudang_tujuan = $this->input->post('insert_id_gudang_tujuan', TRUE);
        $id_gudang_asal = $this->input->post('insert_id_gudang_asal', TRUE);

        $id_barang = $this->input->post('insert_id_barang[]');
        $jumlah = $this->input->post('insert_jumlah_barang[]');
        $satuan = $this->input->post('insert_satuan[]');
        $keterangan = $this->input->post('insert_keterangan[]');

        for ($i=0; $i < count($id_barang); $i++) { 
            $array_model = array(
                'id_hand_over' => $id_hand_over,
                'id_barang' => $id_barang[$i],
                'jumlah' => $jumlah[$i],
                'satuan' => $satuan[$i]
            );
            
            if($this->Base_model->insert('detail_hand_over', $array_model) == false)
            {
                return false;
            }
        }
        return true;

    }
    
    public function edit_hand_over($id_hand_over){
    
        $id_gudang_asal = $this->input->post('edit_id_gudang_asal', TRUE);
        $id_gudang_tujuan = $this->input->post('edit_id_gudang_tujuan', TRUE);
    
        $kode_gudang_asal = $this->Base_model->get_specific('gudang', array('id_gudang' => $id_gudang_asal))->kode_gudang;
        $kode_gudang_tujuan = $this->Base_model->get_specific('gudang', array('id_gudang' => $id_gudang_tujuan))->kode_gudang;
        $kode_hand_over = sprintf('%05d', $id_hand_over);
    
        $array_model = array(
            'id_admin' => $this->session->userdata('id_admin'),
            'id_gudang_asal' => $id_gudang_asal,
            'id_gudang_tujuan' => $this->input->post('edit_id_gudang_tujuan', TRUE),
            'kode_hand_over' => $kode_gudang_asal.$kode_hand_over.$kode_gudang_tujuan,
            'tanggal_dibuat' => $this->input->post('edit_tanggal_dibuat', TRUE),
            'status_hand_over' => 'diproses'
        );
    
        $edit_hand_over = $this->Base_model->edit('hand_over', array('id_hand_over' => $id_hand_over), $array_model);
    
        return true;
    }
    
    public function edit_detail_hand_over($id_hand_over){
    
        $id_gudang = $this->input->post('edit_id_gudang_tujuan', TRUE);
        $id_barang = $this->input->post('edit_id_barang[]');
        $jumlah = array_values($this->input->post('edit_jumlah_barang[]'));
        $satuan = array_values($this->input->post('edit_satuan[]'));
        
        /*
            Tahapan edit detail hand_over
            1. Hapus data lama
            2. Input data detail hand_over yang baru
        */
        if($this->Base_model->delete('detail_hand_over', array('id_hand_over' => $id_hand_over)) == true)
        {   
            for ($i=0; $i < count($id_barang); $i++) { 
                $array_model = array(
                    'id_hand_over' => $id_hand_over,
                    'id_barang' => $id_barang[$i],
                    'jumlah' => $jumlah[$i],
                    'satuan' => $satuan[$i]
                );
                if($this->Base_model->insert('detail_hand_over', $array_model) === false)
                {
                    return false;
                }
            }
            return true;
            
        }else
        {   
            //error hapus detail hand_over_lama
            return false;
        }
    }

    public function delete_hand_over($id_hand_over)
    {
        $all_barang = $this->Base_model->get_all_specific('detail_hand_over', array("id_hand_over" => $id_hand_over) );
        $hand_over = $this->Base_model->get_specific('hand_over', array("id_hand_over" => $id_hand_over) );
        
        if($hand_over->status_hand_over == 'diterima')
        {
            if($this->hand_over_ditolak($all_barang, $hand_over->id_gudang_asal, $hand_over->id_gudang_tujuan) === FALSE)
            {
                return false;
            }
        }

        if($this->Base_model->delete('hand_over', array("id_hand_over" => $id_hand_over)) == true)
        {
            return true;
        }else
        {
            return false;
        }
    }

    
    public function hand_over_diterima($detail_hand_over, $id_gudang_asal, $id_gudang_tujuan)
    {
        //FUNGSI INI DIGUNAKAN UNTUK MENGUBAH STOK BARANG MENJADI BERTAMBAH (PRE ORDER DITERIMA DSB)
        for ($i=0; $i < count($detail_hand_over); $i++) { 
            $pengali = 1;
            switch ($detail_hand_over[$i]->satuan) {
                case 'kodi':
                    $pengali = 20;
                    break;
                case 'lusin':
                    $pengali = 12;
                    break;
                case 'pasang':
                    $pengali = 1;
                    break;
                default:
                    break;
            }
            
            /*
                1. Mengurangi stok pada gudang asal
                2. Menambah stok pada gudang tujuan
            */
            $where_reduce = array(
                "id_barang" => $detail_hand_over[$i]->id_barang,
                "id_gudang" => $id_gudang_asal
            );

            if($this->manajemen_stok->reduce_specific_stok_barang($where_reduce, $detail_hand_over[$i]->jumlah * $pengali) !== false)
            {
                $where_add = array(
                    "id_barang" => $detail_hand_over[$i]->id_barang,
                    "id_gudang" => $id_gudang_tujuan
                );

                if($this->manajemen_stok->add_specific_stok_barang($where_add, $detail_hand_over[$i]->jumlah * $pengali) === false)
                {
                    return false;
                }
            }
        }
        return true;
    }

    public function hand_over_ditolak($detail_hand_over, $id_gudang_asal, $id_gudang_tujuan)
    {
        //FUNGSI INI DIGUNAKAN UNTUK MENGUBAH STOK BARANG MENJADI BERKURANG (DARI STATUS DITERIMA KE STATUS DITOLAK)
        for ($i=0; $i < count($detail_hand_over); $i++) { 
            $pengali = 1;
            switch ($detail_hand_over[$i]->satuan) {
                case 'kodi':
                    $pengali = 20;
                    break;
                case 'lusin':
                    $pengali = 12;
                    break;
                case 'pasang':
                    $pengali = 1;
                    break;
                default:
                    break;
            }

            /*  
                Kebalikan dari hand over diterima yaitu menjadi
                1. Menambah stok pada gudang asal
                2. Mengurangi stok pada gudang tujuan
            */
            $where_reduce = array(
                "id_barang" => $detail_hand_over[$i]->id_barang,
                "id_gudang" => $id_gudang_tujuan
            );

            if($this->manajemen_stok->reduce_specific_stok_barang($where_reduce, $detail_hand_over[$i]->jumlah * $pengali) !== false)
            {
                $where_add = array(
                    "id_barang" => $detail_hand_over[$i]->id_barang,
                    "id_gudang" => $id_gudang_asal
                );

                if($this->manajemen_stok->add_specific_stok_barang($where_add, $detail_hand_over[$i]->jumlah * $pengali) === false)
                {
                    return false;
                }
            }
        }
        return true;
    }

    public function cetak_hand_over($where)
    {
        $data['data_hand_over'] = $this->Hand_over_model->get_specific_hand_over($where);
        $data['data_detail_hand_over'] = $this->Hand_over_model->get_all_specific_detail_hand_over($where);

        $this->load->view('cetak_hand_over', $data);
    }
}

/* End of file Hand_over.php */

?>