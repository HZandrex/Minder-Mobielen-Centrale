<?php
    /**
     * @file medewerker/wachtwoordGebruikerWijzigen.php
     * 
     * View waarin het wachtwoord veranderd kan worden van een gebruiker
     * - geeft via wachtwoordWijzigenForm wachtwoord & wachtwoordBevestigen door naar GebruikersBeheren::wachtwoordVeranderen()
     * 
     * @see GebruikersBeheren::wachtwoordVeranderen()
     */
?>

<div class="row justify-content-center align-self-center">
    <?php
    $attributes = array('name' => 'wachtwoordWijzigenForm');
    $hidden = array('id' => $editGebruiker->id);
    echo form_open('medewerker/gebruikersBeheren/wachtwoordVeranderen', $attributes, $hidden);
    ?>
    <div class="card" id="inlogscherm">
        <div class="card-body">
            <?php echo anchor('medewerker/gebruikersBeheren', '< Terug', 'class="card-link"'); ?>
        </div>
        <div class="card-body">
            <h5 class="card-title">Wachtwoord wijzigen</h5>
            <div class="form-group">
                <?php echo form_label('Wachtwoord:', 'wachtwoord'); ?></td>
                <?php
                $data = array('name' => 'wachtwoord', 'id' => 'wachtwoord', 'size' => '30', 'class' => 'form-control', 'required' => 'true');
                echo form_password($data);
                ?>
            </div>
            <div class="form-group">
                <?php echo form_label('Wachtwoord bevestigen:', 'wachtwoordBevestigen'); ?></td>
                <?php
                $data = array('name' => 'wachtwoordBevestigen', 'id' => 'wachtwoordBevestigen', 'size' => '30', 'class' => 'form-control', 'required' => 'true');
                echo form_password($data);
                ?>
            </div>
            <?php echo form_submit(array('name' => 'wachtwoordWijzigenKnop', 'value' => 'Wachtwoord wijzigen', 'class' => 'btn btn-primary')); ?>
        </div>
    </div>

    <?php echo form_close(); ?>
</div>
