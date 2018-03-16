<?php

/**
 * @class PersoonlijkeGegevens
 * @brief Controller-klasse voor de persoonlijke gegevens
 * 
 * Controller-klase met alle methodes die gebruikt worden om persoonlijke gegevens te beheren
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class PersoonlijkeGegevens extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

	//Aanpassingen nodig om ingelogde gebruiker weer te geven.
    public function persoonlijkeGegevens() {
        $data['titel'] = 'Persoonlijke Gegevens';
        $data['author'] = 'Tijmen Elseviers';
		
		$this->load->model('persoonlijke_gegevens_model');
		$data['gegevens'] = $this->persoonlijke_gegevens_model->get();

        $partials = array('inhoud' => 'Gebruiker/persoonlijkeGegevens');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function wachtwoordWijzigen(){
        $data['titel'] = '';
        $data['author'] = 'Geffrey W.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'Gebruiker/wachtwoordWijzigen');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function wachtwoordVeranderen() {
        $id = $this->input->post('id');
        $oudWachtwoord = $this->input->post('oudWachtwoord');
        $nieuwWachtwoord = $this->input->post('nieuwWachtwoord');
        //echo "$id $oudWachtwoord $nieuwWachtwoord";
        
        $this->load->model('gebruiker_model');
        
        $gebruiker = $this->gebruiker_model->get($id);

        if ($this->gebruiker_model->getGebruiker($gebruiker->mail, $oudWachtwoord)) {
            if ($nieuwWachtwoord == $this->input->post('wachtwoordBevestigen')) {
                $this->gebruiker_model->wijzigWachtwoord($id, $nieuwWachtwoord);
                $titel = "Minder Mobiele Centrale wachtwoord veranderd";
                $boodschap = "<p>U heeft zojuist uw wachtwoord veranderd. Noteer dit wachtwoord ergens of onthoud dit goed.</p>"
                        . "<p>Heeft u het wachtwoord niet veranderd en krijgd u deze mail, neem dan snel contact met ons op."
                        . " U vindt deze gegevens op onze site.<p>" . anchor('home', "Link naar de site van de Minder Mobiele Centrale");
                $this->stuurMail($gebruiker->mail, $boodschap, $titel);
                redirect('gebruiker/persoonlijkegegevens/toonwachtwoordveranderd');
            } else {
                redirect('gebruiker/persoonlijkegegevens/toonfoutwachtwoordovereenkomst');
            }
        } else {
            redirect('gebruiker/persoonlijkegegevens/toonfoutoudwachtwoord');
        }
    }
    
    private function stuurMail($geadresseerde, $boodschap, $titel) {
        $this->load->library('email');

        $this->email->from('atworkteam23@gmail.com', 'tv-shop');
        $this->email->to(/*$geadresseerde*/'atworkteam23@gmail.com');
        $this->email->subject($titel);
        $this->email->message($boodschap);

        if (!$this->email->send()) {
            show_error($this->email->print_debugger());
            return false;
        } else {
            return true;
        }
    }
    
    public function toonMelding($foutTitel, $boodschap, $link) {
        $data['titel'] = '';
        $data['author'] = 'Geffrey W.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $data['foutTitel'] = $foutTitel;
        $data['boodschap'] = $boodschap;
        $data['link'] = $link;

        $partials = array('menu' => 'main_menu', 'inhoud' => 'main_error');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function toonFoutOudWachtwoord() {
        $titel = "Fout!";
        $boodschap = "Het oude wachtwoord is niet correct.</br>"
                . "Probeer opnieuw!";
        $link = array("url" => "gebruiker/persoonlijkegegevens/wachtwoordwijzigen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }
    
    public function toonFoutWachtwoordOvereenkomst() {
        $titel = "Fout!";
        $boodschap = "Het wachtwoord is niet 2 keer hetzelfde.</br>"
                . "Probeer opnieuw!";
        $link = array("url" => "gebruiker/persoonlijkegegevens/wachtwoordwijzigen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }
    
    public function toonWachtwoordVeranderd() {
        $titel = "Wachtwoord succesvol veranderd";
        $boodschap = "Uw wachtwoord werd succesvol gewijzigd.</br>"
                . "U kan nu gewoon inloggen met het nieuwe wachtwoord.";
        $link = array("url" => "gebruiker/inloggen", "tekst" => "Inloggen");

        $this->toonMelding($titel, $boodschap, $link);
    }

}