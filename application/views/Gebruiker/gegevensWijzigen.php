<?php
        $attributen = array('name' => 'wijzigenGegevensFormulier', 'class' => 'form-horizontal');
		$hidden = array('id' => $gegevens->id);
        echo form_open('gebruiker/persoonlijkegegevens/gegevensVeranderen', $attributen, $hidden);
    ?>
<div class="col-lg-12">
	<div class=row>
        <div class="col-lg-6 col-sm-12">
		<h4>Contactgegevens</h4>
					<?php echo form_label('Voornaam:', 'gegevensVoornaam'); ?>
					<input style="width:auto;" type="text" class="form-control" name="gegevensVoornaam" value= "<?php echo $gegevens->voornaam?>" required>
					<?php echo form_label('Naam:', 'gegevensNaam'); ?>
					<input type="text" class="form-control" name="gegevensNaam" value= "<?php echo $gegevens->naam?>" required>
					<?php echo form_label('Geboorte:', 'gegevensGeboorte'); ?>
					<input type="date" class="form-control" name="gegevensGeboorte" value= "<?php print $gegevens->geboorte ?>" required>
					<?php echo form_label('Telefoon:', 'gegevensTelefoon'); ?>
					<input type="text" class="form-control" name="gegevensTelefoon" value= "<?php echo $gegevens->telefoon?>" required>
					<?php echo form_label('Email:', 'gegevensMail'); ?>
					<input type="text" class="form-control" name="gegevensMail" value= "<?php echo $gegevens->mail?>" required>
					<?php echo form_label('Gewenst communicatiemiddel:', 'gegevensCommunicatie'); ?>
					<select class="form-control" name="gegevensCommunicatie" required>
					<?php
					foreach($communicatiemiddelen as $middel)
					{
						if($middel->id == $gegevens->voorkeur->id){
							print '<option selected value="'.$middel->id.'">'.$middel->naam.'</option>';
						}
						else{
							print '<option value="'.$middel->id.'">'.$middel->naam.'</option>';
						}
					}
					?>
					</select>
            </div>
			<div class="col-lg-6 col-sm-12">
			<h4>Adresgegevens</h4>
					<?php echo form_label('Gemeente:', 'gegevensGemeente'); ?>
					<input style="width:auto" type="text" class="form-control" name="gegevensGemeente" value= "<?php echo $gegevens->adres->gemeente?>" required>
					<?php echo form_label('Postcode:', 'gegevensPostcode'); ?>
					<input style="width:auto" type="text" class="form-control" name="gegevensPostcode" value= "<?php echo $gegevens->adres->postcode?>" required>
					<?php echo form_label('Straat + Nr:', 'gegevensStraat'); ?>
					<div class="row">
						<div class="col-8">
							<input type="text" maxlength="4"  class="form-control" name="gegevensStraat" value= "<?php echo $gegevens->adres->straat?>" required>
						</div>
						<div class="col-4">
							<input type="text" class="form-control" name="gegevensHuisnummer" value= "<?php echo $gegevens->adres->huisnummer?>" required>
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
