<?php

// pattern book
$patternbook = $app['controllers_factory'];
$patternbook->get('/', function() use($app) {
  return $app['twig']->render('patternbook/index.twig');
})->bind('patternbook');
$patternbook->get('/{pattern}/', function($pattern) use($app) {
  require "pattern.php";
  return $app['twig']->render('patternbook/pattern.twig', ['pattern' => $pattern_info]);
})->bind('pattern');

return $patternbook;