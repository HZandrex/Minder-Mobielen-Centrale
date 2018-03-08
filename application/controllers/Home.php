<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['titel'] = 'Home';
        $data['author'] = 'Geffrey W.';
        
        $this->load->model('webinfo_model');
        $data['webinfo'] = $this->webinfo_model->get();

        $partials = array('inhoud' => 'home');
        $this->template->load('main_master', $partials, $data);
    }

}
