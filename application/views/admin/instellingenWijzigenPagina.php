<?php


?>
<script>
    $(document).ready(function(){
        var aniTijd = 100;

        $('#teWijzigeVoorkeur').val('');

        $("#soort option").click(function() {
            $('#voorkeurAdd').hide(aniTijd);
            $('#teWijzigeVoorkeur').prop('disabled', false);
            $('#voorkeurWijzigen').prop('disabled', false);
            $('#voorkeurVerwijderen').prop('disabled', false);
            $('#nieuweVoorkeur').prop('disabled', true);
            $('#voorkeurEdit').show(aniTijd);
            $('#voorkeurNew').show(aniTijd);
            $("#teWijzigeVoorkeur").val($(this).text());
            $("#voorkeurId").val($(this).val());
        });

        $("#nieuwKnop").click(function () {
            $('#voorkeurNew').hide(aniTijd);
            $('#voorkeurEdit').hide(aniTijd);
            $('#voorkeurAdd').show(aniTijd);
            $('#nieuweVoorkeur').prop('disabled', false);
            $('#voorkeurWijzigen').prop('disabled', true);
            $('#voorkeurVerwijderen').prop('disabled', true);
            $('#teWijzigeVoorkeur').prop('disabled', true);
        });

    });
</script>

<div class="row">
    <div class="col-sm-12 col-md-6">
    <?php
        $attributes = array('name' => 'instellingenForm');
        echo form_open('admin/instellingen/wijzigInstellingen', $attributes);
        foreach ($instellingen as $instelling) {
            echo '<div class="form-group row">';
                echo form_label($instelling->beschrijving, $instelling->naam, array('class' => 'col-sm-12 col-md-8 col-form-label'));
                echo form_input(array('name' => $instelling->naam, 'id' => $instelling->naam, 'placeholder' => $instelling->waarde, 'type' => 'numeric', 'size' => '30', 'class' => 'form-control col-sm-12 col-md-2'));
            echo '</div>';
        }

        echo form_submit(array('name' => 'InstellingenOpslaan', 'value' => 'Opslaan', 'class' => 'btn btn-primary'));

        echo form_close();
    ?>
    </div>


    <div class="col-sm-12 col-md-6">
        <?php
        $attributes = array('name' => 'voorkeurForm');
        echo form_open('admin/instellingen/voorkeurBeheren', $attributes);
        ?>
        <div class="row">
            <?php if (!empty($voorkeuren)) {?>
                <div class="col-12">
                    <p>Communicatie mogenlijkheden:</p>
                    <?php
                    $lengte = count($voorkeuren);
                    if(count($voorkeuren) > 10){
                        $lengte = 10;
                    }
                    echo form_listboxpro('soort', $voorkeuren, 'id', 'naam', 0, array('id' => 'soort', 'size' => $lengte, 'class' => 'form-control'));
                    ?>
                </div>
            <?php } else {?>
            <div class="col-12 ">
                <div class="card" style="margin-top: 20px">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <p class="font-weight-bold">Er zijn geen mindermobiele waar jij verantwoordelijk voor bent</p>
                        </div>
                    </div>
                </div>
            <?php } ?>


            <div class="col-12" id="voorkeurEdit">
                <div class="row" style="padding-top: 10px">
                    <div class="col-12">
                        <?php echo form_label('Verander de naam:', 'teWijzigeVoorkeur'); ?>
                    </div>
                    <div class="col-6">
                        <?php
                        echo form_input(array('type' => 'hidden', 'name' => 'voorkeurId', 'id' => 'voorkeurId'));
                        echo form_input(array('name' => 'teWijzigeVoorkeur', 'id' => 'teWijzigeVoorkeur', 'placeholder' => 'Selecteer voorkeur', 'required' => 'true', 'disabled' => 'true', 'size' => '30', 'class' => 'form-control'));
                        ?>
                    </div>
                    <div class="col-6" style="padding-left: 0">
                        <?php
                        echo form_submit(array('name' => 'voorkeurWijzigen', 'id' => 'voorkeurWijzigen', 'value' => 'Wijzigen', 'class' => 'btn btn-primary'));
                        ?>
                        <?php
                        echo form_submit(array('name' => 'voorkeurVerwijderen', 'id' => 'voorkeurVerwijderen', 'value' => 'Verwijderen', 'class' => 'btn btn-danger'));
                        ?>
                    </div>
                </div>

            </div>

            <div class="col-12" id="voorkeurNew" style="padding-top: 10px">
                <button id="nieuwKnop" type="button" class="btn btn-primary">Nieuw</button>
            </div>

            <div class="col-12" id="voorkeurAdd" style="display: none">
                <div class="row" style="padding-top: 10px">
                    <div class="col-12">
                        <?php echo form_label('Geef een nieuwe voorkeur in:', 'nieuweVoorkeur'); ?>
                    </div>
                    <div class="col-6">
                        <?php
                            echo form_input(array('name' => 'nieuweVoorkeur', 'id' => 'nieuweVoorkeur', 'placeholder' => 'Nieuwe voorkeur', 'required' => 'true', 'disabled' => 'true', 'size' => '30', 'class' => 'form-control'));
                        ?>
                    </div>
                    <div class="col-6" style="padding-left: 0">
                        <?php
                            echo form_submit(array('name' => 'voorkeurToevoegen', 'value' => 'Toevoegen', 'class' => 'btn btn-primary'));
                        ?>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>