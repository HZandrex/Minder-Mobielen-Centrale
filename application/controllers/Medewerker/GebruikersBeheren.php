<?php

/**
 * @class GebruikersBeheren
 * @brief Controller-klasse voor de gebruikers te kunnen beheren
 * 
 * Controller-klase met alle methodes die gebruikt worden voor de gebruikers te beheren.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class GebruikersBeheren extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Toont het startscherm met alle gebruikers in de view Medewerker/gebruikersBeherenOverzicht.php.
     * 
     * @see Medewerker/gebruikersBeherenOverzicht.php
     */
    public function index() {
        $data['titel'] = 'Gebruikers beheren';
        $data['author'] = 'Geffrey W.';

        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null){
            $data['gebruiker'] = $gebruiker;
        } else{
            redirect('gebruiker/inloggen');
        }

        foreach ($gebruiker->functies as $functie) {
            if ($functie->id != 4) {//id=4 -> Medewerker
                redirect('admin/instellingen/toonfoutonbevoegd');
            }
        }

        $this->load->model('functiegebruiker_model');
        $data['gebruikers'] = $this->functiegebruiker_model->getAllGebruikersByFunction(1);

        $this->load->model('functie_model');
        $data['functies'] = $this->functie_model->getAll(4); //4 = alle functies buiten medewerker & admin

        $partials = array('menu' => 'main_menu', 'inhoud' => 'medewerker/gebruikersbeherenoverzicht');
        $this->template->load('main_master', $partials, $data);
    }

    public function haalAjaxOp_GebruikersOpFunctie(){
        $functieId = $this->input->get('functieId');

        $this->load->model('functiegebruiker_model');
        $data['gebruikers'] = $this->functiegebruiker_model->getAllGebruikersByFunction($functieId);

        $this->load->view('medewerker/ajax_gebruikers', $data);
    }

    public function haalAjaxOp_GebruikerInfo(){
        $gebruikerId = $this->input->get('gebruikerId');

        $this->load->model('gebruiker_model');
        $data['gebruiker'] = $this->gebruiker_model->getWithFunctions($gebruikerId);

        $this->load->view('medewerker/ajax_gebruikerInfo', $data);
    }
}
