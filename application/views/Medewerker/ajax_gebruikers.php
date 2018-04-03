<?php

foreach ($gebruikers as $gebruiker) {
    echo '<option value="' . $gebruiker->id . '">' . $gebruiker->voornaam . ' ' . $gebruiker->naam . '</option>';
}
?>