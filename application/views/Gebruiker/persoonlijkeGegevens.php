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
					<td><?php $gegevens->voornaam; ?></td>
				</tr>
				<tr>
					<td>Naam:</td>
					<td><?php $gegevens->naam; ?></td>
				</tr>
				<tr>
					<td>Telefoonnummer:</td>
					<td><?php $gegevens->telefoon; ?></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><?php $gegevens->mail; ?></td>
				</tr>
				<tr>
					<td>Gewenst communicatiemiddel:</td>
					<td><?php $gegevens->VoorkeurID; ?></td>
				</tr>
			</table>
            </div>
			<div class="col-md-6 form-group">
			<h4>Adresgegevens</h4>
				<table>
					<tr>
					<td>Gemeente:</td>
					<td><?php $gegevens->gemeente; ?></td>
				</tr>
				<tr>
					<td>Postcode:</td>
					<td><?php $gegevens->postcode; ?></td>
				</tr>
				<tr>
					<td>Straat + nr:</td>
					<td><?php $gegevens->straat; ?> <?php $gegevens->huisnummer ?></td>
				</tr>
				</table>
			</div>
    </div>
</div>
