<?php
/**
	* @file rittenOverzicht.php
	*
	* vieuw waar al de ritten van een minder mobiele persoon worden opgelijst. De eerst volgende rit zal vanboven staan.
	* - krijgt een $ritten object binnen waar al de nodige info instaat
	* - maakt gebruik van een tabel om alles weer te geven
*/
	// var_dump($ritten);
?>
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-sm-6">
				<p>
					Naam minder mobiele filter
				</p>
				<p>
					Naam vrijwilliger filter
				</p>
			</div>
			<div class="col-sm-6">
				Status
			</div>
		</div>
	</div>
</div>
<div class="card">
	<table class="table table-striped">
	  <thead>
		<tr>
		  <th scope="col">Datum</th>
		  <th scope="col">Vertrek uur</th>
		  <th scope="col">Minder mobiele</th>
		  <th scope="col">Vrijwilliger</th>
		  <th scope="col">Status</th>
		  <th scope="col"></th>
		</tr>
	  </thead>
	  <tbody>
		<?php
			foreach($ritten as $rit){
				if(!empty($rit)){
		?>
					<tr>
						<td><?php print date("d.m.y", strtotime($rit->heenvertrek->tijd));?></td>
						<td><?php print date("G:i", strtotime($rit->heenvertrek->tijd));?></td>
						<td><?php print $rit->MM->voornaam . " " . $rit->MM->naam;?></td>
						<td><?php if(!empty($rit->vrijwilliger->vrijwilliger->voornaam)){
							print $rit->vrijwilliger->vrijwilliger->voornaam . " " . $rit->vrijwilliger->vrijwilliger->naam;
						}else{
							print "N/A";
						} ?></td>
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
						<td><?php print anchor(array('medewerker/rittenAfhandelen/eenRit', $rit->id), '<i class="fa fa-eye fa-2x" data-toggle="tooltip" data-placement="top" title="Bekijken"></i>'); ?></td>
					</tr>
		<?php
				}
			}
		?>
	  </tbody>
	</table>
</div>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>	