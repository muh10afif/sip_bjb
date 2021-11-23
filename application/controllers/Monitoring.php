<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller{   

    function __construct(){
        parent::__construct();
        $this->load->library('Cek_login_lib');
        $this->cek_login_lib->logged_in();
        $this->load->model('M_monitoring');
        
        $array = array(
            'hitung_deb' => $this->M_monitoring->get_jml_data_monitoring($this->session->userdata('tgl_skrg'), $this->session->userdata('tgl_min_3'))->num_rows(),
            'data_debb'  => $this->M_monitoring->get_data_monitoring_2($this->session->userdata('tgl_skrg'), $this->session->userdata('tgl_min_3'))->result_array()
        );
        
        $this->session->set_userdata( $array );
    }

    function tes()
    {
        $date = date('Y-m-d H:i:s');
        echo $a = substr($date, 0, 10);
    }

    function index()
    {   
        $data = array(  'title' => 'Monitoring Progress',
                        'isi'   => 'dasbor/dasbor_view',
                        'menu'  => 'monitoring_prog'
                    );

        $this->load->view('layout/wrapper',$data);
    }

    public function monitoring_debitur($jenis = 'npl', $unduh = '', $list = '', $reg_employee = '')
    {
        // mecari hari H-3
        $tgl_skrg       = date('Y-m-d', now('Asia/Jakarta'));
        $new_tgl_skrg   = strtotime($tgl_skrg);

        $jml_hari       = 3;
        $new_jml_hari   = 86400 * $jml_hari;

        $hasil_jml      = $new_tgl_skrg - $new_jml_hari;
        $tanggal_min_3  = date('Y-m-d', $hasil_jml);

        $data           = [ 'title'         => 'Monitoring Debitur',
                            'isi'           => 'monitoring/monitoring_debitur',
                            'aktif'         => $jenis,
                            'list'          => $list,
                            'reg_employee'  => $reg_employee
                            ];

        if ($list == 'semua') {
            $data['judul']     = 'Data Monitoring Debitur';
            $data['menu']      = 'monitoring';
            $data['data_deb']  = $this->M_monitoring->get_data_list_monitoring($jenis, $reg_employee = '', $deal_reff = '')->result_array();
        } elseif ($list == 'debitur') {
            // cari debitur kelolaan
            $cr = $this->M_monitoring->get_debitur_kelolaan($jenis, $reg_employee)->result_array();

            $data['reg']       = $cr;
            $data['judul']     = 'Data Monitoring';
            $data['menu']      = 'monitoring_deb';
            $data['data_deb']  = $this->M_monitoring->get_data_list_monitoring($jenis, $reg_employee, $deal_reff = '')->result_array();
        } else {
            $data['judul']     = 'Data Debitur Follow UP H-3';
            $data['menu']      = '';
            $data['data_deb']  = $this->M_monitoring->get_data_monitoring($tgl_skrg, $tanggal_min_3, $jenis)->result_array();
        }

        if ($unduh == 'excel') {
            $this->template->load('monitoring/template_excel_deb', 'monitoring/unduh_excel', $data);
        } else {
            $this->load->view('layout/wrapper', $data);
        }

    }

    // mengunduh bukti pembayaran
    public function bukti_kunjungan()
    {
        $id_tr_m      = $this->uri->segment(3);
        $jenis          = $this->uri->segment(4);
        $d_print        = $this->uri->segment(5);

        $fto = $this->M_monitoring->get_data_list_monitoring($jenis = '', $reg_employee = '', $id_tr_m)->row_array();

        $t_ao     = $fto['ttd_ao']; 
        $t_deb    = $fto['ttd_debitur'];

        $array = [$t_ao, $t_deb];

        define('UPLOAD_DIR', 'assets/images/');

        if (!empty($fto)) {
            for ($i = 0; $i < 2 ; $i++) {

                if ($i == 0) {
                    $nama = 'ttd_ao.png';
                } elseif ($i == 1) {
                    $nama = 'ttd_deb.png';
                }

                $name_file = $nama;
                
                $image_base64 = base64_decode($array[$i]);
                $file = UPLOAD_DIR . $name_file;
                file_put_contents($file, $image_base64);
            }
                
        }

        $data   = [
                'data_deb'  => $this->M_monitoring->get_data_list_monitoring($jenis = '', $reg_employee = '', $id_tr_m)->row_array(),
                'foto_deb'  => $this->M_monitoring->get_foto_monitoring($id_tr_m),
                'jenis'     => $this->uri->segment(4),
                'd_print'   => $this->uri->segment(5)
                 ];

        $this->load->view('monitoring/preview', $data, FALSE);

        // $this->load->view('monitoring/v_word', $data, FALSE);
        // $this->load->view('monitoring/print_bukti', $data, FALSE);
        // $this->load->view('monitoring/tes', $data, FALSE);
    }

    // menampilkan foto monitoring
    public function foto_monitoring($id_tr_monitoring, $jenis, $reg_employee = '')
    {
        $data           = [ 'title'         => 'Foto Monitoring Debitur',
                            'isi'           => 'monitoring/foto_monitoring_debitur',
                            'foto_deb'      => $this->M_monitoring->get_foto_monitoring($id_tr_monitoring),
                            'jenis'         => $jenis,
                            'menu'          => 'monitoring',
                            'reg_employee'  => $this->session->userdata('reg_employee')
                              
                            ];

        $this->load->view('layout/wrapper', $data);
    }

    // menampilkan list tr_kelolaan
    public function kelolaan_debitur($jenis = 'npl', $unduh = '')
    {
        $data           = [ 'title'         => 'Kelolaan Debitur',
                            'isi'           => 'monitoring/kelolaan_debitur',
                            'menu'          => 'kelolaan',
                            'aktif'         => $jenis,
                            'judul'         => 'Data Kelolaan',
                            'data_deb'      => $this->M_monitoring->get_deb_kelolaan($jenis, $this->session->userdata('reg_employee'))->result_array(),
                            'reg_employee'  => $this->session->userdata('reg_employee'),
                            'jenis'         => $jenis
                            ];  

        if ($unduh == 'excel') {
            $this->template->load('monitoring/template_excel_deb', 'monitoring/unduh_excel_ao', $data);
        } else {
            $this->load->view('layout/wrapper', $data);
        }
    }

}