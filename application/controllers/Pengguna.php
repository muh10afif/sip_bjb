<?php
class Pengguna extends CI_Controller{   

    function __construct(){
        parent::__construct();
        $this->load->library('Cek_login_lib');
        $this->cek_login_lib->logged_in();
        $this->load->model(array('model_pengguna','model_karyawan','M_monitoring'));

        $array = array(
          'hitung_deb' => $this->M_monitoring->get_jml_data_monitoring($this->session->userdata('tgl_skrg'), $this->session->userdata('tgl_min_3'))->num_rows(),
          'data_debb'  => $this->M_monitoring->get_data_monitoring_2($this->session->userdata('tgl_skrg'), $this->session->userdata('tgl_min_3'))->result_array()
        );
        
        $this->session->set_userdata( $array );
    }


    public function data($aksi = 'tampil', $id = null)
    {   
        if ($aksi == 'ubah') {

          $id   =  $this->uri->segment(4);

          $data = array(  'judul' => 'Edit Data Pengguna',
                          'aksi'  => 'ubah',
                          'title' => 'Master Pengguna',
                          'isi'   => 'pengguna/lihat_data',
                          'menu'  => 'pengguna'
                        );

          $data['rcd']            = $this->model_pengguna->get_employee();
          $data['r_user']         = $this->model_pengguna->get_one($id)->row_array();
          $data['record']         = $this->model_pengguna->tampil_data();
          $data['level']          = $this->model_pengguna->get_level();
          $data['ambil_cabang']   = $this->model_karyawan->ambil_cabang();
          $data['ambil_kanwil']   = $this->model_karyawan->ambil_kanwil();

          $this->load->view('layout/wrapper',$data);
          
        } else {
          $data = array(  'aksi'  => 'tampil',
                          'title' => 'Master Pengguna',
                          'isi'   => 'pengguna/lihat_data',
                          'menu'  => 'pengguna'
                        );

          $data['rcd']            = $this->model_pengguna->get_employee();
          $data['record']         = $this->model_pengguna->tampil_data();
          $data['level']          = $this->model_pengguna->get_level();
          $data['ambil_cabang']   = $this->model_karyawan->ambil_cabang();
          $data['ambil_kanwil']   = $this->model_karyawan->ambil_kanwil();

          $this->load->view('layout/wrapper',$data);
        }
        
    }

    //  fungsi untuk memanggil web api
    function callAPI($method, $url, $data){
      $curl = curl_init();

       switch ($method){
          case "POST":
             curl_setopt($curl, CURLOPT_POST, 1);
             if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
             break;
          case "PUT":
             curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
             if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                
             break;
          default:
             if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
       }

       // OPTIONS:
       curl_setopt($curl, CURLOPT_URL, $url);
       curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'APIKEY: 111111111111111111111',
          'Content-Type: application/json',
       ));
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

       // EXECUTE:
       $result = curl_exec($curl);
       if(!$result){die("Connection Failure");}
       curl_close($curl);
       return $result;
    }
    
    // fungsi ubah data atau simpan data
    public function post_ubah($aksi, $p_level = null, $p_kanwil = null, $p_cabang = null)
    {
        $options      = ['cost' => 10];

        $id           =  $this->input->post('id');
        $reg_employee =  $this->input->post('reg_employee');
        $email        =  $this->input->post('username');
        $sha          =  $this->input->post('sha');
        $level        =  $this->input->post('level');
        $active       =  $this->input->post('active');
        $kanwil       =  $this->input->post('kanwil');
        $cabang       =  $this->input->post('cabang_induk');
        $p_sha        =  $this->input->post('p_sha');

        // jika aksi ingin mengubah data
        if ($aksi == 'ubah') {

            // jika data inputan password terisi
            if (!empty($sha)) {

                  // jika level adalah USER
                  if ($level == 4 || $level == 2) {
                    
                      $data_array =  array(
                          "id"            => $id,
                          "name"          => "",
                          "email"         => $email,
                          "reg_employee"  => $reg_employee,
                          "password"      => $sha,
                          "address"       => "",
                          "auth"          => $level,
                          "active"        => $active

                      );

                      $data_2 = [ 'kanwil'      =>  $kanwil,
                                  'cabang_induk'=>  $cabang
                                ];

                      if (($active == '0') || ($p_cabang != $cabang)) {
                          $this->model_pengguna->hapus_kelolaan($reg_employee);
                      }

                      $this->model_karyawan->edit($data_2,$reg_employee);

                      $e = $this->model_karyawan->get_one($reg_employee)->row_array();

                      $make_call = $this->callAPI('POST', 'http://skdigital.id:8085/sip_bjb/api/user/EditUser?abaikan1=ohji&abaikan2=ahayyy&abaikan3=qwrty', json_encode($data_array));
                      $response = json_decode($make_call, true);
                      $errors   = $response['response']['errors'];
                      $data     = $response['response']['data'][0];

                        if ($response == "Cieeee Berhasil!") {
                            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Berhasil merubah data nama '.$e['name'].'</div>');
                        } else {
                            $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Tidak ada perubahan data!</div>');
                        }

                        redirect('pengguna/data');

                  // jika level manager, supervisor.....
                  } else {
                      $data   = [ 'reg_employee'=>  $reg_employee,
                                  'email'       =>  $email,
                                  'sha'         =>  password_hash($sha,PASSWORD_DEFAULT, $options),
                                  'level'       =>  $level,
                                  'active'      =>  $active
                              ];

                      $data_2 = [ 'kanwil'      =>  $kanwil,
                                  'cabang_induk'=>  $cabang
                                ];
                  }
 

            // jika inputan password KOSONG         
            } else {

                  // jika level adalah USER
                  if ($level == 4 || $level == 2) {

                    $lv = $this->model_karyawan->cari_data('m_user', array('id' => $id))->row_array();
                    
                      $data_array =  array(
                          "id"            => $id,
                          "name"          => "",
                          "email"         => $email,
                          "reg_employee"  => $reg_employee,
                          "password"      => $lv['sha'],
                          "address"       => "",
                          "auth"          => $level,
                          "active"        => $active

                      );

                      $data_2 = [ 'kanwil'      =>  $kanwil,
                                  'cabang_induk'=>  $cabang
                                ];

                      if (($active == '0') || ($p_cabang != $cabang)) {
                          $this->model_pengguna->hapus_kelolaan($reg_employee);
                      }

                      $this->model_karyawan->edit($data_2,$reg_employee);

                      $e = $this->model_karyawan->get_one($reg_employee)->row_array();

                      $make_call = $this->callAPI('POST', 'http://skdigital.id:8085/sip_bjb/api/user/EditUser?abaikan1=ohji&abaikan2=ahayyy&abaikan3=qwrty', json_encode($data_array));
                      $response = json_decode($make_call, true);
                      $errors   = $response['response']['errors'];
                      $data     = $response['response']['data'][0];

                        if ($response == "Cieeee Berhasil!") {
                            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Berhasil merubah data nama '.$e['name'].'</div>');
                        } else {
                            $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Tidak ada perubahan data!</div>');
                        }

                        redirect('pengguna/data');

                  // jika level manager, supervisor.....
                  } else {
                    
                    $data   = [ 'reg_employee'  =>  $reg_employee,
                                'email'         =>  $email,
                                'level'         =>  $level,
                                'active'        =>  $active
                              ];

                    $data_2 = [ 'kanwil'      =>  $kanwil,
                                'cabang_induk'=>  $cabang
                              ];

                  }

            }

            $reg = $this->model_karyawan->get_one($reg_employee)->row_array();

            $this->model_karyawan->edit($data_2,$reg_employee);

            $hasil_2 = $this->db->affected_rows();

            $this->model_pengguna->edit($data,$id);

            $hasil = $this->db->affected_rows();

            if ($hasil != 0 || $hasil_2 != 0) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Berhasil mengubah data nama '.$reg['name'].'</div>');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Tidak ada perubahan data!</div>');
            }

            redirect('pengguna/data');


        // jika aksi ingin menyimpan data -- POST ---
        } else {

            // jika level USER
            if ($level == 4 || $level == 2) {
                  $data_array =  array(
                      "id"            => "",
                      "name"          => "",
                      "email"         => $email,
                      "reg_employee"  => $reg_employee,
                      "password"      => $sha,
                      "address"       => "",
                      "auth"          => $level,
                      "active"        => $active
                  );

                   $cek_user = $this->model_karyawan->cari_username($email)->num_rows();

                  if ($cek_user == 0 ) {

                      $e = $this->model_karyawan->get_one($reg_employee)->row_array();

                      // $make_call = $this->callAPI('POST', 'http://skdigital.id:8085/sip_bjb/api/user/SaveUser?abaikan=ohji', json_encode($data_array));
                      $make_call = $this->callAPI('POST', 'http://localhost:58874/api/user/SaveUser?abaikan=ohji', json_encode($data_array));
                      $response = json_decode($make_call, true);
                      $errors   = $response['response']['errors'];
                      $data     = $response['response']['data'][0];

                      if ($response == 1) {
                          $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Berhasil menambahkan data nama '.$e['name'].'</div>');
                      } else {
                          $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Tidak ada penambahan data!</div>');
                      }

                  } else {

                      $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Data tidak tersimpan, Username sudah ada!</div>');

                  }

                  

                  redirect('pengguna/data');

              // jika level manager, supervisor.....
              } else {
                   $data = [  'reg_employee'  =>  $reg_employee,
                              'email'         =>  $email,
                              'sha'           =>  password_hash($sha,PASSWORD_DEFAULT, $options),
                              'level'         =>  $level,
                              'active'        =>  $active
                            ];

                  $data_2 = [ 'kanwil'        =>  $kanwil,
                              'cabang_induk'  =>  $cabang 
                            ];

                  $cek_user = $this->model_karyawan->cari_username($email)->num_rows();

                  if ($cek_user == 0 ) {

                      $hasil = $this->model_karyawan->edit($data_2,$reg_employee);

                      $this->model_pengguna->post($data);

                      $data = $this->model_karyawan->get_one($reg_employee)->row_array();

                      // $hasil = $this->db->affected_rows($ha);

                      if ($hasil != 0) {
                          $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Berhasil menambahkan data nama '.$data['name'].'</div>');
                      } else {
                          $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Tidak ada penambahan data!</div>');
                      }   

                  } else {

                      $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Data tidak tersimpan, Username sudah ada!</div>');
                    
                  }                  

                  

                  redirect('pengguna/data');
              }
        } 
        
    }
    
    function hapus()
    {
        $id   =  $this->uri->segment(3);
        $reg  =  $this->uri->segment(4);

        $data = $this->model_karyawan->get_one($reg)->row_array();

        $this->model_pengguna->delete($id);

        $hasil = $this->db->affected_rows();

        if ($hasil != 0) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Berhasil menghapus data nama '.$data['name'].'</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible col-md-12"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-filter"></i>Tidak ada perubahan data!</div>');
        }

        redirect('pengguna/data');
    }
}