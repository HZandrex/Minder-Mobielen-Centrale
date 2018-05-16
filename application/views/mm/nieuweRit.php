<?php
	/**
	 * @file MM/nieuweRit.php
	 *
	 * View waarin de nieuwe rit pagina wordt weergegeven
	 *  - Wanneer een mindermobiele een nieuwe rit wilt aanmaken komt hij hierop uit.
	 *  - Deze pagina krijgt de variabele $adressen binnen waar al de adressen in staan die de minder mobiele ooit gebruikt heeft.
	 *
	 * Gemaakt door Michiel Olijslagers
	 */
	// var_dump($adressen);
	// var_dump($instellingen);

	$selectAdressen = '<option value="default" selected disabled>Kies een adres of voeg er een toe</option><option id="nieuwAdres" value="nieuwAdres">Nieuw adres</option>';
	if(!empty($adressen[0])){
		foreach($adressen as $adres){
			$selectAdressen .= '<option value="' . $adres->id . '">' . $adres->straat . ' ' . $adres->huisnummer . ' (' . $adres->gemeente . ')</option>';
		}
	}
	
?>
<style>
	.pac-container{
		z-index: 10000;
	}

</style>
<main>
	<div id="errorPlaats">
	
	</div>
	<?php 
		$attributes = array('name' => 'nieuweRit', 'id' => 'nieuweRit');
		echo form_open('mm/ritten/nieuweRitOpslaan', $attributes);  
	?>
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-sm-6">
						<p><i class="fas fa-shopping-cart"></i> klant: <?php print $gebruikerMM->voornaam . " " . $gebruikerMM->naam; ?></p>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="heenTerug" name="heenTerug">
							<label class="custom-control-label" for="heenTerug">Heen en terug</label>
						</div>
						<p id="credits"></p>
					</div>
					<div class="col-sm-6">
								<button type="button" class="btn btn-primary" id="opslaan"><i class="fas fa-save"></i> Opslaan</button>
						<?php
								print anchor(array('mm/ritten'), '<i class="fas fa-ban"></i> Anuleren', array('class' => 'btn btn-danger'));

						?>
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
							<p id="heenInfo"></p>
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
								<input data-provide="datepicker" id="heenDatum" class="form-control datepicker" name="heenDatum">
							</div>
						</div>
						<div class="col">
							<label for="startTijdHeen">Start tijd: </label>
							<input type="time" id="startTijdHeen" width="276" class="form-control" id="time" name="startTijdHeen"/>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="heenStartAdres">Start adres: </label>
							<select class="custom-select" id="heenStartAdres" name="heenStartAdres">
								<?php
									print $selectAdressen;
								?>
							</select>
						</div>
						<div class="col">
							<label for="heenEindeAdres">Bestemming adres: </label>
							<select class="custom-select" id="heenEindeAdres" name="heenEindeAdres">
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
							<p id="terugInfo"></p>
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
								<input data-provide="datepicker" id="terugDatum" class="form-control" name="terugDatum" disabled>
							</div>
						</div>
						<div class="col">
							<label for="startTijdTerug">Start tijd: </label>
							<input type="time" id="startTijdTerug" width="276" class="form-control" id="time" name="startTijdTerug"/>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="terugStartAdres">Start adres: </label>
							<select class="custom-select" id="terugStartAdres" name="terugStartAdres" disabled>
								<?php
									print $selectAdressen;
								?>
							</select>
						</div>
						<div class="col">
							<label for="terugEindeAdres">Bestemming adres: </label>
							<select class="custom-select" id="terugEindeAdres" name="terugEindeAdres" disabled>
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
						<textarea class="form-control" id="opmerkingenMM" name="opmerkingenMM" rows="3"></textarea>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="card">
					<div class="card-body">
						<h5>Verwachte kost</h5>
						<table id="kost"></table>
					</div>
				</div>
			</div>
		</div>
	<?php echo form_close(); ?>
</main>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-id="">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="adres" novalidate>
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Nieuw adres</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-danger" role="alert" id="errorModal" style="display: none;"></div>
					<div id="locationField">
						<div class="form-group">
							<input type="text" class="form-control" id="autocomplete" placeholder="Vul hier het adres in" onFocus="geolocate()">
						</div>
					</div>
					<div id="address">
						<div class="form-group">
							<label for="street_number">Nummer</label>
							<input type="text" class="form-control" id="street_number" disabled="true">
						</div>
						<div class="form-group">
							<label for="route">Straat</label>
							<input type="text" class="form-control" id="route" disabled="true">
						</div>
						<div class="form-group">
							<label for="locality">Gemeente</label>
							<input type="text" class="form-control" id="locality" disabled="true">
						</div>
						<div class="form-group">
							<label for="postal_code">Postcode</label>
							<input type="text" class="form-control" id="postal_code" disabled="true">
						</div>
						<div class="form-group">
							<label for="administrative_area_level_1">Staat</label>
							<input type="text" class="form-control" id="administrative_area_level_1" disabled="true">
						</div>
						<div class="form-group">
							<label for="country">Land</label>
							<input type="text" class="form-control" id="country" disabled="true">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="anuleerAdres">Anuleren</button>
					<button type="button" class="btn btn-primary" id="saveAdres">Opslaan</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Replace the value of the key parameter with your own API key. -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3Fe2FqE9k7EP-u0Q1j5vUoVhtfbWfSjU&libraries=places&callback=initAutocomplete" async defer></script>
<script>

$("#heenEindeAdres").change(function () {
	var i = $('#heenEindeAdres option:checked').val();
	$("#terugStartAdres").val(i);
});

$("#heenStartAdres").change(function () {
	var i = $('#heenStartAdres option:checked').val();
	$("#terugEindeAdres").val(i);
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip();
})

$('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
	weekStart: 1,
	language: 'nl'
});

$('#heenTerug').click(function() {
	if (!$(this).is(':checked')) {
		$('#terug').slideUp();
	}else{
		$('#terug').slideDown();
	}
});

$('#heenDatum').change(function(){
	$('#terugDatum').val($('#heenDatum').val());
	var timeStamp = $('#heenDatum').val() + ' 00:00:00';
	$.ajax(
	{
		type:"post",
		url: "<?php echo base_url(); ?>index.php/mm/ritten/berekenCredits",
		data:{ userId:'<?php echo $gebruikerMM->id; ?>', date: timeStamp},
		success:function(response)
		{
			var credits = JSON.parse(response);				
			$('#credits').html('Je hebt nog <span id="aantalCredits">' + credits + '</span> credits, deze rit kost 1 credit.');
		}
	});

});

$('select').change(function() {
	if($(this).val() == 'nieuwAdres'){
		$('#exampleModal').attr('data-id', $(this).attr('id'));
		$('#exampleModal').modal('show');
	}
});

$('#anuleerAdres').click(function(){
	$('#' + $('#exampleModal').attr('data-id')).val('default');
	$('#exampleModal').modal('hide');
	$("form#adres :input").each(function(){
		$(this).val('');
	});
	$('#errorModal').hide();
});

$("#exampleModal").on('hide.bs.modal', function () {
	$('#' + $('#exampleModal').attr('data-id')).val('default');
	$("form#adres :input").each(function(){
		$(this).val('');
	});
	$('#errorModal').hide();
});

$('#saveAdres').click(function(){
	//uitlezen adres
	var huisnummer = $('#street_number').val();
	var straat = $('#route').val();
	var gemeente = $('#locality').val();
	var postcode = $('#postal_code').val();
	
	if(huisnummer == '' || straat == '' || gemeente == '' || postcode == ''){
		errorModal('Vul een volledig adres in! huisnummer, straat, gemeente, postcode');
	}else{
		//kijk of adres al ingeladen is
		var bestaat = checkOfAdresIngeladenIs(huisnummer, straat, gemeente);
		if(bestaat != false){
			$('#exampleModal').modal('hide');
			$('#' + $('#exampleModal').attr('data-id')).val(bestaat);
			$("#terugStartAdres").val($('#heenEindeAdres option:checked').val());
			$("#terugEindeAdres").val($('#heenStartAdres option:checked').val());
		}else{
			// ajaxrequest
			$.ajax(
				{
					type:"post",
					url: "<?php echo base_url(); ?>index.php/mm/ritten/nieuwAdres",
					data:{ huisnummer:huisnummer, straat:straat, gemeente:gemeente, postcode:postcode},
					success:function(response)
					{
						// console.log(response);//Stationsstraat 177, Geel, België
						var adres = JSON.parse(response);
						//toevoegen aan adressen lijst
						$('select').each(function(){
							$(this).children().eq(1).after('<option value="' + adres.id + '">' + adres.straat + ' ' + adres.huisnummer + ' (' + adres.gemeente + ')</option>');
						});
						$('#exampleModal').modal('hide');
						console.log('test');
						$('#' + $('#exampleModal').attr('data-id')).val(adres.id);
						$("#terugStartAdres").val($('#heenEindeAdres option:checked').val());
						$("#terugEindeAdres").val($('#heenStartAdres option:checked').val());
						calulateCost();
					}
				}
			);
		}
	}
});

function errorModal(bericht){
	$('#errorModal').html(bericht);
	$('#errorModal').slideDown();
}

function checkOfAdresIngeladenIs(huisnummer, straat, gemeente){
	var result = false;
	$('select#heenStartAdres option').each(function(){
		if($(this).text() == (straat + " " + huisnummer + " (" + gemeente + ")")){
			result = $(this).val();
			return false;
		}
	});
	return result;
}

$('main input').change(function(){
	calulateCost();
});

$('main select').change(function(){
	calulateCost();
});

function calulateCost(){
	if($('#heenStartAdres').val() != null && $('#heenEindeAdres').val() != null && $('#startTijdHeen').val() != '' && $('#heenDatum').val() != ''){
		var timeStamp = $('#heenDatum').val();
		var now = new Date();
		var timeStamp = timeStamp.charAt(3) + timeStamp.charAt(4) + '/' + timeStamp.charAt(0) + timeStamp.charAt(1) + '/' + timeStamp.charAt(6) + timeStamp.charAt(7) + timeStamp.charAt(8) + timeStamp.charAt(9) + ' ' + $('#startTijdHeen').val() + ':00';
		var d = new Date(timeStamp);
		if(d > now){
			var totaalPrijs = 0;
			$.ajax(
			{
				type:"post",
				url: "<?php echo base_url(); ?>index.php/mm/ritten/berekenKost",
				data:{ startAdres:$('#heenStartAdres').val(), eindAdres:$('#heenEindeAdres').val(), timeStamp:timeStamp},
				success:function(response)
				{
					var data = JSON.parse(response);
					var heenPrijs = totaalPrijs = Math.round(parseFloat(data.distance.value) * parseFloat(data.kostPerKm.waarde) /1000).toFixed(2);
					$('#kost').html('');
					$('#kost').append('<tr id="heen"><td>Heen rit (' + data.distance.text + '): </td><td> € ' + heenPrijs + '</td></tr>');
					$('#heenInfo').text('Verwachte informatie: ' + data.distance.text + ', ' + data.duration.text);
					$('#heenInfo').attr("data-tijd", data.duration.value);
					if($('#terugStartAdres').val() != null && $('#terugEindeAdres').val() != null && $('#startTijdTerug').val() != '' && $('#terugDatum').val() != '' && $('input#heenTerug').is(':checked')){
						var timeStamp = $('#terugDatum').val();
						var timeStamp = timeStamp.charAt(3) + timeStamp.charAt(4) + '/' + timeStamp.charAt(0) + timeStamp.charAt(1) + '/' + timeStamp.charAt(6) + timeStamp.charAt(7) + timeStamp.charAt(8) + timeStamp.charAt(9) + ' ' + $('#startTijdTerug').val();
						$.ajax(
						{
							type:"post",
							url: "<?php echo base_url(); ?>index.php/mm/ritten/berekenKost",
							data:{ startAdres:$('#terugStartAdres').val(), eindAdres:$('#terugEindeAdres').val(), timeStamp:timeStamp},
							success:function(response)
							{
								var data = JSON.parse(response);
								var terugPrijs = Math.round(parseFloat(data.distance.value) * parseFloat(data.kostPerKm.waarde) /1000).toFixed(2);
								
								$('#kost').append('<tr id="terug"><td>Terug rit (' + data.distance.text + '): </td><td> € ' + terugPrijs + '</td></tr>');
								$('#kost').append('<tr id="totaalHeenTerug" style="border-top: 1px solid grey;"><td><strong>Totale prijs: </strong></td><td> € <span id="totaalPrijs">' + (parseFloat(totaalPrijs) + parseFloat(terugPrijs)) + '</span></td></tr>');
								$('#totaalHeen').html('');
								$('#terugInfo').text('Verwachte informatie: ' + data.distance.text + ', ' + data.duration.text);
							}
						});
					}else{
						$('#kost').append('<tr style="border-top: 1px solid grey;" id="totaalHeen"><td><strong>Totale prijs: </strong></td><td> € <span id="totaalPrijs">' + totaalPrijs + '</span></td></tr>');
					}
				}
			});
		}
	}else{
		$('#kost').html('');
		$('#terugInfo').html('');
		$('#heenInfo').html('');
	}
}

//autocomplete van google
var placeSearch, autocomplete;
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

function initAutocomplete() {
  // Create the autocomplete object, restricting the search to geographical
  // location types.
  autocomplete = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
      {types: ['geocode']});

  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

  for (var component in componentForm) {
    document.getElementById(component).value = '';
   // document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      autocomplete.setBounds(circle.getBounds());
    });
  }
}

$('#opslaan').click(function(){
	$('#errorPlaats').html('');
	var error = false;
	
	//heen datum test, ingevuld, in de toekomst
	if($('#heenDatum').val() == ''){
		errorPlaats('Vul een geldige datum in.');
		error = true;
	}else{
		var timeStamp = $('#heenDatum').val();
		var now = new Date() ;			
		var timeStamp = timeStamp.charAt(3) + timeStamp.charAt(4) + '/' + timeStamp.charAt(0) + timeStamp.charAt(1) + '/' + timeStamp.charAt(6) + timeStamp.charAt(7) + timeStamp.charAt(8) + timeStamp.charAt(9) + ' 00:00:00';
		var d = new Date(timeStamp);
		if(d <= now){
			errorPlaats('Vul een datum in die in de toekomst ligt.');
			error = true;
		}else{
			now.setDate(now.getDate() + <?php print $instellingen->waarde; ?>); 
			if(d <= now){
				errorPlaats('Je kan maar <?php print $instellingen->waarde; ?> dagen op voorhand een rit aanvragen.');
				error = true;
			}else{
				//check aantal credits
				if(!$('span#aantalCredits').length){
					errorPlaats('Oops iets ging er mis. Je kan best even geduld hebben, anders kan je opnieuw proberen. Als je deze error blijft krijgen neem dan contact op met de admin!');
					error = true;
				}else{
					if($('span#aantalCredits').text() == 0){
						errorPlaats('Je hebt niet meer voldoende credits voor deze week.');
						error = true;
					}
				}
			}
		}
	}
	
	//start tijd, ingevuld
	if($('#startTijdHeen').val() == ''){
		errorPlaats('Vul een geldige startTijd in.');
		error = true;
	}
	
	//heen start adres ingevuld
	if($('#heenStartAdres').val() == null){
		errorPlaats('Vul een geldig heen start adres in.');
		error = true;
	}
	
	//heen eind adres ingevuld
	if($('#heenEindeAdres').val() == null){
		errorPlaats('Vul een geldig heen start adres in.');
		error = true;
	}
	
	//als terug rit aangevinkt is
	if($('input#heenTerug').is(':checked')){
		//terug datum test, ingevuld, in de toekomst
		if($('#terugDatum').val() == ''){
			errorPlaats('Vul een geldige datum in.');
			error = true;
		}else{
			var timeStamp = $('#terugDatum').val();
			var now = new Date();
			var timeStamp = timeStamp.charAt(3) + timeStamp.charAt(4) + '/' + timeStamp.charAt(0) + timeStamp.charAt(1) + '/' + timeStamp.charAt(6) + timeStamp.charAt(7) + timeStamp.charAt(8) + timeStamp.charAt(9) + ' 00:00:00';
			var d = new Date(timeStamp);
			if(d <= now){
				errorPlaats('Vul een datum in die in de toekomst ligt.');
				error = true;
			}
		}
		
		//start tijd, ingevuld
		if($('#startTijdTerug').val() == ''){
			errorPlaats('Vul een geldige startTijd in voor de terug rit.');
			error = true;
		}
		
		//terug start adres ingevuld
		if($('#terugStartAdres').val() == null){
			errorPlaats('Vul een geldig terug start adres in.');
			error = true;
		}
		
		//terug eind adres ingevuld
		if($('#terugEindeAdres').val() == null){
			errorPlaats('Vul een geldig terug start adres in.');
			error = true;
		}
		
		var d = new Date();
		var theDate = d.getFullYear() + '-' + ( d.getMonth() + 1 ) + '-' + d.getDate();
		var heenTijd = new Date( Date.parse( theDate + " " + $('#startTijdHeen').val() ) + $('#heenInfo').attr("data-tijd")*1000 );
		var terugTijd = new Date( Date.parse( theDate + " " + $('#startTijdTerug').val() ));
		
		if(terugTijd < heenTijd){
			errorPlaats('Vul een start tijd in voor de terugrit die later is dan de heen rit.');
			error = true;
		}
	}
	
	if(!error){
		//check verwachte kost
		if(!$('span#totaalPrijs').length){
			errorPlaats('Oops iets ging er mis. Je kan best even geduld hebben, anders kan je opnieuw proberen. Als je deze error blijft krijgen neem dan contact op met de admin!');
			error = true;
		}else{
			addData('kost', $('span#totaalPrijs').text());
		}
	}
	
	if(!error){
		// console.log('submit');
		addData('userId', '<?php print $gebruikerMM->id; ?>');
		$('#terugStartAdres').prop('disabled', false);
		$('#terugEindeAdres').prop('disabled', false);
		$('#terugDatum').prop('disabled', false);
		$( "#nieuweRit" ).submit();
	}
	
});

function errorPlaats(bericht){
	$('#errorPlaats').append('<div class="alert alert-danger" role="alert" id="errorMain">' + bericht + '</div>');
}

function addData(dataNaam, data){
	var input = $("<input>").attr("type", "hidden").attr("name", dataNaam).val(data);
	$('#nieuweRit').append($(input));
}
</script>