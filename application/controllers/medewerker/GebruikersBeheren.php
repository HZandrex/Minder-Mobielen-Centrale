<?php

/**
 * @class GebruikersBeheren
 * @brief Controller-klasse voor de gebruikers te kunnen beheren
 *
 * Controller-klase met alle methodes die gebruikt worden voor de gebruikers te beheren.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class GebruikersBeheren extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Toont het startscherm met alle gebruikers in de view Medewerker/gebruikersBeherenOverzicht.php.
     *
     * @see Medewerker/gebruikersBeherenOverzicht.php
     */
    public function index()
    {
        $data['titel'] = 'Gebruikers beheren';
        $data['author'] = 'Geffrey W.';

        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null) {
            $data['gebruiker'] = $gebruiker;
        } else {
            redirect('gebruiker/inloggen');
        }

        foreach ($gebruiker->functies as $functie) {
            if ($functie->id != 4) {//id=4 -> Medewerker
                redirect('admin/instellingen/toonfoutonbevoegd');
            }
        }

        $this->load->model('functiegebruiker_model');
        $data['gebruikers'] = $this->functiegebruiker_model->getAllGebruikersByFunction(1);

        $this->load->model('functie_model');
        $data['functies'] = $this->functie_model->getAll(4); //4 = alle functies buiten medewerker & admin

<<<<<<< HEAD
        $partials = array('menu' => 'main_menu', 'inhoud' => 'medewerker/gebruikerseherenoverzicht');
=======
        $partials = array('menu' => 'main_menu', 'inhoud' => 'medewerker/gebruikersBeherenOverzicht');
>>>>>>> 19560fb228b050984682b17d9d27f709dc41d1f6
        $this->template->load('main_master', $partials, $data);
    }

    public function haalAjaxOp_GebruikersOpFunctie()
    {
        $functieId = $this->input->get('functieId');

        $this->load->model('functiegebruiker_model');
        $data['gebruikers'] = $this->functiegebruiker_model->getAllGebruikersByFunction($functieId);

        $this->load->view('medewerker/ajax_gebruikers', $data);
    }

    public function haalAjaxOp_GebruikerInfo()
    {
        $gebruikerId = $this->input->get('gebruikerId');

        $this->load->model('gebruiker_model');
        $data['gebruiker'] = $this->gebruiker_model->getWithFunctions($gebruikerId);

        $this->load->view('medewerker/ajax_gebruikerInfo', $data);
    }

    public function wachtwoordWijzigen($id)
    {
        $data['titel'] = '';
        $data['author'] = 'Geffrey W.';

        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null) {
            $data['gebruiker'] = $gebruiker;
        } else {
            redirect('gebruiker/inloggen');
        }

        foreach ($gebruiker->functies as $functie) {
            if ($functie->id != 4) {//id=4 -> Medewerker
                redirect('admin/instellingen/toonfoutonbevoegd');
            }
        }

        $this->load->model('gebruiker_model');
        $data['editGebruiker'] = $this->gebruiker_model->getWithFunctions($id);

        $partials = array('menu' => 'main_menu', 'inhoud' => 'medewerker/wachtwoordGebruikerWijzigen');
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
            redirect('medewerker/gebruikersbeheren/toonwachtwoordgewijzigd');
        } else {
            redirect('medewerker/gebruikersbeheren/toonfoutwachtwoordwijzigen/' . $id);
        }
    }

    public function nieuweGebruikerMaken(){
        $data['titel'] = 'Gebruiker toevoegen';
        $data['author'] = 'Geffrey W.';

        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null) {
            $data['gebruiker'] = $gebruiker;
        } else {
            redirect('gebruiker/inloggen');
        }

        foreach ($gebruiker->functies as $functie) {
            if ($functie->id != 4) {//id=4 -> Medewerker
                redirect('admin/instellingen/toonfoutonbevoegd');
            }
        }

        $this->load->model('functie_model');
        $data['functies'] = $this->functie_model->getAll(4); //4 = alle functies buiten medewerker & admin

        $this->load->model('voorkeur_model');
        $data['communicatiemiddelen'] = $this->voorkeur_model->getAll();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'medewerker/nieuweGebruikerToevoegen');
        $this->template->load('main_master', $partials, $data);
    }

    public function gebruikerToevoegen(){
        $this->load->model('gebruiker_model');
        $this->load->model('adres_model');

        $gebruiker = new stdClass();
        $gebruiker->voornaam = $this->input->post('voornaam');
        $gebruiker->naam = $this->input->post('naam');
        $gebruiker->geboorte = $this->input->post('geboorte');
        $gebruiker->telefoon = $this->input->post('telefoon');
        $gebruiker->mail = $this->input->post('mail');
        $gebruiker->voorkeurId = $this->input->post('voorkeurId');

        $adres = new stdClass();
        $adres->gemeente = $this->input->post('gemeente');
        $adres->postcode = $this->input->post('postcode');
        $adres->straat = $this->input->post('straat');
        $adres->huisnummer = $this->input->post('huisnummer');
        if($this->gebruiker_model->getByMail($gebruiker->mail)){
            redirect('medewerker/gebruikersbeheren/toonfoutbestaandemail');
        }

        $bestaandAdres = $this->adres_model->bestaatAdresAl($adres);
        if(!$bestaandAdres){
            $gebruiker->adresId = $this->adres_model->insertAdres($adres);
        } else{
            $gebruiker->adresId = $bestaandAdres;
        }
        $this->gebruiker_model->insertGebruiker($gebruiker);

        redirect('medewerker/gebruikersbeheren');
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
    public function toonFoutWachtwoordWijzigen($id) {
        $titel = "Fout!";
        $boodschap = "De opgegeven wachtwoorden komen niet overeen.</br>"
            . "Probeer opnieuw!";
        $link = array("url" => "medewerker/gebruikersbeheren/wachtwoordwijzigen/" . $id, "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     */
    public function toonFoutBestaandeMail() {
        $titel = "Fout!";
        $boodschap = "U probeerde een gebruiker te maken met een mail dat al in gebruik is.</br>"
            . "Probeer een andere mail!";
        $link = array("url" => "medewerker/gebruikersbeheren/nieuwegebruikermaken", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     */
    public function toonWachtwoordGewijzigd() {
        $titel = "Wachtwoord succesvol veranderd";
        $boodschap = "het wachtwoord werd succesvol gewijzigd.</br>"
            . "De gebruiker kan nu gewoon inloggen met het nieuwe wachtwoord.";
        $link = array("url" => "medewerker/gebruikersbeheren", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

}
