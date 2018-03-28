<?php
        $attributen = array('name' => 'wijzigenGegevensFormulier', 'class' => 'form-horizontal');
        echo form_open('gebruiker/persoonlijkegegevens/gegevensWijzig', $attributen);
    ?>
<div class="col-lg-12">
    <div class="row">
            <div class="col-lg-6 col-sm-12 centered">
		<h4>Contactgegevens</h4>
				<div class = "col-6">
					<?php echo form_label('Voornaam:', 'gegevensVoornaam'); ?>
					<input style="{width:auto} type="text" class="form-control" name="gegevensVoornaam" value= "<?php echo $gegevens->voornaam?>" required>
				</div>
				<div class = "col-6">
					<?php echo form_label('Naam:', 'gegevensNaam'); ?>
					<input type="text" class="form-control" name="gegevensNaam" value= "<?php echo $gegevens->naam?>" required>
				</div>
				<div class = "col-6">
					<?php echo form_label('Telefoon:', 'gegevensTelefoon'); ?>
					<input type="text" class="form-control" name="gegevensTelefoon" value= "<?php echo $gegevens->telefoon?>" required>
				</div>
				<div class = "col-6">
					<?php echo form_label('Email:', 'gegevensMail'); ?>
					<input type="text" class="form-control" name="gegevensMail" value= "<?php echo $gegevens->mail?>" required>
				</div>
				<div class = "col-6">
					<?php echo form_label('Gewenst communicatiemiddel:', 'gegevensCommunicatie'); ?>
					<input type="text" class="form-control" name="gegevensCommunicatie" value= "<?php echo $gegevens->voorkeur->naam?>" required>
				</div>
            </div>
			<div class="col-lg-6 col-sm-12 centered">
			<h4>Adresgegevens</h4>
				<div class = "col-6">
					<?php echo form_label('Gemeente:', 'gegevensGemeente'); ?>
					<input style="{width:auto} type="text" class="form-control" name="gegevensVoornaam" value= "<?php echo $gegevens->adres->gemeente?>" required>
				</div>
				<div class = "col-6">
					<?php echo form_label('Postcode:', 'gegevensPostcode'); ?>
					<input style="{width:auto} type="text" class="form-control" name="gegevensVoornaam" value= "<?php echo $gegevens->adres->postcode?>" required>
				</div>
				<div class = "col-6">
					<?php echo form_label('Straat + Nr:', 'gegevensStraat'); ?>
					<div class="row">
						<div class="col-8">
							<input type="text" maxlength="4"  class="form-control" name="contactGemeenteCode" value= "<?php echo $gegevens->adres->straat?>" required>
						</div>
						<div class="col-4">
							<input type="text" class="form-control" name="contactGemeente" value= "<?php echo $gegevens->adres->huisnummer?>" required>
						</div>
					</div>
				</div>
			</div>
			<div class="text-right col-12">
				<?php echo form_submit('knop', 'Opslaan', 'class="btn btn-primary"'); ?>
				<?php echo form_close(); ?>
			</div>
    </div>
</div>
