<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @class Home
 * @brief Controller-klasse voor de Webinfo te laden (beginpagina)
 * 
 * Controller-klase met alle methodes die gebruikt worden om Webinfo (de beginpagina) weer te geven
 */
class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Haalt al de webinfo om weer te geven op via webinfo_model (deze wordt zodanig in een array gestoken
     * zodat de info makkelijk te raadplegen is) en de info van
     * de aangemelde gebruiker via de authex library, de aangemelde gebruiker zit
     * in een sessievariabelen.
     * Vervolgens wordt het resulterende object getoond in de view Gebruiker/homePagina.php
     * 
     * @see webinfo_model::getAll()
     * @see libraries/Authex.php::getGebruikerInfo()
     * @see Gebruiker/homePagina.php
     */
    public function index() {
        $data['titel'] = 'Home';
        $data['author'] = 'Nico C.';
         
        $this->load->model('webinfo_model');
        $data['webinfo'] = $this->webinfo_model->getAll();
        
        $data['gebruiker']  = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'Gebruiker/homePagina');
        $this->template->load('main_master', $partials, $data);
    }
    /*
     * Dit is puur een bootstrap test.
     */
    public function test() {
        $data['titel'] = 'Home';
        $data['author'] = 'Geffrey W.';
        
        $data['gebruiker']  = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'test');
        $this->template->load('main_master', $partials, $data);
    }
}
