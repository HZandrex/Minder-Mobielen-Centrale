<?php

/**
 * @class Gebruiker_model
 * @brief Model-klasse voor gebruikers (medewerkers, vrijwilligers, ...)
 * 
 * Model-klasse die alle methodes bevat om te interageren met de database-tabel gebruiker.
 */
class Gebruiker_model extends CI_Model {

    function __construct() {
        /**
         * Constructor
         */
        parent::__construct();
    }

    function get($id) {
		/**
		 * Retourneert het record met id=$id uit de tabel gebruiker.
		 * @param $id De id van het record dat opgevraagd wordt
		 * @return het opgevraagde record
		 */
        $this->db->where('id', $id);
        $query = $this->db->get('gebruiker');
        return $query->row();
    }

    function getAllInActive() {
		/**
		 * Retourneert het record met id=$id uit de tabel gebruiker.
		 * @param $id De id van het record dat opgevraagd wordt
		 * @return het opgevraagde record
		 */
        $this->db->where('active', 0);
        $query = $this->db->get('gebruiker');
        return $query->result();
    }

    
    /**
     * Retourneert het record met mail=$email uit de tabel gebruiker.
     * @param $email Het mailadres van het record dat opgevraagd wordt
     * @return het opgevraagde record
     */
    function getByMail($email) {
        $this->db->where('mail', $email);
        $query = $this->db->get('gebruiker');
        return $query->row();
        if($query->num_rows() > 0){
            $result = $query->row();
            return $result;
        }else{
            return false;
        }
    }
	
    /**
     * Retourneert het record met resetToken=$resetToken uit de tabel gebruiker.
     * @param $resetToken De resetToken van het record dat opgevraagd wordt
     * @return het opgevraagde record
     */
    function getByResetToken($resetToken) {
        $this->db->where('resetToken', $resetToken);
        $query = $this->db->get('gebruiker');
        return $query->row();
    }

    /**
     * Retourneert het record met id=$id uit de tabel gebruiker.
     * hierbij worden ook zijn functies megegeven (MinderMobiele, coach, ...)
     * @param $id De id van het record dat opgevraagd wordt
     * @return het opgevraagde record
     */
    function getWithFunctions($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('gebruiker');
        $gebruiker = $query->row();

        $this->load->model('functieGebruiker_model');
		$this->load->model('adres_model');
		$this->load->model('voorkeur_model');
		$gebruiker->voorkeur = $this->voorkeur_model->get($gebruiker->voorkeurId);
		$gebruiker->adres = $this->adres_model->getById($gebruiker->adresId);
        $gebruiker->functies = $this->functieGebruiker_model->getWithName($gebruiker->id);

        return $gebruiker;
    }

    /**
     * Retourneert het record met id=$id uit de tabel gebruiker.
     * hierbij worden ook zijn functies megegeven (MinderMobiele, coach, ...)
     * @param $id De id van het record dat opgevraagd wordt
     * @return het opgevraagde record
     */
    function getEmpty() {
        $gebruiker = new stdClass();

        $this->db->where('id', 1);
        $query = $this->db->get('gebruiker');
        $voorbeeldGebruiker = $query->row();

        foreach ($voorbeeldGebruiker as $attribut => $waarde){
            $gebruiker->$attribut = null;
        }

        $this->load->model('functieGebruiker_model');
        $this->load->model('adres_model');
        $this->load->model('voorkeur_model');
        $gebruiker->voorkeur = $this->voorkeur_model->getEmpty();
        $gebruiker->adres = $this->adres_model->getEmpty();
        $gebruiker->functies = $this->functieGebruiker_model->getEmpty();
        return $gebruiker;
    }
	
	function updateGebruiker($gebruiker)
    {
        $gebruiker->mail = ucfirst(strtolower($gebruiker->mail));
        $this->db->where('id', $gebruiker->id);
        $this->db->update('gebruiker', $gebruiker);
    }

    function activeerGebruiker($id)
    {
        $this->db->set('active', 1);
        $this->db->where('id', $id);
        $this->db->update('gebruiker');
    }

    function deactiveerGebruiker($id)
    {
        $this->db->set('active', 0);
        $this->db->set('wachtwoord', null);
        $this->db->where('id', $id);
        $this->db->update('gebruiker');
    }

    function insertGebruiker($gebruiker){
        $data = array(
            'voornaam' => $gebruiker->voornaam,
            'naam' => $gebruiker->naam,
            'geboorte' => $gebruiker->geboorte,
            'telefoon' => $gebruiker->telefoon,
            'mail' => ucfirst(strtolower($gebruiker->mail)),
            'voorkeurId' => $gebruiker->voorkeurId,
            'adresId' => $gebruiker->adresId
        );

        $this->db->insert('gebruiker', $data);
        return $this->db->insert_id();
    }

    /**
     * Retourneert het record met mail=$email, wachtwoord=$wachtwoord & active = 1 uit de tabel gebruiker.
     * @param $email Het mailadres van het record dat opgevraagd wordt
     * @param $wachtwoord Het wachtwoord in hash van het record dat opgevraagd wordt
     * @return het opgevraagde record als er een gebruiker is met het opgeven email & wachtwoord combo en active is
     * anders null
     * 
     */
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
    
    /**
     * Retourneert true wanneer de resetToken bestaat en false wanneer hij niet bestaat.
     * @param $resetToken De resetToken dat wordt gecontroleerd
     * @return false bij niet bestaan & true bij het bestaan
     */
    function controleerResetToken($resetToken) {
        $this->db->where('resetToken', $resetToken);
        $query = $this->db->get('gebruiker');

        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
     * Wijzigt de waarde van resetToken waar mail=$email in de tabel gebruiker.
     * @param $email Het mailadres van wie de token moet worden gewijzigt
     * @param $resetToken De resetToken dat wordt gecontroleerd
     */
    function wijzigResetToken($email, $resetToken){
        $gebruiker = new stdClass();
        $gebruiker->resetToken = $resetToken;
        $this->db->where('mail', $email);
        $this->db->update('gebruiker', $gebruiker);
    }
    
    /**
     * Verwijdert resetToken waar resetToken = $resetToken.
     * @param $resetToken De resetToken dat wordt verwijdert
     */
    function verwijderResetToken($resetToken){
        $gebruiker = new stdClass();
        $gebruiker->resetToken = null;
        $this->db->where('resetToken', $resetToken);
        $this->db->update('gebruiker', $gebruiker);
    }
    
    /**
     * Wijzigt het wachtwoord na een nieuw aan te vragen waar resetToken = $resetToken,
     * vervolgens wordt de resetToken verwijderd via Gebruiker_model::verwijderResetToken().
     * @param $resetToken De resetToken waarvan het wachtwoord wordt veranderd
     * @param $wachtwoord Het nieuwe wachtwoord dat werd opgeven in gebruiker/wachtwoordVergetenWijzigen.php
     * 
     * @see Gebruiker_model::verwijderResetToken()
     */
    function wijzigWachtwoordReset($resetToken, $wachtwoord){
        $gebruiker = new stdClass();
        $gebruiker->wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);
        $this->db->where('resetToken', $resetToken);
        $this->db->update('gebruiker', $gebruiker);
        $this->verwijderResetToken($resetToken);
    }
    
    
    /**
     * Wijzigt het wachtwoord waar id = $id en meld de gebruiker af.
     * @param $wachtwoord Het nieuwe wachtwoord dat werd opgeven in Gebruiker/wachtwoordWijzigen.php
     */
    function wijzigWachtwoord($id, $wachtwoord){
        $gebruiker = new stdClass();
        $gebruiker->wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);
        $this->db->where('id', $id);
        $this->db->update('gebruiker', $gebruiker);
        $this->authex->meldAf();
    }

    /**
     * Wijzigt het wachtwoord waar id = $id en meld de gebruiker af.
     * @param $wachtwoord Het nieuwe wachtwoord dat werd opgeven in Gebruiker/wachtwoordWijzigen.php
     */
    function wijzigWachtwoordGebruiker($id, $wachtwoord){
        $gebruiker = new stdClass();
        $gebruiker->wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);
        $this->db->where('id', $id);
        $this->db->update('gebruiker', $gebruiker);
    }

	function getCredits($id, $date){
		/**
		 * Berekent hoeveel credits een bepaalde gebruiker binnen een bepaalde week heet
		 * 
		 * @param $id Dit is het de minder mobiele
		 * @param $date Datum van de week waar de credits berekent moeten worden
		 * @see instelling_model::getValueById()
		 * @see Rit_model::getAantalRitten()
		 * @see Gemaakt door Michiel Olijslagers
		 */
		$this->load->model('instelling_model');
		$this->load->model('rit_model');
		
		$gebruikteCredits = $this->rit_model->getAantalRitten($id, $date);
		$maxCredits = $this->instelling_model->getValueById(1);
		
		$creditsOver = $maxCredits->waarde - $gebruikteCredits;
		return $creditsOver;
	}
}
