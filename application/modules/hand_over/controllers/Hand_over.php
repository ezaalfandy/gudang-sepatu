<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hand_over extends MY_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Hand_over_model');
        
    }
    
    public function index()
    {
        
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

    public function insert_hand_over()
        {

        $config = array(
            array(
                'field' => 'insert_id_gudang_asal',
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
            $id_gudang_tujuan = $this->input->post('insert_id_gudang_tujuan', TRUE);
            $id_gudang_asal = $this->input->post('insert_id_gudang_asal', TRUE);

            
            $kode_gudang_asal = $this->Base_model->get_specific('gudang', array('id_gudang' => $id_gudang_asal))->kode_gudang;
            $kode_gudang_tujuan = $this->Base_model->get_specific('gudang', array('id_gudang' => $id_gudang_tujuan))->kode_gudang;
            $kode_hand_over = sprintf('%05d', $this->Base_model->get_last_primary_key('hand_over', 'id_hand_over'));
            
            $array_model = array(
                'id_admin' => $this->session->userdata('id_admin'),
                'id_gudang_asal' => $id_gudang_asal,
                'id_gudang_tujuan' => $id_gudang_tujuan,
                'kode_hand_over' => $kode_gudang_asal.$kode_hand_over.$kode_gudang_tujuan,
                'tanggal_dibuat' => $this->input->post('insert_tanggal_dibuat', TRUE),
                'status_hand_over' => 'diproses'
            );

                $id_hand_over = $this->Base_model->insert('hand_over', $array_model);
                if($id_hand_over === false)
                {
                    return false;
                }else{
                    return $id_hand_over;
                }
        }else{
            return false;
        }

        return true;
    }

    public function insert_detail_hand_over($id_hand_over)
        {

        $id_barang = $this->input->post('insert_id_barang[]');
        $jumlah = $this->input->post('insert_jumlah_barang[]');
        $keterangan = $this->input->post('insert_keterangan[]');

        for ($i=0; $i < count($id_barang); $i++) { 
            $array_model = array(
                'id_hand_over' => $id_hand_over,
                'id_barang' => $id_barang[$i],
                'jumlah' => $jumlah[$i],
                'keterangan' => isset($keterangan[$i]) ? $keterangan[$i]: null
            );
            
            if($this->Base_model->insert('detail_hand_over', $array_model) === false)
            {
                return false;
            }
        }
        return true;

    }

    public function delete_hand_over($id_hand_over)
        {
        $all_barang = $this->Base_model->get_all_specific('detail_hand_over', array("id_hand_over" => $id_hand_over) );
        
        for ($i=0; $i < count($all_barang); $i++) 
        { 
            if($this->manajemen_stok->reduce_total_stock($all_barang[$i]->id_barang, $all_barang[$i]->jumlah ) === false)
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

    public function cetak_hand_over($id_hand_over)
    {
        $data['data_hand_over'] = $this->Hand_over_model->get_specific_hand_over(array('id_hand_over' => $id_hand_over));
        $data['data_detail_hand_over'] = $this->Hand_over_model->get_all_detail_hand_over_by_id_hand_over($id_hand_over);

        $this->load->view('cetak_hand_over', $data);
    }
}

/* End of file Hand_over.php */

?>