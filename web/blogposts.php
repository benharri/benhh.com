<?php
require __DIR__."/../vendor/autoload.php";

$parser = new Mni\FrontYAML\Parser();
$dir    = __DIR__."/blogposts";
$dirit  = new DirectoryIterator($dir);
foreach($dirit as $file){
  if(!$file->isDot()){
    $doc = $parser->parse(file_get_contents($dir.'/'.$file));
    $posts[basename($file, ".md")]            = $doc->getYAML();
    $posts[basename($file, ".md")]["content"] = $doc->getContent();
  }
}

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

foreach($posts as &$post){
  $post["teaser"] = tease($post["content"], 3);
}

return $posts;


