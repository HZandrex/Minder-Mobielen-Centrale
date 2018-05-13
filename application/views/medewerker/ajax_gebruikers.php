<?php
/**
 * @file medewerker/ajax_gebruikers.php
 *
 * View waarin een lijst van gebruikers wordt getoond
 */
?>

<?php

foreach ($gebruikers as $gebruiker) {
    echo '<option value="' . $gebruiker->id . '">' . $gebruiker->voornaam . ' ' . $gebruiker->naam . '</option>';
}
?>