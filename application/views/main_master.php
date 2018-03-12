<!DOCTYPE html>
<html lang="en">
    
    

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Minder Mobiele Centrale</title>

        <!-- Bootstrap Core CSS -->
        <?php echo pasStylesheetAan("bootstrap.min.css"); ?>
        <?php echo pasStylesheetAan("main_style.css"); ?>
        <?php echo pasStylesheetAan("inloggen.css"); ?>
		<?php echo pasStylesheetAan("../fontawesome/css/fontawesome-all.min.css"); ?>

        <?php echo haalJavascriptOp("jquery-3.3.1.min.js"); ?>
        <?php echo haalJavascriptOp("bootstrap.min.js"); ?>

        <script type="text/javascript">
            var site_url = '<?php echo site_url(); ?>';
            var base_url = '<?php echo base_url(); ?>';
        </script>

    </head>

    <body>
        <div class="page-wrap">
            <div>
                <?php echo anchor('home', toonAfbeelding("MMC.png", "height=100px"))?>
            </div>
            <!-- Navigation -->
            <nav class="navbar navbar-expand-lg navbar-dark">
                <?php echo anchor('home', 'Home', 'class="navbar-brand active"') ?>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav mr-auto">

                    </div>

                    <div class="navbar-nav">
                        <?php echo $menu?>
                    </div>
                </div>
             </nav>

            <!-- Page Content -->
            <div class="container">

                <!-- Jumbotron Header
                <header class="jumbotron hero-spacer">
                    <?-php echo $hoofding; ?>
                </header>

                <hr> -->

                <div class="row">
                    <div class="col-lg-12">
                        <h3 id="pageTitle"><?php echo $titel; ?></h3>
                    </div>
                </div>

                <!-- Page Features -->
                <div class="row">
                    <?php echo $inhoud; ?>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </div>
        
        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <span class="mr-auto">
                        <span>Nico C.</span><span>Lorenz C.</span><span>Tijmen E.</span><span>Michiel O.</span><span>Geffrey W.</span>
                    </span>

                    <span>Team 23 Christel Maes</span>
                    
                    <script>
                        $('span').filter(function(){ return $(this).text() === "<?php echo $author; ?>"; }).css('text-decoration','underline');
                    </script>
                </div>
            </div>
        </footer>

    </body>

</html>
