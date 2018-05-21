<?php
    /**
     * @file gebruiker/homePagina.php
     * 
     * View waarin de beginpagina wordt weergegeven (info, contact gegevens, ...)
     * - krijgt een $webinfo-array binnen
     *
     * Gemaakt door Nico Claes
     */
    var_dump($webinfo);
?>

<div class="row">
    <div class="col-12">
        <?php
        echo "<h4>" . $webinfo["homeTitel"] . "</h4>";
        echo "<p>" . $webinfo["homeTekst"] . "</p>";
        ?>
    </div>
    <div class="col-12 col-sm-6">
        <h4>Contact</h4>
        <table>
            <?php
            echo "<tr>";
            echo "<td>Telefoon:</td>";
            echo "<td>" . $webinfo["contactTelefoon"] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Mail:</td>";
            echo "<td>" . $webinfo["contactMail"] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Fax:</td>";
            echo "<td>" . $webinfo["contactFax"] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Adres:</td>";
            echo "<td>" . $webinfo["contactStraat"] . " " . $webinfo["contactStraatNr"] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td></td>";
            echo "<td>" . $webinfo["contactGemeenteCode"] . " " . $webinfo["contactGemeente"] . "</td>";
            echo "</tr>";
            ?>
        </table>
    </div>
    <div class="col-12 col-sm-6">
        <h4>Openingsuren</h4>
        <table>
            <?php
            echo "<tr>";
            echo "<td>" . $webinfo["openingsurenDagen"] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>" . $webinfo["openingsurenVanEersteDeel"] .
            " - " . $webinfo["openingsurenTotEersteDeel"];
            ?>
            &amp; <?php
            echo $webinfo["openingsurenVanTweedeDeel"] .
            " - " . $webinfo["openingsurenTotTweedeDeel"] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>" . $webinfo["openingsurenSluitDagen"] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>" . $webinfo["openingsurenOpmerking"] . "</td>";
            echo "</tr>";
            ?>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-12 col-sm-4">
        <div class="img-responsive">
            <?php
            echo '<img class="homePagina" src= "' . $webinfo["foto_1"] . '" alt="HomePaginaFoto 1" style="width:100%">';
            ?>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="img-responsive">
            <?php
            echo '<img class="homePagina" src= "' . $webinfo["foto_2"] . '" alt="HomePaginaFoto 2" style="width:100%">';
            ?>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="img-responsive">
            <?php
            echo '<img class="homePagina" src= "' . $webinfo["foto_3"] . '" alt="HomePaginaFoto 3" style="width:100%">';
            ?>
        </div>
    </div>
</div>
<!--INSERT INTO `webinfo`(`naam`, `waarde`) VALUES ('','')-->