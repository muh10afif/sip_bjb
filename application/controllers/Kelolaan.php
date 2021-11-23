<?php

class Kelolaan extends CI_Controller{

        function __construct(){
            parent::__construct();
            $this->load->library(array('pagination', 'Cek_login_lib'));
            $this->cek_login_lib->logged_in();
            $this->load->model(array('model_kelolaan','M_monitoring'));

            $array = array(
                'hitung_deb' => $this->M_monitoring->get_jml_data_monitoring($this->session->userdata('tgl_skrg'), $this->session->userdata('tgl_min_3'))->num_rows(),
                'data_debb'  => $this->M_monitoring->get_data_monitoring_2($this->session->userdata('tgl_skrg'), $this->session->userdata('tgl_min_3'))->result_array()
            );
            
            $this->session->set_userdata( $array );

            ini_set('max_execution_time', 0); 
        }

    public function testes()
    {
        // $db="bjb_080121";

        // $connectionInfo = array( "UID"=>'sa',                            
        //                         "PWD"=>'digital',                            
        //                         "Database"=>$db); 

        // $kon = sqlsrv_connect('localhost',$connectionInfo);

        // $sql="SELECT a.*, b.kolektibilitas, b.outstanding FROM tr_kelolaan a INNER JOIN m_debitur b ON (a.deal_reff = b.deal_reff) WHERE a.stat = 1 AND b.jenis_debitur='npl'";

        // //Mengeksekusi/menjalankan query diatas	
        // $a = sqlsrv_query($kon,$sql)->result_array();

        // print_r($a);
        
    }
    
    function data($jenis = 'npl'){

        $j = strtoupper($jenis);
       
        $data = array(  'title' => "Transaksi Atur Kelolaan $j",
                        'isi'   => 'kelolaan/lihat_data',
                        'menu'  => 'kelolaan'
                    );
        $data['rcd']        =   $this->model_kelolaan->tampil_employee();

        if ($jenis == 'npl') {
            //$data['record']     = $this->model_kelolaan->tampilkan_data_kel('npl');
            $data['aktif']      = 'npl';
        } else {
            //$data['record']     = $this->model_kelolaan->tampilkan_data_kel('wo');
            $data['aktif']      = 'wo';
        }

        $a = strtoupper($jenis);
        $data['jenis'] = "Status Debitur $a";

        $data['kanwil']         = $this->model_kelolaan->get_kanwil($jenis)->result_array();
        $data['cabang']         = $this->model_kelolaan->get_cabang_2($jenis)->result_array();
        $data['ao']             = $this->model_kelolaan->get_ao($jenis)->result_array();
        $data['sess_level']     = $this->session->userdata('level');
        $data['sess_kanwil']    = $this->session->userdata('kanwil');

        $limit = 10;
        $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $data['list']      = $this->model_kelolaan->get_debitur_list($limit, $start, $jenis)->result_array();
        $data['next']      = $start + 10;
        $data['prev']      = $start - 10;
        $data['start']     = $start;
        $data['total']     = $this->model_kelolaan->jumlah_debitur($jenis);

        $this->load->view('layout/wrapper',$data);
    }

    // 26-01-21
    public function tampil_kelolaan()
    {
        $jenis  = $this->input->post('jenis');
        $status = $this->input->post('status');
        $kanwil = $this->input->post('kanwil');
        $cabang = $this->input->post('cabang');
        $ao     = $this->input->post('ao');

        $dt = ['jenis'  => $jenis,
               'status' => $status,
               'kanwil' => $kanwil,
               'cabang' => $cabang,
               'ao'     => $ao
              ];
        
        $list = $this->model_kelolaan->get_data_kelolaan_2($dt);

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($o['ao'] == null) {
                $s_ao = '<div align="center"><button type="button" class="btn btn-sm btn-warning tambah_kelolaan" style="margin-right: 5px;" deal_reff="'.$o['deal_reff'].'" jenis="'.$jenis.'" kanwil="'.$o['kanwil'].'" cabang_induk="'.$o['cabang_induk'].'" nama="'.$o['nama'].'" jenis_debitur="'.$jenis.'">Tambahkan</button>';
            } else {
                $s_ao = '<div align="center">'.$o['ao'].'</div>';
            }

            $aksi = '<button class="btn btn-sm btn-info detail" nama="'.$o['nama'].'" alamat="'.$o['alamat'].'" telepon="'.$o['telepon'].'" handphone="'.$o['handphone'].'" kanwil="'.$o['kanwil'].'" cabang_induk="'.$o['cabang_induk'].'" kantor="'.$o['kantor'].'" ao="'.$o['ao'].'" deal_reff="'.$o['deal_reff'].'" cif="'.$o['cif'].'" segmen="'.$o['segmen'].'" loan_type="'.$o['loan_type'].'" plafond="'.number_format($o['plafond'],0,'.','.').'" outstanding="'.number_format($o['outstanding'],0,'.','.').'" tunggakan_pokok="'.number_format($o['tunggakan_pokok'],0,'.','.').'">Detail</button>';

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = $o['nama'];
            $tbody[]    = $o['alamat'];
            $tbody[]    = $o['kanwil'];
            $tbody[]    = $o['cabang_induk'];
            $tbody[]    = $o['deal_reff'];
            $tbody[]    = $s_ao;
            $tbody[]    = $aksi;
            $data[]     = $tbody;
        }

        $output = [ "draw"              => $_POST['draw'],
                    "recordsTotal"      => $this->model_kelolaan->jumlah_semua_kelolaan_2($dt),
                    "recordsFiltered"   => $this->model_kelolaan->jumlah_filter_kelolaan_2($dt),   
                    "data"              => $data,
                ];

        echo json_encode($output);
    }

    function json($jenis){
        $this->load->library('datatables');

        // $this->db->select('a.*, a.deal_reff as deal, b.reg_employee, c.name as n_e, b.*');
        
        $this->datatables->select('a.latitude, a.nama, a.cif, a.alamat, a.kanwil, a.cabang_induk, a.kantor, a.segmen, a.loan_type, a.deal_reff, a.plafond, a.outstanding, c.name, a.logitude, a.restruct');
        $this->datatables->from('m_debitur as a');
        $this->datatables->join('tr_kelolaan as b', 'a.deal_reff = b.deal_reff', 'left');
        $this->datatables->join('m_employee as c', 'c.reg_employee = b.reg_employee', 'left');
        $this->datatables->where('a.jenis_debitur', $jenis);
        return print_r($this->datatables->generate());
    }

    public function get_data_kelolaan($jenis)
    {
        $list = $this->model_kelolaan->get_datatables($jenis);
        $data = array();
        
        $no = $_POST['start'];
        foreach ($list as $r) {

            $no++;
            $row = array();
            $row[] = "<center>$no<center>";
            $row[] = $r->nama;
            $row[] = $r->cif;
            $row[] = $r->alamat;
            $row[] = $r->kanwil;
            $row[] = $r->cabang_induk;
            $row[] = $r->kantor;
            $row[] = $r->segmen;
            $row[] = $r->loan_type;
            $row[] = $r->deal;
            $row[] = $r->plafond;
            $row[] = $r->outstanding;
            $row[] = $r->n_e;

            if ($r->reg_employee != null) {
                $row[] = '<span class="label label-success">Sudah Masuk Kelolaan</span>';
            } else {
                $row[] = '<span class="label label-danger">Belum Masuk Kelolaan</span>';
            }
            
            if ($r->reg_employee == null){ 
                $row[]  ='<a href="'.base_url().'kelolaan/tambah/'.$r->deal.'/'.$jenis.'" class="label label-warning">Tambahkan</a>';
            } else {
                $row[]  = ' ';
            }

            $data[] = $row;
            
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal"      => $this->model_kelolaan->count_all($jenis),
                        "recordsFiltered"   => $this->model_kelolaan->count_filtered($jenis),
                        "data" => $data
                );
        //output to json format
        echo json_encode($output);
    }

    function tambah($deal_reff, $jenis){
        $data = array(  'title' => 'Form Tambahkan Data Kelolaan',
                        'isi'   => 'kelolaan/tambah_kelolaan',
                        'menu'  => 'kelolaan'
                    );
        //$data['rcd'] = $this->model_kelolaan->ambil_debitur($deal_reff);

        $hasil = $this->model_kelolaan->ambil_debitur($deal_reff);

            $data['rcd'] = $hasil->deal_reff;
            $cabang      = $hasil->cabang_induk;

            $data['record'] = $this->model_kelolaan->tampil_kelolaan_em($cabang)->result();

            $data['jenis'] = $jenis;

        //$data['record'] = $this->model_kelolaan->tampil_employee();
        $this->load->view('layout/wrapper',$data);
    }

    // 06-01-2021
    public function ambil_ao()
    {
        $cabang = $this->input->post('cabang_induk');

        $cb = $this->model_kelolaan->tampil_kelolaan_em($cabang)->result_array();

        $option = "";

        if (empty($cb)) {
            $option = "<option value=''>-- AO Tidak Ada --</option>";
        } else {

            $option .= "<option value=''>-- Pilih AO --</option>";
            foreach ($cb as $c) {
                $option .= '<option value="'.$c['reg_employee'].'">'.$c['name'].'</option>';
            } 

        }

        echo json_encode(['option' => $option]);
    }

    // 06-01-2021
    public function simpan_kelolaan()
    {
        $reg        = $this->input->post('reg_employee');
        $deal_reff  = $this->input->post('deal_reff');
        $jenis      = $this->input->post('jenis_debitur');

        $cari = $this->M_monitoring->cari_data('tr_kelolaan', ['deal_reff' => $deal_reff, 'stat' => 1])->num_rows();

        if ($cari == 0) {
            $data = [
                    'reg_employee'  => $reg,
                    'deal_reff'     => $deal_reff,
                    'stat'          => 1
                ];

            $this->model_kelolaan->post($data);

            $simpan = 'sukses';
        } else {
            $simpan = 'gagal';
        }
         
        $ao         = $this->model_kelolaan->get_ao($jenis)->result_array();

        $option = "";

        $option .= "<option value=''>-- Pilih AO --</option>";
        foreach ($ao as $c) {
            $option .= '<option value="'.$c['reg_employee'].'">'.$c['name'].'</option>';
        } 

        echo json_encode(['status' => $simpan, 'option' => $option]);
    }

    function post($jenis)
    {
        if(isset($_POST['submit'])){
            $reg = $this->input->post('reg_employee');
            $deal_reff = $this->input->post('deal_reff');
            $stat = 1;
            $data = array(
                'reg_employee'=>$reg,
                'deal_reff'=>$deal_reff,
                'stat'=>$stat
            );
            $this->model_kelolaan->post($data);
            redirect("kelolaan/data/$jenis");
        }
        else{
            //$this->load->view('kategori/form_input');
             $data = array(  'title' => 'Tambah Data',
                        'isi'   => 'kategori/form_input',
                        'menu'  => 'kelolaan'
                        );
             $this->load->view('layout/wrapper',$data);
        }
    }
    
    function tf_kelolaan($jenis = 'npl')
    {
        $j = strtoupper($jenis);

        $data = array(  'title' => "Transaksi Transfer Kelolaan $j",
                        'isi'   => 'kelolaan/tf_kelolaan',
                        'menu'  => 'tf_kelolaan'
                    );
        $data['rcd']        =   $this->model_kelolaan->tampil_employee();
        if ($jenis == 'npl') {
            $data['record']     =   $this->model_kelolaan->tampilkan_tf('npl');
            $data['aktif']      = 'npl';
        } else {
            $data['record']     =   $this->model_kelolaan->tampilkan_tf('wo');
            $data['aktif']      = 'wo';
        }

        $a = strtoupper($jenis);
        $data['jenis'] = "Status Debitur $a";
        
        $this->load->view('layout/wrapper',$data);
    }

    function tf_kelolaan_update($deal_reff, $jenis){
        $data = array(  'title' => 'Data Kelolaan',
                        'isi'   => 'kelolaan/tambah_tf_kelolaan',
                        'menu'  => 'tf_kelolaan'
                    );

        /*$data['rcd'] = $this->model_kelolaan->ambil_tr_kelolaan($deal_reff);
        $data['record'] = $this->model_kelolaan->tampil_employee();*/

        $hasil = $this->model_kelolaan->ambil_tr_kelolaan($deal_reff);

        $data['id']  = $hasil->id;
        $data['rcd'] = $hasil->deal_reff;
        $cabang      = $hasil->cabang_induk;

        $data['record'] = $this->model_kelolaan->tampil_kelolaan_em($cabang)->result();

        $data['jenis'] = $jenis;

        $this->load->view('layout/wrapper',$data);
    }

    function update($jenis)
    {
        if(isset($_POST['submit'])){
            $stat       = 1;
            $id         = $this->input->post('id');
            $reg        = $this->input->post('reg_employee');
            $deal_reff  = $this->input->post('deal_reff');

            $cari = $this->M_monitoring->cari_data('tr_kelolaan', ['deal_reff' => $deal_reff, 'stat' => 1])->num_rows();

            if ($cari == 0) {
                $data = array(
                    'stat'          =>$stat,
                    'reg_employee'  => $reg,
                    'deal_reff'     => $deal_reff
                );

                $this->db->insert('tr_kelolaan', $data);

                $data_u = array(
                    'stat'  => '88'
                );
                
                $this->model_kelolaan->update($data_u,$id);
            }
            
            redirect("kelolaan/tf_kelolaan/$jenis");
        }
        else{
            //$this->load->view('kategori/form_input');
             $data = array(  'title' => 'Tambah Data',
                        'isi'   => 'kategori/form_input',
                        'menu'  => 'tf_kelolaan'
                    );
             $this->load->view('layout/wrapper',$data);
        }
    }

    function pengajuan_kelolaan($jenis = 'npl')
    {
        $j = strtoupper($jenis);

        $data = array(  'title' => "Transaksi Pengajuan Kelolaan $j",
                        'isi'   => 'kelolaan/pengajuan_kelolaan',
                        'menu'  => 'pengajuan_kelolaan'
                    );
        if ($jenis == 'npl') {
            $data['record']     = $this->model_kelolaan->tampilkan_pengajuan('npl');
            $data['aktif']      = 'npl';
        } else {
            $data['record']     = $this->model_kelolaan->tampilkan_pengajuan('wo');
            $data['aktif']      = 'wo';
        }

        $a = strtoupper($jenis);
        $data['jenis'] = "Status Debitur $a";
        
        $this->load->view('layout/wrapper',$data);
    }

    function proses($id, $jenis)
    {
        $data = array('title'   =>  'Proses',
                      'isi'     =>  'kelolaan/proses_tf_kelolaan',
                      'menu'    => 'pengajuan_kelolaan'
                  );

        $data['rcd']    = $this->model_kelolaan->get_proses($id)->row_array();
        $data['jenis']  = $jenis;

        $this->load->view('layout/wrapper',$data);
    }

    function proses_kelola($jenis)
    {
        $id     = $this->input->post('id');
        $status = $this->input->post('stat');
        $deal   = $this->input->post('deal');

        $data = array( 'stat'=> $status );

        if ($status == 2) {
            $stat = 1;
        } else {
            $stat = 0;
        }

        $dataUp = array( 'stat'=> $stat );

        $this->model_kelolaan->simpan_proses($data,$id);
        $this->model_kelolaan->update_tf($dataUp,$deal);

        redirect("kelolaan/pengajuan_kelolaan/$jenis");
    }

    public function tes()
    {
        $this->db->DISTINCT();
        $this->db->SELECT('cabang_induk');
        $this->db->FROM('m_debitur');
            $this->db->where('jenis_debitur', 'npl');

        print_r($this->db->get()->result_array());
    }

    function atur_otomatis($jenis)
    {
        $list_ao        = array();
        $list_debitur   = array();
        $deal_reff      = '';
        $cabang         = '';

        $this->db->DISTINCT();
        $this->db->SELECT('cabang_induk');
        $this->db->FROM('m_debitur');
        $this->db->where('jenis_debitur', $jenis);
        $hasil = $this->db->get()->result_array();

        foreach($hasil as $r)
        {
            $cabang = $r['cabang_induk'];

            $this->db->SELECT('deal_reff');
            $this->db->FROM('m_debitur');
            $this->db->WHERE('cabang_induk',$cabang);
            $this->db->where('jenis_debitur', $jenis);
            $this->db->limit(5);
            $hasil2 = $this->db->get()->result_array();
            unset($list_debitur);
            $list_debitur = array();
            if($hasil2 != null)
            {
                foreach($hasil2 as $r2)
                {
                    $deal_reff = $r2['deal_reff'];
                    array_push($list_debitur, $deal_reff);
                }
            }

            $this->db->SELECT('e.reg_employee');
            $this->db->FROM('m_employee as e');
            $this->db->join('m_user as u', 'u.reg_employee = e.reg_employee', 'left');
            $this->db->WHERE('e.cabang_induk',$cabang);
            $this->db->where('u.level', 4);
            $this->db->where('u.active', 1);
            $this->db->order_by('e.reg_employee', 'asc');
            $hasil3 = $this->db->get()->result_array();
            unset($list_ao);
            $list_ao = array();
            if($hasil3 != null)
            {
                foreach($hasil3 as $r3)
                {
                    $reg_employee = $r3['reg_employee'];
                    array_push($list_ao, $reg_employee);
                }
            }

            $index = 0;
            $stat = 1;
            if(count($list_debitur) > 0 && count($list_ao) > 0)
            {
                for ($i = 0; $i < count($list_debitur); $i++) 
                {
                    $data = array(  'reg_employee'  => $list_ao[$index],
                                    'deal_reff'     => $list_debitur[$i],
                                    'stat'          => $stat);

                    $this->db->SELECT('*');
                    $this->db->FROM('tr_kelolaan');
                    $this->db->WHERE('deal_reff', $list_debitur[$i]);
                    $hasil = $this->db->get()->num_rows();

                    if($hasil == 0)
                    {
                        $this->db->insert('tr_kelolaan',$data);
                    }

                    if($index < count($list_ao) - 1)
                    {
                        $index++;
                    }
                    else
                    {
                        $index = 0;
                    }
                }
            }
        }

        redirect("kelolaan/data/$jenis");
    }
}