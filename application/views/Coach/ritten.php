<?php
/**
 * @file ritten.php
 *
 * vieuw waar al de ritten van een minder mobiele persoon worden opgelijst. De eerst volgende rit zal vanboven staan.
 * - krijgt een $ritten object binnen waar al de nodige info instaat
 * - maakt gebruik van een tabel om alles weer te geven
 */
var_dump($ritten[0]);
?>
<div class="card">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Datum</th>
            <th scope="col">Vertrek</th>
            <th scope="col">Voor</th>
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
                    <td><?php print $rit->persoon->voornaam ." ". $rit->persoon->naam?></td>
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
                    <td><?php
                        if ($rit->status->status->id == "1"){
                            print '<i class="fa fa-times fa-2x  text-danger"></i>';
                        }else if ($rit->status->status->id=="2"){
                            print '<i class="fa fa-check fa-2x  text-success"></i>';
                        }else if ($rit->status->status->id =="3"){
                            print '<i class="fa fa-question-circle fa-2x text-info"></i>';
                        }else if ($rit->status->status->id =="4"){
                            print '<i class="fa fa-minus-circle fa-2x text-warning"></i>';
                        }
                        ?></td>
                    <td><?php print anchor(array('MM/ritten/eenRit', $rit->id), '<i class="fa fa-eye fa-2x"></i>'); ?></td>
                </tr>
                <?php
            }
        }

        ?>
        </tbody>
    </table>
</div>