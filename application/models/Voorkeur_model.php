<?php

/**
 * @class Voorkeur_model
 * @brief Model-klasse voor voorkeuren
 *
 * Model-klasse die alle methodes bevat om te interageren met de database-tabel voorkeur.
 */
class Voorkeur_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Retourneert het record met id=$id uit de tabel voorkeur.
     * @param $id De id van het record dat opgevraagd wordt
     * @return het opgevraagde record
     *
     * Gemaakt door Geffrey Wuyts
     */
    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('voorkeur');
        return $query->row();
    }

    /**
     * Retourneert het record met naam=$naam uit de tabel voorkeur.
     * @param $naam De naam van het record dat opgevraagd wordt
     * @return het opgevraagde record
     *
     * Gemaakt door Geffrey Wuyts
     */
    function getByNaam($naam) {
        $this->db->where('naam', $naam);
        $query = $this->db->get('voorkeur');
        return $query->row();
    }

    /**
     * Retourneert een lege voorkeur met alle eigenschappen van een record uit de tabel voorkeur.
     * @return Een lege voorkeur
     *
     * Gemaakt door Geffrey Wuyts
     */
    function getEmpty(){
        $voorkeur = new stdClass();

        $voorkeur->id = null;
        $voorkeur->naam  = null;

        return $voorkeur;
    }

    /**
     * Retourneert alle records uit de tabel voorkeur.
     * @return Alle records
     *
     * Gemaakt door Geffrey Wuyts
     */
    function getAll()
    {
        $query = $this->db->get('voorkeur');
        return $query->result();
    }

    /**
     * Gaat een nieuwe voorkeur aanmaken in de tabel voorkeur met de gegevens van $voorkeur.
     * Alvorens het toevoegen wordt de voorkeur naam in kleine letters gezet met als eerste letter een hoofdletter.
     * @param $voorkeur Een voorkeur object
     * @return Het id van het nieuwe record
     *
     * Gemaakt door Geffrey Wuyts
     */
    function voegToe($voorkeur){
        $voorkeur->naam = ucfirst(strtolower($voorkeur->naam));
        $this->db->insert('voorkeur', $voorkeur);
        return $this->db->insert_id();
    }

    /**
     * Gaat de gegevens van een voorkeur uit de tabel voorkeur aanpassen naar de gegevens uit $voorkeur.
     * Alvorens het aanpassen wordt de voorkeur naam in kleine letters gezet met als eerste letter een hoofdletter.
     * @param $voorkeur Een voorkeur object met nieuwe gegevens
     *
     * Gemaakt door Geffrey Wuyts
     */
    function wijzigen($voorkeur){
        $voorkeur->naam = ucfirst(strtolower($voorkeur->naam));
        $this->db->where('id', $voorkeur->id);
        $this->db->update('voorkeur', $voorkeur);
    }

    /**
     * Verwijdert de voorkeur waar id=$id.
     * @param $id Het id van de voorkeur dat wordt verwijderd
     *
     * @return bool
     *
     * Gemaakt door Geffrey Wuyts
     */
    function verwijderen($id){
        $this->db->where('id', $id);
        if (!$this->db->delete('voorkeur')){
            return false;
        }
        return true;
    }
}
