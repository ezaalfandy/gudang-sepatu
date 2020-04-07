<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends MY_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Base_model');
    }
    
    public function _remap($method, $params = array()){
        $controller = mb_strtolower(get_class($this));
        $uri_controller = str_replace('-', '_', mb_strtolower($this->uri->segment(1)));
        if( $uri_controller == $controller){
            show_404();
        }else
        {   
            if(method_exists($this, $method)){
                return call_user_func_array(array($this, $method), $params);
            }else{
                show_404();
            }
        }
    }


}

/* End of file Base.php */

?>