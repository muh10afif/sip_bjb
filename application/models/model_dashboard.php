<?php
class model_dashboard extends ci_model{
    
    function jumlahPlan()
    {
       $query = $this->db->query("SELECT * FROM plan_placeitem ");
       return $query->num_rows();
    }
}