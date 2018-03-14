<?php
/**
 * @class Gebruiker_model
 * @brief Model-klasse voor gebruikers (medewerkers, vrijwilligers, ...)
 * 
 * Model-klasse die alle methodes bevat om te interageren met de database-tabel gebruiker
 */

class Gebruiker_model extends CI_Model {

    function __construct()
    {
        /**
         * Constructor
         */
        parent::__construct();
    }
    
    /**
     * Retourneert het record met id=$id uit de tabel gebruiker
     * @param $id De id van het record dat opgevraagd wordt
     * @return het opgevraagde record
     */
    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('gebruiker');
        return $query->row();
    }
    
    /**
     * Retourneert het record met id=$id uit de tabel gebruiker
     * hierbij worden ook zijn functies megegeven (MinderMobiele, coach, ...)
     * @param $id De id van het record dat opgevraagd wordt
     * @return het opgevraagde record
     */
    function getWithFunctions($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('gebruiker');
        $gebruiker = $query->row();
        
        $this->load->model('functieGebruiker_model');
        $gebruiker->functies = $this->functieGebruiker_model->getWithName($gebruiker->id);
        
        return $gebruiker;
    }
    
    /**
     * Retourneert het record met mail=$email, wachtwoord=$wachtwoord & active = 1 uit de tabel gebruiker
     * @param $email Het mail adres van het record dat opgevraagd wordt
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
                        
}
