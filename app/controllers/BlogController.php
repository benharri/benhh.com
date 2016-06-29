<?php
namespace benharri;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;
// blog
class BlogController implements ControllerProviderInterface
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

    foreach($blogposts as &$post){
      $post["teaser"] = substr($post["content"], 0, 200). "...";
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
    });

    return $blog;
  }
}
