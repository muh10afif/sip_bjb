<?php
class Model_kelolaan extends CI_Model{

    // 26-01-21
    public function get_kanwil($jenis)
    {
        $this->db->select('a.kanwil');
        $this->db->from('m_debitur as a');
        $this->db->where('a.jenis_debitur', $jenis);
        $kanwil = $this->session->userdata('kanwil');
        $level  = $this->session->userdata('level');
        if ($level == 3) {
            $this->db->where('a.kanwil', $kanwil);
        }
        $this->db->group_by('a.kanwil');
        $this->db->order_by('a.kanwil', 'asc');
        
        return $this->db->get();
    }

    // 26-01-21
    public function get_cabang_2($jenis)
    {
        $this->db->select('a.cabang_induk');
        $this->db->from('m_debitur as a');
        $this->db->where('a.jenis_debitur', $jenis);
        $kanwil = $this->session->userdata('kanwil');
        $level  = $this->session->userdata('level');
        if ($level == 3) {
            $this->db->where('a.kanwil', $kanwil);
        }
        $this->db->group_by('a.cabang_induk');
        $this->db->order_by('a.cabang_induk', 'asc');
        
        return $this->db->get();
    }

    // 26-01-21
    public function get_ao($jenis)
    {
        $this->db->select('e.name, e.reg_employee');
        $this->db->from('m_debitur as d');
        $this->db->join('tr_kelolaan as k', 'k.deal_reff = d.deal_reff', 'inner');
        $this->db->join('m_employee as e', 'e.reg_employee = k.reg_employee', 'inner');
        $this->db->where('d.jenis_debitur', $jenis);
        $kanwil = $this->session->userdata('kanwil');
        $level  = $this->session->userdata('level');
        if ($level == 3) {
            $this->db->where('d.kanwil', $kanwil);
        }
        
        $this->db->group_by('e.name');
        $this->db->group_by('e.reg_employee');
        $this->db->order_by('e.name', 'asc');
        
        return $this->db->get();
    }

    // 26-01-21
    public function get_data_kelolaan_2($dt)
    {
        $this->_get_datatables_query_kelolaan_2($dt);

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_kelolaan_2 = [null, 'a.nama', 'a.alamat', 'a.kanwil', 'a.cabang_induk', 'a.deal_reff'];
    var $kolom_cari_kelolaan_2  = ['LOWER(a.nama)', 'LOWER(a.alamat)', 'LOWER(a.kanwil)', 'LOWER(a.cabang_induk)', 'a.deal_reff'];
    var $order_kelolaan_2       = ['a.nama' => 'asc'];

    public function _get_datatables_query_kelolaan_2($dt)
    {
        if ($dt['ao'] != '') {
            $wh = $dt['ao'];

            $this->db->select("a.nama, a.alamat, a.telepon, a.handphone, a.kanwil, a.cabang_induk, a.kantor, a.deal_reff, a.cif, a.segmen, a.loan_type, a.plafond, a.outstanding, a.tunggakan_pokok, (SELECT c.name FROM tr_kelolaan as t LEFT JOIN m_employee as c ON c.reg_employee = t.reg_employee WHERE t.deal_reff = a.deal_reff AND t.stat = 1 AND c.name = '$wh') as ao");
        } else {
            $wh = "";

            $this->db->select("a.nama, a.alamat, a.telepon, a.handphone, a.kanwil, a.cabang_induk, a.kantor, a.deal_reff, a.cif, a.segmen, a.loan_type, a.plafond, a.outstanding, a.tunggakan_pokok, (SELECT c.name FROM tr_kelolaan as t LEFT JOIN m_employee as c ON c.reg_employee = t.reg_employee WHERE t.deal_reff = a.deal_reff AND t.stat = 1 $wh) as ao");
        }

        $this->db->from('m_debitur as a');
        if ($dt['ao'] != '') {
            $this->db->join('tr_kelolaan as t', 't.deal_reff = a.deal_reff', 'left');
            $this->db->join('m_employee as e','e.reg_employee = t.reg_employee', 'left');
            $this->db->where('t.stat', 1);
            $this->db->where("(SELECT c.name FROM tr_kelolaan as t LEFT JOIN m_employee as c ON c.reg_employee = t.reg_employee WHERE t.deal_reff = a.deal_reff AND t.stat = 1) = '$wh'", null, false);
            
        }
        $this->db->where('a.jenis_debitur', $dt['jenis']);
        $kanwil = $this->session->userdata('kanwil');
        $level  = $this->session->userdata('level');
        if ($level == 3) {
            $this->db->where('a.kanwil', $kanwil);
        } else {
            if ($dt['kanwil'] != '') {
                $this->db->where('a.kanwil', $dt['kanwil']);
            }
        }
        if ($dt['cabang'] != '') {
            $this->db->where('a.cabang_induk', $dt['cabang']);
        }
        if ($dt['status'] != '') {
            if ($dt['status'] == 0) {
                $this->db->where("(SELECT TOP 1 c.name FROM tr_kelolaan as t LEFT JOIN m_employee as c ON c.reg_employee = t.reg_employee WHERE t.deal_reff = a.deal_reff AND t.stat = 1) IS NULL", null, false);
            } else {
                $this->db->where("(SELECT TOP 1 c.name FROM tr_kelolaan as t LEFT JOIN m_employee as c ON c.reg_employee = t.reg_employee WHERE t.deal_reff = a.deal_reff AND t.stat = 1) IS NOT NULL", null, false);
            }
        }
        
        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_kelolaan_2;

        foreach ($kolom_cari as $cari) {
            if ($input_cari) {
                if ($b === 0) {
                    $this->db->group_start();
                    $this->db->like($cari, $input_cari);
                } else {
                    $this->db->or_like($cari, $input_cari);
                }

                if ((count($kolom_cari) - 1) == $b ) {
                    $this->db->group_end();
                }
            }

            $b++;
        }

        if (isset($_POST['order'])) {

            $kolom_order = $this->kolom_order_kelolaan_2;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_kelolaan_2)) {
            
            $order = $this->order_kelolaan_2;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_kelolaan_2($dt)
    {
        if ($dt['ao'] != '') {
            $wh = $dt['ao'];

            $this->db->select("a.nama, a.alamat, a.telepon, a.handphone, a.kanwil, a.cabang_induk, a.kantor, a.deal_reff, a.cif, a.segmen, a.loan_type, a.plafond, a.outstanding, a.tunggakan_pokok, (SELECT c.name FROM tr_kelolaan as t LEFT JOIN m_employee as c ON c.reg_employee = t.reg_employee WHERE t.deal_reff = a.deal_reff AND t.stat = 1 AND c.name = '$wh') as ao");
        } else {
            $wh = "";

            $this->db->select("a.nama, a.alamat, a.telepon, a.handphone, a.kanwil, a.cabang_induk, a.kantor, a.deal_reff, a.cif, a.segmen, a.loan_type, a.plafond, a.outstanding, a.tunggakan_pokok, (SELECT c.name FROM tr_kelolaan as t LEFT JOIN m_employee as c ON c.reg_employee = t.reg_employee WHERE t.deal_reff = a.deal_reff AND t.stat = 1 $wh) as ao");
        }

        $this->db->from('m_debitur as a');
        if ($dt['ao'] != '') {
            $this->db->join('tr_kelolaan as t', 't.deal_reff = a.deal_reff', 'left');
            $this->db->join('m_employee as e','e.reg_employee = t.reg_employee', 'left');
            $this->db->where('t.stat', 1);
            $this->db->where("(SELECT c.name FROM tr_kelolaan as t LEFT JOIN m_employee as c ON c.reg_employee = t.reg_employee WHERE t.deal_reff = a.deal_reff AND t.stat = 1) = '$wh'", null, false);
            
        }
        $this->db->where('a.jenis_debitur', $dt['jenis']);
        $kanwil = $this->session->userdata('kanwil');
        $level  = $this->session->userdata('level');
        if ($level == 3) {
            $this->db->where('a.kanwil', $kanwil);
        } else {
            if ($dt['kanwil'] != '') {
                $this->db->where('a.kanwil', $dt['kanwil']);
            }
        }
        if ($dt['cabang'] != '') {
            $this->db->where('a.cabang_induk', $dt['cabang']);
        }
        if ($dt['status'] != '') {
            if ($dt['status'] == 0) {
                $this->db->where("(SELECT TOP 1 c.name FROM tr_kelolaan as t LEFT JOIN m_employee as c ON c.reg_employee = t.reg_employee WHERE t.deal_reff = a.deal_reff AND t.stat = 1) IS NULL", null, false);
            } else {
                $this->db->where("(SELECT TOP 1 c.name FROM tr_kelolaan as t LEFT JOIN m_employee as c ON c.reg_employee = t.reg_employee WHERE t.deal_reff = a.deal_reff AND t.stat = 1) IS NOT NULL", null, false);
            }
        }

        return $this->db->count_all_results();
    }

    public function jumlah_filter_kelolaan_2($dt)
    {
        $this->_get_datatables_query_kelolaan_2($dt);

        return $this->db->get()->num_rows();
        
    }

  ###########################################################
  /////////// AWAL BAGIAN AMBIL DATA SERVER SIDE ////////////
  ###########################################################

  var $column_order   = array('a.nama', 'a.cif', 'a.alamat', 'a.kanwil', 'a.cabang_induk','a.kantor','a.segmen','a.loan_type', 'a.deal_reff', 'a.plafond', 'a.outstanding', 'c.name');

  var $column_search  = array('a.nama', 'a.cif', 'a.alamat', 'a.kanwil', 'a.cabang_induk','a.kantor','a.segmen','a.loan_type', 'a.deal_reff', 'a.plafond', 'a.outstanding', 'c.name'); 

  var $order = array('a.nama' => 'ASC'); 


  private function _get_datatables_query($jenis)
    {         
        $this->db->select('a.*, a.deal_reff as deal, b.reg_employee, c.name as n_e, b.*');
        $this->db->from('m_debitur as a');
        $this->db->join('tr_kelolaan as b', 'a.deal_reff = b.deal_reff', 'left');
        $this->db->join('m_employee as c', 'c.reg_employee = b.reg_employee', 'left');
        $this->db->where('a.jenis_debitur', $jenis);

        $i = 0;
     
        foreach ($this->column_search as $item)
        {
            if($_POST['search']['value'])
            {
                 
                if($i===0)
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
         
        if(isset($_POST['order']))
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables($jenis)
    {
        $this->_get_datatables_query($jenis);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($jenis)
    {
        $this->_get_datatables_query($jenis);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($jenis)
    {           
        $this->db->select('a.*, a.deal_reff as deal, b.reg_employee, c.name as n_e, b.*');
        $this->db->from('m_debitur as a');
        $this->db->join('tr_kelolaan as b', 'a.deal_reff = b.deal_reff', 'left');
        $this->db->join('m_employee as c', 'c.reg_employee = b.reg_employee', 'left');
        $this->db->where('a.jenis_debitur', $jenis);

        return $this->db->count_all_results();
    }

    // 30-12-2020
    // public function get_debitur_list($limit, $start, $jenis)
    // {
    //     $this->db->select('a.*, a.deal_reff as deal, b.reg_employee, c.name as n_e, b.*');
    //     $this->db->from('m_debitur as a');
    //     $this->db->join('tr_kelolaan as b', 'a.deal_reff = b.deal_reff', 'left');
    //     $this->db->join('m_employee as c', 'c.reg_employee = b.reg_employee', 'left');
    //     $this->db->where('a.jenis_debitur', $jenis);
    //     $kanwil = $this->session->userdata('kanwil');
    //     $level  = $this->session->userdata('level');
    //     if ($level == 3) {
    //         $this->db->where('a.kanwil', $kanwil);
    //     }
    //     $this->db->limit($limit);
    //     $this->db->offset($start);
        
        
    //     return $this->db->get();   
    // }

    public function get_debitur_list($limit, $start, $jenis)
    {
        $this->db->select('a.*, a.deal_reff as deal,  (SELECT TOP 1 c.name FROM tr_kelolaan as t LEFT JOIN m_employee as c ON c.reg_employee = t.reg_employee WHERE t.deal_reff = a.deal_reff AND t.stat = 1 ) as ao');
        $this->db->from('m_debitur as a');
        $this->db->where('a.jenis_debitur', $jenis);
        $kanwil = $this->session->userdata('kanwil');
        $level  = $this->session->userdata('level');
        if ($level == 3) {
            $this->db->where('a.kanwil', $kanwil);
        }
        $this->db->limit($limit);
        $this->db->offset($start);
        
        
        return $this->db->get();   
    }

    public function get_debitur_list_2($jenis)
    {
        $this->db->select('a.*, a.deal_reff as deal, b.reg_employee, c.name as n_e, b.*');
        $this->db->from('m_debitur as a');
        $this->db->join('tr_kelolaan as b', 'a.deal_reff = b.deal_reff', 'left');
        $this->db->join('m_employee as c', 'c.reg_employee = b.reg_employee', 'left');
        $this->db->where('a.jenis_debitur', $jenis);
        
        return $this->db->get();   
    }

    public function jumlah_debitur($jenis)
    {
        $this->db->select('a.*, a.deal_reff as deal, b.reg_employee, c.name as n_e, b.*');
        $this->db->from('m_debitur as a');
        $this->db->join('tr_kelolaan as b', 'a.deal_reff = b.deal_reff', 'left');
        $this->db->join('m_employee as c', 'c.reg_employee = b.reg_employee', 'left');
        $this->db->where('a.jenis_debitur', $jenis);
        $kanwil = $this->session->userdata('kanwil');
        $level  = $this->session->userdata('level');
        if ($level == 3) {
            $this->db->where('a.kanwil', $kanwil);
        }

        return $this->db->count_all_results();
    }
 
    ###########################################################
    ////////// PENUTUP BAGIAN AMBIL DATA SERVER SIDE //////////
    ###########################################################
    
 function tampilkan_data(){
        
        return $this->db->get('m_debitur');
    }
    
  function tampilkan_data_kel($jenis)
  {
    if ($jenis == 'npl') {
      $query = "SELECT a.*,a.deal_reff as deal,b.reg_employee,c.name as n_e, b.* FROM m_debitur a LEFT JOIN tr_kelolaan b ON(a.deal_reff = b.deal_reff) LEFT JOIN m_employee c ON (b.reg_employee = c.reg_employee) WHERE a.jenis_debitur = 'npl'";
    } else {
      $query = "SELECT a.*,a.deal_reff as deal,b.reg_employee,c.name as n_e,  b.* FROM m_debitur a LEFT JOIN tr_kelolaan b ON(a.deal_reff = b.deal_reff) LEFT JOIN m_employee c ON (b.reg_employee = c.reg_employee) WHERE a.jenis_debitur = 'wo'";
    }
    
    return $this->db->query($query);
  }

  function tampilkan_tf($jenis)
  {
    if ($jenis == 'npl') {
        $jn = 'npl';
    } else {
        $jn = 'wo';
    }

    $kanwil = $this->session->userdata('kanwil');
    $level  = $this->session->userdata('level');
    if ($level == 3) {
        // $this->db->where('a.kanwil', $kanwil);
        $a = "and a.kanwil = '$kanwil'";
    } else {
        $a = "";
    }

    $query = "SELECT a.nama, a.cif, a.nama, a.alamat, a.kanwil, a.cabang_induk, a.kantor, a.plafond ,a.deal_reff as deal,b.reg_employee,b.id as idl, b.stat FROM m_debitur a LEFT JOIN tr_kelolaan b ON(a.deal_reff = b.deal_reff) left join tr_transfer_kelolaan as k ON (k.reg_ao = b.reg_employee) WHERE a.jenis_debitur = '$jn' $a and b.stat = 0 GROUP BY a.deal_reff, a.nama, a.cif, a.alamat, a.kanwil, a.cabang_induk, a.kantor, a.plafond, b.stat, b.reg_employee, b.id";

    // if ($jenis == 'npl') {
    //     $query = "SELECT a.*,a.deal_reff as deal,b.reg_employee,b.id as idl, b.* FROM m_debitur a LEFT JOIN tr_kelolaan b ON(a.deal_reff = b.deal_reff) left join tr_transfer_kelolaan as k ON k.reg_ao = b.reg_employee WHERE a.jenis_debitur = 'npl' and b.stat = 0 GROUP BY a.deal_reff, a.nama, a.cif, a.alamat, a.telepon, a.kanwil, a.cabang_induk, a.kantor, a.segmen, a.loan_type,";
    // } else {
    //     $query = "SELECT a.*,a.deal_reff as deal,b.reg_employee,b.id as idl, b.* FROM m_debitur a LEFT JOIN tr_kelolaan b ON(a.deal_reff = b.deal_reff) left join tr_transfer_kelolaan as k ON k.reg_ao = b.reg_employee WHERE a.jenis_debitur = 'wo' and b.stat = 0 GROUP BY a.deal_reff";
    // }
   
    return $this->db->query($query);
  }

  function ambil_tr_kelolaan($deal_reff)
  {
    $query = "SELECT * FROM tr_kelolaan as t JOIN m_debitur as d ON d.deal_reff = t.deal_reff WHERE id = $deal_reff ";
    return $this->db->query($query)->row();
  }

  function tampil_employee()
  {
      return $this->db->query("select * from m_employee");
  }

  public function tampil_kelolaan_em($cabang)
  {
    $this->db->from('m_employee');
    $this->db->where('cabang_induk', $cabang);
    $this->db->order_by('name', 'asc');
    
    return $this->db->get();
  }

  function ambil_debitur($deal_reff)
  {
      $this->db->FROM('m_debitur');
      $this->db->WHERE('deal_reff',$deal_reff);
      return $this->db->get()->row();
  }
  
  function tampilkan_pengajuan($jenis)
  {
      $this->db->SELECT('a.*,a.stat as sts,b.id as ida, c.*, d.*');
      $this->db->FROM('tr_transfer_kelolaan a');
      $this->db->JOIN('tr_kelolaan b','b.id = a.id_kelolaan','INNER');
      $this->db->JOIN('m_debitur c','b.deal_reff = c.deal_reff','INNER');
      $this->db->JOIN('m_employee d','d.reg_employee = b.reg_employee','INNER');
      if ($jenis == 'npl') {
        $this->db->where('c.jenis_debitur', 'npl');
      } else {
        $this->db->where('c.jenis_debitur', 'wo');
      }

        $kanwil = $this->session->userdata('kanwil');
        $level  = $this->session->userdata('level');
        if ($level == 3) {
            $this->db->where('c.kanwil', $kanwil);
        }

      return $this->db->get();
  }
    
    function post($data){
        $this->db->insert('tr_kelolaan',$data);
    }

    function get_proses($id)
    {
        $this->db->SELECT('a.*,a.id as ida, d.*, c.*');
        $this->db->FROM('tr_transfer_kelolaan a');
        $this->db->JOIN('tr_kelolaan b','b.id = a.id_kelolaan','INNER');
        $this->db->JOIN('m_debitur c','b.deal_reff = c.deal_reff','INNER');
        $this->db->JOIN('m_employee d','d.reg_employee = b.reg_employee','INNER');
        $this->db->WHERE('a.id_kelolaan',$id);
        $this->db->where('a.stat', 0);

        return $this->db->get();
    }

    function update($data,$id)
    {
        $this->db->where('id',$id);
        $this->db->update('tr_kelolaan',$data);
    }

    function update_tf($data,$id)
    {
        $this->db->where('deal_reff',$id);
        $this->db->update('tr_kelolaan',$data);
    }

    function simpan_proses($data,$id)
    {
        $this->db->where('id',$id);
        $this->db->update('tr_transfer_kelolaan',$data);
    }
    
    function get_one($id)
    {
        $param  =   array('kategori_id'=>$id);
        return $this->db->get_where('kategori_barang',$param);
    }
    
    
    function delete($id)
    {
        $this->db->where('kategori_id',$id);
        $this->db->delete('kategori_barang');
    }
}