<?php

/**
 * @class Instellingen
 * @brief Controller-klasse voor de algemene instellingen te wijzigen
 * 
 * Controller-klase met alle methodes die gebruikt worden om de algemene instellingen te wijzigen.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Instellingen extends CI_Controller {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Toont het scherm om alle instellingen te wijzigen in de view admin/instellingenWijzigenPagina.php.
     * 
     * @see admin/instellingenWijzigenPagina.php
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function index() {
        $data['titel'] = 'Instellingen';
        $data['author'] = 'G. Wuyts';

        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null){
            $data['gebruiker'] = $gebruiker;
        } else{
            redirect('gebruiker/inloggen');
        }

        foreach ($gebruiker->functies as $functie) {
            if ($functie->id != 5) {//id=5 -> Admin
                redirect('admin/instellingen/toonfoutonbevoegd');
            }
        }
        
        $this->load->model('instelling_model');
        $data['instellingen'] = $this->instelling_model->getAll();
        
        $this->load->model('voorkeur_model');
        $data['voorkeuren'] = $this->voorkeur_model->getAll();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'admin/instellingenWijzigenPagina');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Gaat eerst kijken welke knop er juist is ingedrukt (Wijzigen, Verwijderen of Toevoegen).\n\n
     *
     * Bij wijzigen gaat de data uit het form in een nieuw voorkeur object worden gestoken.
     * Dit object wordt dan doorgestuurd om de voorkeur te wijzigen via het Voorkeur_model.\n\n
     *
     * Bij verwijderen gaat de voorkeur worden verwijderd via het Voorkeur_model. Wanneer dit niet is gelukt wordt
     * er een melding getoond via Instellingen::toonFoutVoorkeurInGebruik().\n\n
     *
     * Wanneer het geen van vorige knoppen was wilt dit zeggen dat er op toevoegen is gedrukt.
     * De voorkeur wordt toegevoegd via de private functie Instellingen::voegVoorkeurToe();
     * In deze private functie gaat er eerst worden gekeken of het veld niet leeg is gelaten, wanneer dit wel is word een melding getoond via
     * Instellingen::toonFoutVoorkeurToevoegen(). Wanneer het niet leeg is wordt de informatie toegevoegd aan een leeg voorkeur
     * object. Wanneer deze voorkeur toch een id heeft dat niet =0 word er weer de zelfde fout getoond. Wanneer het id=0
     * zal er gekeken worden of er al een voorkeur bestaat met dezelfde naam via het Voorkeur_model. Als de voorkeur al bestaat
     * wordt er een melding getoond via Instellingen::toonFoutBestaatAl(), anders wordt de voorkeur toegevoegd via het Voorkeur_model.\n\n
     *
     * Na elke actie wordt de pagina opnieuw opgeroepen via Instellingen::index().
     *
     * @see Voorkeur_model::wijzigen()
     * @see Voorkeur_model::verwijderen()
     * @see Voorkeur_model::getByNaam()
     * @see Voorkeur_model::voegToe()
     * @see Instellingen::toonFoutVoorkeurInGebruik()
     * @see Instellingen::toonFoutVoorkeurToevoegen()
     * @see Instellingen::toonFoutBestaatAl()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function voorkeurBeheren(){
        $this->load->model('voorkeur_model');

        $wijzigenKnop = $this->input->post('voorkeurWijzigen');
        $verwijderKnop = $this->input->post('voorkeurVerwijderen');

        if (isset($wijzigenKnop)){
            $voorkeur = new stdClass();
            $voorkeur->id = $this->input->post('voorkeurId');
            $voorkeur->naam = $this->input->post('teWijzigeVoorkeur');

            $this->voorkeur_model->wijzigen($voorkeur);

            redirect('admin/instellingen');
        } elseif (isset($verwijderKnop)){
            $id = $this->input->post('voorkeurId');

            if(!$this->voorkeur_model->verwijderen($id)){
                redirect('admin/instellingen/toonfoutvoorkeuringebruik');
            }

            redirect('admin/instellingen');
        } else{
            $voorkeur = new stdClass();

            $voorkeur->id = $this->input->post('id');
            $voorkeur->naam = $this->input->post('nieuweVoorkeur');
            $this->voegVoorkeurToe($voorkeur);
        }
    }

    private function voegVoorkeurToe($voorkeur){
        $this->load->model('voorkeur_model');
        if ($voorkeur->naam != ""){
            if ($voorkeur->id == 0){
                if ($this->voorkeur_model->getByNaam($voorkeur->naam) == null){
                    $this->voorkeur_model->voegToe($voorkeur);
                } else{
                    redirect('admin/instellingen/toonfoutbestaatal');
                }
            }
            else{
                redirect('admin/instellingen/toonfoutvoorkeurtoevoegen');
            }

            redirect('admin/instellingen');
        } else{
            redirect('admin/instellingen/toonfoutvoorkeurtoevoegen');
        }
    }

    /**
     * Gaat kijken of instellingen zijn gewijzigd (nieuwe waarde ingevuld), wanneer dit niet zo is wordt een melding getoond
     * via Instellingen::toonFoutGeenWaardes(). Wanneer er wel instellingen zijn gewijzigd zullen deze ook gewijzigd worden
     * in de tabel via het Instelling_model en wordt een melding getoond via Instellingen::toonInstellingGewijzigd().
     *
     * @see Instelling_model::wijzig()
     * @see Instellingen::toonFoutGeenWaardes()
     * @see Instellingen::toonInstellingGewijzigd()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function wijzigInstellingen(){
        $this->load->model('instelling_model');
        $instellingen = $this->instelling_model->getAll();
        $gewijzigd = false;

        foreach ($instellingen as $instelling){
            $waarde = $this->input->post($instelling->naam);
            if ($waarde != null) {
                $instelling->waarde = str_replace(",",".",$waarde);
                $gewijzigd = true;
            }
        }

        if(!$gewijzigd){
            redirect('admin/instellingen/toonfoutgeenwaardes');
        }

        $this->instelling_model->wijzig($instellingen);

        redirect('admin/instellingen/tooninstellinggewijzigd');
    }

    /**
     * Toont de melding pagina met de opgeven parrameters foutTitel=$foutTitel, boodschap=$boodschap & link=$link
     * in de view main_melding.php.
     *
     * @param $foutTitel De titel die op de meldingspagina komt
     * @param $boodschap De boodschap dat getoond moet worden
     * @param $link De link en naam die wordt getoond om eventueel naar een andere pagina te gaan
     *
     * @see main_melding.php
     */
    public function toonMelding($foutTitel, $boodschap, $link) {
        $data['titel'] = '';
        $data['author'] = 'G. Wuyts';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $data['foutTitel'] = $foutTitel;
        $data['boodschap'] = $boodschap;
        $data['link'] = $link;

        $partials = array('menu' => 'main_menu', 'inhoud' => 'main_melding');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Dit zal Instellingen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Instellingen::toonMelding()
     */
    public function toonFoutOnbevoegd() {
        $titel = "Fout!";
        $boodschap = "U bent niet bevoegd deze functie te gebruiken met dit account.</br>"
            . "Log in met een account dat wel bevoegd is!";
        $link = array("url" => "home", "tekst" => "Home");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Instellingen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Instellingen::toonMelding()
     */
    public function toonFoutGeenWaardes() {
        $titel = "Fout!";
        $boodschap = "U heeft geen nieuwe waardes opgegeven.</br>"
            . "Probeer opnieuw!";
        $link = array("url" => "admin/instellingen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Instellingen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Instellingen::toonMelding()
     */
    public function toonFoutVoorkeurInGebruik() {
        $titel = "Fout!";
        $boodschap = "U probeerde een voorkeur te verwijderen die nog in gebruik is door iemand.</br>"
            . "Zorg eerst dat deze niet meer gebruikt wordt en probeer dan opnieuw!";
        $link = array("url" => "admin/instellingen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Instellingen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Instellingen::toonMelding()
     */
    public function toonFoutVoorkeurToevoegen() {
        $titel = "Fout!";
        $boodschap = "Er is iets foutgelopen bij het toevoegen.</br>"
            . "Probeer het opnieuw!";
        $link = array("url" => "admin/instellingen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Instellingen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Instellingen::toonMelding()
     */
    public function toonFoutBestaatAl() {
        $titel = "Fout!";
        $boodschap = "U probeerde een voorkeur toe te voegen die al bestaat.</br>"
            . "Probeer het opnieuw met een andere naam!";
        $link = array("url" => "admin/instellingen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Instellingen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Instellingen::toonMelding()
     */
    public function toonInstellingGewijzigd() {
        $titel = "Succes!";
        $boodschap = "De instellingen zijn succesvol gewijzigd!";
        $link = array("url" => "admin/instellingen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }
}
