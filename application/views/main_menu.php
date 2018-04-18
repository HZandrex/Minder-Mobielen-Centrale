<?php
    /**
     * @file main_menu.php
     * 
     * View waarin de inhoud van de navbar wordt opgemaakt
     * - aan de hand van de functie van de ingelogde gebruiker worden er andere functies getoont
     */
?>

<?php
echo '<div class="navbar-nav mr-auto">';
echo divAnchor('home', 'Home', 'class="nav-item nav-link"');

if ($gebruiker == null) { // niet aangemeld
    echo '</div>';
    echo '<div class="navbar-nav">';
    echo divAnchor('gebruiker/inloggen', 'Inloggen', 'class="nav-item nav-link"');
    echo '</div>';
} else { // wel aangemeld
    foreach ($gebruiker->functies as $functie) {
        switch ($functie->naam) {
            case 'Minder mobiele':
                    echo divAnchor('MM/Ritten','Ritten beheren','class="nav-item nav-link"');
                    break;
				
            case 'Coach':
                echo divAnchor('Coach/Ritten','MM beheren','class="nav-item nav-link"');
				echo divAnchor('Coach/MijnMM/mijnMMLijst','Mijn MM','class="nav-item nav-link"');
                break;
				
            case 'Vrijwilliger':
                echo divAnchor('Vrijwilliger/Ritten','Ritten','class="nav-item nav-link"');
                break;
				
            case 'Medewerker':
                echo divAnchor('medewerker/gebruikersBeheren','Gebruikers beheren','class="nav-item nav-link"');
                break;

            case 'Admin':
                echo divAnchor('admin/webinfo', 'Webinfo wijzigen', 'class="nav-item nav-link"');
                echo divAnchor('admin/instellingen', 'Instellingen', 'class="nav-item nav-link"');
                break;
        }
    }
    echo '</div>';
    ?>
    <div class="navbar-nav">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $gebruiker->voornaam . ' ' . $gebruiker->naam; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <?php echo divAnchor('gebruiker/persoonlijkegegevens/persoonlijkegegevens', 'Mijn gegevens', 'class="nav-link"'); ?>
                <?php echo divAnchor('gebruiker/inloggen/loguit', 'Uitloggen', 'class="nav-link"'); ?>
            </div>
        </li>
    </div>
<?php } ?>