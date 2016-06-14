<?php
include 'inc/db.php';
include 'login_check.php';


$id = mysql_real_escape_string($_GET['id']);
$query = "select * from photos where id = '$id'";
$query_data = $db->query($query);

$query2 = "update photos set viewcount = viewcount + 1 where id='$id'";
$db->query($query2);

while($result = $query_data->fetch_object()){
  header("Content-type:".$result->filetype);
  header('Content-Disposition: inline; filename="'.$result->filename.'"');
  $photo = isset($_REQUEST['thumbnail']) ? $result->thumbnail : $result->photo;
  echo $photo;
}