<?php

class M_user extends CI_Model {

    private $table = "m_user";

    function cek($username, $password) {
        $this->db->where("email", $username);
        $this->db->where("sha", $password);
        return $this->db->get("m_user");
    }

    function semua() {
        return $this->db->get("m_user");
    }

    function cekKode($kode) {
        $this->db->where("email", $kode);
        return $this->db->get("m_user");
    }

    function cekId($kode) {
        $this->db->where("u_id", $kode);
        return $this->db->get("user");
    }
    
    function getLoginData($usr, $psw) {
        $u = mysql_real_escape_string($usr);
        $p = md5(mysql_real_escape_string($psw));
        $q_cek_login = $this->db->get_where('users', array('username' => $u, 'password' => $p));
        if (count($q_cek_login->result()) > 0) {
            foreach ($q_cek_login->result() as $qck) {
                foreach ($q_cek_login->result() as $qad) {
                    $sess_data['logged_in'] = 'aingLoginWebYeuh';
                    $sess_data['u_id'] = $qad->id;
                    $sess_data['u_name'] = $qad->email;
                    $sess_data['nama'] = $qad->email;
                    $sess_data['group'] = $qad->level;
                    $sess_data['rid'] = $qad->level;
                    $this->session->set_userdata($sess_data);
                }
                redirect('dashboard');
            }
        } else {
            $this->session->set_flashdata('result_login', '<br>Username atau Password yang anda masukkan salah.');
            header('location:' . base_url() . 'login');
        }
    }

    function update($id, $info) {
        $this->db->where("u_id", $id);
        $this->db->update("user", $info);
    }

    function simpan($info) {
        $this->db->insert("user", $info);
    }

    function hapus($kode) {
        $this->db->where("u_id", $kode);
        $this->db->delete("user");
    }

    // 19-01-21
    public function cari_data_log($user_id)
    {
        $this->db->select('*');
        $this->db->from('log_request');
        $this->db->where('userId', $user_id);
        $this->db->where('response', "00");
        $this->db->where('action', "login");
        $this->db->where('status', 1);

        return $this->db->get();
    }

    // 29-04-2021
    public function get_login_aktif($userId)
    {
        $this->db->select('*');
        $this->db->from('log_request');
        $this->db->where('userId', $userId);
        $this->db->where('response', "00");
        $this->db->where('action', "login");
        $this->db->where('status', 1);
        $this->db->order_by('created_at', 'desc');
        
        
        return $this->db->get();
                
    }

}
