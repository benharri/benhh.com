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

$dbopts = parse_url(getenv('DATABASE_URL'));
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
  'db.options' => array(
    'driver'   => 'pdo_sqlite',
    'path'     => __DIR__.'/app.db',
  ),
));


///////////////////////////////////////////////////////////////////////
// ROUTES
///////////////////////////////////////////////////////////////////////


// index
$app->get('/', function() use($app) {
  return $app['twig']->render('onepage/onepage.twig');
});

// old layout
$app->get('/gallery/', function() use($app) {
  return $app['twig']->render('index.twig');
});

// resume.pdf
$app->get('/resume/', function() use($app) {
  return $app->sendFile(__DIR__.'/../Resume.pdf');
});

// about
$app->get('/about/', function() use($app) {
  return $app['twig']->render('about.twig');
});

// blog (grav)
$app->get('/blog/', function() use($app) {
  return $app['twig']->render('blog/blog.twig');
  return "Coming Soon. Under development.";
});

// portfolio
$app->get('/portfolio/', function() use($app) {
  return "Coming soon. Under Development.";
});

// solitaire
$app->get('/solitaire/', function() use($app) {
  return $app['twig']->render('solitaire.html');
});


// pattern book
$patternbook = $app['controllers_factory'];
$patternbook->get('/', function() use($app) {
  return $app['twig']->render('patternbook/index.twig');
});
$patternbook->get('/{pattern}/', function($pattern) use($app) {
  require "pattern.php";
  return $app['twig']->render('patternbook/pattern.twig', ['pattern' => $pattern_info]);
});
$app->mount('/patternbook/', $patternbook);



// $app->run();
return $app;