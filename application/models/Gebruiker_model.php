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

    /**
     * Retourneert het record met id=$id uit de tabel gebruiker.
     * @param $id De id van het record dat opgevraagd wordt
     * @return het opgevraagde record
     */
    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('Gebruiker');
        return $query->row();
    }


    
    /**
     * Retourneert het record met mail=$email uit de tabel gebruiker.
     * @param $email Het mailadres van het record dat opgevraagd wordt
     * @return het opgevraagde record
     */
    function getByMail($email) {
        $this->db->where('mail', $email);
        $query = $this->db->get('Gebruiker');
        return $query->row();
    }
    /**
     * Retourneert het record met resetToken=$resetToken uit de tabel gebruiker.
     * @param $resetToken De resetToken van het record dat opgevraagd wordt
     * @return het opgevraagde record
     */
    function getByResetToken($resetToken) {
        $this->db->where('resetToken', $resetToken);
        $query = $this->db->get('Gebruiker');
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
        $query = $this->db->get('Gebruiker');
        $gebruiker = $query->row();

        $this->load->model('functieGebruiker_model');
        $gebruiker->functies = $this->functieGebruiker_model->getWithName($gebruiker->id);

        return $gebruiker;
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
        $query = $this->db->get('Gebruiker');

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
     * Retourneert true wanneer het email adres nog niet wordt gebruikt en false
     * wanneer er al een account is met dit mailadres.
     * @param $email Het mailadres dat wordt gecontroleerd
     * @return true bij nog niet bestaan & false bij het al bestaan
     */
    function controleerEmailVrij($email) {
        // is email al dan niet aanwezig
        $this->db->where('mail', $email);
        $query = $this->db->get('Gebruiker');

        if ($query->num_rows() == 0) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Retourneert true wanneer de resetToken bestaat en false wanneer hij niet bestaat.
     * @param $resetToken De resetToken dat wordt gecontroleerd
     * @return false bij niet bestaan & true bij het bestaan
     */
    function controleerResetToken($resetToken) {
        $this->db->where('resetToken', $resetToken);
        $query = $this->db->get('Gebruiker');

        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
     * Wijzigt de waarde van resetToken waar mail=$email in de tabel Gebruiker.
     * @param $email Het mailadres van wie de token moet worden gewijzigt
     * @param $resetToken De resetToken dat wordt gecontroleerd
     */
    function wijzigResetToken($email, $resetToken){
        $gebruiker = new stdClass();
        $gebruiker->resetToken = $resetToken;
        $this->db->where('mail', $email);
        $this->db->update('Gebruiker', $gebruiker);
    }
    
    /**
     * Verwijdert resetToken waar resetToken = $resetToken.
     * @param $resetToken De resetToken dat wordt verwijdert
     */
    function verwijderResetToken($resetToken){
        $gebruiker = new stdClass();
        $gebruiker->resetToken = null;
        $this->db->where('resetToken', $resetToken);
        $this->db->update('Gebruiker', $gebruiker);
    }
    
    /**
     * Wijzigt het wachtwoord na een nieuw aan te vragen waar resetToken = $resetToken,
     * vervolgens wordt de resetToken verwijderd via Gebruiker_model::verwijderResetToken().
     * @param $resetToken De resetToken waarvan het wachtwoord wordt veranderd
     * @param $wachtwoord Het nieuwe wachtwoord dat werd opgeven in Gebruiker/wachtwoordVergetenWijzigen.php
     * 
     * @see Gebruiker_model::verwijderResetToken()
     */
    function wijzigWachtwoordReset($resetToken, $wachtwoord){
        $gebruiker = new stdClass();
        $gebruiker->wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);
        $this->db->where('resetToken', $resetToken);
        $this->db->update('Gebruiker', $gebruiker);
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
        $this->db->update('Gebruiker', $gebruiker);
        $this->authex->meldAf();
    }

}
