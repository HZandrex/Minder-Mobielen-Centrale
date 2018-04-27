<div class="col-sm-8">
    <h4>Contactgegevens</h4>
    <table class="table">
        <tr>
            <td>Voornaam:</td>
            <td><?php print $gebruiker->voornaam; ?></td>
        </tr>
        <tr>
            <td>Naam:</td>
            <td><?php print $gebruiker->naam; ?></td>
        </tr>
        <tr>
            <td>Geboorte:</td>
            <td><?php print date("d/m/Y", strtotime($gebruiker->geboorte)) ?></td>
        </tr>
        <tr>
            <td>Telefoonnummer:</td>
            <td><?php print $gebruiker->telefoon; ?></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><?php print $gebruiker->mail; ?></td>
        </tr>
        <tr>
            <td>Gewenst communicatiemiddel:</td>
            <td><?php print $gebruiker->voorkeur->naam; ?></td>
        </tr>
    </table>
</div>
<div class="col-sm-4">
    <h4>Functies</h4>
    <ul>
        <?php foreach ($gebruiker->functies as $functie){
            echo "<li>$functie->naam</li>";
        }?>
    </ul>
</div>
<div class="col-sm-12">
    <h4>Adresgegevens</h4>
    <table class="table">
        <tr>
            <td>Gemeente:</td>
            <td><?php print $gebruiker->adres->gemeente; ?></td>
        </tr>
        <tr>
            <td>Postcode:</td>
            <td><?php print $gebruiker->adres->postcode; ?></td>
        </tr>
        <tr>
            <td>Straat + nr:</td>
            <td><?php print $gebruiker->adres->straat; ?> <?php print $gebruiker->adres->huisnummer ?></td>
        </tr>
    </table>
</div>
<div class="col-sm-12">
    <?php print anchor("medewerker/gebruikersBeheren/wachtwoordWijzigen/$gebruiker->id", 'Wachtwoord wijzigen', 'class="btn btn-primary"'); ?>
    <?php print anchor("medewerker/gebruikersBeheren/gegevensWijzigen/$gebruiker->id", 'Gegevens wijzigen', 'class="btn btn-primary"'); ?>
</div>

