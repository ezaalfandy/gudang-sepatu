<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Errors extends MY_Controller {
    
        public function index()
        {
            
        }

        public function page_missing()
        {
            $this->load->view('errors/404');
        }
    
    }
    
    /* End of file Errors.php */
    
?>