<?php
require_once 'inc/db.php';
require_once 'login_check.php';

$gd_fn_suffix = array(
        'image/jpeg' => 'JPEG',
        'image/pjpeg'=> 'JPEG',
        'image/gif'  => 'GIF',
        'image/bmp'  => 'WMBP',
        'image/x-png'=> 'PNG',
        'image/png'  => 'PNG'
);

$query = 'select photo, id, filetype, filesize from photos where thumbnail is null';
$query_data = $db->query($query);

while($result = $query_data->fetch_object()){

  $id = $result->id;

  $fn_suffix = $gd_fn_suffix[$result->filetype];
  $fn_read   = 'ImageCreateFrom' . $fn_suffix;
  $fn_write  = 'Image' . $fn_suffix;

  preg_match('/^width=\"?(\d+)\"?\sheight=\"?(\d+)\"?$/', $result->filesize, $matches);

  $width = $matches[1];
  $height= $matches[2];
  $size  = 100;
  $aspect_ratio = $height/$width;

  if ($width <= $size) {
    $new_w = $width;
    $new_h = $height;
  } else {
    $new_w = $size;
    $new_h = abs($new_w * $aspect_ratio);
  }

  ////////////////////////////////////////////////////////////////////
  // Create thumbnail
  ////////////////////////////////////////////////////////////////////
  $src  = imagecreatefromstring($result->photo);
  $dest = '';
  if($src){
    $dest = imagecreatetruecolor($new_w, $new_w);
    imagecopyresized($dest, $src, 0, 0, 0, 0, $new_w, $new_h, $width, $height);
  }

  ob_start();
  $fn_write($dest);
  $tb_data = mysql_real_escape_string(ob_get_contents());
  ob_end_clean();

  ////////////////////////////////////////////////////////////////////

  $query2 = "update photos set thumbnail = '$tb_data' where id = $id";
  $db->query($query2) or die("query2 error");

}

$_SESSION['msg']['success'] = 'thumbnails created successfully';
header("Location: home.php"); die();
