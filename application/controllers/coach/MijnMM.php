<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MijnMM extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function mijnMMLijst() {
		$data['titel'] = 'Mijn MM';
        $data['author'] = 'Tijmen Elseviers';
		
		$gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null){
            $data['gebruiker'] = $gebruiker;
        } else{
            redirect('gebruiker/inloggen');
        }
		
		
		$this->load->model('coachMinderMobiele_model');
		$data['minderMobielen'] = $this->coachMinderMobiele_model->getMMById($gebruiker->id);
		
		$partials = array('menu' => 'main_menu', 'inhoud' => 'coach/mijnMM');
        $this->template->load('main_master', $partials, $data);
	}
}

