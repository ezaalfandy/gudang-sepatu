<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_stok extends MY_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Manajemen_stok_model');
        
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

    public function index()
    {
        
    }

    public function reduce_total_stock($id_barang, $quantity)
    {
        if($this->Manajemen_stok_model->reduce_total_stock($id_barang, $quantity) == true)
        {
            return true;
        }else{
            return false;
        }
    }

    public function add_total_stock($id_barang, $quantity)
    {
        if($this->Manajemen_stok_model->add_total_stock($id_barang, $quantity) == true)
        {
            return true;
        }else{
            return false;
        }
    }

    public function create_specific_stok_barang_to_all_gudang($id_barang)
    {
        if($this->Manajemen_stok_model->create_specific_stok_barang_to_all_gudang($id_barang) == true)
        {
            return true;
        }else{
            return false;
        }
    }

    public function create_all_stok_barang_to_specific_gudang($id_gudang)
    {
        if($this->Manajemen_stok_model->create_all_stok_barang_to_specific_gudang($id_gudang) == true)
        {
            return true;
        }else{
            return false;
        }
    }

    public function reduce_specific_stok_barang($where, $quantity)
    {
        if($this->Manajemen_stok_model->reduce_specific_stok_barang($where, $quantity) == true)
        {
            return true;
        }else{
            return false;
        }
    }

    public function add_specific_stok_barang($where, $quantity)
    {
        if($this->Manajemen_stok_model->add_specific_stok_barang($where, $quantity) == true)
        {
            return true;
        }else{
            return false;
        }
    }

    public function get_all_specific_stok_barang($where, $json = FALSE)
    {
        $result = $this->Manajemen_stok_model->get_all_specific_stok_barang($where);
        return ($json == true) ? json_encode($result) : $result;
    }

    public function search_all_specific_stok_barang($where, $like, $json = FALSE)
    {
        $result = $this->Manajemen_stok_model->search_all_specific_stok_barang($where, $like);
        return ($json == true) ? json_encode($result) : $result;
    }

    public function get_all_barang_akan_habis($json = FALSE)
    {
        $result = $this->Manajemen_stok_model->get_all_barang_akan_habis();
        return ($json == true) ? json_encode($result) : $result;
    }

    public function get_all_specific_barang_akan_habis($where, $json = FALSE)
    {
        $result = $this->Manajemen_stok_model->get_all_specific_barang_akan_habis($where);
        return ($json == true) ? json_encode($result) : $result;
    }
}

/* End of file Manajemen_stok.php */

?>