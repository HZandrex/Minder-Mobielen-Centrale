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

        if(!get_cookie('FirstVisit', TRUE)){
            set_cookie('FirstVisit', 'set', (10 * 365 * 24 * 60 * 60));
            $data['firstVisit'] = true;
        }
        else{
            $data['firstVisit'] = false;
        }

        $this->load->model('functieGebruiker_model');
        $data['gebruikers'] = $this->functieGebruiker_model->getAllGebruikersByFunction(1);

        $this->load->model('functie_model');
        $data['functies'] = $this->functie_model->getAll(4); //4 = alle functies buiten medewerker & admin

        $partials = array('menu' => 'main_menu', 'inhoud' => 'medewerker/gebruikersBeherenOverzicht');

        $this->template->load('main_master', $partials, $data);
    }

    public function haalAjaxOp_GebruikersOpFunctie()
    {
        $functieId = $this->input->get('functieId');

        $this->load->model('functieGebruiker_model');
        $data['gebruikers'] = $this->functieGebruiker_model->getAllGebruikersByFunction($functieId);

        $this->load->view('medewerker/ajax_gebruikers', $data);
    }

    public function haalAjaxOp_GebruikerInfo()
    {
        $gebruikerId = $this->input->get('gebruikerId');

        $this->load->model('gebruiker_model');
        $data['selectedGebruiker'] = $this->gebruiker_model->getWithFunctions($gebruikerId);
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
            redirect('medewerker/gebruikersBeheren/toonwachtwoordgewijzigd');
        } else {
            redirect('medewerker/gebruikersBeheren/toonfoutwachtwoordwijzigen/' . $id);
        }
    }

    /**
     * Gaat de gegevens van een persoon doorgeven naar de gegevens wijzigen pagina.
     *
     * @see Gebruiker_model::getWithFunctions()
     * @see Voorkeur_model::getAll()
     * @see Gebruiker::gegevensWijzigen()
     */
    public function gegevensWijzigen($id = 0){

        $data['author'] = 'Geffrey Wuyts';

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

        if ($id == 0) {
            $data['titel'] = 'Gebruiker Toevoegen';
            $this->load->model('gebruiker_model');
            $data['editGebruiker'] = $this->gebruiker_model->getEmpty();
        } else {
            $this->load->model('gebruiker_model');
            $data['titel'] = 'Gebruiker Gegevens Wijzigen';
            $data['editGebruiker'] = $this->gebruiker_model->getWithFunctions($id);
        }

        $this->load->model('adres_model');
        $data['adressen'] = $this->adres_model->getAll();

        $this->load->model('functie_model');
        $data['functies'] = $this->functie_model->getAll(4); //4 = alle functies buiten medewerker & admin

        $this->load->model('voorkeur_model');
        $data['voorkeuren'] = $this->voorkeur_model->getAll();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'medewerker/gegevensWijzigen');
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
        $this->load->model('gebruiker_model');
        $this->load->model('adres_model');
        $this->load->model('functie_model');

        $gebruiker = $this->gebruiker_model->getEmpty();
        foreach ($gebruiker as $attribut => $waarde){
            $post = $this->input->post($attribut);
            if($post != null) {
                $gebruiker->$attribut = $post;
            }
        }
        if($gebruiker->id == null){
            if ($this->gebruiker_model->getByMail($gebruiker->mail) != false) {
                redirect('medewerker/gebruikersBeheren/toonfoutbestaandemail');
            } else {
                $gebruiker->id = $this->gebruiker_model->insertGebruiker($gebruiker);
                $this->verwittigGebruiker($gebruiker->id);
            }
        }
        else{
            $this->gebruiker_model->updateGebruiker($gebruiker);
        }

        $allFuncties = $this->functie_model->getAll(4); //4 = alle functies buiten medewerker & admin

        foreach ($allFuncties as $functie){
            $this->pasFunctieGebruikerAan($gebruiker, $functie, $this->input->post('functie'.$functie->id));
        }

        redirect('medewerker/gebruikersBeheren/toongegevensgewijzigd');
    }

    private function verwittigGebruiker($id){
        $this->load->model('gebruiker_model');
        $gebruiker = $this->gebruiker_model->get($id);
        $resetToken = $this->random_resetToken();
        while ($this->gebruiker_model->controleerResetToken($resetToken)) {
            $resetToken = $this->random_resetToken();
        }
        $this->gebruiker_model->wijzigResetToken($gebruiker->mail, $resetToken);

        $titel = "Welkom bij de Minder Mobiele Centrale";
        $boodschap = '<p>Er werd zonet een account voor u aangemaakt voor onze site.</p>'
            . "<p>Uw kan na het activeren van uw account deze gegevens controleren en eventueel aanpassen.</p><br>"
            . "<p>Activeer uw account via volgende link: " . anchor(base_url() . 'index.php/gebruiker/inloggen/gebruikerActiveren/' . $resetToken, 'Link om uw account te activeren') . "</p><br>"
            . '<p>Wanneer u zelf geen nieuw account heeft aangevraagd neem dan zo snel mogelijk contact op. Voor onze contactgegevens kan u terecht op onze site: '
            . anchor(base_url(), 'Link naar de Minder Mobielen Centrale') . '</p>';
        $this->stuurMail($gebruiker->mail, $boodschap, $titel);
    }

    private function pasFunctieGebruikerAan($gebruiker, $functie, $checkbox){
        $this->load->model('functieGebruiker_model');

        if ($checkbox == null){
            $functieGebruikerId = $this->functieGebruiker_model->functieGebruikerBestaat($gebruiker->id, $functie->id);
            if ($functieGebruikerId != false){
                if (!$this->functieGebruiker_model->verwijderen($functieGebruikerId)){
                    redirect('medewerker/gebruikersBeheren/toonfoutopslaan/'.$gebruiker->id);
                }
            }
        }
        else{
            $functieGebruikerId = $this->functieGebruiker_model->functieGebruikerBestaat($gebruiker->id, $functie->id);
            if ($functieGebruikerId == false){
                $functieGebruiker = new stdClass();
                $functieGebruiker->functieId = $functie->id;
                $functieGebruiker->gebruikerId = $gebruiker->id;
                if (!$this->functieGebruiker_model->voegToe($functieGebruiker)){
                    redirect('medewerker/gebruikersBeheren/toonfoutopslaan/'.$gebruiker->id);
                }
            }
        }
    }

    public function pasStatusGebruikerAan($id){
        $this->load->model('gebruiker_model');
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

        $editGebruiker = $this->gebruiker_model->get($id);

        if($editGebruiker->active == 0){
            $this->gebruiker_model->activeerGebruiker($id);
            redirect('medewerker/gebruikersBeheren/toonstatusveranderd/'."geactiveerd");
        } else{
            $this->gebruiker_model->deactiveerGebruiker($id);
            redirect('medewerker/gebruikersBeheren/toonstatusveranderd/'."gedeactiveerd");
        }
    }

    /**
     * Stuurt een E-mail naar het ogegeven mailadres $geadresseerde, de mail wordt opgesteld
     * met de parameters $titel en $boodschap. Dit gebeurd via de email library.
     * De parameters komen van een andere functie waar deze functie wordt opgeroepen bv. inloggen::nieuwWachtwoordAanvragen().
     *
     * De configuratie van het mail adres waar me wordt verzonden is email.php dat zich bevind in de config map.
     *
     * @param $geadresseerde Het mailadres waar de mail naar wordt gestuurd
     * @param $boodschap De inhoud van de mail
     * @param $titel De titel van de mail
     *
     * @see email.php
     * @see inloggen::nieuwWachtwoordAanvragen()
     * @return bool
     */
    private function stuurMail($geadresseerde, $boodschap, $titel) {
        $this->load->library('email');

        $this->email->from('atworkteam23@gmail.com', 'Minder Mobielen Centrale');
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
    public function toonFoutWachtwoordWijzigen($id)
    {
        $titel = "Fout!";
        $boodschap = "De opgegeven wachtwoorden komen niet overeen.</br>"
            . "Probeer opnieuw!";
        $link = array("url" => "medewerker/gebruikersBeheren/wachtwoordWijzigen/" . $id, "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     */
    public function toonFoutBestaandeMail()
    {
        $titel = "Fout!";
        $boodschap = "U probeerde een gebruiker te maken met een mail dat al in gebruik is.</br>"
            . "Probeer een andere mail!";
        $link = array("url" => "medewerker/gebruikersBeheren/gegevensWijzigen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     */
    public function toonFoutUrl()
    {
        $titel = "Fout!";
        $boodschap = "U heeft een ongeldige URL opgegeven.</br>"
            . "Probeer opnieuw!";
        $link = array("url" => "home", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     */
    public function toonFoutOpslaan($id)
    {
        $titel = "Fout!";
        $boodschap = "Er heeft zich een probleem opgetreden bij het opslaan.</br>"
            . "Probeer opnieuw! Als dit blijft voorvallen neemt u best contact op met de systeembeheerder.";
        $link = array("url" => "medewerker/gebruikersBeheren/gegevensWijzigen/$id", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     */
    public function toonWachtwoordGewijzigd()
    {
        $titel = "Wachtwoord succesvol veranderd";
        $boodschap = "het wachtwoord werd succesvol gewijzigd.</br>"
            . "De gebruiker kan nu gewoon inloggen met het nieuwe wachtwoord.";
        $link = array("url" => "medewerker/gebruikersBeheren", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     */
    public function toonGegevensGewijzigd()
    {
        $titel = "Gegevens succesvol veranderd";
        $boodschap = "De gebruiker zijn gegevens werden succesvol veranderd.</br>"
            . "De gebruiker kan deze veranderingen ook zien.";
        $link = array("url" => "medewerker/gebruikersBeheren", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     */
    public function toonStatusVeranderd($status)
    {
        $titel = "Status succesvol veranderd";
        $boodschap = "De gebruiker is succesvol $status.";
        $link = array("url" => "medewerker/gebruikersBeheren", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Genereert een string van 20 willekeurige karakters uit de string $chars.
     *
     * @return $resetToken om vijlig wachtwoord te kunnen wijzigen
     */
    private function random_resetToken() {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $resetToken = substr(str_shuffle($chars), 0, 20);
        return $resetToken;
    }

}
