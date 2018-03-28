<?php

/**
 * @class Instellingen
 * @brief Controller-klasse voor de algemene instellingen te wijzigen
 * 
 * Controller-klase met alle methodes die gebruikt worden om de algemene instellingen te wijzigen.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Instellingen extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Toont het inlogscherm in de view Gebruiker/inlogPagina.php.
     * 
     * @see Gebruiker/inlogPagina.php
     */
    public function index() {
        $data['titel'] = 'Instellingen';
        $data['author'] = 'Geffrey W.';

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

        $partials = array('menu' => 'main_menu', 'inhoud' => 'admin/instellingenwijzigenpagina');
        $this->template->load('main_master', $partials, $data);
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
        $data['author'] = 'Geffrey W.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $data['foutTitel'] = $foutTitel;
        $data['boodschap'] = $boodschap;
        $data['link'] = $link;

        $partials = array('menu' => 'main_menu', 'inhoud' => 'main_melding');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     */
    public function toonFoutOnbevoegd() {
        $titel = "Fout!";
        $boodschap = "U bent niet bevoegd deze functie te gebruiken met dit account.</br>"
            . "Log in met een account dat wel bevoegd is!";
        $link = array("url" => "home", "tekst" => "Home");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     */
    public function toonFoutGeenWaardes() {
        $titel = "Fout!";
        $boodschap = "U heeft geen nieuwe waardes opgegeven.</br>"
            . "Probeer opnieuw!";
        $link = array("url" => "admin/instellingen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     */
    public function toonFoutVoorkeurInGebruik() {
        $titel = "Fout!";
        $boodschap = "U probeerde een voorkeur te verwijderen die nog in gebruik is door iemand.</br>"
            . "Zorg eerst dat deze niet meer gebruikt wordt en probeer dan opnieuw!";
        $link = array("url" => "admin/instellingen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     */
    public function toonInstellingGewijzigd() {
        $titel = "Succes!";
        $boodschap = "De instellingen zijn succesvol gewijzigd!";
        $link = array("url" => "admin/instellingen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

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
            $nieuweVoorkeur = $this->input->post('nieuweVoorkeur');
            if ($nieuweVoorkeur != ""){
                $voorkeur = new stdClass();

                $voorkeur->id = $this->input->post('id');
                $voorkeur->naam = $nieuweVoorkeur;

                $this->load->model('voorkeur_model');
                if ($voorkeur->id == 0){
                    $this->voorkeur_model->voegToe($voorkeur);
                }
                else{
                    echo "fout";
                    exit();
                }

                redirect('admin/instellingen');
            } else{
                echo "leeg";
            }

        }
    }

    public function wijzigInstellingen(){
        $this->load->model('instelling_model');
        $instellingen = $this->instelling_model->getAll();
        $gewijzigd = false;

        foreach ($instellingen as $instelling){
            $waarde = $this->input->post($instelling->naam);
            if ($waarde != null) {
                $instelling->waarde = $waarde;
                $gewijzigd = true;
            }
        }

        if(!$gewijzigd){
            redirect('admin/instellingen/toonFoutGeenWaardes');
        }

        $this->instelling_model->wijzig($instellingen);

        redirect('admin/instellingen/tooninstellinggewijzigd');
    }
}
