<?php
    /**
     * @file gebruiker/inlogPagina.php
     * 
     * View waarin de inlogpagina wordt weergegeven
     * - geeft via loginForm email & wachtwoord door naar Inloggen::controleerLogin()
     * 
     * @see Inloggen::controleerLogin()
     *
     * Gemaakt door Geffrey Wuyts
     */
?>

<div class="row justify-content-center align-self-center">
    <?php
    $attributes = array('name' => 'loginForm');
    echo form_open('gebruiker/inloggen/controleerLogin', $attributes);
    ?>
    <div class="card" style="margin-top: 20px">
        <div class="card-body">
            <h5 class="card-title">Inloggen</h5>
            
            <div class="form-group">
                <?php echo form_label('E-mail:', 'email'); ?>
                <?php echo form_input(array('name' => 'email', 'id' => 'email', 'size' => '30', 'class' => 'form-control', 'required' => 'true'),'','autofocus'); ?>
            </div>
            <div class="form-group">
                <?php echo form_label('Wachtwoord:', 'wachtwoord'); ?></td>
                <?php
                $data = array('name' => 'wachtwoord', 'id' => 'wachtwoord', 'size' => '30', 'class' => 'form-control', 'required' => 'true');
                echo form_password($data);
                ?>
            </div>
            <?php echo form_submit(array('name' => 'inlogKnop', 'value' => 'Inloggen', 'class' => 'btn btn-primary')); ?>
            <?php echo anchor('', '<i class="fas fa-question"></i>', 'id="opener" class="card-link"') ; ?>
        </div>
        <div class="card-body">
            <?php echo anchor('gebruiker/inloggen/wachtwoordVergeten', 'Wachtwoord vergeten?', 'class="card-link"') ; ?>
        </div>
    </div>

    <?php echo form_close(); ?>
</div>

<div id="dialog" title="Inlog/uitloggen handleiding">
    <h5>Inloggen</h5>
    <ul>
        <li>Hoofdletter gevoelig!</li>
        <li>Geen spaties!</li>
    </ul>

    <h5>Uitloggen</h5>
    <p>Rechts bovenaan in menu</p>
    <?php echo toonAfbeelding('/handleiding/helpUitloggen.png', $attributen = 'alt="afbeelding uitloggen"');?>

</div>

<script>
  $( "#dialog" ).dialog({
      autoOpen: false,
      position: { my: "left top", at: "left bottom", of: "#opener" }
   });

    $( "#opener" ).click(function(e) {
        e.preventDefault();
        $( "#dialog" ).dialog( "open" );
    });
</script>
