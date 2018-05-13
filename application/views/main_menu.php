<?php
    /**
     * @file main_menu.php
     * 
     * View waarin de inhoud van de navbar wordt opgemaakt
     * - aan de hand van de functie van de ingelogde gebruiker worden er andere functies getoont
     */
?>

<?php
echo '<div class="navbar-nav mr-auto">';
echo divAnchor('home', 'Home', 'class="nav-item nav-link"');

if ($gebruiker == null) { // niet aangemeld
    echo '</div>';
    echo '<div class="navbar-nav">';
    echo divAnchor('gebruiker/inloggen', 'Inloggen', 'class="nav-item nav-link"');
    echo '</div>';
} else { // wel aangemeld
    foreach ($gebruiker->functies as $functie) {
        switch ($functie->naam) {
            case 'Minder mobiele':
                    echo divAnchor('mm/ritten','Mijn ritten','class="nav-item nav-link"');
                    break;
				
            case 'Coach':
                echo divAnchor('coach/ritten','Overzicht ritten','class="nav-item nav-link"');
				echo divAnchor('coach/mijnMM/mijnMMLijst','MM beheren','class="nav-item nav-link"');
                break;
				
            case 'Vrijwilliger':
                echo divAnchor('vrijwilliger/ritten','Mijn ritten','class="nav-item nav-link"');
                break;
				
            case 'Medewerker' || 'Admin':
                echo divAnchor('medewerker/rittenAfhandelen','Ritten afhandelen','class="nav-item nav-link"');
                echo divAnchor('medewerker/gebruikersBeheren','Gebruikers beheren','class="nav-item nav-link"');
                if ($functie->naam == 'Admin'){
                    echo divAnchor('admin/webinfo', 'Webinfo wijzigen', 'class="nav-item nav-link"');
                    echo divAnchor('admin/instellingen', 'Instellingen', 'class="nav-item nav-link"');
                }
                break;
        }
    }
    echo '</div>';
    ?>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $gebruiker->voornaam . ' ' . $gebruiker->naam; ?>
            </a>
        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <li><?php echo divAnchor('gebruiker/persoonlijkeGegevens/persoonlijkeGegevens', 'Mijn gegevens', 'class="nav-link"'); ?></li>
            <li><?php echo divAnchor('gebruiker/help', 'Help', 'class="nav-link"'); ?></li>
            <li><?php echo divAnchor('gebruiker/inloggen/loguit', 'Uitloggen', 'class="nav-link"'); ?></li>
        </ul>
      </li>
    </ul>
  </div>
<div id="handleidingDialog"></div>
<?php } ?>
<!-- Dialoogvenster -->
<div class="modal fade" id="mijnDialoogscherm" role="dialog">
    <div class="modal-dialog">

        <!-- Inhoud dialoogvenster-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Handleiding</h4>
            </div>
            <div class="modal-body">
                <p><div id="resultaat"></div></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Sluit</button>
            </div>
        </div>

    </div>
</div>

<script>
    $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
      if (!$(this).next().hasClass('show')) {
        $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
      }
      var $subMenu = $(this).next(".dropdown-menu");
      $subMenu.toggleClass('show');


      $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
        $('.dropdown-submenu .show').removeClass("show");
      });


      return false;
    });
 
    function toonHandleiding()
    {
        $.ajax({type: "GET",
                url : site_url + "/gebruiker/persoonlijkeGegevens/toonHandleiding",
                success: function(result){
                    $("#resultaat").html(result);
                    $('#mijnDialoogscherm').modal('show');
                },
                error: function (xhr, status, eroor) {
                    alert("-- ERROR IN AJAX -- \n\n" + xhr.responseText)
                }
            });
    }

    $(document).ready(function () {

        $("#handleiding").click(function (e) {
            e.preventDefault();
            toonHandleiding();
        });

    });
</script>