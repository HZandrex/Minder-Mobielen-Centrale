<?php
    /**
     * @file Gebruiker/inlogPagina.php
     * 
     * View waarin de inlogpagina wordt weergegeven
     * - geeft via loginForm email & wachtwoord door naar Inloggen::controleerLogin()
     * 
     * @see Inloggen::controleerLogin()
     */
?>

<div class="row justify-content-center align-self-center">
    <?php
    $attributes = array('name' => 'wachtwoordVergetenForm');
    $hidden = array('id' => $gebruiker->id);
    echo form_open('gebruiker/persoonlijkegegevens/wachtwoordveranderen', $attributes, $hidden);
    ?>
    <div class="card" id="inlogscherm">
        <div class="card-body">
            <?php echo anchor('gebruiker/inloggen', '< Terug', 'class="card-link"'); ?>
        </div>
        <div class="card-body">
            <h5 class="card-title">Wachtwoord veranderen</h5>
            <div class="form-group">
                <?php echo form_label('Oud wachtwoord:', 'oudWachtwoord'); ?></td>
                <?php
                $data = array('name' => 'oudWachtwoord', 'id' => 'oudWachtwoord', 'size' => '30', 'class' => 'form-control', 'required' => 'true');
                echo form_password($data);
                ?>
            </div>
            <div class="form-group">
                <?php echo form_label('Nieuw wachtwoord:', 'nieuwWachtwoord'); ?></td>
                <?php
                $data = array('name' => 'nieuwWachtwoord', 'id' => 'nieuwWachtwoord', 'size' => '30', 'class' => 'form-control', 'required' => 'true');
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

    <?php echo form_close();?>
</div>
