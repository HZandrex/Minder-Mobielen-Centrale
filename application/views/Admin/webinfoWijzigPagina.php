
<div class="col-12">
    <?php
        $attributen = array('name' => 'mijnFormulier', 'class' => 'form-horizontal');
        echo form_open('admin/webinfo/wijzig', $attributen);
    ?>
    <h3>Homepagina</h3>
    <div class="form-group">
        <?php echo form_label('Titel:', 'homeTitel'); ?>
        <input type="text" class="form-control" name="homeTitel" value= "<?php echo $webinfo["homeTitel"]?>" required>
    </div>
    <div class="form-group">
        <?php echo form_label('Tekst (Intro?):', 'homeTekst'); ?>
        <textarea rows="8" class="form-control" name="homeTekst" required><?php echo $webinfo["homeTekst"]?></textarea>
    </div>
    <div class="form-group">
        <?php echo form_label('Foto&#39;s:', 'foto_1'); ?>
        <input type="url" class="form-control" name="foto_1" value= "<?php echo $webinfo["foto_1"]?>" required>
        <input type="url" class="form-control" name="foto_2" value= "<?php echo $webinfo["foto_2"]?>" required>
        <input type="url" class="form-control" name="foto_3" value= "<?php echo $webinfo["foto_3"]?>" required>
    </div>
</div>

<div class="col-md-6">
    <h3>Contactinformatie</h3>
        <div class="form-group">
            <?php echo form_label('Telefoon:', 'contactTelefoon'); ?>
            <input type="tel" class="form-control" name="contactTelefoon" value= "<?php echo $webinfo["contactTelefoon"]?>" required>
        </div>
        <div class="form-group">
            <?php echo form_label('Mail:', 'contactMail'); ?>
            <input type="email" class="form-control" name="contactMail" value= "<?php echo $webinfo["contactMail"]?>" required>
        </div>
        <div class="form-group">
            <?php echo form_label('Fax:', 'contactFax'); ?>
            <input type="text" class="form-control" name="contactFax" value= "<?php echo $webinfo["contactFax"]?>" required>
        </div>
        <div class="form-group">
            <?php echo form_label('Straat:', 'contactStraat'); ?>
            <div class="row">
                <div class="col-9">
                <input type="text" class="form-control" name="contactStraat" value= "<?php echo $webinfo["contactStraat"]?>" required>
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" name="contactStraatNr" value= "<?php echo $webinfo["contactStraatNr"]?>" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php echo form_label('Adres:', 'contactGemeenteCode'); ?>
            <div class="row">
                <div class="col-4">
                    <input type="text" maxlength="4"  class="form-control" name="contactGemeenteCode" value= "<?php echo $webinfo["contactGemeenteCode"]?>" required>
                </div>
                <div class="col-8">
                    <input type="text" class="form-control" name="contactGemeente" value= "<?php echo $webinfo["contactGemeente"]?>" required>
                </div>
            </div>
        </div>
    </table>
</div>

<div class="col-md-6">
    <h3>Openingsuren</h3>
        <div class="form-group">
            <?php echo form_label('Dagen open:', 'openingsurenDagen'); ?>
            <input type="text" class="form-control" name="openingsurenDagen" value= "<?php echo $webinfo["openingsurenDagen"]?>" required>
        </div>
        <div class="form-group">
            <?php echo form_label('Uren:', 'openingsurenVanEersteDeel'); ?>
            <div class="row">
                <div class="col-2">
                    Van 
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" name="openingsurenVanEersteDeel" value= "<?php echo $webinfo["openingsurenVanEersteDeel"]?>" required>
                </div>
                <div class="col-1">
                    -
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" name="openingsurenTotEersteDeel" value= "<?php echo $webinfo["openingsurenTotEersteDeel"]?>" required>
                </div>
                <div class="col-2">
                    Tot 
                </div>
                <div class="col-4">    
                    <input type="text" class="form-control" name="openingsurenVanTweedeDeel" value= "<?php echo $webinfo["openingsurenVanTweedeDeel"]?>" required>
                </div>
                <div class="col-1">
                    -
                </div>
                <div class="col-4">   
                    <input type="text" class="form-control" name="openingsurenTotTweedeDeel" value= "<?php echo $webinfo["openingsurenTotTweedeDeel"]?>" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php echo form_label('Sluit dagen:', 'openingsurenSluitDagen'); ?>
            <input type="text" class="form-control" name="openingsurenSluitDagen" value= "<?php echo $webinfo["openingsurenSluitDagen"]?>" required>
        </div>
        <div class="form-group">
            <?php echo form_label('Opmerking:', 'openingsurenOpmerking'); ?>
            <input type="text" class="form-control" name="openingsurenOpmerking" value= "<?php echo $webinfo["openingsurenOpmerking"]?>" required>
        </div>
</div>
<div class="text-right col-12">
    <?php echo form_submit('knop', 'Opslaan', 'class="btn btn-primary"'); ?>
    <?php echo form_close(); ?>
</div>