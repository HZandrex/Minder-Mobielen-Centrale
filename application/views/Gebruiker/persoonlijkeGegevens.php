<div class="col-lg-12">
    <div class="row">
            <div class="col-md-6 form-group">
			<h3>Eigen gegevens</h3>	
            </div>
            <div class="col-md-6 form-group">
		<h4>Contactgegevens</h4>
            <table>
				<tr>
					<td>Voornaam:</td>
					<td><?php echo $gegevens->voornaam; ?></td>
				</tr>
				<tr>
					<td>Naam:</td>
					<td><?php echo $gegevens->naam; ?></td>
				</tr>
				<tr>
					<td>Telefoonnummer:</td>
					<td><?php echo $gegevens->telefoon; ?></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><?php echo $gegevens->mail; ?></td>
				</tr>
				<tr>
					<td>Gewenst communicatiemiddel:</td>
					<td><?php echo $gegevens->voorkeur; ?></td>
				</tr>
			</table>
            </div>
			<div class="pull-left">
			<h4>Adresgegevens</h4>
				<table>
					<tr>
					<td>Gemeente:</td>
					<td><?php echo $gegevens->adres; ?></td>
				</tr>
				<tr>
					<td>Postcode:</td>
					<td><?php echo $gegevens->adres; ?></td>
				</tr>
				<tr>
					<td>Straat + nr:</td>
					<td><?php echo $gegevens->adres; ?> <?php echo $gegevens->adres ?></td>
				</tr>
				</table>
			</div>
    </div>
</div>
