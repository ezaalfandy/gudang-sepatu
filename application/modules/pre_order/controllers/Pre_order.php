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

    public function index()
    {
        echo urldecode($controller);
    }

    public function get_all_pre_order(){
        return $this->Pre_order_model->get_all_pre_order();
    }

    public function insert_pre_order(){

        $config = array(
            array(
                'field' => 'insert_id_supplier',
                'label' => ' Id Supplier',
                'rules' => 'required'
            ),
            array(
                'field' => 'insert_id_gudang_tujuan',
                'label' => ' Id Gudang Tujuan',
                'rules' => 'required'
            )
        );

        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE) 
        {
            $id_supplier = $this->input->post('insert_id_supplier', TRUE);
            $id_gudang = $this->input->post('insert_id_gudang_tujuan', TRUE);

            $kode_supplier = $this->Base_model->get_specific('supplier', array('id_supplier' => $id_supplier))->kode_supplier;
            $kode_gudang = $this->Base_model->get_specific('gudang', array('id_gudang' => $id_gudang))->kode_gudang;
            $id_pre_order = sprintf('%05d', $this->Base_model->get_last_primary_key('pre_order', 'id_pre_order'));

            $array_model = array(
                'id_admin' => $this->session->userdata('id_admin'),
                'id_supplier' => $id_supplier,
                'id_gudang_tujuan' => $this->input->post('insert_id_gudang_tujuan', TRUE),
                'kode_pre_order' => $kode_supplier.$id_pre_order.$kode_gudang,
                'tanggal_dibuat' => $this->input->post('insert_tanggal_dibuat', TRUE),
                'tanggal_setor' => $this->input->post('insert_tanggal_setor', TRUE)
            );

                $id_pre_order = $this->Base_model->insert('pre_order', $array_model);

                if($id_pre_order === false)
                {
                    return false;
                }else{
                    return $id_pre_order;
                }
        }else{
            return false;
        }

        return true;
    }

    public function insert_detail_pre_order($id_pre_order){

        $id_gudang = $this->input->post('insert_id_gudang_tujuan', TRUE);

        $id_barang = $this->input->post('insert_id_barang[]');
        $jumlah = $this->input->post('insert_jumlah_barang[]');
        $keterangan = $this->input->post('insert_keterangan[]');
        

        for ($i=0; $i < count($id_barang); $i++) { 
            $array_model = array(
                'id_pre_order' => $id_pre_order,
                'id_barang' => $id_barang[$i],
                'jumlah' => $jumlah[$i],
                'keterangan' => isset($keterangan[$i]) ? $keterangan[$i]: null
            );
            
            if($this->Base_model->insert('detail_pre_order', $array_model) === false)
            {
                return false;
            }else
            {
                if($this->manajemen_stok->add_total_stock($id_barang[$i], $jumlah[$i]) !== false)
                {   
                    $where = array(
                        "id_barang" => $id_barang[$i],
                        "id_gudang" => $id_gudang
                    );

                    if($this->manajemen_stok->add_specific_stok_barang($where, $jumlah[$i]) === false)
                    {
                        return false;
                    }
                }
            }
        }
        return true;

    }

    public function delete_pre_order($id_pre_order){
        $all_barang = $this->Base_model->get_all_specific('detail_pre_order', array("id_pre_order" => $id_pre_order) );
        $id_gudang = $this->Base_model->get_specific('pre_order', array('id_pre_order' => $id_pre_order))->id_gudang_tujuan;

        for ($i=0; $i < count($all_barang); $i++) 
        { 
            if($this->manajemen_stok->reduce_total_stock($all_barang[$i]->id_barang, $all_barang[$i]->jumlah ) !== false)
            {
                $where = array(
                    "id_barang" => $all_barang[$i]->id_barang,
                    "id_gudang" => $id_gudang
                );

                if($this->manajemen_stok->reduce_specific_stok_barang($where, $all_barang[$i]->jumlah) === false)
                {
                    return false;
                }
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

    public function cetak_pre_order($id_pre_order)
    {
        $data['data_pre_order'] = $this->Pre_order_model->get_specific_pre_order(array('id_pre_order' => $id_pre_order));
        $data['data_detail_pre_order'] = $this->Pre_order_model->get_all_detail_pre_order_by_id_pre_order($id_pre_order);

        $this->load->view('cetak_pre_order', $data);
    }

    public function cetak_barcode_pre_order($id_pre_order)
    {
        $data['data_pre_order'] = $this->Pre_order_model->get_specific_pre_order(array('id_pre_order' => $id_pre_order));
        $data['data_detail_pre_order'] = $this->Pre_order_model->get_all_detail_pre_order_by_id_pre_order($id_pre_order);

        $this->load->view('cetak_barcode', $data);
    }

}

/* End of file Pre_order.php */

?>