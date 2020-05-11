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
                redirect('asisten-manager-gudang');
            }else{
                $this->load->view('account/login_admin');
            }
        }

        public function management(){
            if ($this->session->userdata('level') == 'asisten_manager_gudang') {
                redirect('asisten-manager-gudang');
            }else{
                $this->load->view('account/login_management');
            }
        }

        public function login_management(){
            if ($this->Account_model->login_management() == "asisten_manager_gudang") {
                redirect('asisten-manager-gudang');
            }else {
                $this->session->set_flashdata('message', 'Username Atau Password Salah !');
                $this->load->view('account/login_management');
            }
        }

        public function login_admin_gudang(){
            if ($this->Account_model->login_admin_gudang() == true) {
                redirect('admin-gudang');
            }else {
                $this->session->set_flashdata('message', 'Username Atau Password Salah !');
                $this->load->view('account/login_admin');
            }
        }

        public function logout(){
            $this->session->sess_destroy();
            redirect('account');
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

        public function cek_password($password_to_check, $password_available){
            if (password_verify($password_to_check, $password_available) == TRUE) 
            {
                return true;
            }else
            {
                return false;
            }
        }
        
        public function generate_password($password){
            if ($this->session->userdata('id_admin') !== NULL) {
                return password_hash($password , PASSWORD_BCRYPT, ['cost' => 10]);
            }else{
                $this->load->view('Admin/Access_denied');
            }
        }
    
    }
    
    /* End of file Account.php */
    
?>