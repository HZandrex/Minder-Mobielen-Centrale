<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @class Home
 * @brief Controller-klasse voor de Webinfo te laden (beginpagina)
 * 
 * Controller-klase met alle methodes die gebruikt worden om Webinfo (de beginpagina) weer te geven
 */
class Help extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $data['titel'] = 'Help';
        $data['author'] = 'Geffrey W.';

        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'gebruiker/helpPagina');
        $this->template->load('main_master', $partials, $data);
    }
}
