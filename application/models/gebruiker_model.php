<?php

class Gebruiker_model extends CI_Model {

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

    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('gebruiker');
        return $query->row();
    }
    
    function getWithFunctions($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('gebruiker');
        $gebruiker = $query->row();
        
        $this->load->model('functieGebruiker_model');
        $gebruiker->functies = $this->functieGebruiker_model->getWithName($gebruiker->id);
        
        return $gebruiker;
    }
    
    function getGebruiker($email, $wachtwoord) {
        // geef gebruiker-object met $email en $wachtwoord EN geactiveerd = 1
        $this->db->where('mail', $email);
        $this->db->where('active', 1);
        $query = $this->db->get('gebruiker');
        
        if ($query->num_rows() == 1) {
            $gebruiker = $query->row();
            // controleren of het wachtwoord overeenkomt
            if (password_verify($wachtwoord, $gebruiker->wachtwoord)) {
                return $gebruiker;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
                        
}
