<?php

class Voorkeur_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Retourneert het record met id=$id uit de tabel gebruiker.
     * @param $id De id van het record dat opgevraagd wordt
     * @return het opgevraagde record
     */
    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('Voorkeur');
        return $query->row();
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

    function wijzigen($voorkeur){
        $this->db->where('id', $voorkeur->id);
        $this->db->update('Voorkeur', $voorkeur);
    }

    function verwijderen($id){
        $this->db->where('id', $id);
        if (!$this->db->delete('Voorkeur')){
            return false;
        }
        return true;
    }
}
