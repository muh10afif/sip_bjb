<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	function __construct(){
        parent::__construct();
        $this->load->library('Cek_login_lib');
		$this->cek_login_lib->logged_in();
        $this->load->model(array('model_report','M_monitoring'));

        $array = array(
        	'hitung_deb' => $this->M_monitoring->get_jml_data_monitoring($this->session->userdata('tgl_skrg'), $this->session->userdata('tgl_min_3'))->num_rows(),
        	'data_debb'  => $this->M_monitoring->get_data_monitoring_2($this->session->userdata('tgl_skrg'), $this->session->userdata('tgl_min_3'))->result_array()
        );
        
		$this->session->set_userdata( $array );
		
		ini_set('max_execution_time', 0); 
    }

    public function tes()
    {
    	$a = substr('2019-03-30', 0 , 7);

    	echo $a;
    }

	public function tess()
	{
		// $a = $this->model_report->count_report($segmen="", $kanwil="", $cabang_induk="", $reg_employee="", $kolektibilitas="")->result_array();

		$a = $this->db->get_where('report_npl', ['kanwil' => 'KANWIL 1'])->result_array();
		

		print_r($a);
	}

    public function ambil_data()
	{
		$modul 		= $this->input->post('modul');
		$id 		= $this->input->post('id');
		$kanwil 	= $this->input->post('kanwil');
		$cabang 	= $this->input->post('cabang');
		$id_kanwil 	= $this->input->post('id_kanwil');
		$id_ao 		= $this->input->post('id_ao');

		if ($modul == "cabang") {
			echo $this->model_report->cabang_1($id, $cabang);
		} elseif ($modul == "kanwil") {
			echo $this->model_report->kanwil_1($id, $id_kanwil);
		} elseif ($modul == "ao") {
			echo $this->model_report->ao_1($id,$kanwil, $id_ao);
		}

	}
	
    #################################################################################
	######### 																######### 
	######### 			Laporan : Monitoring Potensi Recoveries  			######### 
	######### 																######### 
	#################################################################################
    public function potensi($jenis = 'npl')
	{
		$j = strtoupper($jenis);

		if (isset($_POST['cari'])) {
			$jenis_deb = $this->input->post('jenis_deb');

			$data = [
			    'isi' 			=> 'report/potensi/potensi',
			    'title'			=> "Report Potensi Recoveries $j",
			    'header'		=> $this->model_report->get_segmen(),
			    'kol'			=> $this->model_report->get_kol(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'p_segmen'		=> $this->input->post('segmen'),
			    'p_kol'			=> $this->input->post('kol'),
			    'p_kanwil'		=> $this->input->post('kanwil'),
			    'p_cabang'		=> $this->input->post('cabang'),
			    'p_ao'			=> $this->input->post('ao'),
			    'p_bulan'		=> $this->input->post('bulan'),
			    'p_debitur'		=> $this->input->post('debitur'),
			    'jenis'			=> $this->input->post('jenis_deb'),
			    'debitur'		=> $this->model_report->get_debitur($jenis_deb),
				'list'			=> $this->model_report->get_list_potensi_recov($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'), $this->input->post('bulan'), $jenis)->result_array(),
			    'aktif'			=> 'report',
			    'menu'			=> 'potensi'
			];

			$this->load->view('layout/wrapper', $data);
		} elseif (isset($_POST['unduh'])) {
			$jns = $this->input->post('jns');

			if ($jns == 'data') {
				$jns_report = $jns;
			} elseif ($jns == 'detail') {
				$jns_report = $jns;
			} else {
				$jns_report = 'data';
			}

			$jenis_deb 	= $this->input->post('jenis_deb');

			$debitur 	= $this->input->post('debitur');
			$segmen 	= $this->input->post('segmen');
		    $kol 		= $this->input->post('kol');
		    $kanwil 	= $this->input->post('kanwil');
		    $cabang 	= $this->input->post('cabang');
		    $ao 		= $this->input->post('ao');
		    $bulan 		= $this->input->post('bulan');

		    $nama_ao	= $this->model_report->get_employee($ao)->row_array();

		    $nama_kol 	= $this->model_report->get_data_kol($kol)->row_array();

			$data = [
			    'header'		=> $this->model_report->get_segmen(),
			    'kol'			=> $this->model_report->get_kol(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'p_segmen'		=> $segmen,
			    'p_kol'			=> $kol,
			    'p_kanwil'		=> $kanwil,
			    'p_cabang'		=> $cabang,
			    'p_ao'			=> $ao,
			    'nama_ao' 		=> $nama_ao['name'],
			    'nama_kol' 		=> $nama_kol['kolektibilitas'],
			    'p_debitur'		=> $debitur,
			    'jenis'			=> $jenis_deb,
			    'jns_report'	=> $jns_report,
			    'p_bulan'		=> $bulan,
			    'debitur'		=> $this->model_report->get_debitur($jenis_deb),
			    'aktif'			=> 'report',
			    'report_detail'	=> $this->model_report->get_data_detail($jenis_deb, $debitur, $segmen, $kanwil, $cabang, $ao, $bulan, $komitmen = null, $monitoring = null, $kol = null, $restruk = null),
				'list'			=> $this->model_report->get_list_potensi_recov($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'), $this->input->post('bulan'), $jenis)->result_array(),
			];

			if ($jns == 'detail') {
				$this->template->load('report/potensi/template_preview','report/potensi/unduh/preview_unduh_detail', $data);
			} else {
				$this->template->load('report/potensi/template_preview','report/potensi/unduh/preview_unduh', $data);
			}

		} elseif (isset($_POST['pdf'])) {
			$jns = $this->input->post('jns');

			if ($jns == 'data') {
				$jns_report = $jns;
			} elseif ($jns == 'detail') {
				$jns_report = $jns;
			} else {
				$jns_report = 'data';
			}

			$jenis_deb = $this->input->post('jenis_deb');

			$debitur 	= $this->input->post('debitur');
			$segmen 	= $this->input->post('segmen');
		    $kol 		= $this->input->post('kol');
		    $kanwil 	= $this->input->post('kanwil');
		    $cabang 	= $this->input->post('cabang');
		    $ao 		= $this->input->post('ao');
		    $bulan 		= $this->input->post('bulan');

		    $nama_ao	= $this->model_report->get_employee($ao)->row_array();

		    $nama_kol 	= $this->model_report->get_data_kol($kol)->row_array();
		    

			$data = [
			    'header'		=> $this->model_report->get_segmen(),
			    'kol'			=> $this->model_report->get_kol(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'p_segmen'		=> $this->input->post('segmen'),
			    'p_kol'			=> $this->input->post('kol'),
			    'p_kanwil'		=> $this->input->post('kanwil'),
			    'p_cabang'		=> $this->input->post('cabang'),
			    'p_ao'			=> $this->input->post('ao'),
			    'nama_ao' 		=> $nama_ao['name'],
			    'nama_kol' 		=> $nama_kol['kolektibilitas'],
			    'jenis'			=> $this->input->post('jenis_deb'),
			    'p_debitur'		=> $debitur,
			    'jns_report'	=> $jns_report,
			    'p_bulan'		=> $this->input->post('bulan'),
			    'debitur'		=> $this->model_report->get_debitur($jenis_deb),
			    'aktif'			=> 'report',
			    'report_detail'	=> $this->model_report->get_data_detail($jenis_deb, $debitur, $segmen, $kanwil, $cabang, $ao, $bulan, $komitmen = null, $monitoring = null, $kol = null, $restruk = null),
				'list'			=> $this->model_report->get_list_potensi_recov($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'), $this->input->post('bulan'), $jenis)->result_array(),
			];

			if ($jns == 'detail') {
				$this->template->load('report/template_pdf','report/potensi/unduh/preview_unduh_detail', $data);
			} else {
				$this->template->load('report/template_pdf','report/potensi/unduh/preview_unduh', $data);
			}

		} elseif (isset($_POST['excel'])) {
			$jns = $this->input->post('jns');

			if ($jns == 'data') {
				$jns_report = $jns;
			} elseif ($jns == 'detail') {
				$jns_report = $jns;
			} else {
				$jns_report = 'data';
			}

			$jenis_deb = $this->input->post('jenis_deb');

			$debitur 	= $this->input->post('debitur');
			$segmen 	= $this->input->post('segmen');
		    $kol 		= $this->input->post('kol');
		    $kanwil 	= $this->input->post('kanwil');
		    $cabang 	= $this->input->post('cabang');
		    $ao 		= $this->input->post('ao');
		    $bulan 		= $this->input->post('bulan');

		    $nama_ao	= $this->model_report->get_employee($ao)->row_array();

		    $nama_kol 	= $this->model_report->get_data_kol($kol)->row_array();
		    

			$data = [
			    'header'		=> $this->model_report->get_segmen(),
			    'kol'			=> $this->model_report->get_kol(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'kanwil_1'		=> $this->model_report->get_kanwil_1()->result_array(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'p_segmen'		=> $this->input->post('segmen'),
			    'p_kol'			=> $this->input->post('kol'),
			    'nama_ao' 		=> $nama_ao['name'],
			    'nama_kol' 		=> $nama_kol['kolektibilitas'],
			    'p_kanwil'		=> $this->input->post('kanwil'),
			    'p_cabang'		=> $this->input->post('cabang'),
			    'p_ao'			=> $this->input->post('ao'),
			    'p_debitur'		=> $debitur,
			    'jenis'			=> $this->input->post('jenis_deb'),
			    'jns_report'	=> $jns_report,
			    'p_bulan'		=> $this->input->post('bulan'),
			    'debitur'		=> $this->model_report->get_debitur($jenis_deb),
			    'aktif'			=> 'report',
			    'report_detail'	=> $this->model_report->get_data_detail($jenis_deb, $debitur, $segmen, $kanwil, $cabang, $ao, $bulan, $komitmen = null, $monitoring = null, $kol = null, $restruk = null),
				'list'			=> $this->model_report->get_list_potensi_recov($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'), $this->input->post('bulan'), $jenis)->result_array(),
			];

			if ($jns == 'detail') {
				$this->template->load('report/template_excel','report/potensi/unduh/preview_unduh_detail', $data);
			} else {
				$this->template->load('report/template_excel','report/potensi/unduh/preview_unduh', $data);
			}

		}else {
			$data = [
			    'isi' 			=> 'report/potensi/potensi',
			    'title'			=> "Report Potensi Recoveries $j",
			    'header'		=> $this->model_report->get_segmen(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'debitur' 		=> $this->model_report->get_debitur($jenis),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'kol'			=> $this->model_report->get_kol(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'p_segmen'		=> '',		
			    'p_cabang'		=> '',		
			    'p_kol'			=> '',		
			    'p_kanwil'		=> '',		
			    'p_ao'			=> '',
			    'p_bulan'		=> '',
			    'p_debitur' 	=> '',
				'list'			=> $this->model_report->get_list_potensi_recov($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'), $this->input->post('bulan'), $jenis)->result_array(),
			    'jenis'			=> $jenis,
			    'aktif'			=> 'report',
			    'menu'			=> 'potensi'
			];

			$this->load->view('layout/wrapper', $data);
		}
	}

	#################################################################################
	######### 																######### 
	######### 					Laporan : Monitoring Komitmen 				######### 
	######### 																######### 
	#################################################################################

	public function monitoring($jenis = 'npl')
	{
		$j = strtoupper($jenis);

		if (isset($_POST['cari'])) {
			$jenis_deb = $this->input->post('jenis_deb');

			$data = [
			    'isi' 			=> 'report/komitmen_debitur/v_monitoring',
			    'title'			=> "Report Monitoring Komitmen Debitur $j",
			    'header'		=> $this->model_report->get_segmen(),
			    'kol'			=> $this->model_report->get_kol(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'd_monitoring'	=> $this->model_report->get_mon_kom('monitoring'),
			    'd_komitmen'	=> $this->model_report->get_mon_kom('komitmen'),
			    'p_segmen'		=> $this->input->post('segmen'),
			    'p_kanwil'		=> $this->input->post('kanwil'),
			    'p_cabang'		=> $this->input->post('cabang'),
			    'p_ao'			=> $this->input->post('ao'),
			    'jenis'			=> $this->input->post('jenis_deb'),
			    'p_debitur'		=> $this->input->post('debitur'),
			    'p_bulan'		=> $this->input->post('bulan'),
			    'p_komitmen'	=> $this->input->post('komitmen'),
			    'p_monitoring'	=> $this->input->post('monitoring'),
			    'debitur'		=> $this->model_report->get_debitur($jenis_deb),
				'list'			=> $this->model_report->get_list_monitoring_komit($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('monitoring'),
				 $this->input->post('segmen'), $this->input->post('bulan'), $this->input->post('komitmen'), $jenis)->result_array(),
			    'aktif'			=> 'report',
			    'menu'			=> 'r_monitoring'
			];

			$this->load->view('layout/wrapper', $data);
		} elseif (isset($_POST['unduh'])) {
			$jns = $this->input->post('jns');

			if ($jns == 'data') {
				$jns_report = $jns;
			} elseif ($jns == 'detail') {
				$jns_report = $jns;
			} else {
				$jns_report = 'data';
			}

			$jenis_deb 	= $this->input->post('jenis_deb');

			$debitur 	= $this->input->post('debitur');
			$segmen 	= $this->input->post('segmen');
		    $komitmen	= $this->input->post('komitmen');
		    $monitoring	= $this->input->post('monitoring');
		    $kanwil 	= $this->input->post('kanwil');
		    $cabang 	= $this->input->post('cabang');
		    $ao 		= $this->input->post('ao');
		    $bulan 		= $this->input->post('bulan');
		    $komitmen 	= $this->input->post('komitmen');
		    $monitoring	= $this->input->post('monitoring');

		    $nama_ao	= $this->model_report->get_employee($ao)->row_array();

			$data = [
			    'header'		=> $this->model_report->get_segmen(),
			    'kol'			=> $this->model_report->get_kol(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'd_monitoring'	=> $this->model_report->get_mon_kom('monitoring'),
			    'd_komitmen'	=> $this->model_report->get_mon_kom('komitmen'),
			    'debitur'		=> $this->model_report->get_debitur($jenis_deb),
			    'jenis'			=> $jenis_deb,
			    'p_segmen'		=> $segmen,
			    'p_kanwil'		=> $kanwil,
			    'p_cabang'		=> $cabang,
			    'p_ao'			=> $ao,
			    'p_debitur'		=> $debitur,
			    'p_bulan'		=> $bulan,
			    'p_monitoring'	=> $monitoring,
			    'p_komitmen'	=> $komitmen,
			    'nama_ao' 		=> $nama_ao['name'],
			    'jns_report'	=> $jns_report,
			    'aktif'			=> 'report',
			    'report_detail'	=> $this->model_report->get_data_detail($jenis_deb, $debitur, $segmen, $kanwil, $cabang, $ao, $bulan, $komitmen, $monitoring,$kol = null, $restruk = null),
				'list'			=> $this->model_report->get_list_monitoring_komit($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('monitoring'),
				 $this->input->post('segmen'), $this->input->post('bulan'), $this->input->post('komitmen'), $jenis)->result_array(),
			];

			if ($jns == 'detail') {
				$this->template->load('report/komitmen_debitur/template_preview','report/komitmen_debitur/unduh/preview_unduh_detail', $data);
			} else {
				$this->template->load('report/komitmen_debitur/template_preview','report/komitmen_debitur/unduh/preview_unduh', $data);
			}

		} elseif (isset($_POST['pdf'])) {
			$jns = $this->input->post('jns');

			if ($jns == 'data') {
				$jns_report = $jns;
			} elseif ($jns == 'detail') {
				$jns_report = $jns;
			} else {
				$jns_report = 'data';
			}

			$jenis_deb = $this->input->post('jenis_deb');

			$debitur 	= $this->input->post('debitur');
			$segmen 	= $this->input->post('segmen');
		    $kol 		= $this->input->post('kol');
		    $kanwil 	= $this->input->post('kanwil');
		    $cabang 	= $this->input->post('cabang');
		    $ao 		= $this->input->post('ao');
		    $bulan 		= $this->input->post('bulan');
		    $komitmen 	= $this->input->post('komitmen');
		    $monitoring	= $this->input->post('monitoring');

		    $nama_ao	= $this->model_report->get_employee($ao)->row_array();
			
			$data = [
			    'header'		=> $this->model_report->get_segmen(),
			    'kol'			=> $this->model_report->get_kol(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'debitur'		=> $this->model_report->get_debitur($jenis_deb),
			    'jenis'			=> $jenis_deb,
			    'p_segmen'		=> $segmen,
			    'p_kanwil'		=> $kanwil,
			    'p_cabang'		=> $cabang,
			    'p_ao'			=> $ao,
			    'p_debitur'		=> $debitur,
			    'p_bulan'		=> $bulan,
			    'p_monitoring'	=> $monitoring,
			    'p_komitmen'	=> $komitmen,
			    'nama_ao' 		=> $nama_ao['name'],
			    'jns_report'	=> $jns_report,
			    'aktif'			=> 'report',
			    'report_detail'	=> $this->model_report->get_data_detail($jenis_deb, $debitur, $segmen, $kanwil, $cabang, $ao, $bulan, $komitmen, $monitoring,$kol = null, $restruk = null),
				'list'			=> $this->model_report->get_list_monitoring_komit($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('monitoring'),
				 $this->input->post('segmen'), $this->input->post('bulan'), $this->input->post('komitmen'), $jenis)->result_array(),
			];

			if ($jns == 'detail') {
				$this->template->load('report/template_pdf','report/komitmen_debitur/unduh/preview_unduh_detail', $data);
			} else {
				$this->template->load('report/template_pdf','report/komitmen_debitur/unduh/preview_unduh', $data);
			}

		} elseif (isset($_POST['excel'])) {
			$jns = $this->input->post('jns');

			if ($jns == 'data') {
				$jns_report = $jns;
			} elseif ($jns == 'detail') {
				$jns_report = $jns;
			} else {
				$jns_report = 'data';
			}

			$jenis_deb = $this->input->post('jenis_deb');

			$debitur 	= $this->input->post('debitur');
			$segmen 	= $this->input->post('segmen');
		    $kanwil 	= $this->input->post('kanwil');
		    $cabang 	= $this->input->post('cabang');
		    $ao 		= $this->input->post('ao');
		    $bulan 		= $this->input->post('bulan');
		    $komitmen 	= $this->input->post('komitmen');
		    $monitoring	= $this->input->post('monitoring');

		    $nama_ao	= $this->model_report->get_employee($ao)->row_array();

			$data = [
			    'header'		=> $this->model_report->get_segmen(),
			    'kol'			=> $this->model_report->get_kol(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'debitur'		=> $this->model_report->get_debitur($jenis_deb),
			    'jenis'			=> $jenis_deb,
			    'p_segmen'		=> $segmen,
			    'p_kanwil'		=> $kanwil,
			    'p_cabang'		=> $cabang,
			    'p_ao'			=> $ao,
			    'p_debitur'		=> $debitur,
			    'p_bulan'		=> $bulan,
			    'p_monitoring'	=> $monitoring,
			    'p_komitmen'	=> $komitmen,
			    'nama_ao' 		=> $nama_ao['name'],
			    'jns_report'	=> $jns_report,
			    'aktif'			=> 'report',
			    'report_detail'	=> $this->model_report->get_data_detail($jenis_deb, $debitur, $segmen, $kanwil, $cabang, $ao, $bulan, $komitmen, $monitoring,$kol = null, $restruk = null),
				'list'			=> $this->model_report->get_list_monitoring_komit($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('monitoring'),
				 $this->input->post('segmen'), $this->input->post('bulan'), $this->input->post('komitmen'), $jenis)->result_array(),
			];

			if ($jns == 'detail') {
				$this->template->load('report/template_excel','report/komitmen_debitur/unduh/preview_unduh_detail', $data);
			} else {
				$this->template->load('report/template_excel','report/komitmen_debitur/unduh/preview_unduh', $data);
			}

		}else {
			$data = [
			    'isi' 			=> 'report/komitmen_debitur/v_monitoring',
			    'title'			=> "Report Monitoring Komitmen Debitur $j",
			    'header'		=> $this->model_report->get_segmen(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'kol'			=> $this->model_report->get_kol(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'd_monitoring'	=> $this->model_report->get_mon_kom('monitoring'),
			    'd_komitmen'	=> $this->model_report->get_mon_kom('komitmen'),
			    'p_segmen'		=> '',		
			    'p_cabang'		=> '',		
			    'p_kol'			=> '',		
			    'p_kanwil'		=> '',		
			    'p_ao'			=> '',
			    'p_debitur'		=> '',
			    'p_bulan'		=> '',
			    'p_monitoring'	=> '',
			    'p_komitmen'	=> '',
			    'jenis'			=> $jenis,
			    'debitur'		=> $this->model_report->get_debitur($jenis),
				'list'			=> $this->model_report->get_list_monitoring_komit($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('monitoring'),
				 $this->input->post('segmen'), $this->input->post('bulan'), $this->input->post('komitmen'), $jenis)->result_array(),
			    'aktif'			=> 'report',
			    'menu'			=> 'r_monitoring'
			];

			$this->load->view('layout/wrapper', $data);
		}
	}

	#################################################################################
	######### 																######### 
	######### 			Laporan : Monitoring Kelolaan NPL AO PPK 			######### 
	######### 																######### 
	#################################################################################

	public function kelelolaan_npl_ao()
	{
		if (isset($_POST['cari'])) {
			$data = [
			    'isi' 			=> 'report/npl_ao/v_npl_ao',
			    'title'			=> "Report Monitoring Kelolaan NPL AO PPK",
			    'header'		=> $this->model_report->get_segmen(),
			    'kol'			=> $this->model_report->get_kol(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'kanwil_1'		=> $this->model_report->get_kanwil_1()->result_array(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'p_segmen'		=> $this->input->post('segmen'),
			    'p_kol'			=> $this->input->post('kol'),
			    'p_kanwil'		=> $this->input->post('kanwil'),
			    'p_cabang'		=> $this->input->post('cabang'),
			    'p_ao'			=> $this->input->post('ao'),
				'list'			=> $this->model_report->get_list_kelolaan($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'), $this->input->post('kol'), 'npl')->result_array(),
			    'aktif'			=> 'report',
			    'menu'			=> 'r_kelolaan_npl'
			];

			$this->load->view('layout/wrapper', $data);
		} elseif (isset($_POST['unduh'])) {
			$jns = $this->input->post('jns');

			if ($jns == 'data') {
				$jns_report = $jns;
			} elseif ($jns == 'detail') {
				$jns_report = $jns;
			} else {
				$jns_report = 'data';
			}

			$segmen 	= $this->input->post('segmen');
		    $kol 		= $this->input->post('kol');
		    $kanwil 	= $this->input->post('kanwil');
		    $cabang 	= $this->input->post('cabang');
		    $ao 		= $this->input->post('ao');
		    $jenis_deb 	= 'npl';

		    $nama_ao	= $this->model_report->get_employee($ao)->row_array();

		    $nama_kol 	= $this->model_report->get_data_kol($kol)->row_array();

			$data = [
			    'header'		=> $this->model_report->get_segmen(),
			    'kol'			=> $this->model_report->get_kol(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'jenis'			=> 'npl',
			    'p_segmen'		=> $segmen,
			    'p_kanwil'		=> $kanwil,
			    'p_cabang'		=> $cabang,
			    'p_ao'			=> $ao,
			    'p_kol' 		=> $kol,
			    'nama_ao' 		=> $nama_ao['name'],
			    'nama_kol' 		=> $nama_kol['kolektibilitas'],
			    'jns_report'	=> $jns_report,
			    'aktif'			=> 'report',
			    'report_detail'	=> $this->model_report->get_data_detail_rwo($jenis_deb, $debitur = null, $segmen, $kanwil, $cabang, $ao, $bulan = null, $komitmen = null, $monitoring = null, $kol, $restruk = null),
				'list'			=> $this->model_report->get_list_kelolaan($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'), $this->input->post('kol'), 'npl')->result_array()
			];

			if ($jns == 'detail') {
				$this->template->load('report/npl_ao/template_preview','report/npl_ao/unduh/preview_unduh_detail', $data);
			} else {
				$this->template->load('report/npl_ao/template_preview','report/npl_ao/unduh/preview_unduh', $data);
			}

		} elseif (isset($_POST['pdf'])) {
			$jns = $this->input->post('jns');

			if ($jns == 'data') {
				$jns_report = $jns;
			} elseif ($jns == 'detail') {
				$jns_report = $jns;
			} else {
				$jns_report = 'data';
			}

			$segmen 	= $this->input->post('segmen');
		    $kol 		= $this->input->post('kol');
		    $kanwil 	= $this->input->post('kanwil');
		    $cabang 	= $this->input->post('cabang');
		    $ao 		= $this->input->post('ao');
			$jenis_deb 	= 'npl';

		    $nama_ao	= $this->model_report->get_employee($ao)->row_array();

		    $nama_kol 	= $this->model_report->get_data_kol($kol)->row_array();

			$data = [
			    'header'		=> $this->model_report->get_segmen(),
			    'kol'			=> $this->model_report->get_kol(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'p_segmen'		=> $segmen,
			    'p_kanwil'		=> $kanwil,
			    'p_cabang'		=> $cabang,
			    'p_ao'			=> $ao,
			    'p_kol' 		=> $kol,
			    'nama_ao' 		=> $nama_ao['name'],
			    'nama_kol' 		=> $nama_kol['kolektibilitas'],
			    'jns_report'	=> $jns_report,
			    'aktif'			=> 'report',
			    'report_detail'	=> $this->model_report->get_data_detail_rwo($jenis_deb, $debitur = null, $segmen, $kanwil, $cabang, $ao, $bulan = null, $komitmen = null, $monitoring = null, $kol, $restruk = null),
				'list'			=> $this->model_report->get_list_kelolaan($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'), $this->input->post('kol'), 'npl')->result_array()
			];

			if ($jns == 'detail') {
				$this->template->load('report/template_pdf','report/npl_ao/unduh/preview_unduh_detail', $data);
			} else {
				$this->template->load('report/template_pdf','report/npl_ao/unduh/preview_unduh', $data);
			}

		} elseif (isset($_POST['excel'])) {
			$jns = $this->input->post('jns');

			if ($jns == 'data') {
				$jns_report = $jns;
			} elseif ($jns == 'detail') {
				$jns_report = $jns;
			} else {
				$jns_report = 'data';
			}

			$segmen 	= $this->input->post('segmen');
		    $kol 		= $this->input->post('kol');
		    $kanwil 	= $this->input->post('kanwil');
		    $cabang 	= $this->input->post('cabang');
		    $ao 		= $this->input->post('ao');
			$jenis_deb 	= 'npl';

		    $nama_ao	= $this->model_report->get_employee($ao)->row_array();

		    $nama_kol 	= $this->model_report->get_data_kol($kol)->row_array();

			$data = [
			    'header'		=> $this->model_report->get_segmen(),
			    'kol'			=> $this->model_report->get_kol(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'p_segmen'		=> $segmen,
			    'p_kanwil'		=> $kanwil,
			    'p_cabang'		=> $cabang,
			    'p_ao'			=> $ao,
			    'p_kol' 		=> $kol,
			    'nama_ao' 		=> $nama_ao['name'],
			    'nama_kol' 		=> $nama_kol['kolektibilitas'],
			    'jns_report'	=> $jns_report,
			    'aktif'			=> 'report',
			    'report_detail'	=> $this->model_report->get_data_detail_rwo($jenis_deb, $debitur = null, $segmen, $kanwil, $cabang, $ao, $bulan = null, $komitmen = null, $monitoring = null, $kol, $restruk = null),
				'list'			=> $this->model_report->get_list_kelolaan($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'), $this->input->post('kol'), 'npl')->result_array()
			];

			if ($jns == 'detail') {
				$this->template->load('report/template_excel','report/npl_ao/unduh/preview_unduh_detail', $data);
			} else {
				$this->template->load('report/template_excel','report/npl_ao/unduh/preview_unduh', $data);
			}
			
		}else {
			$data = [
			    'isi' 			=> 'report/npl_ao/v_npl_ao',
			    'title'			=> "Report Monitoring Kelolaan NPL AO PPK",
			    'header'		=> $this->model_report->get_segmen(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'kanwil_1'		=> $this->model_report->get_kanwil_1()->result_array(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'kol'			=> $this->model_report->get_kol(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'p_segmen'		=> '',		
			    'p_cabang'		=> '',		
			    'p_kol'			=> '',		
			    'p_kanwil'		=> '',		
			    'p_ao'			=> '',
				'list'			=> $this->model_report->get_list_kelolaan($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'), $this->input->post('kol'), 'npl')->result_array(),
			    'aktif'			=> 'report',
			    'menu'			=> 'r_kelolaan_npl'		
			];

			$this->load->view('layout/wrapper', $data);
		}

	}

	#################################################################################
	######### 																######### 
	######### 			Laporan : Monitoring Kelolaan WO AO PPK 			######### 
	######### 																######### 
	#################################################################################

	public function kelelolaan_wo_ao()
	{
		if (isset($_POST['cari'])) {
			$data = [
			    'isi' 			=> 'report/wo_ao/v_wo_ao',
			    'title'			=> "Report Monitoring Kelolaan WO AO PPK",
			    'header'		=> $this->model_report->get_segmen(),
			    'kol'			=> $this->model_report->get_kol_wo(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'kanwil_1'		=> $this->model_report->get_kanwil_1()->result_array(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'p_segmen'		=> $this->input->post('segmen'),
			    'p_kol'			=> $this->input->post('kol'),
			    'p_kanwil'		=> $this->input->post('kanwil'),
			    'p_cabang'		=> $this->input->post('cabang'),
			    'p_ao'			=> $this->input->post('ao'),
				'list'			=> $this->model_report->get_list_kelolaan($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'), $this->input->post('kol'), 'wo')->result_array(),
			    'aktif'			=> 'report',
			    'menu'			=> 'r_kelolaan_wo'
			];

			$this->load->view('layout/wrapper', $data);
		} elseif (isset($_POST['unduh'])) {
			$jns = $this->input->post('jns');

			if ($jns == 'data') {
				$jns_report = $jns;
			} elseif ($jns == 'detail') {
				$jns_report = $jns;
			} else {
				$jns_report = 'data';
			}

			$segmen 	= $this->input->post('segmen');
		    $kol 		= $this->input->post('kol');
		    $kanwil 	= $this->input->post('kanwil');
		    $cabang 	= $this->input->post('cabang');
		    $ao 		= $this->input->post('ao');
		    $jenis_deb 	= 'wo';

		    $nama_ao	= $this->model_report->get_employee($ao)->row_array();

		    $nama_kol 	= $this->model_report->get_data_kol($kol)->row_array();

			$data = [
			    'header'		=> $this->model_report->get_segmen(),
			    'kol'			=> $this->model_report->get_kol_wo(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'jenis'			=> 'wo',
			    'p_segmen'		=> $segmen,
			    'p_kanwil'		=> $kanwil,
			    'p_cabang'		=> $cabang,
			    'p_ao'			=> $ao,
			    'p_kol' 		=> $kol,
			    'nama_ao' 		=> $nama_ao['name'],
			    'nama_kol' 		=> $nama_kol['kolektibilitas'],
			    'jns_report'	=> $jns_report,
			    'aktif'			=> 'report',
			    'report_detail'	=> $this->model_report->get_data_detail_rwo($jenis_deb, $debitur = null, $segmen, $kanwil, $cabang, $ao, $bulan = null, $komitmen = null, $monitoring = null, $kol, $restruk = null),
				'list'			=> $this->model_report->get_list_kelolaan($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'), $this->input->post('kol'), 'wo')->result_array(),
			];

			if ($jns == 'detail') {
				$this->template->load('report/wo_ao/template_preview','report/wo_ao/unduh/preview_unduh_detail', $data);
			} else {
				$this->template->load('report/wo_ao/template_preview','report/wo_ao/unduh/preview_unduh', $data);
			}

		} elseif (isset($_POST['pdf'])) {
			$jns = $this->input->post('jns');

			if ($jns == 'data') {
				$jns_report = $jns;
			} elseif ($jns == 'detail') {
				$jns_report = $jns;
			} else {
				$jns_report = 'data';
			}

			$segmen 	= $this->input->post('segmen');
		    $kol 		= $this->input->post('kol');
		    $kanwil 	= $this->input->post('kanwil');
		    $cabang 	= $this->input->post('cabang');
		    $ao 		= $this->input->post('ao');
			$jenis_deb 	= 'wo';

		    $nama_ao	= $this->model_report->get_employee($ao)->row_array();

		    $nama_kol 	= $this->model_report->get_data_kol($kol)->row_array();

			$data = [
			    'header'		=> $this->model_report->get_segmen(),
			    'kol'			=> $this->model_report->get_kol_wo(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'p_segmen'		=> $segmen,
			    'p_kanwil'		=> $kanwil,
			    'p_cabang'		=> $cabang,
			    'p_ao'			=> $ao,
			    'p_kol' 		=> $kol,
			    'nama_ao' 		=> $nama_ao['name'],
			    'nama_kol' 		=> $nama_kol['kolektibilitas'],
			    'jns_report'	=> $jns_report,
			    'aktif'			=> 'report',
			    'report_detail'	=> $this->model_report->get_data_detail_rwo($jenis_deb, $debitur = null, $segmen, $kanwil, $cabang, $ao, $bulan = null, $komitmen = null, $monitoring = null, $kol, $restruk = null),
				'list'			=> $this->model_report->get_list_kelolaan($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'), $this->input->post('kol'), 'wo')->result_array(),
			];

			if ($jns == 'detail') {
				$this->template->load('report/template_pdf','report/wo_ao/unduh/preview_unduh_detail', $data);
			} else {
				$this->template->load('report/template_pdf','report/wo_ao/unduh/preview_unduh', $data);
			}

		} elseif (isset($_POST['excel'])) {
			$jns = $this->input->post('jns');

			if ($jns == 'data') {
				$jns_report = $jns;
			} elseif ($jns == 'detail') {
				$jns_report = $jns;
			} else {
				$jns_report = 'data';
			}

			$segmen 	= $this->input->post('segmen');
		    $kol 		= $this->input->post('kol');
		    $kanwil 	= $this->input->post('kanwil');
		    $cabang 	= $this->input->post('cabang');
		    $ao 		= $this->input->post('ao');
			$jenis_deb 	= 'wo';

		    $nama_ao	= $this->model_report->get_employee($ao)->row_array();

		    $nama_kol 	= $this->model_report->get_data_kol($kol)->row_array();

			$data = [
			    'header'		=> $this->model_report->get_segmen(),
			    'kol'			=> $this->model_report->get_kol_wo(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'p_segmen'		=> $segmen,
			    'p_kanwil'		=> $kanwil,
			    'p_cabang'		=> $cabang,
			    'p_ao'			=> $ao,
			    'p_kol' 		=> $kol,
			    'nama_ao' 		=> $nama_ao['name'],
			    'nama_kol' 		=> $nama_kol['kolektibilitas'],
			    'jns_report'	=> $jns_report,
			    'aktif'			=> 'report',
			    'report_detail'	=> $this->model_report->get_data_detail_rwo($jenis_deb, $debitur = null, $segmen, $kanwil, $cabang, $ao, $bulan = null, $komitmen = null, $monitoring = null, $kol, $restruk = null),
				'list'			=> $this->model_report->get_list_kelolaan($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'), $this->input->post('kol'), 'wo')->result_array(),
			];

			if ($jns == 'detail') {
				$this->template->load('report/template_excel','report/wo_ao/unduh/preview_unduh_detail', $data);
			} else {
				$this->template->load('report/template_excel','report/wo_ao/unduh/preview_unduh', $data);
			}
			
		}else {
			$data = [
			    'isi' 			=> 'report/wo_ao/v_wo_ao',
			    'title'			=> "Report Monitoring Kelolaan WO AO PPK",
			    'header'		=> $this->model_report->get_segmen(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'kanwil_1'		=> $this->model_report->get_kanwil_1()->result_array(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'kol'			=> $this->model_report->get_kol_wo(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'p_segmen'		=> '',		
			    'p_cabang'		=> '',		
			    'p_kol'			=> '',		
			    'p_kanwil'		=> '',		
			    'p_ao'			=> '',
				'list'			=> $this->model_report->get_list_kelolaan($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'), $this->input->post('kol'), 'wo')->result_array(),
			    'aktif'			=> 'report',
			    'menu'			=> 'r_kelolaan_wo'		
			];

			$this->load->view('layout/wrapper', $data);
		}
	}

	#################################################################################
	######### 																######### 
	######### 			Laporan : Monitoring Potensi Restrukturisasi		######### 
	######### 																######### 
	#################################################################################

	public function potensi_restruk()
	{
		if (isset($_POST['cari'])) {
			$data = [
			    'isi' 			=> 'report/restruk/v_restruk',
			    'title'			=> "Report Monitoring Potensi Restrukturisasi",
			    'header'		=> $this->model_report->get_segmen(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'kanwil_1'		=> $this->model_report->get_kanwil_1()->result_array(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'p_segmen'		=> $this->input->post('segmen'),
			    'p_kanwil'		=> $this->input->post('kanwil'),
			    'p_cabang'		=> $this->input->post('cabang'),
			    'p_ao'			=> $this->input->post('ao'),
				'list'			=> $this->model_report->get_list_potensi_restruk($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'))->result_array(),
			    'aktif'			=> 'report',
			    'menu'			=> 'restruk'
			];

			$this->load->view('layout/wrapper', $data);
		} elseif (isset($_POST['unduh'])) {
			$jns = $this->input->post('jns');

			if ($jns == 'data') {
				$jns_report = $jns;
			} elseif ($jns == 'detail') {
				$jns_report = $jns;
			} else {
				$jns_report = 'data';
			}

			$segmen 	= $this->input->post('segmen');
		    $kanwil 	= $this->input->post('kanwil');
		    $cabang 	= $this->input->post('cabang');
		    $ao 		= $this->input->post('ao');
		    $jenis_deb 	= 'npl';
		    $restruk 	= 1;

		    $nama_ao	= $this->model_report->get_employee($ao)->row_array();

			$data = [
			    'header'		=> $this->model_report->get_segmen(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'jenis'			=> 'npl',
			    'p_segmen'		=> $segmen,
			    'p_kanwil'		=> $kanwil,
			    'p_cabang'		=> $cabang,
			    'p_ao'			=> $ao,
			    'nama_ao' 		=> $nama_ao['name'],
			    'jns_report'	=> $jns_report,
			    'aktif'			=> 'report',
			    'report_detail'	=> $this->model_report->get_data_detail($jenis_deb, $debitur = null, $segmen, $kanwil, $cabang, $ao, $bulan = null, $komitmen = null, $monitoring = null, $kol = null, $restruk),
				'list'			=> $this->model_report->get_list_potensi_restruk($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'))->result_array()
			];

			if ($jns == 'detail') {
				$this->template->load('report/restruk/template_preview','report/restruk/unduh/preview_unduh_detail', $data);
			} else {
				$this->template->load('report/restruk/template_preview','report/restruk/unduh/preview_unduh', $data);
			}

		} elseif (isset($_POST['pdf'])) {
			$jns = $this->input->post('jns');

			if ($jns == 'data') {
				$jns_report = $jns;
			} elseif ($jns == 'detail') {
				$jns_report = $jns;
			} else {
				$jns_report = 'data';
			}

			$segmen 	= $this->input->post('segmen');
		    $kanwil 	= $this->input->post('kanwil');
		    $cabang 	= $this->input->post('cabang');
		    $ao 		= $this->input->post('ao');
			$jenis_deb 	= 'npl';
			$restruk 	= 1;

		    $nama_ao	= $this->model_report->get_employee($ao)->row_array();

			$data = [
			    'header'		=> $this->model_report->get_segmen(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'p_segmen'		=> $segmen,
			    'p_kanwil'		=> $kanwil,
			    'p_cabang'		=> $cabang,
			    'p_ao'			=> $ao,
			    'nama_ao' 		=> $nama_ao['name'],
			    'jns_report'	=> $jns_report,
			    'aktif'			=> 'report',
			    'report_detail'	=> $this->model_report->get_data_detail($jenis_deb, $debitur = null, $segmen, $kanwil, $cabang, $ao, $bulan = null, $komitmen = null, $monitoring = null, $kol = null, $restruk),
				'list'			=> $this->model_report->get_list_potensi_restruk($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'))->result_array()
			];

			if ($jns == 'detail') {
				$this->template->load('report/template_pdf','report/restruk/unduh/preview_unduh_detail', $data);
			} else {
				$this->template->load('report/template_pdf','report/restruk/unduh/preview_unduh', $data);
			}

		} elseif (isset($_POST['excel'])) {
			$jns = $this->input->post('jns');

			if ($jns == 'data') {
				$jns_report = $jns;
			} elseif ($jns == 'detail') {
				$jns_report = $jns;
			} else {
				$jns_report = 'data';
			}

			$segmen 	= $this->input->post('segmen');
		    $kanwil 	= $this->input->post('kanwil');
		    $cabang 	= $this->input->post('cabang');
		    $ao 		= $this->input->post('ao');
			$kol 		= $this->input->post('kol');
			$jenis_deb 	= 'npl';
			$restruk 	= 1;

		    $nama_ao	= $this->model_report->get_employee($ao)->row_array();

		    $nama_kol 	= $this->model_report->get_data_kol($kol)->row_array();

			$data = [
			    'header'		=> $this->model_report->get_segmen(),
			    'kol'			=> $this->model_report->get_kol(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'p_segmen'		=> $segmen,
			    'p_kanwil'		=> $kanwil,
			    'p_cabang'		=> $cabang,
			    'p_ao'			=> $ao,
			    'nama_ao' 		=> $nama_ao['name'],
			    'nama_kol' 		=> $nama_kol['kolektibilitas'],
			    'jns_report'	=> $jns_report,
			    'aktif'			=> 'report',
			    'report_detail'	=> $this->model_report->get_data_detail($jenis_deb, $debitur = null, $segmen, $kanwil, $cabang, $ao, $bulan = null, $komitmen = null, $monitoring = null, $kol = null, $restruk),
				'list'			=> $this->model_report->get_list_potensi_restruk($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'))->result_array()
			];

			if ($jns == 'detail') {
				$this->template->load('report/template_excel','report/restruk/unduh/preview_unduh_detail', $data);
			} else {
				$this->template->load('report/template_excel','report/restruk/unduh/preview_unduh', $data);
			}
			
		}else {
			$data = [
			    'isi' 			=> 'report/restruk/v_restruk',
			    'title'			=> "Report Monitoring Potensi Restrukturisasi",
			    'header'		=> $this->model_report->get_segmen(),
			    'kanwil'		=> $this->model_report->get_kanwil(),
			    'kanwil_1'		=> $this->model_report->get_kanwil_1()->result_array(),
			    'result_segmen' => $this->model_report->get_segmen()->result_array(),	
			    'result_kanwil' => $this->model_report->get_kanwil()->result_array(),
			    'd_cabang'		=> $this->model_report->get_cabang(),
			    'd_ao'			=> $this->model_report->get_ao(),
			    'p_segmen'		=> '',		
			    'p_cabang'		=> '',	
			    'p_kanwil'		=> '',		
			    'p_ao'			=> '',
				'list'			=> $this->model_report->get_list_potensi_restruk($this->input->post('ao'), $this->input->post('cabang'), $this->input->post('kanwil'), $this->input->post('segmen'))->result_array(),
			    'aktif'			=> 'report',
			    'menu'			=> 'restruk'		
			];

			$this->load->view('layout/wrapper', $data);
		}
	}

}