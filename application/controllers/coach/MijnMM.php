<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MijnMM extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
	
	    public function toonMelding($foutTitel, $boodschap, $link)
    {
        $data['titel'] = '';
        $data['author'] = 'Tijmen E.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $data['foutTitel'] = $foutTitel;
        $data['boodschap'] = $boodschap;
        $data['link'] = $link;

        $partials = array('menu' => 'main_menu', 'inhoud' => 'main_melding');
        $this->template->load('main_master', $partials, $data);
    }

    public function mijnMMLijst() {
		$data['titel'] = 'Mijn MM';
        $data['author'] = 'Tijmen E.';
		
		$gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null){
            $data['gebruiker'] = $gebruiker;
        } else{
            redirect('gebruiker/inloggen');
        }
		
		
		$this->load->model('coachMinderMobiele_model');
		$data['minderMobielen'] = $this->coachMinderMobiele_model->getMMById($gebruiker->id);
		
		$partials = array('menu' => 'main_menu', 'inhoud' => 'coach/mijnMM');
        $this->template->load('main_master', $partials, $data);
	}
	
	public function haalAjaxOp_GebruikerInfo()
    {
        $gebruikerId = $this->input->get('gebruikerId');

        $this->load->model('gebruiker_model');
        $data['selectedGebruiker'] = $this->gebruiker_model->getWithFunctions($gebruikerId);
        $this->load->view('coach/ajax_gebruikerInfo', $data);
    }
	
	public function gegevensWijzigen($id = 0){
        $data['titel'] = 'Gebruiker Gegevens Wijzigen';
        $data['author'] = 'Geffrey Wuyts';

        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null) {
            $data['gebruiker'] = $gebruiker;
        } else {
            redirect('gebruiker/inloggen');
        }
        foreach ($gebruiker->functies as $functie) {
            if ($functie->id != 2) {//id=2 -> Coach
                redirect('admin/instellingen/toonfoutonbevoegd');
            }
        }

        if ($id == 0) {
            $this->load->model('gebruiker_model');
            $data['editGebruiker'] = $this->gebruiker_model->getEmpty();
        } else {
            $this->load->model('gebruiker_model');
            $data['editGebruiker'] = $this->gebruiker_model->getWithFunctions($id);
        }

        $this->load->model('adres_model');
        $data['adressen'] = $this->adres_model->getAll();

        $this->load->model('voorkeur_model');
        $data['voorkeuren'] = $this->voorkeur_model->getAll();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'coach/gegevensWijzigen');
        $this->template->load('main_master', $partials, $data);
    }
	
	public function gegevensVeranderen(){
        $this->load->model('gebruiker_model');
        $this->load->model('adres_model');

        $gebruiker = $this->gebruiker_model->getEmpty();
        foreach ($gebruiker as $attribut => $waarde){
            $post = $this->input->post($attribut);
            if($post != null) {
                $gebruiker->$attribut = $post;
            }
        }
        if($gebruiker->id == null){
            $gebruiker->id = $this->gebruiker_model->insertGebruiker($gebruiker);
        }
        else{
            $this->gebruiker_model->updateGebruiker($gebruiker);
        }
        redirect('coach/mijnMM/toonGegevensGewijzigd');
    }
	
	public function wachtwoordWijzigen($id)
    {
        $data['titel'] = '';
        $data['author'] = 'Tijmen E.';

        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null) {
            $data['gebruiker'] = $gebruiker;
        } else {
            redirect('gebruiker/inloggen');
        }

        foreach ($gebruiker->functies as $functie) {
            if ($functie->id != 2) {//id=2 -> Coach
                redirect('admin/instellingen/toonfoutonbevoegd');
            }
        }

        $this->load->model('gebruiker_model');
        $data['editGebruiker'] = $this->gebruiker_model->getWithFunctions($id);

        $partials = array('menu' => 'main_menu', 'inhoud' => 'coach/wachtwoordGebruikerWijzigen');
        $this->template->load('main_master', $partials, $data);
    }
	
	public function wachtwoordVeranderen()
    {
        $id = $this->input->post('id');
        $Wachtwoord = $this->input->post('wachtwoord');
        $wachtwoordBevestigen = $this->input->post('wachtwoordBevestigen');

        $this->load->model('gebruiker_model');

        if ($Wachtwoord == $wachtwoordBevestigen) {
            $this->gebruiker_model->wijzigWachtwoordGebruiker($id, $Wachtwoord);
            redirect('coach/mijnMM/toonwachtwoordgewijzigd');
        } else {
            redirect('coach/mijnMM/toonfoutwachtwoordwijzigen/' . $id);
        }
    }
	
	public function toonFoutWachtwoordWijzigen($id)
    {
        $titel = "Fout!";
        $boodschap = "De opgegeven wachtwoorden komen niet overeen.</br>"
            . "Probeer opnieuw!";
        $link = array("url" => "coach/mijnMM/wachtwoordWijzigen/" . $id, "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }
	
	public function toonWachtwoordGewijzigd()
    {
        $titel = "Wachtwoord succesvol veranderd";
        $boodschap = "het wachtwoord werd succesvol gewijzigd.</br>"
            . "De gebruiker kan nu gewoon inloggen met het nieuwe wachtwoord.";
        $link = array("url" => "coach/mijnMM/mijnMMLijst", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }
	
	public function toonGegevensGewijzigd()
    {
        $titel = "Gegevens succesvol veranderd";
        $boodschap = "De gebruiker zijn gegevens werden succesvol veranderd.</br>"
            . "De gebruiker kan deze veranderingen ook zien.";
        $link = array("url" => "coach/mijnMM/mijnMMLijst", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }
	
}

