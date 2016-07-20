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
  return $app['twig']->render('index.twig', ["scrollnav" => true]);
})->bind('homepage');

// resume.pdf
$app->get('/resume/', function() use($app) {
  return $app->sendFile(__DIR__.'/../web/resume.pdf');
})->bind('resume');

// solitaire
$app->get('/solitaire/', function() use($app) {
  return $app['twig']->render('solitaire.html');
});

// app/controllers
$app->mount('/portfolio/', new benharri\controllers\Portfolio());
$app->mount('/blog/', new benharri\controllers\Blog());
$app->mount('/patternbook/', new benharri\controllers\Patternbook());

return $app;
