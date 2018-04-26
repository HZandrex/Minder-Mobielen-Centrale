<?php
$attributen = array('name' => 'wijzigenGegevensFormulier', 'class' => 'form-horizontal');
$hidden = array('id' => $editGebruiker->id);
echo form_open('medewerker/gebruikersBeheren/gegevensVeranderen', $attributen, $hidden);
?>
<div class=row>
    <div class="col-lg-6 col-sm-12">
        <div class="row">
            <h4 class="col-12">Contactgegevens</h4>
            <div class="col-6">
                <?php echo form_label('Voornaam:', 'voornaam'); ?>
                <input type="text" class="form-control" name="voornaam"
                       value="<?php echo $editGebruiker->voornaam ?>"
                       required>
            </div>
            <div class="col-6">
                <?php echo form_label('Naam:', 'naam'); ?>
                <input type="text" class="form-control" name="naam" value="<?php echo $editGebruiker->naam ?>"
                       required>
            </div>
            <div class="col-12">
                <?php echo form_label('Geboorte:', 'geboorte'); ?>
                <input type="date" class="form-control" name="geboorte"
                       value="<?php print $editGebruiker->geboorte ?>"
                       required>
                <?php echo form_label('Telefoon:', 'telefoon'); ?>
                <input type="text" class="form-control" name="telefoon"
                       value="<?php echo $editGebruiker->telefoon ?>"
                       required>
                <?php echo form_label('Email:', 'mail'); ?>
                <input type="text" class="form-control" name="mail" value="<?php echo $editGebruiker->mail ?>"
                       required>
                <?php echo form_label('Gewenst communicatiemiddel:', 'voorkeur'); ?>
                <select class="form-control" name="voorkeurId" required>
                    <?php
                    foreach ($voorkeuren as $voorkeur) {
                        if ($voorkeur->id == $editGebruiker->voorkeur->id) {
                            print '<option selected value="' . $voorkeur->id . '">' . $voorkeur->naam . '</option>';
                        } else {
                            print '<option value="' . $voorkeur->id . '">' . $voorkeur->naam . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12">
        <div class="row">
            <h4 class="col-12">Adresgegevens</h4>
            <div class="col-8">
                <?php echo form_label('Gemeente:', 'gemeente'); ?>
                <input type="text" class="form-control" name="gemeente"
                       value="<?php echo $editGebruiker->adres->gemeente ?>" required>
            </div>
            <div class="col-4">
                <?php echo form_label('Postcode:', 'postcode'); ?>
                <input type="text" class="form-control" name="postcode"
                       value="<?php echo $editGebruiker->adres->postcode ?>" required>
            </div>
            <div class="col-8">
                <?php echo form_label('Straat:', 'straat'); ?>
                <input type="text" maxlength="4" class="form-control" name="straat"
                       value="<?php echo $editGebruiker->adres->straat ?>" required>
            </div>
            <div class="col-4">
                <?php echo form_label('Nr:', 'huisnummer'); ?>
                <input type="text" class="form-control" name="huisnummer"
                       value="<?php echo $editGebruiker->adres->huisnummer ?>" required>
            </div>
            <div class="col-12">
                <h4>Functies</h4>
                <?php foreach ($functies as $functie){
                    echo '<div class="form-check">';
                    $temp = false;
                    foreach ($editGebruiker->functies as $gebruikerFunctie) {
                        if ($gebruikerFunctie->id == $functie->id) {
                            echo form_checkbox("functie" . $functie->id, $functie->id, TRUE, 'class="form-check-input" id="'.$functie->naam.'"');
                            $temp = true;
                        }
                    }
                    if(!$temp){
                        echo form_checkbox("functie" . $functie->id, $functie->id, FALSE, 'class="form-check-input" id="'.$functie->naam.'"');
                    }
                    echo form_label($functie->naam, $functie->naam, 'class="form-check-label"');
                    echo "</div>";
                }?>
            </div>
        </div>
    </div>
</div>
<div class="text-right col-12">
    <?php echo form_submit('knop', 'Opslaan', 'class="btn btn-primary"'); ?>
    <?php echo anchor('medewerker/gebruikersBeheren', 'Annuleren', 'class="btn btn-primary"'); ?>
    <?php echo form_close(); ?>
</div>
