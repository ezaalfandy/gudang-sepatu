<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends MY_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Base_model');
    }
    
    public function index()
    {
        
    }

}

/* End of file Base.php */

?>