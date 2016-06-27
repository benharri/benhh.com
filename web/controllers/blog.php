<?php

// blog
$blog = $app['controllers_factory'];

$blog->get('/', function() use($app) {
  return $app['twig']->render('blog/blog.twig',
    ['posts' => include __DIR__."/../blogposts.php"]
  );
})->bind('blog-home');

$blog->get('/{slug}/', function($slug) use($app) {
  return $app['twig']->render('blog/post.twig',
    ['post' => (include __DIR__."/../blogposts.php")[$slug]]
  );
});

return $blog;