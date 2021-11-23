<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dasbor extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('M_monitoring');

        $array = array(
        	'hitung_deb' => $this->M_monitoring->get_jml_data_monitoring($this->session->userdata('tgl_skrg'), $this->session->userdata('tgl_min_3'))->num_rows(),
        	'data_debb'  => $this->M_monitoring->get_data_monitoring_2($this->session->userdata('tgl_skrg'), $this->session->userdata('tgl_min_3'))->result_array()
        );
        
		$this->session->set_userdata( $array );
		
		$this->load->library('Cek_login_lib');
		$this->cek_login_lib->logged_in();
		
		// if ($this->session->userdata('masuk') != TRUE) {
    	// 	redirect('auth','refresh');
    	// }

    }
	
	// Index login
	public function index() {
		$data = array(	'title'	=> 'Halaman Dashboard',
						'isi'	=> 'dasbor/dasbor_view',
						'menu'	=> 'dasbor'
					);
		$this->load->view('layout/wrapper',$data);
	}

	function fetch(){

		$data = $this->excel_import_model->select();
	
		$output = '
	
		<h3 align="center">Total Data - '.$data->num_rows().'</h3>
	
		<table class="table table-striped table-bordered">
	
		 <tr>
	
		  <th>Name</th>
	
		  <th>Email</th>
	
		 </tr>
	
		';
	
		foreach($data->result() as $row){
	
		  $output .= '
	
		  <tr>
	
		  <td>'.$row->name.'</td>
	
		  <td>'.$row->email.'</td>
	
		  </tr>
	
		  ';
	
		}
	
		$output .= '</table>';
	
		echo $output;
	
	  }
	
	
}