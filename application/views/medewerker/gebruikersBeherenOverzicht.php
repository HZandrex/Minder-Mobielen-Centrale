<?php
/**
 * @file medewerker/gebruikersBeherenOverzicht.php
 *
 * View waarin gebruikers in kunnen worden beheerd
 */
?>

<script>
    function haalGebruikersMetFunctieOp(functieId) {
        $.ajax({
            type: "GET",
            url: site_url + "/medewerker/gebruikersBeheren/haalAjaxOp_GebruikersOpFunctie",
            data: {functieId: functieId},
            success: function (result) {
                $("#gebruikersListbox").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    function haalGebruikerInfoOp(gebruikerId) {
        $.ajax({
            type: "GET",
            url: site_url + "/medewerker/gebruikersBeheren/haalAjaxOp_GebruikerInfo",
            data: {gebruikerId: gebruikerId},
            success: function (result) {
                $("#gebruikerInfo").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        if($("input[name=firstVisit]").val() == 1){
            $('#tutorialModal').modal('show');
        }
        $('#gebruikersForm input[id=functieRadiogroup0]').prop("checked", true);
        haalGebruikersMetFunctieOp($('#gebruikersForm input[id=functieRadiogroup0]').val());

        $('#gebruikersForm input[name=functieRadiogroup]').change(function () {
            haalGebruikersMetFunctieOp($('#gebruikersForm input[name=functieRadiogroup]:checked').val());
        });

        $('#gebruikersListbox').change(function () {
            haalGebruikerInfoOp($('#gebruikersListbox option:selected').val());
        });

        $('#closeTut').click(function () {
            $('#tutorialModal').modal('hide');
        });
    });
</script>


<?php
$attributes = array('name' => 'gebruikersForm', 'id' => 'gebruikersForm');
echo form_open('admin/instellingen/voorkeurBeheren', $attributes);
?>
<div class="row">
    <div class="col-5">
        <p><b>Gebruikers</b></p>
        <?php
        echo form_hidden('firstVisit', $firstVisit);
        echo form_radiogroupFuncties('functieRadiogroup', $functies, 'id', 'naam');
        echo form_listboxproGebruikersBeheren('gebruikersListbox', array(), 'id', 'voornaam', 'naam', 0, array('id' => 'gebruikersListbox', 'size' => 10, 'class' => 'form-control'));
        ?>
        <div style="margin-top: 10px;"><?php print anchor("medewerker/gebruikersBeheren/gegevensWijzigen", '+ Nieuwe gebruiker', 'class="btn btn-primary"'); ?></div>
    </div>

    <div class="col-7">
        <div id="gebruikerInfo" class="row"></div>
    </div>

</div>
<?php echo form_close(); ?>
<div class="modal fade" id="tutorialModal" tabindex="-1" role="dialog" aria-labelledby="tutorialModalLabel"
     aria-hidden="true" data-id="" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tutorialModalLabel">Hoe werkt Gebruikers beheren?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <?php echo toonAfbeelding("tutorial/tut1.jpg", 'class="d-block w-100" alt="First slide"');?>
                        </div>
                        <?php
                            for ($i = 2; $i <= 7; $i++){
                                echo '<div class="carousel-item">';
                                echo toonAfbeelding("tutorial/tut".$i.".jpg", 'class="d-block w-100" alt="First slide"');
                                echo '</div>';
                            }
                        ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev" style="color: black;">
                        <span><i class="fas fa-angle-left fa-2x"></i></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next" style="color: black;">
                        <span><i class="fas fa-angle-right fa-2x"></i></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="closeTut">Close</button>
            </div>
        </div>
    </div>
</div>
