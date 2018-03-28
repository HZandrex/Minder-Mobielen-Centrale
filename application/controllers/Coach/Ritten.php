<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ritten extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
//        $lid = 9;
//        $this->load->model('rit_model');
        $this->load->model('functiegebruiker_model');
//        $this->load->model('gebruiker_model');

        $data['naam']= $this->functiegebruiker_model->getByMMId();
//        $data['MM']= array();

//        foreach ($data['naam'] as $mm){
//            array_push($data['MM'], $this->gebruiker_model->get($mm->id));
//        }

//        $data['ritten'] = $this->rit_model->getByMMCId($lid);

        $data['titel'] = 'Ritten';
        $data['author'] = 'Lorenz C.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu','inhoud' => 'Coach/ritten');
        $this->template->load('main_master', $partials, $data);
        
    }



	
}

