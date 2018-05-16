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
        *@see VrijwilligerRit_model::getVrijwilligerRittenByVrijwilligerId()
        *
        * Gemaakt door Nico Claes
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
            *Haalt al de informatie op van een bepaalde rit waar het id van meegegeven wordt.
            *
            *@param $vrijwilligerRitId Dit is het id van de gevraagde rit van een vrijwilliger.
            *@see Rit_model::getByRitId()
            *
         * Gemaakt door Nico Claes en Michiel Olijslagers
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
        
	/**
        *Verander de informatie van een bepaalde rit waar het id van de vrijwilliger zijn rit is meegegeven.
        *
        *@@param $vrijwilligerRitId Dit is het id van de gevraagde rit van een vrijwilliger.
        * 
        *@see VrijwilligerRit_model::getVrijwilligerRitByVrijwilligerRitId()
        *
        * Gemaakt door Nico Claes
	*/
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
        
        /**
        *Update alleen de opmerking en extra kosten informatie van een bepaalde.
        *rit dat overeen komt met het toegevoegde id van een vrijwilliger zijn rit.
        *
        *@param $vrijwilligerRitId Dit is het id van een toegewezen rit voor de vrijwilliger.
        * 
        *@see VrijwilligerRit_model::getVrijwilligerRitByVrijwilligerRitId()
        *@see VrijwilligerRit_model::updateVrijwilligerRit()
        *
        * Gemaakt door Nico Claes
	*/
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
        
        /**
        *Pas de status aan van een vrijwilliger en mindermobiele zijn rit.
        *
        *@param $vrijwilligerRitId Dit is het id van een toegewezen rit voor de vrijwilliger.
         * 
        *@see VrijwilligerRit_model::updateStatusRitten()
        *
         * Gemaakt door Nico Claes
	*/
        public function statusAanpassen($vrijwilligerRitId){
            $gebruiker = $this->authex->getGebruikerInfo();
            if ($gebruiker == null) {
                redirect('gebruiker/inloggen');
            }
            $this->load->model('vrijwilligerRit_model');
            $this->vrijwilligerRit_model->updateStatusRitten($this->vrijwilligerRit_model->getVrijwilligerRitByVrijwilligerRitId($vrijwilligerRitId)->ritId, $this->input->post('statusId'));
            redirect('vrijwilliger/ritten');
	}
}

