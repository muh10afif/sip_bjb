<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller{  

    function __construct(){
        parent::__construct();
        $this->load->library('Cek_login_lib');
        $this->cek_login_lib->logged_in();
        $this->load->model(array('model_report','model_karyawan', 'M_monitoring'));
        
        $array = array(
            'hitung_deb' => $this->M_monitoring->get_jml_data_monitoring($this->session->userdata('tgl_skrg'), $this->session->userdata('tgl_min_3'))->num_rows(),
            'data_debb'  => $this->M_monitoring->get_data_monitoring_2($this->session->userdata('tgl_skrg'), $this->session->userdata('tgl_min_3'))->result_array()
        );
        
        $this->session->set_userdata( $array );
    }

    // untuk awal tampilan data karyawan
    public function data($aksi = 'tampil', $id = null)
    {   
        if ($aksi == 'ubah') {

            $data = [ 'judul' => 'Edit Data Karyawan', 
                      'aksi'  => 'ubah',
                      'title' => 'Master Karyawan',
                      'isi'   => 'karyawan/lihat_data',
                      'menu'  => 'karyawan' 
                    ];
            
            $id     =  $this->uri->segment(4);

            $data['ambil_cabang']   = $this->model_karyawan->ambil_cabang();
            $data['ambil_kanwil']   = $this->model_karyawan->ambil_kanwil();
            $data['record']         = $this->model_karyawan->tampil_data();
            $data['ubah_data']      = $this->model_karyawan->get_one($id)->row_array();

            $this->load->view('layout/wrapper',$data);

        } else {

            $data = [   'aksi'  => 'tampil',
                        'title' => 'Master Karyawan',
                        'isi'   => 'karyawan/lihat_data',
                        'menu'  => 'karyawan'
                    ];
            
            $data['record']         = $this->model_karyawan->tampil_data();
            $data['ambil_cabang']   = $this->model_karyawan->ambil_cabang();
            $data['ambil_kanwil']   = $this->model_karyawan->ambil_kanwil();
            
            $this->load->view('layout/wrapper',$data);
        }
        
    }

    // untuk mengambil data pada combobox kanwil
    public function ambil_data()
    {
        $modul  = $this->input->post('modul');
        $kanwil = $this->input->post('kanwil');

        if ($modul == "cabang") {
            echo $this->model_report->cabang_1($kanwil);
        } 

    }

    // untuk aksi menambahkan data karyawan
    public function post_ubah($aksi)
    {
        $reg_employee   = $this->input->post('reg_employee');
        $nama           = $this->input->post('name');
        $tgl_lahir      = $this->input->post('birth_date');
        $alamat         = $this->input->post('address');
        $telpon         = $this->input->post('phone');
        $email          = $this->input->post('email');

        $data   = [ 'name'          =>  $nama,
                    'birth_date'    =>  $tgl_lahir,
                    'address'       =>  $alamat,
                    'reg_employee'  =>  $reg_employee,
                    'phone'         =>  $telpon,
                    'email'         =>  $email
                    // 'add_time'      =>  date("Y-m-d H:i:s", now('Asia/Jakarta'))
                ];

        if ($aksi == 'post') {

            $cek_reg = $this->model_karyawan->get_one($reg_employee);

            if ($cek_reg->num_rows() == 0) {

                $this->model_karyawan->post_data($data);

                $hasil = $this->db->affected_rows();

                if ($hasil != 0) {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Berhasil menambahkan data nama '.$nama.'</div>');
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Tidak ada penambahan data!</div>');
                }

            } else {

                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Data tidak tersimpan, Reg Employee sudah ada!</div>');

            }

            

        } else {
            
            $this->model_karyawan->edit($data,$reg_employee);

            $hasil = $this->db->affected_rows();

            if ($hasil != 0) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Berhasil mengubah data nama '.$nama.'</div>');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Tidak ada perubahan data!</div>');
            }

        }
        
        redirect('karyawan/data');
    }
    
    
    function hapus()
    {
        $id     =  $this->uri->segment(3);

        $data = $this->model_karyawan->get_one($id)->row_array();
        
        $this->model_karyawan->delete($id);

        $hasil = $this->db->affected_rows();

        if ($hasil != 0) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Berhasil menghapus data nama '.$data['name'].'</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Tidak ada perubahan data!</div>');
        }

        redirect('karyawan/data');
    }
}