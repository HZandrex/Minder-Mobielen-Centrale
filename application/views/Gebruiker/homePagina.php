<div class="col-lg-6">
    <?php
        echo "<h4>" . $webinfo["homeTitel"] . "</h4>";
        echo "<p>" . $webinfo["homeTekst"] . "</p>";
    ?>
</div>
<div class="col-lg-3">
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
        ?>
    </table>
</div>

<!--INSERT INTO `webinfo`(`naam`, `waarde`) VALUES ('','')-->