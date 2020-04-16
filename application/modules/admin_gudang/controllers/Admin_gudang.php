<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Admin_gudang extends MY_Controller {
        
        public function __construct()
        {
            parent::__construct();            
            $this->load->module('penjualan');
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
        
        public function view_penjualan()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {   
                $where_penjualan = array(
                    "id_gudang_tujuan" => $this->session->userdata('id_gudang')
                );

                $data['data_penjualan'] = $this->penjualan->get_all_specific_penjualan($where_penjualan);
                $data['main_view'] = 'penjualan';
                $this->load->view('template_admin_gudang', $data, FALSE);
            }else{
                redirect('Account');
            }
        }

        public function view_detail_penjualan()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $kode_penjualan = $this->uri->segment(3);
                $data['data_penjualan'] = $this->penjualan->get_specific_penjualan(array('kode_penjualan' => $kode_penjualan));

                if($data['data_penjualan'] !== null)
                {   
                    $id_penjualan = $data['data_penjualan']->id_penjualan;
                    $data['data_detail_penjualan'] = $this->penjualan->get_all_specific_detail_penjualan(array('id_penjualan' => $id_penjualan));
                    $data['main_view'] = 'detail_penjualan';
                    $this->load->view('template_admin_gudang', $data, FALSE);
                }else
                {
                    $this->page_missing();
                }
            }else{
                redirect('Account');
            }
        }

        public function view_insert_penjualan()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $data['data_stok_barang'] = $this->manajemen_stok->get_specific_stok_barang(array('stok_barang.id_gudang' => $this->session->userdata('id_gudang')));
                $data['main_view'] = 'insert_penjualan';
                $this->load->view('template_admin_gudang', $data, FALSE);
            }else{
                redirect('Account');
            }
        }

              
        public function insert_penjualan()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {   
                
                $config = array(
                    array(
                        'field' => 'insert_jenis_transaksi',
                        'label' => 'Jenis Transaksi',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'insert_kode_order',
                        'label' => ' Id Gudang Tujuan',
                        'rules' => 'required'
                    )
                );

                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {   
                    $id_gudang = $this->session->userdata('id_gudang');
                    $id_penjualan = $this->penjualan->insert_penjualan($id_gudang);

                    if($id_penjualan !== false)
                    {
                        if($this->penjualan->insert_detail_penjualan($id_penjualan, $id_gudang) == true)
                        {
                            $array = array(
                                'status' => 'success',
                                'message' => 'Berhasil Input Data Penjualan'
                            );

                            $this->session->set_flashdata($array);
                            redirect('admin-gudang/view-insert-penjualan');
                        }else{
                            $array = array(
                                'status' => 'failed',
                                'message' => 'Gagal Input Data Penjualan'
                            );
                        }
                        
                    }else
                    {
                        $array = array(
                            'status' => 'failed',
                            'message' => 'Gagal Input Data Penjualan'
                        );
                    }
                    
                }else{
                    
                    // VALIDASI GAGAL
                    $array = array(
                        'status' => 'failed',
                        'message' => validation_errors(' ', '')
                    );
                }
                $this->session->set_flashdata($array);
                $this->view_insert_penjualan();
            }else
            {
                redirect('Account');
            }
        }

        public function view_terima_penjualan()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $kode_penjualan = $this->uri->segment(3);
                $data['data_penjualan'] = $this->penjualan->get_specific_penjualan(array('kode_penjualan' => $kode_penjualan));

                if($data['data_penjualan'] !== null)
                {   
                    $id_penjualan = $data['data_penjualan']->id_penjualan;
                    $data['data_detail_penjualan'] = $this->penjualan->get_all_specific_detail_penjualan(array('id_penjualan' => $id_penjualan));
                    $data['main_view'] = 'terima_penjualan';
                    $this->load->view('template_admin_gudang', $data, FALSE);
                }else
                {
                    $this->page_missing();
                }
            }else{
                redirect('Account');
            }
        }
        
        public function terima_penjualan()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                if($this->penjualan->terima_penjualan($this->uri->segment(3))  == true)
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
        
        public function view_hand_over_keluar()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $data['data_hand_over'] = $this->hand_over->get_all_specific_hand_over(array('id_gudang_asal' => $this->session->userdata('id_gudang')));
                $data['data_gudang'] = $this->Base_model->get_all('gudang');
                $data['data_supplier'] = $this->Base_model->get_all('supplier');
                $data['data_barang'] = $this->Base_model->get_all('barang');
                $data['main_view'] = 'hand_over_keluar';
                $this->load->view('template_admin_gudang', $data, FALSE);
            }else{
                redirect('Account');
            }
        }

        public function view_hand_over_masuk()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $data['data_hand_over'] = $this->hand_over->get_all_specific_hand_over(array('id_gudang_tujuan' => $this->session->userdata('id_gudang')));
                $data['data_gudang'] = $this->Base_model->get_all('gudang');
                $data['data_supplier'] = $this->Base_model->get_all('supplier');
                $data['data_barang'] = $this->Base_model->get_all('barang');
                $data['main_view'] = 'hand_over_masuk';
                $this->load->view('template_admin_gudang', $data, FALSE);
            }else{
                redirect('Account');
            }
        }
        
        public function view_detail_hand_over($kode_hand_over = null)
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $kode_hand_over = ($this->uri->segment(3) == null) ? $kode_hand_over : $this->uri->segment(3);
                $data['data_hand_over'] = $this->hand_over->get_specific_hand_over(array('kode_hand_over' => $kode_hand_over));
                
                if($data['data_hand_over'] !== null)
                {
                    
                    $where_stok_barang = array(
                        'stok_barang.id_gudang' => $data['data_hand_over']->id_gudang_asal,
                        'jumlah_stok >' => "0"
                    ); 
                    $data['data_gudang'] = $this->Base_model->get_all('gudang');
                    $data['data_barang'] = $this->manajemen_stok->get_specific_stok_barang($where_stok_barang);
                    $data['data_detail_hand_over'] = $this->hand_over->get_all_specific_detail_hand_over(array('id_hand_over' => $data['data_hand_over']->id_hand_over));
                    $data['main_view'] = 'detail_hand_over';
                    $this->load->view('template_admin_gudang', $data, FALSE);
                }else
                {
                    $this->page_missing();
                }
            }else{
                redirect('Account');
            }
        }

        public function view_terima_hand_over($kode_hand_over = null)
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $kode_hand_over = ($this->uri->segment(3) == null) ? $kode_hand_over : $this->uri->segment(3);
                $data['data_hand_over'] = $this->hand_over->get_specific_hand_over(array('kode_hand_over' => $kode_hand_over));
                
                if($data['data_hand_over'] !== null)
                {
                    $where_stok_barang = array(
                        'stok_barang.id_gudang' => $data['data_hand_over']->id_gudang_asal,
                        'jumlah_stok >' => "0"
                    ); 
                    $data['data_gudang'] = $this->Base_model->get_all('gudang');
                    $data['data_barang'] = $this->manajemen_stok->get_specific_stok_barang($where_stok_barang);
                    $data['data_detail_hand_over'] = $this->hand_over->get_all_specific_detail_hand_over(array('id_hand_over' => $data['data_hand_over']->id_hand_over));
                    $data['main_view'] = 'terima_hand_over';
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
                redirect('admin-gudang/view-hand-over-masuk');
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