<?php

namespace benharri\tests;

use Silex\WebTestCase;

class YourTest extends WebTestCase {
  public function createApplication() {
    $app = require __DIR__.'/../app/app.php';
    $app['debug'] = true;
    unset($app['exception_handler']);

    return $app;
  }

  public function testHomepage() {
    $client = $this->createClient();
    $crawler = $client->request('GET', '/');

    $this->assertTrue($client->getResponse()->isOk());
    $this->assertCount(1, $crawler->filter('h1:contains("Benjamin Hamilton Harris")'));

  }

}
