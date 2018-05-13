<?php
/**
 * @file ritten.php
 *
 * vieuw waar al de ritten van een minder mobiele persoon worden opgelijst. De eerst volgende rit zal vanboven staan.
 * - krijgt een $ritten object binnen waar al de nodige info instaat
 * - maakt gebruik van een tabel om alles weer te geven
 */
 
 // var_dump($statussen);
?>
<div class="card row mt-2">
	<div class="card-body">
		<h3>Filteren</h3>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="mindermobieleZoeken">Minder mobiele</label>
					<input type="text" class="form-control" id="mindermobieleZoeken" placeholder="Geef een naam in">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label for="statusZoeken">Status</label>
					<select class="form-control" id="statusZoeken">
						<option value="empty"><strong>Al de ritten</strong></option>
						<?php
							foreach($statussen as $status){
								print "<option value='" . $status->id . "'>" . $status->naam . "</option>";
							}
						?>	
					</select>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
if (!empty($ritten)){	
?>
	<div class="card row mt-2">
		<table class="table table-striped">
			<thead>
			<tr id="inhoud">
				<th scope="col">Datum</th>
				<th scope="col">Vertrek</th>
				<th scope="col">Voor</th>
				<th scope="col">Start Adres</th>
				<th scope="col">Eind Adres</th>
				<th scope="col">Terugrit</th>

				<th scope="col">Totaal kost</th>
				<th scope="col">Status</th>
				<th scope="col">Details</th>
			</tr>
			</thead>
			<tbody>

			<?php
			foreach($ritten as $rit){
				if(!empty($rit)){
					?>
					<tr data-s="<?php print $rit->status->id; ?>">
						<td><?php print date("d.m.y", strtotime($rit->heenvertrek->tijd));?></td>
						<td><?php print date("G:i", strtotime($rit->heenvertrek->tijd));?></td>
						<td id="mindermobiele"><?php print $rit->persoon->voornaam ." ". $rit->persoon->naam?></td>
						<td><?php print $rit->heenvertrek->adres->straat . " " . $rit->heenvertrek->adres->huisnummer;?></td>
						<td><?php print $rit->heenaankomst->adres->straat . " " . $rit->heenaankomst->adres->huisnummer;?></td>
						<td><?php if(!empty($rit->terugvertrek)){
								print date("G:i", strtotime($rit->terugvertrek->tijd));
							}else{
								print "N/A";
							} ?></td>
						<td><?php print (intval($rit->prijs) + intval($rit->extraKost));?>€</td>
						<td><?php
							if ($rit->status->id == "1"){
								print '<i class="fa fa-times fa-2x  text-danger" data-toggle="tooltip" data-placement="top" title="' . $rit->status->naam . '"></i>';
							}else if ($rit->status->id=="2"){
								print '<i class="fa fa-check fa-2x  text-success" data-toggle="tooltip" data-placement="top" title="' . $rit->status->naam . '"></i>';
							}else if ($rit->status->id =="3"){
								print '<i class="fa fa-question-circle fa-2x text-info" data-toggle="tooltip" data-placement="top" title="' . $rit->status->naam . '"></i>';
							}else if ($rit->status->id =="4"){
								print '<i class="fa fa-minus-circle fa-2x text-warning" data-toggle="tooltip" data-placement="top" title="' . $rit->status->naam . '"></i>';
							}
							?></td>
						<td><?php print anchor(array('coach/ritten/eenRit', $rit->id), '<i class="fab fa-leanpub fa-2x" data-toggle="tooltip" data-placement="top" title="Bekijken"></i>'); ?></td>
					</tr>
				<?php
				}
			}
			?>
			</tbody>
		</table>
	</div>
			
<?php
	}else { 
?>
	<div class="col-12 justify-content-center align-self-center">
		<div class="card" style="margin-top: 20px">
			<div class="card-body">
			   <div class="row justify-content-center">
				   <p class="font-weight-bold">Er zijn geen ritten voor jou</p>
			   </div>
			</div>
		</div>
	</div>
<?php 
	} 
?>
<script>
$(function() {
	$('[data-toggle="tooltip"]').tooltip()
	
	// voeg data-g atribuut toe, hier komt de naam in kleine letters in te staan zodat we hier op kunnen filteren
    $('tr').each(function(){
        $(this).attr('data-m', $(this).find("#mindermobiele").text().toLowerCase());
    })
    
	//als er iets aangepast wordt in het zoek veldje dan word er opnieuw gefilterd
	$('#mindermobieleZoeken').keyup(function(){
		groteFilter();
	});
	
	//als er iets aangepast wordt in het status veld
	$('#statusZoeken').change(function(){
		groteFilter();
	});
	
	//grote filter functie, deze gaat alles filteren
	function groteFilter(){
        var mindermobiele = $('#mindermobieleZoeken').val().toLowerCase();
		var status = $('#statusZoeken').val();
		$('tr').show();
		
		//status check
		if(status != ""){
			if(status == 'empty'){
				$('tr').show();
			}else{
				$('tr[data-s != ' + status + ']').hide();
			}
		}
		
		//minder mobiele check
		if(mindermobiele != ""){
			$('tr').not('[data-m *= ' + mindermobiele + ']').hide();
		}
		
		$('tr#inhoud').show();
	}	
});

</script>	 
