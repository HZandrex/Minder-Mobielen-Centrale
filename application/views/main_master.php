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
        <?php echo pasStylesheetAan("bootstrap.css"); ?>
        <!-- Custom CSS -->
        <?php echo pasStylesheetAan("heroic-features.css"); ?>
        <!-- Buttons CSS -->
        <?php echo pasStylesheetAan("buttons.css"); ?>

        <?php echo haalJavascriptOp("jquery-3.1.0.min.js"); ?>
        <?php echo haalJavascriptOp("bootstrap.js"); ?>

        <script type="text/javascript">
            var site_url = '<?php echo site_url(); ?>';
            var base_url = '<?php echo base_url(); ?>';
        </script>

    </head>

    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo site_url() ?>">Welkom!</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#bootstrap">Bootstrap</a>
                        </li>
                        <li>
                            <a href="#jquery">jQuery</a>
                        </li>
                        <li>
                            <a href="#ajax">Ajax</a>
                        </li>
                        <li>
                            <a href="#json">JSON</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <!-- Page Content -->
        <div class="container">

            <!-- Jumbotron Header -->
            <header class="jumbotron hero-spacer">
                <?php echo $hoofding; ?>
            </header>

            <hr>

            <div class="row">
                <div class="col-lg-12">
                    <h3><?php echo $titel; ?></h3>
                </div>
            </div>

            <!-- Page Features -->
            <?php if (isset($geenRand)) { ?>
                <div class="row text-center">
                    <?php echo $inhoud; ?>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col-lg-12 hero-feature">
                        <div class="thumbnail" style="padding: 20px">
                            <div class="caption">
                                <p>
                                    <?php echo $inhoud; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>        
            <?php } ?>
            <!-- /.row -->

            <hr>

            <!-- Footer -->
            <footer>
                <div class="row">
                    <div class="col-lg-12">
                        <p>Copyright 201x-201x - Thomas More. Alle rechten voorbehouden</p>
                    </div>
                </div>
            </footer>

        </div>
        <!-- /.container -->

    </body>

</html>
