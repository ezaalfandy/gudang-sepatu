<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class asisten_manager_gudang extends MY_Controller {
        
        public function __construct()
        {
            parent::__construct();            
            $this->load->module('pre_order');
        }
        
        public function index()
        {   
            redirect('asisten-manager-gudang/dashboard');
        }

        public function dashboard(){
            if($this->session->userdata('level') == 'asisten_manager_gudang'){
                $data['main_view'] = 'dashboard';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('Account');
            }
        }

        public function view_gudang(){
            if($this->session->userdata('level') == 'asisten_manager_gudang'){
                $data['data_gudang'] = $this->Base_model->get_all('gudang');
                $data['main_view'] = 'gudang';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('Account');
            }
        }
                      
        public function insert_gudang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {        
                $config = array(
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
                        'id_gudang' => $this->input->post('insert_id_gudang', TRUE),
                        'alamat' => $this->input->post('insert_alamat', TRUE),
                        'kabupaten_kota' => $this->input->post('insert_kabupaten_kota', TRUE),
                        'provinsi' => $this->input->post('insert_provinsi', TRUE),
                        'kode_pos' => $this->input->post('insert_kode_pos', TRUE),
                        'nomor_telepon' => $this->input->post('insert_nomor_telepon', TRUE)
                    );
                        if($this->Base_model->insert('gudang', $array_model) !== false)
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
                        redirect('asisten-manager-gudang/view-gudang');
                }else{
                    $this->view_gudang();
                }
                
            }else
            {
                redirect('Account');
            }
        }
                              
        public function delete_gudang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                if($this->Base_model->delete('gudang', array('id_gudang' => $this->uri->segment(3))) == true)
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
                redirect('asisten-manager-gudang/view-gudang');
            }else
            {
                redirect('Account');
            }
        }
                              
        public function edit_gudang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {        
                $config = array(
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
                        'id_gudang' => $this->input->post('edit_id_gudang', TRUE),
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
                redirect('Account');
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
                redirect('Account');
            }
        }                   

        public function view_aturan_barcode(){
            if($this->session->userdata('level') == 'asisten_manager_gudang'){
                $data['data_barang'] = $this->Base_model->get_all('barang');
                $data['data_merek'] = $this->Base_model->get_all('merek');
                $data['data_warna'] = $this->Base_model->get_all('warna');
                $data['main_view'] = 'aturan_barcode';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('Account');
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
                redirect('Account');
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
                redirect('Account');
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
                redirect('Account');
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
                redirect('Account');
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
                redirect('Account');
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
                redirect('Account');
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
                redirect('Account');
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
                redirect('Account');
            }
        }
                            

        public function view_barang(){
            if($this->session->userdata('level') == 'asisten_manager_gudang'){
                $data['data_barang'] = $this->Base_model->get_all('barang');
                $data['data_merek'] = $this->Base_model->get_all('merek');
                $data['data_warna'] = $this->Base_model->get_all('warna');
                $data['main_view'] = 'barang';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('Account');
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
                                'field' => 'insert_stok_awal',
                                'label' => 'Stok Awal',
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

                    $array_model = array(
                        'id_barang' => $this->input->post('insert_id_barang', TRUE),
                        'kode_barang' => $kode_barang,
                        'merek' => $this->input->post('autocomplete_insert_merek', TRUE),
                        'tipe' => $tipe,
                        'warna' => $this->input->post('autocomplete_insert_warna', TRUE),
                        'ukuran' => $ukuran,
                        'stok_awal' => $this->input->post('insert_stok_awal', TRUE),
                        'stok_tersedia' => $this->input->post('insert_stok_awal', TRUE)
                    );

                        if($this->Base_model->insert('barang', $array_model) !== FALSE)
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
                        redirect('asisten-manager-gudang/view_barang');
                }else{
                    $this->view_barang();
                }
                
            }else
            {
                redirect('Account');
            }
        }
                              
        public function delete_barang()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                if($this->Base_model->delete('barang', array('id_barang' => $this->uri->segment(3)) ) == true)
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
                redirect('asisten-manager-gudang/view-barang');
            }else
            {
                redirect('Account');
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
                        redirect('asisten-manager-gudang/view_barang');
                }else{
                    $this->view_barang();
                }
                
            }else
            {
                redirect('Account');
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
                redirect('Account');
            }
        }
        
        public function view_supplier(){
            if($this->session->userdata('level') == 'asisten_manager_gudang'){
                $data['data_supplier'] = $this->Base_model->get_all('supplier');
                $data['main_view'] = 'supplier';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('Account');
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
                        'nama' => $this->input->post('insert_nama', TRUE),
                        'alamat' => $this->input->post('insert_alamat', TRUE),
                        'telepon' => $this->input->post('insert_telepon', TRUE)
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
                redirect('Account');
            }
        }
                                
        public function delete_supplier()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                if($this->Base_model->delete('supplier', array('id_supplier' => $this->uri->segment(3)) ) == true)
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
                redirect('asisten-manager-gudang/view-supplier');
            }else
            {
                redirect('Account');
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
                        'nama' => $this->input->post('edit_nama', TRUE),
                        'alamat' => $this->input->post('edit_alamat', TRUE),
                        'telepon' => $this->input->post('edit_telepon', TRUE)
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
                redirect('Account');
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
                redirect('Account');
            }
        }
        
        public function view_pre_order(){
            if($this->session->userdata('level') == 'asisten_manager_gudang'){
                $data['data_pre_order'] = $this->Base_model->get_all('pre_order');
                $data['data_gudang'] = $this->Base_model->get_all('gudang');
                $data['data_supplier'] = $this->Base_model->get_all('supplier');
                $data['data_barang'] = $this->Base_model->get_all('barang');
                $data['main_view'] = 'pre_order';
                $this->load->view('template_asisten_manager_gudang', $data, FALSE);
            }else{
                redirect('Account');
            }
        }
                              
        public function insert_pre_order()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {   
                $id_pre_order = $this->pre_order->insert_pre_order();
                if($id_pre_order == true){
                    if($this->pre_order->insert_detail_pre_order($id_pre_order) == true)
                    {
                        redirect('asisten-manager-gudang/view-pre-order');
                    }else{
                        $this->view_pre_order();
                    }
                }else{
                    $this->view_pre_order();
                }
            }else
            {
                redirect('Account');
            }
        }
                              
        public function delete_pre_order()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {
                if($this->Base_model->delete('pre_order', array('id_pre_order' => $this->uri->segment(3)) ) == true)
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
                redirect('asisten-manager-gudang/view-pre_order');
            }else
            {
                redirect('Account');
            }
        }
                              
        public function edit_pre_order()
        {
            if($this->session->userdata('level') == 'asisten_manager_gudang')
            {        
                $config = array(
                            array(
                                'field' => 'edit_id_admin',
                                'label' => ' Id Admin',
                                'rules' => 'required'
                            ),
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
                                'field' => 'edit_kode_pre_order',
                                'label' => ' Kode Pre Order',
                                'rules' => 'required'
                            )
                    );
                
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() == TRUE) 
                {
                    $array_model = array(
                        'id_pre_order' => $this->input->post('edit_id_pre_order', TRUE),
                        'id_admin' => $this->input->post('edit_id_admin', TRUE),
                        'id_supplier' => $this->input->post('edit_id_supplier', TRUE),
                        'id_gudang_tujuan' => $this->input->post('edit_id_gudang_tujuan', TRUE),
                        'kode_pre_order' => $this->input->post('edit_kode_pre_order', TRUE)
                    );
                        $id_pre_order = $this->input->post('edit_id_pre_order', TRUE);
                        if($this->Base_model->edit('pre_order', array("id_pre_order" => $id_pre_order), $array_model) == TRUE)
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
                        redirect('asisten-manager-gudang/view-pre-order');
                }else{
                    $this->view_pre_order();
                }
                
            }else
            {
                redirect('Account');
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
                redirect('Account');
            }
        }
                            
                                               
                            


    }
    
    /* End of file asisten_manager_gudang.php */
    
?>