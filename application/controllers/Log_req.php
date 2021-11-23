<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_req extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library(array('pagination', 'Cek_login_lib'));
        $this->cek_login_lib->logged_in();
        $this->load->model(array('M_log','model_kelolaan','M_monitoring'));

        $array = array(
            'hitung_deb' => $this->M_monitoring->get_jml_data_monitoring($this->session->userdata('tgl_skrg'), $this->session->userdata('tgl_min_3'))->num_rows(),
            'data_debb'  => $this->M_monitoring->get_data_monitoring_2($this->session->userdata('tgl_skrg'), $this->session->userdata('tgl_min_3'))->result_array()
        );
        
        $this->session->set_userdata( $array );

        ini_set('max_execution_time', 0); 
    }

    public function index()
    {
        $data = ['title'    => "Log Request",
                 'isi'      => 'logg/log_req',
                 'menu'     => 'log',
                 'user_id'  => $this->M_log->cari_user_id()->result_array()
                ];

        $this->load->view('layout/wrapper',$data);
    }

    public function tampil_log_req()
    {
        $user_id  = $this->input->post('user_id');

        $dt = ['user_id'  => $user_id
              ];
        
        $list = $this->M_log->get_data_log_req($dt);

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($o['status'] == 1) {
                $status = '<div align="center"><button type="button" class="btn btn-sm btn-danger ubah_status" style="margin-right: 5px;" data-id="'.$o['id'].'">Nonaktifkan</button>';
            } else {
                $status = '<div align="center"><span class="badge badge-secondary">Non Aktif</span></div>';
            }

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['userId'];
            $tbody[]    = $o['response'];
            $tbody[]    = $o['action'];
            $tbody[]    = date("d-m-Y H:i:s", strtotime($o['created_at']));
            $tbody[]    = $status;
            $data[]     = $tbody;
        }

        $output = [ "draw"              => $_POST['draw'],
                    "recordsTotal"      => $this->M_log->jumlah_semua_log_req($dt),
                    "recordsFiltered"   => $this->M_log->jumlah_filter_log_req($dt),   
                    "data"              => $data,
                ];

        echo json_encode($output);
    }

    public function ubah_status()
    {
        $id = $this->input->post('id');
        
        $this->db->update('log_request', ['status' => 0], ['id' => $id]);
        
        echo json_encode(['status' => TRUE]);
    }

    // 28-07-2021
    public function uim()
    {
        $data = ['title'    => "Log Response UIM",
                 'isi'      => 'logg/log_uim',
                 'menu'     => 'log_uim',
                 'user_id'  => $this->M_log->cari_user_id()->result_array()
                ];

        $this->load->view('layout/wrapper',$data);
    }

    public function tampil_log_uim()
    {
        $list = $this->M_log->get_data_log_uim();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['status'];
            $tbody[]    = $o['rc'];
            $tbody[]    = $o['response'];
            $tbody[]    = $o['message'];
            $tbody[]    = date("d-m-Y H:i:s", strtotime($o['add_time']));
            $data[]     = $tbody;
        }

        $output = [ "draw"              => $_POST['draw'],
                    "recordsTotal"      => $this->M_log->jumlah_semua_log_uim(),
                    "recordsFiltered"   => $this->M_log->jumlah_filter_log_uim(),   
                    "data"              => $data,
                ];

        echo json_encode($output);
    }

    public function error()
    {
        $data = ['title'    => "Log Error Login",
                 'isi'      => 'logg/log_error',
                 'menu'     => 'log_error',
                ];

        $this->load->view('layout/wrapper',$data);
    }

    public function tampil_log_error()
    {
        $list = $this->M_log->get_data_log_error();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['keterangan'];
            $tbody[]    = date("d-m-Y H:i:s", strtotime($o['add_time']));
            $data[]     = $tbody;
        }

        $output = [ "draw"              => $_POST['draw'],
                    "recordsTotal"      => $this->M_log->jumlah_semua_log_error(),
                    "recordsFiltered"   => $this->M_log->jumlah_filter_log_error(),   
                    "data"              => $data,
                ];

        echo json_encode($output);
    }

}

/* End of file Log_req.php */
