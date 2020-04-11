<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account_model extends CI_Model {

    public function login_management(){
		$hash = $this->db->select('password')
		  				 ->where('username', $this->input->post('username'))
						 ->get('admin_management')
						 ->result();

		
		$password_on_db = $this->cek_password($this->input->post('password'), $hash);
		if($password_on_db != false){
			$query = $this->db->where('username', $this->input->post('username'))
						  ->where('password',$password_on_db)
						  ->get('admin_management');

			if ($this->db->affected_rows() > 0) {
				$array = array(
					'level' => $query->row('level'),
					'username' => $query->row('username'),
					'nama' => $query->row('nama'),
					'foto' => $query->row('foto'),
					'id_admin' => $query->row('id_admin_management')
				);
				$this->session->set_userdata( $array );
				return $query->row('level');
			}else{
				return false;
			}
		}else{
			return false;
		}
    }

    public function login_admin_gudang(){
		$hash = $this->db->select('password')
		  				 ->where('username', $this->input->post('username'))
						 ->get('admin_gudang')
						 ->result();

		
		$password_on_db = $this->cek_password($this->input->post('password'), $hash);
		if($password_on_db != false){
			$query = $this->db->where('username', $this->input->post('username'))
						  ->where('password',$password_on_db)
						  ->get('admin_gudang');

			if ($this->db->affected_rows() > 0) {
				$array = array(
					'level' => 'admin_gudang',
					'username' => $query->row('username'),
					'nama' => $query->row('nama'),
					'foto' => $query->row('foto'),
					'id_admin' => $query->row('id_admin_gudang'),
					'id_gudang' => $query->row('id_gudang')
				);
				$this->session->set_userdata( $array );
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function buat_password($password){
		$options = [
			'cost' => 10
		];
		return password_hash($password , PASSWORD_BCRYPT, $option);
	}

	public function cek_password($password, $hash){
		foreach($hash as $data){
			if (password_verify($password, $data->password)) {
				return $data->password;
			}
		}
		// Jika tidak ada yang cocok
		return false;
	}

	public function ganti_password(){
		$data = array(
			"password" => password_hash($this->input->post('password') , PASSWORD_BCRYPT, ['cost' => 10])
		);
		$this->db->where('id_admin', $this->session->userdata('id_admin'))
				 ->update('admin', $data);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		}else{
			return false;
		}
		
	}
    

}

/* End of file Account_model.php */

?>