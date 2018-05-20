<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Philosophers website">
    <meta name="author" content="Stefanie Seker">

    <title>Philosophers</title>

    <?php echo stylesheet('bootstrap.css'); ?>
    <?php echo stylesheet('style.css'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <?php echo javascript("bootstrap.js"); ?>

    <script type="text/javascript">
        var site_url = '<?php echo site_url(); ?>';
        var base_url = '<?php echo base_url(); ?>';
    </script>

</head>

<body>


    <div>
        <?php echo $menu; ?>
    </div>

    <!-- Page Content -->
    <div class="container">
        
        <div class="row">
            <div class="col-lg-12">
                <h3><?php echo $title; ?></h3>
            </div>
        </div>
        
        <!-- Page Features -->
        <?php //if (isset($nobox)) { ?>
            <div class="row text-center">
                <?php //echo $content; ?>
            </div>
        <?php //} else { ?>
            <div class="row">
                <div class="col-lg-12 hero-feature">
                    <div class="thumbnail" style="padding: 20px">
                        <div class="caption">
                            <p>
                                <?php echo $content; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>        
        <?php //} ?>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>&copy;Stefanie Seker</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

</body>

</html>
