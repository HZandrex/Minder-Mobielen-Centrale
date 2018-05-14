<?php
/**
 * @file coach/Ritten.php
 *
 * Controller waarin de alle functies die een coach gebruikt wordt beschreven.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Ritten extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        /**
         * Deze functie laad de tabel vol met alle ritten die de coach kan zien, dus alleen van de MM die hij beheerd
         *
         * @see Gemaakt door Lore Cleymans
         */


        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null){
            $this->load->model('coachMinderMobiele_model');
			$this->load->model('status_model');
            $data['gebruiker'] = $this->authex->getGebruikerInfo();
            $id = $data['gebruiker']->id;
			$data['statussen'] = $this->status_model->getAll();

            $data['test']=count($this->coachMinderMobiele_model->getById($id));
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
        /**
         * Deze functie geeft een foutmelding, deze kan opgeroepen worden door eender welke functie.
         *
         * @see Gemaakt door Loren Cleymans
         */
        $titel = "Fout!";
        $boodschap = "U moet ingelogd zijn om deze functie te kunnen gebruiken";
        $link = array("url" => "gebruiker/inloggen", "tekst" => "Ga naar login");

        $this->toonMelding($titel, $boodschap, $link);
    }

    public function toonMelding($foutTitel, $boodschap, $link) {
        /**
         * Deze functie roept een foutmelding aan, hier kan je kiezen welke foutmelding je kan oproepen.
         *
         * @see Gemaakt door Loren Cleymans
         */
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
        /**
         * Deze functie zorgt er voor dat er een nieuwe rit wordt toegevoegd in de database.
         *
         * @see Gemaakt door Loren Cleymans
         */
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
        /**
         * Deze functie zorgt er voor dat er een rit kan worden gewijzigd je krijgt een id mee en alle waarden die moeten aangepast worden. Deze past ook alles aan in de database
         *
         * @see Gemaakt door Lorenz Cleymans
         */
        $this->load->model('rit_model');
        $data['titel'] = 'Wijzig rit';
        $data['author'] = 'L. Cleymans';

        $data['gebruiker'] = $this->authex->getGebruikerInfo();
        $this->load->model('gebruiker_model');
        $data['heen'] = $this->rit_model->getByRitId($id);

        $data['gebruikerMM'] = $this->gebruiker_model->get($data['heen']->gebruikerMinderMobieleId);
        $data['adressen'] = $this->rit_model->getAllVoorGebruiker($data['heen']->gebruikerMinderMobieleId);


        $partials = array('menu' => 'main_menu','inhoud' => 'coach/wijzigRit');
        $this->template->load('main_master', $partials, $data);
    }

    public function eenRit($ritId){
        /**
         * Deze functie zorgt er voor dat er een rit kan kan worden weergeven, ook alle details van die rit.
         *
         * @see Gemaakt door Lorenz Cleymans
         */
        $this->load->model('rit_model');
        $data['rit'] = $this->rit_model->getByRitId($ritId);

        $data['titel'] = 'Details rit';
        $data['author'] = 'L. Cleymans';


        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu','inhoud' => 'coach/rit');
        $this->template->load('main_master', $partials, $data);
    }
	
    public function statusAanpassen($ritId){
        /**
         * Deze functie zorgt er voor dat de status kan aangepast worden van een rit, er wordt een rit meegegeven en zo kan de volgende functie deze herkenen.
         *
         * @see rit_model::updateStatusRitten()
         * @see Gemaakt door Lorenz Cleymans
         */
        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker == null) {
            redirect('gebruiker/inloggen');
        }
        $this->load->model('rit_model');
        $this->rit_model->updateStatusRitten($ritId, (int)$this->input->post('statusId'));

        redirect('coach/ritten');
    }
	
    public function berekenCredits(){
        /**
         * Deze functie zorgt er voor dat de credits van een MM worden weergegeven.
         *
         * @see gebruiker_model::getCredits()
         * @see Gemaakt door Michiel Olijslagers
         */
        $this->load->model('gebruiker_model');

        $userId = htmlspecialchars(trim($_POST['userId']));

        $date = str_replace('/', '-', htmlspecialchars(trim($_POST['date'])));

        $credits = $this->gebruiker_model->getCredits($userId, date("Y-m-d G:i:s", strtotime($date)));

        echo json_encode($credits);
    }
	
    public function berekenKost(){
        /**
         * Deze functie zorgt er voor dat de kost voor van punt A naar punt B te gaan berekend kan worden.
         *
         * @see google_model::getReisTijd()
         * @see instelling_model::getValueById()
         * @see Gemaakt door Michiel Olijslagers
         */

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
        /**
         * Deze functie zorgt er voor dat de er een nieuw adres in de select kan worden toegevoegd. Dit met behuld van Google.
         *
         * @see adres_model::bestaatAdres()
         * @see adres_model::addAdres()
         * @see Gemaakt door Michiel Olijslagers
         */
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
        /**
         * Deze functie zorgt er voor dat de wijzigen van een rit kunnnen worden opgeslagen deze zal verder verwijzen naar de database waar het wordt opgeslagen.
         *
         * @see rit_model::saveNewRit()
         * @see Gemaakt door Michiel Olijslagers
         * @see Aangepast door Lorenz Cleymans
         */

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
    public function nieuweRitOpslaan(){
        /**
         * Deze functie is het einde van een nieuwe rit, hier zal een rit in de database gestoken worden.
         *
         * @see rit_model::saveNewRit()
         * @see Gemaakt door Michiel Olijslagers
         * @see Aangepast door Lorenz Cleymans voor coach
         */
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

        redirect('coach/ritten');
    }





}

