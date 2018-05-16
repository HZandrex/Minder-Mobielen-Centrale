<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @class Help
 * @brief Controller-klasse voor de helpPagina te laden (gebruikersondersteuning)
 * 
 * Controller-klase met alle methodes die gebruikt worden om de helpPagina weer te geven
 */
class Help extends CI_Controller {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Toont het scherm om hulp te vinden in de view gebruiker/helpPagina.php.
     *
     * @see gebruiker/helpPagina.php
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function index() {
        $data['titel'] = 'Help';
        $data['author'] = 'G. Wuyts';

        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'gebruiker/helpPagina');
        $this->template->load('main_master', $partials, $data);
    }
}
