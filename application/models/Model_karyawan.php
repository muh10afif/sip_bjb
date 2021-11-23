<?php
class Model_karyawan extends ci_model{
    
    // cari data
    public function cari_data($tabel, $where)
    {
        return $this->db->get($tabel, $where);
        
    }
    
    // cek username
    public function cari_username($username)
    {
        return $this->db->get_where('m_user', array('email' => $username));
    }

    function tampil_data()
    {
        $query= "SELECT reg_employee,name,address,phone,birth_date,email,kanwil,cabang_induk
                FROM m_employee ORDER BY name ASC";
        return $this->db->query($query);
    }
    
    function post_data($data)
    {
        $this->db->insert('m_employee',$data);
    }
    
    function get_one($id)
    {
        $param  =   array('reg_employee'=>$id);
        return $this->db->get_where('m_employee',$param);
    }
    
    function edit($data,$reg_employee)
    {
        $this->db->where('reg_employee',$reg_employee);
        $this->db->update('m_employee',$data);

        return $this->db->affected_rows();
    }
    
    
    function delete($id)
    {
        $this->db->where('reg_employee',$id);
        $this->db->delete('m_employee');
    }

    function ambil_cabang()
    {
        $query = "SELECT cabang FROM m_cabang";
        return $this->db->query($query);
    }

    function ambil_kanwil()
    {
        $query = "SELECT kanwil FROM m_kanwil";
        return $this->db->query($query);
    }
}