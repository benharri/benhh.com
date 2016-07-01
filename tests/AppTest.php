<?php

namespace benharri\tests;

use Silex\WebTestCase;

class YourTest extends WebTestCase
{
  public function createApplication()
  {
    $app = require __DIR__.'/../app/app.php';
    $app['debug'] = true;
    unset($app['exception_handler']);

    return $app;
  }

  public function testFooBar()
  {
    $this->assertTrue(true);
  }
}