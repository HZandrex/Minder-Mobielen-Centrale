<?php
    /**
     * @file main_melding.php
     * 
     * View waarin een melding wordt weergegeven
     * - de inhoud wordt megeven bij het oproepen van deze view
     */
?>

<div class="col-lg-12">
    <div class="row justify-content-center align-self-center">
        <div class="card" id="inlogscherm">
            <div class="card-body">
                <h5 class="card-title"><?php echo $foutTitel; ?></h5>
                <p><?php echo $boodschap; ?></p>
                
            </div>
            <div class="card-body">
                <?php echo anchor($link['url'], $link['tekst'], 'class="card-link"'); ?>
            </div>
        </div>
    </div>
</div>
