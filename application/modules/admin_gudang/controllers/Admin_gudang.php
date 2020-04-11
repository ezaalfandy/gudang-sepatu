<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Admin_gudang extends MY_Controller {
        
        public function __construct()
        {
            parent::__construct();            
            $this->load->module('pre_order');
            $this->load->module('manajemen_stok');
            $this->load->module('hand_over');
            $this->load->module('image_manipulation');
        }
        
        public function index()
        {   
            redirect('admin_gudang/dashboard');
        }

        public function page_missing()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {   
                $this->output->set_status_header(404);
                $data['main_view'] = 'page_missing';
                $this->load->view('template_admin_gudang', $data, FALSE);
            }else{
                redirect('Account');
            }
        }

        public function dashboard()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $data['main_view'] = 'dashboard';
                $this->load->view('template_admin_gudang', $data, FALSE);
            }else{
                redirect('Account');
            }
        }
        
        
        public function view_stok_barang()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $id_gudang = $this->session->userdata('id_gudang');
                $data['data_gudang'] = $this->Base_model->get_specific('gudang', array('id_gudang' => $id_gudang));
                $data['data_stok_barang'] = $this->manajemen_stok->get_specific_stok_barang(array('stok_barang.id_gudang' => $id_gudang));
                $data['main_view'] = 'stok_barang';
                $this->load->view('template_admin_gudang', $data, FALSE);
            }else{
                redirect('Account');
            }
        }
        
        public function view_pre_order()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {   
                $where_pre_order = array(
                    "id_gudang_tujuan" => $this->session->userdata('id_gudang')
                );

                $data['data_pre_order'] = $this->pre_order->get_all_specific_pre_order($where_pre_order);
                $data['main_view'] = 'pre_order';
                $this->load->view('template_admin_gudang', $data, FALSE);
            }else{
                redirect('Account');
            }
        }

        public function view_detail_pre_order()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $kode_pre_order = $this->uri->segment(3);
                $data['data_pre_order'] = $this->pre_order->get_specific_pre_order(array('kode_pre_order' => $kode_pre_order));

                if($data['data_pre_order'] !== null)
                {   
                    $id_pre_order = $data['data_pre_order']->id_pre_order;
                    $data['data_detail_pre_order'] = $this->pre_order->get_all_specific_detail_pre_order(array('id_pre_order' => $id_pre_order));
                    $data['main_view'] = 'detail_pre_order';
                    $this->load->view('template_admin_gudang', $data, FALSE);
                }else
                {
                    $this->page_missing();
                }
            }else{
                redirect('Account');
            }
        }
        
        public function terima_pre_order()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                if($this->pre_order->terima_pre_order($this->uri->segment(3))  == true)
                {
                    $array = array(
                        'status' => 'success',
                        'message' => 'Pre order berhasil diterima'
                    );
                }else{
                    $array = array(
                        'status' => 'failed',
                        'message' => 'Pre order gagal diterima'
                    );
                }
                $this->session->set_flashdata($array);
                redirect('admin-gudang/view-pre-order');
            }else
            {
                redirect('Account');
            }
        }

        public function cetak_pre_order()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $this->pre_order->cetak_pre_order($this->uri->segment(3));
            }else{
                redirect('Account');
            }
        }

        public function cetak_barcode_pre_order()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $this->pre_order->cetak_barcode_pre_order($this->uri->segment(3));
            }else{
                redirect('Account');
            }
        }

        
        public function view_hand_over()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $data['data_hand_over'] = $this->hand_over->get_all_hand_over();
                $data['data_gudang'] = $this->Base_model->get_all('gudang');
                $data['data_supplier'] = $this->Base_model->get_all('supplier');
                $data['data_barang'] = $this->Base_model->get_all('barang');
                $data['main_view'] = 'hand_over';
                $this->load->view('template_admin_gudang', $data, FALSE);
            }else{
                redirect('Account');
            }
        }
        
        public function view_edit_hand_over($id_hand_over = null)
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $id_hand_over = ($this->uri->segment(3) == null) ? $id_hand_over : $this->uri->segment(3);
                $data['data_hand_over'] = $this->hand_over->get_specific_hand_over(array('id_hand_over' => $id_hand_over));
                
                if($data['data_hand_over'] !== null)
                {
                    
                    $where_stok_barang = array(
                        'stok_barang.id_gudang' => $data['data_hand_over']->id_gudang_asal,
                        'jumlah_stok >' => "0"
                    ); 
                    $data['data_gudang'] = $this->Base_model->get_all('gudang');
                    $data['data_barang'] = $this->manajemen_stok->get_specific_stok_barang($where_stok_barang);
                    $data['data_detail_hand_over'] = $this->hand_over->get_all_specific_detail_hand_over(array('id_hand_over' => $id_hand_over));
                    $data['main_view'] = 'edit_hand_over';
                    $this->load->view('template_admin_gudang', $data, FALSE);
                }else
                {
                    $this->page_missing();
                }
            }else{
                redirect('Account');
            }
        }

        public function terima_hand_over()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                if($this->hand_over->terima_hand_over($this->uri->segment(3))  == true)
                {
                    $array = array(
                        'status' => 'success',
                        'message' => 'Hand Over berhasil diterima'
                    );
                }else{
                    $array = array(
                        'status' => 'failed',
                        'message' => 'Hand Over gagal diterima'
                    );
                }
                $this->session->set_flashdata($array);
                redirect('admin-gudang/view-hand-over');
            }else
            {
                redirect('Account');
            }
        }      

        
        public function cetak_hand_over()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {   
                $id_hand_over = $this->uri->segment(3);
                $this->hand_over->cetak_hand_over(array('id_hand_over' => $id_hand_over));
            }else{
                redirect('Account');
            }
        }


    }
    
    /* End of file admin_gudang.php */
    
?>