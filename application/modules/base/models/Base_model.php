<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Base_model extends CI_Model {
    
        public function get_all($table, $limit = 0, $offset = 0)
        {
            return $this->db->get($table, $limit, $offset)->result();
        }

        public function get_all_or_like($table, $like, $limit = 0, $offset = 0)
        {
            return $this->db->or_like($like)->get($table, $limit, $offset)->result();
        }

        public function get_all_specific($table, $where, $order_by = null ,$limit = 0, $offset = 0)
        {
            return $this->db->where($where)->order_by($order_by)->get($table, $limit, $offset)->result();
        }
        
        public function insert($table, $array)
        {
            $this->db->insert($table, $array);
            
            if($this->db->affected_rows() > 0)
            {
                return $this->db->insert_id();
            }else
            {
                return false;
            }
        }

        public function get_specific($table, $where)
        {
            return $this->db->where($where)->get($table)->row();
        }

        public function edit($table, $where, $data)
        {
            $this->db->where($where)->update($table, $data);
            if($this->db->affected_rows() > 0)
            { 
                return true;
            }else
            {
                return false;
            }
        }

        public function delete($table, $where)
        {
            $this->db->where($where)->delete($table);
            
            if($this->db->affected_rows() > 0)
            {
                return true;
            }else
            {
                return false;
            }
        }

        public function get_last_primary_key($table, $primary_key)
        {
            $last_row = $this->db->order_by($primary_key, 'DESC')
                                        ->get($table)
                                        ->row();
            if($last_row == null)
            {
                return 0;
            }else
            {
                return $last_row->$primary_key;
            }   
        }

        public function count_all($table)
        {
            return $this->db->count_all($table);
        }

    }
    
    /* End of file Base_model.php */
    
?>