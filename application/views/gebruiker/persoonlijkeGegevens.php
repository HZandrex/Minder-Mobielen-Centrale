<?php
    /**
     * @file gebruiker/persoonlijkeGegevens.php
     * 
     * View waarin de persoonlijke gegevens van de ingelogde gebruiker worden getoond.
     * - Ga via de knop Wachtwoord wijzigen naar de controller PersoonlijkeGegevens::wachtwoordWijzigen()
	 * - Ga via de knop Gegevens wijzigen naar de controller PersoonlijkeGegevens::gegevensWijzigen()
     * 
     * @see PersoonlijkeGegevens::wachtwoordWijzigen()
	 * @see PersoonlijkeGegevens::gegevensWijzigen()
     *
     * Gemaakt door Tijmen Elseviers
     */
?>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 col-sm-12 centered">
            <h4>Contactgegevens</h4>
            <table class="col-lg-6 col-sm-12 table">
                <tr>
                    <td class="col-3">Voornaam:</td>
                    <td class="col-3"><?php print $gegevens->voornaam; ?></td>
                </tr>
                <tr>
                    <td class="col-3">Naam:</td>
                    <td class="col-3"><?php print $gegevens->naam; ?></td>
                </tr>
                <tr>
                    <td class="col-3">Geboorte:</td>
                    <td class="col-3"><?php print date("d/m/Y", strtotime($gegevens->geboorte)) ?></td>
                </tr>
                <tr>
                    <td class="col-3">Telefoonnummer:</td>
                    <td class="col-3"><?php print $gegevens->telefoon; ?></td>
                </tr>
                <tr>
                    <td class="col-3">Email:</td>
                    <td class="col-3"><?php print $gegevens->mail; ?></td>
                </tr>
                <tr>
                    <td class="col-3">Gewenst communicatiemiddel:</td>
                    <td class="col-3"><?php print $gegevens->voorkeur->naam; ?></td>
                </tr>
            </table>
        </div>
        <div class="col-lg-6 col-sm-12 centered">
            <h4>Adresgegevens</h4>
            <table class="col-lg-6 col-sm-12 table">
                <tr>
                    <td class="col-3">Gemeente:</td>
                    <td class="col-3"><?php print $gegevens->adres->gemeente; ?></td>
                </tr>
                <tr>
                    <td class="col-3">Postcode:</td>
                    <td class="col-3"><?php print $gegevens->adres->postcode; ?></td>
                </tr>
                <tr>
                    <td class="col-3">Straat + nr:</td>
                    <td class="col-3"><?php print $gegevens->adres->straat; ?><?php print ' '.$gegevens->adres->huisnummer ?></td>
                </tr>
            </table>
        </div>
        <div class="col-lg-12 col-sm-12">
            <?php print anchor('gebruiker/persoonlijkeGegevens/wachtwoordWijzigen', 'Wachtwoord wijzigen', 'class="btn btn-primary"'); ?>
            <?php print anchor('gebruiker/persoonlijkeGegevens/gegevensWijzigen', 'Gegevens wijzigen', 'class="btn btn-primary"'); ?>
        </div>
    </div>
</div>
