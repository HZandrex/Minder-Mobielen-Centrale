<?php
    /**
     * @file gebruiker/wachtwoordVergeten.php
     * 
     * View waarin een nieuw wachtwoord kan worden aangevraagd via mail
     * - stuurd naar het opgegeven mail adres in wachtwoordVergetenForm een link om het wachtwoord te wijzigen via Inloggen::nieuwWachtwoordAanvragen()
     * 
     * @see Inloggen::nieuwWachtwoordAanvragen()
     *
     * Gemaakt door Geffrey Wuyts
     */
?>

<div class="row justify-content-center align-self-center">
    <?php
    $attributes = array('name' => 'wachtwoordVergetenForm');
    echo form_open('gebruiker/inloggen/nieuwWachtwoordAanvragen', $attributes);
    ?>
    <div class="card" id="inlogscherm">
        <div class="card-body">
            <?php echo anchor('gebruiker/inloggen', '< Terug', 'class="card-link"'); ?>
        </div>
        <div class="card-body">
            <h5 class="card-title">Wachtwoord vergeten</h5>
            <p>Geef uw E-mail op om een nieuw wachtwoord aan te vragen.</p>
            <div class="form-group">
                <?php echo form_label('E-mail:', 'email'); ?>
                <?php echo form_input(array('name' => 'email', 'id' => 'email', 'size' => '30', 'class' => 'form-control', 'required' => 'true')); ?>
            </div>
            <?php echo form_submit(array('name' => 'verzendKnop', 'value' => 'Verzenden', 'class' => 'btn btn-primary')); ?>
        </div>
    </div>

    <?php echo form_close(); ?>
</div>
