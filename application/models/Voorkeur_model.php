<?php

class Voorkeur_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function getAll()
    {
        $query = $this->db->get('Voorkeur');
        return $query->result();
    }

    function voegToe($voorkeur){
        $this->db->insert('Voorkeur', $voorkeur);
        return $this->db->insert_id();
    }
}
