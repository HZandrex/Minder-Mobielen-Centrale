<?php

/**
 * @class PersoonlijkeGegevens
 * @brief Controller-klasse voor de persoonlijke gegevens
 *
 * Controller-klase met alle methodes die gebruikt worden om persoonlijke gegevens te beheren.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class PersoonlijkeGegevens extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

	/**
     * Haalt de persoonlijke gegevens van de ingelogde gebruiker op.
     *
     * @see Gebruiker::persoonlijkeGegevens()
     */
    public function persoonlijkeGegevens(){
        $data['titel'] = 'Persoonlijke Gegevens';
        $data['author'] = 'T. Elseviers';

        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null) {
            $data['gebruiker'] = $gebruiker;
        } else {
            redirect('gebruiker/inloggen');
        }

        $this->load->model('gebruiker_model');
        $data['gegevens'] = $gebruiker;

        $partials = array('menu' => 'main_menu', 'inhoud' => 'gebruiker/persoonlijkeGegevens');
        $this->template->load('main_master', $partials, $data);
    }
	
	/**
     * Gaat de gegevens van een persoon doorgeven naar de gegevens wijzigen pagina.
     *
     * @see Gebruiker_model::getWithFunctions()
	 * @see Voorkeur_model::getAll()
     * @see Gebruiker::gegevensWijzigen()
     */
    public function gegevensWijzigen(){
        $data['titel'] = 'Persoonlijke Gegevens Wijzigen';
        $data['author'] = 'T. Elseviers';

        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null) {
            $data['gebruiker'] = $gebruiker;
        } else {
            redirect('gebruiker/inloggen');
        }
        $data['editGebruiker'] = $gebruiker;
		
		$this->load->model('adres_model');
        $data['adressen'] = $this->adres_model->getAll();

        $this->load->model('voorkeur_model');
        $data['voorkeuren'] = $this->voorkeur_model->getAll();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'gebruiker/gegevensWijzigen');
        $this->template->load('main_master', $partials, $data);
    }
	
	/**
     * Gaat de gegevens van de gebruiker in de databank veranderen.
     *
     * @see Gebruiker_model::get()
	 * @see Gebruiker_model::updateGebruiker()
     * @see Adres_model::updateAdres()
     * @see Medewerker::gebruikersBeheren()
     * @see PersoonlijkeGegevens::persoonlijkeGegevens()
     */
    public function gegevensVeranderen(){
        $data['titel'] = 'Persoonlijke Gegevens Wijzigen';
        $data['author'] = 'T. Elseviers';

        $this->load->model('gebruiker_model');
        $this->load->model('adres_model');

        $id = $this->input->post('id');

        $gebruiker = $this->gebruiker_model->get($id);

        $gebruiker->voornaam = $this->input->post('voornaam');
        $gebruiker->naam = $this->input->post('naam');
        $gebruiker->geboorte = $this->input->post('geboorte');
        $gebruiker->telefoon = $this->input->post('telefoon');
        $gebruiker->mail = $this->input->post('mail');
        $gebruiker->voorkeurId = $this->input->post('voorkeurId');
		$gebruiker->adresId = $this->input->post('adresId');

        $this->gebruiker_model->updateGebruiker($gebruiker);

        redirect('gebruiker/persoonlijkegegevens/persoonlijkegegevens');
    }


    /**
     * Toont het scherm om het wachtwoord te veranderen in de view Gebruiker/wachtwoordWijzigen.php
     *
     * @see Gebruiker/wachtwoordWijzigen.php
     */
    public function wachtwoordWijzigen()
    {
        $data['titel'] = '';
        $data['author'] = 'G. Wuyts';

        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null) {
            $data['gebruiker'] = $gebruiker;
        } else {
            redirect('gebruiker/inloggen');
        }

        $partials = array('menu' => 'main_menu', 'inhoud' => 'gebruiker/wachtwoordWijzigen');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Gaat kijken of het oude wachtwoord juist is via Gebruiker_model hiervoor wordt ook eerst de bijhorende gebruiker opgehaald,
     * wanneer dit niet juist is word een foutmelding gegeven via PersoonlijkeGegevens::toonFoutOudWachtwoord().
     * Vervolgens wordt gekeken of er 2x hetzelfde wachtwoord werd opgegeven zoniet word een foutmelding gegeven via PersoonlijkeGegevens::toonFoutWachtwoordOvereenkomst().
     * Wanneer dit allemaal juist is zal het wachtwoord worden veranderd via Gebruiker_model, wordt een mail gestuurd om dit te melden
     * en wordt er een melding getoont via PersoonlijkeGegevens::toonWachtwoordVeranderd().
     *
     * @see Gebruiker_model::get()
     * @see Gebruiker_model::getGebruiker()
     * @see Gebruiker_model::wijzigWachtwoord()
     * @see PersoonlijkeGegevens::toonFoutOudWachtwoord()
     * @see PersoonlijkeGegevens::toonFoutWachtwoordOvereenkomst()
     * @see PersoonlijkeGegevens::toonWachtwoordVeranderd()
     */
    public function wachtwoordVeranderen()
    {
        $id = $this->input->post('id');
        $oudWachtwoord = $this->input->post('oudWachtwoord');
        $nieuwWachtwoord = $this->input->post('nieuwWachtwoord');
        $wachtwoordBevestigen = $this->input->post('wachtwoordBevestigen');

        $this->load->model('gebruiker_model');

        $gebruiker = $this->gebruiker_model->get($id);

        if ($this->gebruiker_model->getGebruiker($gebruiker->mail, $oudWachtwoord)) {
            if ($nieuwWachtwoord == $wachtwoordBevestigen) {
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

    /**
     * Stuurt een E-mail naar het ogegeven mailadres $geadresseerde, de mail wordt opgesteld
     * met de parameters $titel en $boodschap. Dit gebeurd via de email library.
     * De parameters komen van een andere functie waar deze functie wordt opgeroepen bv. PersoonlijkeGegevens::wachtwoordVeranderen().
     *
     * De configuratie van het mail adres waar me wordt verzonden is email.php dat zich bevind in de config map.
     *
     * @param $geadresseerde Het mailadres waar de mail naar wordt gestuurd
     * @param $boodschap De inhoud van de mail
     * @param $titel De titel van de mail
     *
     * @see email.php
     * @see PersoonlijkeGegevens::wachtwoordVeranderen()
     *
     * @return bool
     */
    private function stuurMail($geadresseerde, $boodschap, $titel)
    {
        $this->load->library('email');

        $this->email->from('atworkteam23@gmail.com', 'tv-shop');
        $this->email->to($geadresseerde);
        $this->email->subject($titel);
        $this->email->message($boodschap);

        if (!$this->email->send()) {
            show_error($this->email->print_debugger());
            return false;
        } else {
            return true;
        }
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
    public function toonMelding($foutTitel, $boodschap, $link)
    {
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
     * Dit zal PersoonlijkeGegevens::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see PersoonlijkeGegevens::toonMelding()
     */
    public function toonFoutOudWachtwoord()
    {
        $titel = "Fout!";
        $boodschap = "Het oude wachtwoord is niet correct.</br>"
            . "Probeer opnieuw!";
        $link = array("url" => "gebruiker/persoonlijkegegevens/wachtwoordwijzigen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal PersoonlijkeGegevens::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see PersoonlijkeGegevens::toonMelding()
     */
    public function toonFoutWachtwoordOvereenkomst()
    {
        $titel = "Fout!";
        $boodschap = "Het wachtwoord is niet 2 keer hetzelfde.</br>"
            . "Probeer opnieuw!";
        $link = array("url" => "gebruiker/persoonlijkegegevens/wachtwoordwijzigen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal PersoonlijkeGegevens::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see PersoonlijkeGegevens::toonMelding()
     */
    public function toonWachtwoordVeranderd()
    {
        $titel = "Wachtwoord succesvol veranderd";
        $boodschap = "Uw wachtwoord werd succesvol gewijzigd.</br>"
            . "U kan nu gewoon inloggen met het nieuwe wachtwoord.";
        $link = array("url" => "gebruiker/inloggen", "tekst" => "Inloggen");

        $this->toonMelding($titel, $boodschap, $link);
    }
    
    public function toonHandleiding() {
        $this->load->view("gebruiker/handleiding");
    }

}