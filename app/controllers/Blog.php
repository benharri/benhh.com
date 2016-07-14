<?php
namespace benharri\controllers;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;
// blog
class Blog implements ControllerProviderInterface
{

  public function connect(Application $app){

    $blog = $app['controllers_factory'];

    $parser = new \Mni\FrontYAML\Parser();
    $dir    = __DIR__."/../blogposts";
    $dirit  = new \DirectoryIterator($dir);
    foreach($dirit as $file){
      if(!$file->isDot()){
        $doc = $parser->parse(file_get_contents($dir.'/'.$file));
        $blogposts[basename($file, ".md")]            = $doc->getYAML();
        $blogposts[basename($file, ".md")]["content"] = $doc->getContent();
      }
    }

    usort($blogposts, function ($a, $b) {
      return $b['publish_date'] <=> $a['publish_date'];
    }); // sort blog posts by publish date

    foreach($blogposts as &$post){
      preg_match('~([A-z0-9 ,.]|<.*?>){1,300}(?=\s+)~', $post["content"], $matches, PREG_OFFSET_CAPTURE);
      $post["teaser"] = $matches[0][0] . "...";
    }

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
    })->bind('blog-post');

    return $blog;
  }
}
