<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Grafik extends MY_Controller {
        
        
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Grafik_model');
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

        public function get_grafik_penjualan($where, $group_by = 'DATE(penjualan.tanggal_penjualan)'){
            return $this->Grafik_model->get_grafik_penjualan($where, $group_by);
        }
    
        public function get_grafik_pre_order($where, $group_by = 'DATE(pre_order.tanggal_setor)'){
            return $this->Grafik_model->get_grafik_pre_order($where, $group_by);
        }

        public function get_grafik_hand_over($where, $group_by = 'DATE(hand_over.tanggal_dibuat)'){
            return $this->Grafik_model->get_grafik_hand_over($where, $group_by);
        }

        public function get_all_produk_terlaris($where){
            return $this->Grafik_model->get_all_produk_terlaris($where);
        }
    }
    
    /* End of file Grafik.php */
    
?>