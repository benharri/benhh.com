<?php

// blog
$blog = $app['controllers_factory'];
$blogposts = require __DIR__."/../blogposts.php";

$blog->get('/', function() use($app) {
  return $app['twig']->render('blog/blog.twig', ['posts' => $blogposts]);
})->bind('blog-home');

return $blog;