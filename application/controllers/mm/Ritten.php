<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @class Ritten
 * @brief Controller-klasse voor het Ritten
 * 
 * Controller-klasse met alle methodes om ritten op te halen
 */
class Ritten extends CI_Controller {

    public function __construct() {
        parent::__construct();	
    }
	
	/**
	 * Laat al het overzicht zien van al de ritten van de ingelogde minder mobiele
	 * 
	 * @see Rit_model::getByMMCId()
	 *
	 * Gemaakt door Michiel Olijslagers
	 */	
    public function index() {
		$data['titel'] = 'Ritten';
        $data['author'] = 'M. Olijslagers';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();
		
        $this->load->model('rit_model');	
		$data['ritten'] = $this->rit_model->getByMMCId($data['gebruiker']->id);

        $partials = array('menu' => 'main_menu','inhoud' => 'mm/ritten');
        $this->template->load('main_master', $partials, $data);
    }

	/**
	 * Laat de detail pagina zien van 1 bepaalde rit, dit is de rit waar het id van meegegeven wordt.
	 *
	 * @param $ritId Dit is het id van de gevraagde rit
	 * @see Rit_model::getByRitId()
	 * 
	 * Gemaakt door Michiel Olijslagers
	*/
	public function eenRit($ritId){	
		$data['titel'] = 'Details rit';
        $data['author'] = 'M. Olijslagers';
		$data['gebruiker'] = $this->authex->getGebruikerInfo();
		
		$this->load->model('rit_model');
		$data['rit'] = $this->rit_model->getByRitId($ritId);
		
		$partials = array('menu' => 'main_menu','inhoud' => 'mm/rit');
        $this->template->load('main_master', $partials, $data);
	}
	
	/**
		 * Zorgt ervoor dat je de pagina krijgt voor een nieuwe rit aan te maken.
		 * Deze functie gaat al de adressen ophalen die een de ingelogde gebruiker ooit gebruikt heeft.
		 *
		 * @see Rit_model::getAllVoorGebruiker()
		 * 
		 * Gemaakt door Michiel Olijslagers
		*/
	public function nieuweRit(){
		$data['titel'] = 'Nieuwe rit';
        $data['author'] = 'M. Olijslagers';
		$data['gebruiker'] = $this->authex->getGebruikerInfo();
		$data['gebruikerMM'] = $data['gebruiker'];
		
		$this->load->model('rit_model');
		$data['adressen'] = $this->rit_model->getAllVoorGebruiker($data['gebruikerMM']->id);
		
		$partials = array('menu' => 'main_menu','inhoud' => 'mm/nieuweRit');
        $this->template->load('main_master', $partials, $data);
	}
	
	/**
	 * Deze functie voegt een nieuw adres toe als dit adres nog niet bestaat. Nadat een adres ingegeven is dan zal hij dit adres terug geven
	 * Bestaat dit adres dan zal hij het bestaande adres terug geven.
	 *
	 * @see adres_model::bestaatAdres()
	 * @see adres_model::getById()
	 * @see adres_model::addAdres()
	 * @return het volledige adres
     *
	 * Gemaakt door Michiel Olijslagers
	*/
	public function nieuwAdres(){
		$this->load->model('adres_model');
		$bestaat = $this->adres_model->bestaatAdres(htmlspecialchars(trim($_POST['huisnummer'])), htmlspecialchars(trim($_POST['straat'])), htmlspecialchars(trim($_POST['gemeente'])), htmlspecialchars(trim($_POST['postcode'])));
		if($bestaat != false){
			echo json_encode ($this->adres_model->getById($bestaat));
		}else{
			$id = $this->adres_model->addAdres(htmlspecialchars(trim($_POST['huisnummer'])), htmlspecialchars(trim($_POST['straat'])), htmlspecialchars(trim($_POST['gemeente'])), htmlspecialchars(trim($_POST['postcode'])));
			echo json_encode ($this->adres_model->getById($id));
		}
	}
	
	/**
	 * Deze functie geeft in JSON de kost, de afstand en de prijs terug van een bepaalde rit waar een tijd, start- en eindAdres gegeven zijn
	 *
	 * @see google_model::getReisTijd()
     * @see instelling_model::getValueById()
     * @return Tijd, start- en eindAdres
     *
	 * Gemaakt door Michiel Olijslagers
	*/
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
	
	/**
	 * Deze functie geeft een JSON terug waar instaat hoeveel credits een bepaalde gebruiker heeft binnen 1 week
	 *
	 * @see gebruiker_model::getCredits()
	 * @return Het aantal credits dat nog over is voor de opgevraagde week bij de mindermobiele
     *
	 * Gemaakt door Michiel Olijslagers
	*/
	public function berekenCredits(){
		$this->load->model('gebruiker_model');
		
		$userId = htmlspecialchars(trim($_POST['userId']));
		$date = str_replace('/', '-', htmlspecialchars(trim($_POST['date'])));
		$credits = $this->gebruiker_model->getCredits($userId, date("Y-m-d G:i:s", strtotime($date)));
		
		echo json_encode($credits);
	}
	
	/**
	 * Deze functie is het einde van een nieuwe rit, hier zal een rit in de database gestoken worden.
	 *
	 * @see rit_model::saveNewRit()
     *
	 * Gemaakt door Michiel Olijslagers
	*/
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
			$terugDatum = htmlspecialchars(trim($_POST['heenDatum']));
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

	/**
	 * Deze functie is zorgt ervoor dat al de gegevens van een rit die gewijzigd zijn in de database komen te staan, deze worden dus geupdated.
	 *
	 * @see rit_model::getAllVoorGebruiker()
	 * @see rit_model::getByRitId()
     * @parameter deze id is van een rit zo weet de het model welke record hij moet gaan wijzigen
	 * Gemaakt door Lorenz Cleymans
	 */
    public function wijzigRit($id){
        $this->load->model('rit_model');
        $data['titel'] = 'Wijzig rit';
        $data['author'] = 'L. Cleymans';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $data['adressen'] = $this->rit_model->getAllVoorGebruiker($data['gebruiker']->id);

        $data['heen'] = $this->rit_model->getByRitId($id);

        $partials = array('menu' => 'main_menu','inhoud' => 'mm/wijzigRit');
        $this->template->load('main_master', $partials, $data);
    }

	/**
	 * Deze functie is het einde van een wijzig rit, hier zal een rit in de database gestoken worden.
	 *
	 * @see rit_model::saveNewRit()
	 *
	 * Gemaakt door Lorenz Cleymans
	 */
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
            $terugDatum = htmlspecialchars(trim($_POST['heenDatum']));
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
    
    /**
     * Verander de status van een mindermobile zijn rit.
     * 
     * @param $ritId Dit is het id van de gevraagde rit
     * 
     * @see rit_model::updateStatusRitten()
     * 
     * Gemaakt door Nico Claes
     */
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

