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

    public function nieuwWachtwoordAanvragen() {
        $email = $this->input->post('email');

        $this->load->model('gebruiker_model');

        if ($this->gebruiker_model->controleerEmailVrij($email)) {
            redirect('gebruiker/inloggen');
        } else {
            $resetToken = $this->random_resetToken();
            $this->gebruiker_model->wijzigResetToken($email, $resetToken);
            $titel = "Minder Mobiele Centrale aanvraag nieuw wachtwoord";
            $boodschap = 'U heeft een nieuw wachtwoord aangevraagd. Druk op onderstaande link om een nieuw wachtwoord aan te vragen.</br>'
                    . 'Wanneer u zelf geen nieuw wachtwoord hebt aangevraagd hoeft u deze mail simpel te negeren.</br>'
                    . 'Verander wachtwoord: ' . anchor('http://localhost/project23_1718/index.php/gebruiker/inloggen/wachtwoordVergetenWijzigen/' . $resetToken);
            $this->stuurMail($email, $boodschap, $titel);

            redirect('gebruiker/inloggen');
        }
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

    public function wachtwoordVergetenWijzigen($resetToken) {
        $data['titel'] = '';
        $data['author'] = 'Geffrey W.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $data['resetToken'] = $resetToken;

        $partials = array('menu' => 'main_menu', 'inhoud' => 'Gebruiker/wachtwoordVergetenWijzigen');
        $this->template->load('main_master', $partials, $data);
    }

    public function wachtwoordVeranderen() {
        $resetToken = $this->input->post('resetToken');
        $newWachtwoord = $this->input->post('wachtwoord');

        $this->load->model('gebruiker_model');

        if ($this->gebruiker_model->controleerResetToken($resetToken)) {
            echo $newWachtwoord;
        } else {
            echo 'kaka';
        }
    }

    private function random_resetToken() {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $resetToken = substr(str_shuffle($chars), 0, 10);
        return $resetToken;
    }

}
