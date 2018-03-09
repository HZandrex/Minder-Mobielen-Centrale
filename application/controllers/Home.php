<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['titel'] = 'Home';
        $data['author'] = 'Nico C.';
        
        $CI = & get_instance(); 
        $CI->load->model('webinfo_model');
        $data['webinfo'] = $CI->webinfo_model->get();
        
        $data['gebruiker']  = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'Gebruiker/homePagina');
        $this->template->load('main_master', $partials, $data);
    }

}
