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
     * Toont het startscherm om gebruikers te beheren in de view medewerker/gebruikersBeherenOverzicht.php.
     *
     * @see medewerker/gebruikersBeherenOverzicht.php
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function index()
    {
        $data['titel'] = 'Gebruikers beheren';
        $data['author'] = 'G. Wuyts';

        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null) {
            $data['gebruiker'] = $gebruiker;
        } else {
            redirect('gebruiker/inloggen');
        }

        foreach ($gebruiker->functies as $functie) {
            $this->load->model('functie_model');
            if ($functie->id == 4){
                $data['functies'] = $this->functie_model->getAll(4); //4 = alle functies buiten medewerker & admin
            }
            if ($functie->id == 5){
                $data['functies'] = $this->functie_model->getAll(5); //5 = alle functies buiten admin
            }
            if ($functie->id < 4) {//id=4 -> Medewerker
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

        $inActive = $this->functie_model->getEmpty();
        $inActive->naam = "Niet actief";
        array_push($data['functies'], $inActive);

        $partials = array('menu' => 'main_menu', 'inhoud' => 'medewerker/gebruikersBeherenOverzicht');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Haalt alle gebruikers op met een bepaalde functie via het FunctieGebruiker_model. Het functieId wordt doorgegeven via de view medewerker/gebruikersBeherenOverzicht.php.
     * Wanneer er geen functie wordt meegegeven zullen alle gebruikers worden getoond die niet actief zijn via het Gebruiker_model.
     * Al de gebruikers worden getoond via de view medewerker/ajax_Gebruikers.php
     *
     * @see FunctieGebruiker_model::getAllGebruikersByFunction()
     * @see Gebruiker_model::getAllInActive()
     * @see medewerker/gebruikersBeherenOverzicht.php
     * @see medewerker/ajax_Gebruikers.php
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function haalAjaxOp_GebruikersOpFunctie()
    {
        $functieId = $this->input->get('functieId');
        if ($functieId != null){
            $this->load->model('functieGebruiker_model');
            $data['gebruikers'] = $this->functieGebruiker_model->getAllGebruikersByFunction($functieId);
        } else{
            $this->load->model('gebruiker_model');
            $data['gebruikers'] = $this->gebruiker_model->getAllInActive();
        }

        $this->load->view('medewerker/ajax_gebruikers', $data);
    }

    /**
     * Haalt al de informatie op van een geselecteerde gebruiker via het Gebruiker_model. Het gebruikerId wordt doorgegeven via de view medewerker/gebruikersBeherenOverzicht.php.
     * Al de info wordt getoond via de view medewerker/ajax_GebruikerInfo.php
     *
     * @see Gebruiker_model::getWithFunctions()
     * @see medewerker/gebruikersBeherenOverzicht.php
     * @see medewerker/ajax_GebruikerInfo.php
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function haalAjaxOp_GebruikerInfo()
    {
        $gebruikerId = $this->input->get('gebruikerId');

        $this->load->model('gebruiker_model');
        $data['selectedGebruiker'] = $this->gebruiker_model->getWithFunctions($gebruikerId);
        $this->load->view('medewerker/ajax_gebruikerInfo', $data);
    }

    /**
     * Toont het scherm om het wachtwoord te veranderen in de view medewerker/wachtwoordGebruikerWijzigen.php
     *
     * @see medewerker/wachtwoordGebruikerWijzigen.php
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function wachtwoordWijzigen($id)
    {
        $data['titel'] = '';
        $data['author'] = 'G. Wuyts';

        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null) {
            $data['gebruiker'] = $gebruiker;
        } else {
            redirect('gebruiker/inloggen');
        }

        foreach ($gebruiker->functies as $functie) {
            if ($functie->id < 4) {//id=4 -> Medewerker
                redirect('admin/instellingen/toonfoutonbevoegd');
            }
        }

        $this->load->model('gebruiker_model');
        $data['editGebruiker'] = $this->gebruiker_model->getWithFunctions($id);

        $partials = array('menu' => 'main_menu', 'inhoud' => 'medewerker/wachtwoordGebruikerWijzigen');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Gaat kijken of $wachtwoord=$wachtwoordBevestigen, wanneer niet het zelfde wordt een foutmelding getoond via GebruikersBeheren::toonFoutWachtwoordWijzigen.
     * Wanneer de twee wel het zelfde zijn wordt het wachtwoord gewijzigd via het gebruiker_model en wordt
     * er een melding getoond via GebruikersBeheren::toonWachtwoordGewijzigd.
     *
     * @see Gebruiker_model::wijzigWachtwoord()
     * @see GebruikersBeheren::toonFoutWachtwoordWijzigen
     * @see GebruikersBeheren::toonWachtwoordGewijzigd
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function wachtwoordVeranderen()
    {
        $id = $this->input->post('id');
        $Wachtwoord = $this->input->post('wachtwoord');
        $wachtwoordBevestigen = $this->input->post('wachtwoordBevestigen');

        $this->load->model('gebruiker_model');

        if ($Wachtwoord == $wachtwoordBevestigen) {
            $this->gebruiker_model->wijzigWachtwoord($id, $Wachtwoord);
            redirect('medewerker/gebruikersBeheren/toonwachtwoordgewijzigd');
        } else {
            redirect('medewerker/gebruikersBeheren/toonfoutwachtwoordwijzigen/' . $id);
        }
    }

    /**
     * Gaat de gegevens van een persoon doorgeven naar de view medewerker/gegevensWijzigen.php. Wanneer er een nieuwe gebruiker wordt
     * aangemaakt zal er een lege persoon worden meegegeven.
     *
     * @param $id Het id van de gebruiker die gewijzigd moet worden (bij een nieuwe gebruiker wordt dit niet megegeven en is die dus 0)
     *
     * @see Gebruiker_model::getWithFunctions()
     * @see Gebruiker_model::getEmpty()
     * @see Adres_model::getAll()
     * @see Voorkeur_model::getAll()
     * @see Functie_model::getAll()
     * @see medewerker/gegevensWijzigen.php
     *
     * Gemaakt door Geffrey Wuyts
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
            $this->load->model('functie_model');
            if ($functie->id == 4){
                $data['functies'] = $this->functie_model->getAll(4); //4 = alle functies buiten medewerker & admin
            }
            if ($functie->id == 5){
                $data['functies'] = $this->functie_model->getAll(5); //5 = alle functies buiten admin
            }
            if ($functie->id < 4) {//id=4 -> Medewerker
                redirect('admin/instellingen/toonfoutonbevoegd');
            }
        }
        $this->load->model('gebruiker_model');
        if ($id == 0) {
            $data['titel'] = 'Gebruiker Toevoegen';
            $data['editGebruiker'] = $this->gebruiker_model->getEmpty();
        } else {
            $data['titel'] = 'Gebruiker Gegevens Wijzigen';
            $data['editGebruiker'] = $this->gebruiker_model->getWithFunctions($id);
        }

        $this->load->model('adres_model');
        $data['adressen'] = $this->adres_model->getAll();

        $this->load->model('voorkeur_model');
        $data['voorkeuren'] = $this->voorkeur_model->getAll();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'medewerker/gegevensWijzigen');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Gaat eerst kijken of geboortedatum niet in de toekomst ligt, wanneer dit wel is wordt GebruikersBeheren::toonFoutDatum() opgeroepen.
     * vervolgens wordt er gekeken wanneer er een nieuwe gebruiker wordt toegevoegd of het mail adres nog niet is gebruikt ander wordt een fout getoond
     * via GebruikersBeheren::toonFoutBestaandeMail(). Vervolgens wordt de nieuwe gebruiker toegevoegd via het Gebruiker_model en wordt de gebruiker verwittigd door
     * de private functie GebruikersBeheren::verwittigGebruiker().
     *
     * Bij het aanpassen van en al bestaande gebruiker gebeurt dit ook door het Gebruiker_model.
     *
     * Als laatste worden de functies van de gebruiker aangepast wanneer nodig via de private functie GebruikersBeheren::pasFunctieGebruikerAan()
     * en wordt er een melding getoond GebruikersBeheren::toonGegevensGewijzigd()
     *
     * @see Gebruiker_model::getByMail()
     * @see Gebruiker_model::insertGebruiker()
     * @see Gebruiker_model::updateGebruiker()
     * @see GebruikersBeheren::toonFoutDatum()
     * @see GebruikersBeheren::toonFoutBestaandeMail()
     * @see GebruikersBeheren::toonGegevensGewijzigd()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function gegevensVeranderen(){
        $this->load->model('gebruiker_model');
        $this->load->model('adres_model');
        $this->load->model('functie_model');
        $id = $this->input->post('id');

        if ($id != 0){
            $gebruiker = $this->gebruiker_model->get($id);
        } else{
            $gebruiker = $this->gebruiker_model->getEmpty();
        }

        foreach ($gebruiker as $attribut => $waarde){
            $post = $this->input->post($attribut);
            if($post != null) {
                $gebruiker->$attribut = $post;
            }
        }
        if ($gebruiker->geboorte > date('Y-m-d')){
            redirect('medewerker/gebruikersBeheren/toonfoutdatum');
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
        $ingelogdeGebruiker = $this->authex->getGebruikerInfo();
        foreach ($ingelogdeGebruiker->functies as $functie) {
            $this->load->model('functie_model');
            if ($functie->id == 4){
                $allFuncties = $this->functie_model->getAll(4); //4 = alle functies buiten medewerker & admin
            }
            if ($functie->id == 5){
                $allFuncties = $this->functie_model->getAll(5); //5 = alle functies buiten admin
            }
            if ($functie->id < 4) {//id=4 -> Medewerker
                redirect('admin/instellingen/toonfoutonbevoegd');
            }
        }

        foreach ($allFuncties as $functie){
            $this->pasFunctieGebruikerAan($gebruiker, $functie, $this->input->post('functie'.$functie->id));
        }

        redirect('medewerker/gebruikersBeheren/toongegevensgewijzigd');
    }

    /**
     * Er gaat via het Gebruiker_model de gebruiker worden opgehaald. Vervolgens gaat voor deze gebruiker een resetToken worden aangemaakt (voor meer uitleg zie Inloggen::nieuwWachtwoordAanvragen().
     * Hierna wordt er een mail gestuurd via GebruikersBeheren::stuurMail.
     *
     * @param $id Het id van de gebruiker die verwittigd moet worden
     *
     * @see Gebruiker_model::get()
     * @see GebruikersBeheren::stuurMail()
     *
     * Gemaakt door Geffrey Wuyts
     */
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
            . "<p>Activeer uw account via volgende link: " . anchor(base_url() . 'index.php/gebruiker/inloggen/wachtwoordVergetenWijzigen/' . $resetToken, 'Link om uw account te activeren') . "</p><br>"
            . '<p>Wanneer u zelf geen nieuw account heeft aangevraagd neem dan zo snel mogelijk contact op. Voor onze contactgegevens kan u terecht op onze site: '
            . anchor(base_url(), 'Link naar de Minder Mobielen Centrale') . '</p>';
        $this->stuurMail($gebruiker->mail, $boodschap, $titel);
    }

    /**
     * Wanneer een functie niet aangevinkt is $checkbox=null dan zal er gekeken worden of de gebruiker deze functie op deze moment heeft.
     * Wanneer hij deze functie heeft wilt dit dus zeggen dat deze verwijderd moet worden via het FunctieGebruiker_model.
     * Wanneer een functie wel aangevinkt is dan zal er weer gekeken worden of de gebruiker deze functie op deze moment heeft.
     * Wanneer hij deze functie niet heeft wilt dit dus zeggen dat hij deze moet krijgen dit gebeurd via het FunctieGebruiker_model.
     *
     * @param $gebruiker De gebruiker voor wie de functie moet worden aangepast
     * @param $functie De functie die moet worden aangepast
     * @param $checkbox De status van de checkbox die bij deze functie hoort
     *
     * @see FunctieGebruiker_model::functieGebruikerBestaat()
     * @see FunctieGebruiker_model::verwijderen()
     * @see FunctieGebruiker_model::voegToe()
     *
     * Gemaakt door Geffrey Wuyts
     */
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
    /**
     * Eerst wordt de gebruiker opgehaald via het Gebruiker_model. Vervolgens wordt er gekeken of de gebruiker op deze moment al actief is.
     * Wanneer deze nog niet actief is en een mail heeft ingesteld zal er resetToken worden aangemaakt en vervolgens wordt je doorgestuurd naar Inloggen::wachtwoordVergetenWijzigen().
     * Wanneer deze nog geen mail heeft ingesteld zal eerst de gebruiker worden geactiveerd via het Gebruiker_model en vervolgens wordt er een melding getoond via GebruikersBeheren::toonStatusVeranderd().
     *
     * Wanneer deze al actief is zal deze gedeactiveerd worden via het Gebruiker_model en zal er ook een melding worden getoond via GebruikersBeheren::toonStatusVeranderd().
     *
     * @param $id Het id van een gebruiker waarvan de status moet worden aangepast
     * 
     * @see Gebruiker_model::get()
     * @see Gebruiker_model::controleerResetToken()
     * @see Gebruiker_model::wijzigResetToken()
     * @see Gebruiker_model::activeerGebruiker()
     * @see Gebruiker_model::deactiveerGebruiker()
     * @see GebruikersBeheren::toonStatusVeranderd()
     * @see Inloggen::wachtwoordVergetenWijzigen()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function pasStatusGebruikerAan($id){
        $this->load->model('gebruiker_model');
        $gebruiker = $this->authex->getGebruikerInfo();
        if ($gebruiker != null) {
            $data['gebruiker'] = $gebruiker;
        } else {
            redirect('gebruiker/inloggen');
        }
        foreach ($gebruiker->functies as $functie) {
            if ($functie->id < 4) {
                redirect('admin/instellingen/toonfoutonbevoegd');
            }
        }

        $editGebruiker = $this->gebruiker_model->get($id);

        if($editGebruiker->active == 0){
            if ($editGebruiker->mail != null){
                $resetToken = $this->random_resetToken();
                while ($this->gebruiker_model->controleerResetToken($resetToken)) {
                    $resetToken = $this->random_resetToken();
                }
                $this->gebruiker_model->wijzigResetToken($editGebruiker->mail, $resetToken);
                redirect('gebruiker/inloggen/wachtwoordVergetenWijzigen/'.$resetToken);
            } else{
                $this->gebruiker_model->activeerGebruiker($id);
                redirect('medewerker/gebruikersBeheren/toonstatusveranderd/'."geactiveerd");
            }

        } else{
            $this->gebruiker_model->deactiveerGebruiker($id);
            redirect('medewerker/gebruikersBeheren/toonstatusveranderd/'."gedeactiveerd");
        }
    }

    /**
     * Stuurt een mail. Voor verdere uitleg zie Inloggen::stuurMail().
     *
     * @param $geadresseerde Het mailadres waar de mail naar wordt gestuurd
     * @param $boodschap De inhoud van de mail
     * @param $titel De titel van de mail
     *
     * @see Inloggen::stuurMail()
     * @return bool
     *
     * Gemaakt door Geffrey Wuyts
     */
    private function stuurMail($geadresseerde, $boodschap, $titel) {
        $this->load->library('email');

        $this->email->from('atworkteam23@gmail.com', 'Minder Mobielen Centrale');
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
     * Dit zal GebruikersBeheren::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see GebruikersBeheren::toonMelding()
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
     * Dit zal GebruikersBeheren::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see GebruikersBeheren::toonMelding()
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
     * Dit zal GebruikersBeheren::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see GebruikersBeheren::toonMelding()
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
     * Dit zal GebruikersBeheren::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see GebruikersBeheren::toonMelding()
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
     * Dit zal GebruikersBeheren::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see GebruikersBeheren::toonMelding()
     */
    public function toonFoutDatum()
    {
        $titel = "Fout!";
        $boodschap = "U heeft geprobeerd een geboortedatum op te slaan die in de toekomst ligd!</br>"
            . "Dit mag niet probeer opnieuw!";
        $link = array("url" => "medewerker/gebruikersBeheren/gegevensWijzigen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal GebruikersBeheren::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see GebruikersBeheren::toonMelding()
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
     * Dit zal GebruikersBeheren::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see GebruikersBeheren::toonMelding()
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
     * Dit zal GebruikersBeheren::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see GebruikersBeheren::toonMelding()
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
