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
            if($this->db->where($where)->delete($table) == true)
            {
                return true;
            }else{
                return $this->db->error();
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

        public function ganti_session($session){
            $this->session->set_userdata( $session );
            return true;
        }

        public function get_ajax_lookup_barang($keyword, $group_by = NULL)
        {
            $like = array(
                "kode_barang" => $keyword
            );

            if($group_by == NULL)
            {
                $data =  $this->db->or_like($like)->get('barang', 10, 0)->result();
            }else
            {
                $data =  $this->db->or_like($like)->group_by($group_by)->get('barang', 10, 0)->result();
            }
            
            $return_array = array();


            if($data !== NULL)
            {
                if($group_by == NULL)
                {
                    foreach ($data as $key => $value) {
                        $temp = array(
                            "value" => $value->merek.'  '.$value->tipe.'  '.$value->warna.'  '.$value->ukuran.' ('.$value->kode_barang.')',
                            "data" => $value->id_barang
                        );
                        $return_array[] = $temp;
                    }
                }else
                {
                    foreach ($data as $key => $value) {
                        $temp = array(
                            "value" => $value->merek.' '.$value->tipe.' '.$value->warna,
                            "data" => $value->merek.'-'.$value->tipe.'-'.$value->warna
                        );
                        $return_array[] = $temp;
                    }
                }

                return array(
                    "suggestions" => $return_array
                );
            }else{
                return NULL;
            }

        }

    }
    
    /* End of file Base_model.php */
    
?>