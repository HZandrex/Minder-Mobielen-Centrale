<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inloggen extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['titel'] = '';
        $data['author'] = 'Geffrey W.';
        $data['gebruiker']  = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'Gebruiker/inlogPagina');
        $this->template->load('main_master', $partials, $data);
    }
        
        public function toonFout()
	{
            $data['titel'] = 'Fout';
            $data['gebruiker']  = $this->authex->getGebruikerInfo();
            
            $partials = array('hoofding' => 'main_header',
                'menu' => 'main_menu',
                'inhoud' => 'home_fout',
                'voetnoot' => 'main_footer');
            
            $this->template->load('main_master', $partials, $data);
        }
        
        public function controleerLogin()
	{
            $email = $this->input->post('email');
            $wachtwoord = $this->input->post('wachtwoord');
            
            if ($this->authex->meldAan($email, $wachtwoord)) {
                echo $this->session->userdata('gebruiker_id');
            } else {
                redirect('home');
            }
        } 
        
        public function loguit()
	{
            $this->authex->meldAf();
            redirect('home/index');
        } 

}