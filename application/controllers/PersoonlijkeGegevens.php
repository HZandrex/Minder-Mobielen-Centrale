<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PersoonlijkeGegevens extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

	//Aanpassingen nodig om ingelogde gebruiker weer te geven.
    public function persoonlijkeGegevens() {
        $data['titel'] = 'Persoonlijke Gegevens';
        $data['author'] = 'Tijmen Elseviers';
		
		$this->load->model('persoonlijke_gegevens_model');
		$data['gegevens'] = $this->persoonlijke_gegevens_model->get();
		
		var_dump($gegevens);
		exit;

        $partials = array('inhoud' => 'Gebruiker/persoonlijkeGegevens');
        $this->template->load('main_master', $partials, $data);
    }

}