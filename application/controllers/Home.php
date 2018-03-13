<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['titel'] = 'Home';
        $data['author'] = 'Nico C.';
         
        $this->load->model('webinfo_model');
        $data['webinfo'] = $this->webinfo_model->get();
        
        $data['gebruiker']  = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'Gebruiker/homePagina');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function test() {
        $data['titel'] = 'Home';
        $data['author'] = 'Geffrey W.';
        
        $data['gebruiker']  = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'test');
        $this->template->load('main_master', $partials, $data);
    }
}
