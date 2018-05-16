<?php

/**
 * @class RelatiesBeheren
 * @brief Controller-klasse voor de relaties te kunnen beheren
 * 
 * Controller-klase met alle methodes die gebruikt worden voor de relaties tussen minder mobiele en coaches te beheren.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class RelatiesBeheren extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Toont het startscherm met alle gebruikers in de view Medewerker/relatiesBeherenOverzicht.php.
     * 
     * @see FunctieGebruiker_model::getAllGebruikersByFunction()
     * 
     * Gemaakt door Nico Claes
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
    
    /**
     * Toont alle bijhorende coaches van een minder mobiele in een listbox en de overige coaches in een combobox.
     * Terug te vinden in de view Medewerker/ajax_bijhorendeCoaches.php.
     * 
     * @see CoachMinderMobiele_model::getBijhorendeCoaches()
     * @see CoachMinderMobiele_model::getOverschotCoaches()
     * 
     * Gemaakt door Nico Claes
     */
    public function haalAjaxOp_bijhorendeCoaches(){
        $minderMobieleId = $this->input->get('gebruikerId');
        $this->load->model('coachMinderMobiele_model');
        $data['bijhorendeCoaches'] = $this->coachMinderMobiele_model->getBijhorendeCoaches($minderMobieleId);
        $data['coaches'] = $this->coachMinderMobiele_model->getOverschotCoaches();
        
        $this->load->view('medewerker/ajax_bijhorendeCoaches', $data);
    }
    
    /**
     * Archiveer coaches wanneer deze bij een minder mobiele hoort.
     * De pagina zal niet herladen alleen het ajax component zal refreshen.
     * 
     * @see CoachMinderMobiele_model::getAllGebruikersByFunction()
     * @see CoachMinderMobiele_model::getBijhorendeCoaches()
     * @see CoachMinderMobiele_model::getOverschotCoaches()
     * 
     * Gemaakt door Nico Claes
     */
    public function archiveerBijhorendeCoach(){
        $minderMobieleId = $this->input->get('gebruikerId');
        $coachMinderMobieleId = $this->input->get('coachMinderMobieleId');
        
        $this->load->model('coachMinderMobiele_model');
        $this->coachMinderMobiele_model->archiveerBijhorendeCoach($coachMinderMobieleId);
        $data['bijhorendeCoaches'] = $this->coachMinderMobiele_model->getBijhorendeCoaches($minderMobieleId);
        $data['coaches'] = $this->coachMinderMobiele_model->getOverschotCoaches($minderMobieleId);
        
        $this->load->view('medewerker/ajax_bijhorendeCoaches', $data);
    }
    
    /**
     * Voeg een coach toe wanneer deze niet meer bij een minder mobiele hoort.
     * De pagina zal niet herladen alleen het ajax component zal refreshen.
     * 
     * @see CoachMinderMobiele_model::voegToeBijhorendeCoach()
     * @see CoachMinderMobiele_model::getBijhorendeCoaches()
     * @see CoachMinderMobiele_model::getOverschotCoaches()
     * 
     * Gemaakt door Nico Claes
     */
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
