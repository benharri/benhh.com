<?php
namespace benharri\controllers;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class Patternbook implements ControllerProviderInterface
{
  public function connect(Application $app){
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
  }
}