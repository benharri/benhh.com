<?php

// blog
$blog = $app['controllers_factory'];
$blogposts = include __DIR__."/../blogposts.php";

$blog->get('/', function() use($app, $blogposts) {
  return $app['twig']->render('blog/blog.twig',
    ['posts' => $blogposts]
  );
})->bind('blog-home');

$blog->get('/{slug}/', function($slug) use($app, $blogposts) {
  if(empty($blogposts[$slug])){
    return $app['twig']->render('blog/blog.twig',
      ['alert' => 'Blog post not found. You may have a typo in your URL.',
      'posts' => $blogposts]
    );
  }
  return $app['twig']->render('blog/post.twig',
    ['post' => $blogposts[$slug]]
  );
});

return $blog;