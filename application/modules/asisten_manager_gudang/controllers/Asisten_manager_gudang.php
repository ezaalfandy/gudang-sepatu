<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Asisten_manager_gudang extends MY_Controller {
        
        public $template_search_autocomplete_barang = NULL;
        public function __construct()
        {
            parent::__construct();            
            $this->load->module('pre_order');
            $this->load->module('manajemen_stok');
            $this->load->module('account');
            $this->load->module('hand_over');
            $this->load->module('image_manipulation');
            $this->load->module('grafik');
            $this->load->module('penjualan');
            $this->template_search_autocomplete_barang = $this->Base_model->get_all('barang');
        }
        
        public function index()
        {   
            redirect('asisten-manager-gudang/dashboard');
        }

        public function page_missing()
        {

            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $this->output->set_status_header(404);
                $data['main_view'] = 'page_missing';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('account/management');
            }
        }

        public function dashboard()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $data['data_total_barang'] = $this->Base_model->count_all('barang');
                $data['data_total_penjualan'] = $this->Base_model->count_all('penjualan');
                $data['data_total_pre_order'] = $this->Base_model->count_all('pre_order');
                $data['data_total_hand_over'] = $this->Base_model->count_all('hand_over');

                $where_grafik_penjualan = array(
                    'penjualan.tanggal_penjualan >=' => 'DATE(NOW()) - INTERVAL 7 DAY'
                );
                $data['data_grafik_penjualan_tujuh_hari'] = $this->grafik->get_grafik_penjualan($where_grafik_penjualan);

                $where_grafik_pre_order = array(
                    'pre_order.tanggal_setor >=' => 'DATE(NOW()) - INTERVAL 7 DAY'
                );
                $data['data_grafik_pre_order_tujuh_hari'] = $this->grafik->get_grafik_pre_order($where_grafik_pre_order);

                
                $where_grafik_hand_over = array(
                    'hand_over.tanggal_dibuat >=' => 'DATE(NOW()) - INTERVAL 7 DAY'
                );
                $data['data_grafik_hand_over_tujuh_hari'] = $this->grafik->get_grafik_hand_over($where_grafik_hand_over);
                $data['data_barang_akan_habis'] = $this->manajemen_stok->get_all_barang_akan_habis();

                $where_grafik_produk_terlaris = array(
                    'penjualan.tanggal_penjualan >=' => 'DATE(NOW()) - INTERVAL 1 MONTH',
                );
                $data['data_produk_terlaris_bulan_ini'] = $this->grafik->get_all_produk_terlaris($where_grafik_produk_terlaris);

                $data['main_view'] = 'dashboard';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('account/management');
            }
        }

        public function view_gudang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $data['data_gudang'] = $this->Base_model->get_all('gudang');
                $data['main_view'] = 'gudang';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('account/management');
            }
        }
        
        public function view_detail_gudang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $data['data_gudang'] = $this->Base_model->get_specific('gudang', array('kode_gudang' => $this->uri->segment(3)));
                if($data['data_gudang'] !== null)
                {   
                    $id_gudang = $data['data_gudang']->id_gudang;
                    $data['data_stok_barang'] = $this->manajemen_stok->get_all_specific_stok_barang(array('stok_barang.id_gudang' => $id_gudang));
                    
                    $where_grafik_penjualan = array(
                        'penjualan.tanggal_penjualan >=' => 'DATE(NOW()) - INTERVAL 7 DAY',
                        'penjualan.id_gudang' => $data['data_gudang']->id_gudang
                    );
                    $data['data_grafik_penjualan_tujuh_hari'] = $this->grafik->get_grafik_penjualan($where_grafik_penjualan);

                    $where_grafik_pre_order = array(
                        'pre_order.tanggal_setor >=' => 'DATE(NOW()) - INTERVAL 7 DAY',
                        'pre_order.id_gudang_tujuan' => $data['data_gudang']->id_gudang
                    );
                    $data['data_grafik_pre_order_tujuh_hari'] = $this->grafik->get_grafik_pre_order($where_grafik_pre_order);

                    
                    $where_grafik_hand_over = array(
                        'hand_over.tanggal_dibuat >=' => 'DATE(NOW()) - INTERVAL 7 DAY',
                        'hand_over.id_gudang_asal' => $data['data_gudang']->id_gudang
                    );
                    $data['data_grafik_hand_over_tujuh_hari'] = $this->grafik->get_grafik_hand_over($where_grafik_hand_over);
                    
                    $where_stok_barang_akan_habis = array(
                        'gudang.id_gudang' => $data['data_gudang']->id_gudang
                    );
                    $data['data_barang_akan_habis'] = $this->manajemen_stok->get_all_specific_barang_akan_habis($where_stok_barang_akan_habis);

                    $where_grafik_produk_terlaris = array(
                        'penjualan.tanggal_penjualan >=' => 'DATE(NOW()) - INTERVAL 1 MONTH',
                        'penjualan.id_gudang' => $data['data_gudang']->id_gudang
                    );
                    $data['data_produk_terlaris_bulan_ini'] = $this->grafik->get_all_produk_terlaris($where_grafik_produk_terlaris);


                    $data['main_view'] = 'detail_gudang';
                    $this->load->view('template_asisten_manager_gudang', $data, FALSE);
                }else
                {
                    $this->page_missing();
                }
                
            }else{
                redirect('account/management');
            }
        }

        public function insert_gudang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {        
                $config = array(
                            array(
                                'field' => 'insert_kode_gudang',
                                'label' => 'Kode Gudang',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'insert_alamat',
                                'label' => ' Alamat',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'insert_kabupaten_kota',
                                'label' => ' Kabupaten Kota',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'insert_provinsi',
                                'label' => ' Provinsi',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'insert_kode_pos',
                                'label' => ' Kode Pos',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'insert_nomor_telepon',
                                'label' => ' Nomor Telepon',
                                'rules' => 'required'
                            )
                    );
                
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {
                    $array_model = array(
                        'kode_gudang' => $this->input->post('insert_kode_gudang', TRUE),
                        'alamat' => $this->input->post('insert_alamat', TRUE),
                        'kabupaten_kota' => $this->input->post('insert_kabupaten_kota', TRUE),
                        'provinsi' => $this->input->post('insert_provinsi', TRUE),
                        'kode_pos' => $this->input->post('insert_kode_pos', TRUE),
                        'nomor_telepon' => $this->input->post('insert_nomor_telepon', TRUE)
                    );  
                        $id_gudang = $this->Base_model->insert('gudang', $array_model);
                        if( $id_gudang !== false)
                        {   
                            if($this->manajemen_stok->create_all_stok_barang_to_specific_gudang($id_gudang))
                            {
                                $array = array(
                                    'status' => 'success',
                                    'message' => 'Berhasil Input Data'
                                );
                            }
                            else
                            {
                                $array = array(
                                    'status' => 'failed',
                                    'message' => 'Gagal Input Data (function create_all_stok_barang_to_specific_gudang)'
                                );
                            }

                        }else
                        {
                            $array = array(
                                'status' => 'failed',
                                'message' => 'Gagal Input Data'
                            );
                        }
                        $this->session->set_flashdata($array);
                        redirect('asisten-manager-gudang/view-gudang');
                }else{
                    $this->view_gudang();
                }
                
            }else
            {
                redirect('account/management');
            }
        }
                              
        public function delete_gudang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $delete = $this->Base_model->delete('gudang', array('id_gudang' => $this->uri->segment(3)));
                if($delete === true)
                {
                    $array = array(
                        'status' => 'success',
                        'message' => 'Berhasil Hapus Data'
                    );
                }else{
                    $array = array(
                        'status' => 'failed',
                        'message' => $delete['message']
                    );
                }
                $this->session->set_flashdata($array);
                redirect('asisten-manager-gudang/view-gudang');
            }else
            {
                redirect('account/management');
            }
        }
                              
        public function edit_gudang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {        
                $config = array(
                            array(
                                'field' => 'edit_kode_gudang',
                                'label' => 'Kode Gudang',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'edit_alamat',
                                'label' => ' Alamat',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'edit_kabupaten_kota',
                                'label' => ' Kabupaten Kota',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'edit_provinsi',
                                'label' => ' Provinsi',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'edit_kode_pos',
                                'label' => ' Kode Pos',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'edit_nomor_telepon',
                                'label' => ' Nomor Telepon',
                                'rules' => 'required'
                            )
                    );
                
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {
                    $array_model = array(
                        'kode_gudang' => $this->input->post('edit_kode_gudang', TRUE),
                        'alamat' => $this->input->post('edit_alamat', TRUE),
                        'kabupaten_kota' => $this->input->post('edit_kabupaten_kota', TRUE),
                        'provinsi' => $this->input->post('edit_provinsi', TRUE),
                        'kode_pos' => $this->input->post('edit_kode_pos', TRUE),
                        'nomor_telepon' => $this->input->post('edit_nomor_telepon', TRUE)
                    );
                        $id_gudang = $this->input->post('edit_id_gudang', TRUE);
                        if($this->Base_model->edit('gudang', array("id_gudang" => $id_gudang), $array_model) == TRUE)
                        {
                            $array = array(
                                'status' => 'success',
                                'message' => 'Berhasil Edit Data'
                            );
                        }else{
                            $array = array(
                                'status' => 'failed',
                                'message' => 'Gagal Edit Data'
                            );
                        }
                        $this->session->set_flashdata($array);
                        redirect('asisten-manager-gudang/view-gudang');
                }else{
                    $this->view_gudang();
                }
                
            }else
            {
                redirect('account/management');
            }
        }
                              
        public function get_specific_gudang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $result = $this->Base_model->get_specific('gudang',  array("id_gudang" => $this->uri->segment(3)));
                echo json_encode($result);
            }else
            {
                redirect('account/management');
            }
        }                   

        public function view_aturan_barcode()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
        {
                $data['data_barang'] = $this->Base_model->get_all('barang');
                $data['data_merek'] = $this->Base_model->get_all('merek');
                $data['data_warna'] = $this->Base_model->get_all('warna');
                $data['main_view'] = 'aturan_barcode';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('account/management');
            }
        }
                      
        public function insert_merek()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {        
                $config = array(
                            array(
                                'field' => 'insert_nama_merek',
                                'label' => ' Nama Merek',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'insert_kode_merek',
                                'label' => ' Kode Merek',
                                'rules' => 'required'
                            )
                    );
                
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {
                    $array_model = array(
                        'nama_merek' => $this->input->post('insert_nama_merek', TRUE),
                        'kode_merek' => $this->input->post('insert_kode_merek', TRUE)
                    );
                        if($this->Base_model->insert('merek', $array_model) !== false)
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
                        redirect('asisten-manager-gudang/view-aturan-barcode');
                }else{
                    $this->view_aturan_barcode();
                }
                
            }else
            {
                redirect('account/management');
            }
        }
                              
        public function delete_merek()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                if($this->Base_model->delete('merek', array('id_merek' => $this->uri->segment(3)) ) == true)
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
                redirect('asisten-manager-gudang/view-aturan-barcode');
            }else
            {
                redirect('account/management');
            }
        }
                              
        public function edit_merek()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {        
                $config = array(
                            array(
                                'field' => 'edit_nama_merek',
                                'label' => ' Nama Merek',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'edit_kode_merek',
                                'label' => ' Kode Merek',
                                'rules' => 'required'
                            )
                    );
                
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {
                    $array_model = array(
                        'nama_merek' => $this->input->post('edit_nama_merek', TRUE),
                        'kode_merek' => $this->input->post('edit_kode_merek', TRUE)
                    );
                        $id_merek = $this->input->post('edit_id_merek', TRUE);
                        if($this->Base_model->edit('merek', array("id_merek" => $id_merek), $array_model) == TRUE)
                        {
                            $array = array(
                                'status' => 'success',
                                'message' => 'Berhasil Edit Data'
                            );
                        }else{
                            $array = array(
                                'status' => 'failed',
                                'message' => 'Gagal Edit Data'
                            );
                        }
                        $this->session->set_flashdata($array);
                        redirect('asisten-manager-gudang/view-aturan-barcode');
                }else{
                    $this->view_aturan_barcode();
                }
                
            }else
            {
                redirect('account/management');
            }
        }
                              
        public function get_specific_merek()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $result = $this->Base_model->get_specific('merek', array('id_merek' => $this->uri->segment(3)));
                echo json_encode($result);
            }else
            {
                redirect('account/management');
            }
        }
                            
                              
        public function insert_warna()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {        
                $config = array(
                            array(
                                'field' => 'insert_nama_warna',
                                'label' => ' Nama Warna',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'insert_kode_warna',
                                'label' => ' Kode Warna',
                                'rules' => 'required'
                            )
                    );
                
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {
                    $array_model = array(
                        'nama_warna' => $this->input->post('insert_nama_warna', TRUE),
                        'kode_warna' => $this->input->post('insert_kode_warna', TRUE)
                    );
                        if($this->Base_model->insert('warna', $array_model) !== false)
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
                        redirect('asisten-manager-gudang/view-aturan-barcode');
                }else{
                    $this->view_aturan_barcode();
                }
                
            }else
            {
                redirect('account/management');
            }
        }
                              
        public function delete_warna()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                if($this->Base_model->delete('warna',  array('id_warna'=> $this->uri->segment(3)) ) == true)
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
                redirect('asisten-manager-gudang/view-aturan-barcode');
            }else
            {
                redirect('account/management');
            }
        }
                              
        public function edit_warna()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {        
                $config = array(
                            array(
                                'field' => 'edit_nama_warna',
                                'label' => ' Nama Warna',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'edit_kode_warna',
                                'label' => ' Kode Warna',
                                'rules' => 'required'
                            )
                    );
                
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {
                    $array_model = array(
                        'nama_warna' => $this->input->post('edit_nama_warna', TRUE),
                        'kode_warna' => $this->input->post('edit_kode_warna', TRUE)
                    );
                        $id_warna = $this->input->post('edit_id_warna', TRUE);
                        if($this->Base_model->edit('warna', array("id_warna" => $id_warna), $array_model) == TRUE)
                        {
                            $array = array(
                                'status' => 'success',
                                'message' => 'Berhasil Edit Data'
                            );
                        }else{
                            $array = array(
                                'status' => 'failed',
                                'message' => 'Gagal Edit Data'
                            );
                        }
                        $this->session->set_flashdata($array);
                        redirect('asisten-manager-gudang/view-aturan-barcode');
                }else{
                    $this->view_aturan_barcode();
                }
                
            }else
            {
                redirect('account/management');
            }
        }
                              
        public function get_specific_warna()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $result = $this->Base_model->get_specific('warna',  array('id_warna'=> $this->uri->segment(3)));
                echo json_encode($result);
            }else
            {
                redirect('account/management');
            }
        }          

        public function search_barang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $or_like = array(
                    'kode_barang' => $this->input->get('search_string'),
                    'merek' => $this->input->get('search_string'),
                    'warna' => $this->input->get('search_string'),
                    'ukuran' => $this->input->get('search_string')
                );
                $data['data_barang'] = $this->Base_model->get_all_or_like('barang', $or_like);
                $data['data_search_string'] = $this->input->get('search_string');
                
                $data['main_view'] = 'search_result';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('account/management');
            }
        }

        public function view_barang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $data['data_barang'] = $this->Base_model->get_all('barang');
                $data['data_merek'] = $this->Base_model->get_all('merek');
                $data['data_warna'] = $this->Base_model->get_all('warna');
                $data['main_view'] = 'barang';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('account/management');
            }
        }

        public function view_detail_barang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $data['data_barang'] = $this->Base_model->get_specific('barang', array('kode_barang' => $this->uri->segment(3)));
                if($data['data_barang'] !== null)
                {   
                    $id_barang = $data['data_barang']->id_barang;
                    $data['data_gambar_barang'] = $this->Base_model->get_all_specific('gambar_barang', array('id_barang' => $id_barang ));
                    $data['data_stok_barang'] = $this->manajemen_stok->get_all_specific_stok_barang(array('stok_barang.id_barang' => $id_barang));

                    
                    $where_grafik_penjualan = array(
                        'penjualan.tanggal_penjualan >=' => 'DATE(NOW()) - INTERVAL 1 MONTH',
                        'barang.id_barang' => $data['data_barang']->id_barang
                    );
                    $data['data_grafik_penjualan_tujuh_hari'] = $this->grafik->get_grafik_penjualan($where_grafik_penjualan);

                    $where_grafik_pre_order = array(
                        'pre_order.tanggal_setor >=' => 'DATE(NOW()) - INTERVAL 1 MONTH'
                    );
                    $data['data_grafik_pre_order_tujuh_hari'] = $this->grafik->get_grafik_pre_order($where_grafik_pre_order);
                    
                    $where_grafik_penjualan_all_varian = array(
                        'penjualan.tanggal_penjualan >=' => 'DATE(NOW()) - INTERVAL 1 MONTH',
                        'barang.merek' => $data['data_barang']->merek,
                        'barang.tipe' => $data['data_barang']->tipe
                    );
                    $group_by_penjualan_all_varian = array('merek', 'tipe', 'warna', 'DATE(penjualan.tanggal_penjualan)');
                    $data['data_grafik_penjualan_all_varian'] = $this->grafik->get_grafik_penjualan(
                        $where_grafik_penjualan_all_varian,
                        $group_by_penjualan_all_varian
                    );

                    
                    $where_grafik_penjualan_berdasarkan_ukuran = array(
                        'penjualan.tanggal_penjualan >=' => 'DATE(NOW()) - INTERVAL 6 MONTH',
                        'barang.merek' => $data['data_barang']->merek,
                        'barang.tipe' => $data['data_barang']->tipe
                    );
                    $group_by_penjualan_berdasarkan_ukuran = array('merek', 'tipe', 'warna');
                    $data['data_grafik_penjualan_berdasarkan_ukuran'] = $this->grafik->get_grafik_penjualan(
                        $where_grafik_penjualan_berdasarkan_ukuran,
                        $group_by_penjualan_berdasarkan_ukuran
                    );
                    
                    
                    $where_barang_sejenis = array(
                        'barang.merek' => $data['data_barang']->merek,
                        'barang.tipe' => $data['data_barang']->tipe
                    );
                    $data['data_barang_sejenis'] = $this->Base_model->get_all_specific(
                        'barang',
                        $where_barang_sejenis
                    );

                    $data['main_view'] = 'detail_barang';
                    $this->load->view('template_asisten_manager_gudang', $data, FALSE);
                }else
                {
                    $this->page_missing();
                }
                
            }else{
                redirect('account/management');
            }
        }
                              
        public function insert_barang()
        {   
            
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {        
                $config = array(
                            array(
                                'field' => 'autocomplete_insert_merek',
                                'label' => ' Merek',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'insert_tipe',
                                'label' => ' Tipe',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'autocomplete_insert_warna',
                                'label' => ' Warna',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'insert_ukuran',
                                'label' => ' Ukuran',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'insert_alarm_stok_minimal',
                                'label' => 'Alarm Stok Minimal',
                                'rules' => 'required'
                            )
                    );
                
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {   
                    
                    $kode_merek = $this->input->post('kode_merek', TRUE);
                    $kode_warna = $this->input->post('kode_warna', TRUE);
                    $tipe = $this->input->post('insert_tipe', TRUE);
                    $ukuran = $this->input->post('insert_ukuran', TRUE);

                    $kode_barang = $kode_merek.$tipe.$kode_warna.$ukuran;

                    $config['upload_path'] = './uploads/barang/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['max_size']  = '9000'; //diubah
                    
                    $file_gambar = [];
                    for ($i=0; $i < count($_FILES['insert_barang_gambar']['name']); $i++) { 
                        $_FILES['file']['name']     = $_FILES['insert_barang_gambar']['name'][$i]; 
                        $_FILES['file']['type']     = $_FILES['insert_barang_gambar']['type'][$i]; 
                        $_FILES['file']['tmp_name'] = $_FILES['insert_barang_gambar']['tmp_name'][$i]; 
                        $_FILES['file']['error']     = $_FILES['insert_barang_gambar']['error'][$i]; 
                        $_FILES['file']['size']     = $_FILES['insert_barang_gambar']['size'][$i]; 
                        
                        $config['file_name'] = $kode_barang.'_'.$i;
                        
                        $upload = $this->image_manipulation->upload('file', $config);
                        if($upload['status'] == true){

                            //MEMBUAT THUMBNAIL GAMBAR
                            $thumbnail = $this->image_manipulation->create_thumbnail($upload['data']['full_path']);
                            if($thumbnail['status'] == true){
                                $upload['data']['thumbnail'] = $upload['data']['raw_name'].'_thumb'.$upload['data']['file_ext'];
                                $file_gambar[] = $upload['data'];
                            }else{

                                $array = array(
                                    'status' => 'failed',
                                    'message' => 'Gagal membuat thumbnail Gambar'
                                );
                                
                                $this->session->set_flashdata($array);
                                $this->view_barang();
                            }

                        }else{
                            $array = array(
                                'status' => 'failed',
                                'message' => 'Gagal Upload Gambar ('.$upload['message'].')'
                            );
                                
                            $this->session->set_flashdata($array);
                            redirect('asisten-manager-gudang/view-barang');
                        }
                        
                    }

                    $array_model = array(
                        'id_barang' => $this->input->post('insert_id_barang', TRUE),
                        'kode_barang' => $kode_barang,
                        'merek' => $this->input->post('autocomplete_insert_merek', TRUE),
                        'tipe' => $tipe,
                        'warna' => $this->input->post('autocomplete_insert_warna', TRUE),
                        'ukuran' => $ukuran,
                        'alarm_stok_minimal' => $this->input->post('insert_alarm_stok_minimal', TRUE),
                        'stok_tersedia' => 0
                    );
                        $id_barang = $this->Base_model->insert('barang', $array_model);
                        if($id_barang !== FALSE)
                        {   
                            
                            if($this->manajemen_stok->create_specific_stok_barang_to_all_gudang($id_barang) == TRUE)
                            {

                                foreach ($file_gambar as $k_file_gambar => $v_file_gambar) {
                                    $array_gambar_barang = array(
                                        "id_barang" => $id_barang,
                                        "nama_file" => $v_file_gambar['file_name'],
                                        "thumbnail" => $v_file_gambar['thumbnail']
                                    );
                                    $this->Base_model->insert('gambar_barang', $array_gambar_barang);
                                }

                                $array = array(
                                    'status' => 'success',
                                    'message' => 'Berhasil Input Data'
                                );
                            }
                            else
                            {
                                $array = array(
                                    'status' => 'failed',
                                    'message' => 'Gagal Input Data (function create_specific_stok_barang_to_all_gudang)'
                                );
                            }

                        }else{
                            $array = array(
                                'status' => 'failed',
                                'message' => 'Gagal Input Data'
                            );
                        }
                        $this->session->set_flashdata($array);
                        redirect('asisten-manager-gudang/view-barang');
                }else{
                    //VALIDASI FORM GAGAL
                    $this->view_barang();
                }
                
            }else
            {
                redirect('account/management');
            }
        }
                              
        public function delete_barang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $delete = $this->Base_model->delete('barang', array('id_barang' => $this->uri->segment(3)) );
                if($delete === true)
                {
                    $array = array(
                        'status' => 'success',
                        'message' => 'Berhasil Hapus Data'
                    );
                }else{
                    $array = array(
                        'status' => 'failed',
                        'message' => $delete['message']
                    );
                }
                $this->session->set_flashdata($array);
                redirect('asisten-manager-gudang/view-barang');
            }else
            {
                redirect('account/management');
            }
        }
                              
        public function edit_barang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {        
                $config = array(
                            array(
                                'field' => 'autocomplete_edit_merek',
                                'label' => ' Merek',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'edit_tipe',
                                'label' => ' Tipe',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'autocomplete_edit_warna',
                                'label' => ' Warna',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'edit_ukuran',
                                'label' => ' Ukuran',
                                'rules' => 'required'
                            )
                    );
                
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {   
                    
                    $kode_merek = $this->input->post('kode_merek', TRUE);
                    $kode_warna = $this->input->post('kode_warna', TRUE);
                    $tipe = $this->input->post('edit_tipe', TRUE);
                    $ukuran = $this->input->post('edit_ukuran', TRUE);

                    $kode_barang = $kode_merek.$tipe.$kode_warna.$ukuran;

                    $array_model = array(
                        'id_barang' => $this->input->post('edit_id_barang', TRUE),
                        'kode_barang' => $kode_barang,
                        'merek' => $this->input->post('autocomplete_edit_merek', TRUE),
                        'tipe' => $tipe,
                        'warna' => $this->input->post('autocomplete_edit_warna', TRUE),
                        'ukuran' => $ukuran
                    );
                        $id_barang = $this->input->post('edit_id_barang', TRUE);
                        if($this->Base_model->edit('barang', array("id_barang" => $id_barang), $array_model) == true)
                        {
                            $array = array(
                                'status' => 'success',
                                'message' => 'Berhasil Edit Data'
                            );
                        }else{
                            $array = array(
                                'status' => 'failed',
                                'message' => 'Gagal Edit Data'
                            );
                        }
                        $this->session->set_flashdata($array);
                        redirect('asisten-manager-gudang/view-barang');
                }else{
                    $this->view_barang();
                }
                
            }else
            {
                redirect('account/management');
            }
        }
                              
        public function get_specific_barang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $result = $this->Base_model->get_specific('barang', array('id_barang' => $this->uri->segment(3)));
                echo json_encode($result);
            }else
            {
                redirect('account/management');
            }
        }     

        public function get_all_specific_stok_barang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $where = array(
                    'stok_barang.id_gudang' => $this->uri->segment(3),
                    'jumlah_stok >' => "0"
                ); 
                
                echo $this->manajemen_stok->get_all_specific_stok_barang($where, TRUE);
            }else
            {
                redirect('account/management');
            }
        }
        
        public function view_supplier()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $data['data_supplier'] = $this->Base_model->get_all('supplier');
                $data['main_view'] = 'supplier';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('account/management');
            }
        }
        
        public function view_detail_supplier()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $data['data_supplier'] = $this->Base_model->get_specific('supplier', array('kode_supplier' => $this->uri->segment(3)));
                if($data['data_supplier'] !== null)
                {   
                    $id_supplier = $data['data_supplier']->id_supplier;
                    $data['data_pre_order'] = $this->pre_order->get_all_specific_pre_order(array('pre_order.id_supplier' => $id_supplier));
  
                    $where_grafik_pre_order = array(
                        'pre_order.tanggal_setor >=' => 'DATE(NOW()) - INTERVAL 1 MONTH',
                        'pre_order.id_supplier' => $id_supplier,
                    );
                    $data['data_grafik_pre_order'] = $this->grafik->get_grafik_pre_order($where_grafik_pre_order);
    
                    $data['main_view'] = 'detail_supplier';
                    $this->load->view('template_asisten_manager_gudang', $data, FALSE);
                }else
                {
                    $this->page_missing();
                }
                
            }else{
                redirect('account/management');
            }
        }

        public function insert_supplier()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {        
                $config = array(
                            array(
                                'field' => 'insert_kode_supplier',
                                'label' => ' Kode Supplier',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'insert_nama',
                                'label' => ' Nama',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'insert_alamat',
                                'label' => ' Alamat',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'insert_telepon',
                                'label' => ' Telepon',
                                'rules' => 'required'
                            )
                    );
                
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {
                    $array_model = array(
                        'id_supplier' => $this->input->post('insert_id_supplier', TRUE),
                        'kode_supplier' => $this->input->post('insert_kode_supplier', TRUE),
                        'nama_supplier' => $this->input->post('insert_nama', TRUE),
                        'alamat_supplier' => $this->input->post('insert_alamat', TRUE),
                        'telepon_supplier' => $this->input->post('insert_telepon', TRUE)
                    );
                        if($this->Base_model->insert('supplier', $array_model) == true)
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
                        redirect('asisten-manager-gudang/view-supplier');
                }else{
                    $this->view_supplier();
                }
                
            }else
            {
                redirect('account/management');
            }
        }
                                
        public function delete_supplier()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $delete = $this->Base_model->delete('supplier', array('id_supplier' => $this->uri->segment(3)) );
                if($delete === true)
                {
                    $array = array(
                        'status' => 'success',
                        'message' => 'Berhasil Hapus Data'
                    );
                }else{
                    $array = array(
                        'status' => 'failed',
                        'message' => $delete['message']
                    );
                }
                $this->session->set_flashdata($array);
                redirect('asisten-manager-gudang/view-supplier');
            }else
            {
                redirect('account/management');
            }
        }
                                
        public function edit_supplier()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {        
                $config = array(
                            array(
                                'field' => 'edit_kode_supplier',
                                'label' => ' Kode Supplier',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'edit_nama',
                                'label' => ' Nama',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'edit_alamat',
                                'label' => ' Alamat',
                                'rules' => 'required'
                            ),
                            array(
                                'field' => 'edit_telepon',
                                'label' => ' Telepon',
                                'rules' => 'required'
                            )
                    );
                
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {
                    $array_model = array(
                        'id_supplier' => $this->input->post('edit_id_supplier', TRUE),
                        'kode_supplier' => $this->input->post('edit_kode_supplier', TRUE),
                        'nama_supplier' => $this->input->post('edit_nama', TRUE),
                        'alamat_supplier' => $this->input->post('edit_alamat', TRUE),
                        'telepon_supplier' => $this->input->post('edit_telepon', TRUE)
                    );
                        $id_supplier = $this->input->post('edit_id_supplier', TRUE);
                        if($this->Base_model->edit('supplier', array("id_supplier" => $id_supplier), $array_model) == true)
                        {
                            $array = array(
                                'status' => 'success',
                                'message' => 'Berhasil Edit Data'
                            );
                        }else{
                            $array = array(
                                'status' => 'failed',
                                'message' => 'Gagal Edit Data'
                            );
                        }
                        $this->session->set_flashdata($array);
                        redirect('asisten-manager-gudang/view-supplier');
                }else{
                    $this->view_supplier();
                }
                
            }else
            {
                redirect('account/management');
            }
        }
                                
        public function get_specific_supplier()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $result = $this->Base_model->get_specific('supplier', array('id_supplier' => $this->uri->segment(3)));
                echo json_encode($result);
            }else
            {
                redirect('account/management');
            }
        }
        
        public function view_pre_order()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $data['data_pre_order'] = $this->pre_order->get_all_pre_order();
                $data['data_gudang'] = $this->Base_model->get_all('gudang');
                $data['data_supplier'] = $this->Base_model->get_all('supplier');
                $data['data_barang'] = $this->Base_model->get_all('barang');
                $data['main_view'] = 'pre_order';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('account/management');
            }
        }

        public function view_insert_pre_order()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $data['data_pre_order'] = $this->pre_order->get_all_pre_order();
                $data['data_gudang'] = $this->Base_model->get_all('gudang');
                $data['data_supplier'] = $this->Base_model->get_all('supplier');
                $data['data_barang'] = $this->Base_model->get_all('barang');
                $data['main_view'] = 'pre_order/insert_pre_order_per_seri';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('account/management');
            }
        }

        public function view_detail_pre_order()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $kode_pre_order = $this->uri->segment(3);
                $data['data_pre_order'] = $this->pre_order->get_specific_pre_order(array('kode_pre_order' => $kode_pre_order));
                if($data['data_pre_order'] !== null){
                    $data['data_detail_pre_order'] = $this->pre_order->get_all_specific_detail_pre_order(array('id_pre_order' => $data['data_pre_order']->id_pre_order));
                    $data['main_view'] = 'detail_pre_order';
                    $this->load->view('template_asisten_manager_gudang', $data, FALSE);
                }else{
                    $this->page_missing();
                }
            }else{
                redirect('account/management');
            }
        }

        public function view_edit_pre_order($kode_pre_order = null, $mode_satuan =  FALSE)
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                if($kode_pre_order !== null)
                {   
                    $data['data_pre_order'] = $this->pre_order->get_specific_pre_order(array('kode_pre_order' => $kode_pre_order));
                    if($data['data_pre_order']->status_pre_order == 'diterima'){
                        $this->page_missing();
                    }else{
                        $data['data_gudang'] = $this->Base_model->get_all('gudang');
                        $data['data_supplier'] = $this->Base_model->get_all('supplier');

                        $detail_pre_order = $this->pre_order->get_all_specific_detail_pre_order(array('id_pre_order' => $data['data_pre_order']->id_pre_order));
                        $seri = konversi_ke_mode_seri($detail_pre_order);

                        if($mode_satuan == 'mode-satuan' || $seri === FALSE)
                        {
                            //Rincian barang tidak lengkap, akan ditampilkan dalam mode satuan
                            $data['data_detail_pre_order'] = $detail_pre_order;
                            $data['main_view'] = 'pre_order/edit_pre_order';
                        }else{
                            $data['seri'] = $seri;
                            $data['main_view'] = 'pre_order/edit_pre_order_per_seri';
                        }
                        $this->load->view('template_asisten_manager_gudang', $data, FALSE);
                    }
                }else
                {
                    $this->page_missing();
                }
            }else{
                redirect('account/management');
            }
        }

        public function view_terima_pre_order($kode_pre_order = null, $mode_satuan =  FALSE)
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $kode_pre_order = ($this->uri->segment(3) == null) ? $kode_pre_order : $this->uri->segment(3);
                $data['data_pre_order'] = $this->pre_order->get_specific_pre_order(array('kode_pre_order' => $kode_pre_order));

                if($data['data_pre_order'] !== null)
                {
                    $data['data_gudang'] = $this->Base_model->get_all('gudang');
                    $data['data_supplier'] = $this->Base_model->get_all('supplier');

                    $detail_pre_order = $this->pre_order->get_all_specific_detail_pre_order(array('id_pre_order' => $data['data_pre_order']->id_pre_order));
                    $seri = konversi_ke_mode_seri($detail_pre_order);

                    // if($mode_satuan == 'mode-satuan' || $seri === FALSE)
                    // {
                        //Rincian barang tidak lengkap, akan ditampilkan dalam mode satuan
                        $data['data_detail_pre_order'] = $detail_pre_order;
                        $data['main_view'] = 'pre_order/terima_pre_order';
                    // }else{
                    //     $data['seri'] = $seri;
                    //     $data['main_view'] = 'pre_order/terima_pre_order_per_seri';
                    // }
                    $this->load->view('template_asisten_manager_gudang', $data, FALSE);

                }else
                {
                    $this->page_missing();
                }
            }else{
                redirect('account/management');
            }
        }
        
        public function cetak_pre_order()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $this->pre_order->cetak_pre_order($this->uri->segment(3));
            }else{
                redirect('account/management');
            }
        }

        public function cetak_barcode_pre_order()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $this->pre_order->cetak_barcode_pre_order($this->uri->segment(3));
            }else{
                redirect('account/management');
            }
        }

        public function cetak_barcode_by_kode_barang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $data['kode_barang'] = $this->input->get('kode_barang');
                $data['jumlah_barcode'] = $this->input->get('jumlah_barcode');
                $this->load->view('cetak_barcode_by_kode_barang', $data);
            }else{
                redirect('account/management');
            }
        }
        
        public function get_ajax_lookup_barang($uri_segment_3 = FALSE){
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                if($uri_segment_3 == 'per_ukuran')
                {
                    $result =  $this->Base_model->get_ajax_lookup_barang($this->input->get('query', TRUE));
                }else
                {
                    $result =  $this->Base_model->get_ajax_lookup_barang($this->input->get('query', TRUE), array("tipe", "warna"));
                }
                echo json_encode($result);
            }else{
                redirect('account/management');
            }
        }

        public function insert_pre_order($mode_satuan = FALSE)
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
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
                    ),
                    array(
                        'field' => 'insert_tanggal_dibuat',
                        'label' => 'Tanggal dibuat',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'insert_tanggal_setor',
                        'label' => 'Tanggal Setor',
                        'rules' => 'required'
                    )
                );

                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {   
                    $id_pre_order = $this->pre_order->insert_pre_order();

                    if($id_pre_order !== false)
                    {
                        $method = ($mode_satuan == FALSE) ? 'insert_detail_pre_order_per_seri' : 'insert_detail_pre_order';
                        if($this->pre_order->$method($id_pre_order) == true)
                        {
                            $array = array(
                                'status' => 'success',
                                'message' => 'Berhasil Input Data Pre order, silahkan 
                                    <a href="'.base_url('asisten-manager-gudang/cetak-barcode-pre-order/').$id_pre_order.'" target="_blank">
                                        <u>Cetak barcode </u>
                                    </a>
                                    atau 
                                    <a href="'.base_url('asisten-manager-gudang/cetak-pre-order/').$id_pre_order.'" target="_blank">
                                        <u>Cetak Surat sekarang</u>
                                    </a>'
                            );

                            $this->session->set_flashdata($array);
                            redirect('asisten-manager-gudang/view-insert-pre-order');
                        }else{
                            $array = array(
                                'status' => 'failed',
                                'message' => 'Gagal Input Data Pre Order'
                            );
                        }
                        
                    }else
                    {
                        $array = array(
                            'status' => 'failed',
                            'message' => 'Gagal Input Data Pre Order'
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
                $this->view_insert_pre_order();
            }else
            {
                redirect('account/management');
            }
        }
                              
        public function delete_pre_order()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                if($this->pre_order->delete_pre_order($this->uri->segment(3))  == true)
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
                redirect('asisten-manager-gudang/view-pre-order');
            }else
            {
                redirect('account/management');
            }
        }   
                        
        public function terima_pre_order()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $config = array(
                    array(
                        'field' => 'edit_id_supplier',
                        'label' => ' Id Supplier',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'edit_id_gudang_tujuan',
                        'label' => ' Id Gudang Tujuan',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'edit_tanggal_dibuat',
                        'label' => 'Tanggal dibuat',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'edit_tanggal_setor',
                        'label' => 'Tanggal Setor',
                        'rules' => 'required'
                    )
                );
                
                
                $id_pre_order = $this->input->post('edit_id_pre_order', TRUE);
                $data_pre_order = $this->pre_order->get_specific_pre_order(array('id_pre_order' => $id_pre_order));

                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {

                    /*
                        1 Tahap pertama simpan dulu hasil editan
                        2.Lakukan update stok
                    */
                    $edit_pre_order = $this->pre_order->edit_pre_order($id_pre_order);

                    if($edit_pre_order !== false)
                    {
                        if($this->pre_order->edit_detail_pre_order($id_pre_order) == true)
                        {   
                            
                            $terima_pre_order = $this->pre_order->terima_pre_order($id_pre_order);
                            if($terima_pre_order == true){
                                
                                $array = array(
                                    'status' => 'success',
                                    'message' => 'Pre order berhasil diterima, <a href="'.base_url('asisten-manager-gudang/cetak-barcode-pre-order/').$id_pre_order.'" target="_blank"><u>Cetak barcode sekarang</u></a>'
                                );

                                $this->session->set_flashdata($array);
                                redirect('asisten-manager-gudang/view-detail-pre-order/'.$data_pre_order->kode_pre_order);
                            }else
                            {

                                $array = array(
                                    'status' => 'failed',
                                    'message' => 'Gagal menerima pre order'
                                );
                            }
                        }else{
                            $array = array(
                                'status' => 'failed',
                                'message' => 'Gagal menerima pre order'
                            );
                        }
                        
                    }else
                    {
                        //insert table pre order gagal
                        $array = array(
                            'status' => 'failed',
                            'message' => 'Gagal menerima pre order'
                        );
                    }

                    $this->session->set_flashdata($array);
                    redirect('asisten-manager-gudang/view-terima-pre-order/'.$data_pre_order->kode_pre_order);
                }else{
                    //Validasi gagal
                    $array = array(
                        'status' => 'failed',
                        'message' => validation_errors(NULL, NULL)
                    );
                    $this->session->set_flashdata($array);
                    $this->view_terima_pre_order($data_pre_order->kode_pre_order);
                }
                
            }else
            {
                redirect('account/management');
            }
        }

        public function edit_pre_order($mode_satuan = FALSE)
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $config = array(
                    array(
                        'field' => 'edit_id_supplier',
                        'label' => ' Id Supplier',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'edit_id_gudang_tujuan',
                        'label' => ' Id Gudang Tujuan',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'edit_tanggal_dibuat',
                        'label' => 'Tanggal dibuat',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'edit_tanggal_setor',
                        'label' => 'Tanggal Setor',
                        'rules' => 'required'
                    )
                );
        
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {

                    $id_pre_order = $this->input->post('edit_id_pre_order', TRUE);
                    $edit_pre_order = $this->pre_order->edit_pre_order($id_pre_order);
                    $data['data_pre_order'] = $this->pre_order->get_specific_pre_order(array('id_pre_order' => $id_pre_order));

                    if($edit_pre_order !== false)
                    {   
                        
                        $method = ($mode_satuan === FALSE ) ? 'edit_detail_pre_order_per_seri' : 'edit_detail_pre_order';
                
                        if($this->pre_order->$method($id_pre_order) == true)
                        {
                            $array = array(
                                'status' => 'success',
                                'message' => 'Berhasil Edit Data Pre order, <a href="'.base_url('asisten-manager-gudang/cetak-barcode-pre-order/').$id_pre_order.'" target="_blank"><u>Cetak barcode sekarang</u></a>'
                            );
                        }else{
                            $array = array(
                                'status' => 'failed',
                                'message' => 'Gagal Edit Data Pre Order 2'
                            );
                        }
                        
                    }else
                    {
                        //insert table pre order gagal
                        $array = array(
                            'status' => 'failed',
                            'message' => 'Gagal Edit Data Pre Order 1'
                        );
                    }
                    
                    $this->session->set_flashdata($array);
                    redirect('asisten-manager-gudang/view-edit-pre-order/'.$data['data_pre_order']->kode_pre_order,'refresh');
                }else{
                    //Validasi gagal
                    $array = array(
                        'status' => 'failed',
                        'message' => validation_errors(' ', '')
                    );
                    
                    $this->session->set_flashdata($array);
                    $this->view_edit_pre_order($data['data_pre_order']->kode_pre_order, 'mode_satuan');
                }
            }else
            {
                redirect('account/management');
            }
        }
        
        public function view_edit_hand_over($kode_hand_over = null)
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $kode_hand_over = ($this->uri->segment(3) == null) ? $kode_hand_over : $this->uri->segment(3);
                $data['data_hand_over'] = $this->hand_over->get_specific_hand_over(array('kode_hand_over' => $kode_hand_over));
                
                if($data['data_hand_over'] !== null)
                {
                    if($data['data_hand_over']->status_hand_over == 'diterima')
                    {
                        $this->page_missing();
                    }else
                    {
                        $where_stok_barang = array(
                            'stok_barang.id_gudang' => $data['data_hand_over']->id_gudang_asal,
                            'jumlah_stok >' => "0"
                        ); 
                        $data['data_gudang'] = $this->Base_model->get_all('gudang');
                        $data['data_barang'] = $this->manajemen_stok->get_all_specific_stok_barang($where_stok_barang);
                        $data['data_detail_hand_over'] = $this->hand_over->get_all_specific_detail_hand_over(array('id_hand_over' => $data['data_hand_over']->id_hand_over));
                        $data['main_view'] = 'edit_hand_over';
                        $this->load->view('template_asisten_manager_gudang', $data, FALSE);
                    }
                }else
                {
                    $this->page_missing();
                }
            }else{
                redirect('account/management');
            }
        }

        public function view_detail_hand_over($kode_hand_over = null)
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
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
                    $this->load->view('template_asisten_manager_gudang', $data, FALSE);
                }else
                {
                    $this->page_missing();
                }
            }else{
                redirect('account/management');
            }
        }
        
        public function view_terima_hand_over($kode_hand_over = null)
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
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
                    $this->load->view('template_asisten_manager_gudang', $data, FALSE);
                }else
                {
                    $this->page_missing();
                }
            }else{
                redirect('account/management');
            }
        }

        public function get_specific_pre_order()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $result = $this->Base_model->get_specific('pre_order', 'id_pre_order', $this->uri->segment(3));
                echo json_encode($result);
            }else
            {
                redirect('account/management');
            }
        }
                            
        public function view_hand_over()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $data['data_hand_over'] = $this->hand_over->get_all_hand_over();
                $data['data_gudang'] = $this->Base_model->get_all('gudang');
                $data['data_supplier'] = $this->Base_model->get_all('supplier');
                $data['data_barang'] = $this->Base_model->get_all('barang');
                $data['main_view'] = 'hand_over';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('account/management');
            }
        }

        public function view_insert_hand_over()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $data['data_pre_order'] = $this->pre_order->get_all_pre_order();
                $data['data_gudang'] = $this->Base_model->get_all('gudang');
                $data['data_supplier'] = $this->Base_model->get_all('supplier');
                $data['data_barang'] = $this->Base_model->get_all('barang');
                $data['main_view'] = 'insert_hand_over';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('account/management');
            }
        }
        
        public function cetak_hand_over()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $id_hand_over = $this->uri->segment(3);
                $this->hand_over->cetak_hand_over(array('id_hand_over' => $id_hand_over));
            }else{
                redirect('account/management');
            }
        }
                              
        public function insert_hand_over()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                
                $config = array(
                    array(
                        'field' => 'insert_id_gudang_asal',
                        'label' => ' Id Gudang Asal',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'insert_id_gudang_tujuan',
                        'label' => ' Id Gudang Tujuan',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'insert_tanggal_dibuat',
                        'label' => 'Tanggal dibuat',
                        'rules' => 'required'
                    )
                );

                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {   
                    $id_hand_over = $this->hand_over->insert_hand_over();

                    if($id_hand_over !== false)
                    {
                        if($this->hand_over->insert_detail_hand_over($id_hand_over) == true)
                        {
                            $array = array(
                                'status' => 'success',
                                'message' => 'Berhasil input data hand over, <a href="'.base_url('asisten-manager-gudang/cetak-hand-over/').$id_hand_over.'" target="_blank"><u>Cetak surat hand over sekarang</u></a>'
                            );
                        }else{
                            $array = array(
                                'status' => 'failed',
                                'message' => 'Gagal input data hand over'
                            );
                        }
                        
                        $this->session->set_flashdata($array);
                        redirect('asisten-manager-gudang/view-insert-hand-over');
                    }else
                    {
                        $array = array(
                            'status' => 'failed',
                            'message' => 'Gagal Input Data Hand over'
                        );
                        $this->session->set_flashdata($array);
                        $this->view_insert_hand_over();
                    }
                    
                }else{
                    //VALIDASI GAGAL
                    $array = array(
                        'status' => 'failed',
                        'message' => validation_errors(' ', '')
                    );
                    $this->session->set_flashdata($array);
                    $this->view_insert_hand_over();
                }
            }else
            {
                redirect('account/management');
            }
        }
                              
        public function delete_hand_over()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                if($this->hand_over->delete_hand_over($this->uri->segment(3))  == true)
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
                redirect('asisten-manager-gudang/view-hand-over');
            }else
            {
                redirect('account/management');
            }
        }
        
        public function edit_hand_over()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $config = array(
                    array(
                        'field' => 'edit_id_gudang_asal',
                        'label' => ' Id Gudang Asal',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'edit_id_gudang_tujuan',
                        'label' => ' Id Gudang Tujuan',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'edit_tanggal_dibuat',
                        'label' => 'Tanggal dibuat',
                        'rules' => 'required'
                    )
                );
        
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {

                    $id_hand_over = $this->input->post('edit_id_hand_over', TRUE);
                    $data_hand_over = $this->hand_over->get_specific_hand_over(array('id_hand_over' => $id_hand_over));
                    $edit_hand_over = $this->hand_over->edit_hand_over($id_hand_over);
    
                    if($edit_hand_over !== false)
                    {
                        if($this->hand_over->edit_detail_hand_over($id_hand_over) == true)
                        {
                            $array = array(
                                'status' => 'success',
                                'message' => 'Berhasil Edit Data Hand Over, <a href="'.base_url('asisten-manager-gudang/cetak-hand-over/').$data_hand_over->kode_hand_over.'" target="_blank"><u>Cetak surat sekarang</u></a>'
                            );
                        }else{
                            $array = array(
                                'status' => 'failed',
                                'message' => 'Gagal Edit Data Hand Over'
                            );
                        }
                        
                    }else
                    {
                        //insert table pre order gagal
                        $array = array(
                            'status' => 'failed',
                            'message' => 'Gagal Edit Data Hand Over'
                        );
                    }

                    $this->session->set_flashdata($array);
                    redirect('asisten-manager-gudang/view-edit-hand-over/'.$data_hand_over->kode_hand_over);
                }else{
                    //Validasi gagal
                    $array = array(
                        'status' => 'failed',
                        'message' => validation_errors(' ', '')
                    );
                    $this->session->set_flashdata($array);
                    $this->view_edit_hand_over($this->input->post('edit_id_hand_over', TRUE));
                }
                
            }else
            {
                redirect('account/management');
            }
        }

        public function terima_hand_over()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $config = array(
                    array(
                        'field' => 'edit_id_gudang_asal',
                        'label' => ' Id Gudang Asal',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'edit_id_gudang_tujuan',
                        'label' => ' Id Gudang Tujuan',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'edit_tanggal_dibuat',
                        'label' => 'Tanggal dibuat',
                        'rules' => 'required'
                    )
                );
        
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {

                    $id_hand_over = $this->input->post('edit_id_hand_over', TRUE);
                    $data_hand_over = $this->hand_over->get_specific_hand_over(array('id_hand_over' => $id_hand_over));
                    $edit_hand_over = $this->hand_over->edit_hand_over($id_hand_over);
    
                    if($edit_hand_over !== false)
                    {
                        if($this->hand_over->edit_detail_hand_over($id_hand_over) == true)
                        {
                            if($this->hand_over->terima_hand_over($id_hand_over)  == true)
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
                            redirect('asisten-manager-gudang/view-hand-over');
                        }else{
                            $array = array(
                                'status' => 'failed',
                                'message' => 'Gagal Edit Data Hand Over'
                            );
                        }
                        
                    }else
                    {
                        //insert table pre order gagal
                        $array = array(
                            'status' => 'failed',
                            'message' => 'Gagal Edit Data Hand Over'
                        );
                    }

                    $this->session->set_flashdata($array);
                    redirect('asisten-manager-gudang/view-edit-hand-over/'.$data_hand_over->kode_hand_over);
                }else{
                    //Validasi gagal
                    $array = array(
                        'status' => 'failed',
                        'message' => validation_errors(' ', '')
                    );
                    $this->session->set_flashdata($array);
                    $this->view_edit_hand_over($this->input->post('edit_id_hand_over', TRUE));
                }
                
            }else
            {
                redirect('account/management');
            }
        }

        public function get_specific_hand_over()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $result = $this->Base_model->get_specific('hand_over', 'id_hand_over', $this->uri->segment(3));
                echo json_encode($result);
            }else
            {
                redirect('account/management');
            }
        }                                           
                            
        public function view_kalender()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                $data['data_pre_order'] = $this->Base_model->get_all('pre_order');
                $data['data_hand_over'] = $this->Base_model->get_all('hand_over');
                $data['main_view'] = 'kalender';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('account/management');
            }
        }

        public function view_penjualan()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $data['data_penjualan'] = $this->penjualan->get_all_penjualan();

                $data['main_view'] = 'penjualan';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('account/management');
            }
        }

        public function view_edit_profile()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $data['data_profile'] = $this->Base_model->get_specific('admin_management', array(
                    'id_admin_management', 
                    $this->session->userdata('id_admin')
                ));

                $data['main_view'] = 'edit_profile';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('account/management');
            }
        }

        public function edit_profile()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $old_password = $this->input->post('password_lama');
                $password = $this->input->post('edit_password');
                $retype_password = $this->input->post('edit_retype_password');

                if(
                    $this->account->cek_password($old_password, $this->session->userdata('password')) == FALSE ||
                    $password !== $retype_password
                ){
                    $array = array(
                        'status' => 'failed',
                        'message' => 'password tidak sesuai'
                    );
                    $this->session->set_flashdata($array);
                    $this->view_edit_profile();
                }else
                {
                    $nama = $this->input->post('edit_nama');
                    $username = $this->input->post('edit_username');

                    $where = array(
                        "id_admin_management" => $this->session->userdata('id_admin')
                    );

                    $data = array(
                        'nama' => $nama,
                        'username' => $username
                    );

                    if(strlen($password) !== 0){
                        $hash = $this->account->generate_password($password);
                        $data['password'] = $hash;
                    }

                    $this->Base_model->edit('admin_management', $where, $data);

                    $this->Base_model->ganti_session($data);

                    $array = array(
                        'status' => 'success',
                        'message' => 'Edit profile berhasil'
                    );
                    $this->session->set_flashdata($array);
                    redirect('asisten-manager-gudang/view-edit-profile');
                    
                }
            }else{
                redirect('account/management');
            }
        }

        public function import_excel_barang(){
            
            if ($this->session->userdata('level') == "asisten_manager_gudang") {
                ini_set('max_execution_time', 3000); 

                $config['upload_path'] = './temp/';
                $config['allowed_types'] = 'xlsx|csv|xls';
                $config['max_size']  = '4000';
                
                $this->load->library('upload', $config);
                
                if ( ! $this->upload->do_upload('file_excel')){
                    
                    $array = array(
                        "status" => 'failed',
                        "message" => $this->upload->display_errors(' ', ' ')
                    );
                    $this->session->set_flashdata($array);
                    redirect('asisten-manager-gudang/view-barang');
                }else{
                    $upload = $this->upload->data();
                    $file = './temp/'.$upload['file_name'];
                    
                    //load the excel library
                    $this->load->library('excel');

                    $inputFileType = PHPExcel_IOFactory::identify($file);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objReader->setReadDataOnly(true);
                    $objPHPExcel = $objReader->load($file);
                    $sheet = $objPHPExcel->getActiveSheet();
                    $maxCell = $sheet->getHighestRowAndColumn();
                    $data_from_excel = $sheet->rangeToArray('A1:' . $maxCell['column'] . $maxCell['row'], null, true, false, false);

                    //REMOVE BLANK ROW AND COLUMN
                    foreach ($data_from_excel as $key => $value) {
                        if(!isset($value[0])){
                            unset($data_from_excel[$key]);
                        }else{
                            foreach ($value as $k => $v) {
                                if($k > 12 && !isset($v)){
                                    unset($data_from_excel[$key][$k]);
                                }
                            }
                        }
                    }
                    
                    //MENGHILANGKAN HEADER TABLE
                    array_shift($data_from_excel);

                    $warna = $this->Base_model->get_all('warna');
                    $merek = $this->Base_model->get_all('merek');
                    $barang = [];

                    foreach ($warna as $key => $value) {
                        $array_warna[$value->kode_warna] = $value->nama_warna;
                    }
                    $warna = $array_warna;

                    foreach ($merek as $key => $value) {
                        $array_merek[$value->kode_merek] = $value->nama_merek;
                    }
                    $merek = $array_merek;

                    $status_pengecekan = true;
                    $message = []; //UNTUK REPORT ERROR
                    
                    foreach ($data_from_excel as $key => $value) {
                        $kolom_kode_merek = $data_from_excel[$key][0];
                        $kolom_kode_tipe = $data_from_excel[$key][1];
                        $kolom_kode_warna = $data_from_excel[$key][2];
                        $kolom_ukuran = $data_from_excel[$key][3];

                        //VALIDASI MEREK
                        if(array_key_exists($kolom_kode_merek, $merek) == FALSE){
                            $message[] = "Merek TIDAK VALID Baris ".($key+2)." (".$kolom_kode_merek.")<br>";
                            $status_pengecekan = false;
                        }
                        
                        //VALIDASI WARNA
                        if(array_key_exists($kolom_kode_warna, $warna) == FALSE){
                            $message[] = "Warna TIDAK VALID Baris ".($key+2)." (".$kolom_kode_warna.")<br>";
                            $status_pengecekan = false;
                        }

                        $barang[] = array(
                            "kode_barang" => $kolom_kode_merek.$kolom_kode_tipe.$kolom_kode_warna.$kolom_ukuran,
                            "merek" => (array_key_exists($kolom_kode_merek, $merek)? $merek[$kolom_kode_merek] : ''),
                            "tipe" => $kolom_kode_tipe,
                            "warna" => (array_key_exists($kolom_kode_warna, $warna)? $warna[$kolom_kode_warna] : ''),
                            "ukuran" => $kolom_ukuran
                        );
                    }
                    
                    if($status_pengecekan == true){
                        //LOLOS VALIDASI LALU MELAKUKAN INPUT BARANG
                        foreach ($barang as $k => $v) {
                            $array_model = array(
                                'kode_barang' => $v['kode_barang'],
                                'merek' => $v['merek'],
                                'tipe' => $v['tipe'],
                                'warna' => $v['warna'],
                                'ukuran' => $v['ukuran'],
                                'alarm_stok_minimal' => 10,
                                'stok_tersedia' => 0
                            );

                            $id_barang = $this->Base_model->insert('barang', $array_model);
                            if($id_barang !== FALSE)
                            {   
                                if($this->manajemen_stok->create_specific_stok_barang_to_all_gudang($id_barang) == FALSE)
                                {
                                    $array = array(
                                        'status' => 'failed',
                                        'message' => 'Gagal Input Data (function create_specific_stok_barang_to_all_gudang)'
                                    );
                                    break;
                                }else
                                {
                                    $array = array(
                                        'status' => 'success',
                                        'message' => 'Berhasil import data barang'
                                    );
                                }

                            }else{
                                $array = array(
                                    'status' => 'failed',
                                    'message' => 'Gagal Input Data'
                                );
                            }
                        }
                        $this->session->set_flashdata($array);
                        redirect('asisten-manager-gudang/view-barang');
                    }else{
                        $array_session = array(
                            "status" => 'failed',
                            "message" => implode('<br>', $message)
                        );
                        $this->session->set_flashdata($array_session);
                        redirect('asisten-manager-gudang/view-barang');
                    }
                    
                    unlink('./temp/'.$upload['file_name']);
                }
            }else{
                $this->output->set_status_header('403');
                echo json_encode(array('status' => false, "message" => 'Access Denied'));
            }
        }

    }
    
    /* End of file asisten_manager_gudang.php */
    
?>