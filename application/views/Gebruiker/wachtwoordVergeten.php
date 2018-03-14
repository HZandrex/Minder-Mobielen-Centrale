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
    echo form_open('gebruiker/inloggen/nieuwwachtwoord', $attributes);
    ?>
    <div class="card" id="inlogscherm">
        <div class="card-body">
            <?php echo anchor('gebruiker/inloggen', '< Terug'); ?>
            <h5 class="card-title">Wachtwoord vergeten</h5>
            <p>Geef uw E-mail op om een nieuw wachtwoord aan te vragen.</p>
            <div class="form-group">
                <?php echo form_label('E-mail:', 'email'); ?>
                <?php echo form_input(array('name' => 'email', 'id' => 'email', 'size' => '30', 'class' => 'form-control', 'required' => 'true')); ?>
            </div>
            <?php if(isset($fout)){echo $fout;}; ?>
            <?php echo form_submit(array('name' => 'verzendKnop', 'value' => 'Verzenden', 'class' => 'btn btn-primary')); ?>
        </div>
    </div>

    <?php echo form_close(); ?>
</div>
