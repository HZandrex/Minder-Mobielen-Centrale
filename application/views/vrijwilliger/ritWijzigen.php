<?php
/**
	* @file rit.php
	*
	* vieuw waar er 1 bepaalde rit getoond in detail getoond wordt, hier kan de rit ook geanuleerd of aangepast worden.
	* - krijgt een $rit object binnen
*/
        //var_dump($rit);
        $attributen = array('name' => 'mijnFormulier', 'class' => 'form-horizontal');
        echo form_open('admin/webinfo/wijzig', $attributen);
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
                    echo form_submit('knop', 'Opslaan', 'class="btn btn-primary"');
                    echo anchor(array('vrijwilliger/ritten/eenrit', $rit->id), "Terug", 'class="btn btn-primary float-right"');
                ?>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-sm-6">
				<p><i class="fas fa-shopping-cart"></i> klant: <?php print $rit->MM->voornaam . " " . $rit->MM->naam; ?></p>
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
						<td> € <?php print $rit->prijs; ?></td>
						
					</tr>
					<tr>
						<td>Extra kost: </td>
						<td>
                                                    <div class="row">
                                                        <div class="col-2">€</div>
                                                        <?php if(!empty($rit->extraKost))
                                                            print '<input type="number" class="form-control input-sm col-10" name="extraKost" value="'.$rit->extraKost.'"/>';
                                                        else
                                                            print '<input type="number" class="form-control input-sm col-8" name="extraKost" value="0"/>'; ?>
                                                    </div>
                                                </td>
					</tr>
					
					<tr style="border-top: 1px solid grey;">
						<td><strong>Totale prijs: </strong></td>
						<td> € <?php print ($rit->prijs + $rit->extraKost); ?></td>
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
                                    <p><?php print date('D, j M' , strtotime($rit->heenvertrek->tijd)); ?></p>
				</div>
				<div class="col-sm-3">
					<p data-toggle="tooltip" data-placement="top" title="Vertrek tijd"><i class="far fa-clock"></i> <?php print date('G:i' , strtotime($rit->heenvertrek->tijd)); ?></p>
					<p data-toggle="tooltip" data-placement="top" title="Vertrek adres"><i class="fas fa-map-marker"></i> <?php print $rit->heenvertrek->adres->straat . " " . $rit->heenvertrek->adres->huisnummer; ?> </p>
				</div>
				<div class="col-sm-2">
					<div class="mt-4"><i class="far fa-arrow-alt-circle-right"></i>-------<i class="far fa-arrow-alt-circle-right"></i></div>
				</div>
				<div class="col-sm-3">
					<p class="text-left" data-toggle="tooltip" data-placement="top" title="Verwachte aankomst tijd"><i class="far fa-clock"></i>
						<?php 
						
							$date = new DateTime($rit->heenvertrek->tijd);	
							$date->add(DateInterval::createFromDateString($rit->heen->duration->value .' seconds')); 
							echo $date->format('H:i');
							
						?>
					</p>
					<p data-toggle="tooltip" data-placement="top" title="Aankomst adres"><i class="fas fa-flag-checkered"></i> <?php print $rit->heenaankomst->adres->straat . " " . $rit->heenaankomst->adres->huisnummer; ?></p>
				</div>
				<div class="col-sm-2">
					<p data-toggle="tooltip" data-placement="top" title="Verwachte reistijd">
						<i class="fas fa-hourglass-half"></i> <?php print $rit->heen->duration->text; ?>
					</p>
					<p data-toggle="tooltip" data-placement="top" title="Verwachte afstand">
						<i class="fas fa-road"></i> <?php print $rit->heen->distance->text; ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</article>
<?php if(!empty($rit->terugvertrek)){ ?>
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
					<p><?php print date('D, j M' , strtotime($rit->terugvertrek->tijd)); ?></p>
				</div>
				<div class="col-sm-3">
					<p data-toggle="tooltip" data-placement="top" title="Vertrek tijd"><i class="far fa-clock"></i> <?php print date('G:i' , strtotime($rit->terugvertrek->tijd)); ?></p>
					<p data-toggle="tooltip" data-placement="top" title="Vertrek adres"><i class="fas fa-map-marker"></i> <?php print $rit->terugvertrek->adres->straat . " " . $rit->terugvertrek->adres->huisnummer; ?></p>
				</div>
				<div class="col-sm-2">
					<div class="mt-4"><i class="far fa-arrow-alt-circle-right"></i>-------<i class="far fa-arrow-alt-circle-right"></i></div>
				</div>
				<div class="col-sm-3">
					<p class="text-left" data-toggle="tooltip" data-placement="top" title="Verwachte aankomst tijd"><i class="far fa-clock"></i>
						<?php 
						
							$date = new DateTime($rit->terugvertrek->tijd);	
							$date->add(DateInterval::createFromDateString($rit->terug->duration->value .' seconds')); 
							echo $date->format('H:i');
							
						?>
					</p>
					<p data-toggle="tooltip" data-placement="top" title="Aankomst adres"><i class="fas fa-flag-checkered"></i> <?php print $rit->terugaankomst->adres->straat . " " . $rit->terugaankomst->adres->huisnummer; ?></p>
				</div>
				<div class="col-sm-2">
					<p data-toggle="tooltip" data-placement="top" title="Verwachte reistijd">
						<i class="fas fa-hourglass-half"></i> <?php print $rit->terug->duration->text; ?>
					</p>
					<p data-toggle="tooltip" data-placement="top" title="Verwachte afstand">
						<i class="fas fa-road"></i></i> <?php print $rit->terug->distance->text; ?>
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
				<p><?php print $rit->opmerkingKlant; ?></p>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="card">
			<div class="card-body">
                            <div class="form-group">
                                <h5>Opmerking Chauffeur</h5>
                                <?php if($rit->status->id == 2 || $rit->status->id == 3){ ?>
                                    <textarea rows="8" class="form-control" name="openingsurenOpmerking"><?php print $rit->opmerkingVrijwilliger; ?></textarea>
                                <?php } else { ?>
                                <p><?php print $rit->opmerkingVrijwilliger; ?></p>
                                <?php } ?>
                            </div>
			</div>
		</div>
	</div>
</div>
<?php echo form_close(); ?>