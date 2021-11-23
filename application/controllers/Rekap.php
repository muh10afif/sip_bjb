<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap extends CI_Controller {

    public function index()
    {
        $this->pusat();
    }

    public function pusat()
    {
        $this->db->insert('rekap', ['count_npl' => 22222222222222222]);
        
    }
}

/* End of file Rekap.php */
