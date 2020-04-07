<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Image_manipulation extends MY_Controller {
        
        
        public function __construct()
        {
            parent::__construct();
        }
        
        public function index()
        {
            
        }

        public function _remap($method, $params = array())
        {
            $controller = mb_strtolower(get_class($this));
            $uri_controller = str_replace('-', '_', mb_strtolower($this->uri->segment(1)));
            if( $uri_controller == $controller){
                show_404();
            }else
            {   
                if(method_exists($this, $method))
                {
                    return call_user_func_array(array($this, $method), $params);
                }else{
                    show_404();
                }
            }
        }

        public function upload($name, $config){
            
            $this->load->library('upload');
            $this->upload->initialize($config);

            if ( ! $this->upload->do_upload($name)){
                return array("status" => false, "message" =>$this->upload->display_errors('',''));
            }
            else{
                return array("status" => true, "data" =>$this->upload->data());
            }
        }
        
        
        public function create_thumbnail($path){
            $this->load->library('image_lib');

            $config['image_library'] = 'GD2';
            $config['source_image'] = $path;
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width']         = 200;
            $config['height']       = 200;

            $this->load->library('image_lib');
            
            $this->image_lib->initialize($config);
            if ( ! $this->image_lib->resize())
            {   
                return array("status" => false, "message" => $this->image_lib->display_errors('',''));
            }else{
                $this->image_lib->clear();
                return array("status" => true);
            }
        }
    }
    
    /* End of file Image_manipulation.php */
    
?>