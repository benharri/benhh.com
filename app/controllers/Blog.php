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
    $dir_iter  = new \DirectoryIterator($dir);
    foreach($dir_iter as $file){
      if($file->isDot()) continue;
      if($file->isDir()){
        $subdir = $dir .'/'. $file->getFilename();
        $subdir_iter = new \DirectoryIterator($subdir);
        foreach($subdir_iter as $subdirfile){
          if(!$subdirfile->isDot()){
            $subdoc = $parser->parse(file_get_contents($subdir.'/'.$subdirfile));
            $blogposts[$file.""][basename($subdirfile, ".md")]            = $subdoc->getYAML();
            $blogposts[$file.""][basename($subdirfile, ".md")]["content"] = $subdoc->getContent();
          }
        }
      } else {
        $doc = $parser->parse(file_get_contents($dir.'/'.$file));
        $blogposts["blog-main"][basename($file, ".md")]            = $doc->getYAML();
        $blogposts["blog-main"][basename($file, ".md")]["content"] = $doc->getContent();
      }
    }

    foreach($blogposts as &$blogdir){
      uasort($blogdir, function ($a, $b) {
        return $a['publish_date'] <=> $b['publish_date'];
      }); // sort blog posts by publish date

      foreach($blogdir as &$post){
        preg_match('~([A-z0-9 ,.]|<.*?>){1,300}(?=\s+)~', $post["content"], $matches, PREG_OFFSET_CAPTURE);
        $post["teaser"] = $matches[0][0] . "...";
      } // trim content for teaser
    }

    // ROUTES
    $blog->get('/', function() use($app, $blogposts) {

      return $app['twig']->render('blog/blog.twig',
        ['posts' => $blogposts]
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
      // return $blogposts[$folder][$slug];
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
