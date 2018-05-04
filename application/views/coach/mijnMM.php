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
  $('select').filterByText($('input'));
});

function haalGebruikerInfoOp(gebruikerId) {
        $.ajax({
            type: "GET",
            url: site_url + "/coach/mijnMM/haalAjaxOp_GebruikerInfo",
            data: {gebruikerId: gebruikerId},
            success: function (result) {
                $("#gebruikerInfo").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    };
	
	$(document).ready(function () {
		$('#listBoxMinderMobielen').change(function () {
            haalGebruikerInfoOp($('#listBoxMinderMobielen option:selected').val());
        });
	});
</script>
<div>
	
	<div class="row">
		<div class="panel panel-primary col-lg-4">
			<div class="panel-heading>Zoeken</div>
				<div class="panel-body">
					<div class="form-group">
							<label for="naam">Zoeken:</label>
							<?php echo form_input(array('name' => 'naam', 'id' => 'search', 'class' => 'form-control')) ?>
					</div>
				</div>
				
				<select id="listBoxMinderMobielen" class="form-control" name="listBoxMinderMobielen" size="15">
				<?php foreach($minderMobielen as $minderMobiel){?>
					<option value="<?php echo $minderMobiel->id?>"><?php echo $minderMobiel->voornaam." ".$minderMobiel->naam ?></option>
					<?php } ?>
				</select>
		</div>
				
			
		<div class="col-lg-8">
			<div id="gebruikerInfo" class="row"></div>
		</div>
	
	</div>
</div>
