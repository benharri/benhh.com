<?php
require __DIR__."/../vendor/autoload.php";

function tease($body, $sentencesToDisplay = 2) {
  $nakedBody = preg_replace('/\s+/', ' ', strip_tags($body));
  $sentences = preg_split('/(\.|\?|\!)(\s)/', $nakedBody);
  if (count($sentences) <= $sentencesToDisplay)
    return $nakedBody;
  $stopAt = 0;
  foreach ($sentences as $i => $sentence) {
    $stopAt += strlen($sentence);
    if ($i >= $sentencesToDisplay - 1) break;
  }
  $stopAt += ($sentencesToDisplay * 2);
  return trim(substr($nakedBody, 0, $stopAt));
}

$parser = new Mni\FrontYAML\Parser();
$dir    = __DIR__."/views/blog/posts";
$dirit  = new DirectoryIterator($dir);
foreach($dirit as $file){
  if(!$file->isDot()){
    $doc = $parser->parse(file_get_contents($dir.'/'.$file));
    $docs[basename($file, ".md")]            = $doc->getYAML();
    $docs[basename($file, ".md")]["content"] = $doc->getContent();
  }
}

$posts = array(
  "first-post" => array(
    "title"        => "My first post",
    "author"       => "Ben Harris",
    "slug"         => "first-post",
    "content"      => "This is my first post Lorem ipsum dolor sit amet, consectetur adipisicing elit. Totam, illo, excepturi? Voluptatem dolore dicta, voluptate fugiat, molestiae similique, nulla dignissimos recusandae natus quia hic doloremque fugit consequatur sunt cumque mollitia.",
    "tags"         => array("Hello", "World"),
    "publish_date" => date("D, M jS Y"),
  ),
  "second-post" => array(
    "title"        => "My second post",
    "author"       => "Ben Harris",
    "slug"         => "second-post",
    "content"      => "This is my second post. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione voluptatem similique iure praesentium cumque cupiditate numquam alias. Earum adipisci aspernatur assumenda cumque omnis unde delectus fugiat sit ex, aliquam aut!",
    "tags"         => array("Gello", "Jello"),
    "publish_date" => date("D, M jS Y"),
  )
);

foreach($posts as &$post){
  $post["teaser"] = tease($post["content"], 3);
}

return $docs;


