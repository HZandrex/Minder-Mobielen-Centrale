<?php
/**
	* @file ritten.php
	*
	* vieuw waar al de ritten van een minder mobiele persoon worden opgelijst. De eerst volgende rit zal vanboven staan.
	* - krijgt een $ritten object binnen waar al de nodige info instaat
	* - maakt gebruik van een tabel om alles weer te geven
        * 
        * Gemaakt door Lorenz Cleymans en Michiel Olijslagers
*/
	//var_dump($ritten);
?>
<?php
if (!empty($ritten)){ ?>
        <div class="card">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Datum</th>
                  <th scope="col">Vertrek</th>
                  <th scope="col">Start Adres</th>
                  <th scope="col">Eind Adres</th>
                  <th scope="col">Terugrit</th>
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
                                <td><?php print date("d.m.y", strtotime($rit->rit->heenvertrek->tijd));?></td>
                                <td><?php print date("G:i", strtotime($rit->rit->heenvertrek->tijd));?></td>
                                <td><?php print $rit->rit->heenvertrek->adres->straat . " " . $rit->rit->heenvertrek->adres->huisnummer;?></td>
                                <td><?php print $rit->rit->heenaankomst->adres->straat . " " . $rit->rit->heenaankomst->adres->huisnummer;?></td>
                                <td><?php if(!empty($rit->rit->terugvertrek)){
                                                            print date("G:i", strtotime($rit->rit->terugvertrek->tijd));
                                }else{
                                                            print "N/A";
                                } ?></td>
                                <td><?php print (intval($rit->rit->prijs) + intval($rit->rit->extraKost));?>€</td>
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
                                <td><?php print anchor(array('vrijwilliger/ritten/eenRit/', $rit->id), '<i class="fab fa-leanpub fa-2x" data-toggle="tooltip" data-placement="top" title="Bekijken"></i>'); ?></td>
                            </tr>
                <?php
                        }
                    }
                ?>
              </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="col-12 justify-content-center align-self-center">
            <div class="card" style="margin-top: 20px">
                <div class="card-body">


                    <div class="row justify-content-center">
                        <p class="font-weight-bold">Er zijn geen ritten voor jou</p>
                    </div>
                </div>

            </div>
        </div>
<?php } ?>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});
</script>	