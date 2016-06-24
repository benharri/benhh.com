<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

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

// index
$app->get('/', function() use($app) {
  return $app['twig']->render('onepage/onepage.twig');
  return $app->redirect($app['url_generator']->generate('onepage'));
  return $app['twig']->render('index.twig');
});

$app->get('/old', function() use($app) {
  return $app['twig']->render('index.twig');
});

// $app->get('/test', function() use($app) {
//   return $app['twig']->render('onepage/onepage.twig');
// });
// $app->get('/one', function() use($app) {
//   return $app['twig']->render('onepage/onepage.twig');
// })
// ->bind('onepage');

// serve resume
$app->get('/resume', function() use($app) {
  return $app->sendFile(__DIR__.'/../Resume.pdf');
});

// about
$app->get('/about', function() use($app) {
  return $app['twig']->render('about.twig');
});

// contact
$app->get('/contact', function() use($app) {
  return $app['twig']->render('contact.twig');
});

// portfolio
$app->get('/portfolio', function() use($app) {
  return "portfolio";
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

$todolist = $app['controllers_factory'];
$todolist->get('/', function() use($app) {
  return $app['twig']->render('tasks/tasks.twig');
});
$todolist->get('/{user}', function($user) use($app) {
  return $app['twig']->render('tasks/userlist.twig', ['user' => $user]);
});
$app->mount('/tasks', $todolist);

$app->run();