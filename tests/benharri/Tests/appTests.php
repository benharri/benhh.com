<?php

require __DIR__."/../vendor/autoload.php";

namespace benharri\Tests;

use Silex\WebTestCase;

class AppTest extends WebTestCase
{
  public function createApplication() {
    $app = require __DIR__.'/../../../web/app.php';
    $app['debug'] = true;
    unset($app['exception_handler']);
    return $app;
  }

  public function testHomePage() {
    $client = $this->createClient();
    $crawler = $client->request('GET', '/');

    $this->assertTrue($client->getResponse()->isOk());
  }
}