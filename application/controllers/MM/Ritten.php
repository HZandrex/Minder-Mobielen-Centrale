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
		$lid = 9;
        $this->load->model('rit_model');
        $data['ritten'] = $this->rit_model->getByMMCId($lid);
		
		$data['titel'] = 'Ritten';
        $data['author'] = 'Michiel O.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu','inhoud' => 'MM/ritten');
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
		$this->load->model('rit_model');
		$data['rit'] = $this->rit_model->getByRitId($ritId);
		
		$data['titel'] = 'Details rit';
        $data['author'] = 'Michiel O.';
		$data['gebruiker'] = $this->authex->getGebruikerInfo();
		
		$partials = array('menu' => 'main_menu','inhoud' => 'MM/rit');
        $this->template->load('main_master', $partials, $data);
	}
	
	public function nieuweRit(){
		$data['titel'] = 'Nieuwe rit';
        $data['author'] = 'Michiel O.';
		$data['gebruiker'] = $this->authex->getGebruikerInfo();
		
		$partials = array('menu' => 'main_menu','inhoud' => 'MM/nieuweRit');
        $this->template->load('main_master', $partials, $data);
		
	}
	
}

