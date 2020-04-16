<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Penjualan extends MY_Controller {
    
        public function __construct()
        {
            parent::__construct();
            $this->load->model('penjualan_model');
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
        
        public function insert_penjualan($id_gudang){

            $array_model = array(
                'id_admin' => $this->session->userdata('id_admin'),
                'id_gudang' => $id_gudang,
                'kode_order' => $this->input->post('insert_kode_order', TRUE),
                'jenis_transaksi' => $this->input->post('insert_jenis_transaksi', TRUE)
            );

            $id_penjualan = $this->Base_model->insert('penjualan', $array_model);

            if($id_penjualan !== FALSE)
            {
                return $id_penjualan;
            }else{
                return FALSE;
            }                

        }

        public function insert_detail_penjualan($id_penjualan, $id_gudang){

            $id_barang = $this->input->post('insert_id_barang[]');
            $jumlah = $this->input->post('insert_jumlah_barang[]');
            

            for ($i=0; $i < count($id_barang); $i++) { 
                $array_model = array(
                    'id_penjualan' => $id_penjualan,
                    'id_barang' => $id_barang[$i],
                    'jumlah' => $jumlah[$i]
                );
                
                if($this->Base_model->insert('detail_penjualan', $array_model) === false)
                {
                    return false;
                }else
                {
                    $where = array(
                        "id_barang" => $id_barang[$i],
                        "id_gudang" => $id_gudang
                    );

                    if($this->manajemen_stok->reduce_specific_stok_barang($where, $jumlah[$i] ) === false)
                    {
                        return false;
                    }
                }
            }
            return true;
        }





    }
    
    /* End of file Penjualan.php */
    

?>