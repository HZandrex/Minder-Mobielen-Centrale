<script>
    function haalGebruikersMetFunctieOp ( functieId ) {
        $.ajax({type : "GET",
            url : site_url + "/medewerker/gebruikersbeheren/haalAjaxOp_GebruikersOpFunctie",
            data : { functieId : functieId },
            success : function(result){
                $("#gebruikersListbox").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }


    $(document).ready(function(){
        $('#gebruikersForm input[name=functieRadiogroup]').

        $('#gebruikersForm input[name=functieRadiogroup]').change(function () {
            haalGebruikersMetFunctieOp($('#gebruikersForm input[name=functieRadiogroup]:checked').val());
        });
    });

</script>


<?php
$attributes = array('name' => 'gebruikersForm', 'id' => 'gebruikersForm');
echo form_open('admin/instellingen/voorkeurBeheren', $attributes);
?>
<div class="row">

    <div class="col-md-6 col-12">
        <p><b>Gebruikers</b></p>
        <?php
        echo form_radiogroupFuncties('functieRadiogroup', $functies, 'id', 'naam');
        echo form_listboxproGebruikersBeheren('gebruikersListbox', array(), 'id', 'voornaam', 'naam', 0, array('id' => 'gebruikersListbox', 'size' => 10, 'class' => 'form-control w-75'));
        ?>
    </div>

    <div class="col-md-6 col-12">
        <p><b>Contactgegevens</b></p>
    </div>

</div>
<?php echo form_close(); ?>