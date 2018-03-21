<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ritten extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->model('rit_model');
        $data['ritten'] = $this->rit_model->getById(114);
		
		$data['titel'] = 'Ritten';
        $data['author'] = 'Michiel O.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu','inhoud' => 'MM/ritten');
        $this->template->load('main_master', $partials, $data);
    }

	
	public function eenRit($gebruikerId){
		
		
		
		
		$data['titel'] = 'Details rit';
        $data['author'] = 'Michiel O.';
		$data['gebruiker'] = $this->authex->getGebruikerInfo();
		
		$partials = array('menu' => 'main_menu','inhoud' => 'MM/rit');
        $this->template->load('main_master', $partials, $data);
	}

	
}

