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
        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null) {
            $data['gebruiker'] = $gebruiker;
        } else {
            redirect('gebruiker/inloggen');
        }
		
        $this->load->model('vrijwilligerRit_model');
        $data['ritten'] = $this->vrijwilligerRit_model->getVrijwilligerRittenByVrijwilligerId($gebruiker->id);

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
	public function eenRit($vrijwilligerRitId){	
            $data['titel'] = 'Details rit';
            $data['author'] = 'Nico C.';
            $gebruiker = $this->authex->getGebruikerInfo();
            if ($gebruiker != null) {
                $data['gebruiker'] = $gebruiker;
            } else {
                redirect('gebruiker/inloggen');
            }
	
            $this->load->model('vrijwilligerRit_model');
            $data['rit'] = $this->vrijwilligerRit_model->getVrijwilligerRitByVrijwilligerRitId($vrijwilligerRitId);

            $partials = array('menu' => 'main_menu','inhoud' => 'vrijwilliger/rit');
            $this->template->load('main_master', $partials, $data);
	}
	
	public function wijzigen($vrijwilligerRitId){
            $data['titel'] = 'Wijzig rit';
            $data['author'] = 'Nico C.';
            $gebruiker = $this->authex->getGebruikerInfo();
            if ($gebruiker != null) {
                $data['gebruiker'] = $gebruiker;
            } else {
                redirect('gebruiker/inloggen');
            }
	
            $this->load->model('vrijwilligerRit_model');
            $data['rit'] = $this->vrijwilligerRit_model->getVrijwilligerRitByVrijwilligerRitId($vrijwilligerRitId);

            $partials = array('menu' => 'main_menu','inhoud' => 'vrijwilliger/ritWijzigen');
            $this->template->load('main_master', $partials, $data);
	}
        
	public function update($vrijwilligerRitId){
            $gebruiker = $this->authex->getGebruikerInfo();
            if ($gebruiker == null) {
                redirect('gebruiker/inloggen');
            }

            $this->load->model('vrijwilligerRit_model');
            
            $vrijwilligerRit = new stdClass();
            $vrijwilligerRit->id = $vrijwilligerRitId;
            $vrijwilligerRit->ritId = $this->vrijwilligerRit_model->getVrijwilligerRitByVrijwilligerRitId($vrijwilligerRitId)->ritId;
            $vrijwilligerRit->statusId = $this->input->post('statusId');
            $vrijwilligerRit->extraKost = $this->input->post('extraKost');
            $vrijwilligerRit->opmerkingVrijwilliger = $this->input->post('opmerkingVrijwilliger');
            $this->vrijwilligerRit_model->updateVrijwilligerRit($vrijwilligerRit);

            redirect('vrijwilliger/ritten/eenRit/'.$vrijwilligerRitId);
	}
        
        public function statusAanpassen($vrijwilligerRitId){
            $gebruiker = $this->authex->getGebruikerInfo();
            if ($gebruiker == null) {
                redirect('gebruiker/inloggen');
            }
            $this->load->model('vrijwilligerRit_model');
            $this->vrijwilligerRit_model->updateStatusRitten(getVrijwilligerRitByVrijwilligerRitId($this->vrijwilligerRit_model->$vrijwilligerRitId)->ritId, (int)$this->input->post('statusId'));
            redirect('vrijwilliger/ritten');
	}
}

