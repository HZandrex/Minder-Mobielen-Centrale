<?php
$attributen = array('name' => 'wijzigenGegevensFormulier', 'class' => 'form-horizontal');
echo form_open('medewerker/gebruikersbeheren/gebruikerToevoegen', $attributen);
?>
<div class="col-lg-12">
    <div class=row>
        <div class="col-lg-6 col-sm-12">
            <h4>Contactgegevens</h4>
            <?php echo form_label('Voornaam:', 'voornaam'); ?>
            <input style="{width:auto} type=" text" class="form-control" name="voornaam" required>
            <?php echo form_label('Naam:', 'naam'); ?>
            <input type="text" class="form-control" name="naam" required>
            <?php echo form_label('Geboorte:', 'geboorte'); ?>
            <input type="date" class="form-control" name="geboorte" required>
            <?php echo form_label('Telefoon:', 'telefoon'); ?>
            <input type="text" class="form-control" name="telefoon" required>
            <?php echo form_label('Email:', 'mail'); ?>
            <input type="text" class="form-control" name="mail" required>
            <?php echo form_label('Gewenst communicatiemiddel:', 'voorkeurId'); ?>
            <select class="form-control" name="voorkeurId" required>
                <?php
                foreach ($communicatiemiddelen as $middel) {
                    print '<option value="' . $middel->id . '">' . $middel->naam . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-lg-6 col-sm-12">
            <h4>Adresgegevens</h4>
            <?php echo form_label('Gemeente:', 'gemeente'); ?>
            <input style="{width:auto} type=" text" class="form-control" name="gemeente" required>
            <?php echo form_label('Postcode:', 'postcode'); ?>
            <input style="{width:auto} type=" text" class="form-control" name="postcode" required>
            <?php echo form_label('Straat + Nr:', 'straat'); ?>
            <div class="row">
                <div class="col-8">
                    <input type="text" class="form-control" name="straat" required>
                </div>
                <div class="col-4">
                    <input type="text" maxlength="4" class="form-control" name="huisnummer" required>
                </div>
            </div>

        </div>
    </div>
    <div class="text-right col-12">
        <?php echo form_submit('knop', 'Opslaan', 'class="btn btn-primary"'); ?>
        <?php echo anchor('gebruiker/persoonlijkegegevens/persoonlijkegegevens', 'Annuleren', 'class="btn btn-primary"'); ?>
        <?php echo form_close(); ?>
    </div>
</div>
