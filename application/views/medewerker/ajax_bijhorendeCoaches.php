<?php
    //var_dump(json_encode($coaches));
?>
<script>
    function verwijderBijhorendeCoach(gebruikerId, coachMinderMobieleId) {
        $.ajax({
            type: "GET",
            url: site_url + "/medewerker/relatiesBeheren/archiveerBijhorendeCoach",
            data: {gebruikerId: gebruikerId, coachMinderMobieleId: coachMinderMobieleId},
            success: function (result) {
                $("#toonBijhorendeCoaches").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    };
    
    function voegToeBijhorendeCoach(gebruikerId, coachId) {
        $.ajax({
            type: "GET",
            url: site_url + "/medewerker/relatiesBeheren/voegToeBijhorendeCoach",
            data: {gebruikerId: gebruikerId, coachId: coachId},
            success: function (result) {
                $("#toonBijhorendeCoaches").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    };
    
    $(document).ready(function () {
        $('#listBoxBijhorendeCoaches').change(function () {
            $('#verwijderCoach-btn').removeClass("disabled");
        });
        $('#verwijderCoach-btn').click(function(){
            verwijderBijhorendeCoach($('#listBoxMinderMobielen option:selected').val(), $('#listBoxBijhorendeCoaches option:selected').val());  
            console.log($('#listBoxBijhorendeCoaches option:selected').val());
        });
        $('#voegToeCoach-btn').click(function(){
            voegToeBijhorendeCoach($('#listBoxMinderMobielen option:selected').val(), $('#comboBoxOverigeCoaches option:selected').val());  
            console.log($('#comboBoxOverigeCoaches option:selected').val());
        });
    });
</script>
<div class="form-group">
        <label for="sel1">Bijhorende coach(es):</label>
        <div class="input-group mb-2">
        <select multiple class="form-control" id="listBoxBijhorendeCoaches">
            <?php
                foreach ($bijhorendeCoaches as $coachMinderMobiele){
                    echo '<option value="'.$coachMinderMobiele->id.'">'.$coachMinderMobiele->coach->voornaam. ' ' .$coachMinderMobiele->coach->naam. '</option>';
                }
            ?>
        </select>
        <div class="input-group-append">
            <button class="btn btn-danger disabled" id="verwijderCoach-btn" type="button">Verwijderen</button>
        </div>
    </div>
    </div>
    <div class="input-group">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="comboBoxOverigeCoaches">Coach:</label>
            </div>
            <select class="custom-select" id="comboBoxOverigeCoaches">
                <?php
                    foreach ($coaches as $coach){
                        $coachExist = true;
                        foreach ($bijhorendeCoaches as $bijhorendeCoach){
                            
                            if($coach->coach->id == $bijhorendeCoach->coach->id){
                                $coachExist = false;
                            }
                        }
                        if($coachExist){
                            echo '<option value="'.$coach->coach->id.'">'.$coach->coach->voornaam. ' ' .$coach->coach->naam. '</option>';
                        }
                    }
                ?>
            </select>
        <div class="input-group-append">
          <button class="btn btn-success" id="voegToeCoach-btn" type="button">Toevoegen</button>
        </div>
    </div>
    </div>