<?php

class FunctieGebruiker_model extends CI_Model {

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

    /*function get($gebruikersId)
    {
        $this->db->where('gebruikerId', $gebruikerId);
        $query = $this->db->get('FunctieGebruiker');
        return $query->result();
    }*/
    function getWithName($gebruikerId)
    {
        $this->db->where('gebruikerId', $gebruikerId);
        $query = $this->db->get('FunctieGebruiker');
        $functiesGebruiker = $query->result();
        
        $this->load->model('functie_model');
        $functies = array();
        foreach ($functiesGebruiker as $functieGebruiker) {
            array_push($functies ,$this->functie_model->get($functieGebruiker->functieId));
        }
        
        return $functies;
    }

}
