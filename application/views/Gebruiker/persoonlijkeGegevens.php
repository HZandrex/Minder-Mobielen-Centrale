<div class="col-lg-12">
    <div class="row">
            <div class="col-lg-6 col-sm-12 centered">
		<h4>Contactgegevens</h4>
            <table class="col-lg-6 col-sm-12 table">
				<tr>
					<td class="col-3">Voornaam:</td>
					<td class="col-3"><?php echo $gegevens->voornaam; ?></td>
				</tr>
				<tr>
					<td class="col-3">Naam:</td>
					<td class="col-3"><?php echo $gegevens->naam; ?></td>
				</tr>
				<tr>
					<td class="col-3">Telefoonnummer:</td>
					<td class="col-3"><?php echo $gegevens->telefoon; ?></td>
				</tr>
				<tr>
					<td class="col-3">Email:</td>
					<td class="col-3"><?php echo $gegevens->mail; ?></td>
				</tr>
				<tr>
					<td class="col-3">Gewenst communicatiemiddel:</td>
					<td class="col-3"><?php echo $gegevens->voorkeur->naam; ?></td>
				</tr>
			</table>
            </div>
			<div class="col-lg-6 col-sm-12 centered">
			<h4>Adresgegevens</h4>
				<table class="col-lg-6 col-sm-12 table">
				<tr>
					<td class="col-3">Gemeente:</td>
					<td class="col-3"><?php echo $gegevens->adres->gemeente; ?></td>
				</tr>
				<tr>
					<td class="col-3">Postcode:</td>
					<td class="col-3"><?php echo $gegevens->adres->postcode; ?></td>
				</tr>
				<tr>
					<td class="col-3">Straat + nr:</td>
					<td class="col-3"><?php echo $gegevens->adres->straat; ?> <?php echo $gegevens->adres->huisnummer ?></td>
				</tr>
				</table>
			</div>
			<div>
				<?php echo divAnchor('gebruiker/persoonlijkegegevens/wachtwoordWijzigen', 'Wachtwoord wijzigen', 'class="btn btn-primary"'); ?>
			</div>
    </div>
</div>
