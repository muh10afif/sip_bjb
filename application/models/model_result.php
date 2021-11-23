<?php
class model_result extends ci_model{
    
    
    function tampil_data()
    {
         $this->db->SELECT('plan_placeitem.id, s_user.namaLengkap, daily_timeplan.waktu, 
         daily_timeresult.waktu AS hasil,plan_placeitem.place,plan_placeitem.stat, instansi.nama AS namai, 
         place.nama AS namap, daily_timeresult.result, daily_timeresult.lat, daily_timeresult.long, 
         daily_timeresult.long, daily_timeresult.address, daily_timeresult.pic, daily_timeresult.hp');
        $this->db->FROM('s_user');
        $this->db->JOIN('daily_timeplan', 's_user.id = daily_timeplan.user' ,'LEFT');
        $this->db->JOIN('plan_placeitem', 'daily_timeplan.id = plan_placeitem.id_timeplan' ,'LEFT');
        $this->db->JOIN('instansi', 'instansi.id = plan_placeitem.instansi' ,'LEFT');
        $this->db->JOIN('place', 'place.id = plan_placeitem.place_id' ,'LEFT');
        $this->db->JOIN('daily_timeresult', 'daily_timeresult.id_plan = plan_placeitem.id' ,'LEFT');
        return $this->db->get();
    }

    function tampil_periode($tanggal1,$tanggal2)
    {
         $this->db->SELECT('plan_placeitem.id, s_user.namaLengkap, daily_timeplan.waktu, 
         daily_timeresult.waktu AS hasil,plan_placeitem.place,plan_placeitem.stat, instansi.nama AS namai, 
         place.nama AS namap, daily_timeresult.result, daily_timeresult.lat, daily_timeresult.long, 
         daily_timeresult.long, daily_timeresult.address, daily_timeresult.pic, daily_timeresult.hp');
        $this->db->FROM('s_user');
        $this->db->JOIN('daily_timeplan', 's_user.id = daily_timeplan.user' ,'LEFT');
        $this->db->JOIN('plan_placeitem', 'daily_timeplan.id = plan_placeitem.id_timeplan' ,'LEFT');
        $this->db->JOIN('instansi', 'instansi.id = plan_placeitem.instansi' ,'LEFT');
        $this->db->JOIN('place', 'place.id = plan_placeitem.place_id' ,'LEFT');
        $this->db->JOIN('daily_timeresult', 'daily_timeresult.id_plan = plan_placeitem.id' ,'LEFT');
        $this->db->WHERE("daily_timeplan.waktu between '$tanggal1' AND '$tanggal2'");
        return $this->db->get();
    }
}