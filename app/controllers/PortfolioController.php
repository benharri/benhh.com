<?php

namespace benharri;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class PortfolioController implements ControllerProviderInterface
{
  public function connect(Application $app){
    // portfolio route controller
    $portfolio = $app['controllers_factory'];

    $portfolio->get('/', function() use($app) {
      return $app['twig']->render('portfolio/portfolio.twig');
    })->bind('portfolio');

    return $portfolio;
  }
}