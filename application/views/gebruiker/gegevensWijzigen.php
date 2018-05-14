<?php
/**
 * @file gebruiker/gegevensWijzigen.php
 *
 * View waarin een gebruiker zijn gegevens veranderd kunnen worden
 * - geeft via wijzigenGegevensFormulier alle gegevens door naar PersoonlijkeGegevens::gegevensVeranderen()
 *
 * PersoonlijkeGegevens::gegevensVeranderen()
 */
?>

<?php
$attributen = array('name' => 'wijzigenGegevensFormulier', 'class' => 'form-horizontal');
$hidden = array('id' => $gegevens->id);
echo form_open('gebruiker/persoonlijkeGegevens/gegevensVeranderen', $attributen, $hidden);
?>

<style>
	.pac-container {
        z-index: 10000;
    }

    input::-webkit-calendar-picker-indicator{
        display: none;
    }
    input[type="date"]::-webkit-input-placeholder{
        visibility: hidden !important;
    }

	.datepicker { position: relative; z-index: 10000 !important; }
</style>

<div class="row">
    <div class="col-lg-6 col-sm-12">
        <div class="row">
            <h4 class="col-12">Contactgegevens</h4>
            <div class="col-6">
                <?php echo form_label('Voornaam:', 'gegevensVoornaam'); ?>
                <input required placeholder="Voornaam" type="text" class="form-control" name="gegevensVoornaam"
                       value="<?php echo $gegevens->voornaam ?>"
                       required>
            </div>
            <div class="col-6">
                <?php echo form_label('Naam:', 'gegevensNaam'); ?>
                <input required placeholder="Naam" type="text" class="form-control" name="gegevensNaam" value="<?php echo $gegevens->naam ?>"
                       required>
            </div>
            <div class="col-12">
                <?php echo form_label('Geboorte:', 'gegevensGeboorte'); ?>
                <input required class="form-control datepicker" data-provide="datepicker" type="date" name="gegevensGeboorte"
                       value="<?php print $gegevens->geboorte ?>"
                       required>
                <?php echo form_label('Telefoon:', 'gegevensTelefoon'); ?>
                <input required minlength="9" pattern="^[0-9]*$" type="text" class="form-control" name="gegevensTelefoon"
                       value="<?php echo $gegevens->telefoon ?>"
                       required>
                <?php echo form_label('Email:', 'gegevensMail'); ?>
                <input required type="text" class="form-control" name="gegevensMail" value="<?php echo $gegevens->mail ?>"
                       required>
                <?php echo form_label('Gewenst communicatiemiddel:', 'gegevensCommunicatie'); ?>
                <select class="form-control" name="gegevensCommunicatie" required>
                    <?php
                    foreach ($communicatiemiddelen as $middel) {
                        if ($middel->id == $gegevens->voorkeur->id) {
                            print '<option selected value="' . $middel->id . '">' . $middel->naam . '</option>';
                        } else {
                            print '<option value="' . $middel->id . '">' . $middel->naam . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

    </div>
    <div class="col-lg-6 col-sm-12">
        <div class="row">
            <h4 class="col-12">Adresgegevens</h4>
            <div class="col-12">
                <label for="adres">Thuis adres: </label>
                <select class="custom-select" id="adres" name="adresId" required>
                    <?php
                    $selectAdressen = '<option value="default" selected disabled>Kies een adres of voeg er een toe</option><option id="nieuwAdres" value="nieuwAdres">Nieuw adres</option>';
                    foreach ($adressen as $adres) {
                        if ($adres->id == $gegevens->adres->id) {
                            $selectAdressen .= '<option selected value="' . $adres->id . '">' . $adres->straat . ' ' . $adres->huisnummer . ' (' . $adres->gemeente . ')</option>';
                        } else {
                            $selectAdressen .= '<option value="' . $adres->id . '">' . $adres->straat . ' ' . $adres->huisnummer . ' (' . $adres->gemeente . ')</option>';
                        }
                    }
                    echo $selectAdressen;
                    ?>
                </select>
            </div>

    </div>
</div>
<div class="text-right col-12">
    <?php echo form_submit('knop', 'Opslaan', 'class="btn btn-primary"'); ?>
    <?php echo anchor('gebruiker/persoonlijkeGegevens/persoonlijkeGegevens', 'Annuleren', 'class="btn btn-primary"'); ?>
    <?php echo form_close(); ?>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true" data-id="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="adres" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nieuw adres</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert" id="errorModal" style="display: none;"></div>
                    <div id="locationField">
                        <div class="form-group">
                            <input type="text" class="form-control" id="autocomplete"
                                   placeholder="Vul hier het adres in" onFocus="geolocate()">
                        </div>
                    </div>
                    <div id="address">
                        <div class="form-group">
                            <label for="street_number">Nummer</label>
                            <input type="text" class="form-control" id="street_number" disabled="true">
                        </div>
                        <div class="form-group">
                            <label for="route">Straat</label>
                            <input type="text" class="form-control" id="route" disabled="true">
                        </div>
                        <div class="form-group">
                            <label for="locality">Gemeente</label>
                            <input type="text" class="form-control" id="locality" disabled="true">
                        </div>
                        <div class="form-group">
                            <label for="postal_code">Postcode</label>
                            <input type="text" class="form-control" id="postal_code" disabled="true">
                        </div>
                        <div class="form-group">
                            <label for="administrative_area_level_1">Staat</label>
                            <input type="text" class="form-control" id="administrative_area_level_1"
                                   disabled="true">
                        </div>
                        <div class="form-group">
                            <label for="country">Land</label>
                            <input type="text" class="form-control" id="country" disabled="true">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="anuleerAdres">Anuleren</button>
                    <button type="button" class="btn btn-primary" id="saveAdres">Opslaan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3Fe2FqE9k7EP-u0Q1j5vUoVhtfbWfSjU&libraries=places&callback=initAutocomplete"
        async defer></script>
<script>
$('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        weekStart: 1,
        endDate: '+0d',
        autoclose: true,
        language: 'nl'
    });

    $('select').change(function () {
        if ($(this).val() == 'nieuwAdres') {
            $('#exampleModal').attr('data-id', $(this).attr('id'));
            $('#exampleModal').modal('show');
        }
    });

    $('#anuleerAdres').click(function () {
        $('#exampleModal').modal('hide');
        $("form#adres :input").each(function () {
            $(this).val('');
        });
        $('#errorModal').hide();
    });

    $("#exampleModal").on('hide.bs.modal', function () {
        $('#' + $('#exampleModal').attr('data-id')).val('default');
        $("form#adres :input").each(function () {
            $(this).val('');
        });
        $('#errorModal').hide();
    });

    $('#saveAdres').click(function () {
        //uitlezen adres
        var huisnummer = $('#street_number').val();
        var straat = $('#route').val();
        var gemeente = $('#locality').val();
        var postcode = $('#postal_code').val();

        if (huisnummer == '' || straat == '' || gemeente == '' || postcode == '') {
            errorModal('Vul een volledig adres in! huisnummer, straat, gemeente, postcode');
        } else {
            //kijk of adres al ingeladen is
            var bestaat = checkOfAdresIngeladenIs(huisnummer, straat, gemeente);
            if (bestaat != false) {
                $('#exampleModal').modal('hide');
                $('#' + $('#exampleModal').attr('data-id')).val(bestaat);

            } else {
                // ajaxrequest
                $.ajax(
                    {
                        type: "post",
                        url: "<?php echo base_url(); ?>index.php/mm/ritten/nieuwAdres",
                        data: {huisnummer: huisnummer, straat: straat, gemeente: gemeente, postcode: postcode},
                        success: function (response) {
                            console.log(response);//Stationsstraat 177, Geel, België
                            var adres = JSON.parse(response);
                            //toevoegen aan adressen lijst
                            $('select').each(function () {
                                $(this).children().eq(1).after('<option value="' + adres.id + '">' + adres.straat + ' ' + adres.huisnummer + ' (' + adres.gemeente + ')</option>');
                            });
                            $('#exampleModal').modal('hide');
                            $('#' + $('#exampleModal').attr('data-id')).val(adres.id);
                        }
                    }
                );
            }
        }
    });

    function errorModal(bericht) {
        $('#errorModal').html(bericht);
        $('#errorModal').slideDown();
    }

    function checkOfAdresIngeladenIs(huisnummer, straat, gemeente) {
        var result = false;
        $('select#heenStartAdres option').each(function () {
            if ($(this).text() == (straat + " " + huisnummer + " (" + gemeente + ")")) {
                result = $(this).val();
                return false;
            }
        });
        return result;
    }

    //autocomplete van google
    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
            document.getElementById(component).value = '';
            // document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
</script>
