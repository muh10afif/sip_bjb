<?php
class model_operator extends CI_Model{
    
    function cek_login($table,$where){		
		return $this->db->get_where($table,$where);
	}	

	public function cek_user_login($email)
	{
		$this->db->select('u.reg_employee, sha, level, active, e.kanwil, e.name, e.email as email2, v.auth as auto');
		$this->db->from('m_user as u');
		$this->db->join('m_employee as e', 'e.reg_employee = u.reg_employee', 'left');
		$this->db->join('m_authorization as v', 'v.id = u.level', 'left');
		$this->db->where('u.email', $email);
		
		return $this->db->get();

	}

	// 27-12-2020
	public function cari_data($tabel, $where)
	{
		return $this->db->get_where($tabel, $where);
		
	}
}