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

    function get($gebruikersId)
    {
        $this->db->where('GebruikersId', $gebruikersId);
        $query = $this->db->get('FunctieGebruiker');
        return $query->result();
    }
    function getWithName($gebruikersId)
    {
        $this->db->where('GebruikersId', $gebruikersId);
        $query = $this->db->get('FunctieGebruiker');
        $functiesGebruiker = $query->result();
        
        $this->load->model('functie_model');
        foreach ($functiesGebruiker as $functieGebruiker) {
            $functieGebruiker->functieNaam = $this->functie_model->get($functieGebruiker->functiesId);
        }
        
        return $functiesGebruiker;
    }
                        
}
