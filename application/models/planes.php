<?php

require_once APPPATH . 'interfaces/PlanesDaoInterface.php';

class Planes extends CI_Model implements PlanesDaoInterface {

    function __construct()
    {
        parent::__construct();
    }

    function get($plan_id)
    {
        $this->db->where('id', $plan_id);
        return $this->db->get('planes')->result();
    }

}