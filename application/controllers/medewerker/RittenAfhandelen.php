<?php

/**
 * @class RittenAfhandelen
 * @brief Controller-klasse voor de ritten te kunnen afhandelen
 * 
 * Controller-klase met alle methodes die gebruikt worden voor de ritten af te handelen.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class RittenAfhandelen extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['titel'] = 'Gebruikers beheren';
        $data['author'] = 'Michiel O.';
		
		$gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null) {
            $data['gebruiker'] = $gebruiker;
        } else {
            redirect('gebruiker/inloggen');
        }
		
		$this->load->model('rit_model');
		$data['ritten'] = $this->rit_model->getAllRitten();
		
        $partials = array('menu' => 'main_menu', 'inhoud' => 'medewerker/rittenOverzicht');
        $this->template->load('main_master', $partials, $data);
    }
	
	public function eenRit($ritId){		
		$this->load->model('rit_model');
		$data['rit'] = $this->rit_model->getByRitId($ritId);
		
		$data['titel'] = 'Details rit';
        $data['author'] = 'Michiel O.';
		$data['gebruiker'] = $this->authex->getGebruikerInfo();
		
		$partials = array('menu' => 'main_menu','inhoud' => 'medewerker/rit');
        $this->template->load('main_master', $partials, $data);
	}
}
