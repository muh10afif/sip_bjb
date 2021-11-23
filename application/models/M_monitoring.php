<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_monitoring extends CI_Model {

	public function cari_data($tabel, $where)
	{
		return $this->db->get_where($tabel, $where);
		
	}

	// menampilkan list tr_kelolaan
	public function get_deb_kelolaan($jenis, $reg_employee)
	{
		$this->db->select('k.*, d.*, ko.*, e.*, e.cabang_induk as cabang_ao');
		$this->db->from('tr_kelolaan as k');
		$this->db->join('m_debitur as d', 'd.deal_reff = k.deal_reff', 'inner');
		$this->db->join('m_kolektibilitas as ko', 'ko.id = d.kolektibilitas', 'left');
		$this->db->join('m_employee as e', 'e.reg_employee = k.reg_employee', 'inner');
		$this->db->where('d.jenis_debitur', $jenis);
		$this->db->where('k.reg_employee', $reg_employee);
		$this->db->where('k.stat', 1);

		return $this->db->get();
	}

	public function get_data_monitoring($tgl_skrg, $tanggal_min_3, $jenis)
	{
		$this->db->select('m.*, d.*, k.*, m.add_time as waktu_kunjungan, e.*');
		$this->db->from('tr_monitoring as m');
		$this->db->join('m_debitur as d', 'd.deal_reff = m.deal_reff', 'inner');
		$this->db->join('m_kolektibilitas as k', 'k.id = d.kolektibilitas', 'inner');
		$this->db->join('m_employee as e', 'e.reg_employee = m.reg_employee', 'inner');
		$this->db->where("m.tgl_komitmen BETWEEN '$tgl_skrg' AND '$tanggal_min_3' ");
		$this->db->where('d.jenis_debitur', $jenis);

		return $this->db->get();
	}

	public function get_data_monitoring_2($tgl_skrg, $tanggal_min_3)
	{
		$this->db->from('tr_monitoring as m');
		$this->db->join('m_debitur as d', 'd.deal_reff = m.deal_reff', 'inner');
		$this->db->join('m_kolektibilitas as k', 'k.id = d.kolektibilitas', 'inner');
		$this->db->where("m.tgl_komitmen BETWEEN '$tgl_skrg' AND '$tanggal_min_3' ");
		$this->db->where('m.status', 1);

		return $this->db->get();
	}

	public function get_jml_data_monitoring($tgl_skrg, $tanggal_min_3)
	{
		$this->db->from('tr_monitoring as m');
		$this->db->join('m_debitur as d', 'd.deal_reff = m.deal_reff', 'inner');
		$this->db->where("m.tgl_komitmen BETWEEN '$tgl_skrg' AND '$tanggal_min_3' ");
		$this->db->where('m.status', 1);
		
		return $this->db->get();
	}

	// 140121
	public function get_debitur_kelolaan($jenis, $reg_employee)
	{
		$this->db->select('t.deal_reff');
		$this->db->from('tr_kelolaan as t');
		$this->db->join('m_debitur as d', 'd.deal_reff = t.deal_reff', 'inner');
		$this->db->where('t.reg_employee', $reg_employee);
		$this->db->where('d.jenis_debitur', $jenis);
		$this->db->group_by('t.deal_reff');
		
		return $this->db->get();
	}

	// menampilkan semua data 
	public function get_data_list_monitoring_2($jenis,$deal_reff)
	{
		$this->db->select('m.*, d.*, k.*, m.id as id_tr_m, m.add_time as waktu_kunjungan,e.*, e.cabang_induk as cabang_ao, t.*, e.reg_employee as reg');

		// $this->db->select('d.deal_reff, d.nama, m.komitmen, m.tgl_komitmen, m.nominal, m.id as id_tr_m, e.reg_employee as reg');
		$this->db->from('tr_monitoring as m');
		$this->db->join('m_debitur as d', 'd.deal_reff = m.deal_reff', 'inner');
		$this->db->join('m_kolektibilitas as k', 'k.id = d.kolektibilitas', 'left');
		$this->db->join('m_employee as e', 'e.reg_employee = m.reg_employee', 'inner');
		$this->db->join('ttd as t', 't.id_tr_monitoring = m.id', 'left');
			
		$this->db->where('d.jenis_debitur', $jenis);
		$this->db->where('m.deal_reff', $deal_reff);

		$this->db->order_by('m.add_time', 'desc');

		return $this->db->get();
	}

	// menampilkan semua data 
	public function get_data_list_monitoring($jenis, $reg_employee, $id_tr_m)
	{
		$this->db->select('m.*, d.*, k.*, m.id as id_tr_m, m.add_time as waktu_kunjungan,e.*, e.cabang_induk as cabang_ao, t.*');
		$this->db->from('tr_monitoring as m');
		$this->db->join('m_debitur as d', 'd.deal_reff = m.deal_reff', 'inner');
		$this->db->join('m_kolektibilitas as k', 'k.id = d.kolektibilitas', 'left');
		$this->db->join('m_employee as e', 'e.reg_employee = m.reg_employee', 'inner');
		$this->db->join('ttd as t', 't.id_tr_monitoring = m.id', 'left');
		if (!empty($jenis)) {
			$this->db->where('d.jenis_debitur', $jenis);
		}
		if (!empty($reg_employee)) {
			$this->db->where('m.reg_employee', $reg_employee);
		}
		if (!empty($id_tr_m)) {
			$this->db->where('m.id', $id_tr_m);	
		}
		$this->db->order_by('m.add_time', 'desc');

		return $this->db->get();
	}

	// menampilkan foto monitoring
	public function get_foto_monitoring($id_tr_monitoring)
	{
		$this->db->from('tr_monitoring as m');		
		$this->db->join('picture_monitoring as p', 'p.id_monitoring = m.id', 'inner');
		$this->db->join('m_debitur as d', 'd.deal_reff = m.deal_reff', 'inner');
		$this->db->where('p.id_monitoring', $id_tr_monitoring);

		return $this->db->get();
	}

}

/* End of file M_monitoring.php */
/* Location: ./application/models/M_monitoring.php */