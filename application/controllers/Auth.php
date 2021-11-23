<?php

class Auth extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model(array('model_operator','M_monitoring', 'M_user'));
      $this->load->library('Excel');
	}

	public function index(){

      $this->load->library('Cek_login_lib');
      $this->cek_login_lib->logged_in_2();

      // if ($this->session->userdata('masuk') == FALSE) {
      //    $data = array(
      //       'userId'       => $this->session->userdata('userId'),
      //       'response'     => $this->session->userdata('response'),
      //       'action'       => 'logout12',
      //       'created_at'   => date('Y-m-d H:i:s', now('Asia/Jakarta'))
      //    );

      //    $this->db->insert('log_request', $data);
      // }

		$this->load->view('login/login_view');
   }

   public function tes_konek()
   {
      // $serverName = "DESKTOP-NBN9AI5\SQLEXPRESS"; //serverName\instanceName
      $serverName = "DESKTOP-I10QEH4\SQLEXPRESS";

      // Since UID and PWD are not specified in the $connectionInfo array,
      // The connection will be attempted using Windows Authentication.
      // $connectionInfo = array( "Database"=>"bjb");
      // $conn = sqlsrv_connect( $serverName, $connectionInfo);

      // if( $conn ) {
      //    echo "Connection established.<br />";
      // }else{
      //    echo "Connection could not be established.<br />";
      //    die( print_r( sqlsrv_errors(), true));
      // }
   }
   
   public function tes()
   {
      include "prosesaes.php";
	
      $nama = "ACHMAD ADIN YAHYA";
         // $z = "abcdefghijuklmno0123456789012345";// key
         $z = "yQTAFGpD2MAaOfhg2InXZm601SRYCl13";// key
      $aes = new Aes($z);
      $enkrip=$aes->encrypt($nama);
      echo "\n\n Hasil Enkrip:\n" .($enkrip) . "\n";
      $decrypted = $aes->decrypt($enkrip);

      echo "\n\n Hasil Dekrip:\n". stripslashes($decrypted)."\n";
   }

   public function tes_lagi()
   {
      define('AES_256_CBC', 'aes-256-cbc');
      // $encryption_key = openssl_random_pseudo_bytes(32);
      $encryption_key = "yQTAFGpD2MAaOfhg2InXZm601SRYCl13";
      $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(AES_256_CBC));
      $data = "namasdfmndfk";
      echo "Before encryption: $data\n\n";
      $encrypted = openssl_encrypt($data, AES_256_CBC, $encryption_key, 0, $iv);
      echo "Encrypted: $encrypted\n\n";
      $encrypted = $encrypted . ':' . $iv;
      $parts = explode(':', $encrypted);
      $decrypted = openssl_decrypt($parts[0], AES_256_CBC, $encryption_key, 0, $parts[1]);
      echo "Decrypted: $decrypted\n\n";
   }

   public function tes_p()
   {
      $a = "eyJpdiI6Ik5TamtVMkxlVkVPSlVKQUxGVlwvTjJ3PT0iLCJ2YWx1ZSI6Iko5S3NqbUhHUnRnQW52UUlKeU0xMUE9PSIsIm1hYyI6ImY1ZTU0MWJkOTU1MGMxZjFkYjJjZWVhYzllMTllYzhhYzI0MmNiZTdlYzE0ZmE1MTE2NGY1NjY2MmQ0N2NkMjIifQ==";

      var_dump($a);
   }

  public function pass()
  {
    echo password_hash('12345', PASSWORD_DEFAULT);
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
     /*if(!$result){die("Connection Failure");}*/
     curl_close($curl);
     return $result;
  }

  public function tes_api()
  {
      $url = "http://127.0.0.1:8000/aes256";

      $curl = curl_init($url);

      $data = array(
         'password'  => "sad",
      );

      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

      $result = curl_exec($curl);

      curl_close($curl);

      $res = array(
      'userId' => "asd",
      'password' => $result,
      'appId' => 201
      );

      echo json_encode($res);
  }

	function login(){

      $email  = trim(htmlspecialchars($this->input->post('email',TRUE),ENT_QUOTES));
      $pwd    = trim(htmlspecialchars($this->input->post('password',TRUE),ENT_QUOTES));

      $cek_user = $this->model_operator->cek_user_login($email)->row_array();

      if ($cek_user['level'] == 4 || $cek_user['level'] == 2) {

         /*$make_call = $this->callAPI('GET', "http://192.168.0.26/sip_bjb/api/user/GetUserFromWeb?email=$email&pass=$pwd&abaikan=kevinliaaudianaturyawan", false);*/

         $make_call = $this->callAPI('GET', "http://skdigital.id:8085/sip_bjb/api/user/GetUserFromWeb?email=$email&pass=$pwd&abaikan=kevinliaaudianaturyawan", false);

         $response = json_decode($make_call, true);

         $pass = $response['password'];

         $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
         
      } 

      $data      = ['email' => $email];

      $cek_email = $this->model_operator->cek_user_login($email);

      $tgl_skrg       = date('Y-m-d', now('Asia/Jakarta'));
      $new_tgl_skrg   = strtotime($tgl_skrg);

      $jml_hari       = 3;
      $new_jml_hari   = 86400 * $jml_hari;

      $hasil_jml      = $new_tgl_skrg - $new_jml_hari;
      $tanggal_min_3  = date('Y-m-d', $hasil_jml);

      if ($cek_email->num_rows() != 0) {
         foreach ($cek_email->result_array() as $c) {

               if ($c['level'] == 1 || $c['level'] == 3 || $c['level'] == 5) {
                  $pass_hash = $c['sha'];
               }

               if (password_verify($pwd, $pass_hash)) {
                  
                  if (($c['active'] == 1)) {
                     $array = array(
                        'email'        => $email,
                        'masuk'        => TRUE,
                        'username'     => $c['username'],
                        'level'        => $c['level'],
                        'auto'         => $c['auto'],
                        'name'         => $c['name'],
                        'kanwil'       => $c['kanwil'],
                        'reg_employee' => $c['reg_employee'],
                        'tgl_skrg'     => $tgl_skrg,
                        'tgl_min_3'    => $tanggal_min_3
                     );

                     $this->session->set_userdata($array);

                     redirect('dasbor');
                  } else {
                     $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Anda tidak mempunyai hak akses masuk!</div>');
                     redirect('auth');
                  }

               } else {
                  $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Password salah!</div>');
                  $this->load->view('login/login_view', $data);
               }
         }

      } else {
         $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Username tidak temukan!</div>');
            redirect('auth');
      }

   }

   // 27-12-2020
   public function buat_session($res)
   {
      $tgl_skrg       = date('Y-m-d', now('Asia/Jakarta'));
      $new_tgl_skrg   = strtotime($tgl_skrg);

      $jml_hari       = 3;
      $new_jml_hari   = 86400 * $jml_hari;

      $hasil_jml      = $new_tgl_skrg + $new_jml_hari;
      $tanggal_min_3  = date('Y-m-d', $hasil_jml);

      $dt = $res;

      if ($dt['idFungsi'] == 1473)
      {
         $lvl = 1;
      }
      else if ($dt['idFungsi'] == 1455)
      {
         $lvl = 2;
      }
      else if ($dt['idFungsi'] == 1456)
      {
         $lvl = 3;
      }
      else
      {
         $lvl = 4;
      }

      $c = $this->model_operator->cari_data('m_authorization', ['id' => $lvl])->row_array();

      $u = $this->model_operator->cari_data('m_employee', ['reg_employee' => $dt['nip']])->row_array();

      if ($lvl == 1) {
         $nm_lvl = "Super Admin";
      } else if ($lvl == 2) {
         $nm_lvl = "Pusat";
      } else if ($lvl == 3) {
         $nm_lvl = "Kanwil";
      } else {
         $nm_lvl = "AO";
      }

      $array = array(
         'email'        => $dt['userId'],
         'masuk'        => TRUE,
         'username'     => $dt['userId'],
         'level'        => $lvl,
         'auto'         => $c['auth'],
         'nama_lvl'     => $nm_lvl,
         'name'         => $dt['nama'],
         'kanwil'       => $dt['namaKanwil'],
         'reg_employee' => $dt['nip'],
         'cabang'       => $u->cabang_induk,
         'tgl_skrg'     => $tgl_skrg,
         'tgl_min_3'    => $tanggal_min_3
      );

      $this->session->set_userdata($array);

      return true;
   }

   public function buat_log($data_log)
   {
      $user_id    = $this->input->post('userId');

      // $cari = $this->M_user->cari_data_log($user_id)->num_rows();

      // if ($cari == 0) {

      //    $data = ['userId'       => $user_id,
      //             'response'     => $this->input->post('response'),
      //             'action'       => 'login',
      //             'created_at'   => date('Y-m-d H:i:s', now('Asia/Jakarta'))
      //             ];

      //    $this->db->insert('log_request', $data);

      //    $id_log = $this->db->insert_id();
         
      //    $array = array(
      //       'id_log'       => $this->input->post('id_log'),
      //       'userId'       => $this->input->post('userId'),
      //       'response'     => $this->input->post('response')
      //    );
         
      //    $this->session->set_userdata( $array );    
         
      //    echo json_encode(['status' => "1"]);
      
      // } else {

      //    echo json_encode(['status' => "0"]);
         
      // }

      $array = array(
         'id_log'       => $data_log['id_log'],
         'userId'       => $data_log['userId'],
         'response'     => $data_log['response']
      );
      
      $this->session->set_userdata( $array );    
      
      // echo json_encode(['status' => "1"]);

      return true;

   }

   public function logout()
   {
      if ($this->session->userdata('masuk')) {

         $data = array(
            'userId'       => $this->session->userdata('userId'),
            'response'     => $this->session->userdata('response'),
            'action'       => 'logout',
            'created_at'   => date('Y-m-d H:i:s', now('Asia/Jakarta')),
            'status'       => 0
         );

         $this->db->insert('log_request', $data);

         $user_id = $this->session->userdata('userId');
         $id_log  = $this->session->userdata('id_log');
         $status  = 0;

         // update data
         $this->db->update('log_request', ['status' => 0], ['id' => $id_log]);
      }
      
      $this->session->sess_destroy();

      $url  = base_url('');
      redirect($url);
   }

   public function aksi_logout()
   {
      # code...
   }

   public function generate_pass()
   {
      $plaintext = "Mahameru7";
      $password = 'jkbsdklUIG/98xhk()nklkjghjl_21';

      // CBC has an IV and thus needs randomness every time a message is encrypted
      $method = 'aes-256-cbc';

      // Must be exact 32 chars (256 bit)
      // You must store this secret random key in a safe place of your system.
      $key = substr(hash('sha256', $password, true), 0, 32);
      // echo "Password:" . $password . "\n";

      // Most secure key
      //$key = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

      // IV must be exact 16 chars (128 bit)
      $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

      // Most secure iv
      // Never ever use iv=0 in real life. Better use this iv:
      // $ivlen = openssl_cipher_iv_length($method);
      // $iv = openssl_random_pseudo_bytes($ivlen);

      // av3DYGLkwBsErphcyYp+imUW4QKs19hUnFyyYcXwURU=
      $encrypted = base64_encode(openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv));

      $a = "DA78FsMHkjnC809AfmxjKw==";

      // My secret message 1234
      $decrypted = openssl_decrypt(base64_decode($a), $method, $key, OPENSSL_RAW_DATA, $iv);

      // echo 'plaintext=' . $plaintext . "\n";
      // echo 'cipher=' . $method . "\n";
      // echo 'encrypted to: ' . $encrypted . "\n";
      //echo 'decrypted to: ' . $decrypted . "\n\n";

      echo json_encode(['hasil' => $encrypted]);
   }

   public function generate_pass_2($plaintext)
   {
      $password = 'jkbsdklUIG/98xhk()nklkjghjl_21';

      // CBC has an IV and thus needs randomness every time a message is encrypted
      $method = 'aes-256-cbc';

      // Must be exact 32 chars (256 bit)
      // You must store this secret random key in a safe place of your system.
      $key = substr(hash('sha256', $password, true), 0, 32);
      // echo "Password:" . $password . "\n";

      // Most secure key
      //$key = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

      // IV must be exact 16 chars (128 bit)
      $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

      // Most secure iv
      // Never ever use iv=0 in real life. Better use this iv:
      // $ivlen = openssl_cipher_iv_length($method);
      // $iv = openssl_random_pseudo_bytes($ivlen);

      // av3DYGLkwBsErphcyYp+imUW4QKs19hUnFyyYcXwURU=
      $encrypted = base64_encode(openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv));

      $a = "DA78FsMHkjnC809AfmxjKw==";

      // My secret message 1234
      $decrypted = openssl_decrypt(base64_decode($a), $method, $key, OPENSSL_RAW_DATA, $iv);

      // echo 'plaintext=' . $plaintext . "\n";
      // echo 'cipher=' . $method . "\n";
      // echo 'encrypted to: ' . $encrypted . "\n";
      //echo 'decrypted to: ' . $decrypted . "\n\n";

      return $encrypted;
   }

   // 16-02-2021
   public function tes_curl()
   {
      $userid = $this->input->post('userId');
      $password = $this->input->post('password');

      $url = "http://127.0.0.1:8000/aes256";

      $curl = curl_init($url);

      $data = array(
         'password'  => $password,
      );

      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

      $result = curl_exec($curl);

      curl_close($curl);
   }

   public function save_user($dt)
   {
         if ($dt['idFungsi'] == 1473)
         {
            $lvl = 1;
         }
         else if ($dt['idFungsi'] == 1455)
         {
            $lvl = 2;
         }
         else if ($dt['idFungsi'] == 1456)
         {
            $lvl = 3;
         }
         else
         {
            $lvl = 4;
         }

        $reg_employee   = $dt['nip'];
        $userId         = $dt['userId'];
        $level          = $lvl;
        $nama           = $dt['nama'];
        $kanwil         = $dt['namaKanwil'];
        $cabang         = $dt['namaCabang'];

        // cari di user
        $a = $this->db->get_where('m_user', ['reg_employee' => $reg_employee]);
        $b = $this->db->get_where('m_employee', ['reg_employee' => $reg_employee]);

        $data_user = [  'reg_employee'   => $reg_employee,
                        'email'          => $userId,
                        'level'          => $level,
                        'active'         => 1
                     ];

        if ($a->num_rows() == 0) {
            
            $this->db->insert('m_user', $data_user);
            
        } else {

            $aa = $a->row_array();

            $this->db->update('m_user', $data_user, ['id' => $aa['id']]);

        }

        $data_emp = [   'reg_employee'   => $reg_employee,
                        'name'           => $nama,
                        'kanwil'         => $kanwil,
                        'cabang_induk'   => $cabang
                  ];

        if ($b->num_rows() == 0) {

            $this->db->delete('m_employee', ['name' => $nama]);
            
            $this->db->insert('m_employee', $data_emp);
            
        } else {

            $bb = $b->row_array();
            
            $this->db->update('m_employee', $data_emp, ['reg_employee' => $bb['reg_employee']]);
            
        }
        

        return true;
   }

   public function aes()
	{
		$encrypter = new Illuminate\Encryption\Encrypter('yQTAFGpD2MAaOfhg2InXZm601SRYCl13', 'AES-256-CBC');

      $psw      = "tes";
      $enc     = $encrypter->encrypt($psw);
      $pass     = "eyJpdiI6IkgvYXRnRU95bXhheDRaRzZmUjlWZmc9PSIsInZhbHVlIjoiQ1VDR1lKUzdyREhBSW5mVVl4bG5HZz09IiwibWFjIjoiY2MxZWZlZGEwYWM3NzdjNGFiMTQwZDU2NDgwYmY3NjVkMzM4YzBiZTcwNGYxYWYzOTc1MzZhYmU2MGI5ZGJkYyJ9";
      //$pass     = "eyJpdiI6ImV0ZU9NZFgzbXJTWnFJWG03T1BkMEE9PSIsInZhbHVlIjoidXlTejNuVEhjMXpzOHdNd0Y2TUEvdXkybU5oblMrNXhmSXIvUngzeGI5bz0iLCJtYWMiOiI1MWY5ZGU0Mjg5NDAwZTQ0ZDc5MDE2OGExMDc2NmU2MWU1ZWZkMmI3MmI4Yjk1NDc1NjFlZmU4OGM2ZGEyMGMwIn0=";

      $des = $encrypter->decryptString($pass);

      echo $des;
	}

   public function proses_login()
   {
      
      $encrypter = new Illuminate\Encryption\Encrypter('yQTAFGpD2MAaOfhg2InXZm601SRYCl13', 'AES-256-CBC');

      $username = $this->input->post('userid');
      $psw      = $this->input->post('password');
      $pass     = $encrypter->encrypt($psw);
      //$pass     = "eyJpdiI6IkgvYXRnRU95bXhheDRaRzZmUjlWZmc9PSIsInZhbHVlIjoiQ1VDR1lKUzdyREhBSW5mVVl4bG5HZz09IiwibWFjIjoiY2MxZWZlZGEwYWM3NzdjNGFiMTQwZDU2NDgwYmY3NjVkMzM4YzBiZTcwNGYxYWYzOTc1MzZhYmU2MGI5ZGJkYyJ9";
      //$pass     = "eyJpdiI6ImV0ZU9NZFgzbXJTWnFJWG03T1BkMEE9PSIsInZhbHVlIjoidXlTejNuVEhjMXpzOHdNd0Y2TUEvdXkybU5oblMrNXhmSXIvUngzeGI5bz0iLCJtYWMiOiI1MWY5ZGU0Mjg5NDAwZTQ0ZDc5MDE2OGExMDc2NmU2MWU1ZWZkMmI3MmI4Yjk1NDc1NjFlZmU4OGM2ZGEyMGMwIn0=";

      // $des = $encrypter->decryptString($pass);

      // echo $des; exit();
      //$pass     = "eyJpdiI6IjJDSllxd3UwU3NYQmNoUkRzcnBZSWc9PSIsInZhbHVlIjoiSHlraEtUSVRkelFNNmF4RWg4b01VOC9sTzJkUzl0MnhncXVJQVBsK3JPUT0iLCJtYWMiOiIzYTNjOWU4NjVhYjIzZDhhYjZkOGIzZTBlNjdiNDc1NmNhNWJhMjlmNTQ5MWE4YTkwNGIxM2Q1NWI0ZjQwMzE2In0=";

      // $url="http://10.6.232.134/v1/api/login";

      // $data1 = array(
      //    'userId'    => $username,
      //    'password'  => $pass,
      //    'appId'     => 212
      // );

      // $curl = curl_init($url);
      // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      // curl_setopt($curl, CURLOPT_POSTFIELDS, $data1);
      // $response = curl_exec($curl);

      // $err = curl_error($curl);

      // curl_close($curl);

      // $json = json_decode($response, true);

      // print_r($pass); exit();

         $response = ['nama'          => "Afif",
                     'nip'           => "12.00.3000",
                     'userid'        => "L111",
                     'kodeCabang'    => "P060",
                     'namaCabang'    => "CABANG UTAMA BANDUNG",
                     "kodeInduk"     => "P009",
                     "namaInduk"    => "CABANG UTAMA BANDUNG",
                     "kodeKanwil"   => "K001",
                     "namaKanwil"   => "KANWIL 1",
                     "jabatan"      => "STAF G4",
                     "posisiPenempatan" => "-",
                     "hp"           => "085624203225",
                     "email"        => "araspati@bankbjb.co.id",
                     "kodeGrade"    => "0085",
                     "namaGrade"    => "G4",
                     "idFungsi"     => "1455",
                     "fungsiTambahan"   => "-",
                     "limitDebet"   => "0",
                     "limitKredit"  => "0",
                     "id"           => "20151002103451P0938539"
                  ];

         $a =  json_encode(["status" => "success","rc" => "00", "response" => $response, "message" => "Transaction success."]);

         $json = json_decode($a, true);

         $json2 = json_encode($response);

      // cari yang login
      $cari = $this->M_user->get_login_aktif($username)->row_array();

      if ($username == 'L00GSIP' && $psw == 'p@ss00') {
         $array = array(
            'masuk'     => TRUE,
            'name'      => 'Admin Log',
            'nama_lvl'  => 'Admin',
            'cabang'    => '-',
            'kanwil'    => '-',
            'level'     => 0,
            'userId'    => 'L00GSIP',
            'response'  => '00'
         );

         $this->session->set_userdata( $array );

         $dt = ['userId'   => 'L00GSIP',
                'response' => '00',
                'action'   => 'login'
               ];
         $this->db->insert('log_request', $dt);

         redirect('log_req');
         exit();
      }

      if (!empty($cari)) {

         $this->session->set_flashdata('login', "<div class='alert alert-danger'>Masih ada yang aktif</div>");
         redirect('auth');
      
      } else {
         // echo $json['response']; exit();

         $dta_res = ['status'    => $json['status'],
                     'rc'        => $json['rc'],
                     // 'response'  => $json['response'],
                     'response'  => $json2,
                     'message'   => $json['message']
                     ];
         
         $this->db->insert('log_response_uim', $dta_res);

         // input log request
         $dt = ['userId'   => $username,
                'response' => $json['rc'],
                'action'   => 'login'
               ];
         $this->db->insert('log_request', $dt);
         $id_log = $this->db->insert_id();

         
         $array = array(
            'id_log' => $id_log
         );

         $this->session->set_userdata( $array );
         
         if ($json['rc'] == '00') {

            $this->buat_session($json['response']);

            $this->save_user($json['response']);

            redirect('dasbor');
         
         } elseif ($json['rc'] == '63') {
            
            $this->session->set_flashdata('login', "<div class='alert alert-danger'>Password Salah</div>");
            $this->session->set_flashdata('userid', $username);
            redirect('auth');
            
         } elseif ($json['rc'] == '44') {
            
            $this->session->set_flashdata('login', "<div class='alert alert-danger'>UserId Tidak Terdaftar</div>");
            redirect('auth');
         
         } else {
   
            $this->session->set_flashdata('login', "<div class='alert alert-danger'>Gagal Login</div>");
            redirect('auth');
            
         }
         
      }
   }

   public function coba()
   {
      // $this->load->driver('cache', array('adapter' => 'redis','backup' => 'file'));

      // if($this->cache->redis->is_supported()) {
      //    $cached = $this->cache->get('key');
      //    if($cached != null){
      //       echo $cached;
      //    }
      //    else{
      //       echo 'Some Value';
      //       $this->cache->save('key', "Some Value");
      //    }
      // }

      $this->load->driver('cache');
      $this->cache->redis->save('foo', 'bar', 10);
   }

   public function tess()
   {
      # {"status":"success","rc":"00","response":{"nama":"BINTANG RADHITYA SURYA","nip":"13.88.6608","userId":"E237","kodeCabang":"0001","namaCabang":"CABANG UTAMA BANDUNG","kodeInduk":"0001","namaInduk":"CABANG UTAMA BANDUNG","kodeKanwil":"K001","namaKanwil":"Kanwil 1","jabatan":"Staf Supporting","posisiPenempatan":"","kodePenempatan":"D181","hp":"08561206827","email":"bsurya@BANKBJB.CO.ID","kodeGrade":"0084","namaGrade":"G3","idFungsi":"1457","namaFungsi":"AO PPK","fungsiTambahan":"","limitDebet":"0","limitKredit":"0","id":"090512152734772"},"message":"Transaction success."};

      $response = ['nama'          => "Afif",
                  'nip'           => "12.00.3000",
                  'userid'        => "L111",
                  'kodeCabang'    => "P060",
                  'namaCabang'    => "CABANG UTAMA BANDUNG",
                  "kodeInduk"     => "P009",
                  "namaInduk"    => "CABANG UTAMA BANDUNG",
                  "kodeKanwil"   => "K001",
                  "namaKanwil"   => "KANWIL 1",
                  "jabatan"      => "STAF G4",
                  "posisiPenempatan" => "-",
                  "hp"           => "085624203225",
                  "email"        => "araspati@bankbjb.co.id",
                  "kodeGrade"    => "0085",
                  "namaGrade"    => "G4",
                  "idFungsi"     => "835",
                  "fungsiTambahan"   => "-",
                  "limitDebet"   => "0",
                  "limitKredit"  => "0",
                  "id"           => "20151002103451P0938539"
               ];

      $a =  json_encode(["status" => "success","rc" => "00", "response" => $response, "message" => "Transaction success."]);

      $json = json_decode($a, true);

      // print_r($json['response']);


      
   }

   public function proses_login_2()
   {
      $url = 'http://192.168.201.75/sip_bjb/api/User/LoginUser';
      //$url = 'https://sip-ppk.bankbjb.co.id/sip_bjb/api/User/LoginUser';
      //$url = 'http://localhost:58874/api/User/LoginUser';

      $username = $this->input->post('userid');
      $pass     = $this->input->post('password');

      $data1 = array(
         'userId'    => $username,
         'password'  => $this->generate_pass_2($pass),
      );

      $curl = curl_init();

      curl_setopt_array($curl, array(
         CURLOPT_URL => $url,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => "",
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 30000,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => "POST",
         CURLOPT_POSTFIELDS => json_encode($data1),
         CURLOPT_HTTPHEADER => array(
               // Set here requred headers
               "accept: */*",
               "accept-language: en-US,en;q=0.8",
               "content-type: application/json",
               "Authorization: bearer LQ0rEdQqF5-6nKWMeckZHiFCka494kG0Dy-EqlamNW371XoCcG5YDCv0YepdzRd9QitmOPwsyLPRxvpN3TWyir_i4JVPnkWeBmIaMj2b2hcvSa51uoYrrA95uIi75pdfBJj-dFyx0iOUwxgjGN6dlJig55kyiKBXMGpLAErl0ySQvScXgbmDTtRpoRV8P1S2HjYdqfb8bJ4x5vQdxXu2mguYUJmaRmU5VGdb865MbeWgRQJGZpNJbHmUJnd6Z6Iro59mcE1imCn1s8d9kmktS8feD4Rrfe2ClCoSzLbmXCBX50WXHxLzfoL1Iet36wvV"
         ),
      ));

      // bearer rSS7FoXjfAIjME6HUPzUSAejLqxzpyLerWbEclFdLVZUB6ZYYrzB2CXREZgxX6UzyYxDer3kIMBkU-uFCrfVlydcLS-YHeqh9gGdxXYBGJ_gyiLlm-JtCKTIssLwBOXBFvP7QvAy0RspfcpRwN07GZNhdpk3DKmpXZGJ-ncEf07z0QtsAsIVkVle7Uem7IBJkUnD-J9aCJ0icbt6Cf8ODDBPi24dagwKA6SM3v5ISjs7PLxF65JcD-ovN917mX3tzzI_iS4jnl75OIE1QucFTlFHDryu0FH9MfExOFTJYrNyWnen3-O19Ke4uYPUgOpE

      // bearer KDjG1ep6YnY5mpWjpUxg2d5YKcawvdraQstdGS0DkM317IWW7cNPv91H2x6xPR21eWPOc-H-MvMOz2WCaWMW9ZfOUhgpUc0VESJVNTLosU3Z_pl2LTjh2RBZk97INXk962M-iwPiF4ltcMNBzyU66C3_BIV8FBU_GjZwD4ShBKdJGQJcWyJY969FWu6PZ7oZhx4FHMvzmVfxPL2rEsnrD_HbCJLGAIgi51qOWNuQUjC7C6gFr39r7a5ZA8H7Bv5hop9MfKMVp2YcjHcQXfU1FnWZvWrQQz7UoWtuKvWPK24wbUJegdnHIYJY2TzxbXlB

      $response = curl_exec($curl);

      $err = curl_error($curl);

      curl_close($curl);


      // echo json_decode($response);
      $res = json_decode($response);
      
      // echo $a->email;

      // userId:username, response:r, id_log:id_log

      $data_log = ['userId'   => $username, 'response' => $res->rc, 'id_log' => $res->id_log];

      $this->buat_log($data_log);

      if ($res->rc == '00') {

         $this->buat_session($res);

         redirect('dasbor');
      
      } elseif ($res->rc == '63') {
         
         $this->session->set_flashdata('login', "<div class='alert alert-danger'>Password Salah</div>");
         $this->session->set_flashdata('userid', $username);
         redirect('auth');
         
      } elseif ($res->rc == '44') {
         
         $this->session->set_flashdata('login', "<div class='alert alert-danger'>UserId Tidak Terdaftar</div>");
         redirect('auth');
      
      } elseif ($res->rc == 'Masih ada yang aktif') {
         
         $this->session->set_flashdata('login', "<div class='alert alert-danger'>Masih ada yang aktif</div>");
         redirect('auth');
         
      } else {

         $this->session->set_flashdata('login', "<div class='alert alert-danger'>Gagal Login</div>");
         redirect('auth');
         
      }
   }

   function import(){
	
		if(isset($_FILES["file"]["name"])){
	
		   $path = $_FILES["file"]["tmp_name"];
	
		   $object = PHPExcel_IOFactory::load($path);
	
		   foreach($object->getWorksheetIterator() as $worksheet){
	
            $highestRow = $worksheet->getHighestRow();
      
            $highestColumn = $worksheet->getHighestColumn();
      
            for($row=2; $row<=$highestRow; $row++){
      
               $deal_reff     = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
               $reg_employee  = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

               // $cari = $this->model_operator->cari_data('tr_kelolaan', ['deal_reff' => $deal_reff,'reg_employee' => $reg_employee,'stat' => 1,])->num_rows();
      
               $data[] = array(
      
                  'deal_reff'       => $deal_reff,
                  'reg_employee'    => $reg_employee,
                  'stat'            => 1,
                  'add_time'        => date("Y-m-d H:i:s", now('Asia/Jakarta'))
      
               );

               // if ($cari == 0) {
               //    $this->db->insert('tr_kelolaan', $data);
               // }

      
            }
	
		  }
	
		   //   $this->excel_import_model->insert($data);

         $this->db->insert_batch('tr_kelolaan', $data);
        
	
		   echo 'Data Imported successfully';
	
		}
	
	}

}