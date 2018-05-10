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
            $data['author'] = 'L. Cleymans';


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
        $data['author'] = 'L. Cleymans';
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
        $data['author'] = 'L. Cleymans';
        $this->load->model('gebruiker_model');

        $data['gebruiker'] = $this->authex->getGebruikerInfo();
        $data['gebruikerMM'] = $this->gebruiker_model->get($id);

        $data['adressen'] = $this->rit_model->getAllVoorGebruiker($data['gebruikerMM']->id);

        $partials = array('menu' => 'main_menu','inhoud' => 'coach/nieuweRit');
        $this->template->load('main_master', $partials, $data);
    }

    public function wijzigRit($id){

        $this->load->model('rit_model');
        $data['titel'] = 'Wijzig rit';
        $data['author'] = 'L. Cleymans';

        $data['gebruiker'] = $this->authex->getGebruikerInfo();
        $this->load->model('gebruiker_model');
        $data['heen'] = $this->rit_model->getByRitId($id);
        var_dump($data['heen']);

       $data['gebruikerMM'] = $this->gebruiker_model->get($data['heen']->gebruikerMinderMobieleId);
        $data['adressen'] = $this->rit_model->getAllVoorGebruiker($data['heen']->gebruikerMinderMobieleId);


        $partials = array('menu' => 'main_menu','inhoud' => 'coach/wijzigRit');
        $this->template->load('main_master', $partials, $data);
    }

    public function eenRit($ritId){
        $this->load->model('rit_model');
        $data['rit'] = $this->rit_model->getByRitId($ritId);

        $data['titel'] = 'Details rit';
        $data['author'] = 'L. Cleymans';


        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu','inhoud' => 'coach/rit');
        $this->template->load('main_master', $partials, $data);
    }
	
    public function statusAanpassen($ritId){
        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker == null) {
            redirect('gebruiker/inloggen');
        }
        $this->load->model('rit_model');
        $this->rit_model->updateStatusRitten($ritId, (int)$this->input->post('statusId'));

        redirect('coach/ritten');
    }
	
    public function berekenCredits(){
        $this->load->model('gebruiker_model');

        $userId = htmlspecialchars(trim($_POST['userId']));

        $date = str_replace('/', '-', htmlspecialchars(trim($_POST['date'])));

        $credits = $this->gebruiker_model->getCredits($userId, date("Y-m-d G:i:s", strtotime($date)));

        echo json_encode($credits);
    }
	
    public function berekenKost(){
        $this->load->model('google_model');
        $this->load->model('instelling_model');

        $startAdres = htmlspecialchars(trim($_POST['startAdres']));
        $eindAdres = htmlspecialchars(trim($_POST['eindAdres']));
        $timeStamp = htmlspecialchars(trim($_POST['timeStamp']));

        $afstand = $this->google_model->getReisTijd($startAdres, $eindAdres, $timeStamp);
        $afstand->kostPerKm = $this->instelling_model->getValueById(2);

        echo json_encode ($afstand);
    }
	
    public function nieuwAdres(){
        $this->load->model('adres_model');
        //check of adres al bestaat
        $bestaat = $this->adres_model->bestaatAdres(htmlspecialchars(trim($_POST['huisnummer'])), htmlspecialchars(trim($_POST['straat'])), htmlspecialchars(trim($_POST['gemeente'])), htmlspecialchars(trim($_POST['postcode'])));
        if($bestaat != false){
            echo json_encode ($this->adres_model->getById($bestaat));
        }else{
            $id = $this->adres_model->addAdres(htmlspecialchars(trim($_POST['huisnummer'])), htmlspecialchars(trim($_POST['straat'])), htmlspecialchars(trim($_POST['gemeente'])), htmlspecialchars(trim($_POST['postcode'])));
            echo json_encode ($this->adres_model->getById($id));
        }
    }
	
    public function wijzigRitOpslaan(){


        $this->load->model('rit_model');

        $mmId = htmlspecialchars(trim($_POST['userId']));
        $heenDatum = htmlspecialchars(trim($_POST['heenDatum']));
        $startTijdHeen = htmlspecialchars(trim($_POST['startTijdHeen']));
        $heenStartAdresId = htmlspecialchars(trim($_POST['heenStartAdres']));
        $heenEindeAdresId = htmlspecialchars(trim($_POST['heenEindeAdres']));
        $opmerkingenMM = htmlspecialchars(trim($_POST['opmerkingenMM']));
        $kost = htmlspecialchars(trim($_POST['kost']));
        if(isset($_POST['heenTerug'])){
            $heenTerug = true;
            $terugDatum = htmlspecialchars(trim($_POST['terugDatum']));
            $startTijdTerug = htmlspecialchars(trim($_POST['startTijdTerug']));
            $terugStartAdresId = htmlspecialchars(trim($_POST['terugStartAdres']));
            $terugEindeAdresId = htmlspecialchars(trim($_POST['terugEindeAdres']));
        }else{
            $heenTerug = false;
            $terugDatum = '';
            $startTijdTerug = '';
            $terugStartAdresId = '';
            $terugEindeAdresId = '';
        }

        $ritId = $this->rit_model->saveNewRit($mmId, $opmerkingenMM, '', $kost,  '', '3', $heenTerug, $heenStartAdresId, $heenEindeAdresId, $terugStartAdresId, $terugEindeAdresId, $startTijdHeen, $startTijdTerug, $heenDatum, $terugDatum);

        redirect('coach/ritten');

    }





}

