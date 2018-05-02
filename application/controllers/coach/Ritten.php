<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ritten extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {



        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null){
            $this->load->model('coachMinderMobiele_model');
            $data['gebruiker'] = $this->authex->getGebruikerInfo();
            $id = $data['gebruiker']->id;

            $data['test']=count($this->coachMinderMobiele_model->getById($id));

//            $this->load->library('pagination');
//            $this->load->library('table');
//
//
//            $config['base_url'] = 'http://localhost/project23_1718/index.php/Coach/Ritten/index';
//
//            $config['total_rows'] = count($this->coachmindermobiele_model->getById($id));
//            $config['per_page'] =2;

//            $this->pagination->initialize($config);
            $data['ritten']= $this->coachMinderMobiele_model->getById($id);
            $data['titel'] = 'Ritten';
            $data['author'] = 'Lorenz C.';


            $partials = array('menu' => 'main_menu','inhoud' => 'coach/ritten');
            $this->template->load('main_master', $partials, $data);

        } else{
            redirect('coach/ritten/toonfouturl');
        }


    }

    public function toonFoutUrl() {
        $titel = "Fout!";
        $boodschap = "U moet ingelogd zijn om deze functie te kunnen gebruiken";
        $link = array("url" => "gebruiker/inloggen", "tekst" => "Ga naar login");

        $this->toonMelding($titel, $boodschap, $link);
    }

    public function toonMelding($foutTitel, $boodschap, $link) {
        $data['titel'] = '';
        $data['author'] = 'Lorenz C.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $data['foutTitel'] = $foutTitel;
        $data['boodschap'] = $boodschap;
        $data['link'] = $link;

        $partials = array('menu' => 'main_menu', 'inhoud' => 'main_melding');
        $this->template->load('main_master', $partials, $data);
    }

    public function nieuweRit($id){
        $this->load->model('rit_model');
        $data['titel'] = 'Nieuwe rit';
        $data['author'] = 'Lorenz C.';
        $this->load->model('gebruiker_model');

        $data['gebruiker'] = $this->authex->getGebruikerInfo();
        $data['gebruikerMM'] = $this->gebruiker_model->get($id);

        $data['adressen'] = $this->rit_model->getAllVoorGebruiker($data['gebruikerMM']->id);

        $partials = array('menu' => 'main_menu','inhoud' => 'mm/nieuweRit');
        $this->template->load('main_master', $partials, $data);
    }




}

