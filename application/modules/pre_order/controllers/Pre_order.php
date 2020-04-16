<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pre_order extends MY_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pre_order_model');
        $this->load->model('Base_model');
    }

    public function _remap($method, $params = array())
    {
        $controller = mb_strtolower(get_class($this));
        $uri_controller = str_replace('-', '_', mb_strtolower($this->uri->segment(1)));
        if( $uri_controller == $controller){
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
    public function get_all_pre_order(){
        return $this->Pre_order_model->get_all_pre_order();
    }

    public function get_specific_pre_order($where)
    {
        return $this->Pre_order_model->get_specific_pre_order($where);
    }

    public function get_all_specific_pre_order($where)
    {
        return $this->Pre_order_model->get_all_specific_pre_order($where);
    }

    public function get_all_specific_detail_pre_order($where){
        return $this->Pre_order_model->get_all_specific_detail_pre_order($where);
    }

    public function insert_pre_order(){

        $id_supplier = $this->input->post('insert_id_supplier', TRUE);
        $id_gudang = $this->input->post('insert_id_gudang_tujuan', TRUE);

        $array_model = array(
            'id_admin' => $this->session->userdata('id_admin'),
            'id_supplier' => $id_supplier,
            'id_gudang_tujuan' => $this->input->post('insert_id_gudang_tujuan', TRUE),
            'kode_pre_order' => ' ',
            'tanggal_dibuat' => Date('Y-m-d', strtotime($this->input->post('insert_tanggal_dibuat', TRUE))),
            'tanggal_setor' =>  Date('Y-m-d', strtotime($this->input->post('insert_tanggal_setor', TRUE))),
            'status_pre_order' => 'diproses'
        );

        $id_pre_order = $this->Base_model->insert('pre_order', $array_model);

        if($id_pre_order !== FALSE)
        {
            //UPDATE kode_pre_order setelah insert
            $kode_supplier = $this->Base_model->get_specific('supplier', array('id_supplier' => $id_supplier))->kode_supplier;
            $kode_gudang = $this->Base_model->get_specific('gudang', array('id_gudang' => $id_gudang))->kode_gudang;
            $kode_pre_order = $kode_supplier.sprintf('%05d', $id_pre_order).$kode_gudang;

            if($this->Base_model->edit('pre_order', array('id_pre_order' => $id_pre_order), array('kode_pre_order' => $kode_pre_order)) === FALSE)
            {
                return FALSE;
            }
        }else{
            return FALSE;
        }                

        return $id_pre_order;
    }

    public function insert_detail_pre_order($id_pre_order){

        $id_gudang = $this->input->post('insert_id_gudang_tujuan', TRUE);

        $id_barang = $this->input->post('insert_id_barang[]');
        $jumlah = $this->input->post('insert_jumlah_barang[]');
        $satuan = $this->input->post('insert_satuan[]');
        $harga_per_satuan = $this->input->post('insert_harga_per_satuan[]');
        

        for ($i=0; $i < count($id_barang); $i++) { 
            $array_model = array(
                'id_pre_order' => $id_pre_order,
                'id_barang' => $id_barang[$i],
                'jumlah' => $jumlah[$i],
                'satuan' => $satuan[$i],
                'harga_per_satuan' => $harga_per_satuan[$i]
            );
            
            if($this->Base_model->insert('detail_pre_order', $array_model) === false)
            {
                return false;
            }
        }


        //MENGINPUT TOTAL HARGA
        $total_harga = $this->hitung_total_harga($id_pre_order);
        $this->Base_model->edit('pre_order', array('id_pre_order' => $id_pre_order), array('total_harga' => $total_harga));
        return true;
       

    }
    
    public function edit_pre_order($id_pre_order){
    
        $id_supplier = $this->input->post('edit_id_supplier', TRUE);
        $id_gudang = $this->input->post('edit_id_gudang_tujuan', TRUE);

        $kode_supplier = $this->Base_model->get_specific('supplier', array('id_supplier' => $id_supplier))->kode_supplier;
        $kode_gudang = $this->Base_model->get_specific('gudang', array('id_gudang' => $id_gudang))->kode_gudang;
        $kode_pre_order = sprintf('%05d', $id_pre_order);

        $array_model = array(
            'id_admin' => $this->session->userdata('id_admin'),
            'id_supplier' => $id_supplier,
            'id_gudang_tujuan' => $this->input->post('edit_id_gudang_tujuan', TRUE),
            'kode_pre_order' => $kode_supplier.$kode_pre_order.$kode_gudang,
            'tanggal_dibuat' => $this->input->post('edit_tanggal_dibuat', TRUE),
            'tanggal_setor' => $this->input->post('edit_tanggal_setor', TRUE)
        );

        $edit_pre_order = $this->Base_model->edit('pre_order', array('id_pre_order' => $id_pre_order), $array_model);

        return true;
    }

    public function edit_detail_pre_order($id_pre_order){

        $id_gudang = $this->input->post('edit_id_gudang_tujuan', TRUE);

        $id_barang = $this->input->post('edit_id_barang[]');
        $jumlah = $this->input->post('edit_jumlah_barang[]');
        $satuan = $this->input->post('edit_satuan[]');
        $harga_per_satuan = $this->input->post('edit_harga_per_satuan[]');
        
        /*
            Tahapan edit detail pre_order
            1. Hapus data lama
            2. Input data detail pre_order yang baru
        */
        if($this->Base_model->delete('detail_pre_order', array('id_pre_order' => $id_pre_order)) == true)
        {   
            for ($i=0; $i < count($id_barang); $i++) { 
                $array_model = array(
                    'id_pre_order' => $id_pre_order,
                    'id_barang' => $id_barang[$i],
                    'jumlah' => $jumlah[$i],
                    'satuan' => $satuan[$i],
                    'harga_per_satuan' => $harga_per_satuan[$i]
                );
                if($this->Base_model->insert('detail_pre_order', $array_model) === false)
                {
                    return false;
                }
            }
            
            //MENGINPUT TOTAL HARGA
            $total_harga = $this->hitung_total_harga($id_pre_order);
            $this->Base_model->edit('pre_order', array('id_pre_order' => $id_pre_order), array('total_harga' => $total_harga));
            return true;
            
        }else
        {   
            //error hapus detail pre_order_lama
            return false;
        }
    }

    public function hitung_total_harga($id_pre_order){

        $detail_pre_order = $this->Base_model->get_all_specific('detail_pre_order', array("id_pre_order" => $id_pre_order) );
        $total_harga = 0;

        for ($i=0; $i < count($detail_pre_order); $i++) { 
            $total_harga += ($detail_pre_order[$i]->jumlah * $detail_pre_order[$i]->harga_per_satuan);
        }
        return $total_harga;

    }

    public function delete_pre_order($id_pre_order){
        $all_barang = $this->Base_model->get_all_specific('detail_pre_order', array("id_pre_order" => $id_pre_order) );
        $data_pre_order = $this->Base_model->get_specific('pre_order', array('id_pre_order' => $id_pre_order));

        if($data_pre_order->status_pre_order == 'diterima'){
            if($this->pre_order_ditolak($all_barang, $data_pre_order->id_gudang_tujuan) === false)
            {
                return false;
            }
        }
        
        if($this->Base_model->delete('pre_order', array("id_pre_order" => $id_pre_order)) == true)
        {
            return true;
        }else
        {
            return false;
        }
    }

    public function terima_pre_order($id_pre_order){
        $all_barang = $this->Base_model->get_all_specific('detail_pre_order', array("id_pre_order" => $id_pre_order) );
        $id_gudang = $this->Base_model->get_specific('pre_order', array('id_pre_order' => $id_pre_order))->id_gudang_tujuan;

        if($this->pre_order_diterima($all_barang, $id_gudang) == true)
        {
            if($this->Base_model->edit(
                'pre_order', 
                array("id_pre_order" => $id_pre_order), 
                array("status_pre_order" => "diterima")) == true
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


    public function cetak_pre_order($id_pre_order)
    {
        $data['data_pre_order'] = $this->Pre_order_model->get_specific_pre_order(array('id_pre_order' => $id_pre_order));
        $data['data_detail_pre_order'] = $this->Pre_order_model->get_all_specific_detail_pre_order(array('id_pre_order' => $id_pre_order));

        $this->load->view('cetak_pre_order', $data);
    }

    public function cetak_barcode_pre_order($id_pre_order)
    {
        $data['data_pre_order'] = $this->Pre_order_model->get_specific_pre_order(array('id_pre_order' => $id_pre_order));
        $data['data_detail_pre_order'] = $this->Pre_order_model->get_all_specific_detail_pre_order(array('id_pre_order' => $id_pre_order));

        $this->load->view('cetak_barcode', $data);
    }

    public function pre_order_diterima($detail_pre_order, $id_gudang)
    {
        //FUNGSI INI DIGUNAKAN UNTUK MENGUBAH STOK BARANG MENJADI BERTAMBAH (PRE ORDER DITERIMA DSB)
        for ($i=0; $i < count($detail_pre_order); $i++) { 
            $pengali = 1;
            switch ($detail_pre_order[$i]->satuan) {
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

            if($this->manajemen_stok->add_total_stock($detail_pre_order[$i]->id_barang, $detail_pre_order[$i]->jumlah * $pengali ) !== false)
            {   
                $where = array(
                    "id_barang" => $detail_pre_order[$i]->id_barang,
                    "id_gudang" => $id_gudang
                );

                if($this->manajemen_stok->add_specific_stok_barang($where, $detail_pre_order[$i]->jumlah * $pengali) === false)
                {
                    return false;
                }
            }
        }
        return true;
    }

    public function pre_order_ditolak($detail_pre_order, $id_gudang)
    {
        //FUNGSI INI DIGUNAKAN UNTUK MENGUBAH STOK BARANG MENJADI BERKURANG (DARI STATUS DITERIMA KE STATUS DITOLAK)
        for ($i=0; $i < count($detail_pre_order); $i++) { 
            $pengali = 1;
            switch ($detail_pre_order[$i]->satuan) {
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

            if($this->manajemen_stok->reduce_total_stock($detail_pre_order[$i]->id_barang, $detail_pre_order[$i]->jumlah * $pengali ) !== false)
            {   
                $where = array(
                    "id_barang" => $detail_pre_order[$i]->id_barang,
                    "id_gudang" => $id_gudang
                );

                if($this->manajemen_stok->reduce_specific_stok_barang($where, $detail_pre_order[$i]->jumlah * $pengali) === false)
                {
                    return false;
                }
            }
        }
        return true;
    }
}

/* End of file Pre_order.php */

?>