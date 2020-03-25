<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_controller extends MX_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->module('base');
    }
}

/* End of file MY_controller.php */

?>