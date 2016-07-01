<?php

namespace benharri\tests;

use Silex\WebTestCase;

class PortfolioTest extends WebTestCase {
  public function createApplication() {
    $app = require __DIR__.'/../app/app.php';
    $app['debug'] = true;
    unset($app['exception_handler']);

    return $app;
  }

  public function testPortfolioHomepage() {
    $client = $this->createClient();
    $crawler = $client->request('GET', '/portfolio/');

    $this->assertTrue($client->getResponse()->isOk());

  }

}
