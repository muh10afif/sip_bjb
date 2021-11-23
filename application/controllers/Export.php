<?php
class Export extends CI_Controller{   
        
       private $filename = "import_data"; // Kita tentukan nama filenya

    public function __construct() {
        parent::__construct();
        $this->load->library('Cek_login_lib');
        $this->cek_login_lib->logged_in();
        $this->load->model(array('model_export','M_monitoring'));

        $array = array(
            'hitung_deb' => $this->M_monitoring->get_jml_data_monitoring($this->session->userdata('tgl_skrg'), $this->session->userdata('tgl_min_3'))->num_rows(),
            'data_debb'  => $this->M_monitoring->get_data_monitoring_2($this->session->userdata('tgl_skrg'), $this->session->userdata('tgl_min_3'))->result_array()
        );
        
        $this->session->set_userdata( $array );
    }

   public function form(){
        $data = array(); // Buat variabel $data sebagai array

        $data = ['menu' => 'export_npl'];
        
        if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
            // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
            $upload = $this->model_export->upload_file($this->filename);
            
            if($upload['result'] == "success"){ // Jika proses upload sukses
                // Load plugin PHPExcel nya
                include APPPATH.'third_party/PHPExcel/PHPExcel.php';
                
                $excelreader = new PHPExcel_Reader_Excel2007();
                $loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang tadi diupload ke folder excel
                $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
                
                // Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
                // Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
                $data['sheet'] = $sheet; 
            }else{ // Jika proses upload gagal
                $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
            }
        }
        $this->load->view('export/import_data', $data);
    }

    public function simpan(){
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        
        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang telah diupload ke folder excel
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
        
        $this->model_export->truncate();
        // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
        $data = array();
        $jenis = "npl";
        $numrow = 1;
        foreach($sheet as $row){
            if($numrow > 1){

                $asal_start = $row['K'];
                $baru_start = date("Y-m-d", strtotime($asal_start)); 

                $asal_mate  = $row['L'];
                $baru_mate  = date("Y-m-d", strtotime($asal_mate));

                $plafond            = str_replace(',', '', $row['M']);
                $outstanding        = str_replace(',', '', $row['N']);
                $dpd                = str_replace(',', '', $row['P']);
                $tunggakan_pokok    = str_replace(',', '', $row['Q']);
                $tunggakan_bunga    = str_replace(',', '', $row['R']);

                // Kita push (add) array data ke variabel data
                array_push($data, array(
                    'nama'              => $row['A'], 
                    'cif'               => $row['B'],
                    'alamat'            => $row['C'],
                    'telepon'           => $row['D'],
                    'kanwil'            => $row['E'],
                    'cabang_induk'      => $row['F'],
                    'kantor'            => $row['G'],
                    'segmen'            => $row['H'],
                    'loan_type'         => $row['I'],
                    'deal_reff'         => $row['J'],
                    'start_date'        => $baru_start,
                    'mat_date'          => $baru_mate,
                    'plafond'           => $plafond,
                    'outstanding'       => $outstanding,
                    'kolektibilitas'    => $row['O'],
                    'dpd'               => $dpd,
                    'tunggakan_pokok'   => $tunggakan_pokok,
                    'tunggakan_bunga'   => $tunggakan_bunga,
                    'jenis_debitur'     => $jenis
                ));
            }


            
            $numrow++; // Tambah 1 setiap kali looping
        }

        // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
        $this->model_export->insert_multiple($data);
        
        redirect("kelolaan/data"); // Redirect ke halaman awal (ke controller siswa fungsi index)
    }

    public function formWO(){
        $data = array(); // Buat variabel $data sebagai array

        $data = ['menu' => 'export_wo'];
        
        if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
            // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
            $upload = $this->model_export->upload_file($this->filename);
            
            if($upload['result'] == "success"){ // Jika proses upload sukses
                // Load plugin PHPExcel nya
                include APPPATH.'third_party/PHPExcel/PHPExcel.php';
                
                $excelreader = new PHPExcel_Reader_Excel2007();
                $loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang tadi diupload ke folder excel
                $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
                
                // Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
                // Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
                $data['sheet'] = $sheet; 
            }else{ // Jika proses upload gagal
                $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
            }
        }
        $this->load->view('export/import_dataWO', $data);
    }

    public function simpanWO(){
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        
        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang telah diupload ke folder excel
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
        
        //$this->model_export->truncate();
        // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
        $data = array();
        $jenis = 'wo';
        $numrow = 1;
        foreach($sheet as $row){
            if($numrow > 1){


                $asal_start = $row['K'];
                $baru_start = date("Y-m-d", strtotime($asal_start)); 

                $asal_mate  = $row['L'];
                $baru_mate  = date("Y-m-d", strtotime($asal_mate));

                $tgl_wo     = $row['M'];
                $baru_tgl_wo= date("Y-m-d", strtotime($tgl_wo));

                $plafond            = str_replace(',', '', $row['N']);
                $tunggakan_pokok    = str_replace(',', '', $row['O']);
                $bunga_lapor        = str_replace(',', '', $row['P']);
                $bunga_ekstra       = str_replace(',', '', $row['Q']);
                $denda              = str_replace(',', '', $row['R']);

                // Kita push (add) array data ke variabel data
                array_push($data, array(
                    'nama'              => $row['A'],
                    'cif'               => $row['B'],
                    'alamat'            => $row['C'],
                    'telepon'           => $row['D'],
                    'kanwil'            => $row['E'],
                    'cabang_induk'      => $row['F'],
                    'kantor'            => $row['G'],
                    'segmen'            => $row['H'],
                    'loan_type'         => $row['I'],
                    'deal_reff'         => $row['J'],
                    'start_date'        => $baru_start,
                    'mat_date'          => $baru_mate,
                    'tgl_wo'            => $baru_tgl_wo,
                    'plafond'           => $plafond,
                    'tunggakan_pokok'   => $tunggakan_pokok,
                    'bunga_lapor'       => $bunga_lapor,
                    'bunga_ekstra'      => $bunga_ekstra,
                    'denda'             => $denda,
                    'jenis_debitur'     => $jenis

                ));
            }
            
            $numrow++; // Tambah 1 setiap kali looping
        }

        // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
        $this->model_export->insert_multiple($data);
        
        redirect("kelolaan/data/wo"); // Redirect ke halaman awal (ke controller siswa fungsi index)
    }
    
}