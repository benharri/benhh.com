<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path' => __DIR__.'/views',
));

// index
$app->get('/', function() use($app) {
  return $app['twig']->render('index.twig');
});

// serve resume
$app->get('/resume', function() use($app) {
  return $app->sendFile('../resume.pdf');
});

// about
$app->get('/about', function() use($app) {
  return $app['twig']->render('about.twig');
});

// contact
$app->get('/contact', function() use($app) {
  return $app['twig']->render('contact.twig');
});

// solitaire
$app->get('/solitaire', function() use($app) {
  return $app['twig']->render('solitaire.twig');
});

// pattern book
$patternbook = $app['controllers_factory'];

$patternbook->get('/', function() use($app) {
  return $app['twig']->render('patternbook/index.twig');
});

$patternbook->get('/{pattern}', function($pattern) use($app) {
  require "pattern.php";
  return $app['twig']->render('patternbook/pattern.twig', ['pattern' => $pattern_info]);
});

$app->mount('/patternbook', $patternbook);

// hello world
$app->get('/hello/{name}', function($name) use($app) {
  return 'Hello '.$app->escape($name);
});

$app->run();