<?php
/**
 * @class Gebruiker_model
 * @brief Model-klasse voor gebruikers (medewerkers, vrijwilligers, ...)
 *
 * Model-klasse die alle methodes bevat om te interageren met de database-tabel gebruiker.
 */
class FunctieGebruiker_model extends CI_Model {

    function __construct()
    {
        /**
         * Constructor
         */
        parent::__construct();
    }

    /**
     * Retourneert het record met gebruikerId=$gebruikerId en waar eindTijd=null (anders heeft deze gebruiker deze functie niet meer) uit de tabel functieGebruiker.
     *
     * @param $gebruikerId De gebruikerId van het record dat opgevraagd wordt
     *
     * @return het opgevraagde record
     */
    function getWithName($gebruikerId)
    {
        $this->db->where('gebruikerId', $gebruikerId);
        $this->db->where('eindTijd', null);
        $query = $this->db->get('functieGebruiker');
        $functiesGebruiker = $query->result();
        
        $this->load->model('functie_model');
        $functies = array();
        foreach ($functiesGebruiker as $functieGebruiker) {
            array_push($functies ,$this->functie_model->get($functieGebruiker->functieId));
        }
        
        return $functies;
    }

    /**
     * Gaat kijken of er een record bestaat waar gebruikerId=$gebruikerId, functieId=$functieId en waar eindTijd=null (anders heeft deze gebruiker deze functie niet meer) uit de tabel functieGebruiker.
     * Wanneer er een record bestaat zal het id hiervan worden geretourneerd, anders wordt er false geretourneerd.
     *
     * @param $gebruikerId De gebruikerId van het record dat opgevraagd wordt
     * @param $functieId De functieId van het record dat opgevraagd wordt
     *
     * @return false of id van het record.
     */
    function functieGebruikerBestaat($gebruikerId, $functieId)
    {
        $this->db->where('gebruikerId', $gebruikerId);
        $this->db->where('functieId', $functieId);
        $this->db->where('eindTijd', null);
        $query = $this->db->get('functieGebruiker');;
        $functiesGebruiker = $query->row();

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $functiesGebruiker->id;
        }
    }

    /**
     * Retourneert een lege record met alle eigenschappen van een record uit de tabel functieGebruiker. Deze lege record bevat ook een lege functie gemaakt via Functie_model.
     *
     * @see Functie_model::getEmpty()
     *
     * @return een lege array
     */
    function getEmpty(){
        $this->load->model('functie_model');
        $functies = array();
        array_push($functies, $this->functie_model->getEmpty());

        return $functies;
    }

    /**
     * Voegt een nieuwe record toe aan de tabel functieGebruiker met de gegevens uit $functieGebruiker.
     *
     * @param  $functieGebruiker Eeen object dat moet worden toegevoegd
     *
     * @return bool
     */
    function voegToe($functieGebruiker){
        if(!$this->db->insert('functieGebruiker', $functieGebruiker)){
            return false;
        }
        return true;

    }


    /**
     * Zorgt ervoor dat er een eindTijd wordt toegevoegd aan een record van de tabel functieGebruiker waar id=$id.
     *
     * @param  $id De id van het record dat aangepast moet worden
     *
     * @return bool
     */
    function verwijderen($id){
        $functieGebruiker = new stdClass();
        $functieGebruiker->eindTijd = date("Y-m-d H:i:s");

        $this->db->where('id', $id);
        if(!$this->db->update('functieGebruiker', $functieGebruiker)){
            return false;
        }
        return true;
    }

    /**
     * Haalt eerst all records op met functieId=$functieId en waar eindTijd=null uit de tabel functieGebruiker.
     * Vervolgens worden alle gebruikers die deze functie hebben opgehaald($functie->gebruikerId) via het Gebruiker_model en geretourneerd als gebruikers.
     *
     * @param $functieId De functieId van het record dat opgevraagd wordt
     *
     * @see Gebruiker_model::get()
     *
     * @return het opgevraagde record
     */
    function getAllGebruikersByFunction($functieId)
    {
        $this->db->where('functieId', $functieId);
        $this->db->where('eindTijd', null);
        $query = $this->db->get('functieGebruiker');
        $functies =  $query->result();
        $this->load->model('gebruiker_model');
        $gebruikers = array();
        foreach ($functies as $functie) {
            $gebruiker = $this->gebruiker_model->get($functie->gebruikerId);
            if ($gebruiker->active == 1) array_push($gebruikers, $gebruiker);
        }
        return $gebruikers;
    }

}
