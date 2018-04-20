<script>
    function haalGebruikersMetFunctieOp(functieId) {
        $.ajax({
            type: "GET",
            url: site_url + "/medewerker/gebruikersbeheren/haalAjaxOp_GebruikersOpFunctie",
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
            url: site_url + "/medewerker/gebruikersbeheren/haalAjaxOp_GebruikerInfo",
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
        $('#gebruikersForm input[id=functieRadiogroup0]').prop("checked", true);
        haalGebruikersMetFunctieOp($('#gebruikersForm input[id=functieRadiogroup0]').val());

        $('#gebruikersForm input[name=functieRadiogroup]').change(function () {
            haalGebruikersMetFunctieOp($('#gebruikersForm input[name=functieRadiogroup]:checked').val());
        });

        $('#gebruikersListbox').change(function () {
            haalGebruikerInfoOp($('#gebruikersListbox option:selected').val());
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
        echo form_radiogroupFuncties('functieRadiogroup', $functies, 'id', 'naam');
        echo form_listboxproGebruikersBeheren('gebruikersListbox', array(), 'id', 'voornaam', 'naam', 0, array('id' => 'gebruikersListbox', 'size' => 10, 'class' => 'form-control'));
        ?>
    </div>

    <div class="col-7">
        <div id="gebruikerInfo" class="row"></div>
    </div>

</div>
<?php echo form_close(); ?>