<?php
class Model_pengguna extends CI_model{
    
    public function get_level()
    {
        return $this->db->get('m_authorization');
    }
    
    function tampil_data()
    {
        $this->db->select('u.id , e.reg_employee, sha, level, active, e.name, u.email as email_user, v.auth, e.kanwil, e.cabang_induk');
        $this->db->from('m_user as u');
        $this->db->join('m_employee as e', 'e.reg_employee = u.reg_employee', 'inner');
        $this->db->join('m_authorization as v', 'v.id = u.level', 'inner');
        $this->db->order_by('e.name', 'asc');
        
        return $this->db->get();
    }
    
    function post($data)
    {
        $this->db->insert('m_user',$data);
    }
    
    function get_one($id)
    {
        /*$param  =   array('id'=>$id);
        return $this->db->get_where('m_user',$param);*/

        $this->db->select('u.*, e.*, e.email as email_2, u.email as email');
        $this->db->from('m_user as u');
        $this->db->join('m_employee as e', 'e.reg_employee = u.reg_employee', 'left');
        $this->db->where('u.id', $id);

        return $this->db->get();
    }
    
    function edit($data,$id)
    {
        $this->db->where('id',$id);
        $this->db->update('m_user',$data);
    }
    
    
    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('m_user');
    }

    public function hapus_kelolaan($reg_employee)
    {
        $this->db->where('reg_employee', $reg_employee);
        $this->db->delete('tr_kelolaan');
    }

    function get_employee()
    {
        $this->db->select('reg_employee');
        $this->db->from('m_user as u');
        $sub = $this->db->get_compiled_select();

        $this->db->select('e.name, e.reg_employee');
        $this->db->from('m_employee as e');
        $this->db->where("e.reg_employee NOT IN ($sub)", NULL, FALSE);

        return $this->db->get();
    }
}