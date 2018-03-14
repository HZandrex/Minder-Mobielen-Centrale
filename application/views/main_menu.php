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
        switch ($functie->functieNaam->naam) {
        case 'Coach':
            echo divAnchor('product/bestel', 'Producten bestellen', 'class="nav-item nav-link"');
            break;
        }
    }
    echo '</div>';
    
    echo '<div class="navbar-nav">';
        echo divAnchor('gebruiker/inloggen/loguit', $gebruiker->voornaam . ' ' . $gebruiker->naam, 'class="nav-item nav-link"');
    echo '</div>';
}
