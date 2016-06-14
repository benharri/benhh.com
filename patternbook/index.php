<?php
if(isset($_GET["q"])){
  $pattern = strtolower(str_replace(" ", "", $_GET["q"])); include "pattern.php"; die();
}
if(isset($_GET["notfound"])){
  $pattern = $_GET["notfound"];
  $msg = '<div class="alert alert-warning">Unable to find "'.$pattern.'".</div>';
}
if(count($_GET) == 1){ $pattern = array_keys($_GET)[0]; include "pattern.php"; die();}

include_once "header.php";

?>
<br>
<?php if(isset($msg)){
  echo $msg;
}?>

<div class="jumbotron">

  <div class="page-header">
    <h1>Software Engineering Patterns</h1>
  </div>

</div>

<div class="page-header">
  <h3>Ben Harris' Pattern Book</h3>
</div>

<p>This is collection of experiences I have noticed in my experiences with software development so far.</p>
<p>Patterns are:</p>
<ul>
  <li>element of grammar</li>
  <li>in programming languages: production</li>
  <li>describe and think about our designs using patterns</li>
</ul>

<p>Anatomy of a pattern:</p>
<ul>
    <li>name</li>
    <li>common issue to be solved</li>
    <li>(re)solution</li>
    <li>examples (if applicable)</li>
    <li>related patterns</li>
</ul>

<div class="page-header"><h2><strong>Allow, don't force.</strong></h2></div>

<?php include_once "footer.php";
