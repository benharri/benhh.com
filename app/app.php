<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
// $app['debug'] = true;

///////////////////////////////////////////////////////////////////////
// SERVICE PROVIDERS
///////////////////////////////////////////////////////////////////////

$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path' => __DIR__.'/views',
));

///////////////////////////////////////////////////////////////////////
// ROUTES
///////////////////////////////////////////////////////////////////////
$app->get('/', function() use($app) {
      return $app['twig']->render('patternbook/index.twig');
    })->bind('patternbook');

$app->get('/{pattern}/', function($pattern) use($app) {
  require "pattern.php";
  return $app['twig']->render('patternbook/pattern.twig', ['pattern' => $pattern_info]);
})->bind('pattern');



return $app;
