<?php

namespace benharri\tests;

use Silex\WebTestCase;

class PatternbookTest extends WebTestCase {
  public function createApplication() {
    $app = require __DIR__.'/../app/app.php';
    $app['debug'] = true;
    unset($app['exception_handler']);

    return $app;
  }

  public function testPatternbookHomepage() {
    $client = $this->createClient();
    $crawler = $client->request('GET', '/patternbook/');

    $this->assertTrue($client->getResponse()->isOk());

  }

}
