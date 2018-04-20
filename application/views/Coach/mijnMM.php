<?php
    ?>

<div>
	
	<div class="row">
		<div class="panel panel-primary col-lg-12">
			<div class="panel-heading>Zoeken</div>
			<div class="panel-body">
				<p>
					<div class="form-group row col-lg-4">
						<label class="col-lg-4" for="naam">Zoeken:</label>
						<?php echo form_input(array('name' => 'naam', 'id' => 'naam', 'class' => 'form-control col-lg-8')) ?>
					</div>
				</p>
			</div>
		</div>
		<div class="col-lg-12">
		<select class="col-lg-4 form-control" name="cars" size="15">
		<?php foreach($minderMobielen as $minderMobiel){?>
			<option value="<?php echo $minderMobiel->id?>"><?php echo $minderMobiel->voornaam." ".$minderMobiel->naam ?></option
		</select>
		<?php } ?>
		</div>
	</div>
</div>

<?php  ?>