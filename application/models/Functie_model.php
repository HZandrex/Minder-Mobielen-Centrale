<?php

class Functie_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('functie');
        return $query->row();
    }

    function getAll($totId){
        $this->db->where('id <', $totId);
        $query = $this->db->get('functie');
        return $query->result();
    }
                        
}
