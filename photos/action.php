<?php
require 'inc/db.php';

//delete photo
if($_REQUEST['do'] == 'delete_photo'){

    if($_SESSION["username"] != $_GET['username']){
      $_SESSION["msg"]["error"] = "You do not have sufficient privileges to access that page.";
      header("Location: home.php"); die();
    }

    $id = mysql_real_escape_string($_REQUEST['id']);
    $query = 'delete from photos where id= \''.$id.'\'';
    $db->query($query);
    $_SESSION["msg"]["success"] = "Photo deleted successfully";
    header("Location: home.php");die();

}
//delete user
elseif($_REQUEST['do'] == 'delete_user'){


    if($_SESSION["username"] != 'admin'){
      $_SESSION["msg"]["error"] = "You do not have sufficient privileges to access that page.";
      header("Location: home.php"); die();
    }

    $username = mysql_real_escape_string($_REQUEST['username']);
    if($username == 'admin'){
      die("cannot delete admin user <br /><a href=home.php>return</a>");
    }
    $query = 'delete from users where username = \''. $username .'\'';
    $db->query($query);
    $query2= 'delete from photos where username = \''. $username.'\'';
    $db->query($query2);
    $_SESSION["msg"]["success"] = "User account deleted successfully.";
    header("Location: home.php"); die();

}
//reset failcount

elseif($_REQUEST['do'] == 'reset_failcount'){

    if($_SESSION["username"] != 'admin'){
      $_SESSION["msg"]["error"] = "You do not have sufficient privileges to access that page.";
      header("Location: home.php"); die();
    }

    $username = mysql_real_escape_string($_REQUEST['username']);
    $query = "update users set failcount = 0 where username = '$username'";
    $db->query($query);

    $_SESSION["msg"]["success"] = "Failcount reset successfully.";
    header("Location: home.php"); die();

}

elseif($_REQUEST['do'] == 'register'){

    $username = mysql_real_escape_string($_POST["username"]);
    $password_prehash = $_POST['password'];
    $password = md5($_POST["password"]);
    $password_reenter = md5($_POST["password-reenter"]);

    if($password != $password_reenter){
      // passwords do not match
      $_SESSION["msg"]["error"] = "Passwords do not match. Try again.";
      header("Location: signup.php"); die();
    }
    if(!preg_match('/^[a-zA-Z]\w{3,14}$/', $password_prehash)){
      // weak password
      $_SESSION["msg"]["error"] = "Password did not meet requirements. First letter must be a letter. Must be between 4 and 15 characters long, using no characters other than letters, numbers, and underscore (_)";
      header("Location: signup.php"); die();
    }

    $query = "select * from users where username = '" . $username ."'";
    $result = $db->query($query);

    if($result->num_rows > 0){
      // user already exists
      $_SESSION["msg"]["error"] = "This user already exists. Please log in.";
      header("Location: login.php"); die();
    }

    // passwords match and user does not already exist. create new user.

    $query = "insert into users (username, password) values ('" . $username . "', '" . $password . "')";
    $db->query($query);
    // user created. log user in now.
    $_SESSION["msg"]["success"] = "User created successfully. Log in again.";
    header("Location: home.php"); die();



}

elseif($_REQUEST['do'] == 'logout'){
  $session = $_COOKIE["PHPSESSID"];

  $query = $_GET["logoutall"] == "yes" ? "update users set session=null" : "update users set session = null where session = '" . $session . "'";
  $db->query($query);

  unset($_SESSION['logged-in']);
  unset($_SESSION['username']);

  $_SESSION["msg"]["success"] = "Successfully logged out";
  header("Location: login.php"); die();
}

else{
  $_SESSION["msg"]["error"] = "Error.";
  header("Location: home.php"); die();
}