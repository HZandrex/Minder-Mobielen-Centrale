<?php

var_dump($gebruiker->functies);
?>
<div class="row">
    <div class="col-sm-12 col-md-6">
    <?php
        $attributes = array('name' => 'instellingenForm');
        echo form_open('admin/instellingen/wijzigInstellingen', $attributes);
        /*
         * input field komt bij klein scherm lelijk te staan
         */
        foreach ($instellingen as $instelling) {
            echo '<div class="form-group row">';
                echo form_label($instelling->beschrijving, $instelling->naam, array('class' => 'col-sm-12 col-md-7 col-form-label'));
                echo form_input(array('name' => $instelling->naam, 'id' => $instelling->naam, 'placeholder' => $instelling->waarde, 'size' => '30', 'class' => 'form-control col-sm-12 col-md-2'));
            echo '</div>';
        }
        echo form_close();
    ?>
    </div>
    
    <div class="col-sm-12 col-md-6">
        <div class="row">
            <div class="col-12">
                <p>Communicatie mogenlijkheden:</p>
            </div>
            <div class="col-11">
                <?php
                    $lengte = count($voorkeuren);
                    if(count($voorkeuren) > 10){
                        $lengte = 10;
                    }
                    echo form_listboxpro('soort', $voorkeuren, 'id', 'naam', 0, array('id' => 'soort', 'size' => $lengte, 'class' => 'form-control'));
                ?>
            </div>
            <div class="col-1">
                <?php echo anchor('', '<i class="fas fa-times fa-2x" style="color:red" padding:0></i>'); ?>
            </div>
            <div class="row" style="padding: 10px 10px 0">
                <div class="form-group col-8">
                    <?php
                        echo form_input(array('name' => 'nieuweVoorkeur', 'id' => 'nieuweVoorkeur', 'placeholder' => 'Nieuwe voorkeur', 'size' => '30', 'class' => 'form-control'));
                    ?>
                </div>
                <div class="col-3">
                    <?php
                        echo form_submit(array('name' => 'voorkeurToevoegen', 'value' => 'Toevoegen', 'class' => 'btn btn-primary'));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>