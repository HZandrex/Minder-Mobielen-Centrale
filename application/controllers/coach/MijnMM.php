<?php

/**
 * @class MijnMM
 * @brief Controller-klasse voor de Mindermobiele gegevens per coach
 *
 * Controller-klase met alle methodes die gebruikt worden om de mindermobielen per coach te beheren.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class MijnMM extends CI_Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Haalt een lijst van mindermobielen op van de ingelogde coach. Deze lijst wordt daarna doorgestuurd en weergegeven
     * op de view coach/mijnMM.
     *
     * @see coach/mijnMM.php
     * @see CoachMinderMobiele_model::getMMById()
     *
     * Gemaakt door Tijmen Elseviers
     */
    public function mijnMMLijst()
    {
        $data['titel'] = 'Mijn MM';
        $data['author'] = 'T. Elseviers';

        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null) {
            $data['gebruiker'] = $gebruiker;
        } else {
            redirect('gebruiker/inloggen');
        }


        $this->load->model('coachMinderMobiele_model');
        $data['minderMobielen'] = $this->coachMinderMobiele_model->getMMById($gebruiker->id);

        $partials = array('menu' => 'main_menu', 'inhoud' => 'coach/mijnMM');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Deze functie haalt de gegevens van een specifieke Mindermobiele op om in de view coach/ajax_gebruikerInfo
     * verder te gebruiken en achteraf weer te geven op de correcte pagina.
     *
     * @see Gebruiker_model::getWithFunctions()
     * @see coach/ajax_gebruikerInfo.php
     *
     * Gemaakt door Tijmen Elseviers
     *
     * Medemogelijk door Geffrey Wuyts
     */
    public function haalAjaxOp_GebruikerInfo()
    {
        $gebruikerId = $this->input->get('gebruikerId');

        $this->load->model('gebruiker_model');
        $data['selectedGebruiker'] = $this->gebruiker_model->getWithFunctions($gebruikerId);
        $this->load->view('coach/ajax_gebruikerInfo', $data);
    }

    /**
     * Deze functie laadt de view coach/gegevensWijzigen met de gegevens van de geselecteerde mindermobiele
     * door middel van deze op te halen uit het model Gebruiker_model::getWithFunctions().
     *
     * @see Gebruiker_model::getEmpty()
     * @see Gebruiker_model::getWithFunctions()
     * @see Adres_model::getAll()
     * @see Voorkeur_model::getAll()
     * @see coach/gegevensWijzigen.php
     *
     * Gemaakt door Tijmen Elseviers
     *
     * Medemogelijk door Geffrey Wuyts
     */
    public function gegevensWijzigen($id = 0)
    {
        $data['titel'] = 'Gebruiker Gegevens Wijzigen';
        $data['author'] = 'T. Elseviers';

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

    /**
     * Deze functie zorgt ervoor dat de gegevens die de coach wijzigt op de view coach/gegevensWijzigen
     * aangepast worden in de databank. Het systeem stuurt deze gegevens mee door middel van de parameter
     * $gebruiker. Achteraf toont het systeem een melding dat dit gelukt via de controller
     * MijnMM::toonGegegevensGewijzigd().
     *
     * @see Gebruiker_model::getEmpty()
     * @see Gebruiker_model::insertGebruiker()
     * @see Gebruiker_model::updateGebruiker()
     * @see MijnMM::toonGegegevensGewijzigd()
     *
     * Gemaakt door Tijmen Elseviers
     *
     * Medemogelijk door Geffrey Wuyts
     */
    public function gegevensVeranderen()
    {
        $this->load->model('gebruiker_model');
        $this->load->model('adres_model');

        $gebruiker = $this->gebruiker_model->getEmpty();
        foreach ($gebruiker as $attribut => $waarde) {
            $post = $this->input->post($attribut);
            if ($post != null) {
                $gebruiker->$attribut = $post;
            }
        }
        if ($gebruiker->id == null) {
            $gebruiker->id = $this->gebruiker_model->insertGebruiker($gebruiker);
        } else {
            $this->gebruiker_model->updateGebruiker($gebruiker);
        }
        redirect('coach/mijnMM/toonGegevensGewijzigd');
    }

    /**
     * Toont het scherm om het wachtwoord te veranderen in de view coach/wachtwoordGebruikerWijzigen.php.
     *
     * @see Coach/wachtwoordGebruikerWijzigen.php
     *
     * Gemaakt door Tijmen Elseviers
     *
     * Medemogelijk door Geffrey Wuyts
     */
    public function wachtwoordWijzigen($id)
    {
        $data['titel'] = '';
        $data['author'] = 'T. Elseviers';

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

    /**
     * Gaat kijken of het oude wachtwoord juist is via Gebruiker_model hiervoor wordt ook eerst de bijhorende gebruiker opgehaald,
     * wanneer dit niet juist is word een foutmelding gegeven via Coach::mijnMM::toonFoutOudWachtwoord().
     * Vervolgens wordt gekeken of er 2x hetzelfde wachtwoord werd opgegeven zoniet word een foutmelding gegeven via PersoonlijkeGegevens::toonFoutWachtwoordOvereenkomst().
     * Wanneer dit allemaal juist is zal het wachtwoord worden veranderd via Gebruiker_model, wordt een mail gestuurd om dit te melden
     * en wordt er een melding getoont via Coach::mijnMM::toonWachtwoordVeranderd().
     *
     * @see Gebruiker_model::get()
     * @see Gebruiker_model::getGebruiker()
     * @see Gebruiker_model::wijzigWachtwoord()
     * @see mijnMM::toonFoutOudWachtwoord()
     * @see mijnMM::toonWachtwoordVeranderd()
     *
     * Gemaakt door Tijmen Elseviers
     *
     * Medemogelijk door Geffrey Wuyts
     */
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

    /**
     * Toont de melding pagina met de opgeven parameters foutTitel=$foutTitel, boodschap=$boodschap & link=$link
     * in de view main_melding.php.
     *
     * @param $foutTitel De titel die op de meldingspagina komt
     * @param $boodschap De boodschap dat getoond moet worden
     * @param $link De link en naam die wordt getoond om eventueel naar een andere pagina te gaan
     *
     * @see main_melding.php
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function toonMelding($foutTitel, $boodschap, $link)
    {
        $data['titel'] = '';
        $data['author'] = 'T. Elseviers';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $data['foutTitel'] = $foutTitel;
        $data['boodschap'] = $boodschap;
        $data['link'] = $link;

        $partials = array('menu' => 'main_menu', 'inhoud' => 'main_melding');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Dit zal PersoonlijkeGegevens::toonMelding() oproepen en de nodige parameters megeven om een boodschap te tonen.
     *
     * @see PersoonlijkeGegevens::toonMelding()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function toonFoutWachtwoordWijzigen($id)
    {
        $titel = "Fout!";
        $boodschap = "De opgegeven wachtwoorden komen niet overeen.</br>"
            . "Probeer opnieuw!";
        $link = array("url" => "coach/mijnMM/wachtwoordWijzigen/" . $id, "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal PersoonlijkeGegevens::toonMelding() oproepen en de nodige parameters megeven om een boodschap te tonen.
     *
     * @see PersoonlijkeGegevens::toonMelding()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function toonWachtwoordGewijzigd()
    {
        $titel = "Wachtwoord succesvol veranderd";
        $boodschap = "het wachtwoord werd succesvol gewijzigd.</br>"
            . "De gebruiker kan nu gewoon inloggen met het nieuwe wachtwoord.";
        $link = array("url" => "coach/mijnMM/mijnMMLijst", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal PersoonlijkeGegevens::toonMelding() oproepen en de nodige parameters megeven om een boodschap te tonen.
     *
     * @see PersoonlijkeGegevens::toonMelding()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function toonGegevensGewijzigd()
    {
        $titel = "Gegevens succesvol veranderd";
        $boodschap = "De gebruiker zijn gegevens werden succesvol veranderd.</br>"
            . "De gebruiker kan deze veranderingen ook zien.";
        $link = array("url" => "coach/mijnMM/mijnMMLijst", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }
}

