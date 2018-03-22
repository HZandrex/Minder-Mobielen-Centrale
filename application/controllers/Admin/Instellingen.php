<?php

/**
 * @class Instellingen
 * @brief Controller-klasse voor de algemene instellingen te wijzigen
 * 
 * Controller-klase met alle methodes die gebruikt worden om de algemene instellingen te wijzigen.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Instellingen extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Toont het inlogscherm in de view Gebruiker/inlogPagina.php.
     * 
     * @see Gebruiker/inlogPagina.php
     */
    public function index() {
        $data['titel'] = 'Instellingen';
        $data['author'] = 'Geffrey W.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();
        
        $this->load->model('instelling_model');
        $data['instellingen'] = $this->instelling_model->getAll();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'admin/instellingenwijzigenpagina');
        $this->template->load('main_master', $partials, $data);
    }
}
