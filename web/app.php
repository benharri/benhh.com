<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;


///////////////////////////////////////////////////////////////////////
// SERVICE PROVIDERS
///////////////////////////////////////////////////////////////////////

$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path' => __DIR__.'/views',
));

///////////////////////////////////////////////////////////////////////
// ROUTES
///////////////////////////////////////////////////////////////////////

// index
$app->get('/', function() use($app) {
  return $app['twig']->render('index.twig');
})->bind('homepage');

// resume.pdf
$app->get('/resume/', function() use($app) {
  return $app->sendFile(__DIR__.'/static/resume.pdf');
})->bind('resume');

// solitaire
$app->get('/solitaire/', function() use($app) {
  return $app['twig']->render('solitaire.html');
})->bind('solitaire');

$app->mount('/portfolio/', include 'controllers/portfolio.php');

$app->mount('/blog/', include 'controllers/blog.php');

$app->mount('/patternbook/', include 'controllers/patternbook.php');

// $app->run();
return $app;