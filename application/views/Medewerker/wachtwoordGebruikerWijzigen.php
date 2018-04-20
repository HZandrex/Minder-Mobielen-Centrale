<?php
    /**
     * @file Gebruiker/wachtwoordVergetenWijzigen.php
     * 
     * View waarin het wachtwoord veranderd kan worden na wachtwoord vergeten te doen
     * - geeft via wachtwoordVergetenWijzigenForm wachtwoord & wachtwoordBevestigen door naar Inloggen::wachtwoordVeranderen()
     * 
     * @see Inloggen::wachtwoordVeranderen()
     */
?>

<div class="row justify-content-center align-self-center">
    <?php
    $attributes = array('name' => 'wachtwoordVergetenWijzigenForm');
    $hidden = array('resetToken' => $resetToken);
    echo form_open('gebruiker/inloggen/wachtwoordVeranderen', $attributes, $hidden);
    ?>
    <div class="card" id="inlogscherm">
        <div class="card-body">
            <?php echo anchor('gebruiker/inloggen', '< Terug', 'class="card-link"'); ?>
        </div>
        <div class="card-body">
            <h5 class="card-title">Nieuw wachtwoord instellen</h5>
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
