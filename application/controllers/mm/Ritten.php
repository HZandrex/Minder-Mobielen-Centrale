<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
	* @class Ritten
	* @brief Controller-klasse voor ritten
	*
	*Controller-klasse met alle methodes om ritten op te halen
*/
class Ritten extends CI_Controller {

    public function __construct() {
        parent::__construct();	
    }

	/**
		*Haalt al de informatie op van al de ritten op van de ingelogde minder mobiele
		*
		*@see Rit_model::getByMMCId()
		*
	*/	
    public function index($startRij = 0) {
		$data['titel'] = 'Ritten';
        $data['author'] = 'Michiel O.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();
		
        $this->load->model('rit_model');		
		
		$data['ritten'] = $this->rit_model->getByMMCId($data['gebruiker']->id);

        $partials = array('menu' => 'main_menu','inhoud' => 'mm/ritten');
        $this->template->load('main_master', $partials, $data);
    }

	/**
		*Haalt al de informatie op van al een bepaalde rit waar het id van meegegeven wordt
		*
		*@param $ritId Dit is het id van de gevraagde rit
		*@see Rit_model::getByRitId()
		*
	*/
	public function eenRit($ritId){		
		$this->load->model('rit_model');
		$data['rit'] = $this->rit_model->getByRitId($ritId);
		
		$data['titel'] = 'Details rit';
        $data['author'] = 'Michiel O.';
		$data['gebruiker'] = $this->authex->getGebruikerInfo();
		
		$partials = array('menu' => 'main_menu','inhoud' => 'mm/rit');
        $this->template->load('main_master', $partials, $data);
	}
	
	public function nieuweRit(){
		$this->load->model('rit_model');
		$data['titel'] = 'Nieuwe rit';
        $data['author'] = 'Michiel O.';
		$data['gebruiker'] = $this->authex->getGebruikerInfo();
		
		$data['adressen'] = $this->rit_model->getAllVoorGebruiker($data['gebruiker']->id);
		
		$partials = array('menu' => 'main_menu','inhoud' => 'mm/nieuweRit');
        $this->template->load('main_master', $partials, $data);
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
	
	public function berekenCredits(){
		$this->load->model('gebruiker_model');
		
		$userId = htmlspecialchars(trim($_POST['userId']));

		$date = str_replace('/', '-', htmlspecialchars(trim($_POST['date'])));
		
		$credits = $this->gebruiker_model->getCredits($userId, date("Y-m-d G:i:s", strtotime($date)));
		
		echo json_encode($credits);
	}
	
	public function nieuweRitOpslaan(){
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
		
		redirect('mm/ritten');
	}

    public function wijzigRit($id){

        $this->load->model('rit_model');
        $data['titel'] = 'Wijzig rit';
        $data['author'] = 'Lorenz C.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $data['adressen'] = $this->rit_model->getAllVoorGebruiker($data['gebruiker']->id);

        $data['heen'] = $this->rit_model->getByRitId($id);

        $partials = array('menu' => 'main_menu','inhoud' => 'mm/wijzigRit');
        $this->template->load('main_master', $partials, $data);

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

        redirect('mm/ritten');

    }
    public function statusAanpassen($ritId){
        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker == null) {
            redirect('gebruiker/inloggen');
        }
        $this->load->model('rit_model');
        $this->rit_model->updateStatusRitten($ritId, (int)$this->input->post('statusId'));

        redirect('mm/ritten');
    }
	
}

