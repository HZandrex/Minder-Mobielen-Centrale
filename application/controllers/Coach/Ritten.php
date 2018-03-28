<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ritten extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $this->load->model('coachmindermobiele_model');


        $data['ritten']= $this->coachmindermobiele_model->getById();


        $this->load->library('pagination');

        $config['base_url'] = 'Coach/ritten';
        $config['total_rows'] = 200;
        $config['per_page'] = 20;

        $this->pagination->initialize($config);

        echo $this->pagination->create_links();

        $data['titel'] = 'Ritten';
        $data['author'] = 'Lorenz C.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu','inhoud' => 'Coach/ritten');
        $this->template->load('main_master', $partials, $data);
        
    }



	
}

