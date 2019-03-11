<?php
    // Honeypot
    if (isset($_POST['sooperthemes_url']) && $_POST['sooperthemes_url']) {
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
        exit;
    }

    $base_path = '/srv/users/serverpilot/apps/trysooperthemes-com/public/';

    // redirect to demo
    if (isset($_POST['sooperthemes_submit']) && isset($_POST['email']) && $_POST['email']) {
        $email = htmlspecialchars($_POST['email']);

        // add email to list
        $file = fopen($base_path . 'trysooperthemeslist','a+');
        $fmail = $email . PHP_EOL;
        fwrite($file,$fmail);
        fclose($file);
        print_r(error_get_last());

        if (in_array($_POST['demo'], ['glazed_main_theme_settings', 'glazed_main_demo'])) {
            $demo = $_POST['demo'];
        }

        // update sites_available and sites_active lists
        $sites_available = file_get_contents($base_path . '.sites_available/' . $demo);
        $arr = explode(PHP_EOL, $sites_available);
        if (isset($arr[0]))  {
            $site = $arr[0];
            unset ($arr[0]);
            $sites_active = fopen($base_path . '.sites_active/' . $demo,'a+');
            $fsite = $site.PHP_EOL;
            fwrite($sites_active, $fsite);
            fclose($sites_active);
            print_r(error_get_last());
            // set marker in site to let build scripts know its activated
            file_put_contents($base_path . $demo . '/' . $site . '/sites/default/files/active', '');

        }
        $string = implode(PHP_EOL, $arr);
        file_put_contents($base_path . '.sites_available/' . $demo, $string);

        // redirect user to demo
        header("Location: $demo/$site", TRUE,302);
    }
    else {
        $email = '';
    }
?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <link rel="icon" href="favicon.ico" type="image/x-icon" />

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/animatecss/3.5.1/animate.min.css">
        <!-- <link rel="stylesheet" href="http://glazed-demo.sooperthemes.com/profiles/cms/themes/glazed/css/glazed.css"> -->
        <link rel="stylesheet" href="css/main.css">

        <!--[if lt IE 9]>
            <script src="js/vendor/html5-3.6-respond-1.4.2.min.js"></script>
        <![endif]-->
    </head>
    <body>


    <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="container">
        <div class="row">
          <div class="col-sm-6 col-sm-offset-3 formbox jumbotron">
            <div class="row">
              <div class="col-sm-4 col-sm-offset-4">
                <a href="http://www.sooperthemes.com/"><img src="img/sooperthemes.svg"></a>
              </div>
            </div>
            <div class="wrap-form clearfix">
              <form class="navbar-form navbar-left" role="form">
                <h2>Start 24 Hour Admin Demo!</h2>
                <h4>100% Free and no account registration needed!</h4>
                <br>
                <div class="form-item">
                    <input type="radio" id="glazed_main_theme_settings" name="demo" value="glazed_main_theme_settings" checked>
                    <label for="glazed_main_theme_settings">Drupal 7 Main Demo</label>
                </div>
                <div class="form-item">
                    <input type="radio" id="glazed_main_demo" name="demo" value="glazed_main_demo">
                    <label for="glazed_main_demo">Drupal 8 Main Demo</label>
                </div>
                <noscript><p>This demo requires Javascript, please enable Javascrpit in your browser!</p></noscript>
                <br />
                  <input type="text" placeholder="Email" class="form-control" name="email" value="<?php print $email; ?>">
                <input type="submit" class="btn btn-success" name="sooperthemes_submit" value="Start Glazed Demo">
                <input type="text" placeholder="url" class="form-control" name="sooperthemes_url" value="">
                <br>
                <small class="text-muted">If you enter your email we will send you a link to your admin demo and 2 followup emails, nothing more! The followup emails are to ask your feedback.

                <br><br>
                <a href="https://www.sooperthemes.com">← Back to SooperThemes.com</a>
                <p></p>
              </form>
            </div>
          </div>
        </div>
      </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>

    <script src="//cdn.jsdelivr.net/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
        $( document ).ready(function() {
            // Hopefully this will keep out most robots
            $('form').attr({
              action: "index.php",
              method: "post"
            });
            $('input[name="sooperthemes_url"]').css('opacity', 0.01);
        });
    </script>

    <script src="js/main.js"></script>

    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
        (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
        ga('create','UA-XXXXX-X','auto');ga('send','pageview');
    </script>
    </body>
</html>