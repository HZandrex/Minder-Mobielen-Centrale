<?php
/**
	* @file rit.php
	*
	* vieuw waar er 1 bepaalde rit getoond in detail getoond wordt, hier kan de rit ook geanuleerd of aangepast worden.
	* - krijgt een $rit object binnen
*/
        //var_dump($rit);
        $attributen = array('name' => 'mijnFormulier', 'class' => 'form-horizontal');
        echo form_open('vrijwilliger/ritten/update/'.$rit->id, $attributen);
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="..">Overzicht ritten</a></li>
    <li class="breadcrumb-item active" aria-current="page">Rit wijzigen</li>
  </ol>
</nav>
<div class="row">
	<div class="col-sm-12">
            <p>
		<?php
                    echo '<button class="btn btn-primary" name="statusId" data-toggle="tooltip" data-placement="top" title="Klik hier om de ritwijzigingen op te slaan" type="submit"><i class="fas fa-save"></i> Opslaan</button>';
                    echo anchor("vrijwilliger/ritten/eenRit/".$rit->id, '<i class="fas fa-long-arrow-alt-left"></i> Terug', 'class="btn btn-primary float-right", data-toggle="tooltip", data-placement="top", title="Klik hier om terug te gaan naar de vorige pagina"');
                ?>
            </p>
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
					if(!empty($rit->vrijwilliger)){
						print $rit->vrijwilliger->vrijwilliger->voornaam . " " . $rit->vrijwilliger->vrijwilliger->naam; 
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
					<tr>
						<td>Extra kost: </td>
						<td>
                                                    <div class="row">
                                                        <div class="col-2">€</div>
                                                        <?php if(!empty($rit->rit->extraKost))
                                                            print '<input type="number" class="form-control input-sm col-10" name="extraKost" value="'.$rit->rit->extraKost.'"/>';
                                                        else
                                                            print '<input type="number" class="form-control input-sm col-8" name="extraKost" value="0"/>'; ?>
                                                    </div>
                                                </td>
					</tr>
					
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
                                    <p><?php print date('D, j M' , strtotime($rit->rit->heenvertrek->tijd)); ?></p>
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
						
							$date = new DateTime($rit->rit->heenvertrek->tijd);	
							$date->add(DateInterval::createFromDateString($rit->rit->heen->duration->value .' seconds')); 
							echo $date->format('H:i');
							
						?>
					</p>
					<p data-toggle="tooltip" data-placement="top" title="Aankomst adres"><i class="fas fa-flag-checkered"></i> <?php print $rit->rit->heenaankomst->adres->straat . " " . $rit->rit->heenaankomst->adres->huisnummer; ?></p>
				</div>
				<div class="col-sm-2">
					<p data-toggle="tooltip" data-placement="top" title="Verwachte reistijd">
						<i class="fas fa-hourglass-half"></i> <?php print $rit->rit->heen->duration->text; ?>
					</p>
					<p data-toggle="tooltip" data-placement="top" title="Verwachte afstand">
						<i class="fas fa-road"></i> <?php print $rit->rit->heen->distance->text; ?>
					</p>
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
					<p><?php print date('D, j M' , strtotime($rit->rit->terugvertrek->tijd)); ?></p>
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
						
							$date = new DateTime($rit->rit->terugvertrek->tijd);	
							$date->add(DateInterval::createFromDateString($rit->rit->terug->duration->value .' seconds')); 
							echo $date->format('H:i');
							
						?>
					</p>
					<p data-toggle="tooltip" data-placement="top" title="Aankomst adres"><i class="fas fa-flag-checkered"></i> <?php print $rit->rit->terugaankomst->adres->straat . " " . $rit->rit->terugaankomst->adres->huisnummer; ?></p>
				</div>
				<div class="col-sm-2">
					<p data-toggle="tooltip" data-placement="top" title="Verwachte reistijd">
						<i class="fas fa-hourglass-half"></i> <?php print $rit->rit->terug->duration->text; ?>
					</p>
					<p data-toggle="tooltip" data-placement="top" title="Verwachte afstand">
						<i class="fas fa-road"></i></i> <?php print $rit->rit->terug->distance->text; ?>
					</p>
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
                            <div class="form-group">
                                <h5>Opmerking Chauffeur</h5>
                                <?php if($rit->status->id == 2 || $rit->status->id == 3){ ?>
                                    <textarea rows="2" class="form-control" name="opmerkingVrijwilliger"><?php print $rit->rit->opmerkingVrijwilliger; ?></textarea>
                                <?php } else { ?>
                                <p><?php print $rit->rit->opmerkingVrijwilliger; ?></p>
                                <?php } ?>
                            </div>
			</div>
		</div>
	</div>
</div>
<?php echo form_close(); ?>