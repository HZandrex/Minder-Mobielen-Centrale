<?php

/**
 * @class GebruikersBeheren
 * @brief Controller-klasse voor de gebruikers te kunnen beheren
 * 
 * Controller-klase met alle methodes die gebruikt worden voor de gebruikers te beheren.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class RelatiesBeheren extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Toont het startscherm met alle gebruikers in de view Medewerker/gebruikersBeherenOverzicht.php.
     * 
     * @see Medewerker/gebruikersBeherenOverzicht.php
     */
    public function index() {
        $data['titel'] = 'Relaties beheren';
        $data['author'] = 'N. Claes';

        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null){
            $data['gebruiker'] = $gebruiker;
        } else{
            redirect('gebruiker/inloggen');
        }
        $this->load->model('functieGebruiker_model');
        $data['gebruikers'] = $this->functieGebruiker_model->getAllGebruikersByFunction(1);

        $partials = array('menu' => 'main_menu', 'inhoud' => 'medewerker/relatiesBeherenOverzicht');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function haalAjaxOp_bijhorendeCoaches(){
        $minderMobieleId = $this->input->get('gebruikerId');
        $this->load->model('coachMinderMobiele_model');
        $data['bijhorendeCoaches'] = $this->coachMinderMobiele_model->getBijhorendeCoaches($minderMobieleId);
        $data['coaches'] = $this->coachMinderMobiele_model->getOverschotCoaches();
        
        $this->load->view('medewerker/ajax_bijhorendeCoaches', $data);
    }
    
    public function archiveerBijhorendeCoach(){
        $minderMobieleId = $this->input->get('gebruikerId');
        $coachMinderMobieleId = $this->input->get('coachMinderMobieleId');
        
        $this->load->model('coachMinderMobiele_model');
        $this->coachMinderMobiele_model->archiveerBijhorendeCoach($coachMinderMobieleId);
        $data['bijhorendeCoaches'] = $this->coachMinderMobiele_model->getBijhorendeCoaches($minderMobieleId);
        $data['coaches'] = $this->coachMinderMobiele_model->getOverschotCoaches($minderMobieleId);
        
        $this->load->view('medewerker/ajax_bijhorendeCoaches', $data);
    }
    
    public function voegToeBijhorendeCoach(){
        $minderMobieleId = $this->input->get('gebruikerId');
        $coachId = $this->input->get('coachId');
        
        $this->load->model('coachMinderMobiele_model');
        $this->coachMinderMobiele_model->voegToeBijhorendeCoach($minderMobieleId, $coachId);
        $data['bijhorendeCoaches'] = $this->coachMinderMobiele_model->getBijhorendeCoaches($minderMobieleId);
        $data['coaches'] = $this->coachMinderMobiele_model->getOverschotCoaches($minderMobieleId);
        
        $this->load->view('medewerker/ajax_bijhorendeCoaches', $data);
    }
}
