<?php
/**
 * @file medewerker/relatiesBeherenOverzicht.php
 *
 * View waarin een medewerker relaties tussen minder mobiele gebruiker en coaches kan weergeven, maken en verwijderen.
 *
 * @see RelatiesBeheren::haalAjaxOp_bijhorendeCoaches()
 *
 * Gemaakt doorr Nico Claes
 */
?>

<script>
jQuery.fn.filterByText = function(textbox) {
  return this.each(function() {
    var select = this;
    var options = [];
    $(select).find('option').each(function() {
      options.push({
        value: $(this).val(),
        text: $(this).text()
      });
    });
    $(select).data('options', options);

    $(textbox).bind('change keyup', function() {
      var options = $(select).empty().data('options');
      var search = $.trim($(this).val());
      var regex = new RegExp(search, "gi");

      $.each(options, function(i) {
        var option = options[i];
        if (option.text.match(regex) !== null) {
          $(select).append(
            $('<option>').text(option.text).val(option.value)
          );
        }
      });
    });
  });
};

$(function() {
  $('select').filterByText($('input#zoekGebruiker'));
});


function haalBijhorendeCoachesOp(gebruikerId) {
    $.ajax({
        type: "GET",
        url: site_url + "/medewerker/relatiesBeheren/haalAjaxOp_bijhorendeCoaches",
        data: {gebruikerId: gebruikerId},
        success: function (result) {
            $("#toonBijhorendeCoaches").html(result);
        },
        error: function (xhr, status, error) {
            alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
        }
    });
};
	
$(document).ready(function () {
    $('#listBoxMinderMobielen').change(function () {
        haalBijhorendeCoachesOp($('#listBoxMinderMobielen option:selected').val());
        console.log($('#listBoxMinderMobielen option:selected').val());
    });
});
</script>


<?php
//var_dump($gebruikers);
$attributes = array('name' => 'gebruikersForm', 'id' => 'gebruikersForm');
echo form_open('admin/instellingen/voorkeurBeheren', $attributes);
?>
<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
        <label class="center" for="zoekGebruiker">Minder mobiele gebruiker:</label>
        <div class="input-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="zoekGebruiker">Zoeken:</label>
                </div>
                <input type="text" id="zoekGebruiker" class="form-control">
            </div>
            <select multiple class="form-control" name="listBoxMinderMobielen" id="listBoxMinderMobielen">
                <?php
                    foreach ($gebruikers as $gebruikerInfo){
                        echo '<option value="'.$gebruikerInfo->id.'">'.$gebruikerInfo->voornaam. ' ' .$gebruikerInfo->naam. '</option>';
                    }
                ?>
            </select>
        </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div id="toonBijhorendeCoaches"></div>
    </div>
    </div>
<?php echo form_close(); ?>
