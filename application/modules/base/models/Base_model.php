<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Base_model extends CI_Model {
    
        public function get_all($table, $limit = 0, $offset = 0)
        {
            return $this->db->get($table, $limit, $offset)->result();
        }
        
        public function insert($table, $array){
            $this->db->insert($table, $array);
            
            if($this->db->affected_rows() > 0)
            {
                return $this->db->insert_id();
            }else
            {
                return false;
            }
        }

        public function get_specific($table, $where){
            return $this->db->where($where)->get($table)->row();
        }

        public function edit($table, $where, $data){
            $this->db->where($where)->update($table, $data);
            if($this->db->affected_rows() > 0)
            { 
                return true;
            }else
            {
                return false;
            }
        }

        public function delete($table, $where){
            $this->db->where($where)->delete($table);
            
            if($this->db->affected_rows() > 0)
            {
                return true;
            }else
            {
                return false;
            }
        }
    }
    
    /* End of file Base_model.php */
    
?>