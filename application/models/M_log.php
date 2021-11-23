<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_log extends CI_Model {

    
    public function __construct()
    {
        parent::__construct();
        $this->id_level = $this->session->userdata('level');
        $this->kanwil   = $this->session->userdata('kanwil');
    }
    

    public function cari_user_id()
    {
        $this->db->select('u.email as user_id, e.name');
        $this->db->from('log_request as l');
        $this->db->join('m_user as u', 'u.email = l.userId', 'inner');
        $this->db->join('m_employee as e', 'e.reg_employee = u.reg_employee', 'inner');

        // $this->db->select('u.email as user_id, r.name');
        // $this->db->from('m_user as u');
        // $this->db->join('m_employee as r', 'r.reg_employee = u.reg_employee', 'inner');

        if ($this->id_level == 3) {
            $this->db->where('r.kanwil', $this->kanwil);
        }

        $this->db->group_by('u.email');
        $this->db->group_by('e.name');
        
        return $this->db->get();
    }

    public function get_data_log_req($dt)
    {
        $this->_get_datatables_query_log_req($dt);

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_log_req = [null, 'l.userId', 'l.response', 'l.action', 'CAST(l.created_at as varchar)', 'l.status'];
    var $kolom_cari_log_req  = ['LOWER(l.userId)', 'LOWER(l.response)', 'LOWER(l.action)', 'CAST(l.created_at as VARCHAR)', 'CAST(l.status as VARCHAR)'];
    var $order_log_req       = ['CAST(l.created_at as VARCHAR)' => 'desc'];

    public function _get_datatables_query_log_req($dt)
    {
        // SELECT l.*
        // FROM log_request as l 
        // INNER JOIN m_user as u ON u.email = l.userId
        // INNER JOIN m_employee as e ON e.reg_employee = u.reg_employee
        // WHERE e.kanwil = 'kanwil 1'

        $this->db->select('l.*');
        $this->db->from('log_request as l');
        $this->db->join('m_user as u', 'u.email = l.userId', 'inner');
        $this->db->join('m_employee as e', 'e.reg_employee = u.reg_employee', 'inner');

        if ($this->id_level == 3) {
            $this->db->where('e.kanwil', $this->kanwil);
        }

        if ($dt['user_id'] != '') {
            $this->db->where('l.userId', $dt['user_id']);
        }
        
        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_log_req;

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

            $kolom_order = $this->kolom_order_log_req;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_log_req)) {
            
            $order = $this->order_log_req;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_log_req($dt)
    {
        $this->db->select('l.*');
        $this->db->from('log_request as l');
        $this->db->join('m_user as u', 'u.email = l.userId', 'inner');
        $this->db->join('m_employee as e', 'e.reg_employee = u.reg_employee', 'inner');

        if ($this->id_level == 3) {
            $this->db->where('e.kanwil', $this->kanwil);
        }

        if ($dt['user_id'] != '') {
            $this->db->where('l.userId', $dt['user_id']);
        }

        return $this->db->count_all_results();
    }

    public function jumlah_filter_log_req($dt)
    {
        $this->_get_datatables_query_log_req($dt);

        return $this->db->get()->num_rows();
        
    }

    // 28-07-2021
    public function get_data_log_uim()
    {
        $this->_get_datatables_query_log_uim();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_log_uim = [null, 'l.status', 'l.rc', 'l.response', 'l.message', 'CAST(l.add_time as varchar)'];
    var $kolom_cari_log_uim  = ['LOWER(l.status)', 'LOWER(l.rc)', 'LOWER(CAST (l.response as VARCHAR))', 'LOWER(l.message)', 'CAST(l.add_time as VARCHAR)'];
    var $order_log_uim       = ['l.add_time' => 'desc'];

    public function _get_datatables_query_log_uim()
    {
        $this->db->select('l.*');
        $this->db->from('log_response_uim as l');
        
        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_log_uim;

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

            $kolom_order = $this->kolom_order_log_uim;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_log_uim)) {
            
            $order = $this->order_log_uim;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_log_uim()
    {
        $this->db->select('l.*');
        $this->db->from('log_response_uim as l');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_log_uim()
    {
        $this->_get_datatables_query_log_uim();

        return $this->db->get()->num_rows();
        
    }

    public function get_data_log_error()
    {
        $this->_get_datatables_query_log_error();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_log_error = [null, 'l.keterangan', 'CAST(l.add_time as varchar)'];
    var $kolom_cari_log_error  = ['LOWER(l.keterangan)', 'CAST(l.add_time as VARCHAR)'];
    var $order_log_error       = ['CAST(l.add_time as VARCHAR)' => 'desc'];

    public function _get_datatables_query_log_error()
    {
        $this->db->select('l.*');
        $this->db->from('log_error as l');
        
        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_log_error;

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

            $kolom_order = $this->kolom_order_log_error;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_log_error)) {
            
            $order = $this->order_log_error;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_log_error()
    {
        $this->db->select('l.*');
        $this->db->from('log_error as l');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_log_error()
    {
        $this->_get_datatables_query_log_error();

        return $this->db->get()->num_rows();
        
    }

}

/* End of file M_log.php */
