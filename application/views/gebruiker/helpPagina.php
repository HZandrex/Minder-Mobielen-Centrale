<?php
/**
 * @file Gebruiker/helpPagina.php
 *
 * View waarin de helpPagina wordt weergegeven
 */
?>
<style>
	.card{
		padding:10px;
	}
</style>
<div class="card">
	<div class="row">
		<div class="col-lg-4">
			<h3>Stap 1</h3>
			<p>Als eerste gaan we naar 'Mijn gegevens'.</p>
			<?php echo toonAfbeelding('handleiding/handleiding1.png', $attributen = 'alt="afbeelding mijn gegevens" class="col-lg-12"');?>
		</div>
		<div class="col-lg-4">
			<h3>Stap 2</h3>
			<p>Daarna klik je op de knop wachtwoord wijzigen.</p>
			<?php echo toonAfbeelding('handleiding/handleiding2.png', $attributen = 'alt="afbeelding wachtwoord wijzigen knop" class="col-lg-12"');?>
		</div>
		<div class="col-lg-4">
			<h3>Stap 3</h3>
			<p>Daarna vul je het huidige wachtwoord en twee maal het nieuwe wachtwoord.</p>
			<?php echo toonAfbeelding('handleiding/handleiding3.png', $attributen = 'alt="afbeelding wachtwoord wijzigen" class="col-lg-12"');?>
		</div>
	</div>
</div>


