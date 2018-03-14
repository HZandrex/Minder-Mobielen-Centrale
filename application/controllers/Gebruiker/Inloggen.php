<?php

/**
 * @class Inloggen
 * @brief Controller-klasse voor het inloggen
 * 
 * Controller-klase met alle methodes die gebruikt worden om in te loggen
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Inloggen extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Toont het inlogscherm in de view inlogPagina.php
     * 
     * @see inlogPagina.php
     */
    public function index() {
        $data['titel'] = '';
        $data['author'] = 'Geffrey W.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'Gebruiker/inlogPagina');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Zorgt er voor dat het inlogscherm terug wordt getoond met
     * de foutmelding dat de gegevens niet kloppen in de view inlogPagina.php
     * 
     * @see inlogPagina.php
     */
    public function toonFout() {
        $data['titel'] = '';
        $data['author'] = 'Geffrey W.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $data['fout'] = '<div class="alert alert-danger">Fout: E-mail en Wachtwoord komen niet overeen, probeer opnieuw!</div>';

        $partials = array('menu' => 'main_menu', 'inhoud' => 'Gebruiker/inlogPagina');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Logt in met de Authex library door de methode meldAan($email, $wachtwoord)
     * de inloggegevens worden via de post methode binnengehaald vanuit de form
     * in de view inlogPagina.php
     * 
     * Wanneer het inloggen lukt zal Home::index() worden opgeroepen
     * wanner de gegevens fout zijn zal de methode Inloggen::toonFout() worden opgeroepen.
     * 
     * @param $email Het mail adres dat werd opgeven in de view inlogPagina.php
     * @param $wachtwoord Het wachtwoord dat werd opgeven in de view inlogPagina.php
     * @see Inloggen::toonFout()
     * @see Home::index()
     * @see inlogPagina.php
     */
    public function controleerLogin() {
        $email = $this->input->post('email');
        $wachtwoord = $this->input->post('wachtwoord');

        if ($this->authex->meldAan($email, $wachtwoord)) {
            redirect('home');
        } else {
            redirect('gebruiker/inloggen/toonFout');
        }
    }

    /**
     * Logt uit met de Authex library met de methode meldAf(), vervolgens wordt Home::index() opgeroepen
     * @see Home::index()
     */
    public function loguit() {
        $this->authex->meldAf();
        redirect('home');
    }

    public function wachtwoordVergeten() {
        $data['titel'] = '';
        $data['author'] = 'Geffrey W.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'Gebruiker/wachtwoordVergeten');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function nieuwWachtwoord(){
        
    }

    private function stuurMail($geadresseerde, $boodschap, $titel) {
        $this->load->library('email');

        $this->email->from('atworkteam23@gmail.com', 'tv-shop');
        $this->email->to($geadresseerde);
        $this->email->subject($titel);
        $this->email->message($boodschap);

        if (!$this->email->send()) {
            show_error($this->email->print_debugger());
            return false;
        } else {
            return true;
        }
    }

}
