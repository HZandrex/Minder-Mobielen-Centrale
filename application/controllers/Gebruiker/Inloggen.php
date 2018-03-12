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
        
        $data['fout'] = '';

        $partials = array('menu' => 'main_menu', 'inhoud' => 'Gebruiker/inlogPagina');
        $this->template->load('main_master', $partials, $data);
    }

        public function toonFout()
	{
            $data['titel'] = '';
            $data['author'] = 'Geffrey W.';
            $data['gebruiker']  = $this->authex->getGebruikerInfo();

            $data['fout'] = "Fout: De opgegeven gebruikersnaam en wachtwoord komen niet overeen";

            $partials = array('menu' => 'main_menu', 'inhoud' => 'Gebruiker/inlogPagina');
            $this->template->load('main_master', $partials, $data);
        }
        
        public function controleerLogin()
	{
            $email = $this->input->post('email');
            $wachtwoord = $this->input->post('wachtwoord');
            
            if ($this->authex->meldAan($email, $wachtwoord)) {
                redirect('home');
            } else {
                redirect('gebruiker/inloggen/toonFout');
            }
        } 
        
        public function loguit()
	{
            $this->authex->meldAf();
            redirect('home/index');
        } 

}