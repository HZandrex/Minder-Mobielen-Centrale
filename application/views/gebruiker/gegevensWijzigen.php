<?php
/**
 * @file gebruiker/gegevensWijzigen.php
 *
 * View waarin een gebruiker zijn gegevens veranderd kunnen worden
 * - geeft via wijzigenGegevensFormulier alle gegevens door naar PersoonlijkeGegevens::gegevensVeranderen()
 *
 * @see PersoonlijkeGegevens::gegevensVeranderen()
 */
?>

<?php
$attributen = array('name' => 'wijzigenGegevensFormulier',
    'id' => 'wijzigenGegevensFormulier',
    'novalidate' => 'novalidate',
    'class' => 'form-horizontal needs-validation');
$hidden = array('id' => $editGebruiker->id);
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

</style>
<div class=row>
    <div class="col-lg-6 col-sm-12">
        <div class="row">
            <h4 class="col-12">Contactgegevens</h4>
            <div class="col-6">
                <div class="form-group">
                    <?php
                    echo form_labelpro('Voornaam', 'voornaam');
                    $dataVoornaam = array('id' => 'voornaam',
                        'name' => 'voornaam',
                        'class' => 'form-control',
                        'value' => $editGebruiker->voornaam,
                        'placeholder' => 'Voornaam',
                        'required' => 'required');
                    echo form_input($dataVoornaam) . "\n";
                    ?>
                    <div class="invalid-feedback">Vul een voornaam in!</div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <?php
                    echo form_labelpro('Naam', 'naam');
                    $dataNaam = array('id' => 'naam',
                        'name' => 'naam',
                        'class' => 'form-control',
                        'value' => $editGebruiker->naam,
                        'placeholder' => 'Naam',
                        'required' => 'required');
                    echo form_input($dataNaam) . "\n";
                    ?>
                    <div class="invalid-feedback">Vul een naam in!</div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <?php echo form_labelpro('Geboorte', 'geboorte'); ?>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for='geboorte'>
                                <i class="fas fa-calendar-alt"></i>
                            </label>
                        </div>
                        <?php
                        $dataNaam = array('id' => 'geboorte',
                            'name' => 'geboorte',
                            'class' => 'form-control datepicker',
                            'value' => $editGebruiker->geboorte,
                            'data-provide' => 'datepicker',
                            'type' => 'date',
                            'required' => 'required');
                        echo form_input($dataNaam) . "\n";
                        ?>
                        <div class="invalid-feedback" id="errorGeboorte">Vul een geboortedatum in!</div>
                    </div>
                </div>

                <div class="form-group">
                    <?php
                    echo form_labelpro('Telefoon (zonder spaties)', 'telefoon');
                    $dataTelefoon = array('id' => 'telefoon',
                        'name' => 'telefoon',
                        'class' => 'form-control',
                        'value' => $editGebruiker->telefoon,
                        'required' => 'required',
                        'minlength' => '9',
                        'pattern' => '^[0-9]*$');
                    echo form_input($dataTelefoon) . "\n";
                    ?>
                    <div class="invalid-feedback">Geef een geldige telefoon nummer in!</div>
                </div>

                <div class="form-group">
                    <?php
                    echo form_labelpro('E-mail', 'mail');
                    $dataMail = array('id' => 'mail',
                        'name' => 'mail',
                        'class' => 'form-control',
                        'value' => $editGebruiker->mail,
                        'required' => 'required',
                        'type' => 'mail');
                    echo form_input($dataMail) . "\n";
                    ?>
                    <div class="invalid-feedback">Geef een geldig e-mailadres in!</div>
                </div>
                <?php echo form_label('Gewenst communicatiemiddel:', 'voorkeur'); ?>
                <select class="form-control" name="voorkeurId" required>
                    <?php
                    foreach ($voorkeuren as $voorkeur) {
                        if ($voorkeur->id == $editGebruiker->voorkeur->id) {
                            print '<option selected value="' . $voorkeur->id . '">' . $voorkeur->naam . '</option>';
                        } else {
                            print '<option value="' . $voorkeur->id . '">' . $voorkeur->naam . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12">
        <h4>Adresgegevens</h4>
        <div class="form-group">
            <label for="adres">Thuis adres: </label>
            <select class="custom-select" id="adres" name="adresId" required>
                <?php
                $selectAdressen = '<option value="" selected disabled>Kies een adres of voeg er een toe</option><option id="nieuwAdres" value="nieuwAdres">Nieuw adres</option>';
                foreach ($adressen as $adres) {
                    if ($adres->id == $editGebruiker->adres->id) {
                        $selectAdressen .= '<option selected value="' . $adres->id . '">' . $adres->straat . ' ' . $adres->huisnummer . ' (' . $adres->gemeente . ')</option>';
                    } else {
                        $selectAdressen .= '<option value="' . $adres->id . '">' . $adres->straat . ' ' . $adres->huisnummer . ' (' . $adres->gemeente . ')</option>';
                    }
                }
                echo $selectAdressen;
                ?>
            </select>
            <div class="invalid-feedback">Selecteer een bestaand adres of maak een nieuw aan!</div>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3Fe2FqE9k7EP-u0Q1j5vUoVhtfbWfSjU&libraries=places&callback=initAutocomplete"
        async defer></script>
<script>
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

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