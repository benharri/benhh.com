<?php
include "../inc/php_scripts/common_fns.php";
$dir = "http://euclid.nmu.edu/~benharri/patternbook";
$menu = array(
  "Creational" => array(
    "Factory" => "$dir/?factory",
    "Double Dispatch" => "$dir/?doubledispatch",
    "Prototype" => "$dir/?prototype",
    "Abstract Factory" => "$dir/?abstractfactory",
    "Lazy Initialization" => "$dir/?lazyinitialization",
    "Builder" => "$dir/?builder",
    "Singleton" => "$dir/?singleton",
    "Null Object" => "$dir/?nullobject"
  ),
  "Behavioral" => array(
    "Command" => "$dir/?command",
    "Observer" => "$dir/?observer",
    "Mediator" => "$dir/?mediator",
    "Visitor" => "$dir/?visitor",
    "Interpreter" => "$dir/?interpreter",
    "Iterator" => "$dir/?iterator",
    "Memento" => "$dir/?memento",
    "Chain of Responsibility" => "$dir/?chainofresponsibility",
    "Template Method" => "$dir/?template",
    "State" => "$dir/?state",
    "Strategy" => "$dir/?strategy"
  ),
  "Structural" => array(
    "Facade" => "$dir/?facade",
    "Composite" => "$dir/?composite",
    "Decorator" => "$dir/?decorator",
    "Future" => "$dir/?future",
    "Bridge" => "$dir/?bridge",
    "Adapter" => "$dir/?adapter",
    "Flyweight" => "$dir/?flyweight",
    "Proxy" => "$dir/?proxy"
  )
);


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pattern Book</title>

    <link rel="stylesheet" href="../inc/css/bootstrap.min.css">
    <link rel="stylesheet" href="../inc/css/theme-cosmo.min.css">
    <link rel="stylesheet" href="../inc/css/sticky-footer-navbar.css">

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?=$dir?>/img/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?=$dir?>/img/apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="<?=$dir?>/img/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?=$dir?>/img/favicon-16x16.png" sizes="16x16" />
    <meta name="application-name" content="Pattern Book - Ben Harris"/>
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="<?=$dir?>/img/mstile-144x144.png" />

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
        <a class="navbar-brand" href="<?=$dir?>"><img src="img/apple-touch-icon-152x152.png" alt="brand"></a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <?=b_menu($menu)?>
        </ul>

        <form class="navbar-form navbar-right" action="<?=$dir?>" method="GET" role="search">
          <div class="input-group">
            <input type="text" name="q" id="searchbox" class="form-control" autocomplete="off" data-provide="typeahead" placeholder="Search">
<!--             <div class="input-group-btn">
              <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
            </div> -->
          </div>
        </form>

      </div><!--/.nav-collapse -->
    </div>
  </nav>

  <div class="container" role="main">
