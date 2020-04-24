<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Admin_gudang extends MY_Controller {
        
        public $template_search_autocomplete_barang = NULL;
        public $template_notifikasi_barang_habis = NULL;
       
        public function __construct()
        {
            parent::__construct();            
            $this->load->module('pre_order');
            $this->load->module('manajemen_stok');
            $this->load->module('hand_over');
            $this->load->module('image_manipulation');
            $this->load->module('penjualan');
            $this->load->module('grafik');

            $this->template_search_autocomplete_barang = $this->Base_model->get_all('barang');
            
            $where_barang_habis = array(
                'stok_barang.id_gudang' => $this->session->userdata('id_gudang')
            );
            $this->template_notifikasi_barang_habis = $this->manajemen_stok->get_all_specific_barang_akan_habis($where_barang_habis);
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
                
                $where_grafik_penjualan = array(
                    'penjualan.tanggal_penjualan >=' => 'DATE(NOW()) - INTERVAL 7 DAY',
                    'penjualan.id_gudang' => $this->session->userdata('id_gudang')
                );
                $data['data_grafik_penjualan_tujuh_hari'] = $this->grafik->get_grafik_penjualan($where_grafik_penjualan);

                $where_grafik_pre_order = array(
                    'pre_order.tanggal_setor >=' => 'DATE(NOW()) - INTERVAL 7 DAY',
                    'pre_order.id_gudang_tujuan' => $this->session->userdata('id_gudang')
                );
                $data['data_grafik_pre_order_tujuh_hari'] = $this->grafik->get_grafik_pre_order($where_grafik_pre_order);

                $where_grafik_hand_over = array(
                    'hand_over.tanggal_dibuat >=' => 'DATE(NOW()) - INTERVAL 7 DAY',
                    'hand_over.id_gudang_asal' => $this->session->userdata('id_gudang')
                );
                $data['data_grafik_hand_over_tujuh_hari'] = $this->grafik->get_grafik_hand_over($where_grafik_hand_over);
                
                $where_barang_habis = array(
                    'stok_barang.id_gudang' => $this->session->userdata('id_gudang')
                );
                $data['data_barang_akan_habis'] = $this->manajemen_stok->get_all_specific_barang_akan_habis($where_barang_habis);

                $where_grafik_produk_terlaris = array(
                    'penjualan.tanggal_penjualan >=' => 'DATE(NOW()) - INTERVAL 1 MONTH',
                    'penjualan.id_gudang' => $this->session->userdata('id_gudang')
                );
                $data['data_produk_terlaris_bulan_ini'] = $this->grafik->get_all_produk_terlaris($where_grafik_produk_terlaris);

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
                $data['data_stok_barang'] = $this->manajemen_stok->get_all_specific_stok_barang(array('stok_barang.id_gudang' => $id_gudang));
                $data['main_view'] = 'stok_barang';
                $this->load->view('template_admin_gudang', $data, FALSE);
            }else{
                redirect('Account');
            }
        }
        
        public function view_detail_barang()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $data['data_barang'] = $this->Base_model->get_specific('barang', array('kode_barang' => $this->uri->segment(3)));
                if($data['data_barang'] !== null)
                {   
                    $id_barang = $data['data_barang']->id_barang;
                    $data['data_gambar_barang'] = $this->Base_model->get_all_specific('gambar_barang', array('id_barang' => $id_barang ));

                    $where_grafik_penjualan = array(
                        'penjualan.tanggal_penjualan >=' => 'DATE(NOW()) - INTERVAL 1 MONTH',
                        'barang.id_barang' => $data['data_barang']->id_barang,
                        'penjualan.id_gudang' => $this->session->userdata('id_gudang')
                    );
                    $data['data_grafik_penjualan_tujuh_hari'] = $this->grafik->get_grafik_penjualan($where_grafik_penjualan);

                    $where_grafik_pre_order = array(
                        'pre_order.tanggal_setor >=' => 'DATE(NOW()) - INTERVAL 1 MONTH',
                        'pre_order.id_gudang_tujuan' => $this->session->userdata('id_gudang')
                    );
                    $data['data_grafik_pre_order_tujuh_hari'] = $this->grafik->get_grafik_pre_order($where_grafik_pre_order);
                    
                    $where_grafik_penjualan_all_varian = array(
                        'penjualan.tanggal_penjualan >=' => 'DATE(NOW()) - INTERVAL 1 MONTH',
                        'barang.merek' => $data['data_barang']->merek,
                        'barang.tipe' => $data['data_barang']->tipe,
                        'penjualan.id_gudang' => $this->session->userdata('id_gudang')
                    );
                    $group_by_penjualan_all_varian = array('merek', 'tipe', 'warna', 'DATE(penjualan.tanggal_penjualan)');
                    $data['data_grafik_penjualan_all_varian'] = $this->grafik->get_grafik_penjualan(
                        $where_grafik_penjualan_all_varian,
                        $group_by_penjualan_all_varian
                    );

                    
                    $where_grafik_penjualan_berdasarkan_ukuran = array(
                        'penjualan.tanggal_penjualan >=' => 'DATE(NOW()) - INTERVAL 6 MONTH',
                        'barang.merek' => $data['data_barang']->merek,
                        'barang.tipe' => $data['data_barang']->tipe,
                        'penjualan.id_gudang' => $this->session->userdata('id_gudang')
                    );
                    $group_by_penjualan_berdasarkan_ukuran = array('merek', 'tipe', 'warna');
                    $data['data_grafik_penjualan_berdasarkan_ukuran'] = $this->grafik->get_grafik_penjualan(
                        $where_grafik_penjualan_berdasarkan_ukuran,
                        $group_by_penjualan_berdasarkan_ukuran
                    );
                    
                    
                    $where_barang_sejenis = array(
                        'barang.merek' => $data['data_barang']->merek,
                        'barang.tipe' => $data['data_barang']->tipe,
                        'stok_barang.id_gudang' => $this->session->userdata('id_gudang')
                    );
                    $data['data_barang_sejenis'] = $this->manajemen_stok->get_all_specific_stok_barang(
                        $where_barang_sejenis
                    );

                    $data['main_view'] = 'detail_barang';
                    $this->load->view('template_admin_gudang', $data, FALSE);
                }else
                {
                    $this->page_missing();
                }
                
            }else{
                redirect('Account');
            }
        }

        public function search_barang()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {   
                $or_like = array(
                    'kode_barang' => $this->input->get('search_string'),
                    'merek' => $this->input->get('search_string'),
                    'warna' => $this->input->get('search_string'),
                    'ukuran' => $this->input->get('search_string')
                );
                $where = array(
                    'stok_barang.id_barang' => $this->session->userdata('id_gudang')
                );
                $data['data_barang'] = $this->manajemen_stok->search_all_specific_stok_barang($where,$or_like);
                $data['data_search_string'] = $this->input->get('search_string');
                
                $data['main_view'] = 'search_result';
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

        public function view_terima_pre_order()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $kode_pre_order = $this->uri->segment(3);
                $data['data_pre_order'] = $this->pre_order->get_specific_pre_order(array('kode_pre_order' => $kode_pre_order));

                if($data['data_pre_order'] !== null)
                {   
                    $id_pre_order = $data['data_pre_order']->id_pre_order;
                    $data['data_detail_pre_order'] = $this->pre_order->get_all_specific_detail_pre_order(array('id_pre_order' => $id_pre_order));
                    $data['main_view'] = 'terima_pre_order';
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
                    $data['data_barang'] = $this->manajemen_stok->get_all_specific_stok_barang($where_stok_barang);
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
                    $data['data_barang'] = $this->manajemen_stok->get_all_specific_stok_barang($where_stok_barang);
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
        
        public function view_penjualan()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {   
                $data['data_penjualan'] = $this->penjualan->get_all_specific_penjualan(
                    array('penjualan.id_gudang' => $this->session->userdata('id_gudang'))
                );

                $data['main_view'] = 'penjualan';
                $this->load->view('template_admin_gudang', $data, FALSE);
            }else{
                redirect('Account');
            }
        }

        public function view_insert_penjualan()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $data['data_penjualan'] = $this->penjualan->get_all_specific_penjualan(
                    array('penjualan.id_gudang' => $this->session->userdata('id_gudang')), 
                    'id_penjualan DESC',
                    5
                );

                $data['data_stok_barang'] = $this->manajemen_stok->get_all_specific_stok_barang(array('stok_barang.id_gudang' => $this->session->userdata('id_gudang')));
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
        
        public function delete_penjualan()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                if($this->penjualan->delete_penjualan($this->uri->segment(3))  == true)
                {
                    $array = array(
                        'status' => 'success',
                        'message' => 'Berhasil Hapus Data'
                    );
                }else{
                    $array = array(
                        'status' => 'failed',
                        'message' => 'Gagal Hapus Data'
                    );
                }
                $this->session->set_flashdata($array);
                redirect('admin-gudang/view-penjualan');
            }else
            {
                redirect('Account');
            }
        }   

        public function delete_penjualan_view_insert()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                if($this->penjualan->delete_penjualan($this->uri->segment(3))  == true)
                {
                    $array = array(
                        'status' => 'success',
                        'message' => 'Berhasil Hapus Data'
                    );
                }else{
                    $array = array(
                        'status' => 'failed',
                        'message' => 'Gagal Hapus Data'
                    );
                }
                $this->session->set_flashdata($array);
                redirect('admin-gudang/view-insert-penjualan');
            }else
            {
                redirect('Account');
            }
        }   

        public function view_kalender()
        {
            if($this->session->userdata('level') == 'admin_gudang')
            {
                $id_gudang = $this->session->userdata('id_gudang');
                $data['data_pre_order'] = $this->Base_model->get_all_specific('pre_order', array('id_gudang_tujuan' => $id_gudang));
                $data['data_hand_over_keluar'] = $this->Base_model->get_all_specific('hand_over', array('id_gudang_asal' => $id_gudang));
                $data['data_hand_over_masuk'] = $this->Base_model->get_all_specific('hand_over', array('id_gudang_tujuan' => $id_gudang));
                $data['main_view'] = 'kalender';
                $this->load->view('template_admin_gudang', $data, FALSE);
            }else{
                redirect('Account');
            }
        }

    }
    
    /* End of file admin_gudang.php */
    
?>