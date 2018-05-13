<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        /**
         * @mainpage Commentaar bij Project23_1718
         * 
         * # Wat?
         * Je vindt hier onze Docygen-commentaar bij het PHP-project <b>Project23_1718</b>.
         * - De commentaar bij onze model- en controller-klassen vind je onder het menu <em>Klassen</em>
         * - De commentaar bij onze view-bestanden vind je onder het menu <em>Bestanden</em>
         * - Ook de originele commentaar geschreven bij het Codeigniter-framwork is opgenomen.
         * 
         * # Wie?
         * Dit project is geschreven en becommentarieerd door Nico Claes, Lorenz Cleymans, Tijmen Elseviers, Michiel Olijslagers & Geffrey Wuyts.
         */
        ?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16" />

        <title>Minder Mobiele Centrale</title>

        <!-- Bootstrap Core CSS -->
		<?php echo pasStylesheetAan("main.css"); ?>
        <?php echo pasStylesheetAan("../fontawesome/css/fontawesome-all.min.css"); ?>

        <?php echo haalJavascriptOp("jquery-3.3.1.min.js"); ?>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<?php echo haalJavascriptOp("popper.min.js"); ?>
		<?php echo haalJavascriptOp("bootstrap-datepicker.js"); ?>
        <?php echo haalJavascriptOp("bootstrap.min.js"); ?>
        <?php echo haalJavascriptOp("validator.js"); ?>
        <script type="text/javascript">
            var site_url = '<?php echo site_url(); ?>';
            var base_url = '<?php echo base_url(); ?>';
        </script>

    </head>

    <body>
        <!-- navbar -->
        <header>
            <nav class="navbar navbar-expand-md navbar-dark fixed-top">
                <?php echo anchor('home', toonAfbeelding("MMC_white.png", "height=50px"), 'class="navbar-brand"') ?>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse" id="navbarCollapse">
                    <?php echo $menu ?>
                </div>
            </nav>
        </header>

        <!-- Content -->
        <div class="container">
            <!-- pagina titel -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 id="pageTitle"><?php echo $titel; ?></h1>
                </div>
            </div>
            <!-- pagina inhoud -->
            <?php echo $inhoud; ?>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row footText">
                    <span>N. Claes</span>
                    <span>, </span>
                    <span class="footerNaam">L. Cleymans</span>
                    <span>, </span>
                    <span class="footerNaam">T. Elseviers</span>
                    <span>, </span>
                    <span class="footerNaam">M. Olijslagers</span>
                    <span>, </span>
                    <span class="mr-auto">G. Wuyts</span>

                    <span id="footerTeam">Team 23 Christel Maes</span>

                    <script>
                        $('span').filter(function () {
                            return $(this).text() === "<?php echo $author; ?>";
                        }).css('text-decoration', 'underline');
                    </script>
                </div>
            </div>
        </footer>

    </body>

</html>
