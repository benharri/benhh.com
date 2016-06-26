<?php

// blog
$blog = $app['controllers_factory'];
$blogposts = array("blogs" => "posts");
$blogposts = include __DIR__."/../blogposts.php";

$blog->get('/', function() use($app) {
  return $app['twig']->render('blog/blog.twig', ['posts' => $blogposts]);
})->bind('blog-home');

$blog->get('/{slug}/', function($slug) use($app) {
  return $app['twig']->render('blog/post.twig', ['post' => $blogposts[$slug]]);
});

return $blog;