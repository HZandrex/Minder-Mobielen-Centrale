<?php
$attributen = array('name' => 'wijzigenGegevensFormulier', 'class' => 'form-horizontal');
echo form_open('medewerker/gebruikersBeheren/gebruikerToevoegen', $attributen);
?>
<div class=row>
    <div class="col-lg-6 col-sm-12">
        <div class="row">
            <h4 class="col-12">Contactgegevens</h4>
            <div class="col-6">
                <?php echo form_label('Voornaam:', 'gegevensVoornaam'); ?>
                <input type="text" class="form-control" name="gegevensVoornaam"
                       required>
            </div>
            <div class="col-6">
                <?php echo form_label('Naam:', 'gegevensNaam'); ?>
                <input type="text" class="form-control" name="gegevensNaam"
                       required>
            </div>
            <div class="col-12">
                <?php echo form_label('Geboorte:', 'gegevensGeboorte'); ?>
                <input type="date" class="form-control" name="gegevensGeboorte"
                       required>
                <?php echo form_label('Telefoon:', 'gegevensTelefoon'); ?>
                <input type="text" class="form-control" name="gegevensTelefoon"
                       required>
                <?php echo form_label('Email:', 'gegevensMail'); ?>
                <input type="text" class="form-control" name="gegevensMail"
                       required>
                <?php echo form_label('Gewenst communicatiemiddel:', 'gegevensCommunicatie'); ?>
                <select class="form-control" name="gegevensCommunicatie" required>
                    <?php
                    foreach ($communicatiemiddelen as $middel) {
                        print '<option value="' . $middel->id . '">' . $middel->naam . '</option>';
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
                <?php echo form_label('Gemeente:', 'gegevensGemeente'); ?>
                <input type="text" class="form-control" name="gegevensGemeente"
                       required>
            </div>
            <div class="col-4">
                <?php echo form_label('Postcode:', 'gegevensPostcode'); ?>
                <input type="text" class="form-control" name="gegevensPostcode"
                       required>
            </div>
            <div class="col-8">
                <?php echo form_label('Straat:', 'gegevensStraat'); ?>
                <input type="text" maxlength="4" class="form-control" name="gegevensStraat"
                       required>
            </div>
            <div class="col-4">
                <?php echo form_label('Nr:', 'gegevensHuisnummer'); ?>
                <input type="text" class="form-control" name="gegevensHuisnummer"
                       required>
            </div>
        </div>

    </div>
</div>
<div class="text-right col-12">
    <?php echo form_submit('knop', 'Opslaan', 'class="btn btn-primary"'); ?>
    <?php echo anchor('gebruiker/persoonlijkeGegevens/persoonlijkeGegevens', 'Annuleren', 'class="btn btn-primary"'); ?>
    <?php echo form_close(); ?>
</div>

