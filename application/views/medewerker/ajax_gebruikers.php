<?php
/**
 * @file medewerker/ajax_gebruikers.php
 *
 * View waarin een lijst van gebruikers wordt getoond
 * - krijgt een $gebruiker-object binnen
 *
 * Gemaakt door Geffrey Wuyts
 */
?>

<?php

foreach ($gebruikers as $gebruiker) {
    echo '<option value="' . $gebruiker->id . '">' . $gebruiker->voornaam . ' ' . $gebruiker->naam . '</option>';
}
?>