<?php
if ($gebruiker == null) { // niet aangemeld
    echo divAnchor('gebruiker/inloggen', 'Inloggen', 'class="nav-item nav-link"');
} else { // wel aangemeld
    echo divAnchor('home/meldAf', 'Afmelden');
    switch ($gebruiker->level) {
        case 1: // gewone geregistreerde gebruiker
            echo divAnchor('product/bestel', 'Producten bestellen');
            break;
        case 5: // administrator
            echo divAnchor('product/beheer', 'Producten beheren');
            echo divAnchor('admin/beheer', 'Gebruikers beheren');
            echo divAnchor('admin/configureer', 'Configureren');
            break;
    }
}
