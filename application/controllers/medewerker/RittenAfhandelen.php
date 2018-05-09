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
        $data['titel'] = 'Ritten beheren';
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
		$this->load->model('vrijwilligerRit_model');
	
		$data['titel'] = 'Details rit';
        $data['author'] = 'Michiel O.';
		$data['gebruiker'] = $this->authex->getGebruikerInfo();
		$data['rit'] = $this->rit_model->getByRitId($ritId);
		$data['vrijwilligers'] = $this->vrijwilligerRit_model->getVrijwilligerByRit($ritId);
		
		$partials = array('menu' => 'main_menu','inhoud' => 'medewerker/rit');
        $this->template->load('main_master', $partials, $data);
	}
	
	public function koppelVrijwilliger(){
		$this->load->model('vrijwilligerRit_model');
		
		$ritId = htmlspecialchars(trim($_POST['ritId']));
		$vrijwilligerId = htmlspecialchars(trim($_POST['vrijwilligerId']));
		$alEen = htmlspecialchars(trim($_POST['alEen']));
		
		return $this->vrijwilligerRit_model->koppelVrijwilliger($ritId, $vrijwilligerId, $alEen);
	}
	
	public function wijzigRit($id){
		$this->load->model('rit_model');
        $data['titel'] = 'Wijzig rit';
        $data['author'] = 'Michiel O.';
		$data['gebruiker'] = $this->authex->getGebruikerInfo();
		
		$data['heen'] = $this->rit_model->getByRitId($id);
		
        $data['adressen'] = $this->rit_model->getAllVoorGebruiker($data['heen']->gebruikerMinderMobieleId);

        $partials = array('menu' => 'main_menu','inhoud' => 'medewerker/wijzigRit');
        $this->template->load('main_master', $partials, $data);
	}
}
