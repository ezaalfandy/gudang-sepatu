<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Account extends MY_Controller {
        
        
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Account_model');
            $this->load->module('base');
        }
        
        public function index()
        {
            if ($this->session->userdata('level') == 'asisten_manager_gudang') {
                redirect('Asisten-manager-gudang');
            }else if ($this->session->userdata('level') == 'sekretariat') {
                redirect('Sekretariat');
            }else if ($this->session->userdata('level') == 'perangkat_pertandingan'){
                redirect('Perangkat_pertandingan');
            }elseif ($this->session->userdata('level') == "bendahara") {
                redirect('Bendahara');
            }elseif ($this->session->userdata('level') == "printer") {
                redirect('Printer');
            }elseif ($this->session->userdata('level') == "admin_check_in") {
                redirect('Admin_check_in');
            }elseif ($this->session->userdata('level') == "announcer_dalam") {
                redirect('Announcer_dalam');
            }else{
                $this->load->view('account/login');
            }
        }

        public function login_management(){
            if ($this->Account_model->login_management() == "asisten_manager_gudang") {
                redirect('Asisten-manager-gudang');
            }else if ($this->Account_model->login_management() == "sekretariat") {
                redirect('Sekretariat');
            }elseif ($this->Account_model->login_management() == "perangkat_pertandingan") {
                redirect('Perangkat_pertandingan');
            }elseif ($this->Account_model->login_management() == "bendahara") {
                redirect('Bendahara');
            }elseif ($this->Account_model->login_management() == "printer") {
                redirect('Printer');
            }else {
                $this->session->set_flashdata('message', 'Username Atau Password Salah !');
                redirect('Account');
            }
        }

        public function logout(){
            $this->session->sess_destroy();
            redirect('Account');
        }

        public function ganti_password(){
            if ($this->session->userdata('level') == "sekretariat" || $this->session->userdata('level') == "super_admin") {
                if ($this->Account_model->ganti_password() == true) {
                    echo json_encode(array('status' => true));
                }else {
                    echo json_encode(array('status' => false));
                }
            }else{
                $this->load->view('Admin/Access_denied');
            }
        }
    
    }
    
    /* End of file Account.php */
    
?>