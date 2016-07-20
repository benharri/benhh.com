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
    $dir    = __DIR__."/../../blogposts";
    $dirit  = new \DirectoryIterator($dir);
    foreach($dirit as $file){
      if(!$file->isDot()){
        $doc = $parser->parse(file_get_contents($dir.'/'.$file));
        $blogposts["blog-main"][basename($file, ".md")]            = $doc->getYAML();
        $blogposts["blog-main"][basename($file, ".md")]["content"] = $doc->getContent();

        if($file->isDir()){
          $subdirit = new \DirectoryIterator($dir .'/'. $file->getFilename());
          foreach($subdirit as $subdirfile){
            if(!$subdirfile->isDot()){
              $subdoc = $parser->parse(file_get_contents($subdir.'/'.$subdirfile));
              $blogposts[$subdirfile->getFilename()][basename($subdirfile, ".md")]            = $subdoc->getYAML();
              $blogposts[$subdirfile->getFilename()][basename($subdirfile, ".md")]["content"] = $subdoc->getContent();
            }
          }
        }
      }
    }

    foreach($blogposts as &$blogdir){
      uasort($blogdir, function ($a, $b) {
        return $b['publish_date'] <=> $a['publish_date'];
      }); // sort blog posts by publish date

      foreach($blogdir as &$post){
        preg_match('~([A-z0-9 ,.]|<.*?>){1,300}(?=\s+)~', $post["content"], $matches, PREG_OFFSET_CAPTURE);
        $post["teaser"] = $matches[0][0] . "...";
      } // trim content for teaser
    }

    // ROUTES
    $blog->get('/', function() use($app, $blogposts) {

      foreach($blogposts as $blogdir){
        foreach($blogdir as $post){
          if($post["published"]) $all_posts[] = $post;
        }
      }

      // echo '<pre>$blogposts Dump ';
      // print_r($all_posts);
      // echo '</pre>';die();
      return $app['twig']->render('blog/blog.twig',
        ['posts' => $all_posts]
      );
    })->bind('blog-home');

    $blog->get('/{slug}/', function($slug) use($app, $blogposts) {
      if(empty($blogposts["blog-main"][$slug])){
        return $app['twig']->render('blog/blog.twig',
          ['alert' => 'Blog post not found. You may have a typo in your URL.',
          'posts' => $blogposts["blog-main"]]
        );
      }

      return $app['twig']->render('blog/post.twig',
        ['post' => $blogposts["blog-main"][$slug]]
      );
    })->bind('blog-post');

    $blog->get('/{folder}/{slug}/', function($folder, $slug) use($app, $blogposts) {
      if(empty($blogposts[$folder][$slug])){
        return $app['twig']->render('blog/blog.twig',
          ['alert' => 'Blog post not found. You may have a typo in your URL.',
          'posts' => $blogposts["blog-main"]]
        );
      }

      return $app['twig']->render('blog/post.twig',
        ['post' => $blogposts[$folder][$slug]]
      );
    });

    return $blog;
  }
}
