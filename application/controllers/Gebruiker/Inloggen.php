<?php

/**
 * @class Inloggen
 * @brief Controller-klasse voor het inloggen
 * 
 * Controller-klase met alle methodes die gebruikt worden om in te loggen
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Inloggen extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Toont het inlogscherm in de view inlogPagina.php
     * 
     * @see inlogPagina.php
     */
    public function index() {
        $data['titel'] = '';
        $data['author'] = 'Geffrey W.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'Gebruiker/inlogPagina');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Logt in met de Authex library door de methode meldAan($email, $wachtwoord)
     * de inloggegevens worden via de post methode binnengehaald vanuit de form
     * in de view inlogPagina.php
     * 
     * Wanneer het inloggen lukt zal Home::index() worden opgeroepen
     * wanner de gegevens fout zijn zal de methode toonFoutInloggen worden opgeroepen.
     * 
     * @param $email Het mail adres dat werd opgeven in de view inlogPagina.php
     * @param $wachtwoord Het wachtwoord dat werd opgeven in de view inlogPagina.php
     * @see Inloggen::toonFoutInloggen()
     * @see Home::index()
     */
    public function controleerLogin() {
        $email = $this->input->post('email');
        $wachtwoord = $this->input->post('wachtwoord');

        if ($this->authex->meldAan($email, $wachtwoord)) {
            redirect('home');
        } else {
            redirect('gebruiker/inloggen/toonFoutInloggen');
        }
    }

    /**
     * Logt uit met de Authex library met de methode meldAf(), vervolgens wordt Home::index() opgeroepen
     * @see Home::index()
     */
    public function loguit() {
        $this->authex->meldAf();
        redirect('home');
    }
    
    /**
     * Toont het scherm om een nieuw wachtwoord aan te vragen in de view wachtwoordVergeten.php
     * 
     * @see wachtwoordVergeten.php
     */

    public function wachtwoordVergeten() {
        $data['titel'] = '';
        $data['author'] = 'Geffrey W.';
        $data['gebruiker'] = $this->authex->getGebruikerInfo();

        $partials = array('menu' => 'main_menu', 'inhoud' => 'Gebruiker/wachtwoordVergeten');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Kijkt eerst of er een account bestaat met het opgegeven mailadres(mail = $email) via gebruiker_model.
     * Wanneer er een geen account wordt gevonden wordt de functie toonFoutWachtwoordVeranderen worden opgeroepen.
     * 
     * Bij het vinden van een account zal er eerst een reset token worden gegereneerd via de functie random_resetToken(),
     * vervolgens wordt er gecontroleerd of deze al bestaat in de tabel via het gebruiker_model. Als de token al bestaat zal
     * er een nieuwe worden gegenereerd totdat hij uniek is in de tabel.
     * 
     * Vervolgens zal de gebruiker met het opgegeven mailadres worden bijgewerkt met de reset token via het gebruiker_model,
     * er zal ook een mail worden gestuurd naar het opgegeven mailadres om te zeggen dat er nieuw wachtwoord is aangevraagd en
     * een link in om het nieuwe wachtwoord in te stellen. deze link bevat de reset token om op de pagina te controlren of
     * dit een geldig verzoek is en voor wie het nieuwe wachtwoord bedoeld is, het verzenden van de mail gebeurt via de functie
     * stuurMail. Vervolgens wordt ook een bevesteging getoond via toonMailNieuwWachtwoordVerstuurd.
     * 
     * De link da de view wachtwoordVergetenWijzigen.php openen.
     * 
     * @param $email Het mail adres dat werd opgeven in de view inlogPagina.php
     * @param $resetToken een toekn van 20 willekeurige karrakters lang om het proces vijlig te maken
     * @see Inloggen::toonFoutWachtwoordVeranderen()
     * @see Inloggen::toonMailNieuwWachtwoordVerstuurd()
     * @see Inloggen::random_resetToken()
     * @see Inloggen::wachtwoordVergetenWijzigen()
     * @see Gebruiker_model::controleerEmailVrij()
     * @see Gebruiker_model::controleerResetToken()
     * @see Gebruiker_model::wijzigResetToken()
     */
    public function nieuwWachtwoordAanvragen() {
        $email = $this->input->post('email');

        $this->load->model('gebruiker_model');

        if ($this->gebruiker_model->controleerEmailVrij($email)) {
            redirect('gebruiker/inloggen/toonFoutWachtwoordVeranderen');
        } else {
            $resetToken = $this->random_resetToken();
            while ($this->gebruiker_model->controleerResetToken($resetToken)) {
                $resetToken = $this->random_resetToken();
            }
            $this->gebruiker_model->wijzigResetToken($email, $resetToken);
            $titel = "Minder Mobiele Centrale aanvraag nieuw wachtwoord";
            $boodschap = '<p>U heeft een nieuw wachtwoord aangevraagd. Druk op onderstaande link om een nieuw wachtwoord aan te vragen.</p>'
                    . '<p>Wanneer u zelf geen nieuw wachtwoord hebt aangevraagd hoeft u deze mail simpel te negeren.</p>'
                    . '<p>Verander wachtwoord: ' . anchor('http://localhost/project23_1718/index.php/gebruiker/inloggen/wachtwoordVergetenWijzigen/' . $resetToken, 'Link om wachtwoord te veranderen') . '</p>';
            $this->stuurMail($email, $boodschap, $titel);

            redirect('gebruiker/inloggen/toonMailNieuwWachtwoordVerstuurd');
        }
    }
    
    /**
     * Stuurt een E-mail naar het ogegeven mailadres $geadresseerde, de mail wordt opgesteld
     * met de parameters $titel en $boodschap. Dit gebeurd via de email library.
     * 
     * De configuratie van het mail adres waar me wordt verzonden is email.php dat zich bevind in de config map.
     * 
     * @see email.php
     */
    private function stuurMail($geadresseerde, $boodschap, $titel) {
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
     * 
     */
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

    public function toonFoutInloggen() {
        $titel = "Fout!";
        $boodschap = "Het opgegeven mail adres komt niet overeen met het wachtwoord.</br>"
                . "Probeer opnieuw!";
        $link = array("url" => "gebruiker/inloggen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    public function toonFoutWachtwoordVeranderen() {
        $titel = "Fout!";
        $boodschap = "Het opgegeven mail adres is niet gekoppeld aan een account.</br>"
                . "Probeer opnieuw!";
        $link = array("url" => "gebruiker/inloggen/wachtwoordVergeten", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    public function toonFoutLinkVerlopen() {
        $titel = "Fout!";
        $boodschap = "De url die u gebruikte is niet meer geldig.</br>"
                . "Vraag een nieuwe aan!";
        $link = array("url" => "gebruiker/inloggen/wachtwoordVergeten", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }

    public function toonFoutNieuwWachtwoord($token) {
        $titel = "Fout!";
        $boodschap = "De opgegeven wachtwoorden komen niet overeen.</br>"
                . "Probeer opnieuw!";
        $link = array("url" => "gebruiker/inloggen/wachtwoordVergetenWijzigen/" . $token, "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }
    
    public function toonMailNieuwWachtwoordVerstuurd() {
        $titel = "Mail verstuurd";
        $boodschap = "Er wordt een mail gestuurd naar het opgegevens E-mail adres.</br>"
                . "Dit kan enkele seconden duren, geen mail ontvangen? Ga terug en probeer opnieuw.";
        $link = array("url" => "gebruiker/inloggen", "tekst" => "Terug");

        $this->toonMelding($titel, $boodschap, $link);
    }
    
    public function toonWachtwoordVeranderd() {
        $titel = "Wachtwoord succesvol veranderd";
        $boodschap = "Uw wachtwoord werd succesvol gewijzigd.</br>"
                . "U kan nu gewoon inloggen met het nieuwe wachtwoord.";
        $link = array("url" => "gebruiker/inloggen", "tekst" => "Inloggen");

        $this->toonMelding($titel, $boodschap, $link);
    }

    public function wachtwoordVergetenWijzigen($resetToken) {
        $this->load->model('gebruiker_model');
        if ($this->gebruiker_model->controleerResetToken($resetToken)) {
            $data['titel'] = '';
            $data['author'] = 'Geffrey W.';
            $data['gebruiker'] = $this->authex->getGebruikerInfo();

            $data['resetToken'] = $resetToken;

            $partials = array('menu' => 'main_menu', 'inhoud' => 'Gebruiker/wachtwoordVergetenWijzigen');
            $this->template->load('main_master', $partials, $data);
        } else {
            redirect('gebruiker/inloggen/toonFoutLinkVerlopen');
        }
    }

    public function wachtwoordVeranderen() {
        $resetToken = $this->input->post('resetToken');
        $Wachtwoord = $this->input->post('wachtwoord');

        $this->load->model('gebruiker_model');

        if ($this->gebruiker_model->controleerResetToken($resetToken)) {
            if ($Wachtwoord == $this->input->post('wachtwoordBevestigen')) {
                $gebruiker = $this->gebruiker_model->getByResetToken($resetToken);
                $this->gebruiker_model->wijzigWachtwoordReset($resetToken, $Wachtwoord);
                $titel = "Minder Mobiele Centrale wachtwoord veranderd";
                $boodschap = "<p>U heeft zojuist uw wachtwoord veranderd. Noteer dit wachtwoord ergens of onthoud dit goed.</p>"
                        . "<p>Heeft u het wachtwoord niet veranderd en krijgd u deze mail, neem dan snel contact met ons op."
                        . " U vindt deze gegevens op onze site.<p>" . anchor('home', "Link naar de site van de Minder Mobiele Centrale");
                $this->stuurMail($gebruiker->mail, $boodschap, $titel);
                redirect('gebruiker/inloggen/toonWachtwoordVeranderd');
            } else {
                redirect('gebruiker/inloggen/toonFoutNieuwWachtwoord/' . $resetToken);
            }
        } else {
            redirect('gebruiker/inloggen/toonFoutLinkVerlopen');
        }
    }

    private function random_resetToken() {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $resetToken = substr(str_shuffle($chars), 0, 20);
        return $resetToken;
    }

}
