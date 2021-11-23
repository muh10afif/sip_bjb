<?php
class Model_report extends CI_Model{

    // 06-06-2021
    public function get_list_potensi_recov($ao, $cabang, $kanwil, $segmen, $bulan, $jenis_deb)
    {
        $this->db->select('*');
        $this->db->from("report_potensi_recoveries_$jenis_deb");
        
        if ($ao != '') {
            $this->db->where('reg_employee', $ao);
        }
        if ($cabang != '') {
            $this->db->where('cabang_induk', $ao);
        }
        
        return $this->db->get();
    }

    // 07-06-2021
    public function get_list_monitoring_komit($ao, $cabang, $kanwil, $monitoring, $segmen, $bulan, $komitmen, $jenis_deb)
    {
        $this->db->select('*');
        $this->db->from("report_monitoring_komitmen_$jenis_deb");
        
        if ($ao != '') {
            $this->db->where('reg_employee', $ao);
        }
        if ($cabang != '') {
            $this->db->where('cabang_induk', $ao);
        }
        
        return $this->db->get();
    }

    // 07-06-2021
    public function get_list_kelolaan($ao, $cabang, $kanwil, $segmen, $kol, $jenis_deb)
    {
        $this->db->select('*');
        $this->db->from("report_$jenis_deb");
        
        if ($ao != '') {
            $this->db->where('reg_employee', $ao);
        }
        if ($cabang != '') {
            $this->db->where('cabang_induk', $ao);
        }
        
        return $this->db->get();
    }

    // 07-06-2021
    public function get_list_potensi_restruk($ao, $cabang, $kanwil, $segmen)
    {
        $this->db->select('*');
        $this->db->from("report_potensi_restruk");
        
        if ($ao != '') {
            $this->db->where('reg_employee', $ao);
        }
        if ($cabang != '') {
            $this->db->where('cabang_induk', $ao);
        }
        
        return $this->db->get();
    }

    // 30-04-2021
    public function count_report($segmen="", $kanwil="", $cabang_induk="", $reg_employee="", $kolektibilitas="")
    {
        $this->db->distinct();
        $this->db->select('b.kanwil, b.cabang_induk, e.reg_employee, e.name, b.segmen, b.kolektibilitas');
        $this->db->from('report_npl');
        $this->db->join('m_debitur as b', 'b.deal_reff = a.deal_reff', 'inner');
        $this->db->join('m_employee as e', 'e.reg_employee = a.reg_employee', 'inner');
        if ($segmen) {
        $this->db->where('segmen', $segmen);
        }
        if ($kanwil) {
        $this->db->where('kanwil', $kanwil);
        }
        if ($cabang_induk) {
        $this->db->where('cabang_induk', $cabang_induk);
        }
        if ($reg_employee) {
        $this->db->where('reg_employee', $reg_employee);
        }
        if ($kolektibilitas) {
        $this->db->where('kolektibilitas', $kolektibilitas);
        }
        
        $this->db->where('jenis_debitur', 'npl');
        $this->db->where('stat', 1);
        $this->db->group_by('kanwil');
        $this->db->group_by('cabang_induk');
        $this->db->group_by('reg_employee');
        $this->db->group_by('name');
        $this->db->group_by('segmen');
        $this->db->group_by('kolektibilitas');

        return $this->db->get();
        
    }

    public function get_employee($reg)
    {
        return $this->db->get_where('m_employee', array('reg_employee' => $reg));
    }

    public function cabang_1($id, $cabang)
    {
        $lvl = $this->session->userdata('level');
        $kwl = $this->session->userdata('kanwil'); 

        if ($id != null) {
            $this->db->distinct();
            $this->db->select('cabang_induk');
            $this->db->from('m_debitur');
            $this->db->where('kanwil', $id);
        } else {
            $this->db->distinct();
            $this->db->select('cabang_induk');
            $this->db->from('m_debitur');
            if ($lvl == 3) {
                $this->db->where('kanwil', $kwl);
            }
        }

        $data = $this->db->get()->result_array();

        $cabang = "<option value=''>-- Pilih Cabang --</option>";
        foreach ($data as $d){
            $a = $d['cabang_induk'];

            if ($cabang == $a) {
                $slc = 'selected';
            } else {
                $slc = '';
            }

            $cabang .= "<option value='$a' $slc>".$d['cabang_induk']."</option>";
        }

        return $cabang;
    }

    public function kanwil_1($nama_cabang, $id_kanwil)
    {
        $lvl = $this->session->userdata('level');
        $kwl = $this->session->userdata('kanwil'); 

        if ($nama_cabang != null) {
            $this->db->distinct();
            $this->db->select('kanwil');
            $this->db->from('m_debitur');
            $this->db->where('cabang_induk', $nama_cabang);
        } else {
            $this->db->distinct();
            $this->db->select('kanwil');
            $this->db->from('m_debitur');
            if ($lvl == 3) {
                $this->db->where('kanwil', $kwl);
            }
            $this->db->order_by('kanwil', 'asc');
        }

        $data = $this->db->get()->result_array();

        if ($id_kanwil != null) {
            $slc = 'selected';
        } else {
            $slc = '';
        }

        $kanwil = "<option value=''>-- Pilih Kanwil --</option>";
        foreach ($data as $d) {
            $kanwil .= "<option value='$d[kanwil]' $slc>$d[kanwil]</option>";
        }

        return $kanwil;
    }

    public function ao_1($nama_cabang,$kanwil, $id_ao)
    {
        $lvl = $this->session->userdata('level');
        $kwl = $this->session->userdata('kanwil'); 

        if ($nama_cabang != '' || $kanwil != '') {
            $this->db->select('c.name,c.reg_employee');
            $this->db->from('tr_kelolaan as a');
            $this->db->join('m_debitur as b', 'a.deal_reff = b.deal_reff', 'inner');
            $this->db->join('m_employee as c', 'a.reg_employee = c.reg_employee', 'inner');
            if ($kanwil != '') {
                $this->db->where('b.kanwil', $kanwil);
            }
            if ($nama_cabang != '') {
                $this->db->where('b.cabang_induk', $nama_cabang);
            }
            $this->db->where('a.stat', 1);
            $this->db->group_by('c.reg_employee');
            $this->db->group_by('c.name');
        } else {
            $this->db->select('c.name,c.reg_employee');
            $this->db->from('tr_kelolaan as a');
            $this->db->join('m_debitur as b', 'a.deal_reff = b.deal_reff', 'inner');
            $this->db->join('m_employee as c', 'a.reg_employee = c.reg_employee', 'inner');
            if ($lvl == 3) {
                $this->db->where('b.kanwil', $kwl);
            }
            $this->db->where('a.stat', 1);
            $this->db->group_by('c.reg_employee');
            $this->db->group_by('c.name');
        }

        $data = $this->db->get()->result_array();

        if ($id_ao != null) {
            $slc = 'selected';
        } else {
            $slc = '';
        }

        $ao = "<option value=''>-- Pilih AO --</option>";
        foreach ($data as $d) {
            $ao .= "<option value='$d[reg_employee]' $slc>$d[name]</option>";
        }

        return $ao;

    }
    
    // mengambil kanwil
    public function get_kanwil()
    {
        $this->db->distinct();
        $this->db->select('kanwil');
        $this->db->from('m_debitur');
        $this->db->order_by('kanwil', 'asc');

        return $this->db->get();
    }
    public function get_kanwil_1()
    {
        $this->db->distinct();
        $this->db->select('kanwil');
        $this->db->from('m_debitur');
        $this->db->order_by('kanwil', 'asc');

        return $this->db->get();
    }

    // mengambil macam-macam segmen
    public function get_segmen()
    {
        $this->db->distinct();
        $this->db->select('segmen');
        $this->db->from('m_debitur');
        $this->db->order_by('segmen', 'asc');

        return $this->db->get();
    }

    // mengambil data cabang
    public function get_cabang()
    {
        $this->db->distinct();
        $this->db->select('cabang_induk');
        $this->db->from('m_debitur');
        $this->db->order_by('cabang_induk', 'asc');

        return $this->db->get();
    }

    // mengambil data ao
    public function get_ao()
    {
        $this->db->select('reg_employee, name');
        $this->db->from('m_employee');
        $this->db->group_by('reg_employee')->group_by('name');

        return $this->db->get();
    }

    #################################################################################
    #########                                                               ######### 
    #########           Laporan : Monitoring Kelolaan NPL AO PPK            ######### 
    #########                                                               ######### 
    #################################################################################

    public function get_data_kol($kol)
    {
        return $this->db->get_where('m_kolektibilitas', array('id' => $kol));
    }

    public function get_mon_kom($kolom)
    {
        $this->db->distinct();
        $this->db->select($kolom);
        $this->db->from('tr_monitoring');
        $this->db->where("$kolom != ",'');

        return $this->db->get();
    }

    public function get_data_detail($jenis_deb, $debitur, $segmen, $kanwil, $cabang, $ao, $bulan, $komitmen, $monitoring , $kol, $restruk)
    {
        $kwl = $this->session->userdata('kanwil'); 
        $lvl = $this->session->userdata('level'); 

        if (empty($restruk)) {
            $this->db->select('d.kanwil, d.cabang_induk, d.kantor, d.jenis_debitur, d.outstanding as ot, d.tunggakan_pokok, k.kolektibilitas, k.id as id_kol, d.segmen, d.loan_type, d.deal_reff, d.nama, m.monitoring, m.komitmen, m.tgl_komitmen, m.nominal, e.name');
            $this->db->from('m_debitur as d');
            $this->db->join('tr_monitoring as m', 'm.deal_reff = d.deal_reff', 'inner');
            $this->db->join('m_kolektibilitas as k', 'k.id = d.kolektibilitas', 'left');
            $this->db->join('m_employee as e', 'e.reg_employee = m.reg_employee', 'inner');
            // $this->db->where('m.status', 1);
            
        } else {
            /*$this->db->select('d.kanwil, d.cabang_induk, d.kantor, d.jenis_debitur, d.outstanding as ot, k.kolektibilitas, d.segmen, d.loan_type, d.deal_reff, d.nama, m.monitoring, m.komitmen, m.tgl_komitmen, m.nominal, e.name');
            $this->db->from('m_debitur as d');
            $this->db->join('tr_monitoring as m', 'm.deal_reff = d.deal_reff', 'inner');
            $this->db->join('tr_restruct as r', 'r.deal_reff = d.deal_reff', 'right');
            $this->db->join('m_kolektibilitas as k', 'k.id = d.kolektibilitas', 'inner');
            $this->db->join('m_employee as e', 'e.reg_employee = m.reg_employee', 'right');
            $this->db->where('r.restruct', $restruk)->where('r.status', '1');
            $this->db->group_by('r.deal_reff');*/

              $this->db->select('d.kanwil, d.cabang_induk, d.kantor, d.jenis_debitur, d.outstanding as ot, d.tunggakan_pokok, k.kolektibilitas, d.segmen, d.loan_type, r.deal_reff, d.nama, e.name');
              $this->db->from('tr_monitoring as a');
              $this->db->join('m_debitur as d', 'd.deal_reff = a.deal_reff', 'inner');
              $this->db->join('tr_restruct as r', 'r.deal_reff = d.deal_reff', 'inner');
              $this->db->join('m_kolektibilitas as k', 'k.id = d.kolektibilitas', 'inner');
              $this->db->join('m_employee as e', 'e.reg_employee = a.reg_employee', 'inner');
              $this->db->where('r.restruct', 1);
              $this->db->where('r.status', 1);
              $this->db->group_by('r.deal_reff');
              $this->db->group_by('d.cabang_induk');
              $this->db->group_by('d.kanwil');
              $this->db->group_by('d.kantor');
              $this->db->group_by('d.jenis_debitur');
              $this->db->group_by('d.outstanding');
              $this->db->group_by('k.kolektibilitas');
              $this->db->group_by('d.segmen');
              $this->db->group_by('d.loan_type');
              $this->db->group_by('d.nama');
              $this->db->group_by('d.tunggakan_pokok');
              $this->db->group_by('e.name');

              /*$this->db->select('DISTINCT(r.deal_reff) as total_kelolaan');
              $this->db->from('tr_monitoring as a');
              $this->db->join('m_debitur as b', 'b.deal_reff = a.deal_reff', 'right');
              $this->db->join('tr_restruct as r', 'r.deal_reff = b.deal_reff', 'inner');
              $this->db->where('b.segmen', $segmen[$i]);
              $this->db->where('b.kanwil', $a);
              $this->db->where('b.jenis_debitur', 'npl');
              $this->db->where('r.restruct', 1);
              $this->db->where('r.status', 1);*/

        }
        
            
        $this->db->where('d.jenis_debitur', $jenis_deb);
        
        if ((!empty($kwl)) && ($lvl == 3)) {
            $this->db->where('d.kanwil', $kwl);
        } else {
            if (!empty($kanwil)) {
                $this->db->where('d.kanwil', $kanwil);
            } 
        }
        
        if (!empty($debitur) || !empty($segmen) || !empty($kanwil) || !empty($cabang) || !empty($ao) || !empty($bulan) || !empty($komitmen) || !empty($monitoring) || !empty($kol)) {

            if (!empty($debitur)) {
                $this->db->where('d.nama', $debitur);
            }
            if (!empty($segmen)) {
                $this->db->where('d.segmen', $segmen);
            }
            if (!empty($cabang)) {
                $this->db->where('d.cabang_induk', $cabang);
            }
            if (!empty($ao)) {
                $this->db->where('e.reg_employee', $ao);
            }
            if (!empty($bulan)) {
                $this->db->where("m.tgl_komitmen LIKE '%$bulan%' ");
            }
            if (!empty($komitmen)) {
                $this->db->where('m.komitmen', $komitmen);
            }
            if (!empty($monitoring)) {
                $this->db->where('m.monitoring', $monitoring);
            }
            if (!empty($kol)) {
                $this->db->where('k.id', $kol);
            }
               
        }

        return $this->db->get();
    }

    public function get_data_detail_rwo($jenis_deb, $debitur, $segmen, $kanwil, $cabang, $ao, $bulan, $komitmen, $monitoring , $kol, $restruk)
    {
        $kwl = $this->session->userdata('kanwil'); 
        $lvl = $this->session->userdata('level'); 

        $this->db->select('d.kanwil, d.cabang_induk, d.kantor, d.jenis_debitur, d.outstanding as ot, d.tunggakan_pokok, k.kolektibilitas, k.id as id_kol, d.segmen, d.loan_type, d.deal_reff, d.nama, e.name');
        $this->db->from('m_debitur as d');
        $this->db->join('m_kolektibilitas as k', 'k.id = d.kolektibilitas', 'left');
        $this->db->join('tr_kelolaan as t', 't.deal_reff = d.deal_reff', 'inner');
        $this->db->join('m_employee as e', 'e.reg_employee = t.reg_employee', 'inner');
        $this->db->where('t.stat', 1);
            
        $this->db->where('d.jenis_debitur', $jenis_deb);
        
        if ((!empty($kwl)) && ($lvl == 3)) {
            $this->db->where('d.kanwil', $kwl);
        } else {
            if (!empty($kanwil)) {
                $this->db->where('d.kanwil', $kanwil);
            } 
        }
        
        if (!empty($debitur) || !empty($segmen) || !empty($kanwil) || !empty($cabang) || !empty($ao) || !empty($kol)) {

            if (!empty($debitur)) {
                $this->db->where('d.nama', $debitur);
            }
            if (!empty($segmen)) {
                $this->db->where('d.segmen', $segmen);
            }
            if (!empty($cabang)) {
                $this->db->where('d.cabang_induk', $cabang);
            }
            if (!empty($ao)) {
                $this->db->where('e.reg_employee', $ao);
            }
            if (!empty($kol)) {
                $this->db->where('k.id', $kol);
            }
               
        }

        return $this->db->get();
    }

    public function get_debitur($jenis)
    {
        $this->db->select('nama');
        $this->db->from('m_debitur');
        $this->db->where('jenis_debitur', $jenis);
        $this->db->group_by('nama');
        $this->db->order_by('nama', 'asc');

        return $this->db->get();
    }

    // mengambil kolektibilitas 3, 4, 5
    public function get_kol()
    {
        $this->db->from('m_kolektibilitas');
        $this->db->where('id BETWEEN 3 and 5');

        return $this->db->get();
    }

    // mencari kanwil
    public function get_kanwil_5($kanwil, $jns_debitur)
    {
        /*
        SELECT segmen, COUNT(d.segmen) as jumlah
        FROM tr_kelolaan as k
        left JOIN m_debitur as d ON d.deal_reff = k.deal_reff
        WHERE d.kanwil = 'Kanwil 1' and jenis_debitur = 'npl'
        GROUP BY segmen
        */

        $this->db->select('segmen, count(d.segmen) as jml_segmen');
        $this->db->from('tr_kelolaan as k');
        $this->db->join('m_debitur as d', 'd.deal_reff = k.deal_reff', 'left');
        $this->db->where('d.kanwil', $kanwil)->where('d.jenis_debitur', $jns_debitur);
        $this->db->group_by('d.segmen');

        return $this->db->get();
    }

    // untuk total nominal per kanwil
    public function get_data_npl_ao($kanwil)
    {
        $this->db->select('sum(m.nominal) as tot_nominal, segmen');
        $this->db->from('m_debitur as d');
        $this->db->join('tr_monitoring as m', 'm.deal_reff = d.deal_reff', 'left');
        $this->db->where('d.kanwil', $kanwil)->where('d.jenis_debitur', 'npl');
        $this->db->group_by('segmen');

        $hasil = $this->db->get()->result_array();

        $seg_komersial = 0;
        $seg_konsumer = 0;
        $seg_kpr = 0;
        $seg_bpr = 0;
        $seg_mikro = 0;
        foreach ($hasil as $h) {
            $tot_nominal = $h['tot_nominal'];
            $segmen      = $h['segmen'];

            if ($segmen == 'Divisi Komersial') {
                $seg_komersial = $tot_nominal;
            } elseif ($segmen == 'Divisi Konsumer') {
                $seg_konsumer = $tot_nominal;
            }elseif ($segmen == 'Divisi KPR') {
                $seg_kpr = $tot_nominal;
            }elseif ($segmen == 'Divisi Kredit BPR & LKM') {
                $seg_bpr = $tot_nominal;
            }elseif ($segmen == 'Divisi Mikro') {
                $seg_mikro = $tot_nominal;
            }

        }
            $kanwil_j    = $kanwil; 

        $value[] = [
            'seg_komersial' => $seg_komersial,
            'seg_konsumer'  => $seg_konsumer,
            'seg_kpr'       => $seg_kpr,
            'seg_bpr'       => $seg_bpr,
            'seg_mikro'     => $seg_mikro,
            'kanwil'        => $kanwil_j
        ];
        
        return $value;
    }

    // untuk total nominal per cabang kanwil
    public function get_npl_ao_korwil_cabang($kanwil)
    {
        $this->db->select('cabang_induk');
        $this->db->from('m_debitur');
        $this->db->where('jenis_debitur', 'npl')->where('kanwil', $kanwil);
        $this->db->group_by('cabang_induk');
        $this->db->order_by('cabang_induk', 'asc');

        $cab = $this->db->get()->result_array();

        foreach ($cab as $c) {
            $cab = $c['cabang_induk'];

            $this->db->select('cabang_induk, sum(m.nominal) as tot_nominal_cabang, segmen, d.kanwil');
            $this->db->from('m_debitur as d');
            $this->db->join('tr_monitoring as m', 'm.deal_reff = d.deal_reff', 'left');
            $this->db->where('d.kanwil', $kanwil)->where('d.jenis_debitur', 'npl')->where('d.cabang_induk',$cab);
            $this->db->group_by('d.segmen');
            $this->db->group_by('d.cabang_induk');
            $this->db->order_by('d.cabang_induk', 'asc');

            $hasil = $this->db->get()->result_array();

            $seg_komersial = 0;
            $seg_konsumer = 0;
            $seg_kpr = 0;
            $seg_bpr = 0;
            $seg_mikro = 0;
            foreach ($hasil as $h) {
                $tot_nominal = $h['tot_nominal_cabang'];
                $cabang      = $h['cabang_induk'];
                $segmen      = $h['segmen'];
                $kanwil      = $h['kanwil'];

                if ($segmen == 'Divisi Komersial') {
                    $seg_komersial = $tot_nominal;
                } elseif ($segmen == 'Divisi Konsumer') {
                    $seg_konsumer = $tot_nominal;
                }elseif ($segmen == 'Divisi KPR') {
                    $seg_kpr = $tot_nominal;
                }elseif ($segmen == 'Divisi Kredit BPR & LKM') {
                    $seg_bpr = $tot_nominal;
                }elseif ($segmen == 'Divisi Mikro') {
                    $seg_mikro = $tot_nominal;
                }

            }
                $value[] = [
                    'seg_komersial' => $seg_komersial,
                    'seg_konsumer'  => $seg_konsumer,
                    'seg_kpr'       => $seg_kpr,
                    'seg_bpr'       => $seg_bpr,
                    'seg_mikro'     => $seg_mikro,
                    'cab'           => $cabang,
                    'kanwil'        => $kanwil
                ];
        }

        return $value;

    }

    // untuk total nominal per kanwil AO
    public function get_npl_ao_1($kanwil)
    {
        $this->db->select('e.name');
        $this->db->from('tr_monitoring as m');
        $this->db->join('m_employee as e', 'm.reg_employee = e.reg_employee', 'left');
        $this->db->join('m_debitur as d', 'd.deal_reff = m.deal_reff', 'left');
        $this->db->where('e.kanwil', $kanwil)->where('d.jenis_debitur', 'npl');
        $this->db->group_by('e.name');

        $nama_e = $this->db->get()->result_array();

        $value = array();
        foreach ($nama_e as $n) {
            $n = $n['name'];

            $this->db->select('cabang_induk');
            $this->db->from('m_debitur');
            $this->db->where('jenis_debitur', 'npl')->where('kanwil', $kanwil);
            $this->db->group_by('cabang_induk');
            $this->db->order_by('cabang_induk', 'asc');

            $cabang = $this->db->get()->result_array();

            foreach ($cabang as $c) {
                $cab = $c['cabang_induk'];

                $this->db->select('e.name, sum(m.nominal) as tot_nominal_ao, d.segmen');
                $this->db->from('m_employee as e');
                $this->db->join('tr_monitoring as m', 'm.reg_employee = e.reg_employee', 'left');
                $this->db->join('m_debitur as d', 'd.deal_reff = m.deal_reff', 'left');
                $this->db->where('e.kanwil', $kanwil)->where('d.jenis_debitur', 'npl')->where('e.name', $n);
                $this->db->where('e.cabang_induk', $cab);
                $this->db->group_by('e.name');
                $this->db->group_by('d.segmen');

                $data = $this->db->get()->result_array();

                $seg_komersial  = 0;
                $seg_konsumer   = 0;
                $seg_kpr        = 0;
                $seg_bpr        = 0;
                $seg_mikro      = 0;
                $nama           = '';

                foreach ($data as $o) {
                    $nama           = $o['name'];
                    $tot_nominal_ao = $o['tot_nominal_ao'];
                    $segmen         = $o['segmen'];

                    if ($segmen == 'Divisi Komersial') {
                        $seg_komersial = $tot_nominal_ao;
                    } elseif ($segmen == 'Divisi Konsumer') {
                        $seg_konsumer = $tot_nominal_ao;
                    }elseif ($segmen == 'Divisi KPR') {
                        $seg_kpr = $tot_nominal_ao;
                    }elseif ($segmen == 'Divisi Kredit BPR & LKM') {
                        $seg_bpr = $tot_nominal_ao;
                    }elseif ($segmen == 'Divisi Mikro') {
                        $seg_mikro = $tot_nominal_ao;
                    }

                }
                $value[] = [
                    'seg_komersial' => $seg_komersial,
                    'seg_konsumer'  => $seg_konsumer,
                    'seg_kpr'       => $seg_kpr,
                    'seg_bpr'       => $seg_bpr,
                    'seg_mikro'     => $seg_mikro,
                    'nama'          => $nama,
                    'kanwil'        => $kanwil
                ];
                
            }
            
        return $value;
        }



    }

    public function get_npl_ao($kanwil)
    {
        $this->db->select('e.name');
        $this->db->from('tr_monitoring as m');
        $this->db->join('m_employee as e', 'm.reg_employee = e.reg_employee', 'left');
        $this->db->join('m_debitur as d', 'd.deal_reff = m.deal_reff', 'left');
        $this->db->where('e.kanwil', $kanwil)->where('d.jenis_debitur', 'npl');
        $this->db->group_by('e.name');

        $nama_e = $this->db->get()->result_array();

        $value = array();
        foreach ($nama_e as $n) {
            $ne = $n['name'];

            $this->db->select('e.name, sum(m.nominal) as tot_nominal_ao, d.segmen');
            $this->db->from('m_employee as e');
            $this->db->join('tr_monitoring as m', 'm.reg_employee = e.reg_employee', 'left');
            $this->db->join('m_debitur as d', 'd.deal_reff = m.deal_reff', 'left');
            $this->db->where('e.kanwil', $kanwil)->where('d.jenis_debitur', 'npl')->where('e.name', $ne);
            $this->db->group_by('e.name');
            $this->db->group_by('d.segmen');

            $data = $this->db->get()->result_array();

            $seg_komersial  = 0;
            $seg_konsumer   = 0;
            $seg_kpr        = 0;
            $seg_bpr        = 0;
            $seg_mikro      = 0;
            $nama           = '';

            foreach ($data as $o) {
                $nama           = $o['name'];
                $tot_nominal_ao = $o['tot_nominal_ao'];
                $segmen         = $o['segmen'];

                if ($segmen == 'Divisi Komersial') {
                    $seg_komersial = $tot_nominal_ao;
                } elseif ($segmen == 'Divisi Konsumer') {
                    $seg_konsumer = $tot_nominal_ao;
                }elseif ($segmen == 'Divisi KPR') {
                    $seg_kpr = $tot_nominal_ao;
                }elseif ($segmen == 'Divisi Kredit BPR & LKM') {
                    $seg_bpr = $tot_nominal_ao;
                }elseif ($segmen == 'Divisi Mikro') {
                    $seg_mikro = $tot_nominal_ao;
                }

            }

            $value[] = [
                'seg_komersial' => $seg_komersial,
                'seg_konsumer'  => $seg_konsumer,
                'seg_bpr'       => $seg_bpr,
                'seg_kpr'       => $seg_kpr,
                'seg_mikro'     => $seg_mikro,
                'nama'          => $nama,
                'kanwil'        => $kanwil
            ];
        
        }

        return $value;


    }

    #################################################################################
    #########                                                               ######### 
    #########      Akhir Laporan : Monitoring Kelolaan NPL AO PPK           ######### 
    #########                                                               ######### 
    #################################################################################

    #################################################################################
    #########                                                               ######### 
    #########           Laporan : Monitoring Kelolaan WO AO PPK             ######### 
    #########                                                               ######### 
    #################################################################################

    // mengambil kolektibilitas
    public function get_kol_wo()
    {
        $this->db->from('m_kolektibilitas');
        $this->db->where('id != 3');
        $this->db->where('id != 4');
        $this->db->where('id != 5');

        return $this->db->get();
    }

    // untuk total nominal per kanwil
    public function get_data_wo_ao($kanwil)
    {
        $this->db->select('sum(m.nominal) as tot_nominal, segmen');
        $this->db->from('m_debitur as d');
        $this->db->join('tr_monitoring as m', 'm.deal_reff = d.deal_reff', 'left');
        $this->db->where('d.kanwil', $kanwil)->where('d.jenis_debitur', 'wo');
        $this->db->group_by('segmen');

        $hasil = $this->db->get()->result_array();

        $seg_komersial  = 0;
        $seg_konsumer   = 0;
        $seg_kpr        = 0;
        $seg_bpr        = 0;
        $seg_mikro      = 0;

        foreach ($hasil as $h) {
            $tot_nominal = $h['tot_nominal'];
            $segmen      = $h['segmen'];

            if ($segmen == 'Divisi Komersial') {
                $seg_komersial = $tot_nominal;
            } elseif ($segmen == 'Divisi Konsumer') {
                $seg_konsumer = $tot_nominal;
            }elseif ($segmen == 'Divisi KPR') {
                $seg_kpr = $tot_nominal;
            }elseif ($segmen == 'Divisi Kredit BPR & LKM') {
                $seg_bpr = $tot_nominal;
            }elseif ($segmen == 'Divisi Mikro') {
                $seg_mikro = $tot_nominal;
            }

        }

        $kanwil_j    = $kanwil; 

        $value[] = [
            'seg_komersial' => $seg_komersial,
            'seg_konsumer'  => $seg_konsumer,
            'seg_kpr'       => $seg_kpr,
            'seg_bpr'       => $seg_bpr,
            'seg_mikro'     => $seg_mikro,
            'kanwil'        => $kanwil_j
        ];
        
        return $value;
    }

    // untuk total nominal per cabang kanwil
    public function get_wo_ao_korwil_cabang($kanwil)
    {
        $this->db->select('cabang_induk');
        $this->db->from('m_debitur');
        $this->db->where('jenis_debitur', 'wo')->where('kanwil', $kanwil);
        $this->db->group_by('cabang_induk');
        $this->db->order_by('cabang_induk', 'asc');

        $cab = $this->db->get()->result_array();

        foreach ($cab as $c) {
            $cab1 = $c['cabang_induk'];

            $this->db->select('cabang_induk, sum(m.nominal) as tot_nominal_cabang, segmen, d.kanwil');
            $this->db->from('m_debitur as d');
            $this->db->join('tr_monitoring as m', 'm.deal_reff = d.deal_reff', 'left');
            $this->db->where('d.kanwil', $kanwil)->where('d.jenis_debitur', 'wo')->where('d.cabang_induk',$cab1);
            $this->db->group_by('d.segmen');
            $this->db->group_by('d.cabang_induk');
            $this->db->order_by('d.cabang_induk', 'asc');

            $hasil = $this->db->get()->result_array();

            $seg_komersial = 0;
            $seg_konsumer = 0;
            $seg_kpr = 0;
            $seg_bpr = 0;
            $seg_mikro = 0;
            foreach ($hasil as $h) {
                $tot_nominal = $h['tot_nominal_cabang'];
                $cabang      = $h['cabang_induk'];
                $segmen      = $h['segmen'];
                $kanwil      = $h['kanwil'];

                if ($segmen == 'Divisi Komersial') {
                    $seg_komersial = $tot_nominal;
                } elseif ($segmen == 'Divisi Konsumer') {
                    $seg_konsumer = $tot_nominal;
                }elseif ($segmen == 'Divisi KPR') {
                    $seg_kpr = $tot_nominal;
                }elseif ($segmen == 'Divisi Kredit BPR & LKM') {
                    $seg_bpr = $tot_nominal;
                }elseif ($segmen == 'Divisi Mikro') {
                    $seg_mikro = $tot_nominal;
                }

            }
                $value[] = [
                    'seg_komersial' => $seg_komersial,
                    'seg_konsumer'  => $seg_konsumer,
                    'seg_kpr'       => $seg_kpr,
                    'seg_bpr'       => $seg_bpr,
                    'seg_mikro'     => $seg_mikro,
                    'cab'           => $cabang,
                    'kanwil'        => $kanwil
                ];
        }

        return $value;

    }

    // untuk total nominal per kanwil AO
    public function get_wo_ao($kanwil)
    {
        $this->db->select('e.name');
        $this->db->from('tr_monitoring as m');
        $this->db->join('m_employee as e', 'm.reg_employee = e.reg_employee', 'left');
        $this->db->join('m_debitur as d', 'd.deal_reff = m.deal_reff', 'left');
        $this->db->where('e.kanwil', $kanwil)->where('d.jenis_debitur', 'wo');
        $this->db->group_by('e.name');

        $nama_e = $this->db->get()->result_array();

        $value = array();
        foreach ($nama_e as $n) {
            $ne = $n['name'];

            $this->db->select('e.name, sum(m.nominal) as tot_nominal_ao, d.segmen');
            $this->db->from('m_employee as e');
            $this->db->join('tr_monitoring as m', 'm.reg_employee = e.reg_employee', 'left');
            $this->db->join('m_debitur as d', 'd.deal_reff = m.deal_reff', 'left');
            $this->db->where('e.kanwil', $kanwil)->where('d.jenis_debitur', 'wo')->where('e.name', $ne);
            $this->db->group_by('e.name');
            $this->db->group_by('d.segmen');

            $data = $this->db->get()->result_array();

            $seg_komersial  = 0;
            $seg_konsumer   = 0;
            $seg_kpr        = 0;
            $seg_bpr        = 0;
            $seg_mikro      = 0;
            $nama           = '';

            foreach ($data as $o) {
                $nama           = $o['name'];
                $tot_nominal_ao = $o['tot_nominal_ao'];
                $segmen         = $o['segmen'];

                if ($segmen == 'Divisi Komersial') {
                    $seg_komersial = $tot_nominal_ao;
                } elseif ($segmen == 'Divisi Konsumer') {
                    $seg_konsumer = $tot_nominal_ao;
                }elseif ($segmen == 'Divisi KPR') {
                    $seg_kpr = $tot_nominal_ao;
                }elseif ($segmen == 'Divisi Kredit BPR & LKM') {
                    $seg_bpr = $tot_nominal_ao;
                }elseif ($segmen == 'Divisi Mikro') {
                    $seg_mikro = $tot_nominal_ao;
                }

            }

            $value[] = [
                'seg_komersial' => $seg_komersial,
                'seg_konsumer'  => $seg_konsumer,
                'seg_bpr'       => $seg_bpr,
                'seg_kpr'       => $seg_kpr,
                'seg_mikro'     => $seg_mikro,
                'nama'          => $nama,
                'kanwil'        => $kanwil
            ];
        
        }

        return $value;

    }

    #################################################################################
    #########                                                               ######### 
    #########      Akhir Laporan : Monitoring Kelolaan WO AO PPK            ######### 
    #########                                                               ######### 
    #################################################################################

    #################################################################################
    #########                                                               ######### 
    #########         Laporan : Monitoring Potensi Restrukturisasi          ######### 
    #########                                                               ######### 
    #################################################################################

    // untuk total nominal per kanwil
    public function get_restruk_kanwil($kanwil)
    {
        $this->db->select('sum(m.nominal) as tot_nominal, segmen');
        $this->db->from('m_debitur as d');
        $this->db->join('tr_monitoring as m', 'm.deal_reff = d.deal_reff', 'left');
        $this->db->join('tr_restruct as r', 'r.deal_reff = m.deal_reff', 'left');
        $this->db->where('d.kanwil', $kanwil)->where('d.jenis_debitur', 'npl')->where('r.restruct', '1');
        $this->db->group_by('segmen');

        $hasil = $this->db->get()->result_array();

        $seg_komersial  = 0;
        $seg_konsumer   = 0;
        $seg_kpr        = 0;
        $seg_bpr        = 0;
        $seg_mikro      = 0;

        foreach ($hasil as $h) {
            $tot_nominal = $h['tot_nominal'];
            $segmen      = $h['segmen'];

            if ($segmen == 'Divisi Komersial') {
                $seg_komersial = $tot_nominal;
            } elseif ($segmen == 'Divisi Konsumer') {
                $seg_konsumer = $tot_nominal;
            }elseif ($segmen == 'Divisi KPR') {
                $seg_kpr = $tot_nominal;
            }elseif ($segmen == 'Divisi Kredit BPR & LKM') {
                $seg_bpr = $tot_nominal;
            }elseif ($segmen == 'Divisi Mikro') {
                $seg_mikro = $tot_nominal;
            }

        }

        $kanwil_j    = $kanwil; 

        $value[] = [
            'seg_komersial' => $seg_komersial,
            'seg_konsumer'  => $seg_konsumer,
            'seg_kpr'       => $seg_kpr,
            'seg_bpr'       => $seg_bpr,
            'seg_mikro'     => $seg_mikro,
            'kanwil'        => $kanwil_j
        ];
        
        return $value;
    }

    // untuk total nominal per cabang kanwil
    public function get_restruk_cabang($kanwil)
    {
        /*$this->db->select('cabang_induk');
        $this->db->from('m_debitur');
        $this->db->where('jenis_debitur', 'npl')->where('kanwil', $kanwil);
        $this->db->group_by('cabang_induk');
        $this->db->order_by('cabang_induk', 'asc');*/

        $this->db->select('cabang_induk');
        $this->db->from('tr_restruct as r');
        $this->db->join('m_debitur as d', 'd.deal_reff = r.deal_reff', 'left');
        $this->db->where('d.kanwil', $kanwil)->where('d.jenis_debitur', 'npl');
        $this->db->group_by('d.cabang_induk');
        $this->db->order_by('d.cabang_induk', 'asc');

        $cab = $this->db->get()->result_array();

        $value = array();

        foreach ($cab as $c) {
            $cab1 = $c['cabang_induk'];

            $this->db->select('cabang_induk, sum(m.nominal) as tot_nominal_cabang, segmen, d.kanwil');
            $this->db->from('m_debitur as d');
            $this->db->join('tr_monitoring as m', 'm.deal_reff = d.deal_reff', 'left');
            $this->db->join('tr_restruct as r', 'r.deal_reff = m.deal_reff', 'left');
            $this->db->where('d.kanwil', $kanwil)->where('d.jenis_debitur', 'npl')->where('r.restruct', '1')->where('d.cabang_induk',$cab1);
            $this->db->group_by('d.segmen');
            $this->db->group_by('d.cabang_induk');
            $this->db->order_by('d.cabang_induk', 'asc');

            $hasil = $this->db->get()->result_array();

            $seg_komersial = 0;
            $seg_konsumer = 0;
            $seg_kpr = 0;
            $seg_bpr = 0;
            $seg_mikro = 0;
            $cabang = '';
            foreach ($hasil as $h) {
                $tot_nominal = $h['tot_nominal_cabang'];
                $cabang      = $h['cabang_induk'];
                $segmen      = $h['segmen'];
                $kanwil      = $h['kanwil'];

                if ($segmen == 'Divisi Komersial') {
                    $seg_komersial = $tot_nominal;
                } elseif ($segmen == 'Divisi Konsumer') {
                    $seg_konsumer = $tot_nominal;
                }elseif ($segmen == 'Divisi KPR') {
                    $seg_kpr = $tot_nominal;
                }elseif ($segmen == 'Divisi Kredit BPR & LKM') {
                    $seg_bpr = $tot_nominal;
                }elseif ($segmen == 'Divisi Mikro') {
                    $seg_mikro = $tot_nominal;
                }

            }
                $value[] = [
                    'seg_komersial' => $seg_komersial,
                    'seg_konsumer'  => $seg_konsumer,
                    'seg_kpr'       => $seg_kpr,
                    'seg_bpr'       => $seg_bpr,
                    'seg_mikro'     => $seg_mikro,
                    'cab'           => $cabang,
                    'kanwil'        => $kanwil
                ];
        }
        return $value;


    }

    // untuk total nominal per kanwil AO
    public function get_restruk_ao($kanwil)
    {
        $this->db->select('e.name');
        $this->db->from('tr_monitoring as m');
        $this->db->join('m_employee as e', 'm.reg_employee = e.reg_employee', 'left');
        $this->db->join('m_debitur as d', 'd.deal_reff = m.deal_reff', 'left');
        $this->db->where('e.kanwil', $kanwil)->where('d.jenis_debitur', 'npl');
        $this->db->group_by('e.name');

        $nama_e = $this->db->get()->result_array();

        $value = array();
        foreach ($nama_e as $n) {
            $ne = $n['name'];

            $this->db->select('e.name, sum(m.nominal) as tot_nominal_ao, d.segmen');
            $this->db->from('m_employee as e');
            $this->db->join('tr_monitoring as m', 'm.reg_employee = e.reg_employee', 'left');
            $this->db->join('m_debitur as d', 'd.deal_reff = m.deal_reff', 'left');
            $this->db->join('tr_restruct as r', 'r.deal_reff = m.deal_reff', 'left');
            $this->db->where('e.kanwil', $kanwil)->where('d.jenis_debitur', 'npl')->where('r.restruct', '1')->where('e.name', $ne);
            $this->db->group_by('e.name');
            $this->db->group_by('d.segmen');

            $data = $this->db->get()->result_array();

            $seg_komersial  = 0;
            $seg_konsumer   = 0;
            $seg_kpr        = 0;
            $seg_bpr        = 0;
            $seg_mikro      = 0;
            $nama           = '';

            foreach ($data as $o) {
                $nama           = $o['name'];
                $tot_nominal_ao = $o['tot_nominal_ao'];
                $segmen         = $o['segmen'];

                if ($segmen == 'Divisi Komersial') {
                    $seg_komersial = $tot_nominal_ao;
                } elseif ($segmen == 'Divisi Konsumer') {
                    $seg_konsumer = $tot_nominal_ao;
                }elseif ($segmen == 'Divisi KPR') {
                    $seg_kpr = $tot_nominal_ao;
                }elseif ($segmen == 'Divisi Kredit BPR & LKM') {
                    $seg_bpr = $tot_nominal_ao;
                }elseif ($segmen == 'Divisi Mikro') {
                    $seg_mikro = $tot_nominal_ao;
                }

            }

            $value[] = [
                'seg_komersial' => $seg_komersial,
                'seg_konsumer'  => $seg_konsumer,
                'seg_bpr'       => $seg_bpr,
                'seg_kpr'       => $seg_kpr,
                'seg_mikro'     => $seg_mikro,
                'nama'          => $nama,
                'kanwil'        => $kanwil
            ];
        
        }

        return $value;

    }

    #################################################################################
    #########                                                               ######### 
    #########      Akhir Laporan : Monitoring Potensi Restrukturisasi       ######### 
    #########                                                               ######### 
    #################################################################################
   
}