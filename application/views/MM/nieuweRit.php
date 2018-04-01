<?php
	var_dump($gebruiker);
	var_dump($adressen);
	
	$selectAdressen = '<option selected>Kies een adres of voeg er een toe</option><option id="nieuwAdres" value="nieuwAdres">Nieuw adres</option>';
	foreach($adressen as $adres){
		$selectAdressen .= '<option value="' . $adres->id . '">' . $adres->straat . ' ' . $adres->huisnummer . ' (' . $adres->gemeente . ')</option>';
	}

?>

<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-sm-6">
				<p><i class="fas fa-shopping-cart"></i> klant: <?php print $gebruiker->voornaam . " " . $gebruiker->naam; ?></p>
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="heenTerug">
					<label class="custom-control-label" for="heenTerug">Heen en terug</label>
				</div>
			</div>
			<div class="col-sm-6">
				<button type="button" class="btn btn-primary"><i class="fas fa-save"></i> Opslaan</button>
				<button type="button" class="btn btn-danger"><i class="fas fa-ban"></i> Anuleren</button>
			</div>
		</div>
	</div>
</div>
<article class="mt-2" id="heen">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-sm-6">
					<h5>Heen rit</h5>
				</div>
				<div class="col-sm-6 text-right">
					
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col">
					<label for="heenDatum">Datum: </label>
					<div class="input-group">
						<div class="input-group-prepend">
							<label class="input-group-text" for='heenDatum'>
								<i class="fas fa-calendar-alt"></i>
							</label>
						</div>
						<input data-provide="datepicker" id="heenDatum" class="form-control">
					</div>
				</div>
				<div class="col">
					<label for="startTijdHeen">Start tijd: </label>
					<input type="time" id="startTijdHeen" width="276" class="form-control" id="time"/>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<label for="heenStartAdres">Start adres: </label>
					<select class="custom-select" id="heenStartAdres">
						<?php
							print $selectAdressen;
						?>
					</select>
				</div>
				<div class="col">
					<label for="heenEindeAdres">Bestemming adres: </label>
					<select class="custom-select" id="heenEindeAdres">
						<?php
							print $selectAdressen;
						?>
					</select>
				</div>
			</div>
		</div>
	</div>
</article>
<article class="mt-2" id="terug" style="display: none;">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-sm-6">
					<h5>Terug rit</h5>
				</div>
				<div class="col-sm-6 text-right">
					
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col">
					<label for="terugDatum">Datum: </label>
					<div class="input-group">
						<div class="input-group-prepend">
							<label class="input-group-text" for='terugDatum'>
								<i class="fas fa-calendar-alt"></i>
							</label>
						</div>
						<input data-provide="datepicker" id="terugDatum" class="form-control" placeholder="" disabled>
					</div>
				</div>
				<div class="col">
					<label for="startTijdTerug">Start tijd: </label>
					<input type="time" id="startTijdTerug" width="276" class="form-control" id="time"/>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<label for="terugStartAdres">Start adres: </label>
					<select class="custom-select" id="terugStartAdres">
						<?php
							print $selectAdressen;
						?>
					</select>
				</div>
				<div class="col">
					<label for="terugEindeAdres">Bestemming adres: </label>
					<select class="custom-select" id="terugEindeAdres">
						<?php
							print $selectAdressen;
						?>
					</select>
				</div>
			</div>
		</div>
	</div>
</article>
<div class="row mt-2">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-body">
				<h5>Opmerking</h5>
				<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="card">
			<div class="card-body">
				<h5>Verwachte kost</h5>
				<p>10km * 5€ = 50€</p>
				<p>
					Aantal ritten over		
				</p>
			</div>
		</div>
	</div>
</div>




<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="needs-validation" novalidate>
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Nieuw adres</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<div class="form-check">
							<label for="straat">Straat</label>
							<input type="text" class="form-control" id="straat" required>
							<div class="invalid-feedback">
								Oeps hier is iets fout!
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-check">
							<label for="huisnummer">Nummer</label>
							<input type="number" class="form-control" id="huisnummer" required>
							<div class="invalid-feedback">
								Oeps hier is iets fout!
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-check">
							<label for="gemeente">Gemeente</label>
							<input type="text" class="form-control" id="gemeente" required>
							<div class="invalid-feedback">
								Oeps hier is iets fout!
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-check">
							<label for="postcode">Postcode</label>
							<input type="number" class="form-control" id="postcode" required>
							<div class="invalid-feedback">
								Oeps hier is iets fout!
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Anuleren</button>
					<button type="button" class="btn btn-success" id="testAdres">Test adres</button>
					<button type="button" class="btn btn-primary" id="saveAdres">Opslaan</button>
				</div>
			</form>
		</div>
	</div>
</div>
	


<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
})

$('#heenTerug').click(function() {
	if (!$(this).is(':checked')) {
		$('#terug').slideUp();
	}else{
		$('#terug').slideDown();
	}
});

$('#heenDatum').change(function(){
	$('#terugDatum').val($('#heenDatum').val());
	//show amount of rits availble after this one
});

$('select').change(function() {
	$soortAdres = $(this).attr('id');
	if($(this).val() == 'nieuwAdres'){
		$('#exampleModal').modal('show');
	}
});

$('#testAdres').click(function(){
	testAdres();
});

$('#saveAdres').click(function(){
	// testAdres
	
	// ajaxrequest
	
	// get id of adres
	
	// make new adres list
	
	// fill in just created adres 
});

function testAdres(){
	console.log('test');
	
	//check if al fields are filles
	
	//check if google knows this adressen
	
	//return true or false
}

//fill in adres --> check if both adresses are filled --> calculate cost

</script>