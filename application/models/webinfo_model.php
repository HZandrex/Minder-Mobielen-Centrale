<?php

class Webinfo_model extends CI_Model {

    // +----------------------------------------------------------
    // | Lekkerbier - Bestelling_model.php
    // +----------------------------------------------------------
    // | 2 ITF - 201x-201x
    // +----------------------------------------------------------
    // | Bestelling model
    // |
    // +----------------------------------------------------------
    // | Thomas More Kempen
    // +----------------------------------------------------------

    function __construct()
    {
        parent::__construct();
    }

    function get()
    {
        $query = $this->db->get('webinfo');
        $webinfo = array();
        foreach($query->result() as $waarde){
            $webinfo["$waarde->naam"] = "$waarde->waarde";
        }
        return $webinfo;
    }
                        
}
