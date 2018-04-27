<div class="col-sm-8">
    <h4>Contactgegevens</h4>
    <table class="table">
        <tr>
            <td>Voornaam:</td>
            <td><?php print $selectedGebruiker->voornaam; ?></td>
        </tr>
        <tr>
            <td>Naam:</td>
            <td><?php print $selectedGebruiker->naam; ?></td>
        </tr>
        <tr>
            <td>Geboorte:</td>
            <td><?php print date("d/m/Y", strtotime($selectedGebruiker->geboorte)) ?></td>
        </tr>
        <tr>
            <td>Telefoonnummer:</td>
            <td><?php print $selectedGebruiker->telefoon; ?></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><?php print $selectedGebruiker->mail; ?></td>
        </tr>
        <tr>
            <td>Gewenst communicatiemiddel:</td>
            <td><?php print $selectedGebruiker->voorkeur->naam; ?></td>
        </tr>
    </table>
</div>
<div class="col-sm-4"">
    <h4>Functies</h4>
    <ul>
        <?php foreach ($selectedGebruiker->functies as $functie){
            echo "<li>$functie->naam</li>";
        }?>
    </ul>
</div>
<div class="col-sm-12">
    <h4>Adresgegevens</h4>
    <table class="table">
        <tr>
            <td>Gemeente:</td>
            <td><?php print $selectedGebruiker->adres->gemeente; ?></td>
        </tr>
        <tr>
            <td>Postcode:</td>
            <td><?php print $selectedGebruiker->adres->postcode; ?></td>
        </tr>
        <tr>
            <td>Straat + nr:</td>
            <td><?php print $selectedGebruiker->adres->straat; ?> <?php print $selectedGebruiker->adres->huisnummer ?></td>
        </tr>
    </table>
</div>
<div class="col-sm-12">
    <?php print anchor("medewerker/gebruikersBeheren/wachtwoordWijzigen/$selectedGebruiker->id", 'Wachtwoord wijzigen', 'class="btn btn-primary"'); ?>
    <?php print anchor("medewerker/gebruikersBeheren/gegevensWijzigen/$selectedGebruiker->id", 'Gegevens wijzigen', 'class="btn btn-primary"'); ?>
</div>

