<?php
include "inc/php_scripts/common_fns.php";
$dir = "http://euclid.nmu.edu/~benharri/";

$menu = array(
  "About" => $dir . "about/",
  "Contact" => $dir . "contact/",
  "CS326" => array(
    "Pattern Book" => $dir . "patternbook/"),
  "CS465" => array(
    "Ajax Demo (Airport Lookup)" => $dir . "ajax/",
    "Nations Game" => $dir . "nations/",
    "Party Planner" => $dir . "partyplanner/",
    "Photo Manager" => $dir . "photos/",
    "Spellchecker demo" => $dir . "spellchecker.php",
    "Python Poll App" => "http://euclid.nmu.edu:9999/polls",
  ),
  "Fun" => array(
    "Winning Solitaire" => $dir . "soli/",
    "Kickball" => $dir . "kick/",
    "Harris Woodworks" => $dir . "harriswoodworks/",
    "Harris Woodworks Blog Version" => "http://harriswood.works/",
  ),
);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ben Harris</title>

    <link rel="stylesheet" href="<?=$dir?>inc/css/bootstrap.min.css">
    <link href="<?=$dir?>inc/css/theme-yeti.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=$dir?>inc/css/sticky-footer-navbar.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?=$dir?>">Home</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <?=b_menu($menu)?>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>
