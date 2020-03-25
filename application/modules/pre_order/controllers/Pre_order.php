<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pre_order extends MY_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pre_order_model');
        $this->load->model('Base_model');
    }
    
    public function index()
    {
        
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
            $kode_supplier = $this->Base_model->get_specific('supplier', array('id_supplier' => $id_supplier))->kode_supplier;

            $array_model = array(
                'id_admin' => $this->session->userdata('id_admin'),
                'id_supplier' => $id_supplier,
                'id_gudang_tujuan' => $this->input->post('insert_id_gudang_tujuan', TRUE),
                'kode_pre_order' => "AA"
            );
                if($this->Base_model->insert('pre_order', $array_model) !== false)
                {
                    $array = array(
                        'status' => 'success',
                        'message' => 'Berhasil Input Data'
                    );
                }else{
                    $array = array(
                        'status' => 'failed',
                        'message' => 'Gagal Input Data'
                    );
                }
                $this->session->set_flashdata($array);
                return true;
        }else{
            return false;
        }

        return true;
    }

    public function insert_detail_pre_order($insert_detail_pre_order){
        $id_barang = $this->input->post('insert_id_barang[]');
        $jumlah = $this->input->post('insert_jumlah_barang[]');
        $keteragan = $this->input->post('insert_keterangan[]');

        // $config = array(
        //     array(
        //         'field' => 'insert_id_supplier',
        //         'label' => ' Id Supplier',
        //         'rules' => 'required'
        //     ),
        //     array(
        //         'field' => 'insert_id_gudang_tujuan',
        //         'label' => ' Id Gudang Tujuan',
        //         'rules' => 'required'
        //     )
        // );

        // $this->form_validation->set_rules($config);
        // if($this->form_validation->run() == TRUE) 
        // {
        //     $id_supplier = $this->input->post('insert_id_supplier', TRUE);
        //     $kode_supplier = $this->base_model->get_specific('supplier', array('id_supplier' => $id_supplier))->kode_supplier;

        //     $array_model = array(
        //         'id_admin' => $this->session->userdata('id_admin'),
        //         'id_supplier' => $id_supplier,
        //         'id_gudang_tujuan' => $this->input->post('insert_id_gudang_tujuan', TRUE),
        //         'kode_pre_order' => $this->input->post('insert_kode_pre_order', TRUE)
        //     );
        //         if($this->Base_model->insert('pre_order', $array_model) !== false)
        //         {
        //             $array = array(
        //                 'status' => 'success',
        //                 'message' => 'Berhasil Input Data'
        //             );
        //         }else{
        //             $array = array(
        //                 'status' => 'failed',
        //                 'message' => 'Gagal Input Data'
        //             );
        //         }
        //         $this->session->set_flashdata($array);
        //         return true;
        // }else{
        //     return false;
        // }
    }


}

/* End of file Pre_order.php */

?>