<?php

require "inc/db.php";

// if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] == 'http://euclid.nmu.edu/~benharri/loginproj/login.php'){
if(isset($_POST["username"]) && isset($_POST["password"])){
// Logging in for the first time


  $username = mysql_real_escape_string($_POST["username"]);
  $password = md5($_POST["password"]);

  $ip = $_SERVER['REMOTE_ADDR'];
  $session = $_COOKIE["PHPSESSID"];


  $query = "select * from users where username = '" . $username . "'";

  $result = $db->query($query);

  if($result->num_rows > 0){
    // user found
    $row = $result->fetch_object();

    if($row->password == $password && $row->failcount < 4){
      // password correct. proceed to log-in
      echo 'password correct. logging in.';
      $query2 = "update users set failcount = 0, ip = '" . $ip . "', session = '" . $session . "' where username = '" . $username . "'";

      $db->query($query2);

      header("Location: home.php"); die();
    }
    elseif($row->failcount >=4){
      echo 'You have tried too many times.';
      $_SESSION["msg"]["error"] = "You have tried an incorrect password too many times. Please contact the administrator.";
      header("Location: login.php"); die();
    }
    else {
      echo 'incorrect password';
      $query2 = "update users set failcount = failcount + 1, ip = '" . $ip . "' where username = '" . $username . "'";
      $db->query($query2);

      $_SESSION["msg"]["error"] = "The password you entered was incorrect.";
      header("Location: login.php"); die();
    }


  }

  else {
    // no user found
    echo 'user not found';

    $_SESSION["msg"]["error"] = "User not found. Please register or check the spelling.";
    header("Location: login.php"); die();
  }

}

elseif((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == 1)  && isset($_SESSION['username'])){

  $_SESSION['msg']['logged-in'] = "logged in as " . $_SESSION['username'] ." <a class=\"align-right\" href=\"action.php?do=logout\">Log out</a>";

}

else{
// checking for existing session

  $session = $_COOKIE["PHPSESSID"];
  $query = "select * from users where session = '" . $session . "'";

  $result = $db->query($query);

  if($result->num_rows == 1){
    // already logged in, continue to content.
    $row = $result->fetch_object();
    $_SESSION['username'] = $row->username;
    $_SESSION['adminmode'] = $row->username == 'admin' ? 1 : 0;
    $_SESSION['msg']['logged-in'] = "logged in as " . $row->username ." <a class=\"align-right\" href=\"action.php?do=logout\">Log out</a>";
    $_SESSION['logged-in'] = 1;

  }
  elseif ($result->num_rows > 1){
    // more than one user logged in?
    header("Location: logout.php?logoutall=yes"); die();
  }
  else{
    $_SESSION["msg"]["error"] = "Not logged in. Please log in again.";
    header("Location: login.php"); die();
  }
}
