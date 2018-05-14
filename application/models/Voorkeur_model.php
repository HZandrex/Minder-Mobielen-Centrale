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
        $query = $this->db->get('voorkeur');
        return $query->row();
    }

    /**
     * Retourneert het record met id=$id uit de tabel gebruiker.
     * @param $id De id van het record dat opgevraagd wordt
     * @return het opgevraagde record
     */
    function getByNaam($naam) {
        $this->db->where('naam', $naam);
        $query = $this->db->get('voorkeur');
        return $query->row();
    }

    function getEmpty(){
        $voorkeur = new stdClass();

        $voorkeur->id = null;
        $voorkeur->naam  = null;

        return $voorkeur;
    }
    
    function getAll()
    {
        $query = $this->db->get('voorkeur');
        return $query->result();
    }

    function voegToe($voorkeur){
        $voorkeur->naam = ucfirst(strtolower($voorkeur->naam));
        $this->db->insert('voorkeur', $voorkeur);
        return $this->db->insert_id();
    }

    function wijzigen($voorkeur){
        $voorkeur->naam = ucfirst(strtolower($voorkeur->naam));
        $this->db->where('id', $voorkeur->id);
        $this->db->update('voorkeur', $voorkeur);
    }

    function verwijderen($id){
        $this->db->where('id', $id);
        if (!$this->db->delete('voorkeur')){
            return false;
        }
        return true;
    }
}
