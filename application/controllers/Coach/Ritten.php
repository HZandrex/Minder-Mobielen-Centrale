<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ritten extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['titel'] = 'Ritten';
        $data['author'] = 'Lorenz C.';
        
        $data['gebruiker'] = $this->authex->getGebruikerInfo();
 
        $this->load->model('rit_model');
        $data['ritten'] = $this->rit_model->getById(9);


        $partials = array('menu' => 'main_menu','inhoud' => 'Coach/ritten');
        $this->template->load('main_master', $partials, $data);
        
    }


	
}

