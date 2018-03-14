<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ritten extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['titel'] = 'Ritten';
        $data['author'] = 'Michiel O.';
        
        $data['gebruiker'] = $this->authex->getGebruikerInfo();
 
        $this->load->model('ritten_model');
        $data['ritten'] = $this->ritten_model->getById(114);

        $partials = array('menu' => 'main_menu','inhoud' => 'MM/ritten');
        $this->template->load('main_master', $partials, $data);
    }


	
}

