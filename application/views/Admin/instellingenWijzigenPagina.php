<?php

//print_r($instellingen);
?>
<div class="row">
<?php
    echo '<div class="col-sm-12 col-md-6">';
    $attributes = array('name' => 'instellingenForm');
    echo form_open('admin/instellingen/wijzigInstellingen', $attributes);
    /*
     * input field komt bij klein scherm lelijk te staan
     */
    foreach ($instellingen as $instelling) {
        echo '<div class="form-group row">';
            echo form_label($instelling->beschrijving, $instelling->naam, array('class' => 'col-sm-12 col-md-7 col-form-label'));
            echo form_input(array('name' => $instelling->naam, 'id' => $instelling->naam, 'placeholder' => $instelling->waarde, 'size' => '30', 'class' => 'form-control col-sm-12 col-md-5'));
        echo '</div>';
    }
    echo form_close();
    echo '</div>';
?>
</div>