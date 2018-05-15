<?php

/**
 * @class Authex
 * @brief Library voor authenticatie
 * 
 * Library-klase met alle methodes die gebruikt worden om in te loggen, uit te loggen en te controleren of iemand is ingelogd.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authex {

    /**
     * Constructor
     */
    public function __construct() {
        $CI = & get_instance();

        $CI->load->model('gebruiker_model');
    }

    /**
     * Kijkt of een gebruiker is aangemeld via Authex::isAangemeld. Haalt van de ingelogde gebruiker
     * zijn gegevens op via het Gebruiker_model en geeft deze terug.
     *
     * @see Gebruiker_model::getWithFunctions()
     * @see Authex::isAangemeld()
     *
     * @return Null wanneer er niemand is ingelogd anders een gebruiker object
     */
    function getGebruikerInfo() {
        // geef gebruiker-object als gebruiker aangemeld is
        $CI = & get_instance();

        if (!$this->isAangemeld()) {
            return null;
        } else {
            $id = $CI->session->userdata('gebruiker_id');
            return $CI->gebruiker_model->getWithFunctions($id);
        }
    }

    /**
     * Kijkt of er een id zit in de sessievariabele gebruiker_id.
     *
     * @return bool
     */
    function isAangemeld() {
        // gebruiker is aangemeld als sessievariabele gebruiker_id bestaat
        $CI = & get_instance();

        if ($CI->session->has_userdata('gebruiker_id')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gaat kijken of er een gebruikerbestaat met het opgeven emailadres en wachtwoord via het Gebruiker_model.
     * Wanneer er een gebruiker is gevonden wordt zijn id ($gebruiker->id) in de sessievariabele gebruiker_id gezet
     * en zo wordt de gebruiker aangemeld.
     *
     * @param $email Het emailadres van een gebruiker
     * @param $wachtwoord Het wachtwoord van een gebruiker
     *
     * @see Gebruiker_model::getGebruiker()
     *
     * @return bool
     */
    function meldAan($email, $wachtwoord) {
        // gebruiker aanmelden met opgegeven email en wachtwoord
        $CI = & get_instance();

        $gebruiker = $CI->gebruiker_model->getGebruiker($email, $wachtwoord);

        if ($gebruiker == null) {
            return false;
        } else {
            $CI->session->set_userdata('gebruiker_id', $gebruiker->id);
            return true;
        }
    }

    /**
     * Gaat de sessievariabele gebruiker_id leegmaken en zo de gebruiker afmelden.
     */
    function meldAf() {
        // afmelden, dus sessievariabele wegdoen
        $CI = & get_instance();

        $CI->session->unset_userdata('gebruiker_id');
    }
}
