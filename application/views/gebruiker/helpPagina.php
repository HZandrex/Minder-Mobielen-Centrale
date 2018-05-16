<?php
/**
 * @file gebruiker/helpPagina.php
 *
 * View waarin de helpPagina wordt weergegeven
 *  - Wanneer een medewerker of admin op deze pagina komt krijgt hij een extra stuk te zien voor gebruikers te beheren
 *
 * Gemaakt door Geffrey Wuyts & Tijmen Elseviers
 */
?>
    <style>
        .card {
            padding: 10px;
            margin-top: 20px;
        }
    </style>
    <div class="card">
        <h2 class="card-title">Persoonlijk Wachtwoord Wijzigen</h2>
        <p>Hieronder vindt ziet u in 3 stappen hoe u uw wachtwoord kan veranderen. Wij raden aan om uw wachtwoord
            regelmatig te veranderen wegens veiligheidsredenen.</p>
        <div class="row">
            <div class="col-lg-4">
                <b>Stap 1</b>
                <p>Als eerste gaan we naar 'Mijn gegevens'.</p>
                <?php echo toonAfbeelding('handleiding/handleiding1.png', $attributen = 'alt="afbeelding mijn gegevens" class="col-lg-12"'); ?>
            </div>
            <div class="col-lg-4">
                <b>Stap 2</b>
                <p>Daarna klik je op de knop wachtwoord wijzigen.</p>
                <?php echo toonAfbeelding('handleiding/handleiding2.png', $attributen = 'alt="afbeelding wachtwoord wijzigen knop" class="col-lg-12"'); ?>
            </div>
            <div class="col-lg-4">
                <b>Stap 3</b>
                <p>Daarna vul je het huidige wachtwoord en twee maal het nieuwe wachtwoord.</p>
                <?php echo toonAfbeelding('handleiding/handleiding3.png', $attributen = 'alt="afbeelding wachtwoord wijzigen" class="col-lg-12"'); ?>
            </div>
        </div>
    </div>
<?php
    $temp = false;
    foreach ($gebruiker->functies as $functie) {
        if ($functie->id >= 4) {
            $temp = true;
        }
    }
    if($temp){
?>
    <div class="card">
        <h2 class="card-title">Gebruikers beheren</h2>
        <p>Hier ziet u aan de hand van schermafbeeldingen en wat uitleg hoe u de gebruikers moet beheren. Neem gerust uw
            tijd om de afbeeldingen te bekijken en probeer het zelf eens uit.</p>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <?php echo toonAfbeelding("tutorial/tut1.jpg", 'class="d-block w-100" alt="First slide"'); ?>
                </div>
                <?php
                for ($i = 2; $i <= 7; $i++) {
                    echo '<div class="carousel-item">';
                    echo toonAfbeelding("tutorial/tut" . $i . ".jpg", 'class="d-block w-100" alt="First slide"');
                    echo '</div>';
                }
                ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev"
               style="color: black;">
                <span><i class="fas fa-angle-left fa-2x"></i></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next"
               style="color: black;">
                <span><i class="fas fa-angle-right fa-2x"></i></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
<?php } ?>

