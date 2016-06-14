<?php

require_once 'login_check.php';
$v_page_title = "Home";
$jq = array('inc/scripts.js' , 'inc/mootools1_2.js');
require_once 'inc/header.php';
require_once 'inc/db.php';

if(isset($_SESSION["adminmode"]) && $_SESSION["adminmode"] == 1){
  include 'admin.php';
}else{
// Normal (non-administrator)page ?>


  <!-- Upload new photo -->
  <br>
  <fieldset style="width:250px">
    <legend>Upload a photo</legend>
    <form enctype='multipart/form-data' name='frmupload' action='' method='POST'>
      <label for="filename">Pick a file to upload</label>
      <input name='filename' id='filename' type='file'>
      <br><br>
      <label for="caption">Caption</label>
      <input type="text" name="caption" id="caption" >
      <br><br>
      <input type='submit' value='Upload' name='submit'>
    </form>
  </fieldset>

  <hr>


  <?php
  if(isset($_POST['submit'])){

    if(is_uploaded_file($_FILES['filename']['tmp_name'])){

      // $maxsize=$_POST['MAX_FILE_SIZE'];
      $size=$_FILES['filename']['size'];

      // getting the image info..
      $imgdetails = getimagesize($_FILES['filename']['tmp_name']);
      $meta = `exiftool {$_FILES['filename']['tmp_name']}`;

      $mime_type = $imgdetails['mime'];

      $gd_fn_suffix = array(
        'image/jpeg' => 'JPEG',
        'image/pjpeg'=> 'JPEG',
        'image/gif'  => 'GIF',
        'image/bmp'  => 'WMBP',
        'image/x-png'=> 'PNG'
      );



      // checking for valid image type
      if(in_array($mime_type, array_keys($gd_fn_suffix))){
        // checking for size again
        // if($size<$maxsize){

          $filename=$_FILES['filename']['name'];
          $imgData =mysql_real_escape_string (file_get_contents($_FILES['filename']['tmp_name']));

          $query = "INSERT into photos (filename, photo, filetype, filesize, username, description, meta)
                    values ('$filename','$imgData','".$mime_type."','".
                      mysql_real_escape_string(preg_replace('/"/', '', $imgdetails[3]))."', '".
                      $_SESSION['username'] . "', '".mysql_real_escape_string($_REQUEST["caption"]) . "', '".mysql_real_escape_string($meta)."' )";

          $db->query($query) or die(mysql_error());

          include 'thumbnails.php';

        // }else{
        //   echo "<font class='error'>Image to be uploaded is too large..Error uploading the image!!</font>";
        // }
      }else{
        echo "<font class='error'>Not a valid image file! Please upload an image.</font>";
      }

    }else{
      switch($_FILES['filename']['error']){
      case 0: //no error; possible file attack!
        echo "<font class='error'>There was a problem with your upload.</font>";
        break;
      case 1: //uploaded file exceeds the upload_max_filesize directive in php.ini
        echo "<font class='error'>The file you are trying to upload is too big. php.ini</font>";
        break;
      case 2: //uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form
        echo "<font class='error'>The file you are trying to upload is too big.</font>";
        break;
      case 3: //uploaded file was only partially uploaded
        echo "<font class='error'>The file you are trying upload was only partially uploaded.</font>";
        break;
      case 4: //no file was uploaded
        echo "<font class='error'>You must select an image for upload.</font>";
        break;
      default: //a default error, just in case!
        echo "<font class='error'>There was a problem with your upload.</font>";
        break;
      }
    }

  }

  //List Images Part
  $query='SELECT * from photos where username = \''. $_SESSION["username"] . '\'';
  $query_data = $db->query($query) or die(mysql_error);
  $listimage = "<fieldset>
      <legend>My photos</legend>
     ";
  $listimage.= "
  <table cellpadding='1' cellspacing='1'  class='tablecss'>
    <tr class='tablecss'>
      <td class='label'>Preview</td>
      <td nowrap class='label'>File Name</td>
      <td class='label'>Type</td>
      <td class='label'>Size</td>
      <td class='label'>View Count</td>
      <td class='label'>Description</td>
      <td style='colwidth:100px' class='label'>Metadata</td>
      <td class='label'>Delete</td>
    </tr>";
  $imageexist=false;
  while($result = $query_data->fetch_object()){
    $imageexist=true;
    $listimage.= "
    <tr class='whiterow'>
      <td><a href='img.php?id=$result->id'><img src='img.php?id=$result->id&thumbnail=YES'></a></td>
      <td><a href='img.php?id=$result->id'>".$result->filename."</a></td>
      <td>".str_replace('image/','',$result->filetype)."</td>
      <td nowrap>".$result->filesize."</td>
      <td nowrap>$result->viewcount</td>
      <td nowrap>$result->description</td>
      <td>$result->meta</td>
      <td nowrap><a href='action.php?do=delete_photo&id=$result->id&username={$_SESSION["username"]}'>delete</a></td>
    </tr>";
  }

  $listimage.= "
  </table>
  </fieldset>";

  if($imageexist){
    echo $listimage;
  }else{
    echo 'You have not uploaded any photos yet.';
  }

  echo "<div id='imageframe'></div>";

}
include 'inc/footer.php';
