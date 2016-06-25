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
  return $app['twig']->render('index.twig');
})->bind('homepage');

// resume.pdf
$app->get('/resume/', function() use($app) {
  return $app->sendFile(__DIR__.'/static/resume.pdf');
})->bind('resume');

// portfolio
$app->get('/portfolio/', function() use($app) {
  return $app['twig']->render('portfolio/portfolio.twig');
})->bind('portfolio');

// solitaire
$app->get('/solitaire/', function() use($app) {
  return $app['twig']->render('solitaire.html');
})->bind('solitaire');

// blog
$blog = $app['controllers_factory'];
$blog->get('/', function() use($app) {
  return $app['twig']->render('blog/blog.twig');
})->bind('blog-home');
$app->mount('/blog/', $blog);

// pattern book
$patternbook = $app['controllers_factory'];
$patternbook->get('/', function() use($app) {
  return $app['twig']->render('patternbook/index.twig');
})->bind('patternbook');
$patternbook->get('/{pattern}/', function($pattern) use($app) {
  require "pattern.php";
  return $app['twig']->render('patternbook/pattern.twig', ['pattern' => $pattern_info]);
})->bind('pattern');
$app->mount('/patternbook/', $patternbook);

// $app->run();
return $app;