<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
	* @class Ritten
	* @brief Controller-klasse voor ritten
	*
	*Controller-klasse met alle methodes om ritten op te halen
*/
class Ritten extends CI_Controller {

    public function __construct() {
        parent::__construct();	
    }

	/**
		*Haalt al de informatie op van al de ritten op van de ingelogde minder mobiele
		*
		*@see Rit_model::getByMMCId()
		*
	*/	
    public function index() {
	$data['titel'] = 'Ritten';
        $data['author'] = 'Nico C.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();
		
        $this->load->model('vrijwilligerRit_model');
        $data['ritten'] = $this->vrijwilligerRit_model->getVrijwilligerRittenByVrijwilligerId($data['gebruiker']->id);

        $partials = array('menu' => 'main_menu','inhoud' => 'vrijwilliger/ritten');
        $this->template->load('main_master', $partials, $data);
    }

	/**
		*Haalt al de informatie op van al een bepaalde rit waar het id van meegegeven wordt
		*
		*@param $ritId Dit is het id van de gevraagde rit
		*@see Rit_model::getByRitId()
		*
	*/
	public function eenRit($ritId){		
            $this->load->model('vrijwilligerRit_model');
            $data['rit'] = $this->vrijwilligerRit_model->getVrijwilligerRitByVrijwilligerRitId($ritId);

            $data['titel'] = 'Details rit';
            $data['author'] = 'Nico C.';
            $data['gebruiker'] = $this->authex->getGebruikerInfo();

            $partials = array('menu' => 'main_menu','inhoud' => 'vrijwilliger/rit');
            $this->template->load('main_master', $partials, $data);
	}
	
	public function wijzigen($ritId){
            $this->load->model('vrijwilligerRit_model');
            $data['rit'] = $this->vrijwilligerRit_model->getByVrijwilligerId($ritId);

            $data['titel'] = 'Wijzig rit';
            $data['author'] = 'Nico C.';
            $data['gebruiker'] = $this->authex->getGebruikerInfo();

            $partials = array('menu' => 'main_menu','inhoud' => 'vrijwilliger/ritWijzigen');
            $this->template->load('main_master', $partials, $data);
	}
        
        public function accepterenAnnuleren($vrijwilligerRitId){
            $this->load->model('vrijwilligerRit_model');

            $vrijwilligerRit = new stdClass();
            $vrijwilligerRit->statusId = (int)$this->input->post('statusId');
            $vrijwilligerRit->id = $vrijwilligerRitId;
            var_dump($vrijwilligerRit);
            
            $this->vrijwilligerRit_model->updateStatusVrijwilligerRit($vrijwilligerRit);

            redirect('vrijwilliger/ritten');
	}
}

