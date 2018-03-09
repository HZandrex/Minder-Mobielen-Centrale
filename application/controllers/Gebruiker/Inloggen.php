<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inloggen extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function inloggen() {
        $data['titel'] = '';
        $data['author'] = 'Geffrey W.';

        $partials = array('inhoud' => 'Gebruiker/inlogPagina');
        $this->template->load('main_master', $partials, $data);
    }

}