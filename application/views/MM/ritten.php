<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Datum</th>
      <th scope="col">Vertrek</th>
      <th scope="col">Start Adres</th>
	  <th scope="col">Eind Adres</th>
	  <th scope="col">Terugrit</th>
	  <th scope="col">Afstand prijs</th>
	  <th scope="col">Extra kost</th>
	  <th scope="col">Totaal kost</th>
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
					<td><?php print $rit->heenvertrek->adres->straat . " " . $rit->heenvertrek->adres->huisnummer;?></td>
					<td><?php print $rit->heenaankomst->adres->straat . " " . $rit->heenaankomst->adres->huisnummer;?></td>
					<td><?php if(!empty($rit->terugvertrek)){
						print date("G:i", strtotime($rit->terugvertrek->tijd));
					}else{
						print "N/A";
					} ?></td>
					<td><?php print $rit->prijs;?>€</td>
					<td><?php 
						if(!empty($rit->extraKost)){
							print $rit->extraKost . "€";
						}?>
					</td>
					<td><?php print (intval($rit->prijs) + intval($rit->extraKost));?>€</td>
					<td><?php print $rit->status->status->naam ?></td>
					<td><?php print anchor('url', '<i class="fa fa-eye fa-2x"></i>'); ?></td>
				</tr>
	<?php
			}
		}
	
	?>
  </tbody>
</table>

<?php



?>