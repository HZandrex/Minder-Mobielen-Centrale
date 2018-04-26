<?php
/**
	* @file rit.php
	*
	* vieuw waar er 1 bepaalde rit getoond in detail getoond wordt, hier kan de rit ook geanuleerd of aangepast worden.
	* - krijgt een $rit object binnen
*/
        //var_dump($rit);
		setlocale(LC_TIME, array('.UTF-8','nld_nld@euro','nld_nld','dutch'));
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="..">Overzicht ritten</a></li>
    <li class="breadcrumb-item active" aria-current="page">Rit bekijken</li>
  </ol>
</nav>
<div class="row">
    <div class="col-sm-12">
        <?php
            echo form_open('vrijwilliger/ritten/statusAanpassen/'. $rit->rit->id);
            echo '<p>';
            echo '<div class="btn-group">';
            if($rit->status->id == 2){
                echo anchor(array('vrijwilliger/ritten/wijzigen', $rit->rit->id), '<i class="fas fa-pen-square"></i> Wijzigen', 'class="btn btn-primary", data-toggle="tooltip", title="Klik hier om deze rit aan te passen"');
                echo '<button class="btn btn-danger" name="statusId" data-toggle="tooltip" data-placement="top" title="Klik hier om de rit af te zeggen" type="submit" value="1"><i class="fas fa-ban"></i> Annuleren</button>';
            }              
            if($rit->status->id == 3 ){
                echo '<button class="btn btn-success" name="statusId" data-toggle="tooltip" data-placement="top" title="Klik hier om de rit goed te keuren" type="submit" value="2"><i class="fas fa-check"></i> Goedkeuren</button>';
                echo '<button class="btn btn-danger" name="statusId" data-toggle="tooltip" type="submit" data-placement="top" title="Klik hier om de rit af te zeggen" value="1"><i class="fas fa-ban"></i> Weigeren</button>';
            }
            echo '</div>';
            echo anchor("vrijwilliger/ritten/", '<i class="fas fa-long-arrow-alt-left"></i> Terug', 'class="btn btn-primary float-right", data-toggle="tooltip", data-placement="top", title="Klik hier om terug te gaan naar de vorige pagina"');
            echo '</p>';
            echo form_close(); 
        ?>
    </div>  
</div>
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-sm-6">
				<p><i class="fas fa-shopping-cart"></i> klant: <?php print $rit->rit->MM->voornaam . " " . $rit->rit->MM->naam; ?></p>
				<p>
				<i class="fas fa-car"></i> chauffeur: 
				<?php 
					if(!empty($rit->rit->vrijwilliger)){
						print $rit->rit->vrijwilliger->vrijwilliger->voornaam . " " . $rit->rit->vrijwilliger->vrijwilliger->naam; 
					}else{
						print "Nog geen vrijwilliger gevonden";
					}
				?>
				</p>
				<p>
					<?php
						switch($rit->status->id){
							case 1:
								print '<i class="fas fa-circle text-danger"></i> status: ' . $rit->status->naam;
								break;
							case 2:
								print '<i class="fas fa-circle text-success"></i> status: ' . $rit->status->naam;
								break;
							case 3:
								print '<i class="fas fa-circle text-primary"></i> status: ' . $rit->status->naam;
								break;
							case 4:
								print '<i class="fas fa-circle text-warning"></i> status: ' . $rit->status->naam;
								break;
							default:
								print "error geen duidelijke status gevonden!";
								break;
						}
					
					?>
				</p>
			</div>
			<div class="col-sm-6">
				<table class="mt-3">
					<tr>
						<td>Km kost: </td>
						<td> € <?php print $rit->rit->prijs; ?></td>
						
					</tr>
					<?php if(!(empty($rit->rit->extraKost) || $rit->rit->extraKost == 0)){ ?>
					<tr>
						<td>Extra kost: </td>
						<td> € <?php print $rit->rit->extraKost; ?></td>
					</tr>
					<?php } ?>
					<tr style="border-top: 1px solid grey;">
						<td><strong>Totale prijs: </strong></td>
						<td> € <?php print ($rit->rit->prijs + $rit->rit->extraKost); ?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<article class="mt-2">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-sm-6">
						<h5>Heen rit</h5>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-sm-2">
					<p><?php echo strftime("%a, %d %b", strtotime($rit->rit->heenvertrek->tijd)); ?></p>
					<p data-toggle="tooltip" data-placement="top" title="Toon route">
						<button onclick="ToonVerbergKaart('#mapHeen')" class="btn-primary">
							<i class=" fas fa-map"></i> Kaart
						</button>
					</p>
				</div>
				<div class="col-sm-3">
					<p data-toggle="tooltip" data-placement="top" title="Vertrek tijd"><i class="far fa-clock"></i> <?php print date('G:i' , strtotime($rit->rit->heenvertrek->tijd)); ?></p>
					<p data-toggle="tooltip" data-placement="top" title="Vertrek adres"><i class="fas fa-map-marker"></i> <?php print $rit->rit->heenvertrek->adres->straat . " " . $rit->rit->heenvertrek->adres->huisnummer; ?> </p>
				</div>
				<div class="col-sm-2">
					<div class="mt-4"><i class="far fa-arrow-alt-circle-right"></i>-------<i class="far fa-arrow-alt-circle-right"></i></div>
				</div>
				<div class="col-sm-3">
					<p class="text-left" data-toggle="tooltip" data-placement="top" title="Verwachte aankomst tijd"><i class="far fa-clock"></i>
						<?php 
						if(!empty($rit->rit->heenvertrek->tijd)){
								$date = new DateTime($rit->rit->heenvertrek->tijd);	
								$date->add(DateInterval::createFromDateString($rit->rit->heen->duration->value .' seconds')); 
								echo $date->format('H:i');
							}
						?>
					</p>
					<p data-toggle="tooltip" data-placement="top" title="Aankomst adres"><i class="fas fa-flag-checkered"></i> <?php print $rit->rit->heenaankomst->adres->straat . " " . $rit->rit->heenaankomst->adres->huisnummer; ?></p>
				</div>
				<div class="col-sm-2">
					<p data-toggle="tooltip" data-placement="top" title="Verwachte reistijd">
						<i class="fas fa-hourglass-half"></i> 
						<?php 
							if(!empty($rit->rit->heen->duration->text)){
								$uur = floor($rit->rit->heen->duration->value / 3600);
								$mins = floor($rit->rit->heen->duration->value / 60 % 60);
								$secs = floor($rit->rit->heen->duration->value % 60);
								$timeFormat = sprintf('%02d:%02d:%02d', $uur, $mins, $secs);
								if($uur > 0){
									print $uur . "uur " . $mins . ' min';
								}else if($mins > 0){
									print $mins+1 . ' min';
								}
							}
						?>
					</p>
					<p data-toggle="tooltip" data-placement="top" title="Verwachte afstand">
						<i class="fas fa-road"></i> 
						<?php
							if(!empty($rit->rit->heen->distance->text)){
								print $rit->rit->heen->distance->text;
							}
						?>
					</p>
				</div>
				<div class="col-12">
					<div style="height : 300px" id="mapHeen"></div>
				</div>
			</div>
		</div>
	</div>
</article>
<?php if(!empty($rit->rit->terugvertrek)){ ?>
<article class="mt-2">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-sm-6">
					<h5>Terug rit</h5>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-sm-2">
					<p><?php echo strftime("%a, %d %b", strtotime($rit->rit->terugvertrek->tijd)); ?></p>
					<p data-toggle="tooltip" data-placement="top" title="Toon route">
						<button onclick="ToonVerbergKaart('#mapTerug')" class="btn-primary">
							<i class=" fas fa-map"></i> Kaart
						</button>
					</p>
				</div>
				<div class="col-sm-3">
					<p data-toggle="tooltip" data-placement="top" title="Vertrek tijd"><i class="far fa-clock"></i> <?php print date('G:i' , strtotime($rit->rit->terugvertrek->tijd)); ?></p>
					<p data-toggle="tooltip" data-placement="top" title="Vertrek adres"><i class="fas fa-map-marker"></i> <?php print $rit->rit->terugvertrek->adres->straat . " " . $rit->rit->terugvertrek->adres->huisnummer; ?></p>
				</div>
				<div class="col-sm-2">
					<div class="mt-4"><i class="far fa-arrow-alt-circle-right"></i>-------<i class="far fa-arrow-alt-circle-right"></i></div>
				</div>
				<div class="col-sm-3">
					<p class="text-left" data-toggle="tooltip" data-placement="top" title="Verwachte aankomst tijd"><i class="far fa-clock"></i>
						<?php 
							if(!empty($rit->rit->terugvertrek->tijd)){
								$date = new DateTime($rit->rit->terugvertrek->tijd);	
								$date->add(DateInterval::createFromDateString($rit->rit->terug->duration->value .' seconds')); 
								echo $date->format('H:i');
							}
							
						?>
					</p>
					<p data-toggle="tooltip" data-placement="top" title="Aankomst adres"><i class="fas fa-flag-checkered"></i> <?php print $rit->rit->terugaankomst->adres->straat . " " . $rit->rit->terugaankomst->adres->huisnummer; ?></p>
				</div>
				<div class="col-sm-2">
					<p data-toggle="tooltip" data-placement="top" title="Verwachte reistijd">
						<i class="fas fa-hourglass-half"></i> 
						<?php
							if(!empty($rit->rit->terug->duration->text)){
								$uur = floor($rit->rit->terug->duration->value / 3600);
								$mins = floor($rit->rit->terug->duration->value / 60 % 60);
								$secs = floor($rit->rit->terug->duration->value % 60);
								$timeFormat = sprintf('%02d:%02d:%02d', $uur, $mins, $secs);
								if($uur > 0){
									print $uur . "uur " . $mins . ' min';
								}else if($mins > 0){
									print $mins+1 . ' min';
								}
							}
						?>
					</p>
					<p data-toggle="tooltip" data-placement="top" title="Verwachte afstand">
						<i class="fas fa-road"></i></i> 
						<?php 
							if(!empty($rit->rit->terug->distance->text)){
								print $rit->rit->terug->distance->text;
							}
							 
						?>
					</p>
				</div>
				<div class="col-12">
					<div style="height : 300px;" id="mapTerug"></div>
				</div>
			</div>
		</div>
	</div>
</article>
<?php } ?>
<div class="row mt-2">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-body">
				<h5>Opmerking Klant</h5>
				<p><?php print $rit->rit->opmerkingKlant; ?></p>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="card">
			<div class="card-body">
				<h5>Opmerking Chauffeur</h5>
				<p><?php print $rit->rit->opmerkingVrijwilliger; ?></p>
			</div>
		</div>
	</div>
</div>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABTgvmJaS7yxD1zp9NWJE4Zlg-MIsQTuI&callback=initMaps"> </script>
<script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip();
    });
    //Verberg kaarten
    //$("#mapHeen").add($("#mapTerug").css("display", "none");
    //Toon/verberg kaarten
    function ToonVerbergKaart(content){
        $(content).slideToggle("slow");
    }
    
    //Toon heen route op google maps
    function initMaps() {
        var pointA = '<?php echo $rit->rit->heenvertrek->adres->straat."+".$rit->rit->heenvertrek->adres->huisnummer."+".$rit->rit->heenvertrek->adres->gemeente;?>',
          pointB = '<?php echo $rit->rit->heenaankomst->adres->straat."+".$rit->rit->heenaankomst->adres->huisnummer."+".$rit->rit->heenaankomst->adres->gemeente;?>',
          myOptions = {
            zoom: 7,
            disableDefaultUI: true
          },
          map = new google.maps.Map(document.getElementById('mapHeen'), myOptions),
          // Instantiate a directions service.
          directionsService = new google.maps.DirectionsService,
          directionsDisplay = new google.maps.DirectionsRenderer({
            map: map
          }),
          markerA = new google.maps.Marker({
            address: pointA,
            title: "point A",
            label: "A",
            map: map
          }),
          markerB = new google.maps.Marker({
            address: pointB,
            title: "point B",
            label: "B",
            map: map
        });
        calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB);
        
        //Toon terug route op google maps
        <?php if(!empty($rit->rit->terugvertrek)){ ?>
        var pointA = '<?php echo $rit->rit->terugvertrek->adres->straat."+".$rit->rit->terugvertrek->adres->huisnummer."+".$rit->rit->terugvertrek->adres->gemeente;?>',
            pointB = '<?php echo $rit->rit->terugaankomst->adres->straat."+".$rit->rit->terugaankomst->adres->huisnummer."+".$rit->rit->terugaankomst->adres->gemeente;?>',
          myOptions = {
            zoom: 7,
            disableDefaultUI: true
          },
          map = new google.maps.Map(document.getElementById('mapTerug'), myOptions),
          // Instantiate a directions service.
          directionsService = new google.maps.DirectionsService,
          directionsDisplay = new google.maps.DirectionsRenderer({
            map: map
          }),
          markerA = new google.maps.Marker({
            address: pointA,
            title: "point A",
            label: "A",
            map: map
          }),
          markerB = new google.maps.Marker({
            address: pointB,
            title: "point B",
            label: "B",
            map: map
        });
        calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB);
        <?php } ?>
    }

    function calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB) {
        directionsService.route({
          origin: pointA,
          destination: pointB,
          travelMode: google.maps.TravelMode.DRIVING
        }, function(response, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
    }
</script>