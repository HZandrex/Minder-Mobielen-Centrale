<div class="col-lg-12">
    <div class="row justify-content-center align-self-center">
        <?php
            $attributes = array('name' => 'loginForm');
            echo form_open('gebruiker/inloggen/controleerLogin', $attributes);
        ?>
        <div class="card" id="inlogscherm">
            <div class="card-body">
                <h5 class="card-title">Inloggen</h5>
                <div class="form-group">
                    <?php echo form_label('E-mail:', 'email'); ?>
                    <?php echo form_input(array('name' => 'email', 'id' => 'email', 'size' => '30', 'class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo form_label('Wachtwoord:', 'wachtwoord'); ?></td>
                    <?php 
                        $data = array('name' => 'wachtwoord', 'id' => 'wachtwoord', 'size' => '30', 'class' => 'form-control');
                        echo form_password($data);
                    ?>
                </div>
                <?php echo form_submit(array('name' => 'inlogKnop', 'value' =>'Inloggen', 'class' => 'btn btn-primary')); ?>
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>
