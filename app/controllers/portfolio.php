<?php

// portfolio route controller
$portfolio = $app['controllers_factory'];

$portfolio->get('/', function() use($app) {
  return $app['twig']->render('portfolio/portfolio.twig');
})->bind('portfolio');


return $portfolio;