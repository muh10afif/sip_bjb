<?php
class model_plan extends ci_model{
    
    function tampil_data()
    {
        $this->db->SELECT('plan_placeitem.id, s_user.namaLengkap, daily_timeplan.waktu,plan_placeitem.place AS keterangan,plan_placeitem.stat, instansi.nama, place.nama AS place');
        $this->db->FROM('s_user');
        $this->db->JOIN('daily_timeplan', 's_user.id = daily_timeplan.user' ,'LEFT');
        $this->db->JOIN('plan_placeitem', 'daily_timeplan.id = plan_placeitem.id_timeplan' ,'LEFT');
        $this->db->JOIN('instansi', 'instansi.id = plan_placeitem.instansi' ,'LEFT');
        $this->db->JOIN('place', 'place.id = plan_placeitem.place_id' ,'LEFT');
        return $this->db->get();
    }

    function tampil_periode($tanggal1,$tanggal2)
    {
        $this->db->SELECT('plan_placeitem.id, s_user.namaLengkap, daily_timeplan.waktu,plan_placeitem.place AS keterangan,plan_placeitem.stat, instansi.nama, place.nama AS place');
        $this->db->FROM('s_user');
        $this->db->JOIN('daily_timeplan', 's_user.id = daily_timeplan.user' ,'LEFT');
        $this->db->JOIN('plan_placeitem', 'daily_timeplan.id = plan_placeitem.id_timeplan' ,'LEFT');
        $this->db->JOIN('instansi', 'instansi.id = plan_placeitem.instansi' ,'LEFT');
        $this->db->JOIN('place', 'place.id = plan_placeitem.place_id' ,'LEFT');
        $this->db->WHERE("daily_timeplan.waktu between '$tanggal1' AND '$tanggal2'");
        return $this->db->get();
    }
}