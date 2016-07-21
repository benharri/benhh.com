<?php
namespace benharri\controllers;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

// blog
class Blog implements ControllerProviderInterface
{

  public function connect(Application $app){

    $blog = $app['controllers_factory'];



    // ROUTES
    $blog->get('/', function() use($app) {

      $parser = new \Mni\FrontYAML\Parser();
      $dir    = __DIR__."/../../blogposts";
      $dir_iter  = new \DirectoryIterator($dir);
      foreach($dir_iter as $file){
        if($file->isDot()) continue;
        if($file->isDir()){
          $subdir = $dir .'/'. $file->getFilename();
          $subdir_iter = new \DirectoryIterator($subdir);
          foreach($subdir_iter as $subdirfile){
            if(!$subdirfile->isDot()){
              $subdoc = $parser->parse(file_get_contents($subdir.'/'.$subdirfile));
              if($subdoc->getYAML()["published"]){
                $blogposts[$file.""][basename($subdirfile, ".md")]            = $subdoc->getYAML();
                $blogposts[$file.""][basename($subdirfile, ".md")]["content"] = $subdoc->getContent();
              }
            }
          }
        } else {
          $doc = $parser->parse(file_get_contents($dir.'/'.$file));
          if($doc->getYAML()["published"]){
            $blogposts["blog-main"][basename($file, ".md")]            = $doc->getYAML();
            $blogposts["blog-main"][basename($file, ".md")]["content"] = $doc->getContent();
          }
        }
      }

      foreach($blogposts as &$blogdir){
        foreach($blogdir as $postname => &$post){
          preg_match('~([A-z0-9 ,.]|<.*?>){1,300}(?=\s+)~', $post["content"], $matches, PREG_OFFSET_CAPTURE);
          $post["teaser"] = $matches[0][0] . "...";
          $allposts[$postname] = $post;
        } // trim content for teaser
      }

      uasort($allposts, function ($a, $b) {
        return $b['publish_date'] <=> $a['publish_date'];
      }); // sort blog posts by publish date


      return $app['twig']->render('blog/blog.twig',
        ['posts' => $allposts]
      );
    })->bind('blog-home');

    $blog->get('/search/', function(Request $request) use($app) {
      return $request->get('q');
    })->bind('blog-search');

    $blog->get('/{slug}/', function($slug) use($app) {
      $parser    = new \Mni\FrontYAML\Parser();
      $dir       = __DIR__."/../../blogposts";
      $post_file = $dir . "/" . $slug . ".md";
      if(file_exists($post_file)){
        $doc             = $parser->parse(file_get_contents($post_file));
        $post            = $doc->getYAML();
        $post["content"] = $doc->getContent();
        preg_match('~([A-z0-9 ,.]|<.*?>){1,300}(?=\s+)~', $post["content"], $matches, PREG_OFFSET_CAPTURE);
        $post["teaser"] = $matches[0][0] . "...";

        return $app['twig']->render('blog/post.twig',
          ['post' => $post]
        );
      } else {
        return $app['twig']->render('blog/blog.twig',
          ['alert' => 'Blog post not found. You may have a typo in your URL. <a href="/blog">Return to blog</a>']
        );
      }
    })->bind('blog-post');

    $blog->get('/{folder}/{slug}/', function($folder, $slug) use($app) {
      $parser    = new \Mni\FrontYAML\Parser();
      $dir       = __DIR__."/../../blogposts";
      $post_file = $dir . "/" . $folder . "/" . $slug . ".md";
      if(file_exists($post_file)){
        $doc             = $parser->parse(file_get_contents($post_file));
        $post            = $doc->getYAML();
        $post["content"] = $doc->getContent();
        preg_match('~([A-z0-9 ,.]|<.*?>){1,300}(?=\s+)~', $post["content"], $matches, PREG_OFFSET_CAPTURE);
        $post["teaser"] = $matches[0][0] . "...";

        return $app['twig']->render('blog/post.twig',
          ['post' => $post]
        );
      } else {
        return $app['twig']->render('blog/blog.twig',
          ['alert' => 'Blog post not found. You may have a typo in your URL. <a href="/blog">Return to blog</a>']
        );
      }
    });

    return $blog;
  }
}
