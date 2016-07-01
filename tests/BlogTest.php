<?php

namespace benharri\tests;

use Silex\WebTestCase;

class BlogTest extends WebTestCase {
  public function createApplication() {
    $app = require __DIR__.'/../app/app.php';
    $app['debug'] = true;
    unset($app['exception_handler']);

    return $app;
  }

  public function testBlogHome() {
    $client = $this->createClient();
    $crawler = $client->request('GET', '/blog/');

    $this->assertTrue($client->getResponse()->isOk());
    $this->assertCount(1, $crawler->filter('small:contains("Ben Harris")'));

    // tests to write...
    //# test the markdown parser
    //# test that only posts marked published are displayed
    //# test the paging stuff
    //# test that the markdown teaser stuff doesn't screw up the layout of the rest of the page

  }

  public function testBlogPosts() {
    $client = $this->createClient();
    //foreach post in app/blogposts....
    $crawler = $client->request('GET', '/blog/welcome/'/* .$post */);

    $this->assertTrue($client->getResponse()->isOk());

    //# test the markup
    //# make sure we get the right stuff

  }

}
