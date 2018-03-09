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
	var_dump($ritten);
		foreach($ritten as $rit){
	?>
		<tr>
			<td>Datum</td>
			<td>Vertrek</td>
			<td>Start Adres</td>
			<td>Eind Adres</td>
			<td>Terugrit</td>
			<td><?php print $rit->prijs;?>€</td>
			<td><?php 
				if(!empty($rit->extraKost)){
					print $rit->extraKost . "€";
				}?>
			</td>
			<td><?php print (intval($rit->prijs) + intval($rit->extraKost));?>€</td>
			<td>Status</td>
			<td></td>
		</tr>
	<?php
		}
	
	?>
  </tbody>
</table>

<?php



?>