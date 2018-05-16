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

	/**
	 * Laat de detail pagina zien van 1 bepaalde rit, dit is de rit waar het id van meegegeven wordt.
	 *
	 * @param $ritId Dit is het id van de gevraagde rit
	 * @see Rit_model::getAllRitten()
	 * @see statussen::getAll()
	 * 
	 * Gemaakt door Michiel Olijslagers
	*/
    public function index() {
		$data['titel'] = 'Ritten beheren';
        $data['author'] = 'Olijslagers M.';
		
		$gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null) {
            $data['gebruiker'] = $gebruiker;
        } else {
            redirect('gebruiker/inloggen');
        }
		
		$this->load->model('rit_model');
		$this->load->model('status_model');
		$data['ritten'] = $this->rit_model->getAllRitten();
		$data['statussen'] = $this->status_model->getAll();
		
        $partials = array('menu' => 'main_menu', 'inhoud' => 'medewerker/rittenOverzicht');
        $this->template->load('main_master', $partials, $data);
    }
	
	/**
	 * Laat de detail pagina zien van 1 bepaalde rit, dit is de rit waar het id van meegegeven wordt.
	 *
	 * @param $ritId Dit is het id van de gevraagde rit
	 * @see Rit_model::getByRitId()
	 * @see VrijwilligerRit_model::getVrijwilligerByRit()
	 * 
	 * Gemaakt door Michiel Olijslagers
	*/
	public function eenRit($ritId){		
		$data['titel'] = 'Details rit';
        $data['author'] = 'Olijslagers M.';
		$data['gebruiker'] = $this->authex->getGebruikerInfo();
	
		$this->load->model('rit_model');
		$this->load->model('vrijwilligerRit_model');
		
		$data['rit'] = $this->rit_model->getByRitId($ritId);
		$data['vrijwilligers'] = $this->vrijwilligerRit_model->getVrijwilligerByRit($ritId);
		
		$partials = array('menu' => 'main_menu','inhoud' => 'medewerker/rit');
        $this->template->load('main_master', $partials, $data);
	}
	
	/**
	 * Koppeld een vrijwilliger aan een rit
	 *
	 * @see VrijwilligerRit_model::koppelVrijwilliger()
	 * 
	 * Gemaakt door Michiel Olijslagers
	*/
	public function koppelVrijwilliger(){
		$this->load->model('vrijwilligerRit_model');
		
		$ritId = htmlspecialchars(trim($_POST['ritId']));
		$vrijwilligerId = htmlspecialchars(trim($_POST['vrijwilligerId']));
		$alEen = htmlspecialchars(trim($_POST['alEen']));
		
		return $this->vrijwilligerRit_model->koppelVrijwilliger($ritId, $vrijwilligerId, $alEen);
	}
	
	/**
	 * Koppeld een vrijwilliger aan een rit
	 *
	 * @param $id Dit is het id van de gevraagde rit
	 * @see Rit_model::getByRitId()
	 * @see Rit_model::getAllVoorGebruiker()
	 * 
	 * Gemaakt door Michiel Olijslagers
	*/
	public function wijzigRit($id){
        $data['titel'] = 'Wijzig rit';
        $data['author'] = 'M. Olijslagers';
		$data['gebruiker'] = $this->authex->getGebruikerInfo();
		
		$this->load->model('rit_model');
		$data['heen'] = $this->rit_model->getByRitId($id);
		
        $data['adressen'] = $this->rit_model->getAllVoorGebruiker($data['heen']->gebruikerMinderMobieleId);

        $partials = array('menu' => 'main_menu','inhoud' => 'medewerker/wijzigRit');
        $this->template->load('main_master', $partials, $data);
	}
	
	/**
	 * Reset de status van een vrijwilliger bij de gegeven rit, dit zodat een vrijwilliger zich kan bedenken
	 *
	 * @see VrijwilligerRit_model::resetVrijwilliger()
	 * 
	 * Gemaakt door Michiel Olijslagers
	*/
	public function resetVrijwilliger(){
				$this->load->model('vrijwilligerRit_model');
		
		$ritId = htmlspecialchars(trim($_POST['ritId']));
		$vrijwilligerId = htmlspecialchars(trim($_POST['vrijwilligerId']));
		
		return $this->vrijwilligerRit_model->resetVrijwilliger($ritId, $vrijwilligerId);
	}
}
