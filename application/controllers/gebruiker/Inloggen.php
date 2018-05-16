<?php

/**
 * @class Inloggen
 * @brief Controller-klasse voor het inloggen
 * 
 * Controller-klase met alle methodes die gebruikt worden om in te loggen.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Inloggen extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Toont het inlogscherm in de view gebruiker/inlogPagina.php.
     * 
     * @see gebruiker/inlogPagina.php
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function index() {
        $data['titel'] = '';
        $data['author'] = 'G. Wuyts';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'gebruiker/inlogPagina'); 
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Logt in met de Authex library door de methode meldAan($email, $wachtwoord)
     * de inloggegevens worden via de post methode binnengehaald vanuit de form
     * in de view gebruiker/inlogPagina.php.
     * 
     * Wanneer het inloggen lukt zal Home::index() worden opgeroepen,
     * wanner de gegevens fout zijn zal er een foutmelding worden getoond via Inloggen::toonFoutInloggen().
     * 
     * @see Inloggen::toonFoutInloggen()
     * @see Home::index()
     * @see gebruiker/inlogPagina.php
     * @see Authex::meldAan()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function controleerLogin() {
        $email = strtolower($this->input->post('email'));
        $wachtwoord = $this->input->post('wachtwoord');

        if ($this->authex->meldAan($email, $wachtwoord)) {
            redirect('home');
        } else {
            redirect('gebruiker/inloggen/toonfoutinloggen');
        }
    }

    /**
     * Logt uit met de Authex library, vervolgens wordt Home::index() opgeroepen.
     *
     * @see Home::index()
     * @see Authex::meldAf()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function loguit() {
        $this->authex->meldAf();
        redirect('gebruiker/inloggen');
    }
    
    /**
     * Toont het scherm om een nieuw wachtwoord aan te vragen in de view gebruiker/wachtwoordVergeten.php.
     * 
     * @see gebruiker/wachtwoordVergeten.php
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function wachtwoordVergeten() {
        $data['titel'] = '';
        $data['author'] = 'G. Wuyts';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'gebruiker/wachtwoordVergeten');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Kijkt eerst of er een account bestaat met het opgegeven mailadres(mail = $email) via Gebruiker_model.
     * Wanneer er een geen account wordt gevonden wordt een foutboodschap getoond via Inloggen:toonFoutWachtwoordVeranderen().
     * 
     * Bij het vinden van een account zal er eerst een reset token worden gegereneerd via de private functie random_resetToken(),
     * vervolgens wordt er gecontroleerd of deze al bestaat in de tabel via het Gebruiker_model. Als de token al bestaat zal
     * er een nieuwe gegenereerd worden totdat hij uniek is in de tabel.
     * 
     * Vervolgens zal de gebruiker met het opgegeven mailadres worden bijgewerkt met de reset token via het Gebruiker_model,
     * er zal ook een mail worden gestuurd naar het opgegeven mailadres om te zeggen dat er nieuw wachtwoord is aangevraagd en
     * een link in om het nieuwe wachtwoord in te stellen. deze link bevat de reset token om op de pagina te controlren of
     * dit een geldig verzoek is en voor wie het nieuwe wachtwoord bedoeld is, het verzenden van de mail gebeurt via de private functie
     * stuurMail. Vervolgens wordt ook een bevesteging getoond via Inloggen:toonMailNieuwWachtwoordVerstuurd().
     * 
     * De link zal de view gebruiker/wachtwoordVergetenWijzigen.php openen.
     * 
     * @param $email Het mail adres dat werd opgeven in de view gebruiker/inlogPagina.php
     * @param $resetToken een toekn van 20 willekeurige karrakters lang om het proces vijlig te maken
     *
     * @see Inloggen::toonFoutWachtwoordVeranderen()
     * @see Inloggen::toonMailNieuwWachtwoordVerstuurd()
     * @see Inloggen::wachtwoordVergetenWijzigen()
     * @see Gebruiker_model::getByMail()
     * @see Gebruiker_model::controleerResetToken()
     * @see Gebruiker_model::wijzigResetToken()
     * @see gebruiker/wachtwoordVergetenWijzigen.php
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function nieuwWachtwoordAanvragen() {
        $email = $this->input->post('email');

        $this->load->model('gebruiker_model');

        if (!$this->gebruiker_model->getByMail($email)) {
            redirect('gebruiker/inloggen/toonfoutwachtwoordveranderen');
        } else {
            $resetToken = $this->random_resetToken();
            while ($this->gebruiker_model->controleerResetToken($resetToken)) {
                $resetToken = $this->random_resetToken();
            }
            $this->gebruiker_model->wijzigResetToken($email, $resetToken);
            $titel = "Minder Mobiele Centrale aanvraag nieuw wachtwoord";
            $boodschap = '<p>U heeft een nieuw wachtwoord aangevraagd. Druk op onderstaande link om een nieuw wachtwoord aan te vragen.</p>'
                    . '<p>Wanneer u zelf geen nieuw wachtwoord heeft aangevraagd hoeft u deze mail simpel te negeren.</p>'
                    . '<p>Verander wachtwoord: ' . anchor(base_url() . 'index.php/gebruiker/inloggen/wachtwoordVergetenWijzigen/' . $resetToken, 'Link om wachtwoord te veranderen') . '</p>';
            $this->stuurMail($email, $boodschap, $titel);

            redirect('gebruiker/inloggen/toonmailnieuwwachtwoordverstuurd');
        }
    }
    
    /**
     * Wanneer de $resetToken bestaat in de tabel gebruiker zal de view gebruiker/wachtwoordVergetenWijzigen.php getoond worden,
     * wanneer deze niet bestaat zal er een melding worden getoond via Inloggen::toonFoutLinkVerlopen().
     * De resetToken word gecontroleerd via Gebruiker_model.
     * 
     * @param $resetToken Wordt megeven in de link uit de mail
     * 
     * @see Gebruiker_model::controleerResetToken()
     * @see Inloggen::toonFoutLinkVerlopen()
     * @see gebruiker/wachtwoordVergetenWijzigen.php
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function wachtwoordVergetenWijzigen($resetToken) {
        $this->load->model('gebruiker_model');
        if ($this->gebruiker_model->controleerResetToken($resetToken)) {
            $data['titel'] = '';
            $data['author'] = 'G. Wuyts';
            $data['gebruiker'] = $this->authex->getGebruikerInfo();

            $data['resetToken'] = $resetToken;

            $partials = array('menu' => 'main_menu', 'inhoud' => 'gebruiker/wachtwoordVergetenWijzigen');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect('gebruiker/inloggen/toonfoutlinkverlopen');
        }
    }
    
    /**
     * Eerst wordt er gecontroleerd of de $resetToken bestaat in de tabel gebruiker (wordt gecontroleerd via Gebruiker_model)
     * wanneer deze niet bestaat zal er een melding worden getoond via Inloggen::toonFoutLinkVerlopen().
     * Vervolgens wordt er gecontroleerd of er 2x hetzelfde wachtwoord is opgegeven ($wachtwoord = $wachtwoordBevestigen)
     * wanneer deze niet overeen komen zal er een foutboodschap worden getoond via Inloggen::toonFoutNieuwWachtwoord.
     * Met deze foutboodschap wordt ook $resetToken meegegeven zodat hij het opnieuw kan ingeven.
     * Wanneer de twee voordaan zijn voldaan zal eerst de gebruiker worden opgehaald waarvan het wachtwoord wordt veranderd via het Gebruiker_model,
     * hierna zal van deze gebruiker het wachtwoord worden vervangen door het nieuwe via het Gebruiker_model.
     * Tenslotten wordt er een mail gestuurd zoals bij Inloggen::nieuwWachtwoordAanvragen() en wordt
     * er een melding getoond via Inloggen::toonWachtwoordVeranderd wanneer deze functie wordt opgeroepen bij wachtwoord vergeten.
     *
     * Wanneer een gebruiker zijn account wilt activeren zal hij ook deze functie gebruiken, nu zal dus zoals hierboven het wachtwoord worden ingesteld.
     * Vervolgens gaat het systeem voor een mail te versturen eerst deze gebruiker activeren via het Gebruiker_model, na het sturen van de mail zal de
     * er een melding getoond worden via Inloggen::toonGeactiveerd.
     *
     * Wanneer een gebruiker wordt geactiveerd door een medewerker of admin zal dit analoog verlopen als hierboven alleen wordt er een aangepaste boodschap
     * getoond en mail verstuurd. De boodschapt wordt getoond via Inloggen::toonGeactiveerdDoorMedewerker
     *
     *  
     * @see Gebruiker_model::controleerResetToken()
     * @see Gebruiker_model::getByResetToken()
     * @see Gebruiker_model::wijzigWachtwoordReset()
     * @see Inloggen::toonFoutLinkVerlopen()
     * @see Inloggen::toonFoutNieuwWachtwoord()
     * @see Inloggen::toonWachtwoordVeranderd()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function wachtwoordVeranderen() {
        $resetToken = $this->input->post('resetToken');
        $Wachtwoord = $this->input->post('wachtwoord');
        $wachtwoordBevestigen = $this->input->post('wachtwoordBevestigen');

        $this->load->model('gebruiker_model');
        $ingelogdeGebruiker = $this->authex->getGebruikerInfo();

        if ($this->gebruiker_model->controleerResetToken($resetToken)) {
            if ($Wachtwoord == $wachtwoordBevestigen) {
                $gebruiker = $this->gebruiker_model->getByResetToken($resetToken);
                $this->gebruiker_model->wijzigWachtwoordReset($resetToken, $Wachtwoord);
                if ($gebruiker->active){
                    $titel = "Minder Mobiele Centrale wachtwoord veranderd";
                    $boodschap = "<p>U heeft zojuist uw wachtwoord veranderd. Noteer dit wachtwoord ergens of onthoud dit goed.</p>"
                        . "<p>Heeft u het wachtwoord niet veranderd en ontvangt u deze mail, neem dan snel contact met ons op."
                        . " U vindt deze gegevens op onze site.<p>" . anchor(base_url(), "Link naar de site van de Minder Mobiele Centrale");
                    if(!$this->stuurMail($gebruiker->mail, $boodschap, $titel)){
                        redirect('gebruiker/inloggen/toonfoutmail');
                    }
                    redirect('gebruiker/inloggen/toonwachtwoordveranderd');
                } elseif ($gebruiker->id == $ingelogdeGebruiker->id){
                    $this->gebruiker_model->activeerGebruiker($gebruiker->id);
                    $titel = "Minder Mobiele Centrale wachtwoord ingesteld";
                    $boodschap = "<p>U heeft zojuist uw account geactiveerd en het wachtwoord ingesteld. Noteer dit wachtwoord ergens of onthoud dit goed.</p>"
                        . "<p>Heeft u geen account geactiveerd en ontvangt u deze mail, neem dan snel contact met ons op."
                        . " U vindt deze gegevens op onze site.<p>" . anchor(base_url(), "Link naar de site van de Minder Mobiele Centrale");
                    $this->stuurMail($gebruiker->mail, $boodschap, $titel);
                    redirect('gebruiker/inloggen/toongeactiveerd');
                } else{
                    $this->gebruiker_model->activeerGebruiker($gebruiker->id);
                    $titel = "Minder Mobiele Centrale wachtwoord ingesteld";
                    $boodschap = "<p>Uw account werd zonet geactiveerd en er werd wachtwoord ingesteld. Als u dit zelf heeft doorgegeven noteer dit wachtwoord dan ergens of onthoud dit goed.</p>"
                        . "<p>Wanneer u zelf geen wachtwoord hebt opgegeven neem dan even contact op met een medewerker.</p>"
                        . "<p>Weet u niets van dit account of deze activatie en ontvangt u deze mail, neem dan snel contact met ons op."
                        . " U vindt deze gegevens op onze site.<p>" . anchor(base_url(), "Link naar de site van de Minder Mobiele Centrale");
                    $this->stuurMail($gebruiker->mail, $boodschap, $titel);
                    redirect('gebruiker/inloggen/toongeactiveerddoormedewerker');
                }

            } else {
                redirect('gebruiker/inloggen/toonfoutnieuwwachtwoord/' . $resetToken);
            }
        } else {
            redirect('gebruiker/inloggen/toonfoutlinkverlopen');
        }
    }
    
    /**
     * Genereert een string van 20 willekeurige karakters uit de string $chars.
     * 
     * @return $resetToken om vijlig wachtwoord te kunnen wijzigen
     *
     * Gemaakt door Geffrey Wuyts
     */
    private function random_resetToken() {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $resetToken = substr(str_shuffle($chars), 0, 20);
        return $resetToken;
    }

    /**
     * Stuurt een E-mail naar het ogegeven mailadres $geadresseerde, de mail wordt opgesteld
     * met de parameters $titel en $boodschap. Dit gebeurd via de email library.
     * De parameters komen van een andere functie waar deze functie wordt opgeroepen bv. Inloggen::nieuwWachtwoordAanvragen().
     *
     * De configuratie van het mail adres waar me wordt verzonden is email.php dat zich bevind in de config map.
     *
     * @param $geadresseerde Het mailadres waar de mail naar wordt gestuurd
     * @param $boodschap De inhoud van de mail
     * @param $titel De titel van de mail
     *
     * @see email.php
     * @see Inloggen::nieuwWachtwoordAanvragen()
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
     *
     * Gemaakt door Geffrey Wuyts
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
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function toonFoutInloggen() {
        $titel = "Fout!";
        $boodschap = "Het opgegeven mail adres komt niet overeen met het wachtwoord.</br>"
            . "Probeer opnieuw!";
        $link = array("url" => "gebruiker/inloggen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function toonFoutWachtwoordVeranderen() {
        $titel = "Fout!";
        $boodschap = "Het opgegeven mail adres is niet gekoppeld aan een account.</br>"
            . "Probeer opnieuw!";
        $link = array("url" => "gebruiker/inloggen/wachtwoordvergeten", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function toonFoutLinkVerlopen() {
        $titel = "Fout!";
        $boodschap = "De url die u gebruikte is niet meer geldig.</br>"
            . "Vraag een nieuwe aan!";
        $link = array("url" => "gebruiker/inloggen/wachtwoordvergeten", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function toonFoutNieuwWachtwoord($token) {
        $titel = "Fout!";
        $boodschap = "De opgegeven wachtwoorden komen niet overeen.</br>"
            . "Probeer opnieuw!";
        $link = array("url" => "gebruiker/inloggen/wachtwoordvergetenwijzigen/" . $token, "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function toonFoutMail() {
        $titel = "Fout!";
        $boodschap = "Er is iets foutgelopen bij het versturen van een mail.</br>"
            . "Probeer later opnieuw! Wanneer dit blijft voorvallen neem dan contact op met ons.";
        $link = array("url" => "home", "tekst" => "Home");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function toonMailNieuwWachtwoordVerstuurd() {
        $titel = "Mail verstuurd";
        $boodschap = "Er wordt een mail gestuurd naar het opgegevens E-mail adres.</br>"
            . "Dit kan enkele seconden duren, geen mail ontvangen? Ga terug en probeer opnieuw.";
        $link = array("url" => "gebruiker/inloggen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function toonWachtwoordVeranderd() {
        $titel = "Wachtwoord succesvol veranderd";
        $boodschap = "Uw wachtwoord werd succesvol gewijzigd.</br>"
            . "U kan nu gewoon inloggen met het nieuwe wachtwoord.";
        $link = array("url" => "gebruiker/inloggen", "tekst" => "Inloggen");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function toonGeactiveerd() {
        $titel = "Account succesvol geactiveerd";
        $boodschap = "Uw account werd succesvol geactiveerd.</br>"
            . "U kan nu gewoon inloggen met het ingestelde wachtwoord.";
        $link = array("url" => "gebruiker/inloggen", "tekst" => "Inloggen");

        $this->toonMelding($titel, $boodschap, $link);
    }

    /**
     * Dit zal Inloggen::toonMelding() oproepen en de nodige parrameters megeven om een boodschap te tonen.
     *
     * @see Inloggen::toonMelding()
     *
     * Gemaakt door Geffrey Wuyts
     */
    public function toonGeactiveerdDoorMedewerker() {
        $titel = "Account succesvol geactiveerd";
        $boodschap = "Uw heeft de gebruiker succesvol geactiveerd.</br>"
            . "De gebruiker zal een mail krijgen dat dit gebeurt is.</br>"
            . "Wanneer u zelf een wachtwoord heeft gekozen verwitig de gebruiker dan zelf!";
        $link = array("url" => "medewerker/gebruikersBeheren", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }
}
