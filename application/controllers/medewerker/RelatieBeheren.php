<?php

/**
 * @class GebruikersBeheren
 * @brief Controller-klasse voor de gebruikers te kunnen beheren
 * 
 * Controller-klase met alle methodes die gebruikt worden voor de gebruikers te beheren.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class GebruikersBeheren extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Toont het startscherm met alle gebruikers in de view Medewerker/gebruikersBeherenOverzicht.php.
     * 
     * @see Medewerker/gebruikersBeherenOverzicht.php
     */
    public function index() {
        $data['titel'] = 'Gebruikers beheren';
        $data['author'] = 'Geffrey W.';

        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null){
            $data['gebruiker'] = $gebruiker;
        } else{
            redirect('gebruiker/inloggen');
        }
        //niet compleet
        $partials = array('menu' => 'main_menu', 'inhoud' => 'medewerker/relatieBeherenOverzicht');
        $this->template->load('main_master', $partials, $data);
    }
}
