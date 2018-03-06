<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inloggen extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function inloggen() {
        $data['titel'] = 'Inloggen';
        $data['author'] = 'Geffrey W.';

        $partials = array('inhoud' => 'Gebruiker/inloggen');
        $this->template->load('main_master', $partials, $data);
    }

}