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
        $this->load->library('table');
        $config['base_url'] = '/project23_1718/index.php/coach/Ritten';
        $config['total_rows'] = count($this->coachmindermobiele_model->getById());
        $config['per_page'] =2;
        $config['num_links']=3;

        $this->pagination->initialize($config);



        $data['titel'] = 'Ritten';
        $data['author'] = 'Lorenz C.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu','inhoud' => 'Coach/ritten');
        $this->template->load('main_master', $partials, $data,$config);
        
    }



	
}

